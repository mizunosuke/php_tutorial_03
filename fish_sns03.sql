-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2022 年 12 月 06 日 04:41
-- サーバのバージョン： 10.4.27-MariaDB
-- PHP のバージョン: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `fish_sns03`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `mypage_table`
--

CREATE TABLE `mypage_table` (
  `id` int(20) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `intro` varchar(300) NOT NULL,
  `area` varchar(300) NOT NULL,
  `userid` int(20) NOT NULL,
  `image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `mypage_table`
--

INSERT INTO `mypage_table` (`id`, `nickname`, `intro`, `area`, `userid`, `image`) VALUES
(1, '検討師', '増税します！', '倉橋島', 6, '../../img/20221204_043128.4541.jpeg'),
(2, 'マイネーム野郎', 'テスト２かいめ！', '倉橋島', 7, '../../img/20221204_081217.9295.jpeg'),
(3, 'fumio', '検討に検討を重ね、検討を加速します。\r\nまた、検討すべき議題についても検討の余地が大いにあると判断し、迅速かつ慎重に検討を進めていくことを検討する。', '広島湾', 8, '../../img/20221204_171807.5713.jpeg');

-- --------------------------------------------------------

--
-- テーブルの構造 `postdata_table`
--

CREATE TABLE `postdata_table` (
  `id` int(30) NOT NULL,
  `fishname` varchar(100) NOT NULL,
  `size` int(5) NOT NULL,
  `tackle` varchar(100) NOT NULL,
  `lure` varchar(150) NOT NULL,
  `weather` varchar(100) NOT NULL,
  `comment` varchar(150) NOT NULL,
  `userid` int(30) NOT NULL,
  `created_at` datetime(6) NOT NULL,
  `updated_at` datetime(6) DEFAULT NULL,
  `image` text NOT NULL,
  `area` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `postdata_table`
--

INSERT INTO `postdata_table` (`id`, `fishname`, `size`, `tackle`, `lure`, `weather`, `comment`, `userid`, `created_at`, `updated_at`, `image`, `area`) VALUES
(1, 'ブリ', 88, 'ステラSW６０００', 'ジグパラ４０g', '晴れ', '渋かった', 7, '2022-12-04 15:20:15.000000', NULL, '', '倉橋島'),
(2, 'イカ', 22, '', 'エギ王', '曇り', '風強すぎ', 7, '2022-12-04 15:33:55.000000', NULL, '../postimg/20221204_073355.6938.jpeg', '倉橋島'),
(3, 'サワラ', 100, 'コルトスナイパー', 'サワラチューン', '曇り', '総理が釣りに行ってみました', 8, '2022-12-05 01:20:06.000000', NULL, '../postimg/20221204_172006.8274.jpeg', '倉橋島');

-- --------------------------------------------------------

--
-- テーブルの構造 `user_table`
--

CREATE TABLE `user_table` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(300) NOT NULL,
  `pass` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `user_table`
--

INSERT INTO `user_table` (`id`, `name`, `email`, `pass`) VALUES
(1, 'user01', 'mizumizu@gmail.com', '$2y$10$CNzxxlD/F9hPG6svHmWX9.h5EDw74aLkrfukimOq9zl5Xqon22Tlu'),
(2, 'user02', 'mamama@gmail.com', '$2y$10$7U.1OO3NJb60kKzhatDpEuQU3n4vX4OQnZXxDcXxBMPbQKWoA0VP6'),
(3, 'user03', 'hhhhh@gmail.com', '$2y$10$Ba/eEOJKX2hfdgM7XkDgKecdgPJsGSycgCIKVrffmcVwVQ4uvztaW'),
(4, 'user04', 'aaaaaa@gmail.com', '$2y$10$UI667Q7XKQeJFq.l5H7CWejLFLyNPvBVSNcgxHHHkVZulEwHhSSRy'),
(6, 'user05', 'aaaaa@gmail.com', '$2y$10$wNsql/49URiw58m5oNSLD.LIOv/JA063bBAR.4dbhak8CB9NsfOKa'),
(7, 'myname', 'myname@gmail.com', '$2y$10$xMBbOLriGDL/eti8fzCstugtTC3vaGe48XSAUP1yLa8NmmikwQMDy'),
(8, 'hiraemizuki', 'hirae@gmail.com', '$2y$10$Xa5jBlzemK5AnAidMY54IeYkENIB08142/D865gcqQcKfIoroE13K');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `mypage_table`
--
ALTER TABLE `mypage_table`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `postdata_table`
--
ALTER TABLE `postdata_table`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `mypage_table`
--
ALTER TABLE `mypage_table`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルの AUTO_INCREMENT `postdata_table`
--
ALTER TABLE `postdata_table`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルの AUTO_INCREMENT `user_table`
--
ALTER TABLE `user_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
