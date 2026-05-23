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
-- 資料表結構 `scores`
--
-- 說明：排行榜分數紀錄，供各遊戲的 pull_score.php 動態 API 讀取。
--   game_id     對應 games.id
--   player_name 玩家名稱
--   score       分數（數值越高名次越前）
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

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
