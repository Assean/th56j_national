#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
FunTech 選手器自動檢測工具 v6
第 56 屆全國技能競賽 · 網頁技術

v6 新增（基於 v5_fix）：
  - 確實導覽至使用者選定的檢查頁面
  - 若直接開啟失敗或頁面為空：
      * 文章內容頁 (#article) → 嘗試從首頁點擊
        a.article-readmore 連結進入
      * 其他頁面 → 嘗試從首頁點擊對應導覽連結
        （home-link / games-link / friends-link / profile-link）
  - 若所有導覽方式皆失敗 → 該區塊標記為「不予計分 / 系統錯誤」，
    所有 selector 顯示為 [NOSCORE]，不計入必填缺少分數，
    但在報告中明確列出原因
  - 保留 v5_fix 全部修正（編碼、型別、msvcrt、資料夾排除）
"""

import sys, re, time, os
from datetime import datetime
from pathlib import Path
from typing import List, Dict, Optional

# ── 強制 UTF-8 輸出 ──────────────────────────────────────
if sys.stdout.encoding and sys.stdout.encoding.lower() not in ("utf-8","utf8"):
    sys.stdout.reconfigure(encoding="utf-8", errors="replace")
if sys.stderr.encoding and sys.stderr.encoding.lower() not in ("utf-8","utf8"):
    sys.stderr.reconfigure(encoding="utf-8", errors="replace")

# ── Python 版本檢查（List[str] 等寫法需 3.8+，msvcrt 用法需確認）──
if sys.version_info < (3, 8):
    print("\n  [X] 需要 Python 3.8 以上版本，請升級 Python\n")
    sys.exit(1)

# ── 套件檢查 ─────────────────────────────────────────────
def check_deps():
    missing = []
    for pkg, imp in [("selenium","selenium"),("webdriver-manager","webdriver_manager")]:
        try: __import__(imp)
        except ImportError: missing.append(pkg)
    if missing:
        print(f"\n  [X] 缺少套件，請先執行：pip install {' '.join(missing)}\n")
        sys.exit(1)

check_deps()

# ── msvcrt 必須在 check_deps() 之後 import（避免非 Windows 環境提早炸掉）──
try:
    import msvcrt
    IS_WINDOWS = True
except ImportError:
    IS_WINDOWS = False
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.common.exceptions import NoSuchElementException, WebDriverException, JavascriptException
from webdriver_manager.chrome import ChromeDriverManager

# ── ANSI 顏色 ────────────────────────────────────────────
GREEN   = "\033[92m"
RED     = "\033[91m"
YELLOW  = "\033[93m"
CYAN    = "\033[96m"
BLUE    = "\033[94m"
MAGENTA = "\033[95m"
BOLD    = "\033[1m"
DIM     = "\033[2m"
RESET   = "\033[0m"
BG_SEL  = "\033[44m"   # 藍底（選中項目）

def ok(msg):   print(f"  {GREEN}[OK]{RESET}  {msg}")
def fail(msg): print(f"  {RED}[X]{RESET}   {msg}")
def warn(msg): print(f"  {YELLOW}[!]{RESET}   {msg}")
def info(msg): print(f"  {CYAN}[i]{RESET}   {msg}")
def head(msg): print(f"\n{BOLD}{BLUE}{'='*62}{RESET}\n{BOLD}  {msg}{RESET}\n{BLUE}{'='*62}{RESET}")
def sub(msg):  print(f"\n{MAGENTA}  >> {msg}{RESET}")
def sep():     print(f"  {DIM}{'-'*56}{RESET}")

# ── 常數 ─────────────────────────────────────────────────
MAX_RETRY   = 5
CHECK_DELAY = 1

# ── 頁面類型定義（供使用者選擇對應檔案）────────────────────
# key       = section 群組 key
# label     = 顯示給使用者的名稱
# sections  = 對應 SPEC 裡的 section 名稱列表
# query_key = 選好後存入 page_map 的 key（路徑）
PAGE_TYPES = [
    {
        "key":       "home",
        "label":     "首頁（含未登入/已登入狀態）",
        "sections":  ["首頁 (#home)", "首頁 未登入狀態", "首頁 已登入狀態"],
        "query_key": "home",
        "required":  True,
    },
    {
        "key":       "article",
        "label":     "文章內容頁",
        "sections":  ["文章內容頁 (#article)"],
        "query_key": "article",
        "required":  True,
    },
    {
        "key":       "profile",
        "label":     "個人頁面（含已登入自己的頁面）",
        "sections":  ["個人頁面 (#profile-page)", "個人頁面 自己（已登入）"],
        "query_key": "profile",
        "required":  True,
    },
    {
        "key":       "login",
        "label":     "登入頁面",
        "sections":  ["登入頁面"],
        "query_key": "login",
        "required":  True,
    },
    {
        "key":       "register",
        "label":     "註冊頁面",
        "sections":  ["註冊頁面"],
        "query_key": "register",
        "required":  True,
    },
    {
        "key":       "friends",
        "label":     "好友頁面",
        "sections":  ["好友頁面 (#friends-page)"],
        "query_key": "friends",
        "required":  True,
    },
    {
        "key":       "games",
        "label":     "遊戲列表頁",
        "sections":  ["遊戲列表頁 (#games)"],
        "query_key": "games",
        "required":  True,
    },
    {
        "key":       "game_play",
        "label":     "遊戲內容頁（單一遊戲頁）",
        "sections":  ["遊戲內容頁 (#game-play)"],
        "query_key": "game_play",
        "required":  False,
    },
]

# ── 導覽容錯：當直接開啟頁面失敗時，嘗試從首頁點擊對應連結進入 ──
# key   = page_key
# value = 嘗試點擊的 selector 列表（依序嘗試），找到第一個存在的就點擊
PAGE_NAV_FALLBACK = {
    "article":   [".article-item a.article-readmore", "a.article-readmore"],
    "profile":   [".user-area a.profile-link", "a.profile-link"],
    "games":     [".site-header nav.main-nav a.games-link", "a.games-link"],
    "game_play": [".game-item a.play-game-link", "a.play-game-link"],
    "friends":   [".site-header nav.main-nav a.friends-link", "a.friends-link"],
    "login":     [".user-area a.login-link", "a.login-link"],
    "register":  [".user-area a.register-link", "a.register-link"],
    "home":      [".site-header nav.main-nav a.home-link", "a.home-link"],
}

# ── SPEC ─────────────────────────────────────────────────
SPEC = {
    "首頁 (#home)": {
        "page_key": "home",
        "login_state": "any",
        "checks": [
            ("#home",                                     "首頁根容器",         False),
            ("header.site-header",                        "頁首導覽列",         False),
            (".site-header .brand a.brand-link",          "Logo 連結",         False),
            (".site-header nav.main-nav",                 "主導覽列容器",        False),
            (".site-header nav.main-nav a.home-link",     "首頁連結",           False),
            (".site-header nav.main-nav a.games-link",    "遊戲連結",           False),
            (".site-header nav.main-nav a.friends-link",  "好友連結",           False),
            (".site-header .user-area",                   "使用者區域",         False),
            ("section.articles",                          "文章列表區塊",        False),
            ("section.articles article.article-item",     "文章項目（至少1筆）", False),
            (".article-item .article-title",              "文章標題",           False),
            (".article-item time.article-date",           "文章發佈日期",        False),
            (".article-item .article-excerpt",            "文章摘要",           False),
            (".article-item a.article-readmore",          "閱讀更多連結",        False),
            ("aside.notifications",                       "通知/公告區塊",       False),
            ("aside.notifications .notification-item",    "通知項目（至少1筆）", False),
            (".notification-item .notification-title",    "通知標題",           False),
            (".notification-item time.notification-date", "通知日期",           False),
        ]
    },
    "首頁 未登入狀態": {
        "page_key": "home",
        "login_state": "guest",
        "checks": [
            (".user-area a.login-link",    "登入連結（未登入）", False),
            (".user-area a.register-link", "註冊連結（未登入）", False),
        ]
    },
    "首頁 已登入狀態": {
        "page_key": "home",
        "login_state": "logged",
        "checks": [
            (".user-area .user-badge",    "使用者名稱/頭像（已登入）", False),
            (".user-area a.profile-link", "個人頁面入口（已登入）",    False),
            (".user-area a.logout-link",  "登出按鈕（已登入）",       False),
        ]
    },
    "文章內容頁 (#article)": {
        "page_key": "article",
        "login_state": "any",
        "checks": [
            ("#article",                          "文章內容頁根容器", False),
            ("#article header.article-header",    "文章標題區塊",    False),
            (".article-header h1.article-title",  "文章標題 h1",    False),
            (".article-header time.article-date", "文章發布日期",    False),
            ("#article section.article-body",     "文章內容區塊",    False),
        ]
    },
    "個人頁面 (#profile-page)": {
        "page_key": "profile",
        "login_state": "any",
        "checks": [
            ("#profile-page",                            "個人頁面根容器",        False),
            ("section.profile-header",                   "使用者資訊區",          False),
            (".profile-header img.profile-avatar",       "使用者頭像",            False),
            (".profile-header .profile-username",        "使用者名稱",            False),
            (".profile-header .profile-bio",             "簡介文字",              False),
            ("section.profile-articles",                 "使用者文章區",          False),
            (".profile-articles .article-item",          "文章項目",              True),
            (".article-item .article-title",             "文章標題",              True),
            (".article-item time.article-date",          "發佈日期",              True),
            (".article-item a.article-readmore",         "閱讀文章連結",           True),
            (".profile-articles .empty-article-message", "無文章提示（條件顯示）", True),
        ]
    },
    "個人頁面 自己（已登入）": {
        "page_key": "profile",
        "login_state": "logged",
        "checks": [
            ("a.new-post-link",                                     "發表文章連結",           False),
            ("form.article-create-form",                            "文章發布表單",           False),
            (".article-create-form input.article-title-input",      "文章標題輸入",           False),
            (".article-create-form textarea.article-content-input", "文章內容輸入",           False),
            (".article-create-form button.article-submit-button",   "發布按鈕",              False),
            (".profile-header textarea.profile-bio-input",          "簡介編輯欄位（編輯模式）", True),
        ]
    },
    "登入頁面": {
        "page_key": "login",
        "login_state": "guest",
        "checks": [
            ("form.login-form",                       "登入表單容器",  False),
            (".login-form input.username-input",      "帳號輸入欄",   False),
            (".login-form input.password-input",      "密碼輸入欄",   False),
            (".login-form button.login-submit-button","登入送出按鈕", False),
        ]
    },
    "註冊頁面": {
        "page_key": "register",
        "login_state": "guest",
        "checks": [
            ("form.register-form",                         "註冊表單容器",  False),
            (".register-form input.username-input",        "帳號輸入欄",   False),
            (".register-form input.email-input",           "Email 欄位",  False),
            (".register-form input.password-input",        "密碼欄位",    False),
            (".register-form input.password-confirm-input","確認密碼欄位", False),
            (".register-form button.register-submit",      "註冊送出按鈕", False),
        ]
    },
    "好友頁面 (#friends-page)": {
        "page_key": "friends",
        "login_state": "logged",
        "checks": [
            ("#friends-page",                                "好友頁主容器",       False),
            ("#friends-page .friend-search-section",         "搜尋功能區塊",       False),
            ("form.friend-search-form",                      "搜尋表單",          False),
            (".friend-search-form input.search-input",       "搜尋輸入欄",        False),
            (".friend-search-form button.search-submit-button","搜尋按鈕",        False),
            (".friend-search-section .search-result-list",   "搜尋結果列表容器",   False),
            (".search-result-list .search-result-item",      "搜尋結果項目",       True),
            (".search-result-item .result-username",         "結果：使用者名稱",    True),
            (".search-result-item a.view-profile-link",      "結果：個人頁連結",    True),
            ("#friends-page .friend-list-section",           "我的好友列表區塊",   False),
            (".friend-list-section .section-title",          "好友列表標題",       False),
            (".friend-list-section .friend-item",            "好友項目",          True),
            (".friend-item img.friend-avatar",               "好友頭像",          True),
            (".friend-item .friend-name",                    "好友名稱",          True),
            ("#friends-page .incoming-requests-section",     "收到的好友申請區塊", False),
            (".incoming-requests-section .section-title",    "收到申請標題",       False),
            (".incoming-requests-section .request-item",     "申請項目",          True),
            (".request-item img.request-avatar",             "申請者頭像",        True),
            (".request-item .request-username",              "申請者名稱",        True),
            (".request-item button.accept-request-button",   "接受按鈕",          True),
            (".request-item button.reject-request-button",   "拒絕按鈕",          True),
            ("#friends-page .sent-requests-section",         "送出的好友申請區塊", False),
            (".sent-requests-section .section-title",        "送出申請標題",       False),
            (".sent-requests-section .request-item",         "送出申請項目",       True),
            (".request-item button.cancel-request-button",   "取消申請按鈕",       True),
        ]
    },
    "遊戲列表頁 (#games)": {
        "page_key": "games",
        "login_state": "any",
        "checks": [
            ("#games",                      "遊戲列表頁根容器",    False),
            ("#games section.game-list",    "遊戲列表容器",        False),
            (".game-list .game-item",       "遊戲項目（至少1筆）", False),
            (".game-item img.game-cover",   "遊戲封面圖",          False),
            (".game-item .game-title",      "遊戲名稱",            False),
            (".game-item .game-description","遊戲介紹",            False),
            (".game-item a.play-game-link", "開始遊戲連結",        False),
        ]
    },
    "遊戲內容頁 (#game-play)": {
        "page_key": "game_play",
        "login_state": "any",
        "checks": [
            ("#game-play",                           "遊戲內容頁根容器", False),
            ("#game-play .current-game-title",       "目前遊戲名稱",     False),
            ("#game-play section.game-area",         "遊戲區域容器",     False),
            ("section.game-area iframe.game-frame",  "遊戲 iframe",    False),
            ("aside.game-leaderboard",               "排行榜區塊",       False),
            (".game-leaderboard .leaderboard-title", "排行榜標題",       False),
            (".game-leaderboard .leaderboard-item",  "排行榜資料列",     True),
            (".leaderboard-item .player-rank",       "名次欄位",         True),
        ]
    },
}

# ── JS 注入 ──────────────────────────────────────────────
JS_HIGHLIGHT_PASS = """
(function(sel){
    try{
        var els=document.querySelectorAll(sel);
        if(!els.length) return false;
        els.forEach(function(el){
            el.style.outline='3px solid #22c55e';
            el.style.outlineOffset='2px';
            el.style.backgroundColor='rgba(34,197,94,0.08)';
            el.scrollIntoView({block:'center',behavior:'smooth'});
        });
        return true;
    }catch(e){return false;}
})(arguments[0]);
"""

JS_HIGHLIGHT_FAIL = """
(function(sel,desc){
    var old=document.getElementById('__ftcheck_toast__');
    if(old) old.remove();
    var d=document.createElement('div');
    d.id='__ftcheck_toast__';
    d.style.cssText=[
        'position:fixed','bottom:20px','right:20px','z-index:99999',
        'background:#1a0a0a','border:2px solid #ef4444','border-radius:10px',
        'padding:12px 18px','color:#fca5a5','font-family:monospace',
        'font-size:13px','max-width:420px','box-shadow:0 4px 20px rgba(0,0,0,.5)',
        'line-height:1.6'
    ].join(';');
    d.innerHTML='<span style="color:#ef4444;font-weight:bold">[X] 未找到</span><br>'
        +'<span style="color:#f87171">'+desc+'</span><br>'
        +'<code style="color:#94a3b8;font-size:11px">'+sel+'</code>';
    document.body.appendChild(d);
    setTimeout(function(){if(d.parentNode)d.remove();},2800);
    return false;
})(arguments[0],arguments[1]);
"""

JS_SECTION_BANNER = """
(function(title){
    var old=document.getElementById('__ftcheck_banner__');
    if(old) old.remove();
    var d=document.createElement('div');
    d.id='__ftcheck_banner__';
    d.style.cssText=[
        'position:fixed','top:0','left:0','right:0','z-index:99999',
        'background:linear-gradient(135deg,#1e3a5f,#312e81)',
        'color:#e2e8f0','font-family:sans-serif','font-size:14px',
        'font-weight:600','padding:10px 20px','text-align:center',
        'box-shadow:0 2px 12px rgba(0,0,0,.4)'
    ].join(';');
    d.textContent='[FunTech] 檢測中：'+title;
    document.body.appendChild(d);
})(arguments[0]);
"""

JS_CLEAR = """
(function(){
    document.querySelectorAll('[style*="outline"]').forEach(function(el){
        el.style.outline='';el.style.outlineOffset='';el.style.backgroundColor='';
    });
    ['__ftcheck_banner__','__ftcheck_toast__'].forEach(function(id){
        var el=document.getElementById(id);if(el)el.remove();
    });
})();
"""

# ═══════════════════════════════════════════════════════
# 互動式方向鍵選單（Windows msvcrt）
# ═══════════════════════════════════════════════════════

def _arrow_menu_fallback(title: str, options: List[str], skip_label: Optional[str] = None) -> int:
    """非 Windows 環境的備用選單（數字輸入）"""
    print(f"\n  {CYAN}{BOLD}{title}{RESET}")
    for i, opt in enumerate(options):
        print(f"  {DIM}[{i+1}]{RESET} {opt}")
    skip_idx = len(options) - 1 if skip_label else None
    while True:
        try:
            raw = input("  請輸入編號: ").strip()
            n = int(raw) - 1
            if 0 <= n < len(options):
                if skip_label and n == skip_idx:
                    return -1
                return n
            print("  請輸入有效的編號")
        except (ValueError, KeyboardInterrupt):
            return -1

def arrow_menu(title: str, options: List[str], skip_label: Optional[str] = None) -> int:
    """
    用上/下鍵選擇，Enter 確認。
    回傳選中的 index。
    若有 skip_label，最後一項為跳過（回傳 -1）。
    非 Windows 或無法使用 msvcrt 時，自動改用數字輸入備用選單。
    """
    if not IS_WINDOWS:
        return _arrow_menu_fallback(title, options, skip_label)

    if skip_label:
        options = list(options) + [f"[跳過] {skip_label}"]

    # 若選項數量超過終端機高度，方向鍵重繪會錯位，改用數字輸入備用選單
    try:
        term_height = os.get_terminal_size().lines
    except OSError:
        term_height = 24
    if len(options) > max(5, term_height - 6):
        return _arrow_menu_fallback(title, options, skip_label)

    # 避免長檔名造成終端機自動換行，導致游標重繪錯位
    try:
        term_width = os.get_terminal_size().columns
    except OSError:
        term_width = 100
    max_label_len = max(10, term_width - 12)

    def trim(s: str) -> str:
        if len(s) > max_label_len:
            return s[:max_label_len - 3] + "..."
        return s

    display_options = [trim(o) for o in options]

    idx = 0
    total = len(display_options)

    def render():
        # 清除已顯示的選單行（往上移動 total 行重繪）
        sys.stdout.write(f"\033[{total}A")
        for i, opt in enumerate(display_options):
            if i == idx:
                line = f"  {BG_SEL}{BOLD} > {opt} {RESET}"
            else:
                line = f"      {DIM}{opt}{RESET}"
            sys.stdout.write(f"\r\033[K{line}\n")
        sys.stdout.flush()

    # 初次印出所有選項
    print(f"\n  {CYAN}{BOLD}{title}{RESET}")
    print(f"  {DIM}使用 上/下 方向鍵選擇，Enter 確認{RESET}\n")
    for i, opt in enumerate(display_options):
        if i == idx:
            print(f"  {BG_SEL}{BOLD} > {opt} {RESET}")
        else:
            print(f"      {DIM}{opt}{RESET}")
    sys.stdout.flush()

    while True:
        try:
            ch = msvcrt.getch()
        except (OSError, EOFError):
            # 萬一 stdin 無法讀取（例如非互動環境），改用備用選單
            return _arrow_menu_fallback(title, options, skip_label)

        if ch == b'\xe0':          # 方向鍵前綴
            try:
                arrow = msvcrt.getch()
            except (OSError, EOFError):
                continue
            if arrow == b'H':      # 上
                idx = (idx - 1) % total
                render()
            elif arrow == b'P':    # 下
                idx = (idx + 1) % total
                render()
        elif ch == b'\r':          # Enter
            print()
            if skip_label and idx == total - 1:
                return -1
            return idx
        elif ch == b'\x1b':        # ESC → 跳過
            print()
            return -1
        elif ch in (b'\x03',):     # Ctrl+C
            raise KeyboardInterrupt

# ═══════════════════════════════════════════════════════
# 掃描資料夾，列出所有 .php / .html 檔案
# ═══════════════════════════════════════════════════════
def scan_files(root: str) -> List[dict]:
    """
    遞迴掃描 root 目錄，回傳 [{label, url_path}] 排序後的列表。
    自動排除常見的非頁面資料夾（vendor, node_modules, games 子資料夾的資源等），
    避免選單項目過多導致終端機顯示異常。
    """
    EXCLUDE_DIRS = {
        "node_modules", "vendor", ".git", ".vscode", ".idea",
        "assets", "css", "js", "img", "images", "fonts",
        "uploads", "dist", "build", "__pycache__",
    }

    results = []
    root_path = Path(root)
    if not root_path.exists():
        return results

    for f in sorted(root_path.rglob("*")):
        if not f.is_file():
            continue
        if f.suffix.lower() not in (".php", ".html", ".htm"):
            continue

        rel = f.relative_to(root_path)
        # 若路徑中任一層資料夾名稱屬於排除清單，則跳過
        if any(part.lower() in EXCLUDE_DIRS for part in rel.parts[:-1]):
            continue

        url = "/" + str(rel).replace("\\", "/")
        results.append({
            "label": str(rel),
            "url_path": url,
        })

    # 排序：根目錄檔案優先（路徑層級較少的排前面），再依字母排序
    results.sort(key=lambda x: (x["label"].count("/"), x["label"].count("\\"), x["label"]))
    return results

# ═══════════════════════════════════════════════════════
# 讓使用者為每個頁面類型選擇檔案，回傳 page_map
# page_map[page_key] = url_path（例如 "/index.php"）
# ═══════════════════════════════════════════════════════
def select_pages(files: List[dict], base_url: str) -> dict:
    """
    依序為每個 PAGE_TYPES 顯示選單，讓使用者選擇對應的 .php/.html 檔案。
    非必填的頁面可以跳過（回傳 -1）。
    """
    page_map = {}
    file_labels = [f["label"] for f in files]

    head("請選擇各頁面對應的檔案")
    print(f"  {DIM}以下會依序詢問每個頁面的檔案，請用方向鍵選擇後按 Enter{RESET}")

    for pt in PAGE_TYPES:
        skip_label = "此頁面不存在 / 跳過" if not pt["required"] else None
        chosen_idx = arrow_menu(
            title=f"請選擇【{pt['label']}】的檔案",
            options=file_labels,
            skip_label=skip_label,
        )

        if chosen_idx == -1:
            warn(f"跳過：{pt['label']}")
            page_map[pt["query_key"]] = None
        else:
            chosen = files[chosen_idx]
            ok(f"{pt['label']}  =>  {chosen['label']}")
            page_map[pt["query_key"]] = chosen["url_path"]

    return page_map


# ═══════════════════════════════════════════════════════
# Checker
# ═══════════════════════════════════════════════════════
class Checker:
    def __init__(self, base_url: str, station: str, page_map: dict):
        self.base       = base_url.rstrip("/")
        self.station    = station
        self.page_map   = page_map   # page_key -> url_path
        self.ts         = datetime.now().strftime("%Y%m%d_%H%M%S")
        self.logged_in  = False
        self.mode       = "unknown"
        self.driver     = None
        self.total_pass = 0
        self.total_fail = 0
        self.total_warn = 0
        self.total_not_scored = 0
        self._cur_url   = None

    # ── Chrome ───────────────────────────────────────
    def init_driver(self):
        sub("啟動 Chrome 瀏覽器...")
        opts = Options()
        opts.add_argument("--start-maximized")
        opts.add_argument("--disable-infobars")
        opts.add_argument("--disable-extensions")
        try:
            svc = Service(ChromeDriverManager().install())
            self.driver = webdriver.Chrome(service=svc, options=opts)
            ok("Chrome 啟動成功")
        except Exception as e:
            print(f"\n{RED}[X] Chrome 啟動失敗：{e}{RESET}")
            sys.exit(1)

    def quit_driver(self):
        if self.driver:
            try: self.driver.quit()
            except Exception: pass

    def js(self, script, *args):
        try: return self.driver.execute_script(script, *args)
        except Exception: return None

    def _find_el(self, sel):
        try: return self.driver.find_element(By.CSS_SELECTOR, sel)
        except NoSuchElementException: return None

    # ── 導覽 ────────────────────────────────────────
    def navigate(self, path: str, force: bool = False) -> bool:
        url = self.base + path
        if not force and url == self._cur_url:
            return True
        try:
            self.driver.get(url)
            self._cur_url = url
            time.sleep(0.7)
            return True
        except WebDriverException:
            return False

    def _page_has_content(self, min_len: int = 10) -> bool:
        """檢查目前頁面 body 文字長度，避免空白頁/404 被誤判為成功"""
        try:
            body_text = self.driver.find_element(By.TAG_NAME, "body").text
            return len(body_text.strip()) >= min_len
        except Exception:
            return False

    def _click_first_existing(self, selectors: list) -> bool:
        """依序嘗試點擊第一個存在的 selector，成功回傳 True"""
        for sel in selectors:
            try:
                els = self.driver.find_elements(By.CSS_SELECTOR, sel)
                if els:
                    self.driver.execute_script(
                        "arguments[0].scrollIntoView({block:'center'});", els[0])
                    time.sleep(0.2)
                    els[0].click()
                    time.sleep(0.8)
                    self._cur_url = self.driver.current_url
                    return True
            except Exception:
                continue
        return False

    def navigate_to_page(self, page_key: str, full_path: str) -> tuple:
        """
        確實導覽至檢查頁面，回傳 (success: bool, method: str, reason: str)
        method: "direct" | "link" | "failed"

        流程：
          1. 直接開啟使用者選定的檔案路徑
          2. 若失敗或頁面內容過少 →
             回到首頁，依 PAGE_NAV_FALLBACK 尋找對應連結並點擊
          3. 點擊後再次檢查頁面內容
          4. 兩種方式皆失敗 → (False, "failed", 原因說明)
        """
        # 方式 1：直接導覽
        self._cur_url = None
        direct_ok = self.navigate(full_path)
        if direct_ok and self._page_has_content():
            return True, "direct", ""

        # 方式 2：從首頁點擊對應連結進入
        fallback_sels = PAGE_NAV_FALLBACK.get(page_key)
        if fallback_sels:
            home_path = self.page_map.get("home") or "/index.php"
            self._cur_url = None
            if self.navigate(home_path, force=True):
                if self._click_first_existing(fallback_sels):
                    if self._page_has_content():
                        return True, "link", ""
                    else:
                        return False, "failed", (
                            f"已點擊連結 {fallback_sels[0]} 進入頁面，"
                            f"但頁面內容為空或無法載入"
                        )
                else:
                    return False, "failed", (
                        f"直接開啟 {full_path} 失敗，"
                        f"且首頁找不到對應連結（嘗試過：{', '.join(fallback_sels)}）"
                    )
            else:
                return False, "failed", "直接開啟頁面失敗，且首頁本身無法開啟"

        # 沒有定義 fallback，且直接開啟失敗
        return False, "failed", f"無法開啟頁面：{full_path}（且此頁面類型無備用導覽方式）"

    # ── 登入（使用使用者選好的 login 頁面）─────────
    def login(self, username="admin", password="1234"):
        sub("嘗試自動登入...")
        login_path = self.page_map.get("login") or "/login.php"
        if not self.navigate(login_path):
            warn("登入頁面無法開啟，跳過登入")
            return
        try:
            u_el = self._find_el("input.username-input") or self._find_el("input[type='text']")
            p_el = self._find_el("input.password-input") or self._find_el("input[type='password']")
            btn  = (self._find_el("button.login-submit-button") or
                    self._find_el("button[type='submit']") or
                    self._find_el("input[type='submit']"))
            if not (u_el and p_el and btn):
                warn("找不到登入表單欄位，跳過登入")
                return
            u_el.clear(); u_el.send_keys(username)
            p_el.clear(); p_el.send_keys(password)
            btn.click()
            time.sleep(1.2)
            # 導回首頁確認
            home_path = self.page_map.get("home") or "/index.php"
            self.navigate(home_path, force=True)
            if self._find_el(".user-badge") or self._find_el("a.logout-link"):
                ok(f"登入成功（帳號：{username}）")
                self.logged_in = True
                self._cur_url = None
                return
        except Exception:
            pass
        warn("自動登入失敗，已登入頁面改以訪客狀態請求")

    # ── 載入模式偵測 ─────────────────────────────────
    def detect_mode(self):
        sub("偵測網站載入模式...")
        home_path = self.page_map.get("home") or "/index.php"
        self.navigate(home_path)
        try:
            src = self.driver.page_source
        except Exception:
            return "unknown"
        ajax_hits = sum(1 for p in [
            r'\$\.load\s*\(', r'\$\.ajax\s*\(', r'fetch\s*\(',
            r'axios\.', r'XMLHttpRequest', r'history\.pushState',
        ] if re.search(p, src, re.I))
        if re.search(r'createApp|v-if|v-for|Vue\.component', src, re.I):
            info("偵測到 Vue.js SPA"); return "vue"
        if re.search(r'ReactDOM|createRoot|useState', src, re.I):
            info("偵測到 React SPA"); return "react"
        if ajax_hits >= 3:
            info(f"偵測到 AJAX/fetch（命中 {ajax_hits}）"); return "ajax"
        if ajax_hits >= 1:
            info(f"少量 AJAX（命中 {ajax_hits}），判定混合"); return "mixed"
        info("判定為純 PHP 多頁（MPA）"); return "php"

    # ── 單一 selector 檢查 ───────────────────────────
    def check_one(self, sel: str, desc: str, optional: bool, section_name: str) -> bool:
        time.sleep(CHECK_DELAY)
        try:
            found = len(self.driver.find_elements(By.CSS_SELECTOR, sel)) > 0
        except Exception:
            found = False

        if found:
            self.js(JS_HIGHLIGHT_PASS, sel)
            ok(f"{desc}")
        else:
            self.js(JS_HIGHLIGHT_FAIL, sel, desc)
            if optional:
                warn(f"{desc}  {DIM}[選填]{RESET}")
            else:
                fail(f"{desc}")
        print(f"     {DIM}{sel}{RESET}")
        return found

    # ── 一輪掃描 ────────────────────────────────────
    def scan_once(self, checks: list, section_name: str) -> list:
        self.js(JS_SECTION_BANNER, section_name)
        results = []
        for sel, desc, optional in checks:
            found = self.check_one(sel, desc, optional, section_name)
            results.append({"sel": sel, "desc": desc, "optional": optional, "pass": found})
        return results

    # ── Section 帶重試 ───────────────────────────────
    def run_section(self, section_name: str, spec: dict) -> dict:
        """
        回傳 {"results": [...], "not_scored_reason": str|None}
        若導覽失敗（直接開啟 + 連結點擊皆失敗），
        results 中每個項目標記 not_scored=True，
        not_scored_reason 說明原因（用於報告中顯示「不予計分 / 系統錯誤」）。
        """
        login_state = spec["login_state"]
        page_key    = spec["page_key"]
        checks      = spec["checks"]

        state_label = {"any": "任意", "guest": "未登入", "logged": "已登入"}
        info(f"登入狀態：【{state_label.get(login_state, login_state)}】")

        # 取使用者選好的路徑
        page_path = self.page_map.get(page_key)
        if not page_path:
            reason = f"使用者未選擇此頁面（{page_key}）對應的檔案"
            warn(f"{reason} → 不予計分")
            return {
                "results": [{"sel": s, "desc": d, "optional": o,
                             "pass": False, "not_scored": True}
                            for s, d, o in checks],
                "not_scored_reason": reason,
            }

        # 已登入狀態：用 logged session；未登入：需確保沒有 session（先清 cookie）
        if login_state == "guest" and self.logged_in:
            try:
                self.driver.delete_all_cookies()
                self._cur_url = None
                info("已清除 Cookie 模擬未登入狀態")
            except Exception:
                pass
        elif login_state == "logged" and not self.logged_in:
            warn("（登入失敗，改用訪客狀態）")

        # 加上 query 參數讓有內容的頁面能載入（article/profile 帶 id=1）
        extra_qs = ""
        if page_key in ("article", "profile") and "?" not in page_path:
            extra_qs = "?id=1"
        full_path = page_path + extra_qs

        # ── 確實導覽至檢查頁面（含容錯）────────────────
        sub(f"導覽至檢查頁面：{full_path}")
        nav_ok, nav_method, nav_reason = self.navigate_to_page(page_key, full_path)

        if not nav_ok:
            fail(f"無法導覽至此頁面 → 不予計分 / 系統錯誤")
            info(f"原因：{nav_reason}")
            return {
                "results": [{"sel": s, "desc": d, "optional": o,
                             "pass": False, "not_scored": True}
                            for s, d, o in checks],
                "not_scored_reason": nav_reason,
            }

        if nav_method == "direct":
            ok(f"頁面開啟成功（直接導覽）：{full_path}")
        else:
            ok(f"頁面開啟成功（透過連結點擊進入）：{self.driver.current_url}")
            info(f"提示：直接開啟 {full_path} 未成功，"
                 f"已改由首頁點擊對應連結進入")

        last_results = None

        for attempt in range(1, MAX_RETRY + 1):
            if attempt == 1:
                pending = checks
            else:
                failed_sels = {r["sel"] for r in last_results
                               if not r["pass"] and not r["optional"]}
                pending = [c for c in checks if c[0] in failed_sels]
                if not pending:
                    break

            sep()
            label = f"第 {attempt} 次掃描"
            if attempt > 1:
                label += f"（重試，{len(pending)} 項未通過）"
                # 重試時重新導覽（確保用同一種成功過的方式）
                nav_ok2, _, _ = self.navigate_to_page(page_key, full_path)
                if not nav_ok2:
                    warn("重試時導覽失敗，沿用目前頁面內容繼續檢查")
                time.sleep(0.5)

            print(f"  {BOLD}{CYAN}[ {label} / 最多 {MAX_RETRY} 次 ]{RESET}")
            sep()

            round_results = self.scan_once(pending, section_name)

            if last_results is None:
                last_results = [{**r, "not_scored": False} for r in round_results]
            else:
                updated = {r["sel"]: r for r in round_results}
                for r in last_results:
                    if r["sel"] in updated:
                        r["pass"] = updated[r["sel"]]["pass"]

            req_fail = [r for r in last_results if not r["pass"] and not r["optional"]]
            if not req_fail:
                self.js(JS_CLEAR)
                print(f"\n  {GREEN}{BOLD}[OK] 全部必填通過，不再重試{RESET}")
                break
            else:
                if attempt < MAX_RETRY:
                    print(f"\n  {YELLOW}尚有 {len(req_fail)} 項未通過，"
                          f"準備第 {attempt+1} 次重試...{RESET}")
                else:
                    print(f"\n  {RED}已達最大重試次數（{MAX_RETRY}），繼續下一區塊{RESET}")

        self.js(JS_CLEAR)

        # 如果剛才清了 cookie 模擬訪客，掃完後重新登入
        if login_state == "guest" and self.logged_in:
            self.login()

        return {"results": last_results, "not_scored_reason": None}


    # ── 主流程 ───────────────────────────────────────
    def run(self):
        head("FunTech 選手器自動檢測工具  v6 - 開始檢測")
        print(f"  站台：{BOLD}{self.base}{RESET}   崗位：{BOLD}{self.station}{RESET}")
        print(f"  時間：{self.ts}   每項延遲：{CHECK_DELAY}s   最大重試：{MAX_RETRY}次")

        self.init_driver()

        sub("連線測試...")
        home_path = self.page_map.get("home") or "/index.php"
        try:
            self.driver.get(self.base + home_path)
            time.sleep(0.8)
            ok(f"連線成功：{self.driver.current_url}")
        except WebDriverException:
            print(f"\n{RED}[X] 無法連線，請確認 XAMPP 已啟動{RESET}\n")
            self.quit_driver()
            sys.exit(1)

        self.mode = self.detect_mode()
        self.login()

        all_sections = []
        try:
            for section_name, spec in SPEC.items():
                head(section_name)
                section_result = self.run_section(section_name, spec)
                all_sections.append({
                    "name": section_name,
                    "results": section_result["results"],
                    "not_scored_reason": section_result["not_scored_reason"],
                })
        except KeyboardInterrupt:
            print(f"\n{YELLOW}[!] 使用者中斷，產生目前結果報告...{RESET}")
        finally:
            self.quit_driver()

        for sec in all_sections:
            for r in sec["results"]:
                if r.get("not_scored"):
                    self.total_not_scored += 1
                elif r["pass"]:
                    self.total_pass += 1
                elif r["optional"]:
                    self.total_warn += 1
                else:
                    self.total_fail += 1

        self.print_summary(all_sections)
        self.export_md(all_sections)
        html_path = self.export_html(all_sections)

        import webbrowser
        try:
            webbrowser.open(Path(html_path).resolve().as_uri())
            info("[Web] 已自動開啟 HTML 報告")
        except Exception:
            pass

    # ── 終端機總結 ──────────────────────────────────
    def print_summary(self, all_sections):
        head("檢測總結")
        req_total = self.total_pass + self.total_fail
        rate = round(self.total_pass / max(1, req_total) * 100)
        print(f"  載入模式：{BOLD}{self.mode.upper()}{RESET}")
        print(f"  必填通過：{GREEN}{BOLD}{self.total_pass}{RESET} / {req_total}")
        print(f"  選填缺少：{YELLOW}{self.total_warn}{RESET}")
        print(f"  必填缺少：{RED}{self.total_fail}{RESET}")
        if self.total_not_scored:
            print(f"  不予計分：{MAGENTA}{self.total_not_scored}{RESET}  {DIM}(系統錯誤/無法導覽，已排除於通過率計算){RESET}")
        print(f"  通過率：  {BOLD}{rate}%{RESET}")

        # 不予計分的區塊（系統錯誤）
        noscore_secs = [s for s in all_sections if s.get("not_scored_reason")]
        if noscore_secs:
            sub(f"以下區塊不予計分（系統錯誤，共 {len(noscore_secs)} 個區塊）")
            for s in noscore_secs:
                print(f"  {MAGENTA}[!]{RESET}  [{s['name']}]")
                print(f"     {DIM}原因：{s['not_scored_reason']}{RESET}")

        fails = [(s["name"], r["sel"], r["desc"])
                 for s in all_sections for r in s["results"]
                 if not r["pass"] and not r["optional"] and not r.get("not_scored")]
        if fails:
            sub(f"仍缺少的必填 selector（共 {len(fails)} 項）")
            for sname, sel, desc in fails:
                print(f"  {RED}[X]{RESET}  [{sname}]  {desc}")
                print(f"     {DIM}{sel}{RESET}")
        elif not noscore_secs:
            print(f"\n  {GREEN}{BOLD}[PASS] 所有必填 selector 均已通過！{RESET}")
        else:
            print(f"\n  {GREEN}{BOLD}[PASS] 其餘必填 selector 均已通過！{RESET}")

    # ── Markdown ────────────────────────────────────
    def export_md(self, all_sections) -> str:
        req_total = self.total_pass + self.total_fail
        rate = round(self.total_pass / max(1, req_total) * 100)
        fname = f"funtech_result_{self.station}_{self.ts}.md"
        lines = [
            "# FunTech 選手器自動檢測報告", "",
            "| 項目 | 內容 |", "|------|------|",
            f"| 崗位 | {self.station} |",
            f"| 網址 | {self.base} |",
            f"| 載入模式 | {self.mode.upper()} |",
            f"| 檢測時間 | {self.ts} |",
            f"| 必填通過 | {self.total_pass} / {req_total} |",
            f"| 選填缺少 | {self.total_warn} |",
            f"| 必填缺少 | {self.total_fail} |",
            f"| 不予計分 | {self.total_not_scored} |",
            f"| 通過率 | {rate}% |", "",
            "## 頁面對應檔案", "",
        ]
        for pt in PAGE_TYPES:
            p = self.page_map.get(pt["query_key"]) or "（跳過）"
            lines.append(f"| {pt['label']} | `{p}` |")
        lines.append("")

        for sec in all_sections:
            title = sec['name']
            if sec.get("not_scored_reason"):
                title += "  [不予計分 / 系統錯誤]"
            lines += [f"## {title}", ""]
            if sec.get("not_scored_reason"):
                lines += [f"> **不予計分原因：** {sec['not_scored_reason']}", ""]
            lines += ["| 狀態 | 說明 | Selector | 類型 |",
                      "|:----:|------|----------|:----:|"]
            for r in sec["results"]:
                if r.get("not_scored"):
                    icon, kind = "[NOSCORE]", "不予計分"
                elif r["pass"]:
                    icon, kind = "[OK]", ("選填" if r["optional"] else "必填")
                else:
                    icon, kind = ("[opt]" if r["optional"] else "[X]"), \
                                  ("選填" if r["optional"] else "必填")
                lines.append(f"| {icon} | {r['desc']} | `{r['sel']}` | {kind} |")
            lines.append("")

        # 不予計分區塊總覽
        noscore_secs = [s for s in all_sections if s.get("not_scored_reason")]
        if noscore_secs:
            lines += [f"## [!] 不予計分區塊（共 {len(noscore_secs)} 個，系統錯誤）", ""]
            for s in noscore_secs:
                lines += [f"- **[{s['name']}]**", f"  - 原因：{s['not_scored_reason']}"]
            lines.append("")

        fails = [(s["name"], r["sel"], r["desc"])
                 for s in all_sections for r in s["results"]
                 if not r["pass"] and not r["optional"] and not r.get("not_scored")]
        if fails:
            lines += [f"## [X] 仍缺少的必填項目（{len(fails)} 項）", ""]
            for sname, sel, desc in fails:
                lines += [f"- **[{sname}]** {desc}  ", f"  `{sel}`"]
        else:
            lines += ["## [PASS] 其餘必填 selector 均已通過！", ""]

        with open(fname, "w", encoding="utf-8") as f:
            f.write("\n".join(lines))
        print(f"\n  {CYAN}[MD] Markdown 報告：{fname}{RESET}")
        return fname

    # ── HTML ────────────────────────────────────────
    def export_html(self, all_sections) -> str:
        req_total = self.total_pass + self.total_fail
        rate = round(self.total_pass / max(1, req_total) * 100)
        rc = "#22c55e" if rate >= 80 else "#f59e0b" if rate >= 50 else "#ef4444"
        fname = f"funtech_result_{self.station}_{self.ts}.html"

        def esc(s): return s.replace("&","&amp;").replace("<","&lt;").replace(">","&gt;")

        page_map_rows = "".join(
            f"<tr><td>{esc(pt['label'])}</td>"
            f"<td><code>{esc(self.page_map.get(pt['query_key']) or '（跳過）')}</code></td></tr>"
            for pt in PAGE_TYPES
        )

        secs_html = ""
        for sec in all_sections:
            not_scored_reason = sec.get("not_scored_reason")
            p  = sum(1 for r in sec["results"] if r["pass"] and not r.get("not_scored"))
            f_ = sum(1 for r in sec["results"] if not r["pass"] and not r["optional"] and not r.get("not_scored"))
            w  = sum(1 for r in sec["results"] if not r["pass"] and r["optional"] and not r.get("not_scored"))
            ns = sum(1 for r in sec["results"] if r.get("not_scored"))
            rows = ""
            for r in sec["results"]:
                if r.get("not_scored"):
                    icon, cls = "⛔", "noscore"
                elif r["pass"]:
                    icon, cls = "✅", "pass"
                elif r["optional"]:
                    icon, cls = "🟡", "warn"
                else:
                    icon, cls = "❌", "fail"
                if r.get("not_scored"):
                    kind = "<span class='ns'>不予計分</span>"
                elif r["optional"]:
                    kind = "<span class='opt'>選填</span>"
                else:
                    kind = "<span class='req'>必填</span>"
                rows += (f"<tr class='{cls}'><td class='ic'>{icon}</td>"
                         f"<td>{esc(r['desc'])}</td>"
                         f"<td><code>{esc(r['sel'])}</code></td>"
                         f"<td>{kind}</td></tr>")
            pills = (f"<span class='pill ppass'>{p} 通過</span>"
                     + (f"<span class='pill pfail'>{f_} 缺少</span>" if f_ else "")
                     + (f"<span class='pill pwarn'>{w} 選填缺</span>" if w else "")
                     + (f"<span class='pill pns'>{ns} 不予計分</span>" if ns else ""))
            ih = "⛔" if not_scored_reason else ("❌" if f_ else ("⚠️" if w else "✅"))
            reason_html = (
                f"<div class='ns-reason'><strong>不予計分原因：</strong>{esc(not_scored_reason)}</div>"
                if not_scored_reason else ""
            )
            secs_html += (
                f"<div class='section{' section-ns' if not_scored_reason else ''}'>"
                f"<div class='sec-head'>"
                f"<span class='sec-title'>{ih} {esc(sec['name'])}</span>"
                f"<span class='pills'>{pills}</span></div>"
                f"{reason_html}"
                f"<table><thead><tr><th></th><th>說明</th><th>Selector</th><th>類型</th></tr></thead>"
                f"<tbody>{rows}</tbody></table></div>"
            )

        fails = [(s["name"], r["sel"], r["desc"])
                 for s in all_sections for r in s["results"]
                 if not r["pass"] and not r["optional"] and not r.get("not_scored")]
        fail_block = (
            f"<div class='fail-list'><h2>❌ 仍缺少的必填項目（{len(fails)} 項）</h2>"
            f"<ul>{''.join(f'<li><strong>[{esc(sn)}]</strong> {esc(d)}<br><code>{esc(s)}</code></li>' for sn,s,d in fails)}</ul></div>"
            if fails else
            "<div class='all-pass'>🎉 其餘必填 selector 均已通過！</div>"
        )

        noscore_secs = [s for s in all_sections if s.get("not_scored_reason")]
        noscore_block = ""
        if noscore_secs:
            items = "".join(
                f"<li><strong>[{esc(s['name'])}]</strong><br>"
                f"原因：{esc(s['not_scored_reason'])}</li>"
                for s in noscore_secs)
            noscore_block = (
                f"<div class='noscore-list'><h2>⛔ 不予計分區塊（共 {len(noscore_secs)} 個，系統錯誤）</h2>"
                f"<ul>{items}</ul></div>"
            )

        html = f"""<!DOCTYPE html>
<html lang="zh-TW"><head><meta charset="UTF-8">
<title>FunTech 檢測報告 - {self.station}</title>
<style>
*{{box-sizing:border-box;margin:0;padding:0}}
body{{font-family:'Segoe UI',system-ui,sans-serif;background:#0d0f14;color:#e2e8f0;font-size:14px}}
header{{background:linear-gradient(135deg,#1a1f35,#0f1420);padding:24px 40px;border-bottom:1px solid #2a2f42}}
header h1{{font-size:22px;font-weight:700;background:linear-gradient(90deg,#4f8ef7,#7c3aed);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}}
header p{{color:#64748b;font-size:13px;margin-top:4px}}
.wrap{{max-width:1000px;margin:0 auto;padding:28px 32px}}
.summary{{display:grid;grid-template-columns:repeat(5,1fr);gap:16px;margin-bottom:20px}}
.card{{background:#151820;border:1px solid #2a2f42;border-radius:10px;padding:16px;text-align:center}}
.card .val{{font-size:32px;font-weight:700}}
.card .lbl{{font-size:12px;color:#64748b;margin-top:4px}}
.card.cp .val{{color:#22c55e}}.card.cf .val{{color:#ef4444}}
.card.cw .val{{color:#f59e0b}}.card.cr .val{{color:{rc}}}
.page-map{{background:#151820;border:1px solid #2a2f42;border-radius:10px;
  margin-bottom:20px;overflow:hidden}}
.page-map h3{{background:#1c2030;padding:12px 18px;font-size:13px;
  font-weight:600;color:#64748b;border-bottom:1px solid #2a2f42}}
.page-map table{{width:100%;border-collapse:collapse}}
.page-map td{{padding:8px 18px;border-bottom:1px solid rgba(42,47,66,.5);font-size:13px}}
.page-map tr:last-child td{{border-bottom:none}}
.section{{background:#151820;border:1px solid #2a2f42;border-radius:10px;
  margin-bottom:16px;overflow:hidden}}
.sec-head{{background:#1c2030;padding:14px 18px;display:flex;align-items:center;
  justify-content:space-between;border-bottom:1px solid #2a2f42}}
.sec-title{{font-weight:600;font-size:14px}}
.pills{{display:flex;gap:8px}}
.pill{{font-size:11px;font-weight:700;padding:2px 9px;border-radius:20px}}
.ppass{{background:rgba(34,197,94,.15);color:#22c55e;border:1px solid rgba(34,197,94,.3)}}
.pfail{{background:rgba(239,68,68,.15);color:#ef4444;border:1px solid rgba(239,68,68,.3)}}
.pwarn{{background:rgba(245,158,11,.15);color:#f59e0b;border:1px solid rgba(245,158,11,.3)}}
table{{width:100%;border-collapse:collapse}}
th{{background:#1c2030;padding:9px 14px;text-align:left;font-size:12px;color:#64748b;font-weight:600}}
td{{padding:9px 14px;border-bottom:1px solid rgba(42,47,66,.5);font-size:13px;vertical-align:middle}}
tr:last-child td{{border-bottom:none}}
tr.pass{{background:rgba(34,197,94,.03)}}tr.fail{{background:rgba(239,68,68,.04)}}
tr.warn{{background:rgba(245,158,11,.03)}}
td.ic{{width:36px;text-align:center;font-size:16px}}
code{{font-family:'Cascadia Code','Fira Code',monospace;font-size:12px;
  background:#1c2030;padding:2px 6px;border-radius:4px;color:#93c5fd}}
.req{{background:#1e2438;color:#93c5fd;font-size:11px;padding:2px 7px;border-radius:4px}}
.opt{{background:#2a2010;color:#fcd34d;font-size:11px;padding:2px 7px;border-radius:4px}}
.fail-list{{background:#1a0f0f;border:1px solid rgba(239,68,68,.3);border-radius:10px;
  padding:20px 24px;margin-top:20px}}
.fail-list h2{{color:#ef4444;font-size:15px;margin-bottom:14px}}
.fail-list ul{{list-style:none;display:flex;flex-direction:column;gap:10px}}
.fail-list li{{font-size:13px;line-height:1.7}}
.all-pass{{background:#0f1f12;border:1px solid rgba(34,197,94,.3);border-radius:10px;
  padding:20px 24px;margin-top:20px;color:#22c55e;font-size:16px;font-weight:700;text-align:center}}
.ns{{background:#3b1f4d;color:#d8b4fe;font-size:11px;padding:2px 7px;border-radius:4px}}
.pns{{background:rgba(168,85,247,.15);color:#c084fc;border:1px solid rgba(168,85,247,.3)}}
tr.noscore{{background:rgba(168,85,247,.05)}}
.section-ns{{border-color:rgba(168,85,247,.4)}}
.ns-reason{{background:rgba(168,85,247,.08);border-top:1px solid rgba(168,85,247,.25);
  border-bottom:1px solid rgba(168,85,247,.25);padding:10px 18px;font-size:12.5px;
  color:#d8b4fe}}
.noscore-list{{background:#1f1530;border:1px solid rgba(168,85,247,.35);border-radius:10px;
  padding:20px 24px;margin-top:20px}}
.noscore-list h2{{color:#c084fc;font-size:15px;margin-bottom:14px}}
.noscore-list ul{{list-style:none;display:flex;flex-direction:column;gap:10px}}
.noscore-list li{{font-size:13px;line-height:1.7}}
.card.cn .val{{color:#c084fc}}
</style></head><body>
<header>
  <h1>FunTech 選手器自動檢測報告</h1>
  <p>崗位：{self.station} | 網址：{self.base} | 載入模式：{self.mode.upper()} | 時間：{self.ts}</p>
</header>
<div class='wrap'>
  <div class='summary'>
    <div class='card cp'><div class='val'>{self.total_pass}</div><div class='lbl'>必填通過</div></div>
    <div class='card cf'><div class='val'>{self.total_fail}</div><div class='lbl'>必填缺少</div></div>
    <div class='card cw'><div class='val'>{self.total_warn}</div><div class='lbl'>選填缺少</div></div>
    <div class='card cn'><div class='val'>{self.total_not_scored}</div><div class='lbl'>不予計分</div></div>
    <div class='card cr'><div class='val'>{rate}%</div><div class='lbl'>必填通過率</div></div>
  </div>
  <div class='page-map'>
    <h3>頁面對應檔案</h3>
    <table><tbody>{page_map_rows}</tbody></table>
  </div>
  {secs_html}
  {fail_block}
  {noscore_block}
</div></body></html>"""

        with open(fname, "w", encoding="utf-8") as f:
            f.write(html)
        print(f"  {CYAN}[HTML] HTML 報告：{fname}{RESET}\n")
        return fname


# ═══════════════════════════════════════════════════════
# 入口
# ═══════════════════════════════════════════════════════
def main():
    print(f"\n{BOLD}+{'='*54}+")
    print(f"|   FunTech 選手器自動檢測工具  v6{' '*22}|")
    print(f"|   第 56 屆全國技能競賽 · 網頁技術{' '*20}|")
    print(f"|   Selenium Chrome · 方向鍵選檔 · 每項 {CHECK_DELAY}s · 重試 {MAX_RETRY} 次  |")
    print(f"+{'='*54}+{RESET}\n")

    # Step 1：崗位號
    print(f"  {DIM}提示：只需輸入數字，例如 1 代表 web01，24 代表 web24{RESET}")
    raw = input("  請輸入崗位編號（只輸入數字）: ").strip()
    raw = re.sub(r'^[wW][eE][bB]', '', raw)
    try:
        station_num = f"{int(raw):02d}"
    except ValueError:
        station_num = raw
    station = f"web{station_num}"
    print(f"  → 崗位識別為：{BOLD}{station}{RESET}")

    # Step 2：網址
    default_url = f"http://localhost/{station}"
    print(f"\n  {DIM}範例：http://localhost/web01  或  http://localhost/competition/56J17_N/web24{RESET}")
    raw_url = input(f"  網站根 URL（Enter 使用 {default_url}）: ").strip()
    base_url = raw_url if raw_url else default_url

    # Step 3：掃描本機資料夾
    # 從 URL 反推本機路徑（支援 XAMPP）
    sub("掃描網站檔案目錄...")
    local_root = None

    # 嘗試從 URL 推導本機路徑
    # e.g. http://localhost/competition/56J17_N/web24 → C:\xampp\htdocs\competition\56J17_N\web24
    xampp_candidates = [r"C:\xampp\htdocs", r"C:\Xampp_3\htdocs", r"D:\xampp\htdocs",
                        "/Applications/XAMPP/htdocs", "/opt/lampp/htdocs"]
    url_path_part = re.sub(r'^https?://[^/]+', '', base_url).lstrip("/")

    for htdocs in xampp_candidates:
        candidate = Path(htdocs) / url_path_part.replace("/", os.sep)
        if candidate.exists():
            local_root = str(candidate)
            ok(f"找到本機路徑：{local_root}")
            break

    if not local_root:
        warn("無法自動找到本機路徑，請手動輸入")
        print(f"  {DIM}例如：C:\\Xampp_3\\htdocs\\competition\\56J17_N\\web24{RESET}")
        local_root = input("  請輸入網站本機絕對路徑: ").strip().strip('"')

    files = scan_files(local_root)
    if not files:
        warn(f"在 {local_root} 找不到任何 .php/.html 檔案")
        print("  請確認路徑正確後重新執行\n")
        sys.exit(1)

    info(f"共找到 {len(files)} 個檔案")

    # Step 4：方向鍵選單讓使用者選擇每個頁面的檔案
    page_map = select_pages(files, base_url)

    print(f"\n  {BOLD}崗位：{station}   網址：{base_url}{RESET}")
    print(f"  {BOLD}本機：{local_root}{RESET}\n")
    input(f"  {GREEN}設定完成，按 Enter 啟動 Chrome 開始檢測...{RESET}")

    Checker(base_url, station, page_map).run()


if __name__ == "__main__":
    main()