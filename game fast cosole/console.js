// ╔══════════════════════════════════════════════════════════╗
// ║   第56屆全國技能競賽 - 遊戲快速通關工具 v2.0           ║
// ║   使用方式：貼到遊戲頁面的 Console 中按 Enter           ║
// ╚══════════════════════════════════════════════════════════╝

(function () {
  'use strict';

  /* ── 防止重複執行 ── */
  const OLD = document.getElementById('__gac_panel__');
  if (OLD) OLD.remove();

  /* ── 遊戲辨識 ── */
  const GAME_DEFS = {
    '數字挑戰':  { key: 'number',   canLose: true  },
    '記憶挑戰':  { key: 'memory',   canLose: true  },
    '反應力測試':{ key: 'reaction', canLose: true  },
    '打地鼠':    { key: 'mole',     canLose: false },
    '滑動拼圖':  { key: 'puzzle',   canLose: false },
  };

  let gameName = null, gameDef = null;
  const pageTitle = document.title || '';
  for (const [name, def] of Object.entries(GAME_DEFS)) {
    if (pageTitle.includes(name)) { gameName = name; gameDef = def; break; }
  }

  if (!gameDef) {
    alert('❌ 找不到遊戲！\n請確認在以下頁面執行：\n' + Object.keys(GAME_DEFS).join('、'));
    return;
  }

  /* ── 工具函式 ── */
  const sleep    = ms => new Promise(r => setTimeout(r, ms));
  const rnd      = (a, b) => a + Math.random() * (b - a);
  const rndSleep = (a, b) => sleep(rnd(a, b));

  function fireClick(el) {
    ['pointerdown','mousedown','pointerup','mouseup','click'].forEach(type =>
      el.dispatchEvent(new MouseEvent(type, { bubbles: true, cancelable: true, view: window }))
    );
  }

  /* ── 樣式 ── */
  const CSS = `
    #__gac_panel__ {
      position: fixed; top: 50%; left: 50%;
      transform: translate(-50%,-50%);
      width: 400px; z-index: 2147483647;
      font-family: 'Segoe UI', Arial, sans-serif;
      border-radius: 22px;
      box-shadow: 0 24px 80px rgba(0,0,0,.55), 0 0 0 1px rgba(255,255,255,.12);
      overflow: hidden;
      animation: gacIn .35s cubic-bezier(.22,1,.36,1);
      user-select: none;
    }
    @keyframes gacIn {
      from { opacity:0; transform:translate(-50%,-58%) scale(.92); }
      to   { opacity:1; transform:translate(-50%,-50%) scale(1); }
    }

    /* ── header ── */
    .gac-head {
      background: linear-gradient(135deg,#3a1c71,#d76d77,#ffaf7b);
      padding: 18px 22px;
      display: flex; align-items: center; justify-content: space-between;
    }
    .gac-head-left { display:flex; align-items:center; gap:12px; }
    .gac-icon { font-size:28px; animation:gacBob 2s ease-in-out infinite; }
    @keyframes gacBob { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-5px)} }
    .gac-title { color:#fff; font-size:18px; font-weight:800; letter-spacing:.5px;
                 text-shadow:0 2px 8px rgba(0,0,0,.3); }
    .gac-subtitle { color:rgba(255,255,255,.75); font-size:11px; margin-top:2px; }
    .gac-close {
      background:rgba(255,255,255,.15); border:none; color:#fff;
      width:30px; height:30px; border-radius:50%; cursor:pointer;
      font-size:16px; display:flex; align-items:center; justify-content:center;
      transition:all .2s;
    }
    .gac-close:hover { background:rgba(255,255,255,.3); transform:rotate(90deg); }

    /* ── body ── */
    .gac-body { background:#fff; padding:24px; }

    /* 遊戲卡片 */
    .gac-game-card {
      border-radius:14px; padding:16px 18px; margin-bottom:20px;
      background: linear-gradient(135deg,#a18cd1,#fbc2eb);
      display:flex; align-items:center; gap:14px;
    }
    .gac-game-emoji { font-size:36px; }
    .gac-game-info {}
    .gac-game-tag { font-size:11px; font-weight:700; color:rgba(255,255,255,.8);
                   text-transform:uppercase; letter-spacing:1px; }
    .gac-game-name { font-size:20px; font-weight:900; color:#fff;
                    text-shadow:0 2px 6px rgba(0,0,0,.2); }

    /* 模式按鈕區 */
    .gac-section-label {
      font-size:12px; font-weight:700; color:#8899bb;
      text-transform:uppercase; letter-spacing:.8px;
      margin-bottom:10px;
    }
    .gac-btns { display:grid; gap:10px; margin-bottom:18px; }

    .gac-btn {
      border:none; border-radius:13px; padding:15px 20px;
      font-size:15px; font-weight:800; cursor:pointer; color:#fff;
      position:relative; overflow:hidden;
      transition:transform .2s, box-shadow .2s;
      letter-spacing:.3px;
      display:flex; align-items:center; justify-content:center; gap:10px;
    }
    .gac-btn:hover { transform:translateY(-2px); }
    .gac-btn:active { transform:translateY(1px); }
    .gac-btn:disabled { opacity:.4; cursor:not-allowed; transform:none; }
    .gac-btn::after {
      content:''; position:absolute; inset:0;
      background:rgba(255,255,255,0);
      transition:background .2s;
    }
    .gac-btn:hover::after { background:rgba(255,255,255,.08); }

    .gac-btn-win {
      background:linear-gradient(135deg,#11998e,#38ef7d);
      box-shadow:0 6px 20px rgba(17,153,142,.4);
    }
    .gac-btn-lose {
      background:linear-gradient(135deg,#f7971e,#ffd200);
      box-shadow:0 6px 20px rgba(247,151,30,.35);
    }
    .gac-btn-auto {
      background:linear-gradient(135deg,#4facfe,#00f2fe);
      box-shadow:0 6px 20px rgba(79,172,254,.4);
    }

    .gac-btn-icon { font-size:20px; }
    .gac-btn-text {}
    .gac-btn-text strong { display:block; font-size:15px; }
    .gac-btn-text span   { display:block; font-size:11px; opacity:.85; font-weight:500; margin-top:1px; }

    /* 狀態區 */
    .gac-status {
      border-radius:12px; padding:14px 16px;
      background:#f0f4ff;
      border:2px solid #e0e8ff;
      transition:all .3s;
    }
    .gac-status-label {
      font-size:11px; font-weight:700; color:#8899cc;
      text-transform:uppercase; letter-spacing:.8px; margin-bottom:6px;
    }
    .gac-status-text {
      font-size:14px; font-weight:700; color:#334;
      line-height:1.5; min-height:20px;
      transition:color .3s;
    }

    /* 狀態顏色 */
    .gac-status.running  { border-color:#4facfe; background:#eef7ff; }
    .gac-status.running  .gac-status-text { color:#1a7bd4; }
    .gac-status.success  { border-color:#38ef7d; background:#eefff5; }
    .gac-status.success  .gac-status-text { color:#0e7a45; }
    .gac-status.error    { border-color:#ffd200; background:#fffbee; }
    .gac-status.error    .gac-status-text { color:#8a6000; }

    /* 進度條 */
    .gac-progress-wrap {
      margin-top:10px; display:none;
      background:#e0e8ff; border-radius:99px; height:6px; overflow:hidden;
    }
    .gac-progress-wrap.show { display:block; }
    .gac-progress-bar {
      height:100%; border-radius:99px; width:0%;
      background:linear-gradient(90deg,#4facfe,#00f2fe);
      transition:width .3s ease;
    }
    .gac-progress-bar.green {
      background:linear-gradient(90deg,#11998e,#38ef7d);
    }

    /* 閃爍動畫 */
    @keyframes gacPulse { 0%,100%{opacity:1} 50%{opacity:.5} }
    .gac-pulsing { animation:gacPulse 1.2s ease-in-out infinite; }
  `;

  const styleEl = document.createElement('style');
  styleEl.textContent = CSS;
  document.head.appendChild(styleEl);

  /* ── 遊戲 emoji 對照 ── */
  const EMOJI = {
    number:'🔢', memory:'🧠', reaction:'⚡', mole:'🐭', puzzle:'🧩'
  };

  /* ── 建立面板 HTML ── */
  const winBtn = `
    <button class="gac-btn gac-btn-win" id="gac-win">
      <span class="gac-btn-icon">🏆</span>
      <span class="gac-btn-text">
        <strong>通關模式</strong>
        <span>自動完成 · 模擬真人操控</span>
      </span>
    </button>`;

  const loseBtn = `
    <button class="gac-btn gac-btn-lose" id="gac-lose">
      <span class="gac-btn-icon">💀</span>
      <span class="gac-btn-text">
        <strong>失敗模式</strong>
        <span>自動輸掉 · 模擬真人操控</span>
      </span>
    </button>`;

  const autoBtn = `
    <button class="gac-btn gac-btn-auto" id="gac-win">
      <span class="gac-btn-icon">🤖</span>
      <span class="gac-btn-text">
        <strong>自動模式</strong>
        <span>全自動完成 · 模擬真人操控</span>
      </span>
    </button>`;

  const btnsHTML = gameDef.canLose ? (winBtn + loseBtn) : autoBtn;

  const panel = document.createElement('div');
  panel.id = '__gac_panel__';
  panel.innerHTML = `
    <div class="gac-head">
      <div class="gac-head-left">
        <span class="gac-icon">🎮</span>
        <div>
          <div class="gac-title">快速通關工具</div>
          <div class="gac-subtitle">第56屆全國技能競賽 · 北區訓練</div>
        </div>
      </div>
      <button class="gac-close" id="gac-close">✕</button>
    </div>
    <div class="gac-body">
      <div class="gac-game-card">
        <span class="gac-game-emoji">${EMOJI[gameDef.key]}</span>
        <div class="gac-game-info">
          <div class="gac-game-tag">已辨識遊戲</div>
          <div class="gac-game-name">${gameName}</div>
        </div>
      </div>

      <div class="gac-section-label">選擇模式</div>
      <div class="gac-btns">${btnsHTML}</div>

      <div class="gac-status" id="gac-status">
        <div class="gac-status-label">執行狀態</div>
        <div class="gac-status-text" id="gac-stext">等待選擇模式...</div>
        <div class="gac-progress-wrap" id="gac-prog-wrap">
          <div class="gac-progress-bar" id="gac-prog-bar"></div>
        </div>
      </div>
    </div>
  `;
  document.body.appendChild(panel);

  /* ── 狀態更新 helpers ── */
  function setStatus(msg, type = '') {
    const statusBox  = document.getElementById('gac-status');
    const statusText = document.getElementById('gac-stext');
    if (!statusBox || !statusText) return;
    statusText.textContent = msg;
    statusBox.className = 'gac-status ' + type;
    if (type === 'running') statusText.classList.add('gac-pulsing');
    else statusText.classList.remove('gac-pulsing');
  }

  function showProgress(pct, green = false) {
    const wrap = document.getElementById('gac-prog-wrap');
    const bar  = document.getElementById('gac-prog-bar');
    if (!wrap || !bar) return;
    wrap.classList.add('show');
    bar.style.width = pct + '%';
    bar.className = 'gac-progress-bar' + (green ? ' green' : '');
  }

  function hideProgress() {
    const wrap = document.getElementById('gac-prog-wrap');
    if (wrap) wrap.classList.remove('show');
  }

  function lockBtns(locked) {
    document.querySelectorAll('.gac-btn').forEach(b => b.disabled = locked);
  }

  /* ══════════════════════════════════════════════
     遊戲邏輯
  ══════════════════════════════════════════════ */

  /* ── 1 & 2：數字挑戰 / 記憶挑戰 ── */
  async function runNumber(win) {
    /* 攔截 confirm 對話框，自動選「取消」（不重新開始）→ 觸發 sendResultToParent */
    const origConfirm = window.confirm;
    window.confirm = () => false;

    try {
      await rndSleep(500, 900);
      setStatus('讀取數字列表...', 'running');
      showProgress(10);

      const blocks = [...document.querySelectorAll('.number')]
        .map(el => ({ el, val: parseInt(el.textContent.trim()) }));

      if (!blocks.length) {
        setStatus('⚠️ 找不到數字元素，請確認遊戲已載入', 'error');
        return;
      }

      if (win) {
        /* ── 贏：依升序點擊 ── */
        const sorted = [...blocks].sort((a, b) => a.val - b.val);
        setStatus(`按升序點擊：${sorted.map(n => n.val).join(' → ')}`, 'running');
        showProgress(20);

        for (let i = 0; i < sorted.length; i++) {
          await rndSleep(350, 850);
          showProgress(20 + (i + 1) / sorted.length * 70);
          setStatus(`點擊第 ${i + 1} 個數字：${sorted[i].val}`, 'running');
          fireClick(sorted[i].el);
        }

        await rndSleep(200, 400);
        showProgress(100, true);
        setStatus('✅ 挑戰成功！', 'success');

      } else {
        /* ── 輸：先點最大再點最小，保證觸發失敗 ── */
        const sorted = [...blocks].sort((a, b) => a.val - b.val);
        const wrongOrder = [sorted[sorted.length - 1], sorted[0]]; // 最大 → 最小 = 必錯

        setStatus('故意點擊錯誤順序...', 'running');
        showProgress(30);
        await rndSleep(400, 700);

        fireClick(wrongOrder[0].el);
        await rndSleep(250, 500);
        fireClick(wrongOrder[1].el);

        await rndSleep(300, 500);
        showProgress(100);
        setStatus('❌ 挑戰失敗！', 'error');
      }
    } finally {
      window.confirm = origConfirm;
    }
  }

  /* ── 3：反應力測試 ── */
  async function runReaction(win) {
    setStatus('啟動反應力測試...', 'running');
    showProgress(5);

    const btn = document.getElementById('btn-start');
    if (btn && !btn.disabled) { fireClick(btn); await rndSleep(700, 1100); }

    const arena = document.getElementById('arena');
    if (!arena) { setStatus('⚠️ 找不到反應區域', 'error'); return; }

    const ROUNDS = 5;
    let doneRounds = 0;
    let busy = false;

    setStatus('等待回合開始...', 'running');

    await new Promise(resolve => {
      const obs = new MutationObserver(async () => {
        if (busy) return;
        const cls = arena.className;

        /* 贏：等 go（綠色）後以真實反應時間點擊 */
        if (win && cls.includes('go')) {
          busy = true;
          doneRounds++;
          const ms = Math.round(rnd(140, 310));
          setStatus(`第 ${doneRounds}/${ROUNDS} 回合 — 反應 ${ms}ms`, 'running');
          showProgress((doneRounds / ROUNDS) * 90);
          await sleep(ms);
          fireClick(arena);
          await sleep(200);
          busy = false;
        }

        /* 輸：等 ready（紅色）後立即太早點擊 */
        if (!win && cls.includes('ready') && !cls.includes('go')) {
          busy = true;
          doneRounds++;
          setStatus(`第 ${doneRounds}/${ROUNDS} 回合 — 故意太早`, 'running');
          showProgress((doneRounds / ROUNDS) * 90);
          await rndSleep(250, 550);
          fireClick(arena);
          await sleep(200);
          busy = false;
        }

        /* 完成 */
        if (cls.includes('done')) {
          obs.disconnect();
          showProgress(100, win);
          setStatus(win ? '✅ 測試完成！' : '❌ 所有回合失敗！', win ? 'success' : 'error');
          hideProgress();
          resolve();
        }
      });
      obs.observe(arena, { attributes: true, attributeFilter: ['class'] });
    });
  }

  /* ── 4：打地鼠 ── */
  async function runMole() {
    setStatus('準備開始打地鼠...', 'running');
    showProgress(5);

    const btn = document.getElementById('btn-start');
    if (btn && !btn.disabled) { fireClick(btn); await rndSleep(400, 700); }

    setStatus('🔨 全力打地鼠中...', 'running');

    let ticks = 0;
    const TOTAL_TICKS = 30 * 1000 / 60; // ~500

    await new Promise(resolve => {
      const iv = setInterval(() => {
        ticks++;
        showProgress(Math.min(99, (ticks / TOTAL_TICKS) * 100));

        /* 找所有可打的地鼠 */
        document.querySelectorAll('.mole.up').forEach(async mole => {
          if (mole._gac_hitting) return;
          mole._gac_hitting = true;
          await sleep(rnd(60, 180));   // 模擬人眼+手的延遲
          if (mole.classList.contains('up')) fireClick(mole);
          await sleep(50);
          mole._gac_hitting = false;
        });

        /* 檢查遊戲結束 */
        const overlay = document.getElementById('overlay');
        if (overlay?.classList.contains('show')) {
          clearInterval(iv);
          const score = document.getElementById('score-val')?.textContent ?? '?';
          showProgress(100, true);
          setStatus(`✅ 遊戲結束！得分：${score} 分`, 'success');
          resolve();
        }
      }, 60);
    });
  }

  /* ── 5：滑動拼圖 (A* 最優解) ── */

  /* 從 DOM 讀取當前棋盤 */
  function readBoard() {
    return [...document.querySelectorAll('#puzzle .tile')]
      .map(t => t.dataset.n ? parseInt(t.dataset.n) : 0);
  }

  /* Manhattan distance heuristic */
  function heuristic(state) {
    const GOAL_POS = [null,0,1,2,3,4,5,6,7,8]; // value→goal_index
    let d = 0;
    for (let i = 0; i < 9; i++) {
      const v = state[i];
      if (!v) continue;
      const gi = GOAL_POS[v];
      d += Math.abs(~~(i / 3) - ~~(gi / 3)) + Math.abs(i % 3 - gi % 3);
    }
    return d;
  }

  /* 取得可移動的鄰居索引（空格附近的磚） */
  function getNeighbors(state) {
    const e = state.indexOf(0);
    const r = ~~(e / 3), c = e % 3, ns = [];
    if (r > 0) ns.push(e - 3);
    if (r < 2) ns.push(e + 3);
    if (c > 0) ns.push(e - 1);
    if (c < 2) ns.push(e + 1);
    return ns;
  }

  /* 簡易 Min-Heap（A* 用） */
  class MinHeap {
    constructor() { this._d = []; }
    push(item, priority) {
      this._d.push({ item, priority });
      this._bubbleUp(this._d.length - 1);
    }
    pop() {
      const top = this._d[0].item;
      const last = this._d.pop();
      if (this._d.length) { this._d[0] = last; this._sinkDown(0); }
      return top;
    }
    _bubbleUp(i) {
      while (i > 0) {
        const p = ~~((i - 1) / 2);
        if (this._d[p].priority <= this._d[i].priority) break;
        [this._d[p], this._d[i]] = [this._d[i], this._d[p]];
        i = p;
      }
    }
    _sinkDown(i) {
      const n = this._d.length;
      while (true) {
        let s = i, l = 2*i+1, r = 2*i+2;
        if (l < n && this._d[l].priority < this._d[s].priority) s = l;
        if (r < n && this._d[r].priority < this._d[s].priority) s = r;
        if (s === i) break;
        [this._d[s], this._d[i]] = [this._d[i], this._d[s]];
        i = s;
      }
    }
    get size() { return this._d.length; }
  }

  /* A* 求解 8-puzzle，回傳 tileIdx 序列（每步要點的格子位置） */
  function astarSolve(start) {
    const GOAL_KEY = '1,2,3,4,5,6,7,8,0';
    const startKey = start.join(',');
    if (startKey === GOAL_KEY) return [];

    const heap    = new MinHeap();
    const gScore  = new Map([[startKey, 0]]);
    const cameFrom= new Map();  // key -> parentKey
    const moveFor = new Map();  // key -> tileIdx that was clicked to reach this state

    heap.push({ state: start, key: startKey }, heuristic(start));

    while (heap.size > 0) {
      const { state, key } = heap.pop();
      if (key === GOAL_KEY) {
        /* 重建路徑 */
        const path = [];
        let cur = key;
        while (moveFor.has(cur)) { path.unshift(moveFor.get(cur)); cur = cameFrom.get(cur); }
        return path;
      }

      const g = gScore.get(key);
      for (const ni of getNeighbors(state)) {
        const ns = [...state];
        const e  = ns.indexOf(0);
        [ns[e], ns[ni]] = [ns[ni], ns[e]];
        const nk = ns.join(',');
        const ng = g + 1;
        if (ng < (gScore.get(nk) ?? Infinity)) {
          gScore.set(nk, ng);
          cameFrom.set(nk, key);
          moveFor.set(nk, ni);  // ni = board position of tile clicked
          heap.push({ state: ns, key: nk }, ng + heuristic(ns));
        }
      }
    }
    return null; // 無解（理論上不會，因 shuffle 保證有解）
  }

  async function runPuzzle() {
    setStatus('打亂拼圖中...', 'running');
    showProgress(5);

    const startBtn = document.getElementById('btn-start');
    if (startBtn) { fireClick(startBtn); await rndSleep(900, 1300); }

    setStatus('讀取棋盤狀態...', 'running');
    showProgress(15);
    await sleep(300);

    const board = readBoard();
    setStatus('A* 計算最優路徑...', 'running');
    showProgress(25);
    await sleep(50); // 讓 UI 更新後再做運算

    const moves = astarSolve(board);

    if (!moves || moves.length === 0) {
      showProgress(100, true);
      setStatus('✅ 拼圖已是完成狀態！', 'success');
      return;
    }

    setStatus(`找到 ${moves.length} 步最優解！開始執行...`, 'running');
    showProgress(30);
    await rndSleep(400, 700);

    /* 逐步執行 */
    let currentBoard = [...board];

    for (let i = 0; i < moves.length; i++) {
      const tileIdx = moves[i];  // board position of tile to click
      const pct = 30 + ((i + 1) / moves.length) * 65;

      showProgress(pct);
      setStatus(`執行步驟 ${i + 1} / ${moves.length}`, 'running');

      /* 每次從 DOM 找磚塊（render 後 DOM 會重建）*/
      const tiles = document.querySelectorAll('#puzzle .tile');
      if (tiles[tileIdx]) {
        await rndSleep(220, 480);
        fireClick(tiles[tileIdx]);

        /* 更新本地棋盤 */
        const e = currentBoard.indexOf(0);
        [currentBoard[e], currentBoard[tileIdx]] = [currentBoard[tileIdx], currentBoard[e]];
      }

      /* 提前偵測 overlay（完成畫面） */
      const overlay = document.getElementById('overlay');
      if (overlay?.classList.contains('show')) break;
    }

    await rndSleep(400, 700);
    showProgress(100, true);
    setStatus('✅ 拼圖完成！', 'success');
  }

  /* ══════════════════════════════════════════════
     事件綁定
  ══════════════════════════════════════════════ */

  async function handleMode(win) {
    lockBtns(true);
    hideProgress();
    setStatus('啟動中...', 'running');

    try {
      switch (gameDef.key) {
        case 'number':
        case 'memory':
          await runNumber(win);
          break;
        case 'reaction':
          await runReaction(win);
          break;
        case 'mole':
          await runMole();
          break;
        case 'puzzle':
          await runPuzzle();
          break;
      }
    } catch (err) {
      setStatus('❌ 執行錯誤：' + err.message, 'error');
      console.error('[GAC]', err);
    }

    await sleep(1500);
    lockBtns(false);
  }

  document.getElementById('gac-win')?.addEventListener('click', () => handleMode(true));
  document.getElementById('gac-lose')?.addEventListener('click', () => handleMode(false));

  document.getElementById('gac-close').addEventListener('click', () => {
    panel.remove();
    styleEl.remove();
  });

  /* 可拖曳面板 */
  (function makeDraggable() {
    const head = panel.querySelector('.gac-head');
    let ox = 0, oy = 0, dragging = false;
    head.style.cursor = 'grab';
    head.addEventListener('mousedown', e => {
      dragging = true;
      const r = panel.getBoundingClientRect();
      ox = e.clientX - r.left;
      oy = e.clientY - r.top;
      head.style.cursor = 'grabbing';
      e.preventDefault();
    });
    document.addEventListener('mousemove', e => {
      if (!dragging) return;
      panel.style.left   = (e.clientX - ox) + 'px';
      panel.style.top    = (e.clientY - oy) + 'px';
      panel.style.transform = 'none';
    });
    document.addEventListener('mouseup', () => {
      dragging = false;
      head.style.cursor = 'grab';
    });
  })();

  console.log(
    '%c🎮 快速通關工具 v2.0 已啟動！%c 遊戲：' + gameName,
    'color:#fff;background:linear-gradient(135deg,#3a1c71,#d76d77);padding:6px 14px;border-radius:8px;font-weight:bold;font-size:14px',
    'color:#4facfe;font-size:13px;padding-left:8px'
  );

})();
