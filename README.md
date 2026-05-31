# 第 56 屆全國技能競賽 — 網頁技術（青少年組）
## FunTech 社群網站 · 完整試題說明與第一版實作文件

> **競賽職類**：網頁技術　**競賽時間**：4 小時（競賽當天得有 30% 調整）
> **專案主題**：FunTech — 青少年教育娛樂社群平台
> **版本**：v1（第一版發佈）　**最後更新**：2026-05-31

---

## 目錄

1. [選手注意事項](#1-選手注意事項)
2. [試題總覽](#2-試題總覽)
3. [模組 1：視覺與網頁介面設計](#3-模組-1視覺與網頁介面設計)
4. [模組 2：平台翻新與系統建置](#4-模組-2平台翻新與系統建置)
   - [項目 1：首頁版面設計與個人頁面功能開發](#項目-1首頁版面設計與個人頁面功能開發)
   - [項目 2：會員登入與註冊系統](#項目-2會員登入與註冊系統)
   - [項目 3：好友系統](#項目-3好友系統-friend-system)
   - [項目 4：遊戲頁面](#項目-4遊戲頁面-games)
   - [項目 5：Web API 開發](#項目-5web-api-開發)
5. [專案架構](#5-專案架構)
6. [資料庫設計](#6-資料庫設計)
7. [技術棧與相依套件](#7-技術棧與相依套件)
8. [環境安裝與設定](#8-環境安裝與設定)
9. [實作進度總表](#9-實作進度總表)
10. [已知問題與待修正事項](#10-已知問題與待修正事項)

---

## 1. 選手注意事項

| # | 規定內容 |
|---|---------|
| 1 | 考試時間 4 小時，有異動時以大會另行公告為準 |
| 2 | 選手需自行安裝 XAMPP，設定 Web Server 及資料庫 |
| 3 | 每個工作崗位有一個隨身碟，內含「參考資料」資料夾可供作答時參考 |
| 4 | 依 `web+崗位編號` 在桌面建立資料夾（例如 `web01`），存放評分資料 |
| 5 | 網站首頁設定為 `index.htm` 或 `index.php` |
| 6 | 帳號密碼規定：網頁帳號 `admin` / 密碼 `1234`；DB 帳號 = 崗位編號（`webXX`）/ 密碼 `1234` / DB 名稱 `webXX_db`，違者扣總分 5 分 |
| 7 | 考試相關資料（試題、評分表、資料片等）考後全部收回 |
| 8 | 評分項目前標有「主」（主觀）或「客」（客觀）評分 |
| 9 | 同分時排名順序：① 交卷時間（距結束 10 分鐘內視同相同）→ ② 依評分表項次得分由第 1 項比起 → ③ 主觀評分「網站設計整體性」由裁判共同評分 |
| 10a | 請參考評分標準表作答 |
| 10b | 除非題目特別說明，表單無須檢查資料是否填寫 |
| 10c | 除非特別說明，評分重點在功能完成，與美工無關 |
| 10d | 請隨時將設計好的網頁、圖片及資料庫等儲存至隨身碟 |
| 10e | 比賽結束前將整個作答資料夾複製到隨身碟；成績爭議以隨身碟內容為依據 |
| 10f | 比賽結束時間一到，不可再操作電腦 |
| 10g | 比賽結束時請勿關機，以利評分作業 |

---

## 2. 試題總覽

本競賽共分為兩大模組：

```
模組 1：視覺與網頁介面設計（LOGO、ICON、UI 設計）
模組 2：平台翻新與系統建置
  ├── 項目 1：首頁版面設計與個人頁面功能開發
  ├── 項目 2：會員登入與註冊系統
  ├── 項目 3：好友系統（Friend System）
  ├── 項目 4：遊戲頁面（Games）
  └── 項目 5：Web API 開發（競賽當天公布）
```

**FunTech 平台簡介**：專為青少年打造的教育與娛樂社群網站，提供多元資訊頁面、會員登入系統及簡易遊戲平台。本次競賽以全面升級與重新設計為目標，在保留核心理念的前提下，重新規劃版面與功能架構。

---

## 3. 模組 1：視覺與網頁介面設計

製作 FunTech 網站的視覺設計，包含：

- **LOGO 標誌**：品牌識別主視覺
- **ICON 圖示**：介面用小圖示
- **整體網頁介面**：版面配色、排版設計

> 本版（v1）已放置 `assets/img/logo.png` 作為佔位 Logo；整體視覺美工尚有進一步精修空間。

---

## 4. 模組 2：平台翻新與系統建置

### 項目 1：首頁版面設計與個人頁面功能開發

#### 1.1 首頁（`#home`）

首頁為平台主要入口，須呈現**文章列表**與**通知／公告**，並包含導覽列（Header）。

**試題要求的 DOM 結構與 CSS Selector**

| 需求說明 | CSS Selector | 本版狀態 |
|---------|-------------|---------|
| 首頁根容器 | `#home` | ✅ |
| 頁首導覽列容器 | `header.site-header` | ✅ |
| FunTech Logo（可點擊回首頁） | `.site-header .brand a.brand-link` | ✅ |
| 主要導覽列容器 | `.site-header nav.main-nav` | ✅ |
| 「首頁」連結 | `nav.main-nav a.home-link` | ✅ |
| 「遊戲」連結 | `nav.main-nav a.games-link` | ✅ |
| 「好友」連結 | `nav.main-nav a.friends-link` | ✅ |
| 使用者區域 | `.site-header .user-area` | ✅ |
| 未登入：「登入」連結 | `.user-area a.login-link` | ✅ |
| 未登入：「註冊」連結 | `.user-area a.register-link` | ✅ |
| 已登入：使用者名稱或頭像區塊 | `.user-area .user-badge` | ✅ |
| 已登入：個人頁面入口 | `.user-area a.profile-link` | ✅ |
| 已登入：「登出」按鈕 | `.user-area a.logout-link` | ✅ |
| 文章區塊容器 | `section.articles` | ✅ |
| 文章列表（多筆） | `section.articles article.article-item` | ✅ |
| 文章標題 | `.article-item .article-title` | ✅ |
| 發布日期 | `.article-item time.article-date` | ✅ |
| 文章摘要 | `.article-item .article-excerpt` | ✅ |
| 「閱讀更多」連結 | `.article-item a.article-readmore` | ✅ |
| 通知／公告容器 | `aside.notifications` | ✅ |
| 通知列表（多則） | `aside.notifications .notification-item` | ✅ |
| 通知標題 | `.notification-item .notification-title` | ✅ |
| 通知日期 | `.notification-item time.notification-date` | ✅ |

**本版實作說明**：首頁使用 SPA（單頁應用）架構，透過 `loadpage()` AJAX 函式動態載入 `front/Home-main.php`。文章由資料庫 `articles` 資料表撈取最新 10 筆，通知目前以靜態迴圈產生 5 則佔位公告。首頁與通知區塊可透過頂端分頁 Tab 切換顯示。

---

#### 1.2 文章內容頁（`#article`）

| 需求說明 | CSS Selector | 本版狀態 |
|---------|-------------|---------|
| 文章內容頁根容器 | `#article` | ✅ |
| 標題區塊 | `#article header.article-header` | ✅ |
| 文章標題 | `.article-header h1.article-title` | ✅ |
| 文章發布日期 | `.article-header time.article-date` | ✅ |
| 內容區塊 | `#article section.article-body` | ✅ |

**本版實作說明**：文章內容頁（`front/article.php`）透過 `$_GET['id']` 從資料庫撈取對應文章，使用 `htmlspecialchars()` 防止 XSS。

---

#### 1.3 個人頁面（`#profile-page`）

| 需求說明 | CSS Selector | 本版狀態 |
|---------|-------------|---------|
| 個人頁面根容器 | `#profile-page` | ✅ |
| 使用者資訊區塊 | `section.profile-header` | ✅ |
| 使用者頭像 | `.profile-header img.profile-avatar` | ⚠️ class 誤植為 `profile-avater` |
| 使用者名稱 | `.profile-header .profile-username` | ✅ |
| 簡介文字（無則顯示「尚未填寫自我介紹」） | `.profile-header .profile-bio` | ✅ |
| 點擊頭像觸發上傳 → 更新頭像 → 即時顯示 | — | ✅ |
| 上傳失敗顯示 alert「頭像上傳失敗」 | — | ✅ |
| 點擊簡介切換編輯 → Enter 儲存 → 即時更新 | `textarea.profile-bio-input` | ✅ |
| 儲存失敗顯示 alert「簡介更新失敗」 | — | ✅ |
| 已登入者可見「發表文章」連結 | `a.new-post-link` | ✅ |
| 文章表單容器 | `form.article-create-form` | ✅ |
| 標題輸入欄 | `.article-create-form input.article-title-input` | ✅ |
| 內容輸入欄 | `.article-create-form textarea.article-content-input` | ✅ |
| 發布按鈕 | `.article-create-form button.article-submit-button` | ✅ |
| 發表成功 → alert「發表成功」→ 跳轉至新文章頁 | — | ✅ |
| 使用者文章列表 | `section.profile-articles` | ✅ |
| 每篇文章項目 | `.profile-articles .article-item` | ✅ |
| 文章標題 | `.article-item .article-title` | ✅ |
| 發佈日期 | `.article-item time.article-date` | ✅ |
| 閱讀文章連結 | `.article-item a.article-readmore` | ✅ |
| 無文章時顯示「目前尚無文章」 | `.profile-articles .empty-article-message` | ✅ |

**本版實作說明**：個人頁面（`front/profile-page.php`）以 Session 判斷是否為本人，頭像上傳透過 `api/update_avatar.php` 以 FormData 送出；簡介修改透過 `api/update_bio.php` 以 POST 送出，Enter 鍵觸發儲存。發文表單以 AJAX 呼叫 `api/add_article.php`，成功後 alert 並跳轉至新文章頁。

---

### 項目 2：會員登入與註冊系統

#### 2.1 登入頁面（Login）

| 需求說明 | CSS Selector | 本版狀態 |
|---------|-------------|---------|
| 登入表單容器 | `form.login-form` | ✅ |
| 帳號輸入欄 | `.login-form input.username-input` | ✅ |
| 密碼輸入欄 | `.login-form input.password-input` | ✅ |
| 登入送出按鈕 | `.login-form button.login-submit-button` | ✅ |
| 送出後驗證並登入 | — | ✅ |

**本版實作說明**：`api/login.php` 查詢 `users` 資料表比對帳密，成功則寫入 `$_SESSION['user']`、`$_SESSION['user_id']`，前端收到回傳值後重新載入頁面（SPA 刷新）。

---

#### 2.2 註冊頁面（Register）

| 需求說明 | CSS Selector | 本版狀態 |
|---------|-------------|---------|
| 註冊表單容器 | `form.register-form` | ✅ |
| 帳號輸入欄 | `.register-form input.username-input` | ✅ |
| Email 欄位 | `.register-form input.email-input` | ✅ |
| 密碼輸入欄 | `.register-form input.password-input` | ✅ |
| 確認密碼欄位 | `.register-form input.password-confirm-input` | ✅ |
| 註冊送出按鈕 | `.register-form button.register-submit` | ✅ |
| 送出後建立新帳號 | — | ✅ |
| 成功後導向登入頁 | — | ✅ |
| 帳號重複或格式錯誤顯示 alert | — | ✅ |

**本版實作說明**：`api/register.php` 先檢查帳號是否已存在，若存在則 alert 提示；否則 `INSERT` 新帳號並導向登入頁。

---

#### 2.3 登出（Logout）

| 需求說明 | CSS Selector | 本版狀態 |
|---------|-------------|---------|
| 登出功能 | `a.logout-link` | ✅ |

**本版實作說明**：`api/logout.php` 執行 `session_destroy()` 後以完整頁面重新導向至 `index.php`（非 AJAX，以確保 Session 確實清除）。

---

### 項目 3：好友系統（Friend System）

好友系統允許使用者搜尋其他使用者、查看好友個人頁面、發送好友邀請、接受或拒絕好友申請、查看好友列表，以及移除好友。

#### 3.1 好友頁面整體架構

| 需求說明 | CSS Selector | 本版狀態 |
|---------|-------------|---------|
| 好友頁主容器 | `#friends-page` | ✅ |
| 搜尋功能區塊 | `#friends-page .friend-search-section` | ✅ |
| 好友列表區塊 | `#friends-page .friend-list-section` | ✅ |
| 收到的好友邀請區塊 | `#friends-page .incoming-requests-section` | ✅ |
| 送出的好友申請區塊 | `#friends-page .sent-requests-section` | ✅ |

#### 3.2 搜尋使用者功能

| 需求說明 | CSS Selector | 本版狀態 |
|---------|-------------|---------|
| 搜尋表單 | `form.friend-search-form` | ✅ |
| 搜尋輸入欄 | `.friend-search-form input.search-input` | ✅ |
| 搜尋按鈕 | `.friend-search-form button.search-submit-button` | ✅ |
| 送出搜尋更新結果 | — | ✅ |
| 搜尋結果容器 | `.friend-search-section .search-result-list` | ✅ |
| 每筆搜尋結果項目 | `.search-result-list .search-result-item` | ✅ |
| 使用者名稱 | `.search-result-item .result-username` | ✅ |
| 前往個人頁面連結 | `.search-result-item a.view-profile-link` | ✅ |

#### 3.3 好友列表、收到邀請、送出申請

| 需求說明 | CSS Selector | 本版狀態 |
|---------|-------------|---------|
| 好友列表標題「好友列表」 | `.friend-list-section .section-title` | ✅ |
| 好友列表項目 | `.friend-list-section .friend-item` | ✅ |
| 好友頭像 | `.friend-item img.friend-avatar` | ✅ |
| 好友名稱 | `.friend-item .friend-name` | ✅ |
| 點擊好友導向個人頁面 | — | ✅ |
| 收到申請區標題「收到的好友申請」 | `.incoming-requests-section .section-title` | ✅ |
| 申請項目 | `.incoming-requests-section .request-item` | ✅ |
| 申請者頭像 | `.request-item img.request-avatar` | ✅ |
| 申請者名稱 | `.request-item .request-username` | ✅ |
| 接受按鈕 | `.request-item button.accept-request-button` | ✅ |
| 拒絕按鈕 | `.request-item button.reject-request-button` | ✅ |
| 接受後建立好友關係 | — | ✅ |
| 拒絕後從列表移除 | — | ✅ |
| 送出申請區標題「發送的好友申請」 | `.sent-requests-section .section-title` | ✅ |
| 送出申請項目 | `.sent-requests-section .request-item` | ✅ |
| 對方頭像 | `.request-item img.request-avatar` | ✅ |
| 對方名稱 | `.request-item .request-username` | ✅ |
| 取消申請按鈕 | `.request-item button.cancel-request-button` | ✅ |
| 取消申請後移除項目 | — | ✅ |

#### 3.4 好友的個人頁面

| 需求說明 | CSS Selector | 本版狀態 |
|---------|-------------|---------|
| 好友個人頁面主容器 | `#profile-page` | ✅ |
| 使用者資訊區 | `.profile-header` | ✅ |
| 使用者名稱 | `.profile-header .profile-username` | ✅ |
| 頭像 | `.profile-header img.profile-avatar` | ✅ |
| 簡介文字 | `.profile-header .profile-bio` | ✅ |
| 文章展示區 | `.profile-content` → `section.articles` | ✅ |
| 好友互動操作區（依狀態顯示不同按鈕） | `#profile-page .profile-friend-actions` | ✅ |

**本版實作說明**：好友操作透過 `api/set_friend.php`，以 GET 參數 `action`（`apply`／`accept`／`cancel`／`reject`／`remove`）與 `friend_id` 控制，回傳 JSON。`front/friends-page.php` 以 PHP 查詢 `friends` 資料表，將 `status='accept'`、`status='pending'`（收到）、`status='pending'`（送出）分別渲染至對應區塊。

---

### 項目 4：遊戲頁面（Games）

此項目實作平台的「遊戲系統」，包含遊戲列表頁面、遊戲內容頁面（iframe 載入）以及排行榜資料整合。

#### game.json 設定格式

每個遊戲資料夾（`games/{id}/`）必定包含一個 `game.json`：

```json
{
  "entry": {
    "url": "games/1/index.html"
  },
  "score": {
    "pullUrl": "games/1/api/pull_score.php",
    "columns": ["玩家名稱", "分數"]
  }
}
```

- `entry.url`：遊戲的入口網址
- `score.pullUrl`：取得遊戲分數資料的 API 網址
- `score.columns`：排行榜資料的欄位名稱列表

#### 分數 API 回傳格式

```json
[
  { "玩家名稱": "玩家1", "分數": 95000 },
  { "玩家名稱": "玩家2", "分數": 89000 },
  { "玩家名稱": "玩家3", "分數": 82500 }
]
```

#### 4.1 遊戲列表頁面

| 需求說明 | CSS Selector | 本版狀態 |
|---------|-------------|---------|
| 遊戲列表頁根容器 | `#games` | ✅ |
| 遊戲列表容器 | `#games section.game-list` | ✅ |
| 每個遊戲項目 | `.game-list .game-item` | ✅ |
| 遊戲封面圖 | `.game-item img.game-cover` | ✅ |
| 遊戲名稱 | `.game-item .game-title` | ✅ |
| 遊戲簡介 | `.game-item .game-description` | ✅ |
| 開始遊戲連結 | `.game-item a.play-game-link` | ✅ |
| 點擊連結導向遊戲內容頁 | — | ✅ |

#### 4.2 遊戲內容頁面

| 需求說明 | CSS Selector | 本版狀態 |
|---------|-------------|---------|
| 遊戲內容頁根容器 | `#game-play` | ✅ |
| 顯示遊戲名稱 | `.current-game-title` | ✅ |
| 遊戲區域容器 | `#game-play section.game-area` | ✅ |
| 以 iframe 載入遊戲 | `section.game-area iframe.game-frame` | ✅ |
| 排行榜區塊 | `aside.game-leaderboard` | ✅ |
| 排行榜標題 | `.game-leaderboard .leaderboard-title` | ✅ |
| 排行榜資料項目（動態呼叫 API） | `.game-leaderboard .leaderboard-item` | ✅ |
| 顯示名次 + API 所有欄位 | `.leaderboard-item .player-rank` | ✅ |
| 空資料顯示「目前尚無分數紀錄」 | — | ✅ |

**本版實作說明**：`front/game-play.php` 從資料庫查詢遊戲資料，並以 `file_get_contents()` 讀取 `game.json`。頁面載入後透過 `$.get(score.pullUrl)` 呼叫排行榜 API，動態產生 `.leaderboard-item` 節點。欄位標題依 `score.columns` 動態渲染，支援任意欄位數量。

---

### 項目 5：Web API 開發

> ⚠️ **試題說明：競賽當天公布，尚無法預先作答。**

**已知基本需求：**
- 所有 API 回應使用 **JSON 格式**
- 需實作基本的**錯誤處理**
- API 資料需與系統同步（後台有 N 筆資料，API 也需回傳 N 筆）

**選手提示：**
- 瀏覽器呈現格式不同不影響結果，資料內容正確即可
- 確保 API 輸出與資料庫資料保持完全同步

---

## 5. 專案架構

```
th56j_national/
│
├── index.php                    # 主入口，SPA 架構（Header + #content 動態載入區）
│
├── front/                       # 前端 PHP 頁面（透過 loadpage() AJAX 載入）
│   ├── Home-main.php            # 首頁（文章列表 + 通知公告，Tab 切換）
│   ├── article.php              # 文章內容頁
│   ├── profile-page.php         # 個人頁面（頭像上傳、簡介修改、發文）
│   ├── add-article.php          # 發表文章表單（從個人頁面跳轉）
│   ├── login.php                # 登入頁
│   ├── register.php             # 註冊頁
│   ├── friends-page.php         # 好友列表頁（搜尋、好友、收到/送出申請）
│   ├── friend-profile-page.php  # 好友個人頁面（含好友互動操作區）
│   ├── games.php                # 遊戲列表頁（從 DB 讀取）
│   └── game-play.php            # 遊戲內容頁（iframe + 動態排行榜）
│
├── api/                         # 後端 API（全 JSON 回應）
│   ├── db.php                   # PDO 資料庫連線 + Session 啟動
│   ├── login.php                # 登入驗證、寫入 Session
│   ├── logout.php               # 清除 Session，重導至首頁
│   ├── register.php             # 帳號創建（檢查重複）
│   ├── add_article.php          # 新增文章
│   ├── update_avatar.php        # 更新使用者頭像（接收 multipart/form-data）
│   ├── update_bio.php           # 更新使用者簡介
│   ├── search_users.php         # 使用者搜尋（LIKE 查詢）
│   └── set_friend.php           # 好友操作（apply/accept/cancel/reject/remove）
│
├── games/                       # 遊戲資料夾（主辦單位提供）
│   ├── 1/ ~ 5/                  # 5 個遊戲
│   │   ├── game.json            # 遊戲設定（entry.url、score.pullUrl、score.columns）
│   │   ├── index.html           # 遊戲本體
│   │   ├── cover.svg            # 遊戲封面圖
│   │   ├── scores.json          # 分數資料（靜態）
│   │   └── api/pull_score.php   # 分數 API（回傳 JSON 陣列）
│
├── assets/
│   ├── css/
│   │   ├── bootstrap.css        # Bootstrap 4 樣式
│   │   └── index.css            # 自訂樣式
│   ├── js/
│   │   ├── jquery-3.7.1.min.js  # jQuery
│   │   ├── bootstrap.js         # Bootstrap JS
│   │   ├── vue.3.5.13.js        # Vue 3（備用）
│   │   └── index.js             # 自訂 JS（loadpage 函式）
│   └── img/
│       └── logo.png             # FunTech Logo
│
├── img/                         # 使用者頭像圖片目錄
│   ├── default_header.jpg       # 預設頭像
│   ├── admin.jpg/png            # 管理員頭像
│   └── user_01.jpg ~ user_12.jpg
│
├── document/                    # 競賽文件與素材
│   ├── articles/                # 文章素材 (article01.txt ~ article36.txt)
│   └── users/                   # 使用者素材（頭像圖片、資訊）
│
├── game fast cosole/            # 開發用快速通關工具
│   ├── README.md
│   └── console.js               # 可貼入瀏覽器 Console 的快速分數腳本
│
├── db21 (2).sql                 # 資料庫完整備份（含資料）
└── README.md                    # 本文件
```

---

## 6. 資料庫設計

**連線設定**（`api/db.php`）

| 項目 | 開發環境值 | 競賽環境值 |
|------|-----------|----------|
| Host | `localhost` | `localhost` |
| DB | `db21` | `webXX_db` |
| User | `root` | `webXX` |
| Password | （空） | `1234` |
| Charset | `utf8mb4` | `utf8mb4` |

### 資料表結構

#### `users`
```sql
CREATE TABLE `users` (
  `id`       int UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email`    varchar(255) NOT NULL,
  `bio`      text,
  `header`   varchar(255),            -- 頭像檔名（存放於 /img/ 目錄）
  PRIMARY KEY (`id`)
);
```

#### `articles`
```sql
CREATE TABLE `articles` (
  `id`         int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`    int UNSIGNED NOT NULL,
  `title`      text NOT NULL,
  `content`    text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
);
```

#### `friends`
```sql
CREATE TABLE `friends` (
  `id`           int NOT NULL AUTO_INCREMENT,
  `requester_id` int NOT NULL,          -- 申請者 user id
  `addressee_id` int NOT NULL,          -- 被申請者 user id
  `status`       text NOT NULL,         -- 'pending' | 'accept'
  `created_at`   timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at`   timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
);
```

#### `games`
```sql
CREATE TABLE `games` (
  `id`          int NOT NULL AUTO_INCREMENT,
  `title`       varchar(255) NOT NULL,
  `description` text,
  `cover`       varchar(255),           -- 封面圖路徑
  PRIMARY KEY (`id`)
);
```

#### `scores`
```sql
CREATE TABLE `scores` (
  `id`      int NOT NULL AUTO_INCREMENT,
  `game_id` int NOT NULL,
  `player`  varchar(255) NOT NULL,
  `score`   int NOT NULL,
  PRIMARY KEY (`id`)
);
```

---

## 7. 技術棧與相依套件

| 分類 | 技術 / 套件 | 版本 | 用途 |
|------|-----------|------|------|
| 後端語言 | PHP | 8.2 | 伺服器端邏輯 |
| 資料庫 | MariaDB / MySQL | 10.4+ | 資料儲存 |
| 資料庫連線 | PDO | — | PHP 資料庫存取層 |
| 前端框架 | Bootstrap | 4.x | RWD 排版、元件樣式 |
| JavaScript 函式庫 | jQuery | 3.7.1 | DOM 操作、AJAX |
| JavaScript 框架 | Vue.js | 3.5.13 | 備用（目前未使用） |
| 開發環境 | XAMPP | — | Apache + MySQL + PHP 整合套件 |
| 版本控制 | Git | — | 原始碼版本管理 |

---

## 8. 環境安裝與設定

### 8.1 前置需求

- XAMPP（或任何支援 PHP 8.2+ 與 MySQL 的本機伺服器環境）
- 瀏覽器（Chrome / Firefox 建議）

### 8.2 安裝步驟

```bash
# 1. 將整個專案資料夾放置於 XAMPP 的 htdocs 目錄
#    例如：C:\xampp\htdocs\web01\

# 2. 啟動 XAMPP → 開啟 Apache 與 MySQL

# 3. 進入 phpMyAdmin（http://localhost/phpmyadmin）
#    建立資料庫：db21（開發環境）或 webXX_db（競賽環境）

# 4. 匯入資料庫備份
#    選擇建立的資料庫 → 匯入 → 選取 db21 (2).sql

# 5. 修改 api/db.php 中的連線設定（競賽環境需修改帳密）
```

### 8.3 連線設定修改（競賽環境）

開啟 `api/db.php`，將以下內容：
```php
$dsn = "mysql:host=localhost;dbname=db21;charset=utf8";
$pdo = new PDO($dsn, 'root', '');
```
修改為：
```php
$dsn = "mysql:host=localhost;dbname=webXX_db;charset=utf8mb4";
$pdo = new PDO($dsn, 'webXX', '1234');
```

### 8.4 開啟網站

瀏覽器輸入 `http://localhost/web01/`（依實際資料夾名稱調整）。

---

## 9. 實作進度總表

| 模組 | 項目 | 子功能 | 狀態 |
|------|------|--------|------|
| 模組 1 | 視覺設計 | Logo / ICON / UI | ⚠️ 基本佔位，待美化 |
| 模組 2 | 項目 1 | 首頁文章列表 | ✅ 完成 |
| 模組 2 | 項目 1 | 首頁通知公告 | ⚠️ 靜態佔位，待串接 DB |
| 模組 2 | 項目 1 | 文章內容頁 | ✅ 完成 |
| 模組 2 | 項目 1 | 個人頁面（頭像上傳） | ✅ 完成（class typo 待修） |
| 模組 2 | 項目 1 | 個人頁面（簡介修改） | ✅ 完成 |
| 模組 2 | 項目 1 | 個人頁面（發表文章） | ✅ 完成 |
| 模組 2 | 項目 2 | 登入系統 | ✅ 完成 |
| 模組 2 | 項目 2 | 註冊系統 | ✅ 完成 |
| 模組 2 | 項目 2 | 登出 | ✅ 完成 |
| 模組 2 | 項目 3 | 好友頁面架構 | ✅ 完成 |
| 模組 2 | 項目 3 | 搜尋使用者 | ✅ 完成 |
| 模組 2 | 項目 3 | 好友列表 | ✅ 完成 |
| 模組 2 | 項目 3 | 收到的好友申請 | ✅ 完成 |
| 模組 2 | 項目 3 | 送出的好友申請 | ✅ 完成 |
| 模組 2 | 項目 3 | 好友個人頁面 | ✅ 完成 |
| 模組 2 | 項目 4 | 遊戲列表頁 | ✅ 完成 |
| 模組 2 | 項目 4 | 遊戲內容頁（iframe） | ✅ 完成 |
| 模組 2 | 項目 4 | 排行榜動態 API 串接 | ✅ 完成 |
| 模組 2 | 項目 5 | Web API 開發 | ⏳ 等待競賽當天公布 |

---

## 10. 已知問題與待修正事項

| 優先 | 項目 | 問題說明 | 解決方向 |
|------|------|---------|---------|
| 🔴 高 | `profile-page.php` | `img.profile-avatar` 的 class 誤植為 `profile-avater`（少一個 r），影響自動化測試 | 將 HTML 中 `class="profile-avater"` 改為 `profile-avatar` |
| 🟡 中 | `api/set_friend.php` | 若 `$relation` 為空（例如第一次申請）時，`accept` / `cancel` / `reject` / `remove` 的 `$relation['id']` 會為 NULL，導致 SQL 錯誤 | 加入 `$relation` 空值檢查，或改用參數化查詢 |
| 🟡 中 | `api/login.php` | SQL 直接拼接 `$_POST` 值，存在 SQL Injection 風險 | 改用 PDO Prepared Statements |
| 🟡 中 | `api/register.php` | 同上，且密碼以明文儲存 | 改用 Prepared Statements；密碼改用 `password_hash()` 加密 |
| 🟡 中 | 首頁通知公告 | 目前為靜態迴圈產生 5 則假公告 | 建立 `notifications` 資料表，從 DB 動態讀取 |
| 🟡 中 | 項目 5 | Web API 等待競賽當天公布題目 | 競賽當天依題即時實作 |
| 🟢 低 | 視覺設計 | LOGO、ICON、整體 UI 美化尚不完整 | 補充視覺設計資源，精修 CSS |
| 🟢 低 | 程式碼整理 | 部分檔案殘留 `console.log`；git commit 訊息可更規範 | 清理 debug 碼；統一 commit 風格 |
| 🟢 低 | 個人頁面 | 頭像上傳時缺乏檔案類型與大小的前端驗證 | 加入 `accept="image/*"` 並檢查 `file.size` |

---

## Git Commit 歷程（近期）

| Hash | 訊息 |
|------|------|
| `ddc8818` | 修改功能 Bug 以及製作尚未完成的功能 |
| `8b1cdef` | 加入現 SQL |
| `7d6d2cc` | game-play cols |
| `892a2cc` | 版本標示 |
| `8f3446c` | 遊戲版面調整以及快速通關修正第四版 |
| `6c50c00` | 檔案微調及整理 |
| `116df6e` | 加入遊戲快速通關 console |
| `0dac7eb` | MD 檔案加入進度追蹤 |
| `b61a01b` | 遊戲頁面的美化與排版調整以及壓縮 Games 資料夾 |
| `ab69fdb` | 加入遊戲檔案及資料庫檔案 |

---

*第 56 屆全國技能競賽網頁技術青少年組 · FunTech 社群網站 · v1 發佈版本*
*最後更新：2026-05-31*