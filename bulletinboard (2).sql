-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018 年 11 朁E30 日 20:16
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
(16, 20),
(20, 30),
(21, 20);

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
(40, 20, 3);

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
(3, 'f', 'd', '20181127031044356a192b7913b04c54574d18c28d46e6395428ab.jpeg', '2018-11-27 03:10:44', '2018-11-27 03:10:44', 16);

-- --------------------------------------------------------

--
-- テーブルの構造 `retweets`
--

CREATE TABLE `retweets` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `post_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(16, '涼宮青葉', 'suzumiyaaoba1', 'suzumiyaaoba@gn.jp', 0, '\r\n', '$2y$10$yhg6P3ddoPyNT5x8vTr6COTheBvMx5k5jH3YDjYLzw7D55nfPKK0q'),
(20, 'shizuku', 'shizuku234', 'masa@masa', 1, '20181121160017356a192b7913b04c54574d18c28d46e6395428ab.jpeg', '$2y$10$pN2dLYTTRaA1EPkovrfE7O2s6Q9Ph9ixvkvo1UN/gIzLKXAW/Xy.m'),
(21, 'yukikaze1', 'Yukikaze1', 'ppp@gn.jp', 0, '20181130034352356a192b7913b04c54574d18c28d46e6395428ab.jpeg', '$2y$10$wtA4pWHrlkUFF/PWg2R4ruvcHnIFXCJEbJ/RxpQfxLAvGaOofw5pG'),
(22, 'ヒノアラシ', 'Simakaze2', 'simakazekamasi@gn.jp', 0, '20181130054608356a192b7913b04c54574d18c28d46e6395428ab.jpeg', '$2y$10$Mo0QAduyQiEP0poZ.XNQK.C1qj7Xfi0XYXLD7KKADA/Rdo/FK9MSy'),
(23, 'ヒノアラシ', 'Simakaze3', 'simakazekamasi@gn.jp', 0, '20181130054838356a192b7913b04c54574d18c28d46e6395428ab.jpeg', '$2y$10$DcCy.V2YvLuLhatryEZ3Z.nbrV67YEICKpNd1MeNVsGrNV4hmHVly'),
(24, 'ヒノアラシ', 'Simakaze4', 'simakazekamasi@gn.jp', 0, '20181130055718356a192b7913b04c54574d18c28d46e6395428ab.jpeg', '$2y$10$eHDNYx3fb9.RJVb4joU5wOI7fgIJmXGCuO7vrQYRYRspbTmBko.jK'),
(25, 'ddd', 'dddd4', 'ddd@gn.jp', 0, '20181130055811356a192b7913b04c54574d18c28d46e6395428ab.jpeg', '$2y$10$TbCUTUQCvpUgR7T1uzChGO5.oqxN3y8j6Xd3TCvhl/6IhuUJ8ObdK'),
(26, 'チコリータ', 'ddd8dd', 'uuu@hn.jp', 0, '20181130060025356a192b7913b04c54574d18c28d46e6395428ab.jpeg', '$2y$10$dnrII06FmheF1zWsE/tD9.HLaQvIKK5TvL1.LQwvL4howa27Mo90e'),
(27, 'チコリータ', 'ddd8ddd', 'uuu@hn.jp', 0, '', '$2y$10$8gMS3iUA9WaaN43b3ED2De1UMeNPEGwHwe7A5PCUd5/0u31SiintS'),
(28, 'チコリータ', 'ddd8dddd', 'uuu@hn.jp', 0, '', '$2y$10$Q/lyZtFOd/ajdq.df6Vyiezlf27kCOrKpWjWj86lgCIo9uB9aI8AS'),
(29, 'チコリータ', 'ddd8ddddd', 'uuu@hn.jp', 0, '', '$2y$10$qczgOoKt8gdY2R1NnwOg.uCbTIpVBAwFqr61A4qCt/07x4KIjjdh6'),
(30, 'チコリータ', 'ddd8dddddd', 'uuu@hn.jp', 0, '', '$2y$10$AuO3cshQ8mZ7LD5lVPwnUuetxIABhueVb7Nr1nL4HH7LzjQf4dQXu');

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
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `followings`
--
ALTER TABLE `followings`
  ADD CONSTRAINT `followings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;

--
-- テーブルの制約 `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;

--
-- テーブルの制約 `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;

--
-- テーブルの制約 `retweets`
--
ALTER TABLE `retweets`
  ADD CONSTRAINT `retweets_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
  ADD CONSTRAINT `retweets_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
