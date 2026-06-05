# 第 56 屆全國技能競賽 — 網頁技術（J17）
## FunTech 社群網站｜競賽試題完整說明 × 第五版 Vue 開發專案

> **職類名稱：** 網頁技術（青少年組）
> **競賽時間：** 4 小時（競賽當天得有 30% 之調整）
> **專案版本：** 第五版（Vue 架構，單一 `index.php` SPA）
> **最後更新：** 2026-06-04

---

## 目錄

1. [競賽注意事項](#競賽注意事項)
2. [PDF 試題完整說明](#pdf-試題完整說明)
   - [模組 1：視覺設計](#模組-1視覺與網頁介面設計)
   - [模組 2：平台翻新與系統建置](#模組-2平台翻新與系統建置)
     - [項目 1：首頁與個人頁面](#項目-1首頁版面設計與個人頁面功能開發)
     - [項目 2：登入與註冊](#項目-2會員登入與註冊系統)
     - [項目 3：好友系統](#項目-3好友系統)
     - [項目 4：遊戲頁面](#項目-4遊戲頁面-games)
     - [項目 5：Web API 開發](#項目-5web-api-開發)
3. [專案架構總覽](#專案架構總覽)
4. [技術棧與設計決策](#技術棧與設計決策)
5. [資料庫設計](#資料庫設計)
6. [API 端點一覽](#api-端點一覽)
7. [功能實作狀態](#功能實作狀態)
8. [待修正事項](#待修正事項)
9. [遊戲系統說明](#遊戲系統說明)
10. [快速通關工具（Console 腳本）](#快速通關工具)
11. [競賽部署說明](#競賽部署說明)

---

## 競賽注意事項

以下為官方 PDF 試題中列出的選手應遵守事項：

1. 考試時間為 **4 小時**，時間有異動以大會規定為準。
2. 選手需自行安裝 **XAMPP**，設定 web server 及資料庫環境。
3. 每個工作崗位備有隨身碟，內含「**參考資料**」資料夾，作答時可參考使用。
4. 請依 `web+崗位編號`（例如 `web01`）在桌面建立資料夾，存放評分資料。
5. 網站首頁請設定為 `index.htm` 或 `index.php`。
6. **帳號密碼規則（未依規定扣總分 5 分）：**
   - 網頁帳號：`admin` / `1234`
   - 資料庫使用者：崗位編號（`webXX`）/ 密碼 `1234`
   - 資料庫名稱：`webXX_db`
7. 考試結束，資料全部收回（試題、評分表、資料片、空白紙）。
8. 每項評分均標明「**主觀**」或「**客觀**」評分。
9. **同分決定排名方式：**
   - 先以交卷時間先後排名（距結束前 10 分內視為同級）
   - 再依評分表項次得分逐一比較
   - 最後由裁判共同評分「網站設計整體性」主觀項目決定名次
10. 其他注意：
    - 表單除非特別說明，否則無須驗證資料有無填寫。
    - 除非特別說明要評美工，否則評分重點在功能完成與否。
    - 請隨時將作品存至隨身碟，避免意外。
    - 比賽結束時間到，**不可再操作電腦**，請勿關機以利評分。

---

## PDF 試題完整說明

### 模組 1：視覺與網頁介面設計

製作「**FunTech 社群網站**」視覺與網頁介面設計，包含：

- **LOGO 標誌**
- **ICON 圖示**
- **整體網頁介面**（版面配置、色彩風格、互動元素）

> 此模組為主觀評分，設計美感與整體一致性是重點。

---

### 模組 2：平台翻新與系統建置

FunTech 是一個為青少年打造的教育與娛樂社群網站，提供多元資訊頁面、會員登入系統及簡易遊戲平台。本次競賽要求在保留平台核心理念的前提下，全面重新設計版面與功能架構。

共分為以下五個項目：

---

### 項目 1：首頁版面設計與個人頁面功能開發

#### 1. 首頁（`#home`）

| 編號 | 需求說明 | 必要 CSS Selector |
|------|---------|-------------------|
| 1.1 | 首頁根容器 | `#home` |
| 1.2.1 | 頁首導覽列容器 | `header.site-header` |
| 1.2.2.1 | FunTech Logo（可點擊回首頁） | `.site-header .brand a.brand-link` |
| 1.2.2.2 | 主要導覽列容器 | `.site-header nav.main-nav` |
| 1.2.2.2.1 | 「首頁」連結 | `nav.main-nav a.home-link` |
| 1.2.2.2.2 | 「遊戲」連結 | `nav.main-nav a.games-link` |
| 1.2.2.2.3 | 「好友」連結 | `nav.main-nav a.friends-link` |
| 1.2.2.3 | 使用者區域容器 | `.site-header .user-area` |
| 1.2.2.3.1 | 未登入：「登入」＋「註冊」連結 | `.user-area a.login-link` / `.user-area a.register-link` |
| 1.2.2.3.2 | 已登入：名稱或頭像區塊、個人頁入口、登出 | `.user-area .user-badge` / `a.profile-link` / `a.logout-link` |
| 1.3.1 | 文章區塊容器 | `section.articles` |
| 1.3.2 | 文章列表（多筆，語意化元素） | `section.articles article.article-item` |
| 1.3.3.1 | 文章標題 | `.article-item .article-title` |
| 1.3.3.2 | 發布日期 | `.article-item time.article-date` |
| 1.3.3.3 | 文章摘要 | `.article-item .article-excerpt` |
| 1.3.3.4 | 「閱讀更多」連結（導向文章內容頁） | `.article-item a.article-readmore` |
| 1.4.1 | 通知／公告區塊容器 | `aside.notifications` |
| 1.4.2 | 通知列表（多則） | `aside.notifications .notification-item` |
| 1.4.3.1 | 通知標題 | `.notification-item .notification-title` |
| 1.4.3.2 | 通知發布日期 | `.notification-item time.notification-date` |

#### 2. 文章內容頁（`#article`）

| 編號 | 需求說明 | 必要 CSS Selector |
|------|---------|-------------------|
| 2.1 | 文章內容頁根容器 | `#article` |
| 2.2.1 | 文章標題區塊 | `#article header.article-header` |
| 2.2.2.1 | 文章標題 | `.article-header h1.article-title` |
| 2.2.2.2 | 文章發布日期 | `.article-header time.article-date` |
| 2.3.1 | 文章內容區塊 | `#article section.article-body` |

#### 3. 個人頁面（`#profile-page`）

| 編號 | 需求說明 | 必要 CSS Selector |
|------|---------|-------------------|
| 3.1 | 個人頁面根容器 | `#profile-page` |
| 3.2.1 | 使用者資訊區塊 | `section.profile-header` |
| 3.2.2.1 | 使用者頭像（可為預設圖） | `.profile-header img.profile-avatar` |
| 3.2.2.2 | 使用者名稱 | `.profile-header .profile-username` |
| 3.2.2.3 | 簡介文字（無則顯示「尚未填寫自我介紹」） | `.profile-header .profile-bio` |
| 3.2.3.1–4 | 點擊頭像觸發上傳、更新頭像、即時顯示（失敗 alert「頭像上傳失敗」） | — |
| 3.2.4.1–5 | 點擊簡介切換可編輯、Enter 儲存、即時更新（失敗 alert「簡介更新失敗」） | `textarea.profile-bio-input` |
| 3.3.1 | 已登入者可見「發表文章」連結 | `a.new-post-link` |
| 3.3.2 | 文章表單容器 | `form.article-create-form` |
| 3.3.3.1 | 標題輸入欄 | `.article-create-form input.article-title-input` |
| 3.3.3.2 | 內容輸入欄 | `.article-create-form textarea.article-content-input` |
| 3.3.3.3 | 發布按鈕 | `.article-create-form button.article-submit-button` |
| 3.3.4 | 發表成功 → alert「發表成功」→ 跳轉至新文章頁 | — |
| 3.4.1 | 使用者文章列表 | `section.profile-articles` |
| 3.4.2 | 每篇文章項目 | `.profile-articles .article-item` |
| 3.4.3.1 | 文章標題 | `.article-item .article-title` |
| 3.4.3.2 | 發佈日期 | `.article-item time.article-date` |
| 3.4.3.3 | 閱讀文章連結 | `.article-item a.article-readmore` |
| 3.4.4 | 無文章時顯示「目前尚無文章」 | `.profile-articles .empty-article-message` |

---

### 項目 2：會員登入與註冊系統

| 編號 | 需求說明 | 必要 CSS Selector |
|------|---------|-------------------|
| 1.1 | 登入表單容器 | `form.login-form` |
| 1.2.1 | 帳號輸入欄 | `.login-form input.username-input` |
| 1.2.2 | 密碼輸入欄 | `.login-form input.password-input` |
| 1.2.3 | 登入送出按鈕 | `.login-form button.login-submit-button` |
| 1.3 | 送出後驗證並登入 | — |
| 2.1 | 註冊表單容器 | `form.register-form` |
| 2.2.1 | 帳號輸入欄 | `.register-form input.username-input` |
| 2.2.2 | Email 欄位 | `.register-form input.email-input` |
| 2.2.3 | 密碼輸入欄 | `.register-form input.password-input` |
| 2.2.4 | 確認密碼欄位 | `.register-form input.password-confirm-input` |
| 2.2.5 | 註冊送出按鈕 | `.register-form button.register-submit` |
| 2.3 | 送出後建立新帳號 | — |
| 2.4 | 註冊成功後導向登入頁 | — |
| 2.5 | 帳號重複或格式錯誤顯示 alert | — |
| 3 | 登出功能 | `a.logout-link` |

---

### 項目 3：好友系統

FunTech 的好友系統允許使用者搜尋其他使用者、發送好友邀請、接受或拒絕申請、查看好友列表，以及前往好友的個人頁面。

#### 1. 好友頁面（`#friends-page`）

| 編號 | 需求說明 | 必要 CSS Selector |
|------|---------|-------------------|
| 1.1.1 | 好友頁主容器 | `#friends-page` |
| 1.1.1.1 | 搜尋功能區塊 | `#friends-page .friend-search-section` |
| 1.1.1.2 | 好友列表區塊 | `#friends-page .friend-list-section` |
| 1.1.1.3 | 收到的好友邀請區塊 | `#friends-page .incoming-requests-section` |
| 1.1.1.4 | 送出的好友申請區塊 | `#friends-page .sent-requests-section` |

#### 2. 搜尋使用者

| 編號 | 需求說明 | 必要 CSS Selector |
|------|---------|-------------------|
| 2.1 | 搜尋表單容器 | `form.friend-search-form` |
| 2.2.1 | 搜尋輸入欄 | `.friend-search-form input.search-input` |
| 2.2.2 | 搜尋按鈕 | `.friend-search-form button.search-submit-button` |
| 2.3 | 送出搜尋並更新結果 | — |
| 2.4 | 搜尋結果清單容器 | `.friend-search-section .search-result-list` |
| 2.5 | 每筆搜尋結果項目 | `.search-result-list .search-result-item` |
| 2.6.1 | 使用者名稱 | `.search-result-item .result-username` |
| 2.6.2 | 前往個人頁面連結 | `.search-result-item a.view-profile-link` |

#### 3. 我的好友列表

| 編號 | 需求說明 | 必要 CSS Selector |
|------|---------|-------------------|
| 3.1 | 好友列表標題「好友列表」 | `.friend-list-section .section-title` |
| 3.2 | 好友列表項目 | `.friend-list-section .friend-item` |
| 3.3.1 | 好友頭像 | `.friend-item img.friend-avatar` |
| 3.3.2 | 好友名稱 | `.friend-item .friend-name` |
| 3.4 | 點擊好友導向個人頁面 | — |

#### 4. 收到的好友邀請

| 編號 | 需求說明 | 必要 CSS Selector |
|------|---------|-------------------|
| 4.1 | 區塊標題「收到的好友申請」 | `.incoming-requests-section .section-title` |
| 4.3 | 每筆申請項目 | `.incoming-requests-section .request-item` |
| 4.4.1 | 申請者頭像 | `.request-item img.request-avatar` |
| 4.4.2 | 申請者名稱 | `.request-item .request-username` |
| 4.4.3 | 接受按鈕 | `.request-item button.accept-request-button` |
| 4.4.4 | 拒絕按鈕 | `.request-item button.reject-request-button` |
| 4.5 | 接受後建立好友關係 | — |
| 4.6 | 拒絕後從列表移除 | — |

#### 5. 送出的好友申請

| 編號 | 需求說明 | 必要 CSS Selector |
|------|---------|-------------------|
| 5.1 | 區塊標題「發送的好友申請」 | `.sent-requests-section .section-title` |
| 5.3 | 每筆申請項目 | `.sent-requests-section .request-item` |
| 5.4.1 | 對方頭像 | `.request-item img.request-avatar` |
| 5.4.2 | 對方名稱 | `.request-item .request-username` |
| 5.4.3 | 取消申請按鈕 | `.request-item button.cancel-request-button` |
| 5.5 | 取消後移除項目 | — |

#### 6. 好友個人頁面（`#profile-page`）

| 編號 | 需求說明 | 必要 CSS Selector |
|------|---------|-------------------|
| 6.1 | 好友個人頁面主容器 | `#profile-page` |
| 6.1.1 | 使用者資訊區（名稱 / 頭像 / 簡介） | `#profile-page .profile-header` |
| 6.1.2 | 內容展示區（含文章列表） | `#profile-page .profile-content` → `section.articles` |
| 6.1.3 | 好友互動操作區（依狀態顯示不同按鈕） | `.profile-friend-actions` |

> 好友狀態按鈕邏輯：
> - **無關係** → 顯示「申請好友」
> - **我方已申請** → 顯示「取消申請」
> - **對方申請我** → 顯示「接受」＋「拒絕」
> - **已是好友** → 顯示「已是好友」＋「取消好友」

---

### 項目 4：遊戲頁面 Games

系統從資料庫 `games` 資料表取得遊戲清單，並讀取各遊戲資料夾中的 `game.json` 設定，以 iframe 載入遊戲、呼叫排行榜 API 動態顯示成績。

#### game.json 結構說明

```json
{
  "entry": {
    "url": "http://localhost/games/1/index.html"
  },
  "score": {
    "pullUrl": "http://localhost/games/1/api/pull_score.php",
    "columns": ["玩家名稱", "分數"]
  }
}
```

| 欄位 | 說明 |
|------|------|
| `entry.url` | 遊戲入口網址，載入至 iframe |
| `score.pullUrl` | 排行榜 API 網址，回傳 JSON 陣列 |
| `score.columns` | 排行榜欄位名稱列表（動態決定顯示欄位） |

#### 分數 API 回傳格式

```json
[
  { "玩家名稱": "玩家1", "分數": 95000 },
  { "玩家名稱": "玩家2", "分數": 89000 },
  { "玩家名稱": "玩家3", "分數": 82500 }
]
```

#### 遊戲列表頁（`#games`）

| 編號 | 需求說明 | 必要 CSS Selector |
|------|---------|-------------------|
| 1.1 | 遊戲列表頁根容器 | `#games` |
| 1.2.1 | 遊戲列表容器 | `#games section.game-list` |
| 1.2.2 | 每個遊戲項目（可重複） | `.game-list .game-item` |
| 1.2.3.1 | 遊戲封面圖 | `.game-item img.game-cover` |
| 1.2.3.2 | 遊戲名稱 | `.game-item .game-title` |
| 1.2.3.3 | 遊戲簡介 | `.game-item .game-description` |
| 1.2.3.4 | 開始遊戲連結 | `.game-item a.play-game-link` |
| 1.2.3.5 | 點擊連結導向遊戲內容頁 | — |

#### 遊戲內容頁（`#game-play`）

| 編號 | 需求說明 | 必要 CSS Selector |
|------|---------|-------------------|
| 2.1 | 遊戲內容頁根容器 | `#game-play` |
| 2.2 | 顯示遊戲名稱 | `.current-game-title` |
| 2.3.1 | 遊戲區域容器 | `#game-play section.game-area` |
| 2.3.2 | 以 iframe 載入遊戲 | `section.game-area iframe.game-frame` |
| 2.4.1 | 排行榜區塊 | `aside.game-leaderboard` |
| 2.4.2 | 排行榜標題 | `.game-leaderboard .leaderboard-title` |
| 2.4.3 | 排行榜資料項目（多筆） | `.game-leaderboard .leaderboard-item` |
| 2.4.4 | 名次＋所有 API 欄位 | `.leaderboard-item .player-rank` |
| 2.4.5 | 無資料時顯示「目前尚無分數紀錄」 | — |

---

### 項目 5：Web API 開發

> **⚠️ 試題描述競賽當天公布，以下為已知基本需求。**

**已知需求：**
- 所有 API 回應使用 **JSON 格式**
- 需實作基本的**錯誤處理**
- API 資料需與系統同步（後台有 N 筆資料，API 也需回傳 N 筆）
- 瀏覽器呈現格式不影響結果，資料內容正確即可

---

## 專案架構總覽

```
th56j_vue/
├── index.php                   # 主入口（唯一頁面，Vue 3 SPA 架構）
├── assets/
│   ├── css/
│   │   └── index.css           # 自訂全域樣式
│   └── img/
│       └── logo.png            # 網站 Logo
├── api/                        # 後端 PHP API
│   ├── db.php                  # 資料庫連線 + Session 啟動
│   ├── login.php               # 登入驗證
│   ├── logout.php              # 登出（銷毀 Session）
│   ├── register.php            # 帳號註冊
│   ├── get_profile.php         # 取得目前登入者資料
│   ├── get_articles.php        # 取得所有文章列表
│   ├── get_article.php         # 取得單篇文章
│   ├── get_my_articles.php     # 取得自己的文章
│   ├── add_article.php         # 發表文章
│   ├── update_avatar.php       # 更新頭像（Base64 上傳）
│   ├── update_bio.php          # 更新個人簡介
│   ├── search_users.php        # 搜尋使用者
│   ├── set_friend.php          # 好友操作（apply / accept / reject / cancel / remove）
│   ├── get_friends.php         # 取得好友列表＋申請列表
│   ├── get_friend_profile.php  # 取得好友個人資料＋文章＋好友關係
│   ├── get_games.php           # 取得遊戲列表
│   └── get_game.php            # 取得單一遊戲設定（含 game.json）
├── games/                      # 遊戲資料夾（各含 game.json）
│   ├── 1/  數字挑戰
│   ├── 2/  記憶挑戰
│   ├── 3/  反應力測試
│   ├── 4/  打地鼠
│   └── 5/  滑動拼圖
├── img/                        # 使用者頭像存放區
├── document/                   # 文件與素材
│   ├── articles/               # 36 篇文章樣本（.txt）
│   └── users/                  # 12 位使用者資料（.txt + .jpg）
├── doc/
│   └── 表件04(命題用9-1)-競賽試題及說明_ok.pdf   # 官方試題 PDF
├── db21 (2).sql                # 資料庫匯出檔（含結構＋初始資料）
└── game fast cosole/
    ├── README.md               # 快速通關工具說明
    └── console.js              # 快速通關腳本（貼至 Console 使用）
```

---

## 技術棧與設計決策

### 前端

| 技術 | 版本 | 用途 |
|------|------|------|
| **Vue 3** | CDN `vue.global.prod.js` | Composition API 管理所有頁面狀態 |
| **Bootstrap 4** | 4.5.3 | 響應式排版與 UI 元件 |
| PHP（伺服器端渲染） | — | Session 登入狀態判斷、導覽列切換 |

### 設計模式：Vue SPA（Single Page Application）

整個網站以 **單一 `index.php` 檔案** 為入口，透過 Vue 3 的 `ref('page')` 切換視圖，無需多個 PHP 頁面：

```
page='home'          → 首頁（文章列表 + 公告）
page='article'       → 文章詳情頁
page='add-article'   → 發表文章
page='login'         → 登入
page='register'      → 註冊
page='profile'       → 個人頁面
page='games'         → 遊戲列表
page='game-play'     → 遊戲進行（iframe + 排行榜）
page='friends'       → 好友列表
page='friend-profile'→ 好友個人頁面
```

### 為什麼選擇 Vue CDN 而非 PHP 多頁？

- **速度**：競賽時間有限，不需建置打包環境，CDN 即插即用
- **狀態集中**：所有資料（文章、好友、遊戲）統一在 Vue `setup()` 管理，邏輯清晰
- **API 呼叫簡潔**：`fetch` + `async/await` 直接串接 PHP API
- **DOM 規格符合**：透過 Vue 的 `v-for` 動態渲染符合競賽要求的 CSS selector 結構

---

## 資料庫設計

**資料庫：** `db21`（競賽環境請改為 `webXX_db`）

### 資料表結構

#### `users` — 使用者

```sql
CREATE TABLE `users` (
  `id`       INT(10) NOT NULL AUTO_INCREMENT,
  `username` TEXT NOT NULL,
  `password` TEXT NOT NULL,
  `email`    TEXT NOT NULL,
  `header`   TEXT NOT NULL COMMENT '頭像路徑',
  `bio`      TEXT NOT NULL COMMENT '個人簡介'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

#### `articles` — 文章

```sql
CREATE TABLE `articles` (
  `id`         INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`    INT(10) UNSIGNED NOT NULL,
  `title`      TEXT NOT NULL,
  `content`    TEXT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

#### `friends` — 好友關係

```sql
CREATE TABLE `friends` (
  `id`           INT(10) NOT NULL AUTO_INCREMENT,
  `requester_id` INT(10) NOT NULL,   -- 申請者
  `addressee_id` INT(10) NOT NULL,   -- 被申請者
  `status`       TEXT NOT NULL,      -- 'pending' | 'accept'
  `created_at`   TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  `updated_at`   TIMESTAMP NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

#### `games` — 遊戲

```sql
CREATE TABLE `games` (
  `id`          INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`       TEXT NOT NULL,
  `description` TEXT NOT NULL,
  `cover`       TEXT NOT NULL    -- 封面 SVG 路徑
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

#### `scores` — 分數紀錄

```sql
CREATE TABLE `scores` (
  -- 詳見 db21 (2).sql
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### 初始資料

**遊戲列表（5 筆）：**

| id | 遊戲名稱 | 說明 |
|----|---------|------|
| 1 | 數字挑戰 | 依序點擊數字，按升序完成挑戰 |
| 2 | 記憶挑戰 | 翻開圖案相同的卡牌即可得分 |
| 3 | 反應力測試 | 看到綠色畫面就立刻點擊，測試反應速度 |
| 4 | 打地鼠 | 地鼠冒出來就快點擊，30 秒內打越多分越高 |
| 5 | 滑動拼圖 | 數字拼圖遊戲 |

**資料庫連線設定（`api/db.php`）：**

| 項目 | 開發環境 | 競賽環境 |
|------|---------|---------|
| Host | `localhost` | `localhost` |
| DB | `db21` | `webXX_db` |
| User | `root` | `webXX` |
| Password | `（空）` | `1234` |
| Charset | `utf8mb4` | `utf8mb4` |

---

## API 端點一覽

| 方法 | 端點 | 功能 | 回傳 |
|------|------|------|------|
| GET | `api/get_articles.php` | 取得所有文章（含作者名稱） | JSON 陣列 |
| GET | `api/get_article.php?id={id}` | 取得單篇文章 | JSON 物件 |
| GET | `api/get_my_articles.php` | 取得自己發表的文章 | JSON 陣列 |
| POST | `api/add_article.php` | 發表文章（`title`, `content`） | 新文章 id 或 0 |
| GET | `api/get_profile.php` | 取得目前登入者資料 | JSON 物件 |
| POST | `api/update_avatar.php` | 更新頭像（`imgString` Base64） | 1 或 0 |
| POST | `api/update_bio.php` | 更新簡介（`text`） | 1 或 0 |
| POST | `api/login.php` | 登入（`username`, `password`） | 1 或 0 |
| GET | `api/logout.php` | 登出，銷毀 Session | 重導向 |
| POST | `api/register.php` | 註冊（`username`, `email`, `password`） | 1 或 0 |
| GET | `api/search_users.php?search={q}` | 搜尋使用者 | JSON 陣列 |
| GET | `api/set_friend.php?action={}&friend_id={}` | 好友操作（apply/accept/reject/cancel/remove） | `{"success":bool,"message":""}` |
| GET | `api/get_friends.php` | 取得好友列表＋收到/送出申請 | `{friends, incoming, outgoing}` |
| GET | `api/get_friend_profile.php?id={id}` | 取得好友資料＋文章＋關係狀態 | `{user, articles, relation}` |
| GET | `api/get_games.php` | 取得所有遊戲清單 | JSON 陣列 |
| GET | `api/get_game.php?id={id}` | 取得單一遊戲設定（含 entryUrl, pullUrl） | JSON 物件 |

---

## 功能實作狀態

### 項目 1：首頁與個人頁面

| 功能 | 狀態 | 備註 |
|------|------|------|
| 首頁根容器 `#home` | ✅ | |
| 導覽列（Header） | ✅ | |
| Logo 連結 | ✅ | |
| 首頁 / 遊戲 / 好友連結 | ✅ | |
| 使用者區域（登入/未登入切換） | ✅ | PHP Session 判斷 |
| 文章列表 `section.articles` | ✅ | |
| 每篇文章（title / date / excerpt / readmore） | ✅ | |
| 通知公告 `aside.notifications` | ✅ | 目前為靜態 5 筆 |
| 文章內容頁 `#article` | ✅ | |
| 個人頁面 `#profile-page` | ✅ | |
| 頭像上傳（點擊 → 選檔 → 更新 → 即時顯示） | ✅ | Base64 上傳 |
| 簡介編輯（點擊 → 輸入 → Enter 儲存） | ✅ | |
| 發表文章功能 | ✅ | |
| 使用者文章列表 | ✅ | |
| **⚠️ `profile-avater` class 誤植** | 🟡 待修 | 應為 `profile-avatar` |

### 項目 2：登入 / 註冊

| 功能 | 狀態 |
|------|------|
| 登入表單（帳號 / 密碼 / 送出） | ✅ |
| 登入驗證 | ✅ |
| 註冊表單（帳號 / email / 密碼 / 確認密碼 / 送出） | ✅ |
| 建立新帳號 | ✅ |
| 註冊成功導向登入頁 | ✅ |
| 帳號重複 alert | ✅ |
| 登出功能 | ✅ |

### 項目 3：好友系統

| 功能 | 狀態 | 備註 |
|------|------|------|
| 好友頁主容器 + 四大區塊 | ✅ | |
| 搜尋使用者 | ✅ | |
| 好友列表顯示 | ✅ | |
| 收到申請（接受 / 拒絕） | ✅ | |
| 送出申請（取消） | ✅ | |
| 好友個人頁面（資料 / 文章 / 好友操作） | ✅ | |
| **⚠️ `'pendding'` 拼字錯誤** | 🟡 待修 | 應為 `'pending'` |

### 項目 4：遊戲頁面

| 功能 | 狀態 | 備註 |
|------|------|------|
| 遊戲列表（封面 / 名稱 / 簡介 / 連結） | ✅ | |
| 遊戲內容頁（iframe 載入） | ✅ | |
| 排行榜資料動態載入 | ✅ | 呼叫 `game.pullUrl` API |
| 排行榜欄位動態產生 | 🔴 待修 | 目前硬編碼「玩家名稱」「分數」，需依 `score.columns` 動態產生 |
| 無資料顯示提示 | ✅ | |

### 項目 5：Web API

| 狀態 | 說明 |
|------|------|
| ⏳ 待競賽當天 | 試題當天公布，基礎 JSON 格式 + 錯誤處理架構已備妥 |

---

## 待修正事項

| 優先 | 項目 | 問題 | 解法 |
|------|------|------|------|
| 🔴 高 | 遊戲排行榜 | 欄位硬編碼，需依 `score.columns` 動態渲染 | `v-for col in currentGame.columns` |
| 🟡 中 | 個人頁面 class | `profile-avater` → `profile-avatar` | 搜尋取代 |
| 🟡 中 | 好友狀態 typo | `'pendding'` → `'pending'`（`set_friend.php`） | 字串修正 |
| 🟡 中 | 項目5 Web API | 競賽當天依題目實作 | — |
| 🟢 低 | 通知為靜態 | 公告目前為假資料（5 筆） | 視題目是否要求動態化 |
| 🟢 低 | 程式碼整理 | 移除 `console.log`、整理 commit | — |

---

## 遊戲系統說明

### 內建遊戲（5 款）

| 遊戲 id | 名稱 | 玩法說明 |
|--------|------|---------|
| 1 | 數字挑戰 | 依序點擊數字，按升序完成挑戰 |
| 2 | 記憶挑戰 | 翻開圖案相同的卡牌得分 |
| 3 | 反應力測試 | 看到綠色畫面立刻點擊，測試反應速度 |
| 4 | 打地鼠 | 30 秒內點擊地鼠，越多分越高 |
| 5 | 滑動拼圖 | 數字拼圖，移動方塊完成排列 |

### 遊戲資料夾結構

```
games/
└── {id}/
    ├── index.html        # 遊戲主體
    ├── game.json         # 遊戲設定（entryUrl + score）
    ├── cover.svg         # 遊戲封面圖
    ├── scores.json       # 初始分數
    └── api/
        └── pull_score.php  # 排行榜 API（回傳 JSON 陣列）
```

---

## 快速通關工具

> 位置：`game fast cosole/console.js` — 僅供訓練使用

這是一個用於**第 56 屆全國技能競賽北區訓練**的遊戲自動化工具（v3）。將腳本貼入遊戲頁面的瀏覽器 Console 即可使用。

### 支援遊戲與模式

| 遊戲 | 贏（Win）模式 | 輸（Lose）模式 |
|------|-------------|--------------|
| 數字挑戰 | ✅ 按升序自動點擊 | ✅ 故意錯序 |
| 記憶挑戰 | ✅ 自動找配對 | ✅ 故意錯配 |
| 反應力測試 | ✅ 模擬真人反應（150–300ms） | ✅ 故意太早點擊 |
| 打地鼠 | ✅ 自動追蹤並點擊地鼠 | — |
| 滑動拼圖 | ✅ 自動解拼圖 | — |

### 使用方法

1. 在瀏覽器開啟遊戲頁面（`games/{id}/index.html`）
2. 按 `F12` 開啟開發者工具，切換至 **Console** 分頁
3. 複製 `console.js` 全部內容並貼上，按 Enter 執行
4. 在彈出的控制面板點擊對應模式按鈕

### 技術原理

- 使用 **DOM 操作**直接控制遊戲元素
- 透過 **MutationObserver** 監控遊戲狀態變化
- 加入 **隨機延遲（200–800ms）**模擬真人操作節奏
- 使用 `async/await` 處理非同步流程

---

## 競賽部署說明

### 環境安裝

1. 安裝 **XAMPP**（內含 Apache + MariaDB + PHP 8.x）
2. 將專案資料夾複製至 `C:\xampp\htdocs\web01\`（依崗位編號命名）
3. 啟動 **Apache** 與 **MySQL** 服務

### 資料庫匯入

```sql
-- 1. 建立資料庫
CREATE DATABASE webXX_db CHARACTER SET utf8mb4;

-- 2. 透過 phpMyAdmin 匯入 db21 (2).sql
```

或使用命令列：

```bash
mysql -u webXX -p1234 webXX_db < "db21 (2).sql"
```

### 修改資料庫連線（`api/db.php`）

```php
<?php
$dsn = "mysql:host=localhost;dbname=webXX_db;charset=utf8";
$pdo = new PDO($dsn, 'webXX', '1234');

date_default_timezone_set("Asia/Taipei");
session_start();
```

### 確認入口

開啟 `http://localhost/web01/` 確認 `index.php` 正常顯示 FunTech 首頁。

---

## 評分項目完成度摘要

| 模組 / 項目 | 完成度 | 說明 |
|------------|--------|------|
| 模組 1：視覺設計 | 🟡 基礎 | 有 Logo、Bootstrap 樣式，可進一步美化 |
| 項目 1：首頁 + 個人頁面 | ✅ 95% | class typo 待修 |
| 項目 2：登入 / 註冊系統 | ✅ 100% | 完整實作 |
| 項目 3：好友系統 | ✅ 95% | typo 待修 |
| 項目 4：遊戲頁面 | 🟡 85% | 排行榜欄位需動態化 |
| 項目 5：Web API | ⏳ 待公布 | 基礎架構已就位 |

---

*文件版本：第五版（Vue SPA）｜生成日期：2026-06-04*