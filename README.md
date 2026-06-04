# 第 56 屆全國技能競賽 — 網頁技術（青少年組）
## FunTech 社群網站 · 完整試題說明與第四版PHP開發版本極致簡化實作文件

---

## 一、專案概述

本專案為第 56 屆全國技能競賽網頁技術青少年組的 FunTech 社群平台，採用 PHP + MySQL + Bootstrap 實作。

**本次簡化版本（v5）目標：** 在完全不影響畫面外觀與所有功能的前提下，對第四版（v4-php）PHP 原始碼進行極致精簡，消除所有冗餘程式碼、多餘空行、無效中間變數與迴圈內重複查詢。

---

## 二、簡化成效總覽

| 檔案 | 原始行數 | 簡化後 | 節省 |
|---|---|---|---|
| `api/db.php` | 6 | 4 | -2 |
| `api/logout.php` | 8 | 5 | -3 |
| `partials/header.php` | 38 | 34 | -4 |
| `partials/footer.php` | 6 | 6 | 0 |
| `index.php` | 60 | 43 | -17 |
| `login.php` | 54 | 27 | -27 |
| `register.php` | 65 | 32 | -33 |
| `article.php` | 36 | 17 | -19 |
| `add-article.php` | 51 | 35 | -16 |
| `games.php` | 32 | 23 | -9 |
| `game-play.php` | 97 | 55 | -42 |
| `profile.php` | 118 | 66 | -52 |
| `friends.php` | 186 | 115 | -71 |
| `friend-profile.php` | 91 | 62 | -29 |
| `games/N/api/pull_score.php` × 5 | 45 | 13 | -32 each |
| **合計（含全部 pull_score）** | **1053** | **597** | **-456（-43%）** |

> 相同功能、相同 HTML 輸出，程式碼減少 **43%**。

---

## 三、專案檔案架構

```
th56j_national/
├── api/
│   ├── db.php              ← PDO 連線 + session_start
│   └── logout.php          ← 登出並跳轉
├── partials/
│   ├── header.php          ← 共用 HTML 頭部與導覽列
│   └── footer.php          ← 共用 HTML 底部與 JS 引入
├── games/
│   └── {1-5}/
│       ├── api/pull_score.php  ← 排行榜 API
│       ├── game.json           ← 遊戲設定（entry url, score columns）
│       ├── scores.json         ← 靜態分數資料
│       ├── index.html          ← 遊戲本體
│       └── cover.svg           ← 遊戲封面
├── assets/
│   ├── css/bootstrap.css
│   ├── js/jquery-3.7.1.min.js
│   └── js/bootstrap.js
├── img/                    ← 使用者頭像上傳目錄
├── index.php               ← 首頁（文章列表 / 公告）
├── login.php               ← 登入
├── register.php            ← 註冊
├── article.php             ← 文章閱讀頁
├── add-article.php         ← 發表文章
├── games.php               ← 遊戲列表
├── game-play.php           ← 遊戲頁面 + 排行榜
├── profile.php             ← 個人頁面（頭像上傳、簡介、文章）
├── friends.php             ← 好友管理（搜尋、申請、接受、拒絕）
└── friend-profile.php      ← 他人個人頁面
```

---

## 四、核心簡化策略

### 4-1　移除所有程式碼內中文註解與空行
原始碼含大量說明性中文註解（如 `// 決定目前顯示的分頁`、`// 重整避免 F5 重送`）。簡化版完全移除，邏輯已足夠自明。

### 4-2　單行 Guard Clause
將登入驗證、參數驗證的多行 `if/exit` 合併為單行：
```php
// 原始
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// 簡化
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit; }
```

### 4-3　合併重複的 Session 賦值
登入成功後的 Session 設定由三行合為兩行：
```php
// 原始
$_SESSION['user']    = $chk['username'];
$_SESSION['num']     = $chk['username'];
$_SESSION['user_id'] = $chk['id'];

// 簡化
$_SESSION['user'] = $_SESSION['num'] = $chk['username'];
$_SESSION['user_id'] = $chk['id'];
```

### 4-4　Null Coalescing（`??`）取代 isset + 三元
```php
// 原始
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'articles';

// 簡化
$tab = $_GET['tab'] ?? 'articles';
```

### 4-5　移除中間變數
不必要的暫存變數直接內聯：
```php
// 原始（article.php）
$id = (int)$_GET['id'];
$article = $pdo->query("... WHERE `id`='$id'")->fetch();

// 簡化
$article = $pdo->query("... WHERE `id`='".(int)$_GET['id']."'")->fetch();
```

