<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>FunTech DOM Checker</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:#0f1117;--bg2:#1a1d27;--bg3:#242736;--bg4:#2e3247;
  --border:#2e3347;--text:#e8eaf0;--muted:#7880a0;--dim:#4a5070;
  --green:#3dd68c;--red:#f06464;--yellow:#f5c842;
  --blue:#5b8dee;--purple:#a78bfa;--cyan:#38bdf8;--orange:#fb923c;
}
body{background:var(--bg);color:var(--text);font-family:'Courier New',monospace;font-size:13px;min-height:100vh;display:flex;flex-direction:column}
header{background:var(--bg2);border-bottom:1px solid var(--border);padding:12px 18px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0}
.logo{font-size:15px;font-weight:700;color:var(--cyan);letter-spacing:.5px}
.logo span{color:var(--purple)}
.sub{color:var(--muted);font-size:10px;margin-top:2px}
.layout{display:flex;flex:1;overflow:hidden}
.sidebar{width:268px;background:var(--bg2);border-right:1px solid var(--border);display:flex;flex-direction:column;overflow:hidden;flex-shrink:0}
.sidebar-pages{padding:10px;border-bottom:1px solid var(--border)}
.sidebar-label{font-size:10px;color:var(--dim);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px}
.page-btns{display:flex;flex-direction:column;gap:2px}
.page-btn{padding:7px 10px;border-radius:4px;cursor:pointer;color:var(--muted);font-size:11px;display:flex;align-items:center;justify-content:space-between;transition:all .1s}
.page-btn:hover{background:var(--bg3);color:var(--text)}
.page-btn.active{background:var(--bg4);color:var(--cyan);border-left:2px solid var(--cyan)}
.page-btn .cnt{font-size:10px;color:var(--dim)}
.page-btn.active .cnt{color:var(--cyan)}
.actions{padding:10px;border-top:1px solid var(--border);display:flex;flex-direction:column;gap:5px;flex-shrink:0}
.btn{padding:9px 10px;border-radius:5px;border:1px solid var(--border);background:var(--bg3);color:var(--text);font-family:'Courier New',monospace;font-size:11px;cursor:pointer;text-align:center;transition:all .15s;display:flex;align-items:center;justify-content:center;gap:6px;width:100%}
.btn:hover{border-color:var(--blue);color:var(--blue)}
.btn.cta{background:#0d1e35;border-color:#2a5aaf;color:var(--cyan)}
.btn.cta:hover{border-color:var(--cyan);background:#0f2540}
.btn.ok{background:#0d2a1a;border-color:var(--green);color:var(--green)}
.main{flex:1;overflow-y:auto;padding:16px 20px}
.page-header{display:flex;align-items:center;gap:10px;margin-bottom:14px}
.page-title{font-size:14px;font-weight:700}
.page-info{color:var(--muted);font-size:11px;margin-top:1px}
.stats-row{display:flex;gap:6px;margin-bottom:16px;flex-wrap:wrap}
.stat{background:var(--bg2);border:1px solid var(--border);border-radius:5px;padding:5px 10px;font-size:11px;display:flex;align-items:center;gap:6px}
.stat .n{font-size:14px;font-weight:700}
.stat.g .n{color:var(--green)}.stat.r .n{color:var(--red)}.stat.y .n{color:var(--yellow)}.stat.b .n{color:var(--blue)}
.group{margin-bottom:18px}
.group-title{font-size:10px;font-weight:700;color:var(--purple);text-transform:uppercase;letter-spacing:1.2px;margin-bottom:7px;padding-bottom:5px;border-bottom:1px solid var(--border)}
.item{display:flex;align-items:flex-start;gap:9px;padding:5px 7px;border-radius:4px;margin-bottom:1px}
.item:hover{background:var(--bg3)}
.dot{width:6px;height:6px;border-radius:50%;flex-shrink:0;margin-top:5px}
.dot.req{background:var(--blue)}.dot.cond{background:var(--yellow)}
.sel{color:var(--cyan);font-size:12px;word-break:break-all}
.note{color:var(--dim);font-size:10px;margin-top:1px}
.cbadge{display:inline-block;padding:1px 5px;border-radius:2px;font-size:9px;background:#2a2a12;color:var(--yellow);border:1px solid #4a4a22;margin-left:4px;vertical-align:middle}
.feature-box{background:var(--bg2);border:1px solid var(--border);border-radius:6px;padding:12px;margin-bottom:16px}
.feature-box .ftitle{font-size:10px;color:var(--dim);text-transform:uppercase;letter-spacing:1px;margin-bottom:8px}
.feature-row{display:flex;align-items:flex-start;gap:8px;margin-bottom:7px;font-size:11px}
.feature-row .badge{font-size:9px;padding:2px 7px;border-radius:3px;flex-shrink:0;font-weight:700;margin-top:1px}
.badge-ajax{background:#2a1500;color:var(--orange);border:1px solid #5a3000}
.badge-mut{background:#1a0030;color:var(--purple);border:1px solid #3a0070}
.badge-src{background:#001a30;color:var(--cyan);border:1px solid #004a70}
.badge-spa{background:#001520;color:var(--blue);border:1px solid #003a60}
.badge-mode{background:#002010;color:var(--green);border:1px solid #005030}
.feature-desc{color:var(--muted);line-height:1.7;flex:1}
.feedback{font-size:11px;text-align:center;padding:3px;border-radius:3px;opacity:0;transition:opacity .3s}
.feedback.show{opacity:1;color:var(--green)}
::-webkit-scrollbar{width:4px}::-webkit-scrollbar-track{background:transparent}::-webkit-scrollbar-thumb{background:var(--bg4);border-radius:2px}
</style>
</head>
<body>
<header>
  <div>
    <div class="logo">⚡ FunTech <span>DOM Checker</span></div>
    <div class="sub">第 56 屆全國技能競賽 · 自動偵測 + AJAX 攔截 + 原始碼掃描</div>
  </div>
</header>
<div class="layout">
  <div class="sidebar">
    <div class="sidebar-pages">
      <div class="sidebar-label">頁面選擇</div>
      <div class="page-btns" id="page-btns"></div>
    </div>
    <div style="flex:1"></div>
    <div class="actions">
      <button class="btn cta" id="smartBtn" onclick="copySmartScript()">
        🧠 複製智慧腳本 (完整版)
      </button>
      <button class="btn" onclick="copyPageScript()">
        📋 複製當前頁腳本
      </button>
      <div id="fb" class="feedback"></div>
      <div style="color:var(--dim);font-size:10px;line-height:1.8;margin-top:2px">
        F12 → Console → 貼上 → Enter
      </div>
    </div>
  </div>
  <div class="main" id="main"></div>
</div>

<script>
/* ─────────────────────────────────────────────────
   PAGE DEFINITIONS
───────────────────────────────────────────────── */
const PAGES = [
  {
    id:'home',label:'首頁',emoji:'🏠',info:'index.php / index.html',
    urlPatterns:[/^\/?(index\.(php|html?))?$/,/\/home$/],rootSel:'#home',
    groups:[
      {title:'根容器',items:[{sel:'#home',note:'首頁根容器'}]},
      {title:'Header 導覽列',items:[
        {sel:'header.site-header',note:'頁首容器'},
        {sel:'.site-header .brand a.brand-link',note:'Logo 連結'},
        {sel:'.site-header nav.main-nav',note:'主導覽列'},
        {sel:'.site-header nav.main-nav a.home-link',note:'首頁連結'},
        {sel:'.site-header nav.main-nav a.games-link',note:'遊戲連結'},
        {sel:'.site-header nav.main-nav a.friends-link',note:'好友連結'},
        {sel:'.site-header .user-area',note:'使用者區域'},
        {sel:'.user-area a.login-link',note:'登入連結',cond:'未登入'},
        {sel:'.user-area a.register-link',note:'註冊連結',cond:'未登入'},
        {sel:'.user-area .user-badge',note:'使用者名稱/頭像',cond:'已登入'},
        {sel:'.user-area a.profile-link',note:'個人頁入口',cond:'已登入'},
        {sel:'.user-area a.logout-link',note:'登出按鈕',cond:'已登入'},
      ]},
      {title:'文章列表',items:[
        {sel:'section.articles',note:'文章區塊容器'},
        {sel:'section.articles article.article-item',note:'文章項目（多筆）'},
        {sel:'.article-item .article-title',note:'文章標題'},
        {sel:'.article-item time.article-date',note:'發佈日期'},
        {sel:'.article-item .article-excerpt',note:'文章摘要'},
        {sel:'.article-item a.article-readmore',note:'閱讀更多連結'},
      ]},
      {title:'通知／公告',items:[
        {sel:'aside.notifications',note:'通知區塊容器'},
        {sel:'aside.notifications .notification-item',note:'通知項目（多筆）'},
        {sel:'.notification-item .notification-title',note:'通知標題'},
        {sel:'.notification-item time.notification-date',note:'發佈日期'},
      ]},
    ]
  },
  {
    id:'article',label:'文章內容',emoji:'📄',info:'文章詳細頁面',
    urlPatterns:[/\/article/,/\/post/],rootSel:'#article',
    groups:[
      {title:'根容器',items:[{sel:'#article',note:'文章頁根容器'}]},
      {title:'文章標題區塊',items:[
        {sel:'#article header.article-header',note:'標題區塊'},
        {sel:'.article-header h1.article-title',note:'文章標題 h1'},
        {sel:'.article-header time.article-date',note:'發布日期'},
      ]},
      {title:'文章內容',items:[{sel:'#article section.article-body',note:'文章內容區塊'}]},
    ]
  },
  {
    id:'profile',label:'個人頁面',emoji:'👤',info:'使用者自己的個人頁',
    urlPatterns:[/\/profile/,/\/user/,/\/me\//],rootSel:'#profile-page',
    detectHint:'own',
    groups:[
      {title:'根容器',items:[{sel:'#profile-page',note:'個人頁根容器'}]},
      {title:'使用者資訊區',items:[
        {sel:'section.profile-header',note:'使用者資訊區塊'},
        {sel:'.profile-header img.profile-avatar',note:'使用者頭像'},
        {sel:'.profile-header .profile-username',note:'使用者名稱'},
        {sel:'.profile-header .profile-bio',note:'簡介文字'},
        {sel:'.profile-header textarea.profile-bio-input',note:'簡介編輯框',cond:'點擊簡介後'},
      ]},
      {title:'發表文章功能',items:[
        {sel:'a.new-post-link',note:'發表文章連結'},
        {sel:'form.article-create-form',note:'文章發布表單'},
        {sel:'.article-create-form input.article-title-input',note:'標題輸入欄位'},
        {sel:'.article-create-form textarea.article-content-input',note:'內容輸入欄位'},
        {sel:'.article-create-form button.article-submit-button',note:'發布按鈕'},
      ]},
      {title:'使用者文章區',items:[
        {sel:'section.profile-articles',note:'文章列表區塊'},
        {sel:'.profile-articles .article-item',note:'文章項目（多筆）'},
        {sel:'.article-item .article-title',note:'文章標題'},
        {sel:'.article-item time.article-date',note:'發佈日期'},
        {sel:'.article-item a.article-readmore',note:'閱讀文章連結'},
        {sel:'.profile-articles .empty-article-message',note:'「目前尚無文章」',cond:'無文章時'},
      ]},
    ]
  },
  {
    id:'login',label:'登入頁面',emoji:'🔑',info:'使用者登入',
    urlPatterns:[/\/login/,/\/signin/],rootSel:'form.login-form',
    groups:[{title:'登入表單',items:[
      {sel:'form.login-form',note:'登入表單容器'},
      {sel:'.login-form input.username-input',note:'帳號欄位'},
      {sel:'.login-form input.password-input',note:'密碼欄位'},
      {sel:'.login-form button.login-submit-button',note:'登入送出按鈕'},
    ]}]
  },
  {
    id:'register',label:'註冊頁面',emoji:'📝',info:'使用者註冊',
    urlPatterns:[/\/register/,/\/signup/],rootSel:'form.register-form',
    groups:[{title:'註冊表單',items:[
      {sel:'form.register-form',note:'註冊表單容器'},
      {sel:'.register-form input.username-input',note:'帳號欄位'},
      {sel:'.register-form input.email-input',note:'電子郵件欄位'},
      {sel:'.register-form input.password-input',note:'密碼欄位'},
      {sel:'.register-form input.password-confirm-input',note:'確認密碼欄位'},
      {sel:'.register-form button.register-submit',note:'註冊送出按鈕'},
    ]}]
  },
  {
    id:'friends',label:'好友系統',emoji:'👥',info:'好友列表頁（需登入）',
    urlPatterns:[/\/friends/],rootSel:'#friends-page',
    groups:[
      {title:'好友頁主容器',items:[
        {sel:'#friends-page',note:'好友頁根容器'},
        {sel:'#friends-page .friend-search-section',note:'搜尋功能區塊'},
        {sel:'#friends-page .friend-list-section',note:'好友列表區塊'},
        {sel:'#friends-page .incoming-requests-section',note:'收到的申請區塊'},
        {sel:'#friends-page .sent-requests-section',note:'送出的申請區塊'},
      ]},
      {title:'搜尋使用者',items:[
        {sel:'form.friend-search-form',note:'搜尋表單'},
        {sel:'.friend-search-form input.search-input',note:'搜尋輸入欄位'},
        {sel:'.friend-search-form button.search-submit-button',note:'搜尋按鈕'},
        {sel:'.friend-search-section .search-result-list',note:'搜尋結果容器'},
        {sel:'.search-result-list .search-result-item',note:'結果項目',cond:'搜尋後'},
        {sel:'.search-result-item .result-username',note:'使用者名稱',cond:'搜尋後'},
        {sel:'.search-result-item a.view-profile-link',note:'個人頁連結',cond:'搜尋後'},
      ]},
      {title:'我的好友列表',items:[
        {sel:'.friend-list-section .section-title',note:'「好友列表」標題'},
        {sel:'.friend-list-section .friend-item',note:'好友項目（多筆）'},
        {sel:'.friend-item img.friend-avatar',note:'好友頭像'},
        {sel:'.friend-item .friend-name',note:'好友名稱'},
      ]},
      {title:'收到的好友申請',items:[
        {sel:'.incoming-requests-section .section-title',note:'「收到的好友申請」標題'},
        {sel:'.incoming-requests-section .request-item',note:'申請項目（多筆）'},
        {sel:'.request-item img.request-avatar',note:'申請者頭像'},
        {sel:'.request-item .request-username',note:'申請者名稱'},
        {sel:'.request-item button.accept-request-button',note:'接受好友按鈕'},
        {sel:'.request-item button.reject-request-button',note:'拒絕好友按鈕'},
      ]},
      {title:'送出的好友申請',items:[
        {sel:'.sent-requests-section .section-title',note:'「發送的好友申請」標題'},
        {sel:'.sent-requests-section .request-item',note:'申請項目'},
        {sel:'.request-item img.request-avatar',note:'對方頭像'},
        {sel:'.request-item .request-username',note:'對方使用者名稱'},
        {sel:'.request-item button.cancel-request-button',note:'取消申請按鈕'},
      ]},
    ]
  },
  {
    id:'friend-profile',label:'好友個人頁',emoji:'🔍',info:'查看他人個人頁面',
    urlPatterns:[/\/profile\/\w+/,/\/user\/\w+/],rootSel:'#profile-page',
    detectHint:'other',
    groups:[
      {title:'根容器',items:[{sel:'#profile-page',note:'個人頁根容器'}]},
      {title:'使用者資訊',items:[
        {sel:'#profile-page .profile-header',note:'使用者資訊區塊'},
        {sel:'.profile-header .profile-username',note:'使用者名稱'},
        {sel:'.profile-header img.profile-avatar',note:'使用者頭像'},
        {sel:'.profile-header .profile-bio',note:'簡介文字'},
      ]},
      {title:'內容展示區',items:[
        {sel:'#profile-page .profile-content',note:'內容展示區塊'},
        {sel:'section.articles',note:'文章區塊容器'},
        {sel:'section.articles article.article-item',note:'文章項目（多筆）'},
        {sel:'.article-item .article-title',note:'文章標題'},
        {sel:'.article-item time.article-date',note:'發佈日期'},
        {sel:'.article-item .article-excerpt',note:'文章摘要'},
        {sel:'.article-item a.article-readmore',note:'閱讀更多連結'},
      ]},
      {title:'好友互動操作',items:[
        {sel:'#profile-page .profile-friend-actions',note:'好友狀態互動區塊'},
      ]},
    ]
  },
  {
    id:'games',label:'遊戲列表',emoji:'🎮',info:'遊戲列表頁面 /games',
    urlPatterns:[/\/games\/?$/],rootSel:'#games',
    groups:[
      {title:'根容器',items:[{sel:'#games',note:'遊戲列表根容器'}]},
      {title:'遊戲列表',items:[
        {sel:'#games section.game-list',note:'遊戲列表容器'},
        {sel:'.game-list .game-item',note:'遊戲項目（多筆）'},
        {sel:'.game-item img.game-cover',note:'遊戲封面圖片'},
        {sel:'.game-item .game-title',note:'遊戲名稱'},
        {sel:'.game-item .game-description',note:'遊戲簡介'},
        {sel:'.game-item a.play-game-link',note:'「開始遊戲」連結'},
      ]},
    ]
  },
  {
    id:'game-play',label:'遊戲內容',emoji:'🕹️',info:'遊戲內容頁（含排行榜）',
    urlPatterns:[/\/games\/\d+/,/\/game-play/,/\/play\//],rootSel:'#game-play',
    groups:[
      {title:'根容器',items:[
        {sel:'#game-play',note:'遊戲內容頁根容器'},
        {sel:'.current-game-title',note:'目前遊戲名稱'},
      ]},
      {title:'遊戲區域',items:[
        {sel:'#game-play section.game-area',note:'遊戲區域容器'},
        {sel:'section.game-area iframe.game-frame',note:'遊戲 iframe'},
      ]},
      {title:'排行榜',items:[
        {sel:'aside.game-leaderboard',note:'排行榜區塊'},
        {sel:'.game-leaderboard .leaderboard-title',note:'排行榜標題'},
        {sel:'.game-leaderboard .leaderboard-item',note:'排行榜資料（多筆）'},
        {sel:'.leaderboard-item .player-rank',note:'玩家名次'},
      ]},
    ]
  },
];

/* ─────────────────────────────────────────────────
   BUILD SMART CONSOLE SCRIPT
───────────────────────────────────────────────── */
function buildSmartScript() {
  const pagesData = PAGES.map(p => ({
    id:p.id, label:p.label, rootSel:p.rootSel, detectHint:p.detectHint||'',
    urlPatterns:p.urlPatterns.map(r=>r.source),
    items:p.groups.flatMap(g=>g.items.map(i=>({sel:i.sel,note:i.note,cond:i.cond||'',group:g.title})))
  }));

  return `/* ══════════════════════════════════════════════════════════════
   FunTech DOM Checker — 智慧版
   第 56 屆全國技能競賽 · 網頁技術青少年組
   功能: 偵測載入模式 / 頁面辨識 / 原始碼掃描 / AJAX 攔截 / SPA 路由監聽
══════════════════════════════════════════════════════════════ */
(function(){
'use strict';
if(window.__ftc){window.__ftc.destroy();}

/* ── 頁面定義 ── */
var PG=${JSON.stringify(pagesData)};

/* ── Console 樣式 ── */
var S={
  title:'font-size:14px;font-weight:700;color:#38bdf8;',
  section:'font-size:11px;font-weight:700;color:#a78bfa;',
  ok:'color:#3dd68c;',fail:'color:#f06464;',warn:'color:#f5c842;',
  dim:'color:#7880a0;',cyan:'color:#38bdf8;',orange:'color:#fb923c;',
  tag_ok:'background:#0d2a1a;color:#3dd68c;padding:1px 6px;border-radius:3px;font-weight:700;',
  tag_fail:'background:#2a0d0d;color:#f06464;padding:1px 6px;border-radius:3px;font-weight:700;',
  tag_warn:'background:#2a2000;color:#f5c842;padding:1px 6px;border-radius:3px;',
  tag_ajax:'background:#2a1500;color:#fb923c;padding:1px 6px;border-radius:3px;',
  tag_src:'background:#001a30;color:#38bdf8;padding:1px 6px;border-radius:3px;',
  hr:'color:#2e3347;',
};
function hr(){console.log('%c'+'━'.repeat(60),S.hr);}

/* ═══════════════════════════════════════════════
   1. 載入模式偵測
═══════════════════════════════════════════════ */
function detectMode(){
  var fw=[],mode='traditional';
  var rh=window.__REACT_DEVTOOLS_GLOBAL_HOOK__;
  if(rh&&rh.renderers&&rh.renderers.size>0){fw.push('React');mode='spa';}
  if(!fw.length&&(window.React||document.querySelector('[data-reactroot]'))){fw.push('React');mode='spa';}
  if(window.__vue_app__||document.querySelector('[data-v-app]')){fw.push('Vue3');mode='spa';}
  else if(window.Vue||document.querySelector('[data-v-]')){fw.push('Vue2');mode='spa';}
  if(window.ng||document.querySelector('[ng-version],[_nghost-]')){fw.push('Angular');mode='spa';}
  if(window.__NEXT_DATA__){fw.push('Next.js');mode='ssr-spa';}
  if(window.__NUXT__||window.__nuxt){fw.push('Nuxt');mode='ssr-spa';}
  if(window.Svelte||document.querySelector('[data-svelte]')){fw.push('Svelte');mode='spa';}
  if(mode==='traditional'&&window.location.hash.startsWith('#/')&&window.location.hash.length>2){mode='hash-spa';}
  var labels={traditional:'傳統換頁 (Traditional)',spa:'單頁應用 (SPA)','ssr-spa':'伺服器端路由 (SSR+SPA)','hash-spa':'Hash 路由 SPA'};
  return{mode:mode,label:labels[mode]||mode,frameworks:fw};
}

/* ═══════════════════════════════════════════════
   2. 頁面辨識（DOM優先 → URL fallback）
═══════════════════════════════════════════════ */
function detectPage(){
  var domOrder=['game-play','games','friends','article','login','register','home'];
  for(var i=0;i<domOrder.length;i++){
    var p=PG.find(function(x){return x.id===domOrder[i];});
    if(p&&document.querySelector(p.rootSel))return domOrder[i];
  }
  if(document.querySelector('#profile-page')){
    var own=!!(document.querySelector('a.new-post-link')||document.querySelector('form.article-create-form'));
    return own?'profile':'friend-profile';
  }
  var eff=window.location.hash.startsWith('#/')?window.location.hash.slice(1):window.location.pathname;
  var urlMap=[
    {id:'game-play',re:[/\\/games\\/[^/]+/,/\\/game-play/,/\\/play\\//]},
    {id:'games',re:[/\\/games\\/?$/]},
    {id:'friends',re:[/\\/friends/]},
    {id:'login',re:[/\\/login/,/\\/signin/]},
    {id:'register',re:[/\\/register/,/\\/signup/]},
    {id:'article',re:[/\\/article/,/\\/post/]},
    {id:'profile',re:[/\\/profile/,/\\/user\\//,/\\/me\\//]},
    {id:'home',re:[/^\\/?$/,/index\\.(php|html?)$/,/\\/home$/]},
  ];
  for(var u=0;u<urlMap.length;u++){
    for(var r=0;r<urlMap[u].re.length;r++){
      if(urlMap[u].re[r].test(eff))return urlMap[u].id;
    }
  }
  return null;
}

/* ═══════════════════════════════════════════════
   3. 原始碼掃描
   fetch() 當前頁面的 HTML 原始碼（server 回傳的內容），
   用 DOMParser 解析 → 找出所有靜態 ID 及 class
═══════════════════════════════════════════════ */
function fetchSourceIds(){
  return fetch(window.location.href,{credentials:'same-origin'})
    .then(function(r){return r.text();})
    .then(function(html){
      var parser=new DOMParser();
      var doc=parser.parseFromString(html,'text/html');
      var ids=[],cls={};
      doc.querySelectorAll('[id]').forEach(function(el){if(el.id)ids.push(el.id);});
      doc.querySelectorAll('[class]').forEach(function(el){
        el.classList.forEach(function(c){cls[c]=true;});
      });
      return{ids:ids,classes:Object.keys(cls),raw:html.length};
    })
    .catch(function(e){return{ids:[],classes:[],error:e.message};});
}

/* ═══════════════════════════════════════════════
   4. 現有 DOM 掃描（執行時快照）
═══════════════════════════════════════════════ */
function scanDOM(){
  var ids=[],cls={};
  document.querySelectorAll('[id]').forEach(function(el){if(el.id)ids.push(el.id);});
  document.querySelectorAll('[class]').forEach(function(el){
    el.classList.forEach(function(c){cls[c]=true;});
  });
  return{ids:ids,classes:Object.keys(cls)};
}

/* ═══════════════════════════════════════════════
   5. Selector 檢查
═══════════════════════════════════════════════ */
function runCheck(pageId,label){
  var page=PG.find(function(p){return p.id===pageId;});
  if(!page){console.log('%c找不到頁面定義: '+pageId,S.fail);return null;}
  var pass=0,reqFail=[],condMiss=[],lastGroup='';
  console.group('%c['+page.label+'] selector 檢查',S.section);
  page.items.forEach(function(item){
    var found=!!document.querySelector(item.sel);
    if(found){pass++;}
    else{item.cond?condMiss.push(item):reqFail.push(item);}
    if(item.group!==lastGroup){
      console.log('%c  ▸ '+item.group,S.dim);
      lastGroup=item.group;
    }
    var icon=found?'  ✅':'  ❌';
    var condNote=item.cond?' %c['+item.cond+']':'';
    if(item.cond){
      console.log(icon+' %c'+item.sel+'%c  '+item.note+condNote,S.cyan,S.dim,S.warn);
    }else{
      console.log(icon+' %c'+item.sel+'%c  '+item.note,S.cyan,found?S.dim:S.fail);
    }
  });
  console.groupEnd();
  if(reqFail.length===0){
    console.log('%c  ✅ 必要 selector 全部通過！',S.tag_ok);
  }else{
    console.log('%c  ❌ 缺少 '+reqFail.length+' 個必要 selector:',S.tag_fail);
    reqFail.forEach(function(f){
      console.log('%c    ✗ '+f.sel+'%c  → '+f.note,S.fail,S.dim);
    });
  }
  if(condMiss.length){
    console.log('%c  ⚠ '+condMiss.length+' 個條件 selector 未找到（需在對應狀態下測試）:',S.tag_warn);
    condMiss.forEach(function(f){
      console.log('%c    ~ '+f.sel+'  ['+f.cond+']',S.warn);
    });
  }
  return{pass:pass,reqFail:reqFail.length,total:page.items.length};
}

/* ═══════════════════════════════════════════════
   6. AJAX 攔截
   攔截 XHR + fetch，記錄請求，DOM 異動後自動重新掃描
═══════════════════════════════════════════════ */
var _ajaxLog=[];
var _recheckTimer=null;
var _domChanged=false;

function scheduleRecheck(source){
  clearTimeout(_recheckTimer);
  _recheckTimer=setTimeout(function(){
    if(_domChanged){
      _domChanged=false;
      console.log('%c[FunTech] DOM 異動偵測 → 重新掃描 (來源: '+source+')',S.tag_ajax);
      runMain(true);
    }
  },500);
}

/* MutationObserver 監視 DOM 異動 */
var _mo=new MutationObserver(function(muts){
  var sig=muts.some(function(m){return m.addedNodes.length||m.removedNodes.length;});
  if(sig)_domChanged=true;
});
_mo.observe(document.documentElement,{childList:true,subtree:true,attributes:false});

/* 攔截 XMLHttpRequest */
var _XHROpen=XMLHttpRequest.prototype.open;
var _XHRSend=XMLHttpRequest.prototype.send;
XMLHttpRequest.prototype.open=function(method,url){
  this._ftUrl=url;this._ftMethod=method;
  return _XHROpen.apply(this,arguments);
};
XMLHttpRequest.prototype.send=function(){
  var self=this,url=this._ftUrl,method=this._ftMethod||'GET';
  var t=Date.now();
  this.addEventListener('load',function(){
    var entry={type:'XHR',method:method,url:url,status:self.status,ms:Date.now()-t};
    _ajaxLog.push(entry);
    console.log('%c[XHR] '+method+' '+url+' → '+self.status+' ('+entry.ms+'ms)',S.tag_ajax);
    scheduleRecheck('XHR:'+url);
  });
  this.addEventListener('error',function(){
    console.log('%c[XHR] ✗ '+method+' '+url+' 失敗',S.fail);
  });
  return _XHRSend.apply(this,arguments);
};

/* 攔截 fetch */
var _origFetch=window.fetch;
window.fetch=function(input,init){
  var url=typeof input==='string'?input:(input&&input.url)||String(input);
  var method=(init&&init.method)||'GET';
  var t=Date.now();
  return _origFetch.apply(this,arguments).then(function(res){
    var entry={type:'fetch',method:method,url:url,status:res.status,ms:Date.now()-t};
    _ajaxLog.push(entry);
    /* 排除頁面本身的初始 fetch（原始碼掃描用的那一次）*/
    var isSelf=(url===window.location.href||url===window.location.pathname);
    if(!isSelf){
      console.log('%c[fetch] '+method+' '+url+' → '+res.status+' ('+entry.ms+'ms)',S.tag_ajax);
      scheduleRecheck('fetch:'+url);
    }
    return res;
  }).catch(function(e){
    console.log('%c[fetch] ✗ '+method+' '+url+' 失敗: '+e.message,S.fail);
    throw e;
  });
};

/* ═══════════════════════════════════════════════
   7. SPA 路由監聽
═══════════════════════════════════════════════ */
function patchHistory(){
  var oP=history.pushState.bind(history),oR=history.replaceState.bind(history);
  history.pushState=function(){oP.apply(history,arguments);setTimeout(function(){runMain(true);},400);};
  history.replaceState=function(){oR.apply(history,arguments);setTimeout(function(){runMain(true);},400);};
  window.addEventListener('popstate',function(){setTimeout(function(){runMain(true);},400);});
  window.addEventListener('hashchange',function(){setTimeout(function(){runMain(true);},400);});
}

/* ═══════════════════════════════════════════════
   8. 主流程
═══════════════════════════════════════════════ */
function runMain(fromNav){
  var modeInfo=detectMode();
  var pageId=detectPage();
  var domSnap=scanDOM();

  hr();
  console.log('%c ⚡ FunTech DOM Checker',S.title);
  if(fromNav)console.log('%c  (路由切換 / DOM 異動 → 自動重掃)',S.dim);

  /* 載入模式 */
  var modeColors={traditional:S.ok,spa:S.cyan,'ssr-spa':'color:#a78bfa;','hash-spa':S.warn};
  var mc=modeColors[modeInfo.mode]||S.dim;
  console.log('%c  ▸ 載入模式: %c'+modeInfo.label+(modeInfo.frameworks.length?' ['+modeInfo.frameworks.join(', ')+']':''),S.dim,mc+'font-weight:700;');
  console.log('%c  ▸ URL: %c'+window.location.pathname+window.location.hash,S.dim,'color:#e8eaf0;');

  /* 頁面識別 */
  if(!pageId){
    console.log('%c  ⚠ 無法辨識頁面 — 確認根容器 ID 是否存在','background:#2a2000;color:#f5c842;padding:2px 8px;border-radius:3px;font-weight:700;');
    console.log('%c  現有 DOM IDs: %c'+(domSnap.ids.length?domSnap.ids.map(function(i){return'#'+i;}).join('  '):'(無)'),S.dim,'color:#a78bfa;');
    hr();return;
  }
  var pg=PG.find(function(p){return p.id===pageId;});
  console.log('%c  ▸ 偵測頁面: %c'+pg.label,S.dim,'color:#3dd68c;font-weight:700;');

  hr();

  /* 原始碼掃描 */
  console.log('%c[原始碼掃描] 正在 fetch 頁面 HTML...',S.tag_src);
  fetchSourceIds().then(function(src){
    if(src.error){
      console.log('%c[原始碼掃描] 失敗: '+src.error,S.fail);
    }else{
      console.log('%c[原始碼掃描] 完成 ('+src.raw+'bytes)',S.tag_src);

      /* 比對：哪些必要 selector 在原始碼中已存在，哪些完全不見 */
      var page=PG.find(function(p){return p.id===pageId;});
      var missingInSrc=[];
      page.items.filter(function(i){return!i.cond;}).forEach(function(item){
        /* 嘗試以簡化方式在原始碼 DOM 中 querySelector */
        try{
          var found=false;
          /* 拆解 selector 找 ID 和 class */
          var idMatch=item.sel.match(/#([\\w-]+)/g);
          var clsMatch=item.sel.match(/\\.([\\w-]+)/g);
          if(idMatch){found=idMatch.every(function(m){return src.ids.indexOf(m.slice(1))>-1;});}
          else if(clsMatch){found=clsMatch.some(function(m){return src.classes.indexOf(m.slice(1))>-1;});}
          if(!found)missingInSrc.push(item);
        }catch(e){}
      });

      if(missingInSrc.length){
        console.log('%c[原始碼掃描] ⚠ 以下 selector 在伺服器回傳的 HTML 中找不到（可能是 AJAX/JS 動態渲染）:',S.warn);
        missingInSrc.forEach(function(i){
          console.log('%c  ~ '+i.sel+'%c  → '+i.note,S.orange,S.dim);
        });
      }else{
        console.log('%c[原始碼掃描] 所有必要 selector 均在原始碼中找到',S.ok);
      }

      /* 列出原始碼的 IDs */
      console.log('%c  原始碼 IDs: %c'+(src.ids.length?src.ids.map(function(i){return'#'+i;}).join('  '):'(無)'),S.dim,'color:#a78bfa;');
      console.log('%c  DOM 快照 IDs: %c'+(domSnap.ids.length?domSnap.ids.map(function(i){return'#'+i;}).join('  '):'(無)'),S.dim,'color:#a78bfa;');

      /* 若原始碼 IDs 和 DOM IDs 不同 → 有 AJAX 動態插入的內容 */
      var domOnly=domSnap.ids.filter(function(id){return src.ids.indexOf(id)<0;});
      var srcOnly=src.ids.filter(function(id){return domSnap.ids.indexOf(id)<0;});
      if(domOnly.length){
        console.log('%c  ★ 僅在 DOM 中存在（AJAX/JS 動態插入）: %c'+(domOnly.map(function(i){return'#'+i;}).join('  ')),S.tag_ajax,'color:#fb923c;');
      }
      if(srcOnly.length){
        console.log('%c  ★ 僅在原始碼中存在（尚未渲染 or 被 JS 移除）: %c'+(srcOnly.map(function(i){return'#'+i;}).join('  ')),S.tag_warn,'color:#f5c842;');
      }
    }
    hr();

    /* Selector 逐項檢查 */
    var result=runCheck(pageId);
    hr();

    /* SPA 啟動監聽 */
    if(!window.__ftc._spa&&(modeInfo.mode==='spa'||modeInfo.mode==='ssr-spa'||modeInfo.mode==='hash-spa')){
      window.__ftc._spa=true;
      patchHistory();
      console.log('%c  ▶ SPA 路由監聽已啟動（切換頁面自動重掃）',S.cyan);
    }
    console.log('%c  ▶ AJAX 攔截器已啟動 (XHR + fetch)  |  MutationObserver 監視中',S.tag_ajax);
    console.log('%c  指令: __ftc.check("pageId") | __ftc.ajax() | __ftc.scan() | __ftc.stop()',S.dim);
    hr();
  });
}

/* ═══════════════════════════════════════════════
   公開 API
═══════════════════════════════════════════════ */
window.__ftc={
  _spa:false,
  run:runMain,
  check:function(id){runCheck(id);},
  ajax:function(){console.table(_ajaxLog);},
  scan:scanDOM,
  source:function(){fetchSourceIds().then(function(s){console.log('IDs:',s.ids);console.log('Classes:',s.classes);});},
  pages:function(){console.table(PG.map(function(p){return{id:p.id,label:p.label,rootSel:p.rootSel};}));},
  stop:function(){
    _mo.disconnect();
    XMLHttpRequest.prototype.open=_XHROpen;
    XMLHttpRequest.prototype.send=_XHRSend;
    window.fetch=_origFetch;
    delete window.__ftc;
    console.log('%c[FunTech] 所有攔截器已停止','color:#7880a0;');
  },
  destroy:function(){this.stop&&this.stop();}
};

runMain(false);
})();`;
}

/* ─────────────────────────────────────────────────
   UI
───────────────────────────────────────────────── */
let cur = 0;
function esc(s){return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');}

function renderBtns(){
  document.getElementById('page-btns').innerHTML = PAGES.map((p,i)=>{
    const n = p.groups.flatMap(g=>g.items).length;
    return `<div class="page-btn${i===cur?' active':''}" onclick="setPage(${i})">
      <span>${p.emoji} ${p.label}</span><span class="cnt">${n}</span></div>`;
  }).join('');
}

function renderMain(){
  const p = PAGES[cur];
  const all = p.groups.flatMap(g=>g.items);
  const cond = all.filter(i=>i.cond).length;
  let html = `
  <div class="page-header">
    <div style="font-size:22px">${p.emoji}</div>
    <div><div class="page-title">${p.label}</div><div class="page-info">${p.info}</div></div>
  </div>
  <div class="stats-row">
    <div class="stat b"><span class="n">${all.length}</span><span>selectors</span></div>
    <div class="stat g"><span class="n">${all.length-cond}</span><span>必要</span></div>
    <div class="stat y"><span class="n">${cond}</span><span>條件顯示</span></div>
  </div>`;

  p.groups.forEach(g=>{
    html += `<div class="group"><div class="group-title">${g.title} <span style="color:var(--dim);font-weight:400;font-size:9px">${g.items.length} items</span></div>`;
    g.items.forEach(i=>{
      html += `<div class="item">
        <div class="dot ${i.cond?'cond':'req'}" title="${i.cond?'條件顯示':'必要'}"></div>
        <div style="flex:1">
          <div><span class="sel">${esc(i.sel)}</span>${i.cond?`<span class="cbadge">${i.cond}</span>`:''}</div>
          <div class="note">${i.note}</div>
        </div>
      </div>`;
    });
    html += '</div>';
  });

  html += `<div class="feature-box">
    <div class="ftitle">智慧腳本運作機制</div>
    <div class="feature-row">
      <span class="badge badge-src">原始碼掃描</span>
      <span class="feature-desc">fetch() 當前 URL → DOMParser 解析 HTML → 比對靜態 ID/class，找出「原始碼有但 DOM 沒有」或「DOM 有但原始碼沒有（AJAX動態插入）」的差異</span>
    </div>
    <div class="feature-row">
      <span class="badge badge-ajax">AJAX 攔截</span>
      <span class="feature-desc">Monkey-patch XMLHttpRequest.open/send 及 window.fetch，記錄所有 API 請求 URL / status / 耗時，請求完成後觸發重掃</span>
    </div>
    <div class="feature-row">
      <span class="badge badge-mut">DOM 監聽</span>
      <span class="feature-desc">MutationObserver 監視整個 document，childList + subtree 異動時 debounce 500ms 後重新執行 selector 檢查</span>
    </div>
    <div class="feature-row">
      <span class="badge badge-spa">路由監聽</span>
      <span class="feature-desc">SPA 模式下攔截 history.pushState / replaceState / popstate / hashchange，頁面切換後自動重新偵測頁面並掃描</span>
    </div>
    <div class="feature-row">
      <span class="badge badge-mode">頁面辨識</span>
      <span class="feature-desc">DOM 根容器優先 → URL pattern fallback；#profile-page 進一步以 a.new-post-link 區分「自己/他人」頁面</span>
    </div>
  </div>`;

  document.getElementById('main').innerHTML = html;
}

function setPage(i){cur=i;renderBtns();renderMain();}

function showFb(msg){
  const el=document.getElementById('fb');
  el.textContent=msg;el.className='feedback show';
  setTimeout(()=>el.className='feedback',2200);
}

function copySmartScript(){
  navigator.clipboard.writeText(buildSmartScript()).then(()=>{
    showFb('✓ 智慧腳本已複製，貼到 F12 Console 執行');
    const btn=document.getElementById('smartBtn');
    btn.classList.add('ok');btn.textContent='✓ 已複製！';
    setTimeout(()=>{btn.classList.remove('ok');btn.textContent='🧠 複製智慧腳本 (完整版)';},2500);
  });
}

function copyPageScript(){
  const p=PAGES[cur];
  const items=p.groups.flatMap(g=>g.items.map(i=>({...i,group:g.title})));
  const s=`(function(){var items=${JSON.stringify(items)};var pass=0,fail=[];console.log('%c[FunTech] ${p.label}','font-size:13px;font-weight:700;color:#38bdf8;');items.forEach(function(i){var ok=!!document.querySelector(i.sel);ok?pass++:fail.push(i);console.log((ok?'✅':'❌')+' '+i.sel+'  '+i.note+(i.cond?' ['+i.cond+']':''));});if(fail.length===0){console.log('%c全部通過','color:#3dd68c;font-weight:700;');}else{console.log('%c缺少 '+fail.length+' 個:','color:#f06464;font-weight:700;');fail.forEach(function(f){console.log('  ✗ '+f.sel);});}})();`;
  navigator.clipboard.writeText(s).then(()=>showFb(`✓ ${p.label} 腳本已複製`));
}

renderBtns();
renderMain();
</script>
</body>
</html>