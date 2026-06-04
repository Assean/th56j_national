# FunTech 社群遊戲平台 — 第四版發布文件（PHP 版）

> **版本：** v4-php　｜　**發布日期：** 2026-06-04　｜　**開發者：** sean（y20120816s@gmail.com）
>
> **Git 分支：** `v4-php`　｜　**資料庫：** MariaDB 10.4 / MySQL（`db21`）　｜　**後端語言：** PHP 8.2

---

## 目錄

1. [專案概述](#1-專案概述)
2. [試題需求說明（PDF 規格對照）](#2-試題需求說明)
3. [版本演進歷程](#3-版本演進歷程)
4. [系統架構](#4-系統架構)
5. [資料庫設計](#5-資料庫設計)
6. [頁面與功能說明](#6-頁面與功能說明)
7. [遊戲模組說明](#7-遊戲模組說明)
8. [前端技術棧](#8-前端技術棧)
9. [部署與環境需求](#9-部署與環境需求)
10. [已知問題與改進方向](#10-已知問題與改進方向)

---

## 1. 專案概述

**FunTech** 是一個結合社群互動與小遊戲娛樂的全端網頁平台。使用者可以在平台上完成會員註冊與登入、管理個人頁面、發表與閱讀文章、進行好友交流，並挑戰五款內建的休閒小遊戲，透過全球排行榜比拼分數。

本次為**第四版（PHP 版）**，將原先的靜態或純前端架構全面重構為以 **PHP + MySQL / PDO** 為核心的伺服器端渲染（SSR）架構，並改用 **Bootstrap 5** 作為 UI 框架，提供穩定的後端資料持久化能力。

---

## 2. 試題需求說明

> 本節依照競賽 PDF 試題的要求，逐一列出對應的實作內容。

### 2.1 會員系統

| 試題要求 | 對應實作檔案 | 完成狀態 |
|---|---|---|
| 會員註冊（帳號、Email、密碼、確認密碼） | `register.php` | ✅ 完成 |
| 會員登入（帳號 + 密碼驗證，錯誤提示） | `login.php` | ✅ 完成 |
| 已登入自動跳轉首頁 | `login.php` / `register.php` | ✅ 完成 |
| 登出功能 | `api/logout.php` | ✅ 完成 |
| Session 管理（`$_SESSION['user']`、`$_SESSION['user_id']`） | `api/db.php` | ✅ 完成 |

### 2.2 個人頁面

| 試題要求 | 對應實作 | 完成狀態 |
|---|---|---|
| 顯示個人資訊（頭像、帳號名稱、個人簡介） | `profile.php` | ✅ 完成 |
| 頭像上傳（點擊即觸發，支援 jpg / png / gif） | `profile.php` + finfo MIME 驗證 | ✅ 完成 |
| 個人簡介編輯 | `profile.php` POST 表單 | ✅ 完成 |
| 顯示個人文章列表（含日期、標題、閱讀連結） | `profile.php` | ✅ 完成 |
| 個人頁面入口連結（發表文章按鈕） | `profile.php` | ✅ 完成 |

### 2.3 文章系統

| 試題要求 | 對應實作 | 完成狀態 |
|---|---|---|
| 首頁顯示全站最新 10 篇文章（標題、作者、時間、摘要） | `index.php` | ✅ 完成 |
| 文章詳情頁（標題、日期、全文） | `article.php` | ✅ 完成 |
| 發表文章（標題 + 內容，空白驗證） | `add-article.php` | ✅ 完成 |
| 首頁分頁切換（文章 / 公告兩個 Tab） | `index.php` GET `tab` 參數 | ✅ 完成 |

### 2.4 好友系統

| 試題要求 | 對應實作 | 完成狀態 |
|---|---|---|
| 搜尋使用者（模糊搜尋 `LIKE '%keyword%'`） | `friends.php` | ✅ 完成 |
| 查看他人個人頁面 | `friend-profile.php` | ✅ 完成 |
| 申請好友 | `friends.php?action=apply` | ✅ 完成 |
| 接受好友申請 | `friends.php?action=accept` | ✅ 完成 |
| 拒絕好友申請 | `friends.php?action=reject` | ✅ 完成 |
| 取消已送出的好友申請 | `friends.php?action=cancel` | ✅ 完成 |
| 解除好友關係 | `friends.php?action=remove` | ✅ 完成 |
| 顯示「好友列表 / 收到的申請 / 發出的申請」三區塊 | `friends.php` | ✅ 完成 |

### 2.5 遊戲與排行榜

| 試題要求 | 對應實作 | 完成狀態 |
|---|---|---|
| 遊戲列表頁（封面圖、標題、簡介、開始遊戲連結） | `games.php` | ✅ 完成 |
| 遊戲畫面以 iframe 嵌入 | `game-play.php` | ✅ 完成 |
| 每款遊戲獨立排行榜（從 `scores.json` 讀取，可擴充為 DB） | `game-play.php` + `games/{id}/api/pull_score.php` | ✅ 完成 |
| 排行榜依分數排序，前三名特殊標示 | `game-play.php` Badge 顏色 | ✅ 完成 |
| 五款小遊戲（各自獨立 HTML，可脫離後端單獨運行） | `games/1~5/index.html` | ✅ 完成 |

### 2.6 版面與導覽

| 試題要求 | 對應實作 | 完成狀態 |
|---|---|---|
| 統一 Header（Logo、導覽連結、登入/登出按鈕） | `partials/header.php` | ✅ 完成 |
| 統一 Footer | `partials/footer.php` | ✅ 完成 |
| 未登入時隱藏部分功能（好友、個人頁面） | Session 判斷 | ✅ 完成 |
| 響應式設計（Bootstrap Grid） | Bootstrap 5 | ✅ 完成 |

---

## 3. 版本演進歷程

| 版本 | Git 標籤 / 分支 | 日期 | 主要特色 |
|---|---|---|---|
| v1 | `refs/heads/v1` | 2026-05-31 | 靜態版本，初步 HTML/CSS 結構建立 |
| v2 | `refs/heads/v2` | 2026-05-31 | 前端功能擴充，加入遊戲頁面基礎 |
| v3 | `refs/heads/v3` | 2026-05-31 | 介面優化、遊戲 iframe 架構完成 |
| **v4-php（本版）** | `refs/heads/v4-php` | 2026-05-31 ～ 2026-06-04 | **PHP 後端全面重構**，PDO MySQL，完整好友/文章/排行榜系統 |

### 本版主要 Commit 說明

```
cef75e0  第四版發布[PHP版]
8f3446c  遊戲版面調整以及快速通關修正第四版
116df6e  加入遊戲快速通關 console
b61a01b  遊戲頁面美化與排版調整，壓縮 Games 資料夾
416c9b7  實作好友功能以及按鈕切換
3bf9e5b  完成模糊搜尋功能
0803ab4  完成閱讀文章功能
68a5fe0  完成個人簡介編輯功能
27eb62d  完成頭像上傳功能（存入資料庫）
8b1cdef  加入 SQL 資料庫匯出檔
8a3c267  資料庫檔案調整（重命名為 db21.sql）
```

---

## 4. 系統架構

```
th56j_national/
├── api/
│   ├── db.php              ← PDO 連線 + session_start()（全站共用）
│   └── logout.php          ← 清除 Session，跳轉首頁
│
├── partials/
│   ├── header.php          ← 全站 Header（Logo + 導覽 + 登入狀態）
│   └── footer.php          ← 全站 Footer（引入 jQuery + Bootstrap JS）
│
├── games/
│   ├── 1/ ~ 5/             ← 各遊戲獨立資料夾
│   │   ├── index.html      ← 遊戲本體（純 HTML/JS，可獨立執行）
│   │   ├── game.json       ← 遊戲設定（entry URL + score 欄位定義）
│   │   ├── cover.svg       ← 遊戲封面圖
│   │   ├── scores.json     ← 靜態排行榜快取（離線備援）
│   │   └── api/
│   │       └── pull_score.php  ← 從 DB `scores` 表拉取即時排行
│
├── assets/
│   ├── css/  bootstrap.css、jquery-ui.css、index.css
│   ├── js/   jquery-3.7.1.min.js、bootstrap.js、vue.3.5.13.js、index.js
│   └── img/  logo.png
│
├── img/                    ← 使用者頭像上傳目錄（動態生成）
│
├── index.php               ← 首頁（文章列表 / 公告 Tab）
├── login.php               ← 會員登入
├── register.php            ← 會員註冊
├── profile.php             ← 個人頁面
├── add-article.php         ← 發表文章
├── article.php             ← 文章詳情
├── friends.php             ← 好友管理
├── friend-profile.php      ← 查看他人個人頁
├── games.php               ← 遊戲列表
└── game-play.php           ← 遊戲遊玩 + 排行榜
```

### 技術流程

```
瀏覽器 Request
    ↓
PHP 頁面（include api/db.php → PDO 連線 + Session）
    ↓
SQL Query（PDO query / exec）
    ↓
HTML 輸出（include partials/header + 內容 + footer）
    ↓
Bootstrap + jQuery 前端渲染
```

---

## 5. 資料庫設計

> 資料庫名稱：`db21`　｜　字元集：`utf8mb4 / utf8mb4_unicode_ci`

### 5.1 `users` — 使用者

| 欄位 | 型別 | 說明 |
|---|---|---|
| `id` | INT(10) PK AUTO_INCREMENT | 使用者 ID |
| `username` | TEXT NOT NULL | 帳號（登入用，顯示名稱） |
| `password` | TEXT NOT NULL | 密碼（明文儲存，詳見已知問題） |
| `email` | TEXT NOT NULL | 電子郵件 |
| `header` | TEXT | 頭像檔名（儲存於 `./img/`） |
| `bio` | TEXT | 個人簡介 |

### 5.2 `articles` — 文章

| 欄位 | 型別 | 說明 |
|---|---|---|
| `id` | INT UNSIGNED PK AUTO_INCREMENT | 文章 ID |
| `user_id` | INT UNSIGNED NOT NULL | 作者（FK → users.id） |
| `title` | TEXT NOT NULL | 標題 |
| `content` | TEXT NOT NULL | 內容 |
| `created_at` | TIMESTAMP DEFAULT current_timestamp() | 發文時間 |

### 5.3 `friends` — 好友關係

| 欄位 | 型別 | 說明 |
|---|---|---|
| `id` | INT PK AUTO_INCREMENT | 關係 ID |
| `requester_id` | INT NOT NULL | 申請者 user_id |
| `addressee_id` | INT NOT NULL | 被申請者 user_id |
| `status` | TEXT NOT NULL | `'pending'` / `'accept'` |
| `created_at` | TIMESTAMP | 申請時間 |
| `updated_at` | TIMESTAMP ON UPDATE | 狀態更新時間 |

### 5.4 `games` — 遊戲

| 欄位 | 型別 | 說明 |
|---|---|---|
| `id` | INT UNSIGNED PK AUTO_INCREMENT | 遊戲 ID |
| `title` | TEXT NOT NULL | 遊戲名稱 |
| `description` | TEXT NOT NULL | 遊戲簡介 |
| `cover` | TEXT NOT NULL | 封面圖路徑（SVG） |

### 5.5 `scores` — 排行榜分數

| 欄位 | 型別 | 說明 |
|---|---|---|
| `id` | INT UNSIGNED PK AUTO_INCREMENT | 紀錄 ID |
| `game_id` | INT UNSIGNED NOT NULL | 遊戲 ID（FK → games.id） |
| `player_name` | TEXT NOT NULL | 玩家名稱 |
| `score` | INT NOT NULL | 分數（由高到低排序） |
| `created_at` | TIMESTAMP | 紀錄時間 |

### 資料庫 ER 關係圖（文字版）

```
users ──< articles    (users.id = articles.user_id)
users ──< friends     (users.id = friends.requester_id / addressee_id)
games ──< scores      (games.id = scores.game_id)
```

---

## 6. 頁面與功能說明

### 6.1 首頁 `index.php`

首頁以 GET 參數 `?tab=articles`（預設）或 `?tab=notifications` 控制顯示內容：

- **文章 Tab**：從 `articles` 資料表 LEFT JOIN `users`，取最新 10 筆，顯示標題、作者、時間、50 字摘要與「More」連結。
- **公告 Tab**：靜態迴圈顯示 5 則公告（可擴充為資料庫驅動）。

### 6.2 登入 `login.php`

使用 `POST` 表單，以 SQL 查詢比對帳號密碼後建立 Session：

```php
$_SESSION['user']    = $chk['username'];
$_SESSION['user_id'] = $chk['id'];
```

已登入者自動重導至首頁。

### 6.3 註冊 `register.php`

驗證兩次密碼是否一致，並檢查帳號是否已存在後，執行 `INSERT INTO users`。成功後跳轉至登入頁。

### 6.4 個人頁面 `profile.php`

需登入才可存取（未登入跳轉至 `login.php`）。提供：

- **頭像上傳**：`<input type="file">` 觸發 form submit，以 `finfo` 驗證 MIME，刪除舊頭像後儲存新圖至 `./img/`，更新資料庫 `header` 欄位。
- **個人簡介**：即時 POST 更新 `bio` 欄位。
- **文章列表**：顯示該使用者所有文章，含日期與閱讀連結。

### 6.5 發表文章 `add-article.php`

需登入。驗證標題與內容非空後，INSERT 至 `articles`，並以 `lastInsertId()` 跳轉至剛發布的文章頁。

### 6.6 文章詳情 `article.php`

依 GET `?id=` 取得指定文章，使用 `nl2br(htmlspecialchars(...))` 保留換行並防 XSS，提供「返回列表」按鈕。

### 6.7 好友管理 `friends.php`

好友關係以 `friends` 表中的 `status` 欄位追蹤，分為三個區塊：

| 區塊 | 資料來源 | 功能 |
|---|---|---|
| 搜尋使用者 | GET `?search=` → LIKE 模糊查詢 | 找到後可查看個人頁面 |
| 好友列表 | `status='accept'` | 顯示雙向好友 |
| 收到的申請 | `addressee_id = $my AND status='pending'` | 接受 / 拒絕 |
| 發出的申請 | `requester_id = $my AND status='pending'` | 取消 |

所有好友操作透過 GET `?action=` 觸發，並以 `header Location` 重導防止 F5 重送。

### 6.8 他人個人頁 `friend-profile.php`

根據 `?id=` 顯示指定使用者的頭像、簡介與文章列表，並根據當前好友關係顯示對應的操作按鈕（申請 / 取消申請 / 接受拒絕 / 解除好友）。

### 6.9 遊戲列表 `games.php`

從 `games` 資料表讀取所有遊戲，以 Bootstrap Card Grid 顯示封面圖（SVG）、標題、說明與「開始遊戲」按鈕。

### 6.10 遊戲遊玩 `game-play.php`

讀取 `games/{id}/game.json` 設定：

- **`entry.url`**：以 iframe 嵌入遊戲主頁（高度 600px）
- **`score.columns`**：定義排行榜欄位名稱（玩家名稱 / 分數）
- 排行榜資料優先讀取 `games/{id}/scores.json`，未來可改由 API 端點 `pull_score.php` 提供即時資料庫資料

前三名分別以金（Warning）、銀（Light）、銅（Danger）Badge 標示。

---

## 7. 遊戲模組說明

每款遊戲位於 `games/{id}/`，架構獨立，可脫離後端單獨在瀏覽器執行。

| 遊戲 ID | 名稱 | 玩法說明 | 計分方式 |
|---|---|---|---|
| 1 | **數字挑戰** | 依照升序順序依序點擊畫面上的數字 | 依完成時間與正確率計分（最高分紀錄：95,000） |
| 2 | **記憶挑戰** | 翻牌找出兩兩相同的圖案 | 依配對數量與翻牌次數計分（最高分：1,280） |
| 3 | **反應力測試** | 畫面變綠時立即點擊，測試反應速度 | 依反應時間（毫秒）換算分數 |
| 4 | **打地鼠** | 30 秒內點擊隨機冒出的地鼠 | 每擊中一隻加分，計時結束結算 |
| 5 | **滑動拼圖** | 移動空格使數字 1～8 依序排列 | 依完成步數計分，步數越少分數越高 |

### 遊戲設定格式（`game.json`）

```json
{
  "entry": {
    "url": "games/{id}/index.html"
  },
  "score": {
    "pullUrl": "games/{id}/api/pull_score.php",
    "columns": ["玩家名稱", "分數"]
  }
}
```

### 排行榜 API（`pull_score.php`）

從 `scores` 資料表以 `game_id` 過濾，依 `score DESC, created_at ASC` 排序後回傳 JSON 陣列：

```json
[
  { "玩家名稱": "小明", "分數": 95000 },
  { "玩家名稱": "阿傑", "分數": 89000 }
]
```

---

## 8. 前端技術棧

| 項目 | 版本 | 用途 |
|---|---|---|
| Bootstrap | 5.x（本地） | RWD 版面、元件樣式 |
| jQuery | 3.7.1（本地） | DOM 操作、AJAX（備用） |
| Vue.js | 3.5.13（本地，備用） | 前端框架（保留，未全面啟用） |
| jQuery UI | 含（本地） | 拖曳、互動元件（備用） |

所有前端資源均以本地檔案方式引用（`./assets/`），無需網路連線即可運行。

---

## 9. 部署與環境需求

### 環境需求

| 項目 | 需求 |
|---|---|
| Web Server | Apache 2.4+ 或 Nginx（需支援 PHP） |
| PHP | 8.0 以上（建議 8.2） |
| MySQL / MariaDB | 10.4+（建議） |
| PHP 擴充 | `pdo_mysql`、`fileinfo`、`session` |

### 資料庫初始化

1. 建立資料庫：

```sql
CREATE DATABASE db21 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. 匯入 SQL 檔案（`db21.sql`）：

```bash
mysql -u root -p db21 < db21.sql
```

3. 確認資料表（`users`、`articles`、`friends`、`games`、`scores`）已建立完成。

### 資料庫連線設定（`api/db.php`）

```php
$dsn = "mysql:host=localhost;dbname=db21;charset=utf8";
$pdo = new PDO($dsn, 'root', '');
```

> 正式環境請修改帳號密碼，並移至環境變數管理。

### 頭像上傳目錄

確保 `./img/` 目錄有寫入權限：

```bash
chmod 755 ./img
```

---

## 10. 已知問題與改進方向

### 🔴 高優先

| 問題 | 說明 | 建議修正 |
|---|---|---|
| **密碼明文儲存** | `users.password` 儲存未加密的明文密碼 | 改用 `password_hash()` / `password_verify()` |
| **SQL Injection 風險** | 多處直接拼接 SQL 字串（如 `login.php`、`friends.php`） | 全面改用 PDO Prepared Statements + 綁定參數 |
| **任意路徑遍歷** | `game-play.php` 未驗證 `id` 對應的 `game.json` 路徑是否合法 | 加入白名單驗證或 `realpath()` 檢查 |

### 🟡 中優先

| 問題 | 說明 | 建議修正 |
|---|---|---|
| **公告為靜態資料** | `index.php` 公告 Tab 為 for 迴圈假資料 | 建立 `announcements` 資料表，支援後台管理 |
| **排行榜資料來源** | `game-play.php` 讀取本地 `scores.json` 而非 DB API | 改為 fetch `pull_score.php` 取得即時資料庫資料 |
| **頭像上傳無大小限制** | 未限制上傳檔案大小 | 加入 `$_FILES['header']['size']` 判斷 |
| **好友搜尋顯示自己** | 目前過濾邏輯在 PHP 端排除自己，效率較低 | 在 SQL WHERE 加入 `AND username != '$me'` |

### 🟢 功能擴充

| 建議功能 | 說明 |
|---|---|
| 文章留言 | 在 `article.php` 加入留言區塊，新增 `comments` 資料表 |
| 遊戲分數寫入 | 遊戲結束後呼叫 API 將分數寫入 `scores` 資料表 |
| 個人頭像裁切 | 引入前端裁圖工具（如 Cropper.js）再上傳 |
| HTTPS 強制跳轉 | 正式環境加入 HTTP→HTTPS 重導設定 |
| 管理後台 | 提供文章、使用者、遊戲的後台管理介面 |

---

## 附錄：預設測試帳號

| 帳號 | 密碼 | 備註 |
|---|---|---|
| `mack` | `1234` | 一般使用者，有頭像與簡介 |
| `judy` | `5678` | 一般使用者，有頭像與簡介 |
| `admin` | `1234` | 管理員帳號 |
| `gogolo` | `go` | 一般使用者 |

> ⚠️ 以上帳號均為測試用途，正式發布前請清除或更換。

---

## 附錄：預設角色人物（色彩介紹）

專案內含 12 位預設角色（`img/user_01.jpg` ～ `img/user_12.jpg`），皆為虛構高校人物設定，供前端展示與測試使用：

| 編號 | 帳號代稱 | 角色名稱 | 特色 |
|---|---|---|---|
| user_01 | haru | 林美晴 | 班長、活潑開朗 |
| user_02 | shun | 沈言修 | 古典文學社、沉穩冷靜 |
| user_03 | shiori | 白詩涵 | 家政社、害羞溫柔 |
| user_04 | van | 夏宇凡 | 輕音部吉他手、看似冷酷 |
| user_05 | yanni | 陳樂妍 | 田徑隊、陽光開朗 |
| user_06 | ian | 周律安 | 學生會書記、嚴謹有序 |
| user_07 | detective | 徐慕白 | 圖書委員、推理小說控 |
| user_08 | amethyst | 姜紫嫣 | 流行音樂社社長、個性獨特 |
| user_09 | lofi | 藍逸楓 | 常戴耳機、獨立音樂愛好者 |
| user_10 | podcast | 蘇哲宇 | 廣播社播音員、愛沉思 |
| user_11 | wei | 江雨薇 | 美術社、詩意雨天系 |
| user_12 | justin | 韓宥廷 | 園藝社、浪漫黃昏系 |

---

*文件生成時間：2026-06-04　｜　版本：v4-php Release*