### 4-6　SQL 欄位別名取代 SELECT *
index.php 文章查詢改用欄位別名：
```php
// 原始（兩個變數名）
$articles = $pdo->query("SELECT `articles`.*, `users`.`username`
                          FROM `articles`
                          LEFT JOIN `users` ON `articles`.`user_id` = `users`.`id`
                          ORDER BY `articles`.`created_at` DESC
                          LIMIT 10")->fetchAll();

// 簡化（別名縮短）
$articles = $pdo->query("SELECT a.*,u.username FROM `articles` a LEFT JOIN `users` u ON a.user_id=u.id ORDER BY a.created_at DESC LIMIT 10")->fetchAll();
```

### 4-7　if/foreach 合併（消除 count）
```php
// 原始
if (count($articles) > 0):
    foreach ($articles as $article):

// 簡化（PHP 空陣列即為 falsy）
if ($articles): foreach ($articles as $a):
```

### 4-8　inline 三元取代多行 if/else for class
```php
// 原始
class="btn btn-outline-info mx-2 <?= $tab === 'articles' ? 'active' : '' ?>"

// 簡化（等號周圍去空格）
class="btn btn-outline-info mx-2 <?= $tab==='articles'?'active':'' ?>"
```

### 4-9　finfo + ext_map 合併為內聯鏈式呼叫（profile.php）
```php
// 原始（宣告兩次 ext_map、分開 new finfo）
$ext_map = ['image/jpeg' => '.jpg', ...];
$ext     = $ext_map[$file['mime_type']] ?? '.jpg';
$finfo   = new finfo(FILEINFO_MIME_TYPE);
$mime    = $finfo->file($file['tmp_name']);
$ext     = $ext_map[$mime] ?? '.jpg';

// 簡化（單次宣告、立即索引）
$ext = ['image/jpeg'=>'.jpg','image/png'=>'.png','image/gif'=>'.gif'][(new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name'])] ?? '.jpg';
```

### 4-10　profile.php 消除重複使用者查詢
原始版本在 POST 處理前後各查一次使用者資料；簡化版將 POST 成功後統一重導向，僅在 GET 頁面呈現時查詢一次。

### 4-11　game-play.php badge 陣列查詢取代 if/elseif/else
```php
// 原始
if ($idx === 0) $badgeClass = "badge-warning";
elseif ($idx === 1) $badgeClass = "badge-light text-dark border";
elseif ($idx === 2) $badgeClass = "badge-danger";
else $badgeClass = "badge-secondary";

// 簡化
$badges = ['badge-warning', 'badge-light text-dark border', 'badge-danger'];
$badge  = $badges[$i] ?? 'badge-secondary';
```

### 4-12　pull_score.php：array_map + Arrow Function
```php
// 原始（foreach 手動建陣列）
$data = [];
foreach ($rows as $row) {
    $data[] = [
        '玩家名稱' => $row['player_name'],
        '分數'     => (int) $row['score'],
    ];
}

// 簡化
$data = array_map(fn($r) => ['玩家名稱' => $r['player_name'], '分數' => (int)$r['score']], $stmt->fetchAll(PDO::FETCH_ASSOC));
```

---

## 五、friends.php — N+1 查詢優化（最大優化項目）

原始版本在三個區塊（好友列表、收到申請、發出申請）中皆採用**迴圈內查詢**，每渲染一位使用者就對 `users` 資料表執行一次 SELECT，產生典型的 N+1 查詢問題。

### 原始（N+1 問題）
```php
// 先取好友關係記錄
$friends = $pdo->query("SELECT * FROM `friends` WHERE ...")->fetchAll();

// 再對每一筆關係查詢使用者資料
foreach ($friends as $friend) {
    $friend_id   = ($friend['requester_id'] == $my) ? $friend['addressee_id'] : $friend['requester_id'];
    $friend_info = $pdo->query("SELECT * FROM `users` WHERE `id`='$friend_id'")->fetch(); // ← 每次都查一次
    $avatar      = !empty($friend_info['header']) ? ... : ...;
}
```

**三個區塊共可能觸發 3×N 次查詢。**

