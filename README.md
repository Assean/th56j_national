# 第 56 屆全國技能競賽 — 網頁技術（J17）
## FunTech 社群網站 · 試題與進度追蹤

> 競賽時間：4 小時（競賽當天可能有 30% 調整）
> 專案名稱：FunTech — 青少年教育娛樂社群平台

---

## 試題總覽

### 模組 1：視覺與網頁介面設計
製作 FunTech 網站的視覺設計，包含：LOGO 標誌、ICON、整體網頁介面。

---

### 模組 2：平台翻新與系統建置

FunTech 平台需重新設計版面與功能架構，共分為以下五個項目：

---

## 項目 1：首頁版面設計與個人頁面功能開發

### 1. 首頁（`#home`）

| # | 需求說明 | CSS Selector | 狀態 |
|---|---------|-------------|------|
| 1.1 | 首頁根容器 | `#home` | ✅ |
| 1.2.1 | 頁首導覽列容器 | `header.site-header` | ✅ |
| 1.2.2.1 | FunTech Logo（可點擊回首頁） | `.site-header .brand a.brand-link` | ✅ |
| 1.2.2.2 | 主要導覽列容器 | `.site-header nav.main-nav` | ✅ |
| 1.2.2.2.1 | 「首頁」連結 | `nav.main-nav a.home-link` | ✅ |
| 1.2.2.2.2 | 「遊戲」連結 | `nav.main-nav a.games-link` | ✅ |
| 1.2.2.2.3 | 「好友」連結 | `nav.main-nav a.friends-link` | ✅ |
| 1.2.2.3 | 使用者區域 | `.site-header .user-area` | ✅ |
| 1.2.2.3.1 | 未登入：「登入」`a.login-link` + 「註冊」`a.register-link` | `.user-area a.login-link` / `.user-area a.register-link` | ✅ |
| 1.2.2.3.2 | 已登入：`.user-badge`、`a.profile-link`、`a.logout-link` | `.user-area .user-badge` | ✅ |
| 1.3.1 | 文章區塊容器 | `section.articles` | ✅ |
| 1.3.2 | 文章列表（多筆） | `section.articles article.article-item` | ✅ |
| 1.3.3.1 | 文章標題 | `.article-item .article-title` | ✅ |
| 1.3.3.2 | 發布日期 | `.article-item time.article-date` | ✅ |
| 1.3.3.3 | 文章摘要 | `.article-item .article-excerpt` | ✅ |
| 1.3.3.4 | 「閱讀更多」連結 | `.article-item a.article-readmore` | ✅ |
| 1.4.1 | 通知／公告容器 | `aside.notifications` | ✅ |
| 1.4.2 | 通知列表（多則） | `aside.notifications .notification-item` | ✅ |
| 1.4.3.1 | 通知標題 | `.notification-item .notification-title` | ✅ |
| 1.4.3.2 | 通知日期 | `.notification-item time.notification-date` | ✅ |

### 2. 文章內容頁（`#article`）

| # | 需求說明 | CSS Selector | 狀態 |
|---|---------|-------------|------|
| 2.1 | 文章內容頁根容器 | `#article` | ✅ |
| 2.2.1 | 標題區塊 | `#article header.article-header` | ✅ |
| 2.2.2.1 | 文章標題 | `.article-header h1.article-title` | ✅ |
| 2.2.2.2 | 文章發布日期 | `.article-header time.article-date` | ✅ |
| 2.3.1 | 內容區塊 | `#article section.article-body` | ✅ |

### 3. 個人頁面（`#profile-page`）

