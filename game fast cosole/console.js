// ╔══════════════════════════════════════════════════════════════╗
// ║   第56屆全國技能競賽 - 遊戲快速通關工具 v4.0              ║
// ║   適用架構：index.php (AJAX SPA) + iframe 內嵌遊戲         ║
// ║   使用方式：在 index.php 頁面的 F12 → Console 貼上執行     ║
// ╚══════════════════════════════════════════════════════════════╝
// 修正紀錄 v4.0：
//   ① 遊戲辨識：改用 .current-game-title（AJAX內容）取代 document.title
//   ② 所有 DOM 操作：改用 iframe.contentDocument / iframe.contentWindow
//   ③ Game1 confirm() ：在 iWin 層級攔截（Game2 無 confirm 直接呼叫）
//   ④ 反應力測試：以 arena.className + busy flag 精確控制每回合
//   ⑤ 打地鼠：改用 holes[].up JS 物件追蹤（非純 DOM class）、
//             結果取自 #final-score（非 #score-val）
//   ⑥ 滑動拼圖：A* Min-Heap 最優解；等待 running=true 後再讀棋盤
//   ⑦ fireClick：以 iWin 作為 MouseEvent.view，確保事件正確路由
//   ⑧ 等待 iframe ready：避免 contentDocument 為 null 的時序問題

