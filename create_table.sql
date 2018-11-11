-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018 年 11 朁E09 日 20:16
-- サーバのバージョン： 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zemi3`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `events`
--

CREATE TABLE `events` (
  `id` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `brief` varchar(255) NOT NULL,
  `detail` text NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `path` varchar(255) NOT NULL,
  `organizer` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `tag` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `free` int(255) NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `events`
--

INSERT INTO `events` (`id`, `title`, `brief`, `detail`, `lat`, `lng`, `path`, `organizer`, `start_date`, `end_date`, `tag`, `created_at`, `updated_at`, `location`, `free`, `user_id`) VALUES
(524288, 'user', 'user', 'user', 0.00002, 0.00002, 'user', 'user', '2018-11-10', '2018-11-28', 'user', '2018-11-09', '2018-11-09 17:15:48', 'user', 1, 161);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `img`, `created_at`, `updated_at`) VALUES
(65536, 'mogura', 'mogura@gn.jp', '$2y$10$XnuWPnHDJgVDHUqVEHpsJeHIU15gpmxCeTiT7cImI2Mvkd8QhunoC', '20181110031140356a192b7913b04c54574d18c28d46e6395428ab.jpg', '2018-11-10 03:11:40', '2018-11-10 03:11:40'),
(131072, 'yagami kou', 'mogura@gn.jp', '$2y$10$8/9cFexkt3JYNAf3tlm2VOCYMFLgcnZJV5gH4IiWXgXETocJnztnW', '20181110035041356a192b7913b04c54574d18c28d46e6395428abjpeg', '2018-11-10 03:50:41', '2018-11-10 03:50:41'),
(262144, 'chomado', 'xamarincsharp@ms.jp', '$2y$10$ySCq5xLV6AoBgmZILkvjt.YChlV/xti/NzZ0lIqHkwAOIQ0l25b7u', '20181110040402356a192b7913b04c54574d18c28d46e6395428ab.jpg', '2018-11-10 04:04:02', '2018-11-10 04:04:02'),
(524288, 'mikoto misaka', 'xamarincsharp@gn.iwasaki.ac.jp', '$2y$10$gCi82rXZu2FYQiPey8UOrufxOF5T87bl7Ok9QehgBqsVgVIXAroj.', '20181110041057356a192b7913b04c54574d18c28d46e6395428ab.jpg', '2018-11-10 04:10:57', '2018-11-10 04:10:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