| # | 需求說明 | CSS Selector | 狀態 |
|---|---------|-------------|------|
| 3.1 | 個人頁面根容器 | `#profile-page` | ✅ |
| 3.2.1 | 使用者資訊區塊 | `section.profile-header` | ✅ |
| 3.2.2.1 | 使用者頭像 | `.profile-header img.profile-avatar` | ⚠️ class 誤植為 `profile-avater` |
| 3.2.2.2 | 使用者名稱 | `.profile-header .profile-username` | ✅ |
| 3.2.2.3 | 簡介文字（無則顯示「尚未填寫自我介紹」） | `.profile-header .profile-bio` | ✅ |
| 3.2.3 | 點擊頭像觸發上傳 → 更新頭像 → 即時顯示 | — | ✅ |
| 3.2.4 | 點擊簡介切換編輯模式 → Enter 儲存 → 即時更新 | `textarea.profile-bio-input` | ✅ |
| 3.3.1 | 已登入者可見「發表文章」連結 | `a.new-post-link` | ✅ |
| 3.3.2 | 文章表單容器 | `form.article-create-form` | ✅ |
| 3.3.3.1 | 標題輸入欄 | `.article-create-form input.article-title-input` | ✅ |
| 3.3.3.2 | 內容輸入欄 | `.article-create-form textarea.article-content-input` | ✅ |
| 3.3.3.3 | 發布按鈕 | `.article-create-form button.article-submit-button` | ✅ |
| 3.3.4 | 發表成功 → alert「發表成功」→ 跳轉至新文章頁 | — | ✅ |
| 3.4.1 | 使用者文章列表 | `section.profile-articles` | ✅ |
| 3.4.2 | 每篇文章項目 | `.profile-articles .article-item` | ✅ |
| 3.4.3.1 | 文章標題 | `.article-item .article-title` | ✅ |
| 3.4.3.2 | 發佈日期 | `.article-item time.article-date` | ✅ |
| 3.4.3.3 | 閱讀文章連結 | `.article-item a.article-readmore` | ✅ |
| 3.4.4 | 無文章時顯示「目前尚無文章」 | `.profile-articles .empty-article-message` | ✅ |

---

## 項目 2：會員登入與註冊系統

| # | 需求說明 | CSS Selector | 狀態 |
|---|---------|-------------|------|
| 1.1 | 登入表單容器 | `form.login-form` | ✅ |
| 1.2.1 | 帳號輸入欄 | `.login-form input.username-input` | ✅ |
| 1.2.2 | 密碼輸入欄 | `.login-form input.password-input` | ✅ |
| 1.2.3 | 登入送出按鈕 | `.login-form button.login-submit-button` | ✅ |
| 1.3 | 送出後驗證並登入 | — | ✅ |
| 2.1 | 註冊表單容器 | `form.register-form` | ✅ |
| 2.2.1 | 帳號輸入欄 | `.register-form input.username-input` | ✅ |
| 2.2.2 | Email 欄位 | `.register-form input.email-input` | ✅ |
| 2.2.3 | 密碼輸入欄 | `.register-form input.password-input` | ✅ |
| 2.2.4 | 確認密碼欄位 | `.register-form input.password-confirm-input` | ✅ |
| 2.2.5 | 註冊送出按鈕 | `.register-form button.register-submit` | ✅ |
| 2.3 | 送出後建立新帳號 | — | ✅ |
| 2.4 | 註冊成功後導向登入頁 | — | ✅ |
| 2.5 | 帳號重複或格式錯誤顯示 alert | — | ✅ |
| 3 | 登出功能 | `a.logout-link` | ✅ |

---

## 項目 3：好友系統（Friend System）

