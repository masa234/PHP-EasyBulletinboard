-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018 年 12 朁E04 日 04:51
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
-- Database: `bulletinboard`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `followings`
--

CREATE TABLE `followings` (
  `user_id` int(255) NOT NULL,
  `followed_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `followings`
--

INSERT INTO `followings` (`user_id`, `followed_id`) VALUES
(23, 24);

-- --------------------------------------------------------

--
-- テーブルの構造 `likes`
--

CREATE TABLE `likes` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `post_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`) VALUES
(65, 24, 15),
(66, 24, 14),
(67, 23, 15);

-- --------------------------------------------------------

--
-- テーブルの構造 `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `image` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `image`, `created_at`, `updated_at`, `user_id`) VALUES
(13, 'チコリータ', 'チコリータ', '', '2018-12-04 01:28:00', '2018-12-04 01:28:00', 24),
(14, 'iii', 'iiii', '', '2018-12-04 01:50:10', '2018-12-04 01:50:10', 24),
(15, 'チコリータ３', 'チコリータ', '', '2018-12-04 01:58:31', '2018-12-04 01:58:31', 23);

-- --------------------------------------------------------

--
-- テーブルの構造 `retweets`
--

CREATE TABLE `retweets` (
  `id` int(255) NOT NULL,
  `post_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `retweets`
--

INSERT INTO `retweets` (`id`, `post_id`, `user_id`) VALUES
(0, 13, 24),
(0, 15, 23);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `admin` tinyint(2) NOT NULL,
  `image` text NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `user_name`, `nickname`, `email`, `admin`, `image`, `password`) VALUES
(23, 'チコリータ', 'shizuku234', 'shizuku234@shizuku234', 0, '20181204012116356a192b7913b04c54574d18c28d46e6395428ab.jpeg', '$2y$10$GyIcXODPDy7kcRRc.7GkPuUgdpkl.fIW.RtX.y2bVpetj4aREXuSO'),
(24, 'ナエトル', 'naetoru2', 'bfmt1250081@gn.jp', 0, '20181204012533356a192b7913b04c54574d18c28d46e6395428ab.jpeg', '$2y$10$tg0KksGNp4ThU7jFTL1R.OWzLbjg7XSDWnqwRkiHVJefG95h7Yhaa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `followings`
--
ALTER TABLE `followings`
  ADD UNIQUE KEY `user_id_2` (`user_id`,`followed_id`),
  ADD KEY `user_id` (`user_id`,`followed_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD KEY `id` (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `retweets`
--
ALTER TABLE `retweets`
  ADD UNIQUE KEY `post_id_2` (`post_id`,`user_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `followings`
--
ALTER TABLE `followings`
  ADD CONSTRAINT `followings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- テーブルの制約 `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
