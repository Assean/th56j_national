-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2026-05-31 05:00:49
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `db21`
--

-- --------------------------------------------------------

--
-- 資料表結構 `articles`
--

CREATE TABLE `articles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `articles`
--

INSERT INTO `articles` (`id`, `user_id`, `title`, `content`, `created_at`) VALUES
(13, 1, '初探 PHP 與 MySQL 連線', '學習如何使用 PDO (PHP Data Objects) 建立安全且穩定的資料庫連線，是每一個後端網頁全端開發者的基本功。在過去的開發中，許多人習慣使用傳統的 mysqli 擴充功能，但 PDO 提供了更強大的跨資料庫支援能力，並且原生支援預備陳述式（Prepared Statements）。透過預備陳述式，我們可以將 SQL 指令與使用者輸入的資料完全分離，從根本上杜絕 SQL Injection 注入攻擊的風險。此外，良好的連線管理還包含例外處理（Exception Handling），利用 try-catch 區塊捕捉連線失敗的錯誤，不僅能避免資料庫機密資訊（如密碼、伺服器 IP）直接暴露在前端畫面上，也能提供使用者更友善的錯誤提示。在撰寫全端專案時，穩固的資料庫基礎能讓後續的 API 設計與資料互動變得更加順暢與安全。', '2026-05-28 02:00:00'),
(14, 2, '打造專屬的一頁式網站', '結合 HTML、CSS 與輕量級的 JavaScript，我們可以快速建構出極具視覺衝擊力且流暢的高質感一頁式網站。在現代網頁設計中，一頁式網站（Landing Page）非常適合用於個人作品集、微型企業產品展示或是短期活動宣傳。要打造出吸引人的網頁，首先必須掌握響應式網頁設計（RWD），利用 CSS Flexbox 或 Grid 版面配置，確保網站不論在桌上型電腦、平板還是智慧型手機上都能完美呈現。接著，可以加入捲動偵測（Scroll Animation）或是視覺差滾動（Parallax Scrolling）效果，當使用者向下捲動網頁時，元件以優雅的動畫漸漸浮現，這能大幅提升使用者的互動體驗與停留時間。最後，別忘了優化網頁載入速度，將圖片進行適度壓縮並妥善規劃 DOM 結構，才能在追求精美視覺的同時，兼顧卓越的網頁效能。', '2026-05-28 02:15:00'),
(15, 1, '認識 Google OAuth 登入實作', '在當今的 Web 應用開發中，提供便利且安全的第三方登入功能已成為不可或缺的趨勢。透過整合 Google 登入 API（Google OAuth 2.0），開發者可以允許使用者直接使用其現有的 Google 帳號進行身份驗證，這不僅大幅降低了新使用者的註冊門檻，也免去了使用者需要額外記住一組密碼的負擔。在後端實作上，當使用者在前端點擊登入並授權後，前端會取得一個身份憑證（ID Token），接著必須將此憑證安全地傳送至後端 PHP 伺服器。後端利用 Google 提供的驗證函式庫對憑證進行解析與驗證，確認其有效性後，再從中提取使用者的唯一識別碼、電子郵件及大頭貼等公開資訊。最後，後端會檢查資料庫中是否已存在該使用者，若無則自動建立新帳號，並透過 Session 或 JWT 機制維持使用者的登入狀態，完成整個安全可靠的驗證流程。', '2026-05-28 02:30:00'),
(16, 2, 'SQL Injection 是什麼？如何防範？', '資料庫安全是 Web 應用程式開發中最核心的課題之一，而 SQL Injection（SQL 注入攻擊）則是歷史悠久且危害極大的安全漏洞。這種攻擊通常發生在應用程式沒有對使用者輸入的資料進行嚴格過濾或轉義，就直接將其拼接進 SQL 查詢語法中。攻擊者可以藉由在輸入欄位中惡意輸入特殊的 SQL 指令片段（例如 \' OR \'1\'=\'1），來改變原本 SQL 語句的邏輯，從而繞過身份驗證、任意讀取、修改甚至刪除整個資料庫中的敏感資料。要徹底防範 SQL Injection，現代全端開發最推薦且最有效的方法就是全面採用「預備陳述式」（Prepared Statements）與參數化查詢（Parameterized Queries）。透過將 SQL 指令的架構預先編譯，隨後才將資料作為參數綁定進去，資料庫系統會嚴格將這些參數視為純文字而非可執行的指令，如此一來便能徹底封鎖攻擊者的惡意注入。', '2026-05-28 02:45:00'),
(17, 1, '運用 AI 輔助寫程式的技巧', '隨著人工智慧技術的爆炸性成長，AI 程式碼輔助工具已經成為現代軟體開發者的得力助手。不論是進行複雜的系統架構規劃、繁瑣的 Bug 除錯，還是自動生成重複性高模組程式碼，AI 都能提供即時且高質量的建議。然而，要讓 AI 發揮出最大的效益，關鍵在於開發者的「提示詞工程」（Prompt Engineering）能力。在向 AI 提問時，我們應該給予清晰且具體的上下文背景，例如明確指出目前使用的程式語言版本（如 PHP 8.2、Luau）、框架、資料庫結構以及預期的功能目標。同時，採用「逐步引導」的方式，先讓 AI 規劃邏輯架構，確認無誤後再要求其輸出具體的程式碼實作。此外，我們絕對不能盲目複製 AI 生成的內容，必須培養程式碼審查（Code Review）的能力，仔細檢查潛在的邊界條件與安全漏洞，將 AI 的高效率與人類的嚴謹邏輯相結合。', '2026-05-28 03:00:00'),
(18, 2, 'CSS 霓虹燈發光效果實戰', '想要為你的網頁注入強烈的視覺風格嗎？賽博龐克（Cyberpunk）主題中經典的霓虹燈發光視覺，純粹利用 CSS 就能完美達成。這個效果的核心在於靈活運用 text-shadow（文字陰影）與 box-shadow（區塊陰影）屬性。為了營造出真實的霓虹燈質感，我們不能只設定單層陰影，而是需要透過逗號分隔來堆疊多層陰影。最內層使用高亮度的白色或接近白色的核心顏色，接著向外擴散使用高飽和度的色彩（如螢光藍、電子桃紅或極光綠），並逐漸加大陰影的模糊半徑（Blur Radius），這樣就能創造出由內而外自然擴散的刺眼光暈。為了讓效果更加生動，還可以結合 CSS @keyframes 動態特效，模擬霓虹燈管在通電時特有的微微閃爍（Flickering）或是規律呼吸律動。搭配深色背景與具備機械感的字體，就能輕鬆在網頁上重現充滿未來科技感的科幻世界。', '2026-05-28 03:15:00'),
(19, 1, '為什麼要將密碼進行雜湊？', '在處理使用者註冊與登入系統時，保護使用者的密碼安全是開發者不可推卸的法律與道德責任。我們絕對、永遠不能將使用者的密碼以「明文」（Plaintext）的方式直接存入資料庫中。因為一旦伺服器遭到駭客入侵或資料庫意外洩露，所有使用者的帳號密碼將會赤裸裸地曝光，甚至引發跨平台連帶被盜的嚴重災情。正確的做法是在密碼存入資料庫前進行「安全雜湊」（Hashing）。在 PHP 中，推薦使用內建且安全的 password_hash() 函式，它預設採用強大的 bcrypt 演算法，並且會自動為每個密碼生成獨一無二的「鹽值」（Salt）。雜湊是一個不可逆的單向數學運算，這意味著即使駭客拿到了雜湊後的字串，也幾乎無法反推出原始密碼。當使用者登入時，後端再透過 password_verify() 函式將輸入的密碼與資料庫中的雜湊值進行安全比對，從而在確保驗證功能正常的同時，將資安風險降到最低。', '2026-05-28 03:30:00'),
(20, 2, '動態計分系統的演算法設計', '在開發具備教育意義或遊戲性質的互動平台時，一套設計精妙的「動態計分與獎勵系統」能大幅提升使用者的參與度與黏著度。本系統的核心邏輯不單單只是答對給分，而是引入了「精準度乘數」（Accuracy Multiplier）與「歷史進度追蹤」的演算法機制。當系統在後端 PHP 接收到使用者的答題結果後，會首先計算使用者近期的正確率。如果使用者維持連續答對的連勝紀錄（Streak），系統會動態調高積分加成倍率，激發使用者的挑戰慾望；相反地，若遇到難度較高的關卡，演算法也會根據歷史數據提供進度補償，避免使用者產生挫折感。為了防止系統遭到惡意刷分，我們在程式碼中必須嚴格設定單日積分上限（Daily Point Cap）以及合理的冷卻時間（Cooldown）。整個模組採用獨立的 PHP 類別封裝，並與 MySQL 資料庫進行高頻率但經過優化的資料讀寫，確保計分過程既即時又具備高度防作弊的安全性。', '2026-05-28 03:45:00'),
(21, 1, 'JavaScript 的非同步處理', '現代網頁非常講求流暢且不間斷的使用者體驗，而這背後的功臣正是 JavaScript 的「非同步處理」（Asynchronous Programming）機制。在傳統的同步執行模式下，當網頁向伺服器請求資料（例如載入大量文章內容）時，整個瀏覽器畫面會陷入卡死、無法點擊的狀態，直到資料傳輸完畢為止。為了解決這個痛點，我們必須熟練掌握 AJAX、Promise 以及現代最優雅的 async / await 語法，搭配 Fetch API 來進行後端資料的串接。非同步處理允許瀏覽器在背景發送 HTTP 請求，與此同時，使用者依然可以流暢地捲動網頁、點擊按鈕或觀看動畫。當後端 PHP 伺服器回傳 JSON 格式的資料後，JavaScript 會在背景自動觸發回呼函式，動態地將新資料渲染、更新到畫面的特定 DOM 節點上。這種動態無刷新（SPA）的網頁互動架構，正是打造現代化全端 Web 應用程式的標準配備。', '2026-05-28 04:00:00'),
(22, 2, '網站上線前的準備清單', '將一個親手開發的全端 Web 專案從本機環境（Localhost）推向正式伺服器上線，是整個開發流程中最令人興奮卻也最需要謹慎對待的階段。為了確保網站上線後能穩定運行，開發者必須遵循一份嚴格的準備清單。首先是資料庫層面，必須確認 MySQL 中的資料表結構已經過合理的資料庫正規化（Database Normalization），並且在經常需要搜尋或排序的欄位（如 user_id, created_at）上建立了索引（Index），以優化查詢效能。其次是資安防護，必須將 PHP 的錯誤回報功能（display_errors）關閉，避免詳細的程式碼報錯洩露系統路徑；同時要檢查全站是否已強制啟用 HTTPS 加密傳輸。最後，必須調整伺服器上的檔案與資料夾權限（Permissions），防止外來惡意程式寫入。經過最後一輪完整的邊界條件測試與壓力測試後，專案才能算真正做好了迎接成千上萬真實使用者的準備。', '2026-05-28 04:15:00'),
(23, 1, 'Roblox Luau 基礎語法入門', '想要在 Roblox 平台上打造屬於自己的超人氣遊戲，掌握其專用的程式語言 Luau 是絕對核心的第一步。Luau 是一門基於 Lua 5.1 進行深度優化與擴充的輕量級、高效能腳本語言，它不僅承襲了 Lua 語法簡潔、易讀且好上手的特性，更引入了漸進式類型檢查（Gradual Typing）等現代程式語言的先進特性。在入門階段，開發者首先需要熟悉基礎的變數宣告、多條件判斷式（if-else）以及各種迴圈控制（如 for、while 和 pairs/ipairs 迭代器）。理解 Luau 的變數作用域（Scope）同樣至關重要，養成使用 local 關鍵字宣告區域變數的良好習慣，不僅能有效避免全域變數造成的命名衝突，還能顯著提升腳本在伺服器與客戶端底層的執行效率。透過精心編寫的基礎腳本，你就能開始操控遊戲世界中的各種實體物件（Parts），開啟無限的創意可能。', '2026-05-28 05:00:00'),
(24, 2, 'TweenService 實作流暢 UI 動畫', '在 Roblox 遊戲開發中，遊戲介面（User Interface）的質感往往直接決定了玩家對遊戲的第一印象。一個生硬、瞬間彈出且毫無轉場效果的選單，會大大降低遊戲的專業感。幸好，Roblox 內建了強大的 TweenService（補間動畫服務），讓開發者能夠以極少量的程式碼，為 UI 元件創造出極其平滑且具備物理質感的動態效果。透過 TweenService，你可以自由控制 UI 元素的各項屬性，包括位置（Position）、大小（Size）、透明度（BackgroundTransparency）以及旋轉角度等。在實作時，我們會搭配 TweenInfo.new() 來細緻地定義動畫的持續時間、重複次數、是否自動反轉，以及最重要的「緩和曲線」（EasingStyle，如 Bounce、Elastic、Sine 等）。不論是讓主選單優雅地從螢幕外滑入，還是讓按鈕在玩家懸停時產生動態縮放回饋，TweenService 都是提升遊戲交互體驗的終極利器。', '2026-05-28 05:15:00'),
(25, 1, 'DataStoreService 玩家資料儲存', '對於任何一款具備角色扮演（RPG）、模擬經營或長期升級機制的 Roblox 遊戲而言，如何安全且穩定地保存玩家的遊戲進度，是關乎遊戲壽命的命脈所在。Roblox 提供了 DataStoreService（資料儲存服務），允許開發者將玩家的關鍵數據（如等級、經驗值、虛擬金幣、背包裝備等）持久化地保存在雲端資料庫中。在編寫資料儲存腳本時，我們通常會在玩家加入遊戲時觸發 PlayerAdded 事件，從雲端讀取資料並動態初始化玩家的 Leaderstats 數據；而在玩家離開遊戲時則觸發 PlayerRemoving 事件，將最新的數據打包並安全地寫回雲端。由於網路環境充滿不確定性，資料讀寫過程中極易因為伺服器波動而發生異常，因此我們必須將所有的 DataStore 讀寫指令封裝在 pcall（Protected Call，保護模式呼叫）中，並設計完善的錯誤攔截與自動重試機制，徹底杜絕因為斷線而導致玩家進度遺失、心血白費的悲劇。', '2026-05-28 05:30:00'),
(26, 2, '打造順暢的戰鬥系統打擊感', '一款動作或格鬥類型的 Roblox 遊戲是否好玩，關鍵就在於戰鬥系統的「打擊感」（Game Feel）。優秀的打擊感並非單靠程式碼邏輯，而是需要將多種視覺、聽覺反饋在極短的時間內進行完美的交織與同步。首先，當玩家揮動武器或釋放技能時，我們要在客戶端利用腳本即時播放流暢角色動畫（Animations），並搭配動態生成的武器軌跡特效（Trail）。在攻擊判斷命中瞬間，除了扣除敵人的生命值（Health）外，後端或前端腳本必須立刻觸發連帶效應：在命中點生成炫目的粒子特效（ParticleEmitter）、播放震撼且具備空間立體感的音效（Sound 效果），並對玩家的視角實作輕微的相機震動（Camera Shake）。更進階的作法還包括短暫的「擊中定格」（Hit Stop）效果，透過微幅調慢受擊者的物理運動速度，能賦予每一次攻擊強烈的重量感與打擊回饋，讓玩家欲罷不能。', '2026-05-28 05:45:00'),
(27, 1, '認識 Roblox 的 Server 與 Client', '深刻理解並掌握伺服器（Server）與客戶端（Client）之間的架構關係，是從 Roblox 新手晉升為專業全端遊戲開發者的必經分水嶺。Roblox 採用了典型的網路主從架構：伺服器負責全域物理計算、資料庫讀寫、傷害判定等核心邏輯，是絕對不可信任客戶端的安全防線；而客戶端（即玩家的電腦或手機）則負責處理渲染畫面、UI 顯示、玩家輸入等前端呈現。這兩者位於完全隔離的運行環境中，如果要在它們之間傳遞訊息，就必須仰賴 RemoteEvent（遠端事件）與 RemoteFunction（遠端函式）。例如，當玩家按下鍵盤上的技能鍵時，本地腳本（LocalScript）會捕獲這一輸入，並透過 FireServer() 向伺服器發送請求；伺服器在接收到事件後，會先在後端嚴格驗證該玩家的技能冷卻時間與能量是否足夠，確認合法後才真正執行傷害計算並同步廣播給所有玩家。搞懂這套同步與防外掛機制，才能寫出安全、流暢且不卡頓的網路遊戲。', '2026-05-28 06:00:00'),
(28, 2, '手速極限：排行榜系統實作', '在競技或考驗反應速度的休閒遊戲中，激發玩家之間的競爭心理是提升留存率的絕佳手段。以我們正在開發的專案為例，打造一個全服即時更新的「手速極限全球排行榜」能帶來巨大的互動樂趣。在 Roblox 中，要實作全球跨伺服器的排行榜，必須使用 DataStoreService 底下的特殊分支 —— OrderedDataStore。與一般的資料儲存不同，OrderedDataStore 要求儲存的數值必須是正整數，它會在雲端自動對所有玩家的分數進行由大到小（或由小到大）的排序。在實作排行榜看板（Leaderboard UI）時，我們會編寫一個常駐的伺服器腳本（Script），利用一個定時迴圈（例如每隔 60 秒），使用 GetSortedAsync() 方法從雲端抓取全服前 10 名或前 50 名的頂尖玩家資料。抓取成功後，再透過 RemoteEvent 將這份包含玩家名稱與極限分數的陣列傳遞給前端，動態更新置於遊戲大廳中的 3D 實體看板，給予高分玩家無上的榮譽感。', '2026-05-28 06:15:00'),
(29, 1, '遊戲內的虛擬經濟設計', '一款成功的 Roblox 遊戲背後，往往都有著一套經過深思熟慮、平衡且具備高度持續性的「虛擬經濟系統」。經濟設計的核心在於完美拿捏金幣產出（Faucets）與金幣消耗（Sinks）之間的動態平衡。在遊戲的玩法循環（Gameplay Loop）中，玩家透過完成任務、擊敗怪物或刷新手速紀錄來獲取虛擬貨幣，這是金幣的產出渠道。然而，如果只有產出而沒有合理的消耗途徑，將會導致嚴重的通貨膨脹，讓貨幣迅速貶值並使玩家失去動力。因此，我們必須設計豐富且具備層次感的經濟循環，例如購買全新外觀的武器皮膚、升級角色的基礎屬性、解鎖全新地圖的通行證，或是參與機率性的扭蛋抽獎。在編寫後端邏輯時，所有涉及貨幣變動的程式碼都必須在伺服器端進行嚴格的雙重校驗，確保每一筆交易都合法合規，防範任何透過外掛非法修改本地數值的作弊行為，維護遊戲世界的公平公正。', '2026-05-28 06:30:00'),
(30, 2, '利用 ModuleScript 模組化程式碼', '當你的 Roblox 遊戲專案隨著創意不斷擴展，從最初的幾百行腳本演變成包含上萬行代碼的龐大系統時，如果依然將所有的邏輯塞在少數幾個常規腳本中，程式碼將會變得極其臃腫、難以維護且充滿臭蟲。為了解決這個工程痛點，熟練運用 ModuleScript（模組腳本）進行代碼的「模組化與重構」是唯一的解決之道。ModuleScript 的核心概念是將具備特定功能、高度重複使用的程式碼邏輯（例如：資料庫儲存邏輯、UI 動畫通用函式、傷害計算演算法等）單獨抽離出來，封裝成一個獨立的模組。這個模組不會自動執行，而是等待其他腳本透過 require() 關鍵字將其載入。透過物件導向程式設計（OOP）的觀念，我們可以在 ModuleScript 中定義類別與方法，這不僅實現了「不要重複你自己」（DRY, Don\'t Repeat Yourself）的軟體工程黃金法則，更能讓多位開發者同時協作不同的模組，大幅提升專案的開發效率與系統穩定度。', '2026-05-28 06:45:00'),
(31, 1, '處理玩家中途離線的邊界情況', '在編寫網路遊戲的後端邏輯時，資深開發者與新手最大的差別，往往體現在對「邊界情況（Edge Cases）」的處理能力上。在 Roblox 繁雜的網路環境中，玩家因為手機沒電、網路斷線、閃退或是直接關閉遊戲而突然「中途離線」，是非常頻繁發生的現象。如果我們的腳本只是天真地依靠 PlayerRemoving 事件來儲存資料，當遇到伺服器崩潰（Crash）或是大規模網路波動時，極有可能發生資料來不及寫入就徹底遺失的慘劇。為了打造堅不可摧的資料防護網，我們必須實作更加嚴密的安全機制。除了在 PlayerRemoving 時儲存外，腳本還應該利用 BindToClose() 函式。這個函式會在伺服器即將關閉或重啟時被觸發，它會強制等待腳本將當前伺服器內所有剩餘玩家的資料全數安全寫回雲端資料庫後，才允許伺服器正式關閉。此外，引入定時自動存檔（Auto-Save）機制（如每 5 分鐘自動備份一次），能將意外發生時的玩家損失控制在最低限度。', '2026-05-28 07:00:00'),
(32, 2, '賽博龐克風格的場景搭建技巧', '想要讓你的 Roblox 遊戲在數以萬計的作品中脫穎而出，除了核心玩法要扎實外，獨樹一幟、充滿沉浸感的視覺美術風格同樣是吸睛的關鍵。近年來大受歡迎的「賽博龐克（Cyberpunk）」風格，就是一個非常適合在 Roblox Studio 中展現視覺張力的主題。要搭建出完美的賽博龐克世界，首先要巧妙操控環境的光影設定（Lighting）。我們可以將遊戲內的時間調整為深夜，並將 Ambient（環境光）與 OutdoorAmbient 調深，營造出壓抑且幽暗的城市基調。接著，大量運用內建的 Neon（霓虹發光）材質來製作大樓表面的廣告看板、街道上的機械線條與載具軌跡。色彩搭配上，要選用高對比、高飽和度的冷暖色調碰撞，例如大面積的深電子藍搭配亮眼的螢光粉紅。最後，加入 Atmosphere（大氣效果）調高霧氣濃度（Density），並微調 ColorCorrection 提升畫面色彩對比度，就能完美再現那種煙雨濛濛、霓虹交錯、高科技與低生活交織的經典科幻場景。', '2026-05-28 07:15:00'),
(33, 137, 'gogolo-旅遊', '我是GO導遊', '2026-05-29 15:52:09'),
(34, 138, '管理員日記', '嗨!大家好~\n我是FunTech社群網站的管理員\n以下為更新:\n1.遊戲多元\n2.畫面美化\n3.點擊個人頭像即可上傳圖片', '2026-05-31 02:54:17');

-- --------------------------------------------------------

--
-- 資料表結構 `friends`
--

CREATE TABLE `friends` (
  `id` int(10) NOT NULL,
  `requester_id` int(10) NOT NULL,
  `addressee_id` int(10) NOT NULL,
  `status` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `friends`
--

INSERT INTO `friends` (`id`, `requester_id`, `addressee_id`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 3, 'pending', '2026-05-23 05:31:14', '2026-05-23 05:31:14'),
(9, 2, 1, 'accept', '2026-05-27 10:32:06', '2026-05-27 10:32:21');

-- --------------------------------------------------------

--
-- 資料表結構 `games`
--

CREATE TABLE `games` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `cover` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `games`
--

INSERT INTO `games` (`id`, `title`, `description`, `cover`) VALUES
(1, '數字挑戰', '依序點擊數字，按升序完成挑戰！', 'games/1/cover.svg'),
(2, '記憶挑戰', '翻開圖案相同的卡牌即可得分！', 'games/2/cover.svg'),
(3, '反應力測試', '看到綠色畫面就立刻點擊，測試你的反應速度！', 'games/3/cover.svg'),
(4, '打地鼠', '地鼠冒出來就快點擊，30秒內打越多分越高！', 'games/4/cover.svg'),
(5, '滑動拼圖', '移動方塊讓數字從1排列到8，用最少步數完成！', 'games/5/cover.svg');

-- --------------------------------------------------------

--
-- 資料表結構 `scores`
--

CREATE TABLE `scores` (
  `id` int(10) UNSIGNED NOT NULL,
  `game_id` int(10) UNSIGNED NOT NULL,
  `player_name` text NOT NULL,
  `score` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `scores`
--

INSERT INTO `scores` (`id`, `game_id`, `player_name`, `score`, `created_at`) VALUES
(1, 1, '小明', 95000, '2026-05-12 14:00:00'),
(2, 1, '阿傑', 89000, '2026-05-12 19:00:00'),
(3, 1, 'Wei', 82500, '2026-05-13 00:00:00'),
(4, 1, 'judy', 82000, '2026-05-13 05:00:00'),
(5, 1, 'mack', 70500, '2026-05-13 10:00:00'),
(6, 1, 'Luna', 64000, '2026-05-13 15:00:00'),
(7, 1, '阿哲', 58000, '2026-05-13 20:00:00'),
(8, 1, 'Coco', 41000, '2026-05-14 01:00:00'),
(9, 2, '靜香', 1280, '2026-05-14 06:00:00'),
(10, 2, '大雄', 1140, '2026-05-14 11:00:00'),
(11, 2, 'Amy', 1020, '2026-05-14 16:00:00'),
(12, 2, '阿宏', 960, '2026-05-14 21:00:00'),
(13, 2, '小美', 870, '2026-05-15 02:00:00'),
(14, 2, 'Kevin', 760, '2026-05-15 07:00:00'),
(15, 2, 'Nina', 650, '2026-05-15 12:00:00'),
(16, 2, 'Ryan', 540, '2026-05-15 17:00:00'),
(17, 3, 'Ryan', 985, '2026-05-15 22:00:00'),
(18, 3, 'Tina', 940, '2026-05-16 03:00:00'),
(19, 3, '阿凱', 900, '2026-05-16 08:00:00'),
(20, 3, 'Nina', 860, '2026-05-16 13:00:00'),
(21, 3, 'mack', 820, '2026-05-16 18:00:00'),
(22, 3, '政宏', 770, '2026-05-16 23:00:00'),
(23, 3, 'judy', 720, '2026-05-17 04:00:00'),
(24, 3, '思妤', 660, '2026-05-17 09:00:00'),
(25, 4, '阿傑', 48, '2026-05-17 14:00:00'),
(26, 4, '小明', 44, '2026-05-17 19:00:00'),
(27, 4, 'Coco', 41, '2026-05-18 00:00:00'),
(28, 4, 'Kevin', 37, '2026-05-18 05:00:00'),
(29, 4, 'Amy', 33, '2026-05-18 10:00:00'),
(30, 4, '大雄', 29, '2026-05-18 15:00:00'),
(31, 4, '靜香', 25, '2026-05-18 20:00:00'),
(32, 4, 'Wei', 20, '2026-05-19 01:00:00'),
(33, 5, 'Luna', 8800, '2026-05-19 06:00:00'),
(34, 5, '思妤', 8250, '2026-05-19 11:00:00'),
(35, 5, 'Wei', 7700, '2026-05-19 16:00:00'),
(36, 5, '政宏', 7100, '2026-05-19 21:00:00'),
(37, 5, '阿哲', 6400, '2026-05-20 02:00:00'),
(38, 5, 'Tina', 5600, '2026-05-20 07:00:00'),
(39, 5, 'mack', 4900, '2026-05-20 12:00:00'),
(40, 5, 'judy', 4000, '2026-05-20 17:00:00');

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `header` text NOT NULL COMMENT '頭像路徑',
  `bio` text NOT NULL COMMENT '個人簡介'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `header`, `bio`) VALUES
(1, 'mack', '1234', 'mack@gmai.com', 'mack.jpg', ' OLOLO'),
(2, 'judy', '5678', 'judy@pchome.com', 'judy.jpg', 'I am judy.'),
(3, 'yo', 'A', 'yo@gmail.com', 'yo.jpg', ''),
(4, 'aa', 'aa', 'aa@aa', '', ''),
(5, 'bb', 'bb', 'bb@bb', '', ''),
(6, 'ha', 'ha', 'ha@ha', '', ''),
(7, 'Arthur_test', '1234', 'Arthur_test@funtech.com', '', ''),
(8, 'Amy_test', '1234', 'Amy_test@funtech.com', '', ''),
(9, 'Adam_test', '1234', 'Adam_test@funtech.com', '', ''),
(10, 'Ashley_test', '1234', 'Ashley_test@funtech.com', '', ''),
(11, 'Alexander_test', '1234', 'Alexander_test@funtech.com', '', ''),
(12, 'Benjamin_test', '1234', 'Benjamin_test@funtech.com', '', ''),
(13, 'Betty_test', '1234', 'Betty_test@funtech.com', '', ''),
(14, 'Blake_test', '1234', 'Blake_test@funtech.com', '', ''),
(15, 'Brenda_test', '1234', 'Brenda_test@funtech.com', '', ''),
(16, 'Brody_test', '1234', 'Brody_test@funtech.com', '', ''),
(17, 'Christian_test', '1234', 'Christian_test@funtech.com', '', ''),
(18, 'Catherine_test', '1234', 'Catherine_test@funtech.com', '', ''),
(19, 'Colin_test', '1234', 'Colin_test@funtech.com', '', ''),
(20, 'Clara_test', '1234', 'Clara_test@funtech.com', '', ''),
(21, 'Caleb_test', '1234', 'Caleb_test@funtech.com', '', ''),
(22, 'Derek_test', '1234', 'Derek_test@funtech.com', '', ''),
(23, 'Dylan_test', '1234', 'Dylan_test@funtech.com', '', ''),
(24, 'Daisy_test', '1234', 'Daisy_test@funtech.com', '', ''),
(25, 'Dominic_test', '1234', 'Dominic_test@funtech.com', '', ''),
(26, 'Dakota_test', '1234', 'Dakota_test@funtech.com', '', ''),
(27, 'Evan_test', '1234', 'Evan_test@funtech.com', '', ''),
(28, 'Eleanor_test', '1234', 'Eleanor_test@funtech.com', '', ''),
(29, 'Eric_test', '1234', 'Eric_test@funtech.com', '', ''),
(30, 'Evelyn_test', '1234', 'Evelyn_test@funtech.com', '', ''),
(31, 'Elijah_test', '1234', 'Elijah_test@funtech.com', '', ''),
(32, 'Faith_test', '1234', 'Faith_test@funtech.com', '', ''),
(33, 'Finn_test', '1234', 'Finn_test@funtech.com', '', ''),
(34, 'Flora_test', '1234', 'Flora_test@funtech.com', '', ''),
(35, 'Fabian_test', '1234', 'Fabian_test@funtech.com', '', ''),
(36, 'Felicity_test', '1234', 'Felicity_test@funtech.com', '', ''),
(37, 'Gabriel_test', '1234', 'Gabriel_test@funtech.com', '', ''),
(38, 'Gemma_test', '1234', 'Gemma_test@funtech.com', '', ''),
(39, 'Gregory_test', '1234', 'Gregory_test@funtech.com', '', ''),
(40, 'Gloria_test', '1234', 'Gloria_test@funtech.com', '', ''),
(41, 'Graham_test', '1234', 'Graham_test@funtech.com', '', ''),
(42, 'Harper_test', '1234', 'Harper_test@funtech.com', '', ''),
(43, 'Hunter_test', '1234', 'Hunter_test@funtech.com', '', ''),
(44, 'Hailey_test', '1234', 'Hailey_test@funtech.com', '', ''),
(45, 'Hector_test', '1234', 'Hector_test@funtech.com', '', ''),
(46, 'Hope_test', '1234', 'Hope_test@funtech.com', '', ''),
(47, 'Iris_test', '1234', 'Iris_test@funtech.com', '', ''),
(48, 'Ivan_test', '1234', 'Ivan_test@funtech.com', '', ''),
(49, 'Ivy_test', '1234', 'Ivy_test@funtech.com', '', ''),
(50, 'Isaiah_test', '1234', 'Isaiah_test@funtech.com', '', ''),
(51, 'Irene_test', '1234', 'Irene_test@funtech.com', '', ''),
(52, 'Jacob_test', '1234', 'Jacob_test@funtech.com', '', ''),
(53, 'Jessica_test', '1234', 'Jessica_test@funtech.com', '', ''),
(54, 'Justin_test', '1234', 'Justin_test@funtech.com', '', ''),
(55, 'Jocelyn_test', '1234', 'Jocelyn_test@funtech.com', '', ''),
(56, 'Joshua_test', '1234', 'Joshua_test@funtech.com', '', ''),
(57, 'Kaylee_test', '1234', 'Kaylee_test@funtech.com', '', ''),
(58, 'Kenneth_test', '1234', 'Kenneth_test@funtech.com', '', ''),
(59, 'Kiera_test', '1234', 'Kiera_test@funtech.com', '', ''),
(60, 'Keith_test', '1234', 'Keith_test@funtech.com', '', ''),
(61, 'Kendall_test', '1234', 'Kendall_test@funtech.com', '', ''),
(62, 'Logan_test', '1234', 'Logan_test@funtech.com', '', ''),
(63, 'Lauren_test', '1234', 'Lauren_test@funtech.com', '', ''),
(64, 'Luke_test', '1234', 'Luke_test@funtech.com', '', ''),
(65, 'Leah_test', '1234', 'Leah_test@funtech.com', '', ''),
(66, 'Leo_test', '1234', 'Leo_test@funtech.com', '', ''),
(67, 'Matthew_test', '1234', 'Matthew_test@funtech.com', '', ''),
(68, 'Megan_test', '1234', 'Megan_test@funtech.com', '', ''),
(69, 'Marcus_test', '1234', 'Marcus_test@funtech.com', '', ''),
(70, 'Maya_test', '1234', 'Maya_test@funtech.com', '', ''),
(71, 'Miles_test', '1234', 'Miles_test@funtech.com', '', ''),
(72, 'Nicholas_test', '1234', 'Nicholas_test@funtech.com', '', ''),
(73, 'Naomi_test', '1234', 'Naomi_test@funtech.com', '', ''),
(74, 'Nolan_test', '1234', 'Nolan_test@funtech.com', '', ''),
(75, 'Nina_test', '1234', 'Nina_test@funtech.com', '', ''),
(76, 'Nathaniel_test', '1234', 'Nathaniel_test@funtech.com', '', ''),
(77, 'Oscar_test', '1234', 'Oscar_test@funtech.com', '', ''),
(78, 'Ophelia_test', '1234', 'Ophelia_test@funtech.com', '', ''),
(79, 'Omar_test', '1234', 'Omar_test@funtech.com', '', ''),
(80, 'Orla_test', '1234', 'Orla_test@funtech.com', '', ''),
(81, 'Orion_test', '1234', 'Orion_test@funtech.com', '', ''),
(82, 'Parker_test', '1234', 'Parker_test@funtech.com', '', ''),
(83, 'Paige_test', '1234', 'Paige_test@funtech.com', '', ''),
(84, 'Paul_test', '1234', 'Paul_test@funtech.com', '', ''),
(85, 'Piper_test', '1234', 'Piper_test@funtech.com', '', ''),
(86, 'Preston_test', '1234', 'Preston_test@funtech.com', '', ''),
(87, 'Quentin_test', '1234', 'Quentin_test@funtech.com', '', ''),
(88, 'Qiana_test', '1234', 'Qiana_test@funtech.com', '', ''),
(89, 'Quigley_test', '1234', 'Quigley_test@funtech.com', '', ''),
(90, 'Querida_test', '1234', 'Querida_test@funtech.com', '', ''),
(91, 'Quill_test', '1234', 'Quill_test@funtech.com', '', ''),
(92, 'Richard_test', '1234', 'Richard_test@funtech.com', '', ''),
(93, 'Riley_test', '1234', 'Riley_test@funtech.com', '', ''),
(94, 'Roman_test', '1234', 'Roman_test@funtech.com', '', ''),
(95, 'Ruby_test', '1234', 'Ruby_test@funtech.com', '', ''),
(96, 'Raymond_test', '1234', 'Raymond_test@funtech.com', '', ''),
(97, 'Steven_test', '1234', 'Steven_test@funtech.com', '', ''),
(98, 'Samantha_test', '1234', 'Samantha_test@funtech.com', '', ''),
(99, 'Simon_test', '1234', 'Simon_test@funtech.com', '', ''),
(100, 'Stella_test', '1234', 'Stella_test@funtech.com', '', ''),
(101, 'Silas_test', '1234', 'Silas_test@funtech.com', '', ''),
(102, 'Timothy_test', '1234', 'Timothy_test@funtech.com', '', ''),
(103, 'Trinity_test', '1234', 'Trinity_test@funtech.com', '', ''),
(104, 'Tristan_test', '1234', 'Tristan_test@funtech.com', '', ''),
(105, 'Tessa_test', '1234', 'Tessa_test@funtech.com', '', ''),
(106, 'Tobias_test', '1234', 'Tobias_test@funtech.com', '', ''),
(107, 'Ursula_test', '1234', 'Ursula_test@funtech.com', '', ''),
(108, 'Uriel_test', '1234', 'Uriel_test@funtech.com', '', ''),
(109, 'Upton_test', '1234', 'Upton_test@funtech.com', '', ''),
(110, 'Unity_test', '1234', 'Unity_test@funtech.com', '', ''),
(111, 'Usain_test', '1234', 'Usain_test@funtech.com', '', ''),
(112, 'Valerie_test', '1234', 'Valerie_test@funtech.com', '', ''),
(113, 'Vernon_test', '1234', 'Vernon_test@funtech.com', '', ''),
(114, 'Violet_test', '1234', 'Violet_test@funtech.com', '', ''),
(115, 'Vance_test', '1234', 'Vance_test@funtech.com', '', ''),
(116, 'Vivian_test', '1234', 'Vivian_test@funtech.com', '', ''),
(117, 'Weston_test', '1234', 'Weston_test@funtech.com', '', ''),
(118, 'Wendy_test', '1234', 'Wendy_test@funtech.com', '', ''),
(119, 'Warren_test', '1234', 'Warren_test@funtech.com', '', ''),
(120, 'Whitney_test', '1234', 'Whitney_test@funtech.com', '', ''),
(121, 'Wade_test', '1234', 'Wade_test@funtech.com', '', ''),
(122, 'Ximena_test', '1234', 'Ximena_test@funtech.com', '', ''),
(123, 'Xylon_test', '1234', 'Xylon_test@funtech.com', '', ''),
(124, 'Xiomara_test', '1234', 'Xiomara_test@funtech.com', '', ''),
(125, 'Xerxes_test', '1234', 'Xerxes_test@funtech.com', '', ''),
(126, 'Xanthe_test', '1234', 'Xanthe_test@funtech.com', '', ''),
(127, 'Yvonne_test', '1234', 'Yvonne_test@funtech.com', '', ''),
(128, 'Yosef_test', '1234', 'Yosef_test@funtech.com', '', ''),
(129, 'Yvette_test', '1234', 'Yvette_test@funtech.com', '', ''),
(130, 'Yohan_test', '1234', 'Yohan_test@funtech.com', '', ''),
(131, 'Yael_test', '1234', 'Yael_test@funtech.com', '', ''),
(132, 'Zion_test', '1234', 'Zion_test@funtech.com', '', ''),
(133, 'Zara_test', '1234', 'Zara_test@funtech.com', '', ''),
(134, 'Zeke_test', '1234', 'Zeke_test@funtech.com', '', ''),
(135, 'Zola_test', '1234', 'Zola_test@funtech.com', '', ''),
(136, 'Zander_test', '1234', 'Zander_test@funtech.com', '', ''),
(137, 'gogolo', 'go', 'gogolo@go.com', 'gogolo.jpg', 'HI,evernone. My name is gogolo.'),
(138, 'admin', '1234', 'admin@funtech.com', 'admin.png', '管理員-admin');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `games`
--
ALTER TABLE `games`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