| # | 需求說明 | CSS Selector | 狀態 |
|---|---------|-------------|------|
| 1.1.1 | 好友頁主容器 | `#friends-page` | ✅ |
| 1.1.1.1 | 搜尋功能區塊 | `#friends-page .friend-search-section` | ✅ |
| 1.1.1.2 | 好友列表區塊 | `#friends-page .friend-list-section` | ✅ |
| 1.1.1.3 | 收到的好友邀請區塊 | `#friends-page .incoming-requests-section` | ✅ |
| 1.1.1.4 | 送出的好友申請區塊 | `#friends-page .sent-requests-section` | ✅ |
| 2.1 | 搜尋表單 | `form.friend-search-form` | ✅ |
| 2.2.1 | 搜尋輸入欄 | `.friend-search-form input.search-input` | ✅ |
| 2.2.2 | 搜尋按鈕 | `.friend-search-form button.search-submit-button` | ✅ |
| 2.3 | 送出搜尋更新結果 | — | ✅ |
| 2.4 | 搜尋結果容器 | `.friend-search-section .search-result-list` | ✅ |
| 2.5 | 每筆搜尋結果項目 | `.search-result-list .search-result-item` | ✅ |
| 2.6.1 | 使用者名稱 | `.search-result-item .result-username` | ✅ |
| 2.6.2 | 前往個人頁面連結 | `.search-result-item a.view-profile-link` | ✅ |
| 3.1 | 好友列表標題「好友列表」 | `.friend-list-section .section-title` | ✅ |
| 3.2 | 好友列表項目 | `.friend-list-section .friend-item` | ✅ |
| 3.3.1 | 好友頭像 | `.friend-item img.friend-avatar` | ✅ |
| 3.3.2 | 好友名稱 | `.friend-item .friend-name` | ✅ |
| 3.4 | 點擊好友導向個人頁面 | — | ✅ |
| 4.1 | 收到申請區標題 | `.incoming-requests-section .section-title` | ✅ |
| 4.3 | 申請項目 | `.incoming-requests-section .request-item` | ✅ |
| 4.4.1 | 申請者頭像 | `.request-item img.request-avatar` | ✅ |
| 4.4.2 | 申請者名稱 | `.request-item .request-username` | ✅ |
| 4.4.3 | 接受按鈕 | `.request-item button.accept-request-button` | ✅ |
| 4.4.4 | 拒絕按鈕 | `.request-item button.reject-request-button` | ✅ |
| 4.5 | 接受後建立好友關係 | — | ✅ |
| 4.6 | 拒絕後從列表移除 | — | ✅ |
| 5.1 | 送出申請區標題 | `.sent-requests-section .section-title` | ✅ |
| 5.3 | 送出申請項目 | `.sent-requests-section .request-item` | ✅ |
| 5.4.1 | 對方頭像 | `.request-item img.request-avatar` | ✅ |
| 5.4.2 | 對方名稱 | `.request-item .request-username` | ✅ |
| 5.4.3 | 取消申請按鈕 | `.request-item button.cancel-request-button` | ✅ |
| 5.5 | 取消申請後移除項目 | — | ✅ |
| 6.1 | 好友個人頁面 | `#profile-page` | ✅ |
| 6.1.1 | 使用者資訊區 | `.profile-header` | ✅ |
| 6.1.2 | 文章展示區 | `.profile-content` → `section.articles` | ✅ |
| 6.1.3 | 好友互動操作區（依狀態顯示不同按鈕） | `.profile-friend-actions` | ✅ |

---

## 項目 4：遊戲頁面（Games）

### game.json 結構
```json
{
  "entry": { "url": "http://localhost/gameA/index.php" },
  "score": {
    "pullUrl": "http://localhost/gameA/api/pull_score.php",
    "columns": ["玩家名稱", "分數"]
  }
}
```

| # | 需求說明 | CSS Selector | 狀態 |
|---|---------|-------------|------|
| 1.1 | 遊戲列表頁根容器 | `#games` | ✅ |
| 1.2.1 | 遊戲列表容器 | `#games section.game-list` | ✅ |
| 1.2.2 | 每個遊戲項目 | `.game-list .game-item` | ✅ |
| 1.2.3.1 | 遊戲封面圖 | `.game-item img.game-cover` | ✅ |
| 1.2.3.2 | 遊戲名稱 | `.game-item .game-title` | ✅ |
| 1.2.3.3 | 遊戲簡介 | `.game-item .game-description` | ✅ |
| 1.2.3.4 | 開始遊戲連結 | `.game-item a.play-game-link` | ✅ |
| 1.2.3.5 | 點擊連結導向遊戲內容頁 | — | ✅ |
| 2.1 | 遊戲內容頁根容器 | `#game-play` | ✅ |
| 2.2 | 顯示遊戲名稱 | `.current-game-title` | ✅ |
| 2.3.1 | 遊戲區域容器 | `#game-play section.game-area` | ✅ |
| 2.3.2 | 以 iframe 載入遊戲 | `section.game-area iframe.game-frame` | ✅ |
| 2.4.1 | 排行榜區塊 | `aside.game-leaderboard` | ✅ |
| 2.4.2 | 排行榜標題 | `.game-leaderboard .leaderboard-title` | ✅ |
| 2.4.3 | 排行榜資料項目 | `.game-leaderboard .leaderboard-item` | ⚠️ 目前為靜態 HTML，尚未呼叫 `score.pullUrl` API |
| 2.4.4 | 顯示名次 + API 所有欄位 | `.leaderboard-item .player-rank` | ⚠️ 同上，欄位未動態產生 |
| 2.4.5 | 空資料顯示「目前尚無分數紀錄」 | — | ✅（靜態存在） |

