# 第 56 屆全國技能競賽 — 網頁技術青少年組（J17）
## FunTech 社群網站 ‧ 完整專案文件 v2

> **競賽職類：** 網頁技術  
> **競賽時間：** 4 小時（競賽當天得有 30% 調整）  
> **專案版本：** v2（第二版發佈）  
> **最後更新：** 2026-05-31  

---

## 目錄

1. [競賽總覽與注意事項](#1-競賽總覽與注意事項)
2. [專案技術棧與架構](#2-專案技術棧與架構)
3. [環境設置與帳號規則](#3-環境設置與帳號規則)
4. [資料庫結構](#4-資料庫結構)
5. [專案檔案結構](#5-專案檔案結構)
6. [模組 1：視覺與網頁介面設計](#6-模組-1視覺與網頁介面設計)
7. [模組 2 — 項目 1：首頁版面設計與個人頁面功能開發](#7-模組-2--項目-1首頁版面設計與個人頁面功能開發)
8. [模組 2 — 項目 2：會員登入與註冊系統](#8-模組-2--項目-2會員登入與註冊系統)
9. [模組 2 — 項目 3：好友系統](#9-模組-2--項目-3好友系統)
10. [模組 2 — 項目 4：遊戲頁面](#10-模組-2--項目-4遊戲頁面)
11. [模組 2 — 項目 5：Web API 開發](#11-模組-2--項目-5web-api-開發)
12. [已知問題與待修正事項](#12-已知問題與待修正事項)
13. [CSS Selector 完整速查表](#13-css-selector-完整速查表)
14. [名次同分決定方式](#14-名次同分決定方式)

---

## 1. 競賽總覽與注意事項

### 1.1 競賽說明

本試題分為兩大模組：

- **模組 1**：「FunTech 社群網站」視覺與網頁介面設計，包含 LOGO 標誌、ICON、網頁介面等視覺設計。
- **模組 2**：FunTech 社群網站平台翻新與系統建置，以 FunTech 青少年教育娛樂社群為主題，重新規劃網站系統，共分五個項目。

### 1.2 選手注意事項

- 競賽期間自行安裝 XAMPP，設定 web server 及資料庫環境。
- 每個工作崗位皆有一個隨身碟，內含「參考資料」資料夾供作答參考。
- 依 `web+崗位編號` 在桌面建立資料夾（例如 `web01`、`web02`），作為評分資料夾。
- 網站首頁設定為 `index.htm` 或 `index.php`。
- 每個「評分項目」前標明「主（主觀評分）」或「客（客觀評分）」。
- 比賽結束時間一到，選手不可再操作電腦；比賽結束時請勿關機。
- 考試所有相關資料於考完後全部收回，包含空白紙、試題、評分表、資料片等。

### 1.3 帳號密碼規則

| 用途 | 帳號 | 密碼 |
|------|------|------|
| 網頁管理員帳號 | `admin` | `1234` |
| 資料庫使用者帳號 | 崗位編號（`webXX`） | `1234` |
| 資料庫名稱 | `webXX_db` | — |

> ⚠️ 若未依規定設定帳號密碼，**扣總分 5 分**。

---

## 2. 專案技術棧與架構

### 2.1 前端

| 項目 | 版本／說明 |
|------|-----------|
| HTML5 / CSS3 | 語意化標籤、RWD 版面 |
| Bootstrap | 4.5.3（CDN 引入） |
| jQuery | 3.7.1（本地 + CDN） |
| SPA 架構 | 以 `$.load()` 動態載入子頁面至 `#content` |

### 2.2 後端

| 項目 | 版本／說明 |
|------|-----------|
| PHP | 8.2.x（XAMPP 環境） |
| PDO | MySQL 資料庫連線 |
| Session | 使用者登入狀態管理 |

### 2.3 資料庫

| 項目 | 值 |
|------|---|
| 引擎 | MariaDB 10.4.32 |
| 本機資料庫名稱 | `db21` |
| 本機使用者 | `root`（密碼為空） |
| 競賽環境 | `webXX` / `1234` / `webXX_db` |
| 字元集 | `utf8mb4` |

### 2.4 SPA 運作方式

整個網站以 `index.php` 為唯一入口，所有子頁面透過 jQuery 的 `$.load()` 動態載入至 `<div id="content">` 容器中，實現無重新整理換頁體驗：

```javascript
// assets/js/index.js
function loadpage(url = "main") {
  $("#content").load(url);
}
```

---

## 3. 環境設置與帳號規則

### 3.1 XAMPP 設置

1. 安裝 XAMPP，啟動 Apache 與 MySQL。
2. 將專案資料夾放置於 `htdocs/` 下（例如 `htdocs/web01/`）。
3. 匯入 `db21 (2).sql` 至 phpMyAdmin 以建立資料庫與資料表。
4. 修改 `api/db.php` 中的連線設定以符合競賽環境：

```php
// api/db.php（競賽環境修改）
$dsn = "mysql:host=localhost;dbname=webXX_db;charset=utf8mb4";
$pdo = new PDO($dsn, 'webXX', '1234');
date_default_timezone_set("Asia/Taipei");
session_start();
```

### 3.2 測試帳號（本機開發環境）

| 帳號 | 密碼 | 備註 |
|------|------|------|
| `mack` | `1234` | 主要測試帳號，有文章與頭像 |
| `judy` | `5678` | 第二測試帳號 |
| `yo` | `A` | 第三測試帳號 |
| `admin` | `1234` | 管理員 |

---

## 4. 資料庫結構

### 4.1 `users` 資料表

| 欄位 | 型別 | 說明 |
|------|------|------|
| `id` | int(10) PK | 使用者 ID |
| `username` | text | 帳號名稱 |
| `password` | text | 密碼（明文，競賽環境） |
| `email` | text | 電子郵件 |
| `header` | text | 頭像檔案名稱（存放於 `img/`） |
| `bio` | text | 個人簡介 |

### 4.2 `articles` 資料表

| 欄位 | 型別 | 說明 |
|------|------|------|
| `id` | int(10) PK | 文章 ID |
| `user_id` | int(10) FK | 作者 user id |
| `title` | text | 文章標題 |
| `content` | text | 文章內容 |
| `created_at` | timestamp | 建立時間（預設 `current_timestamp()`） |

### 4.3 `friends` 資料表

| 欄位 | 型別 | 說明 |
|------|------|------|
| `id` | int(10) PK | 紀錄 ID |
| `requester_id` | int(10) | 發送申請者的 user id |
| `addressee_id` | int(10) | 收到申請者的 user id |
| `status` | text | `'pending'`（待確認）或 `'accept'`（已接受） |
| `created_at` | timestamp | 申請時間 |
| `updated_at` | timestamp | 更新時間 |

### 4.4 `games` 資料表

| 欄位 | 型別 | 說明 |
|------|------|------|
| `id` | int(10) PK | 遊戲 ID |
| `title` | text | 遊戲名稱 |
| `description` | text | 遊戲簡介 |
| `cover` | text | 封面圖路徑（如 `games/1/cover.svg`） |

**現有遊戲資料：**

| ID | 名稱 | 說明 |
|----|------|------|
| 1 | 數字挑戰 | 依序點擊數字，按升序完成挑戰 |
| 2 | 記憶挑戰 | 翻開圖案相同的卡牌即可得分 |
| 3 | 反應力測試 | 看到綠色畫面就立刻點擊，測試反應速度 |
| 4 | 打地鼠 | 地鼠冒出來就點擊，30 秒內打越多分越高 |
| 5 | 滑動拼圖 | 移動方塊讓數字從 1 排列到 8，用最少步數完成 |

### 4.5 `scores` 資料表

| 欄位 | 型別 | 說明 |
|------|------|------|
| `id` | int(10) PK | 紀錄 ID |
| `game_id` | int(10) | 對應遊戲 ID |
| `player_name` | text | 玩家名稱 |
| `score` | int(11) | 分數 |

---

## 5. 專案檔案結構

```
th56j_national/
├── index.php                    # ★ 主入口；包含全域 Header 導覽列、session 引入
│
├── front/                       # 所有前端頁面（SPA 子頁面，透過 $.load() 載入）
│   ├── Home-main.php            # 首頁：文章列表 + 公告 Tab
│   ├── article.php              # 文章內容頁
│   ├── profile-page.php         # 個人頁面（含頭像上傳、簡介編輯、發文列表）
│   ├── add-article.php          # 發表文章表單
│   ├── login.php                # 登入頁面
│   ├── register.php             # 註冊頁面
│   ├── friends-page.php         # 好友系統主頁（搜尋、好友列表、申請管理）
│   ├── friend-profile-page.php  # 好友個人頁面（含好友互動操作）
│   ├── games.php                # 遊戲列表頁
│   └── game-play.php            # 遊戲內容頁（iframe + 動態排行榜）
│
├── api/                         # 後端 API（PHP，回應 JSON 或 HTML 片段）
│   ├── db.php                   # ★ 資料庫 PDO 連線 + session_start()
│   ├── login.php                # 登入驗證，成功寫入 session
│   ├── logout.php               # 登出，清除 session 後 redirect
│   ├── register.php             # 註冊，帳號重複檢查後 INSERT
│   ├── add_article.php          # 新增文章，回傳新文章 ID
│   ├── update_avatar.php        # 更新頭像（Base64 解碼後存檔 + DB 更新）
│   ├── update_bio.php           # 更新個人簡介
│   ├── search_users.php         # 搜尋使用者（回傳 HTML 片段）
│   └── set_friend.php           # 好友操作（apply / accept / cancel / reject / remove）
│
├── games/                       # 遊戲資料夾
│   ├── 1/ ~ 5/                  # 5 個遊戲子目錄
│   │   ├── game.json            # 遊戲設定（entry.url、score.pullUrl、score.columns）
│   │   ├── index.html           # 遊戲本體
│   │   ├── cover.svg            # 遊戲封面圖
│   │   ├── scores.json          # 分數資料（靜態測試資料）
│   │   └── api/
│   │       └── pull_score.php   # 排行榜 API（讀取 scores.json 回傳 JSON 陣列）
│   └── games.sql                # games 資料表建立語法
│
├── assets/
│   ├── css/
│   │   └── index.css            # 自訂樣式（卡片懸停、頭像圓形等）
│   ├── js/
│   │   ├── index.js             # loadpage() 核心函式
│   │   ├── jquery-3.7.1.min.js  # jQuery 本地備份
│   │   └── jquery.js            # jQuery 完整版
│   └── img/
│       └── logo.png             # FunTech LOGO
│
├── img/                         # 使用者頭像存放目錄
│   ├── default_header.jpg       # 預設頭像
│   ├── mack.jpg / judy.jpg ...  # 各使用者頭像
│
├── document/                    # 文件資料夾
│   ├── articles/                # 文章素材 (article01.txt ~ article36.txt)
│   └── users/                   # 使用者資料素材
│
├── doc/                         # 競賽原始文件
│   └── 表件04_命題用9-1_競賽試題及說明.pdf
│
├── game fast cosole/            # 遊戲快速通關工具（開發輔助）
│   ├── console.js               # 快速通關注入腳本
│   └── README.md                # 使用說明
│
├── ic_console_test/             # 自動化測試工具
│   └── index.html
│
├── db21 (2).sql                 # ★ 完整資料庫匯出（含資料表結構與測試資料）
└── README.md                    # 專案進度追蹤文件（v1）
```

---

## 6. 模組 1：視覺與網頁介面設計

### 試題要求

製作「FunTech 社群網站」的視覺設計，包含：

- **LOGO 標誌**：可辨識的 FunTech 品牌識別
- **ICON**：各功能區域適用的圖示設計
- **網頁介面**：整體視覺風格設計

### 專案現況

| 項目 | 現況說明 |
|------|---------|
| LOGO | 已提供 `assets/img/logo.png`（圓形裁切，顯示於 Navbar） |
| ICON | 以 Emoji 取代（🏠 首頁、🎮 遊戲、👥 好友、🔐 登入等） |
| UI 風格 | Bootstrap 4 深色 Navbar + 白色卡片式版面，`#f5f6fa` 灰底背景 |
| 卡片互動 | `card:hover` 有上浮 + 陰影加深動畫效果 |

> ⚠️ 模組 1 的視覺評分屬「主觀評分」，本版本以功能完整性為優先，視覺精緻度仍有提升空間。

---

## 7. 模組 2 — 項目 1：首頁版面設計與個人頁面功能開發

### 7.1 首頁（`index.php` + `front/Home-main.php`）

#### 試題規格與實作狀態

**DOM 結構要求：**

| 需求說明 | CSS Selector | 狀態 |
|---------|-------------|------|
| 首頁根容器 | `#home` | ✅ |
| 頁首導覽列容器 | `header.site-header` | ✅ |
| FunTech Logo（可點擊回首頁） | `.site-header .brand a.brand-link` | ✅ |
| 主要導覽列容器 | `.site-header nav.main-nav` | ✅ |
| 「首頁」連結 | `nav.main-nav a.home-link` | ✅ |
| 「遊戲」連結 | `nav.main-nav a.games-link` | ✅ |
| 「好友」連結 | `nav.main-nav a.friends-link` | ✅ |
| 使用者區域容器 | `.site-header .user-area` | ✅ |
| 未登入：「登入」連結 | `.user-area a.login-link` | ✅ |
| 未登入：「註冊」連結 | `.user-area a.register-link` | ✅ |
| 已登入：使用者名稱/頭像區塊 | `.user-area .user-badge` | ✅ |
| 已登入：個人頁面入口 | `.user-area a.profile-link` | ✅ |
| 已登入：「登出」連結 | `.user-area a.logout-link` | ✅ |
| 文章區塊容器 | `section.articles` | ✅ |
| 文章列表項目 | `section.articles article.article-item` | ✅ |
| 文章標題 | `.article-item .article-title` | ✅ |
| 發布日期 | `.article-item time.article-date` | ✅ |
| 文章摘要 | `.article-item .article-excerpt` | ✅ |
| 「閱讀更多」連結 | `.article-item a.article-readmore` | ✅ |
| 通知／公告容器 | `aside.notifications` | ✅ |
| 通知列表項目 | `aside.notifications .notification-item` | ✅ |
| 通知標題 | `.notification-item .notification-title` | ✅ |
| 通知日期 | `.notification-item time.notification-date` | ✅ |

#### 實作說明

首頁採用 Tab 切換設計，分為「📰 文章」與「📢 公告」兩個 Tab：

- **文章列表**：從資料庫 `articles` 資料表以 `JOIN users` 取得最新 10 筆，動態渲染。
- **公告列表**：目前為靜態佔位（5 則），日期顯示當前時間。

```php
// front/Home-main.php 核心查詢
$articles = $pdo->query(
    "SELECT articles.*, users.username 
     FROM articles 
     LEFT JOIN users ON articles.user_id = users.id 
     ORDER BY articles.created_at DESC LIMIT 10"
)->fetchAll();
```

---

### 7.2 文章內容頁（`front/article.php`）

| 需求說明 | CSS Selector | 狀態 |
|---------|-------------|------|
| 文章內容頁根容器 | `#article` | ✅ |
| 標題區塊 | `#article header.article-header` | ✅ |
| 文章標題 | `.article-header h1.article-title` | ✅ |
| 文章發布日期 | `.article-header time.article-date` | ✅ |
| 文章內容區塊 | `#article section.article-body` | ✅ |

透過 GET 參數 `?id=` 取得文章 ID，向 `articles` 資料表查詢並渲染。

---

### 7.3 個人頁面（`front/profile-page.php`）

| 需求說明 | CSS Selector | 狀態 |
|---------|-------------|------|
| 個人頁面根容器 | `#profile-page` | ✅ |
| 使用者資訊區塊 | `section.profile-header` | ✅ |
| 使用者頭像 | `.profile-header img.profile-avatar` | ⚠️ 見備註 |
| 使用者名稱 | `.profile-header .profile-username` | ✅ |
| 簡介文字 | `.profile-header .profile-bio` | ✅ |
| 點擊頭像觸發上傳 → 即時更新 | `textarea.profile-bio-input`（簡介編輯） | ✅ |
| 發表文章連結（已登入才顯示） | `a.new-post-link` | ✅ |
| 文章表單容器 | `form.article-create-form` | ✅ |
| 標題輸入欄 | `.article-create-form input.article-title-input` | ✅ |
| 內容輸入欄 | `.article-create-form textarea.article-content-input` | ✅ |
| 發布按鈕 | `.article-create-form button.article-submit-button` | ✅ |
| 發表成功 → alert「發表成功」→ 跳轉 | — | ✅ |
| 使用者文章列表容器 | `section.profile-articles` | ✅ |
| 每篇文章項目 | `.profile-articles .article-item` | ✅ |
| 文章標題 | `.article-item .article-title` | ✅ |
| 發佈日期 | `.article-item time.article-date` | ✅ |
| 閱讀文章連結 | `.article-item a.article-readmore` | ✅ |
| 無文章時顯示「目前尚無文章」 | `.profile-articles .empty-article-message` | ✅ |

> ⚠️ **備註（待修正）**：目前 `img` 的 class 誤植為 `profile-avater`（少一個 `r`），應改為 `profile-avatar`，否則自動化測試此項目將失敗。

#### 頭像上傳實作流程

```
使用者點擊頭像
    → 觸發 <input type="file"> 的 change 事件
    → FileReader 讀取為 Base64 字串
    → AJAX POST 至 api/update_avatar.php
    → 後端解碼 Base64 → 存至 img/{username}.jpg
    → 更新 users.header 欄位
    → 前端即時更換 img.src
```

#### 簡介編輯實作流程

```
使用者點擊 .show-bio 區塊
    → 切換顯示 <input#bio>（隱藏文字）
    → 輸入新簡介後按 Enter
    → AJAX POST 至 api/update_bio.php
    → 更新 users.bio 欄位
    → 前端即時更新 .show-bio 文字
```

---

## 8. 模組 2 — 項目 2：會員登入與註冊系統

### 8.1 登入頁面（`front/login.php` + `api/login.php`）

| 需求說明 | CSS Selector | 狀態 |
|---------|-------------|------|
| 登入表單容器 | `form.login-form` | ✅ |
| 帳號輸入欄 | `.login-form input.username-input` | ✅ |
| 密碼輸入欄 | `.login-form input.password-input` | ✅ |
| 登入送出按鈕 | `.login-form button.login-submit-button` | ✅ |
| 送出後驗證並登入 | — | ✅ |

#### 後端邏輯（`api/login.php`）

```php
// 驗證帳密
$chk = $pdo->query("SELECT count(*) FROM users 
    WHERE username='{$_POST['username']}' 
    AND password='{$_POST['password']}'")->fetchColumn();

if ($chk) {
    $_SESSION['user']    = $_POST['username'];  // 儲存使用者名稱
    $_SESSION['num']     = $_POST['username'];  // 搜尋用別名
    $_SESSION['user_id'] = /* 查詢取得 id */;   // 儲存使用者 ID
    echo $chk; // 回傳 1
} else {
    echo 0;
}
```

登入成功後前端呼叫 `location.reload()` 重新整理，由 PHP session 判斷顯示登入/登出狀態。

---

### 8.2 註冊頁面（`front/register.php` + `api/register.php`）

| 需求說明 | CSS Selector | 狀態 |
|---------|-------------|------|
| 註冊表單容器 | `form.register-form` | ✅ |
| 帳號輸入欄 | `.register-form input.username-input` | ✅ |
| Email 欄位 | `.register-form input.email-input` | ✅ |
| 密碼輸入欄 | `.register-form input.password-input` | ✅ |
| 確認密碼欄位 | `.register-form input.password-confirm-input` | ✅ |
| 註冊送出按鈕 | `.register-form button.register-submit` | ✅ |
| 送出後建立新帳號 | — | ✅ |
| 成功後導向登入頁 | — | ✅ |
| 帳號重複或格式錯誤顯示 alert | — | ✅ |

前端在送出前會先檢查兩次密碼是否一致，不一致時 `alert("兩次密碼不一致，請重新輸入")` 並中止送出。

---

### 8.3 登出（`api/logout.php`）

| 需求說明 | CSS Selector | 狀態 |
|---------|-------------|------|
| 登出功能（清除 session） | `a.logout-link` | ✅ |

---

## 9. 模組 2 — 項目 3：好友系統

### 9.1 好友頁面（`front/friends-page.php`）

| 需求說明 | CSS Selector | 狀態 |
|---------|-------------|------|
| 好友頁主容器 | `#friends-page` | ✅ |
| 搜尋功能區塊 | `#friends-page .friend-search-section` | ✅ |
| 好友列表區塊 | `#friends-page .friend-list-section` | ✅ |
| 收到的好友邀請區塊 | `#friends-page .incoming-requests-section` | ✅ |
| 送出的好友申請區塊 | `#friends-page .sent-requests-section` | ✅ |

> 未登入時自動重新導向登入頁。

---

### 9.2 搜尋使用者

| 需求說明 | CSS Selector | 狀態 |
|---------|-------------|------|
| 搜尋表單 | `form.friend-search-form` | ✅ |
| 搜尋輸入欄 | `.friend-search-form input.search-input` | ✅ |
| 搜尋按鈕 | `.friend-search-form button.search-submit-button` | ✅ |
| 搜尋結果容器 | `.friend-search-section .search-result-list` | ✅ |
| 每筆搜尋結果 | `.search-result-list .search-result-item` | ✅ |
| 使用者名稱 | `.search-result-item .result-username` | ✅ |
| 前往個人頁面連結 | `.search-result-item a.view-profile-link` | ✅ |

後端 `api/search_users.php` 使用 `LIKE '%keyword%'` 模糊搜尋，並自動過濾掉自己（`$_SESSION['num']`），回傳 HTML 片段直接渲染至結果區塊。

---

### 9.3 我的好友列表

| 需求說明 | CSS Selector | 狀態 |
|---------|-------------|------|
| 好友列表標題「好友列表」 | `.friend-list-section .section-title` | ✅ |
| 好友列表項目 | `.friend-list-section .friend-item` | ✅ |
| 好友頭像 | `.friend-item img.friend-avatar` | ✅ |
| 好友名稱 | `.friend-item .friend-name` | ✅ |
| 點擊好友導向個人頁面 | — | ✅ |

查詢條件：`friends WHERE (requester_id=我 OR addressee_id=我) AND status='accept'`

---

### 9.4 收到的好友申請

| 需求說明 | CSS Selector | 狀態 |
|---------|-------------|------|
| 區塊標題「收到的好友申請」 | `.incoming-requests-section .section-title` | ✅ |
| 申請列表項目 | `.incoming-requests-section .request-item` | ✅ |
| 申請者頭像 | `.request-item img.request-avatar` | ✅ |
| 申請者名稱 | `.request-item .request-username` | ✅ |
| 接受按鈕 | `.request-item button.accept-request-button` | ✅ |
| 拒絕按鈕 | `.request-item button.reject-request-button` | ✅ |
| 接受後建立好友關係 | — | ✅ |
| 拒絕後從列表移除 | — | ✅ |

---

### 9.5 送出的好友申請

| 需求說明 | CSS Selector | 狀態 |
|---------|-------------|------|
| 區塊標題「發送的好友申請」 | `.sent-requests-section .section-title` | ✅ |
| 申請列表項目 | `.sent-requests-section .request-item` | ✅ |
| 對方頭像 | `.request-item img.request-avatar` | ✅ |
| 對方名稱 | `.request-item .request-username` | ✅ |
| 取消申請按鈕 | `.request-item button.cancel-request-button` | ✅ |
| 取消申請後移除項目 | — | ✅ |

---

### 9.6 好友 API（`api/set_friend.php`）

所有好友操作透過 GET 參數 `?action=<動作>&friend_id=<對象ID>` 呼叫，回傳 JSON：

```json
{ "success": true, "message": "操作說明文字" }
```

| `action` 值 | 說明 | SQL 操作 |
|------------|------|---------|
| `apply` | 發送好友申請 | INSERT `status='pending'` |
| `accept` | 接受好友申請 | UPDATE `status='accept'` |
| `cancel` | 取消自己的申請 | DELETE |
| `reject` | 拒絕對方的申請 | DELETE |
| `remove` | 移除好友 | DELETE |

---

### 9.7 好友個人頁面（`front/friend-profile-page.php`）

| 需求說明 | CSS Selector | 狀態 |
|---------|-------------|------|
| 好友個人頁面根容器 | `#profile-page` | ✅ |
| 使用者資訊區塊 | `#profile-page .profile-header` | ✅ |
| 使用者名稱 | `.profile-header .profile-username` | ✅ |
| 頭像 | `.profile-header img.profile-avatar` | ✅ |
| 簡介文字 | `.profile-header .profile-bio` | ✅ |
| 文章展示區 | `#profile-page .profile-content` → `section.articles` | ✅ |
| 好友互動操作區 | `#profile-page .profile-friend-actions` | ✅ |

好友狀態判斷邏輯（依 `friends` 資料表的 `status` 欄位動態顯示不同按鈕）：

| 狀態 | 顯示內容 |
|------|---------|
| 無關係 | 「＋ 申請好友」按鈕 |
| 我送出申請中 | 「取消申請」按鈕 |
| 對方送出申請中 | 「接受好友」+ 「拒絕」按鈕 |
| 已是好友 | 「✓ 已是好友」標籤 + 「取消好友」按鈕 |

> ⚠️ **待修正**：`friend-profile-page.php` 中 `$is_requester` / `$is_addressee` 的 status 比對值誤寫為 `'pendding'`（多一個 d），應改為 `'pending'`，否則好友申請狀態判斷將永遠為 `false`，按鈕無法正確切換。

---

## 10. 模組 2 — 項目 4：遊戲頁面

### 10.1 `game.json` 設定格式

每個遊戲資料夾下必定包含 `game.json`，格式如下：

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

| 欄位 | 說明 |
|------|------|
| `entry.url` | 遊戲入口網址，載入於 iframe |
| `score.pullUrl` | 排行榜資料 API（回傳 JSON 陣列） |
| `score.columns` | 排行榜欄位名稱清單 |

排行榜 API 回傳格式範例（`scores.json`）：

```json
[
  { "玩家名稱": "小明", "分數": 95000 },
  { "玩家名稱": "阿傑", "分數": 89000 },
  { "玩家名稱": "Wei",  "分數": 82500 }
]
```

---

### 10.2 遊戲列表頁（`front/games.php`）

| 需求說明 | CSS Selector | 狀態 |
|---------|-------------|------|
| 遊戲列表頁根容器 | `#games` | ✅ |
| 遊戲列表容器 | `#games section.game-list` | ✅ |
| 遊戲項目 | `.game-list .game-item` | ✅ |
| 遊戲封面圖 | `.game-item img.game-cover` | ✅ |
| 遊戲名稱 | `.game-item .game-title` | ✅ |
| 遊戲簡介 | `.game-item .game-description` | ✅ |
| 開始遊戲連結 | `.game-item a.play-game-link` | ✅ |
| 點擊連結導向遊戲內容頁 | — | ✅ |

從 `games` 資料表讀取所有遊戲，渲染為卡片網格（`col-12 col-md-6 col-lg-4`）。

---

### 10.3 遊戲內容頁（`front/game-play.php`）

| 需求說明 | CSS Selector | 狀態 |
|---------|-------------|------|
| 遊戲內容頁根容器 | `#game-play` | ✅ |
| 顯示遊戲名稱 | `.current-game-title` | ✅ |
| 遊戲區域容器 | `#game-play section.game-area` | ✅ |
| 以 iframe 載入遊戲 | `section.game-area iframe.game-frame` | ✅ |
| 排行榜區塊 | `aside.game-leaderboard` | ✅ |
| 排行榜標題 | `.game-leaderboard .leaderboard-title` | ✅ |
| 排行榜資料項目 | `.game-leaderboard .leaderboard-item` | ✅ |
| 顯示名次 + API 所有欄位 | `.leaderboard-item .player-rank` | ✅ |
| 空資料顯示「目前尚無分數紀錄」 | — | ✅ |

#### 排行榜動態載入實作

後端以 PHP 讀取 `game.json`，取得 `entry.url` 與 `score.pullUrl`，前端 JavaScript 呼叫 API：

```javascript
$.get("<?= $game_setting->score->pullUrl ?>", function(ranks) {
  if (ranks.length > 0) {
    ranks.forEach(function(item, idx) {
      // 依名次顯示金/銀/銅/普通 badge
      var row = '<div class="row ...leaderboard-item...">'
        + '<div class="col-3"><span class="badge ...player-rank...">' + (idx + 1) + '</span></div>'
        + '<div class="col-6 font-weight-bold">' + item['玩家名稱'] + '</div>'
        + '<div class="col-3 text-primary font-weight-bold">' + item['分數'] + '</div>'
        + '</div>';
      $("#leaderboard").append(row);
    });
  } else {
    $("#leaderboard").html('<div class="text-center py-5 text-muted">目前尚無分數紀錄</div>');
  }
});
```

---

## 11. 模組 2 — 項目 5：Web API 開發

### 試題說明

> ⚠️ **競賽當天公布題目，本文件無法預先完整規格化。**

### 已知基本需求

- 所有 API 回應使用 **JSON 格式**（`header("Content-Type: application/json")`）
- 需實作基本的**錯誤處理**
- API 資料需與系統同步（後台有 N 筆資料，API 也需回傳 N 筆）

### 選手提示（官方）

1. 在瀏覽器上看到格式不同不影響結果，只要資料內容正確即可。
2. API 所呈現的資料必須與系統同步。

### 現有可參考的 API 架構

專案中 `api/set_friend.php` 已有完整的 JSON 回應範例可供參考：

```php
<?php
header("Content-Type: application/json");
include_once "db.php";

// ... 業務邏輯 ...

echo json_encode(['success' => true, 'message' => '操作說明']);
```

---

## 12. 已知問題與待修正事項

| 優先 | 項目 | 問題說明 | 解決方法 |
|------|------|---------|---------|
| 🔴 高 | **好友頁面：Typo** | `friend-profile-page.php` 第 12 行，`$is_requester` 與 `$is_addressee` 比對 `status=='pendding'`，多了一個 d，導致申請中狀態永遠判斷錯誤 | 將 `'pendding'` 改為 `'pending'` |
| 🔴 高 | **個人頁面：class 誤植** | `profile-page.php` 中頭像 `<img>` 的 class 為 `profile-avater`，拼字錯誤（少一個 r），影響自動化測試 | 改為 `profile-avatar` |
| 🟡 中 | **項目5：Web API** | 競賽當天公布，尚無法預先實作 | 等待題目後快速開發 |
| 🟡 中 | **帳號密碼設定** | `api/db.php` 中目前使用 `root` 帳號與空密碼，競賽環境需改為 `webXX` / `1234` | 競賽開始後立即修改 |
| 🟡 中 | **資料庫名稱** | 目前連線 `db21`，競賽環境需改為 `webXX_db` | 競賽開始後立即修改 |
| 🟡 中 | **SQL Injection 風險** | 多處直接拼接 SQL（未使用 Prepared Statement），存在安全風險 | 此為競賽環境，以功能完整性優先；正式環境應全面使用 PDO bindParam |
| 🟢 低 | **模組1：視覺設計** | LOGO 僅使用提供的 png，ICON 全為 Emoji | 競賽結束前可優化視覺呈現 |
| 🟢 低 | **公告系統** | 通知／公告目前為靜態佔位，日期顯示當前時間，無資料庫支撐 | 若評分有需求，可增加 `notifications` 資料表 |
| 🟢 低 | **程式碼整理** | 部分檔案有殘留 `console.log`，CSS class 命名可統一 | 比賽前清理 |

---

## 13. CSS Selector 完整速查表

以下為所有評分自動化測試所需的 CSS Selector 完整彙整：

### 導覽列（全站共用 `index.php`）

```
header.site-header
.site-header .brand a.brand-link
.site-header nav.main-nav
nav.main-nav a.home-link
nav.main-nav a.games-link
nav.main-nav a.friends-link
.site-header .user-area
.user-area a.login-link
.user-area a.register-link
.user-area .user-badge
.user-area a.profile-link
.user-area a.logout-link
```

### 首頁（`#home`）

```
#home
section.articles
section.articles article.article-item
.article-item .article-title
.article-item time.article-date
.article-item .article-excerpt
.article-item a.article-readmore
aside.notifications
aside.notifications .notification-item
.notification-item .notification-title
.notification-item time.notification-date
```

### 文章內容頁（`#article`）

```
#article
#article header.article-header
.article-header h1.article-title
.article-header time.article-date
#article section.article-body
```

### 個人頁面（`#profile-page`）

```
#profile-page
section.profile-header
.profile-header img.profile-avatar
.profile-header .profile-username
.profile-header .profile-bio
.profile-header textarea.profile-bio-input
a.new-post-link
form.article-create-form
.article-create-form input.article-title-input
.article-create-form textarea.article-content-input
.article-create-form button.article-submit-button
section.profile-articles
.profile-articles .article-item
.article-item .article-title
.article-item time.article-date
.article-item a.article-readmore
.profile-articles .empty-article-message
```

### 登入頁面

```
form.login-form
.login-form input.username-input
.login-form input.password-input
.login-form button.login-submit-button
```

### 註冊頁面

```
form.register-form
.register-form input.username-input
.register-form input.email-input
.register-form input.password-input
.register-form input.password-confirm-input
.register-form button.register-submit
```

### 好友頁面（`#friends-page`）

```
#friends-page
#friends-page .friend-search-section
#friends-page .friend-list-section
#friends-page .incoming-requests-section
#friends-page .sent-requests-section
form.friend-search-form
.friend-search-form input.search-input
.friend-search-form button.search-submit-button
.friend-search-section .search-result-list
.search-result-list .search-result-item
.search-result-item .result-username
.search-result-item a.view-profile-link
.friend-list-section .section-title
.friend-list-section .friend-item
.friend-item img.friend-avatar
.friend-item .friend-name
.incoming-requests-section .section-title
.incoming-requests-section .request-item
.request-item img.request-avatar
.request-item .request-username
.request-item button.accept-request-button
.request-item button.reject-request-button
.sent-requests-section .section-title
.sent-requests-section .request-item
.request-item button.cancel-request-button
```

### 好友個人頁面

```
#profile-page
#profile-page .profile-header
.profile-header .profile-username
.profile-header img.profile-avatar
.profile-header .profile-bio
#profile-page .profile-content
section.articles
section.articles article.article-item
.article-item .article-title
.article-item time.article-date
.article-item .article-excerpt
.article-item a.article-readmore
#profile-page .profile-friend-actions
```

### 遊戲列表頁（`#games`）

```
#games
#games section.game-list
.game-list .game-item
.game-item img.game-cover
.game-item .game-title
.game-item .game-description
.game-item a.play-game-link
```

### 遊戲內容頁（`#game-play`）

```
#game-play
.current-game-title
#game-play section.game-area
section.game-area iframe.game-frame
aside.game-leaderboard
.game-leaderboard .leaderboard-title
.game-leaderboard .leaderboard-item
.leaderboard-item .player-rank
```

---

## 14. 名次同分決定方式

依據官方試題，同分時依以下順序決定排名：

1. **交卷時間先後**：較早者排名先（競賽結束前 10 分鐘到結束，時間比序等級視同相同）
2. **評分項次得分**：時間相同時，從第 1 項次逐項比較得分，得分高者排名先
3. **主觀評分「網站設計整體性」**：以上均相同時，由所有裁判共同評分，依得分高低決定

---

*文件根據官方競賽試題（PDF）及專案原始碼（v2）自動整理產生*  
*第 56 屆全國技能競賽 ‧ 網頁技術青少年組 ‧ FunTech 社群網站*