(function () {
  'use strict';

  /* ── 清除重複執行的殘留面板 ── */
  document.getElementById('__gac__')?.remove();
  document.getElementById('__gac_css__')?.remove();

  /* ══════════════════════════════════════
     1. 遊戲辨識
     .current-game-title 由 game-play.php AJAX 注入
  ══════════════════════════════════════ */
  const DEFS = {
    '數字挑戰':   { key: 'g1', hasConfirm: true,  canLose: true  },
    '記憶挑戰':   { key: 'g2', hasConfirm: false, canLose: true  },
    '反應力測試': { key: 'g3', hasConfirm: false, canLose: true  },
    '打地鼠':     { key: 'g4', hasConfirm: false, canLose: false },
    '滑動拼圖':   { key: 'g5', hasConfirm: false, canLose: false },
  };
  const EMOJI = { g1:'🔢', g2:'🧠', g3:'⚡', g4:'🐭', g5:'🧩' };
  const GRAD  = { g1:'linear-gradient(135deg,#a18cd1,#fbc2eb)',
                  g2:'linear-gradient(135deg,#667eea,#764ba2)',
                  g3:'linear-gradient(135deg,#f093fb,#f5576c)',
                  g4:'linear-gradient(135deg,#43e97b,#38f9d7)',
                  g5:'linear-gradient(135deg,#4facfe,#00f2fe)' };

  const titleEl  = document.querySelector('.current-game-title');
  const rawTitle = titleEl?.textContent?.trim() ?? '';
  let gameName = null, def = null;
  for (const [name, d] of Object.entries(DEFS)) {
    if (rawTitle.includes(name)) { gameName = name; def = d; break; }
  }

  if (!def) {
    const names = Object.keys(DEFS).join('、');
    alert(`❌ 找不到遊戲！\n\n偵測到的標題：「${rawTitle || '（空）'}」\n\n請先點「遊戲」→「開始遊戲」，\n確認遊戲頁面完整載入後再執行此腳本。\n\n支援遊戲：${names}`);
    return;
  }

  /* ══════════════════════════════════════
     2. 取得 iframe 與其 context
     遊戲全部跑在 <iframe class="game-frame"> 裡
  ══════════════════════════════════════ */
  const iframe = document.querySelector('iframe.game-frame');
  if (!iframe) {
    alert('❌ 找不到 .game-frame iframe！\n請確認遊戲頁面已完整載入。');
    return;
  }

  /* iframe context helper（每次呼叫確保最新） */
  function ctx() {
    return {
      d: iframe.contentDocument || iframe.contentWindow.document,
      w: iframe.contentWindow,
    };
  }

  /* 等待 iframe 載入完成 */
  function iframeReady() {
    const { d } = ctx();
    if (d && d.readyState === 'complete') return Promise.resolve();
    return new Promise(res => {
      iframe.addEventListener('load', res, { once: true });
      setTimeout(res, 6000); // 最多等 6 秒
    });
  }

  /* ── 通用工具 ── */
  const sleep    = ms  => new Promise(r => setTimeout(r, ms));
  const rnd      = (a, b) => a + Math.random() * (b - a);
  const rndSleep = (a, b) => sleep(rnd(a, b));

  /* 模擬完整點擊序列（view 必須為 iWin） */
  function fireClick(el) {
    const { w } = ctx();
    ['pointerdown','mousedown','pointerup','mouseup','click'].forEach(t =>
      el.dispatchEvent(new MouseEvent(t, { bubbles: true, cancelable: true, view: w }))
    );
  }

  /* ══════════════════════════════════════
     3. 面板 UI（附加到主頁面的 body）
  ══════════════════════════════════════ */
  const css = document.createElement('style');
  css.id = '__gac_css__';
  css.textContent = `
    #__gac__{position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);
      width:400px;z-index:2147483647;border-radius:20px;overflow:hidden;
      font-family:'Segoe UI',Arial,sans-serif;user-select:none;
      box-shadow:0 20px 60px rgba(0,0,0,.6),0 0 0 1px rgba(255,255,255,.1);
      animation:_gac_in .3s cubic-bezier(.22,1,.36,1) both}
    @keyframes _gac_in{from{opacity:0;transform:translate(-50%,-58%) scale(.92)}
      to{opacity:1;transform:translate(-50%,-50%) scale(1)}}
    #__gac__ .gh{background:linear-gradient(135deg,#0f0c29 0%,#302b63 60%,#1a0030 100%);
      padding:16px 20px;display:flex;align-items:center;justify-content:space-between;cursor:grab}
    #__gac__ .gh:active{cursor:grabbing}
    #__gac__ .gh-l{display:flex;align-items:center;gap:12px;pointer-events:none}
    #__gac__ .gico{font-size:26px;animation:_gac_bob 2s ease-in-out infinite}
    @keyframes _gac_bob{0%,100%{transform:translateY(0)}50%{transform:translateY(-5px)}}
    #__gac__ .gtit{color:#fff;font-size:17px;font-weight:800;letter-spacing:.5px}
    #__gac__ .gsub{color:rgba(255,255,255,.5);font-size:10px;margin-top:2px}
    #__gac__ .gbadge{display:inline-block;background:linear-gradient(135deg,#f7971e,#ffd200);
      color:#111;font-size:9px;font-weight:800;padding:2px 7px;border-radius:99px;margin-top:3px}
    #__gac__ .gcls{background:rgba(255,255,255,.1);border:none;color:#fff;
      width:28px;height:28px;border-radius:50%;cursor:pointer;font-size:15px;
      display:flex;align-items:center;justify-content:center;transition:all .2s;
      flex-shrink:0;pointer-events:all}
    #__gac__ .gcls:hover{background:rgba(255,255,255,.25);transform:rotate(90deg)}
    #__gac__ .gb{background:#fff;padding:22px}
    #__gac__ .gcard{border-radius:14px;padding:14px 18px;margin-bottom:18px;
      display:flex;align-items:center;gap:14px}
    #__gac__ .gce{font-size:34px}
    #__gac__ .gct{font-size:10px;font-weight:700;color:rgba(255,255,255,.8);
      text-transform:uppercase;letter-spacing:1px}
    #__gac__ .gcn{font-size:20px;font-weight:900;color:#fff;
      text-shadow:0 2px 6px rgba(0,0,0,.2)}
    #__gac__ .glbl{font-size:11px;font-weight:700;color:#8899bb;
      text-transform:uppercase;letter-spacing:.8px;margin-bottom:10px}
    #__gac__ .gbtns{display:grid;gap:9px;margin-bottom:16px}
    #__gac__ .gbtn{border:none;border-radius:12px;padding:14px 18px;
      font-size:14px;font-weight:800;cursor:pointer;color:#fff;
      display:flex;align-items:center;gap:12px;transition:transform .2s,box-shadow .2s}
    #__gac__ .gbtn:hover{transform:translateY(-2px)}
    #__gac__ .gbtn:disabled{opacity:.35;cursor:not-allowed;transform:none!important}
    #__gac__ .gbtn-w{background:linear-gradient(135deg,#11998e,#38ef7d);
      box-shadow:0 5px 18px rgba(17,153,142,.4)}
    #__gac__ .gbtn-l{background:linear-gradient(135deg,#c94b4b,#4b134f);
      box-shadow:0 5px 18px rgba(180,50,50,.35)}
    #__gac__ .gbtn-a{background:linear-gradient(135deg,#4facfe,#00f2fe);
      box-shadow:0 5px 18px rgba(79,172,254,.4)}
    #__gac__ .gbtn-ico{font-size:20px;flex-shrink:0}
    #__gac__ .gbtn-txt strong{display:block;font-size:14px}
    #__gac__ .gbtn-txt span{display:block;font-size:11px;opacity:.82;font-weight:500;margin-top:1px}
    #__gac__ .gst{border-radius:11px;padding:13px 15px;
      background:#f0f4ff;border:2px solid #e0e8ff;transition:all .3s}
    #__gac__ .gst.run{border-color:#4facfe;background:#eef7ff}
    #__gac__ .gst.ok {border-color:#38ef7d;background:#eefff5}
    #__gac__ .gst.err{border-color:#f87171;background:#fff1f1}
    #__gac__ .gst-lbl{font-size:10px;font-weight:700;color:#9aadcc;
      text-transform:uppercase;letter-spacing:.8px;margin-bottom:5px}
    #__gac__ .gst-txt{font-size:13px;font-weight:700;color:#334;line-height:1.5;min-height:18px}
    #__gac__ .gst.run .gst-txt{color:#1a7bd4;animation:_gac_pulse 1.2s ease-in-out infinite}
    #__gac__ .gst.ok  .gst-txt{color:#0e7a45}
    #__gac__ .gst.err .gst-txt{color:#c0392b}
    @keyframes _gac_pulse{0%,100%{opacity:1}50%{opacity:.45}}
    #__gac__ .gpw{margin-top:9px;display:none;height:6px;border-radius:99px;
      background:#dde6ff;overflow:hidden}
    #__gac__ .gpw.show{display:block}
    #__gac__ .gpb{height:100%;border-radius:99px;width:0%;transition:width .35s ease;
      background:linear-gradient(90deg,#4facfe,#00f2fe)}
    #__gac__ .gpb.ok{background:linear-gradient(90deg,#11998e,#38ef7d)}
  `;
  document.head.appendChild(css);

  /* 按鈕 HTML */
  const winBtn = `<button class="gbtn gbtn-w" id="__gac_win">
    <span class="gbtn-ico">🏆</span>
    <span class="gbtn-txt"><strong>通關模式（贏）</strong><span>自動完成 · 模擬真人操控</span></span>
  </button>`;
  const loseBtn = `<button class="gbtn gbtn-l" id="__gac_lose">
    <span class="gbtn-ico">💀</span>
    <span class="gbtn-txt"><strong>失敗模式（輸）</strong><span>自動輸掉 · 模擬真人操控</span></span>
  </button>`;
  const autoBtn = `<button class="gbtn gbtn-a" id="__gac_win">
    <span class="gbtn-ico">🤖</span>
    <span class="gbtn-txt"><strong>自動模式</strong><span>全自動完成 · 模擬真人操控</span></span>
  </button>`;

  const panel = document.createElement('div');
  panel.id = '__gac__';
  panel.innerHTML = `
    <div class="gh" id="__gac_drag">
      <div class="gh-l">
        <span class="gico">${EMOJI[def.key]}</span>
        <div>
          <div class="gtit">快速通關工具</div>
          <div class="gsub">第56屆全國技能競賽 · 北區訓練</div>
          <span class="gbadge">v4.0 · iframe 架構</span>
        </div>
      </div>
      <button class="gcls" id="__gac_x">✕</button>
    </div>
    <div class="gb">
      <div class="gcard" style="background:${GRAD[def.key]}">
        <span class="gce">${EMOJI[def.key]}</span>
        <div>
          <div class="gct">已辨識遊戲</div>
          <div class="gcn">${gameName}</div>
        </div>
      </div>
      <div class="glbl">選擇執行模式</div>
      <div class="gbtns">${def.canLose ? winBtn + loseBtn : autoBtn}</div>
      <div class="gst" id="__gac_st">
        <div class="gst-lbl">執行狀態</div>
        <div class="gst-txt" id="__gac_msg">等待選擇模式...</div>
        <div class="gpw" id="__gac_pw"><div class="gpb" id="__gac_pb"></div></div>
      </div>
    </div>`;
  document.body.appendChild(panel);

  /* ── UI helpers ── */
  const $st  = () => document.getElementById('__gac_st');
  const $msg = () => document.getElementById('__gac_msg');
  const $pw  = () => document.getElementById('__gac_pw');
  const $pb  = () => document.getElementById('__gac_pb');

  function setStatus(msg, type = '') {
    const s = $st(), m = $msg();
    if (!s || !m) return;
    m.textContent = msg;
    s.className = 'gst ' + type;
  }
  function setProgress(pct, done = false) {
    const pw = $pw(), pb = $pb();
    if (!pw || !pb) return;
    pw.classList.add('show');
    pb.style.width = Math.min(100, pct) + '%';
    pb.className = 'gpb' + (done ? ' ok' : '');
  }
  function hideProgress() { $pw()?.classList.remove('show'); }
  function lockBtns(v)    { panel.querySelectorAll('.gbtn').forEach(b => b.disabled = v); }

  /* ══════════════════════════════════════
     4. 遊戲邏輯
  ══════════════════════════════════════ */

  /* ────────────────────────────────────
     G1 數字挑戰 / G2 記憶挑戰
     差異：G1 有 confirm()，G2 直接呼叫 sendResultToParent
     DOM：#numbers > .number（textContent = 數字值）
     邏輯：div.onclick 觸發 checkOrder()
           checkOrder 每次點擊後立即比對升序
  ─────────────────────────────────────*/
  async function runNumber(win) {
    await iframeReady();
    const { d: iDoc, w: iWin } = ctx();

    /* G1 需要攔截 confirm；G2 不需要但攔截無害 */
    const origConfirm = iWin.confirm;
    iWin.confirm = () => false;   // 選「否/取消」→ 觸發 sendResultToParent

    try {
      setStatus('讀取數字方塊...', 'run');
      setProgress(10);
      await rndSleep(500, 900);

      /* 讀取並排序 DOM 元素（依值升序） */
      const blocks = [...iDoc.querySelectorAll('#numbers .number')]
        .map(el => ({ el, val: parseInt(el.textContent.trim(), 10) }));

      if (!blocks.length) {
        setStatus('⚠️ 找不到 .number 元素，請確認 iframe 已載入', 'err');
        return;
      }

      if (win) {
        /* 贏：升序點擊 */
        const sorted = [...blocks].sort((a, b) => a.val - b.val);
        setStatus(`升序點擊：${sorted.map(n => n.val).join(' → ')}`, 'run');
        setProgress(20);

        for (let i = 0; i < sorted.length; i++) {
          await rndSleep(380, 820);
          setProgress(20 + (i + 1) / sorted.length * 72);
          setStatus(`點擊第 ${i + 1} 個：${sorted[i].val}`, 'run');
          fireClick(sorted[i].el);
          /* 若已出現結果文字（G2 直接結束）就停止 */
          if (iDoc.getElementById('result')?.textContent) break;
        }

        await rndSleep(200, 400);
        setProgress(100, true);
        setStatus('✅ 挑戰成功！', 'ok');

      } else {
        /* 輸：點最大再點最小 → 第二次點擊必觸發 checkOrder 失敗 */
        const sorted = [...blocks].sort((a, b) => a.val - b.val);
        setStatus(`故意點錯順序：${sorted[sorted.length-1].val} → ${sorted[0].val}`, 'run');
        setProgress(30);
        await rndSleep(400, 700);

        fireClick(sorted[sorted.length - 1].el);  // 最大
        await rndSleep(280, 520);
        fireClick(sorted[0].el);                   // 最小 → 必失敗

        await rndSleep(300, 500);
        setProgress(100);
        setStatus('❌ 挑戰失敗！', 'err');
      }
    } finally {
      /* 無論成功或例外，都還原 confirm */
      iWin.confirm = origConfirm;
    }
  }

  /* ────────────────────────────────────
     G3 反應力測試
     arena.className 狀態機：
       waiting → 待機（start 前/回合間）
       ready   → 等待變綠（state='waiting' in game）
       go      → 變綠！立即點擊（state='go'）
       toosoon → 太早點了（state='idle'）
       done    → 全部回合完成
     觀察 className 的 MutationObserver 驅動
  ─────────────────────────────────────*/
  async function runReaction(win) {
    await iframeReady();
    const { d: iDoc } = ctx();

    setStatus('啟動反應力測試...', 'run');
    setProgress(5);

    /* 點擊開始按鈕 */
    const btnStart = iDoc.getElementById('btn-start');
    if (btnStart && !btnStart.disabled) {
      fireClick(btnStart);
      await rndSleep(800, 1200);
    }

    const arena = iDoc.getElementById('arena');
    if (!arena) { setStatus('⚠️ 找不到 #arena 元素', 'err'); return; }

    const ROUNDS = 5;
    let doneRounds = 0;
    let busy = false;          // 防止同一狀態重複觸發

    setStatus('等待回合開始...', 'run');

    await new Promise(resolve => {
      const obs = new MutationObserver(async () => {
        if (busy) return;
        const cls = arena.className;

        /* ── 贏：等 class=go → 模擬真實反應時間點擊 ── */
        if (win && cls === 'go') {
          busy = true;
          doneRounds++;
          const ms = Math.round(rnd(145, 310));
          setStatus(`第 ${doneRounds}/${ROUNDS} 回合 — 反應 ${ms} ms`, 'run');
          setProgress(doneRounds / ROUNDS * 88);
          await sleep(ms);
          /* 確認還在 go 狀態才點擊（防止計時器搶先改狀態） */
          if (arena.className === 'go') fireClick(arena);
          await sleep(200);
          busy = false;
        }

        /* ── 輸：等 class=ready（state='waiting'）→ 故意太早點 ── */
        if (!win && cls === 'ready') {
          busy = true;
          doneRounds++;
          setStatus(`第 ${doneRounds}/${ROUNDS} 回合 — 故意太早點擊`, 'run');
          setProgress(doneRounds / ROUNDS * 88);
          await rndSleep(260, 580);   // 1500ms 以內一定還是 ready
          if (arena.className === 'ready') fireClick(arena);
          await sleep(200);
          busy = false;
        }

        /* ── 全部完成 ── */
        if (cls === 'done') {
          obs.disconnect();
          setProgress(100, win);
          setStatus(win ? '✅ 測試完成！' : '❌ 所有回合失敗！', win ? 'ok' : 'err');
          resolve();
        }
      });
      obs.observe(arena, { attributes: true, attributeFilter: ['class'] });
    });
  }

  /* ────────────────────────────────────
     G4 打地鼠
     關鍵：
       holes[idx].up (JS 變數)  → DOM 上的 .mole.up class
       mole.onclick 設置於 showMole()
       #overlay.show → 遊戲結束
       #final-score  → 最終分數（非 #score-val）
  ─────────────────────────────────────*/
  async function runMole() {
    await iframeReady();
    const { d: iDoc } = ctx();

    setStatus('準備打地鼠...', 'run');
    setProgress(5);

    const btnStart = iDoc.getElementById('btn-start');
    if (btnStart && !btnStart.disabled) {
      fireClick(btnStart);
      await rndSleep(400, 700);
    }

    setStatus('🔨 全力打地鼠中...', 'run');
    const GAME_SECS = 30;
    let ticks = 0;
    const TOTAL_TICKS = GAME_SECS * 1000 / 60;

    await new Promise(resolve => {
      const iv = setInterval(() => {
        ticks++;
        setProgress(Math.min(99, ticks / TOTAL_TICKS * 100));

        /* 找所有浮出的地鼠：class="mole up"（非 whacked） */
        iDoc.querySelectorAll('.mole.up:not(.whacked)').forEach(async mole => {
          if (mole._gac) return;        // 避免重複點擊
          mole._gac = true;
          await sleep(rnd(65, 195));    // 模擬人眼+手的反應延遲
          /* 點擊前再確認還是 up 狀態 */
          if (mole.classList.contains('up') && !mole.classList.contains('whacked')) {
            fireClick(mole);
          }
          await sleep(60);
          mole._gac = false;
        });

        /* 偵測結束 overlay */
        const overlay = iDoc.getElementById('overlay');
        if (overlay?.classList.contains('show')) {
          clearInterval(iv);
          /* 最終分數在 #final-score（endGame() 中設置） */
          const score = iDoc.getElementById('final-score')?.textContent ?? '?';
          setProgress(100, true);
          setStatus(`✅ 遊戲結束！最終得分：${score} 分`, 'ok');
          resolve();
        }
      }, 60);

      /* 安全逾時（35秒） */
      setTimeout(() => { clearInterval(iv); resolve(); }, 35000);
    });
  }

  /* ────────────────────────────────────
     G5 滑動拼圖 — A* 最優解
     棋盤從 DOM 讀取：#puzzle .tile
       data-n   = 數字（1-8）
       無 data-n = 空格（值 0）
     tile 在 DOM 中的順序 = board 陣列的 index
     moveTile(idx) 需要 running=true
     render() 每次移動後重建 DOM → 每步都重新 query
  ─────────────────────────────────────*/

  /* Manhattan distance heuristic */
  function heur(state) {
    // GOAL[i] = i+1（0-7位置），position 8 = 0（空格）
    let d = 0;
    for (let i = 0; i < 9; i++) {
      const v = state[i];
      if (!v) continue;
      const gi = v - 1;  // 目標位置：1→0, 2→1, ..., 8→7
      d += Math.abs(~~(i/3) - ~~(gi/3)) + Math.abs(i%3 - gi%3);
    }
    return d;
  }

  /* 取得空格的可移動鄰居 */
  function neighbors(state) {
    const e = state.indexOf(0), r = ~~(e/3), c = e%3, ns = [];
    if (r > 0) ns.push(e - 3);
    if (r < 2) ns.push(e + 3);
    if (c > 0) ns.push(e - 1);
    if (c < 2) ns.push(e + 1);
    return ns;
  }

  /* 最小堆（A* 用） */
  class Heap {
    constructor() { this._h = []; }
    push(item, p)  { this._h.push({item, p}); this._up(this._h.length-1); }
    pop()          { const t=this._h[0].item, l=this._h.pop();
                     if (this._h.length) { this._h[0]=l; this._dn(0); } return t; }
    _up(i)  { while(i>0){const p=~~((i-1)/2); if(this._h[p].p<=this._h[i].p)break;
                [this._h[p],this._h[i]]=[this._h[i],this._h[p]]; i=p;} }
    _dn(i)  { const n=this._h.length; for(;;){let s=i,l=2*i+1,r=2*i+2;
                if(l<n&&this._h[l].p<this._h[s].p)s=l;
                if(r<n&&this._h[r].p<this._h[s].p)s=r;
                if(s===i)break; [this._h[s],this._h[i]]=[this._h[i],this._h[s]]; i=s;} }
    get size() { return this._h.length; }
  }

  /* A* 求解：回傳 board-position 序列（每步要點的格子） */
  function astar(start) {
    const GOAL = '1,2,3,4,5,6,7,8,0';
    const sk   = start.join(',');
    if (sk === GOAL) return [];

    const heap = new Heap();
    const gS   = new Map([[sk, 0]]);
    const cf   = new Map();   // child key → parent key
    const mf   = new Map();   // child key → move (board pos clicked)

    heap.push({ state: start, key: sk }, heur(start));

    while (heap.size > 0) {
      const { state, key } = heap.pop();
      if (key === GOAL) {
        const path = []; let cur = key;
        while (mf.has(cur)) { path.unshift(mf.get(cur)); cur = cf.get(cur); }
        return path;
      }
      const g = gS.get(key);
      for (const ni of neighbors(state)) {
        const ns = [...state], e = ns.indexOf(0);
        [ns[e], ns[ni]] = [ns[ni], ns[e]];
        const nk = ns.join(','), ng = g + 1;
        if (ng < (gS.get(nk) ?? Infinity)) {
          gS.set(nk, ng); cf.set(nk, key); mf.set(nk, ni);
          heap.push({ state: ns, key: nk }, ng + heur(ns));
        }
      }
    }
    return null;  // 無解（shuffle 保證有解，理論上不會發生）
  }

  async function runPuzzle() {
    await iframeReady();
    const { d: iDoc } = ctx();

    setStatus('打亂拼圖中...', 'run');
    setProgress(5);

    /* 點擊「開始/重新打亂」→ startGame() → running=true */
    const btnStart = iDoc.getElementById('btn-start');
    if (btnStart) {
      fireClick(btnStart);
      await rndSleep(400, 600);   // 等待 shuffle() + render() 完成
    }

    /* 讀取棋盤狀態（tiles 在 DOM 中的順序 = board index） */
    setStatus('讀取棋盤...', 'run');
    setProgress(15);
    await sleep(200);

    const readBoard = () =>
      [...iDoc.querySelectorAll('#puzzle .tile')]
        .map(t => t.dataset.n ? parseInt(t.dataset.n, 10) : 0);

    const board = readBoard();
    if (board.length !== 9) {
      setStatus('⚠️ 讀取棋盤失敗，請確認拼圖已啟動', 'err'); return;
    }

    setStatus('A* 計算最優路徑...', 'run');
    setProgress(25);
    await sleep(30);  // 讓 UI 先更新再做運算

    const moves = astar(board);

    if (!moves || moves.length === 0) {
      setProgress(100, true);
      setStatus('✅ 拼圖已完成！', 'ok'); return;
    }

    setStatus(`找到 ${moves.length} 步最優解，開始執行...`, 'run');
    setProgress(30);
    await rndSleep(350, 600);

    for (let i = 0; i < moves.length; i++) {
      const ni = moves[i];
      setProgress(30 + (i + 1) / moves.length * 65);
      setStatus(`步驟 ${i + 1} / ${moves.length}`, 'run');

      /* render() 每次重建 DOM，每步重新 query */
      const tiles = iDoc.querySelectorAll('#puzzle .tile');
      if (tiles[ni]) {
        await rndSleep(230, 460);
        fireClick(tiles[ni]);
      }

      /* 提前偵測完成 overlay */
      if (iDoc.getElementById('overlay')?.classList.contains('show')) break;
    }

    await rndSleep(300, 500);
    setProgress(100, true);
    setStatus('✅ 拼圖完成！', 'ok');
  }

  /* ══════════════════════════════════════
     5. 事件分派
  ══════════════════════════════════════ */
  async function run(win) {
    lockBtns(true);
    hideProgress();
    setStatus('啟動中...', 'run');
    try {
      if      (def.key === 'g1' || def.key === 'g2') await runNumber(win);
      else if (def.key === 'g3')                      await runReaction(win);
      else if (def.key === 'g4')                      await runMole();
      else if (def.key === 'g5')                      await runPuzzle();
    } catch (e) {
      setStatus('❌ 錯誤：' + e.message, 'err');
      console.error('[GAC v4]', e);
    }
    await sleep(1800);
    lockBtns(false);
  }

  document.getElementById('__gac_win')?.addEventListener('click',  () => run(true));
  document.getElementById('__gac_lose')?.addEventListener('click', () => run(false));
  document.getElementById('__gac_x').addEventListener('click', () => {
    panel.remove(); css.remove();
  });

  /* ── 拖曳 ── */
  (function () {
    const drag = document.getElementById('__gac_drag');
    let ox = 0, oy = 0, on = false;
    drag.addEventListener('mousedown', e => {
      if (e.target.id === '__gac_x') return;
      on = true;
      const r = panel.getBoundingClientRect();
      ox = e.clientX - r.left; oy = e.clientY - r.top;
      e.preventDefault();
    });
    document.addEventListener('mousemove', e => {
      if (!on) return;
      panel.style.left = (e.clientX - ox) + 'px';
      panel.style.top  = (e.clientY - oy) + 'px';
      panel.style.transform = 'none';
    });
    document.addEventListener('mouseup', () => { on = false; });
  })();

  /* ── Console 訊息 ── */
  console.log(
    '%c🎮 GAC v4.0 已啟動%c  ' + gameName,
    'color:#fff;background:linear-gradient(135deg,#0f0c29,#302b63);padding:5px 14px;border-radius:8px;font-weight:800;font-size:13px',
    'color:#4facfe;font-size:13px;font-weight:700;padding-left:6px'
  );
  console.log(
    '%c架構說明%c 主頁面(SPA) → AJAX → game-play.php → iframe.game-frame → 遊戲',
    'color:#f6e05e;font-weight:700', 'color:#a0aec0'
  );

})();