---

## 項目 5：Web API 開發

> ⚠️ **競賽當天公布題目，尚無法預先作答。**

**已知基本需求：**
- 所有 API 回應使用 **JSON 格式**
- 需實作基本的**錯誤處理**
- API 資料需與系統同步（後台有 N 筆資料，API 也需回傳 N 筆）

---

## 待修正 / 待完成事項

| 優先 | 項目 | 說明 |
|------|------|------|
| 🔴 高 | 項目4：排行榜動態載入 | `game-play.php` 排行榜目前為靜態佔位，需以 JS 呼叫 `score.pullUrl` 取得資料並動態渲染 `leaderboard-item`，欄位依 `score.columns` 動態產生 |
| 🟡 中 | 個人頁面：class 誤植 | `profile-avater` → 應改為 `profile-avatar`（影響自動化測試） |
| 🟡 中 | 好友功能：typo | `$is_requester`/`$is_addressee` 判斷用到 `status=='pendding'`，應為 `'pending'` |
| 🟡 中 | 項目5：Web API | 等待競賽當天題目公布後實作 |
| 🟢 低 | 模組1：視覺設計 | LOGO、ICON、整體 UI 美化 |
| 🟢 低 | 程式碼整理 | 移除 console.log、整理 git commit |

---

## 專案檔案結構

```
th56j_national/
├── index.php              # 主入口，含 Header 導覽列
├── front/
│   ├── Home-main.php      # 首頁（文章 + 公告）
│   ├── article.php        # 文章內容頁
│   ├── profile-page.php   # 個人頁面（含發文）
│   ├── add-article.php    # 發表文章表單
│   ├── login.php          # 登入頁
│   ├── register.php       # 註冊頁
│   ├── friends-page.php   # 好友列表頁
│   ├── friend-profile-page.php  # 好友個人頁面
│   ├── games.php          # 遊戲列表頁
│   └── game-play.php      # 遊戲內容頁（含排行榜）
├── api/
│   ├── db.php             # 資料庫連線 + session
│   ├── login.php          # 登入 API
│   ├── logout.php         # 登出
│   ├── register.php       # 註冊 API
│   ├── add_article.php    # 發表文章 API
│   ├── update_avatar.php  # 更新頭像 API
│   ├── update_bio.php     # 更新簡介 API
│   ├── search_users.php   # 搜尋使用者 API
│   └── set_friend.php     # 好友操作 API
├── games/
│   ├── 1/ ~ 5/            # 5 個遊戲資料夾（含 game.json、index.html）
│   └── games.sql          # 遊戲資料表
├── assets/
│   ├── css/               # Bootstrap + 自訂 CSS
│   └── js/                # jQuery / Vue / Bootstrap JS
└── doc/                   # 競賽文件（試題 PDF）
```

---

## 資料庫設定

| 項目 | 值 |
|------|----|
| Host | localhost |
| DB | `db21` |
| User | `root` |
| Password | （空） |
| Charset | utf8mb4 |

> 競賽環境帳號規則：DB User = 崗位編號（`webXX`），密碼 = `1234`，DB = `webXX_db`

---

*最後更新：2026-05-26*