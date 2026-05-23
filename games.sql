-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2026-05-22 14:30:00
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
-- 資料表結構 `games`
--
-- 說明：遊戲列表頁（#games）所需的遊戲清單資料來源。
--   id          遊戲編號，同時對應 /games/<id>/ 專案資料夾名稱
--   title       遊戲名稱        → .game-item .game-title
--   description 遊戲簡短介紹    → .game-item .game-description
--   cover       遊戲封面圖路徑  → .game-item img.game-cover
-- 入口網址與分數 API 設定不放這裡，改放各遊戲資料夾的 game.json。
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

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `games`
--
ALTER TABLE `games`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