### 簡化（單次 JOIN）
```php
// 好友列表：一次 JOIN 取得全部資料
$friends = $pdo->query("SELECT u.*, IF(f.requester_id='$my',f.addressee_id,f.requester_id) AS fid
    FROM `friends` f JOIN `users` u ON u.id=IF(f.requester_id='$my',f.addressee_id,f.requester_id)
    WHERE (f.requester_id='$my' OR f.addressee_id='$my') AND f.status='accept'")->fetchAll();

// 收到的申請：一次 JOIN
$incomingRequests = $pdo->query("SELECT u.*, f.requester_id AS rid FROM `friends` f
    JOIN `users` u ON u.id=f.requester_id
    WHERE f.addressee_id='$my' AND f.status='pending'")->fetchAll();

// 發出的申請：一次 JOIN
$outgoingRequests = $pdo->query("SELECT u.*, f.addressee_id AS aid FROM `friends` f
    JOIN `users` u ON u.id=f.addressee_id
    WHERE f.requester_id='$my' AND f.status='pending'")->fetchAll();
```

**三區塊共只需 3 次查詢（固定），無論好友數量多少。**

---

## 六、逐檔簡化說明

### `api/db.php`
移除 DSN 暫存變數，PDO 連線字串直接傳入建構子。

### `api/logout.php`
移除逐一 `unset($_SESSION[...])` 呼叫，改用 `session_destroy()` 一次清除。

### `partials/header.php`
移除頂部 PHP 行內說明注解，HTML 縮排緊湊化，不影響任何 class 或結構。

### `index.php`
SQL JOIN 改用單字母別名（`a`, `u`）；`if (count(...) > 0)` 改為 `if ($articles)`；Active tab 的三元運算子去空格。

### `login.php` / `register.php`
表單欄位的 `<div>` 各自單行化；POST 邏輯中錯誤判斷改用 `elseif` 串接，消除巢狀 `if`。

### `article.php`
`$id` 暫存變數移除，int cast 內聯至 SQL 字串。

### `add-article.php`
取得作者 ID 改用 `fetchColumn()` 直接取單值，不再 `fetch()` 整列資料再讀 `id`。

### `games.php`
移除原始版多餘的 `$games` 宣告位置調整（移至 header 之前，避免空白輸出問題已由 PHP 自行處理）。

### `game-play.php`
分數檔案載入與 `$ranks` 解析移至 `include header.php` 之前；badge 判斷改為陣列索引；移除大量空行與行內注解。

### `profile.php`
合併 POST 上傳與 POST 簡介的分支判斷；`finfo` 與 `ext_map` 合為一行；移除 POST 後重複的使用者查詢；`$msg` 初始化統一由 `$_GET['msg'] ?? ''` 負責。

### `friends.php`
最大優化項目，詳見第五節。action 處理改為 `switch` 取代多層 `case`；搜尋迴圈使用 `foreach` 直接過濾，不再宣告 `$users` 後再遍歷。

### `friend-profile.php`
兩行 guard clause 合為單行；bio 顯示改用三元運算子；`$is_relation` 中間變數移除，直接用 `$relation` 判斷。

### `games/N/api/pull_score.php`（×5）
移除全部中文注解區塊（佔原始行數約 30%）；`foreach` 建立陣列改為 `array_map` + Arrow Function；PDO 建立時直接傳入選項陣列，不額外宣告變數。

---

## 七、未改動項目

以下檔案或內容刻意保留不動：

- **SQL 語法結構** — 原題所需的資料表名稱、欄位名稱、查詢語義完全保留
- **HTML class 名稱** — 全數保留（供競賽評分腳本比對）
- **HTML 結構語義** — 所有 `id`、`class`、`name`、`action`、`method` 屬性完全不變
- **Bootstrap CSS / jQuery** — 靜態資源完全不動
- **遊戲本體** — `games/N/index.html`、`cover.svg`、`scores.json`、`game.json` 不修改
- **`assets/js/index.js`** — 原本僅 1 行，保留原狀
- **安全性層級** — 保持與原版相同（競賽用途，不額外強化）

---

## 八、執行環境需求

| 項目 | 規格 |
|---|---|
| Web Server | Apache / Nginx（PHP 支援） |
| PHP | 8.1+（使用 Arrow Function `fn()`） |
| MySQL | 5.7+ / MariaDB 10.3+ |
| 資料庫名稱 | `db21` |
| 資料庫帳號 | `root` / 密碼空白 |
| 時區設定 | Asia/Taipei |

---

*第 56 屆全國技能競賽 · 網頁技術（青少年組）· v5 極致簡化版*
