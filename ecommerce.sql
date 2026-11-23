-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2025 at 10:45 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `added_at`) VALUES
(6, 1, 3, 1, '2025-04-19 13:36:26'),
(7, 1, 23, 1, '2025-04-19 14:27:55'),
(10, 6, 3, 3, '2025-04-19 19:22:12');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `price_text` varchar(50) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `rating` tinyint(4) DEFAULT 4
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`product_id`, `name`, `brand`, `price`, `price_text`, `image_path`, `rating`) VALUES
(1, 'Jolly Phonics Picture Flash Cards', 'Jolly Learning', 1350.00, '₹1350', 'images/Jolly Phonics Picture Flash Cards.webp', 4),
(2, 'Grammar 1 Pupil Book', 'Jolly Learning', 295.00, '₹295', 'images/Grammar 1 Pupil Book.webp', 4),
(3, 'Grammar 1 Workbooks Set of 1-6', 'Jolly Learning', 2200.00, '₹2200', 'images/Grammar 1 Workbooks set of 1-6.webp', 4),
(4, 'Grammar 2 Pupil Book', 'Jolly Learning', 295.00, '₹295', 'images/Grammar 2 Pupil Book.webp', 4),
(5, 'Grammar 5 Pupil Book', 'Jolly Learning', 295.00, '₹295', 'images/Grammar 5 Pupil Book.webp', 4),
(6, 'Grammar 4 Pupil Book', 'Jolly Learning', 295.00, '₹295', 'images/Grammar 4 Pupil Book.webp', 4),
(7, 'Grammar 1 Teacher Book', 'Jolly Learning', 450.00, '₹450', 'images/Grammar 1 Teacher Book.webp', 4),
(8, 'Grammar 2 Teacher Book', 'Jolly Learning', 450.00, '₹450', 'images/Grammar 2 Teacher Book.webp', 4),
(9, 'Grammar 3 Teacher Book', 'Jolly Learning', 450.00, '₹450', 'images/Grammar 3 Teacher Book.webp', 4),
(10, 'Grammar 4 Teacher Book', 'Jolly Learning', 450.00, '₹450', 'images/Grammar 4 Teacher Book.webp', 4),
(11, 'Grammar 5 Teacher Book', 'Jolly Learning', 450.00, '₹450', 'images/Grammar 5 Teacher Book.webp', 4),
(12, 'Grammar 6 Teacher Book', 'Jolly Learning', 450.00, '₹450', 'images\\Grammar 6 Teacher  Book.webp', 4),
(13, 'Grammar 3 Pupil Book', 'Jolly Learning', 295.00, '₹295', 'images/Grammar 3 Pupil Book.webp', 4),
(14, 'Grammar 6 Pupil Book', 'Jolly Learning', 295.00, '₹295', 'images/Grammar 6 Pupil Book.webp', 4),
(15, 'Grammar Games CD', 'Jolly Learning', 3200.00, '₹3200', 'images/Grammar Games CD.webp', 4),
(16, 'Grammar Songs', 'Jolly Learning', 1075.00, '₹1075', 'images/Grammar Songs.webp', 4),
(17, 'Jolly Dictionary', 'Jolly Learning', 1500.00, '₹1500', 'images/Jolly Dictionary.webp', 4),
(18, 'Jolly Classroom One Year Online subscription', 'Jolly Learning', 11800.00, '₹11800', 'images/Jolly Classroom One Year Online subscription.webp', 4),
(19, 'Jolly English Teachers Kit With Puppets', 'Jolly Learning', 15000.00, '₹15000', 'images/Jolly English Teachers Kit With Puppets.webp', 4),
(20, 'Jolly English Teachers Kit Without Puppets', 'Jolly Learning', 8000.00, '₹8000', 'images/Jolly English Teachers Kit Without Puppets.webp', 4),
(21, 'Jolly Grammar Big Book 1', 'Jolly Learning', 450.00, '₹450', 'images/Jolly Grammar Big Book 1.webp', 4),
(22, 'Jolly Grammar Big Book 2', 'Jolly Learning', 450.00, '₹450', 'images/Jolly Grammar Big Book 2.webp', 4),
(23, 'Jolly Jingles book and CD', 'Jolly Learning', 3300.00, '₹3300', 'images/Jolly Jingles book and CD.webp', 4),
(24, 'Jolly Music Big Book level 1', 'Jolly Learning', 2900.00, '₹2900', 'images/Jolly Music Big Book level 1.webp', 4),
(25, 'Jolly Music Big Book level 2', 'Jolly Learning', 2900.00, '₹2900', 'images/Jolly Music Big Book Level 2.webp', 4),
(26, 'Jolly Music Big Book level 3', 'Jolly Learning', 2900.00, '₹2900', 'images/Jolly Music Big Book Level 3.webp', 4),
(27, 'Jolly Phonics Activity Books, set 1-7', 'Jolly Learning', 4700.00, '₹4700', 'images/Jolly Phonics Activity Books, set 1-7.webp', 4),
(28, 'Jolly Phonics Blends Wheels pack of 10 wheels', 'Jolly Learning', 1550.00, '₹1550', 'images/Jolly Phonics Blends Wheels pack of 10 wheels.webp', 4),
(29, 'Jolly Phonics Capital Letter Handwriting Practice Book', 'Jolly Learning', NULL, 'Coming Soon', 'images/Jolly Phonics Capital Letter Handwriting Practice Book.webp', 4),
(30, 'Jolly Phonics Cards set of 4 boxes', 'Jolly Learning', 5350.00, '₹5350', 'images/Jolly Phonics Cards set of 4 boxes.webp', 4),
(31, 'Jolly Phonics Classroom Kit', 'Jolly Learning', 58000.00, '₹58000', 'images/Jolly Phonics Classroom Kit.webp', 4),
(32, 'Jolly Phonics Extra', 'Jolly Learning', 14000.00, '₹14000', 'images/Jolly Phonics Extra.webp', 4),
(33, 'Jolly Phonics Folktales Readers - Blue Level Books', 'Jolly Learning', 1295.00, '₹1295', 'images/Jolly Phonics Folktales Readers - Blue Level Books.webp', 4),
(34, 'Jolly Phonics Folktales Readers - Green Level Books', 'Jolly Learning', 1295.00, '₹1295', 'images/Jolly Phonics Folktales Readers - Green Level Books.webp', 4),
(35, 'Jolly Phonics Folktales Readers - Purple Level Books', 'Jolly Learning', 1295.00, '₹1295', 'images/Jolly Phonics Folktales Readers - Purple Level Books.webp', 4),
(36, 'Jolly Phonics Folktales Readers - Red Level Books', 'Jolly Learning', 1295.00, '₹1295', 'images/Jolly Phonics Folktales Readers - Red Level Books.webp', 4),
(37, 'Jolly Phonics Folktales Readers - Yellow Level Books', 'Jolly Learning', 1095.00, '₹1095', 'images/Jolly Phonics Folktales Readers - Yellow Level Books.webp', 4),
(38, 'Jolly phonics handwrittint books set of 7 books', 'Jolly Learning', 975.00, '₹975', 'images/jolly phonics handwrittint books set of 7 books.webp', 4),
(39, 'Jolly Phonics Letter Sound Poster', 'Jolly Learning', 600.00, '₹600', 'images/Jolly Phonics Letter Sound Poster.webp', 4),
(40, 'Jolly Phonics Letter Sound Strips (pack of 30 strips)', 'Jolly Learning', 1450.00, '₹1450', 'images/Jolly Phonics Letter Sound Strips (pack of 30 strips).webp', 4),
(41, 'Jolly Phonics Little Word Books', 'Jolly Learning', 1595.00, '₹1595', 'images/Jolly Phonics Little Word Books.webp', 4),
(42, 'Jolly Phonics Magnetic Letters (tub of 106)', 'Jolly Learning', 2600.00, '₹2600', 'images/Jolly Phonics Magnetic Letters (tub of 106).webp', 4),
(43, 'Jolly Phonics Pupil Book 1 ( New 2020 Edition)', 'Jolly Learning', 215.00, '₹215', 'images/Jolly Phonics Pupil Book 1 ( New 2020 Edition).webp', 4),
(44, 'Jolly Phonics Pupil Book 2 ( New 2020 Edition)', 'Jolly Learning', 215.00, '₹215', 'images/Jolly Phonics Pupil Book 2 ( New 2020 Edition).webp', 4),
(45, 'Jolly Phonics Pupil Book 3 ( New 2020 Edition)', 'Jolly Learning', 215.00, '₹215', 'images/Jolly Phonics Pupil Book 3 ( New 2020 Edition).webp', 4),
(46, 'Jolly Phonics Puppets, set of all 3', 'Jolly Learning', 8500.00, '₹8500', 'images/Jolly Phonics Puppets, set of all 3.webp', 4),
(47, 'Jolly Phonics Read and See, Pack 1 (12 titles)', 'Jolly Learning', 3550.00, '₹3550', 'images/Jolly Phonics Read and See, Pack 1 (12 titles).webp', 4),
(48, 'Jolly Phonics Read and See, Pack 2 (12 titles)', 'Jolly Learning', 3550.00, '₹3550', 'images/Jolly Phonics Read and See, Pack 2 (12 titles).webp', 4),
(49, 'Jolly Phonics Readers, Complete Set Yellow Level (pack of 18)', 'Jolly Learning', 2220.00, '₹2220', 'images\\Jolly Phonics Readers, Complete Set  Yellow Level (pack of 18).webp', 4),
(50, 'Jolly Phonics Readers, Complete Set Blue Level (pack of 18)', 'Jolly Learning', 2400.00, '₹2400', 'images\\Jolly Phonics Readers, Complete Set Blue Level  (pack of 18).webp', 4),
(51, 'Jolly Phonics Readers, Complete Set Red Level (pack of 18)', 'Jolly Learning', 2220.00, '₹2220', 'images/Jolly Phonics Readers, Complete Set Red Level (pack of 18).webp', 4),
(52, 'Jolly Phonics Readers, Complete Set, Purple Level (pack of 18)', 'Jolly Learning', 2400.00, '₹2400', 'images/Jolly Phonics Readers, Complete Set, Purple Level (pack of 18) NEW.webp', 4),
(53, 'Jolly Phonics Readers, ORANGE READERS (pack of 21)', 'Jolly Learning', 2400.00, '₹2400', 'images\\Jolly Phonics Readers, ORANGE READERS  (pack of 21).webp', 4),
(54, 'Jolly Phonics Reading Assessment', 'Jolly Learning', 7250.00, '₹7250', 'images/Jolly Phonics Reading Assessment.webp', 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `order_date` datetime NOT NULL,
  `status` varchar(50) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `shipping_address`, `payment_method`, `order_date`, `status`) VALUES
