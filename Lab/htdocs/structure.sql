-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023-05-11 12:40:54
-- 伺服器版本： 10.4.28-MariaDB
-- PHP 版本： 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `資料庫`
--

-- --------------------------------------------------------

--
-- 資料表結構 `使用者資料表`
--

CREATE TABLE `使用者資料表` (
  `ID` varchar(100) NOT NULL,
  `密碼` varchar(100) NOT NULL,
  `姓名` varchar(100) NOT NULL,
  `實驗室編號或辦公室編號` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `聯絡電話` varchar(100) NOT NULL,
  `權限` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `使用者資料表`
--

INSERT INTO `使用者資料表` (`ID`, `密碼`, `姓名`, `實驗室編號或辦公室編號`, `Email`, `聯絡電話`, `權限`) VALUES
('admin', 'admin', 'admin', 'none', 'none', 'none', 2),
('M113040063', '123', 'jim', '5012', '106207237@nccu.edu.tw', '097821654', 0),
('M113040064', '123', '李冠宏', 'EC5007', 'jim880705@gmail.com', '0970224933', 0),
('O123', '123', '黃莉萍', 'EC5011', '123123123@gmail.com', '0978523845', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `教室資料表`
--

CREATE TABLE `教室資料表` (
  `教室編號` varchar(100) NOT NULL,
  `教室位置` varchar(100) NOT NULL,
  `容納人數` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `教室資料表`
--

INSERT INTO `教室資料表` (`教室編號`, `教室位置`, `容納人數`) VALUES
('EC1001', '電資大樓1樓', 30),
('EC1002', '電資大樓1樓', 100),
('EC1005', '電資大樓1樓', 10),
('EC5007', '電資大樓5樓', 50),
('EC5012', '電資大樓5樓', 100),
('EC9032', '電資大樓9樓', 40);

-- --------------------------------------------------------

--
-- 資料表結構 `申請日期和節數表`
--

CREATE TABLE `申請日期和節數表` (
  `申請序號` int(100) NOT NULL,
  `日期` varchar(100) NOT NULL,
  `節數` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `申請日期和節數表`
--

INSERT INTO `申請日期和節數表` (`申請序號`, `日期`, `節數`) VALUES
(1, '2023-05-17', '2'),
(1, '2023-05-17', '3'),
(1, '2023-05-17', '4'),
(2, '2023-05-17', '2'),
(2, '2023-05-17', '3'),
(2, '2023-05-17', '4'),
(3, '2023-05-27', '5'),
(4, '2023-05-10', '3'),
(4, '2023-05-10', '4'),
(5, '2023-05-10', '4'),
(5, '2023-05-10', '5');

-- --------------------------------------------------------

--
-- 資料表結構 `申請設備表`
--

CREATE TABLE `申請設備表` (
  `申請序號` int(100) NOT NULL,
  `附加申請設備編號` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `申請設備表`
--

INSERT INTO `申請設備表` (`申請序號`, `附加申請設備編號`) VALUES
(3, 5),
(4, 5),
(5, 3),
(5, 4),
(5, 5);

-- --------------------------------------------------------

--
-- 資料表結構 `申請資料表`
--

CREATE TABLE `申請資料表` (
  `申請序號` int(100) NOT NULL,
  `教室編號` varchar(100) NOT NULL,
  `借用人` varchar(100) NOT NULL,
  `姓名` varchar(100) NOT NULL,
  `歸還日期` varchar(100) DEFAULT NULL,
  `系辦人員` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `申請資料表`
--

INSERT INTO `申請資料表` (`申請序號`, `教室編號`, `借用人`, `姓名`, `歸還日期`, `系辦人員`) VALUES
(1, 'EC1001', 'm113040064', '李冠宏', '2023-05-09', '黃莉萍'),
(2, 'EC1002', 'm113040064', '李冠宏', '2023-05-09', '黃莉萍'),
(3, 'EC1001', 'M113040064', '李冠宏', NULL, NULL),
(4, 'EC5007', 'M113040064', '李冠宏', NULL, NULL),
(5, 'EC5012', 'M113040064', '李冠宏', '2023-05-10', '黃莉萍');

-- --------------------------------------------------------

--
-- 資料表結構 `設備資料表`
--

CREATE TABLE `設備資料表` (
  `設備編號` varchar(100) NOT NULL,
  `設備名稱` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `設備資料表`
--

INSERT INTO `設備資料表` (`設備編號`, `設備名稱`) VALUES
('1', '筆記型電腦'),
('2', '麥克風'),
('3', '轉接頭'),
('4', '雷射筆'),
('5', '酒精');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `使用者資料表`
--
ALTER TABLE `使用者資料表`
  ADD PRIMARY KEY (`ID`);

--
-- 資料表索引 `教室資料表`
--
ALTER TABLE `教室資料表`
  ADD PRIMARY KEY (`教室編號`);

--
-- 資料表索引 `申請資料表`
--
ALTER TABLE `申請資料表`
  ADD PRIMARY KEY (`申請序號`);

--
-- 資料表索引 `設備資料表`
--
ALTER TABLE `設備資料表`
  ADD PRIMARY KEY (`設備編號`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