(1, 6, 445.00, 'C/326 Suryadarshan Building G D Ambekar Marg, Mumbai, Maharashtra - 400012', 'cod', '2025-04-20 00:49:23', 'pending'),
(2, 6, 2350.00, 'C/326 Suryadarshan Building G D Ambekar Marg, Mumbai, Maharashtra - 400012', 'upi', '2025-04-20 00:51:36', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 2, 1, 295.00),
(2, 2, 3, 1, 2200.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `product_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `brand`, `price`, `rating`, `image_path`, `product_url`, `created_at`) VALUES
(24, 'Grammar 1 Pupil Book', 'Jolly Learning', 295.00, 3, 'images/Grammar 1 Pupil Book.webp', 'sproduct.php?name=Grammar%201%20Pupil%20Book&price=295&img=images/Grammar%201%20Pupil%20Book.webp', '2025-04-18 12:54:40'),
(25, 'Grammar 1 Workbooks Set of 1-6', 'Jolly Learning', 2200.00, 4, 'images/Grammar 1 Workbooks set of 1-6.webp', 'sproduct.php?name=Grammar%201%20Workbooks%20set%20of%201-6&price=2200&img=images/Grammar%201%20Workbooks%20set%20of%201-6.webp', '2025-04-18 12:54:54'),
(26, 'Jolly Jingles book and CD', 'Jolly Learning', 3300.00, 4, 'images/Jolly Jingles book and CD.webp', 'sproduct.php?name=Jolly%20Jingles%20book%20and%20CD&price=3300&img=images/Jolly%20Jingles%20book%20and%20CD.webp', '2025-04-18 12:54:54'),
(27, 'Jolly Music Big Book level 1', 'Jolly Learning', 2900.00, 4, 'images/Jolly Music Big Book level 1.webp', 'sproduct.php?name=Jolly%20Music%20Big%20Book%20Level%201&price=2900&img=images/Jolly%20Music%20Big%20Book%20Level%201.webp', '2025-04-18 12:54:54'),
(28, 'Jolly Music Big Book level 3', 'Jolly Learning', 2900.00, 4, 'images/Jolly Music Big Book Level 3.webp', 'sproduct.php?name=Jolly%20Music%20Big%20Book%20Level%203&price=2900&img=images/Jolly%20Music%20Big%20Book%20Level%203.webp', '2025-04-18 12:54:54'),
(29, 'Jolly Phonics Readers, Complete Set Blue Level (pack of 18)', 'Jolly Learning', 2900.00, 4, 'images/Jolly Phonics Readers, Complete Set Blue Level  (pack of 18).webp', 'sproduct.php?name=Jolly%20Phonics%20Readers,%20Complete%20Set%20Blue%20Level%20%20(pack%20of%2018)&price=2900&img=images/Jolly%20Phonics%20Readers,%20Complete%20Set%20Blue%20Level%20%20(pack%20of%2018).webp', '2025-04-18 12:54:54'),
(30, 'Jolly Phonics Folktales Readers - Blue Level Books', 'Jolly Learning', 1295.00, 4, 'images/Jolly Phonics Folktales Readers - Blue Level Books.webp', 'sproduct.php?name=Jolly%20Phonics%20Folktales%20Readers%20-%20Blue%20Level%20Books&price=1295&img=images/Jolly%20Phonics%20Folktales%20Readers%20-%20Blue%20Level%20Books.webp', '2025-04-18 12:55:09'),
(31, 'Jolly Phonics Folktales Readers - Green Level Books', 'Jolly Learning', 1295.00, 4, 'images/Jolly Phonics Folktales Readers - Green Level Books.webp', 'sproduct.php?name=Jolly%20Phonics%20Folktales%20Readers%20-%20Green%20Level%20Books&price=1295&img=images/Jolly%20Phonics%20Folktales%20Readers%20-%20Green%20Level%20Books.webp', '2025-04-18 12:55:09'),
(32, 'Jolly Phonics Folktales Readers - Purple Level Books', 'Jolly Learning', 1295.00, 4, 'images/Jolly Phonics Folktales Readers - Purple Level Books.webp', 'sproduct.php?name=Jolly%20Phonics%20Folktales%20Readers%20-%20Purple%20Level%20Books&price=1295&img=images/Jolly%20Phonics%20Folktales%20Readers%20-%20Purple%20Level%20Books.webp', '2025-04-18 12:55:09'),
(33, 'Jolly Phonics Folktales Readers - Red Level Books', 'Jolly Learning', 1295.00, 4, 'images/Jolly Phonics Folktales Readers - Red Level Books.webp', 'sproduct.php?name=Jolly%20Phonics%20Folktales%20Readers%20-%20Red%20Level%20Books&price=1295&img=images/Jolly%20Phonics%20Folktales%20Readers%20-%20Red%20Level%20Books.webp', '2025-04-18 12:55:09'),
(34, 'Jolly Phonics Folktales Readers - Yellow Level Books', 'Jolly Learning', 1095.00, 4, 'images/Jolly Phonics Folktales Readers - Yellow Level Books.webp', 'sproduct.php?name=Jolly%20Phonics%20Folktales%20Readers%20-%20Yellow%20Level%20Books&price=1095&img=images/Jolly%20Phonics%20Folktales%20Readers%20-%20Yellow%20Level%20Books.webp', '2025-04-18 12:55:09'),
(35, 'Jolly Phonics Letter Sound Strips (pack of 30 strips)', 'Jolly Learning', 1450.00, 4, 'images/Jolly Phonics Letter Sound Strips (pack of 30 strips).webp', 'sproduct.php?name=Jolly%20Phonics%20Letter%20Sound%20Strips%20(pack%20of%2030%20strips)&price=1450&img=images/Jolly%20Phonics%20Letter%20Sound%20Strips%20(pack%20of%2030%20strips).webp', '2025-04-18 12:55:09');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_history`
--

CREATE TABLE `purchase_history` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `order_id` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `phone`, `email`, `password`, `role`, `name`) VALUES
(1, '+91 9137331549', 'shravsbusiness@gmail.com', '$2y$10$ksmse6AhUJVSwnFWx491Nu0Wa3YxpXPcsKX8G5UQM8lVPvzA0BiTy', 'user', 'Shravani'),
(3, '', 'pawarshravani78@gmail.com', '$2y$10$dmg1AnrdrcKcgMhasvBDROvBklNGOmQBlmmHyiS9DlglLEZ5n48de', 'admin', NULL),
(4, '8108380482', 'sushantmalave9@gmail.com', '$2y$10$R2FQDpvjC5unS/QgVdDKUO5J.77taWT77RAuwSeNWJ9lc2SvfpDAW', 'user', NULL),
(5, '+91 9137331549', 'yash@gmail.com', '$2y$10$MQySeoYEos62e.VqpDaa1OOjp7K/3hezOuM5E/PQGjVpibVwCgzFC', 'user', NULL),
(6, '+91 9137331549', 's2@gmail.com', '$2y$10$LYNY9cYkiXt3Hy/nXlZ1K.Aonb4EPK53tLRQ605CwGJX61TuS851i', 'user', 's2');

-- --------------------------------------------------------

--
-- Table structure for table `user_blogs`
--

CREATE TABLE `user_blogs` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `rating` int(1) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_blogs`
--

INSERT INTO `user_blogs` (`id`, `name`, `email`, `content`, `rating`, `created_at`) VALUES
(1, 'sushant malave', 'sushantmalave9@gmail.com', 'it is nice', 5, '2025-04-19 19:02:56'),
(8, 'Shravani Pawar', 'shravsbusiness@gmail.com', 'shit', 3, '2025-04-19 19:28:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_blogs`
--
ALTER TABLE `user_blogs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_blogs`
--
ALTER TABLE `user_blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD CONSTRAINT `purchase_history_ibfk_1` FOREIGN KEY (`user_email`) REFERENCES `users` (`email`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
