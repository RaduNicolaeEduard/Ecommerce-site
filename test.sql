-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2019 at 09:09 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand`) VALUES
(1, 'Levi&#039;s'),
(2, 'Nike'),
(3, 'Adidas'),
(14, 'Polo'),
(16, 'Tommy Hilfiger'),
(17, 'Lacoste'),
(18, 'Puma'),
(19, 'Zara'),
(20, 'Chanel'),
(21, 'Louis Vitton'),
(22, 'GUESS'),
(23, 'Prada');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `items` text NOT NULL,
  `expire_date` datetime NOT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT 0,
  `shipped` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `items`, `expire_date`, `paid`, `shipped`) VALUES
(17, '[{\"id\":\"21\",\"size\":\"38\",\"quantity\":2}]', '2020-01-20 14:39:15', 1, 0),
(19, '[{\"id\":\"17\",\"size\":\"S\",\"quantity\":\"2\"}]', '2020-01-20 20:04:57', 1, 0),
(20, '[{\"id\":\"18\",\"size\":\"m\",\"quantity\":\"3\"}]', '2020-01-20 20:23:53', 1, 0),
(21, '[{\"id\":\"18\",\"size\":\"s\",\"quantity\":\"2\"}]', '2020-01-20 20:51:15', 1, 0),
(22, '[{\"id\":\"18\",\"size\":\"s\",\"quantity\":2}]', '2020-01-20 20:53:01', 1, 0),
(23, '[{\"id\":\"20\",\"size\":\"s\",\"quantity\":3}]', '2020-01-20 20:59:19', 1, 0),
(24, '[{\"id\":\"21\",\"size\":\"38\",\"quantity\":\"2\"}]', '2020-01-20 21:30:34', 1, 1),
(25, '[{\"id\":\"19\",\"size\":\"s\",\"quantity\":2}]', '2020-01-20 21:32:54', 1, 1),
(26, '[{\"id\":\"19\",\"size\":\"s\",\"quantity\":\"1\"}]', '2020-01-20 21:34:43', 1, 1),
(27, '[{\"id\":\"21\",\"size\":\"32\",\"quantity\":\"1\"},{\"id\":\"19\",\"size\":\"s\",\"quantity\":5},{\"id\":\"18\",\"size\":\"s\",\"quantity\":\"1\"}]', '2020-01-21 13:39:58', 1, 0),
(29, '[{\"id\":\"17\",\"size\":\"L\",\"quantity\":\"1\"}]', '2020-01-21 20:24:42', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `parent`) VALUES
(1, 'Men', 0),
(2, 'Women', 0),
(3, 'boys', 0),
(6, 'Pants M', 1),
(7, 'Shoes M', 1),
(9, 'Shirts W', 2),
(10, 'Pants W', 2),
(11, 'Shoes W', 2),
(13, 'Shirts b', 3),
(14, 'Pants b', 3),
(35, 'Dresses W', 2),
(37, 'Shoes b', 3),
(38, 'Girls', 0),
(41, 'Shirts M', 1),
(44, 'Accesories M', 1),
(45, 'Shirts g', 38),
(46, 'Pants g', 38),
(47, 'Shoes g', 38);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `list_price` decimal(10,2) NOT NULL,
  `brand` int(11) NOT NULL,
  `categories` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `featured` tinyint(4) NOT NULL DEFAULT 0,
  `sizes` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `list_price`, `brand`, `categories`, `image`, `description`, `featured`, `sizes`, `deleted`) VALUES
(17, 'NIKE Dri Fit training', '134.99', '219.99', 2, '41', '/tutorial/images/products/7d1be31d1133c54ee9ded22d305d21a7.jpg', 'Characteristics\r\nGender: men\r\nSport: fitness\r\nColor: black\r\nModel: logo\r\nNeckline: round \r\nTail: regular fit\r\nMaterial: synthetic fibers Material\r\ntechnology: Dri-fit, Nike Breathe\r\nSeason: Spring-Summer, Autumn-Winter\r\nDetails: mesh inserts\r\nMaterial details\r\nExterior : 76% polyester, 12% cotton, 12% viscose\r\n', 1, 'S:20,L:34,XL:11,XXL:56', 0),
(18, 'NIKE Dri fit fitness', '199.99', '189.99', 2, '41', '/tutorial/images/products/6bc9e7638813051f44f237941643ca39.jpg', 'Characteristics\r\nGender: men\r\nSport: fitness\r\nColor: khaki\r\nModel: uni\r\nCollar: round \r\nTailoring: regular fit\r\nMaterial: cotton, synthetic fibers\r\nMaterial technology: Dri-fit, Nike Breathe\r\nSeason: Spring-Summer, Autumn-Winter\r\nMaterial details\r\nExterior: 76% polyester, 12% cotton, 12% viscose', 1, 's:42,m:60,l:120,xl:12', 0),
(19, 'Levis Cotton t-shirt ', '89.99', '139.99', 1, '41', '/tutorial/images/products/2ba3133f9c37906be874215c8beec649.jpg', 'Characteristics\r\nColor: gray melange\r\nModel: text, logo\r\nStyle: casual\r\nWaist: regular fit\r\nNeckline: at the base of the neck\r\nSleeve type: short Outer\r\ncomposition\r\n: 100% cotton', 1, 's:2,m:,l:', 0),
(20, 'Levi&#039;s Cotton t-shirt ', '99.99', '149.99', 1, '41', '/tutorial/images/products/be5bbe0a97bd53a8058330ee1d8cf3e1.jpg', 'Features\r\nColor: Bordeaux red, dark red\r\nModel: uni\r\nMaterial: cotton\r\nStyle: casual\r\nWaist: regular fit\r\nNeckline: at the base of the neck\r\nSleeve type: short\r\nPocket: chest\r\nLine: Supima&reg; - World&#039;s finest cottons Outer\r\ncomposition\r\n: 100% cotton', 1, 's:12', 0),
(21, 'Adidas Originals', '339.99', '729.99', 3, '7', '/tutorial/images/products/540cfc98d0b9aa6348a12f7b759685bb.jpg', 'Caracteristici\r\nCuloare: bleumarin\r\nStil: casual \r\nMaterial: textil, piele veritabila\r\nVarf: rotund\r\nTip talpa: plata\r\nDetalii: constructie tip soseta in partea superioara, aplicatie logo\r\nInchidere: sireturi \r\nCompozitie\r\nExterior: piele, material textil\r\nInterior: material textil\r\nTalpa: alte materiale', 1, '32:30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(175) NOT NULL,
  `street` varchar(255) NOT NULL,
  `street2` varchar(255) NOT NULL,
  `city` varchar(175) NOT NULL,
  `county` varchar(175) NOT NULL,
  `zip_code` varchar(50) NOT NULL,
  `country` varchar(175) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `grand_total` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `txn_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `cart_id`, `full_name`, `email`, `street`, `street2`, `city`, `county`, `zip_code`, `country`, `sub_total`, `tax`, `grand_total`, `description`, `txn_date`) VALUES
(42, 22, 'Radu Nicolae', 'nicolae.radu99@gmail.com', 'Ale Nicolae Tatic nr7', '', 'Pitesti', 'Arges', '110404', 'Romania', '399.98', '48.00', '447.98', '2 items From Fashion Factory', '2019-12-21 21:53:52'),
(46, 24, 'Radu Nicolae', 'nicolae.radu99@gmail.com', 'Ale Nicolae Tatic nr7', '', 'Pitesti', 'Arges', '110404', 'Romania', '679.98', '81.60', '761.58', '2 items From Fashion Factory', '2019-12-21 22:30:53'),
(47, 24, 'Radu Nicolae', 'nicolae.radu99@gmail.com', 'Ale Nicolae Tatic nr7', '', 'Pitesti', 'Arges', '110404', 'Romania', '679.98', '81.60', '761.58', '2 items From Fashion Factory', '2019-12-21 22:31:17'),
(48, 24, 'Radu Nicolae', 'nicolae.radu99@gmail.com', 'Ale Nicolae Tatic nr7', '', 'Pitesti', 'Arges', '110404', 'Romania', '679.98', '81.60', '761.58', '2 items From Fashion Factory', '2019-12-21 22:31:50'),
(49, 25, 'a', 'a@g.c', 'a', 'a', 'a', 'a', 'a', 'a', '179.98', '21.60', '201.58', '2 items From Fashion Factory', '2019-12-21 22:33:07'),
(50, 25, 'a', 'a@g.c', 'a', 'a', 'a', 'a', 'a', 'a', '179.98', '21.60', '201.58', '2 items From Fashion Factory', '2019-12-21 22:34:26'),
(51, 26, 'a', 'a@g.c', 'a', 'a', 'a', 'a', 'a', 'a', '89.99', '10.80', '100.79', '1 item From Fashion Factory', '2019-12-21 22:34:55'),
(52, 27, 'EDU', 'a@g.c', 'Ale Nicolae Tatic nr7', 'sa', 'saaaa', 'AFTER', '+4651', 'Romania', '989.93', '118.79', '1108.72', '7 items From Fashion Factory', '2019-12-22 14:40:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(175) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `join_date` datetime NOT NULL DEFAULT current_timestamp(),
  `last_login` datetime NOT NULL,
  `permissions` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `join_date`, `last_login`, `permissions`) VALUES
(1, 'Nicolae Eduard', 'nicolae.radu99@gmail.com', '$2y$10$cAFbqMuied2EpB1c4R1wpOnjlehfH.WRQtEHwNNJRsGFNexhdQqt6', '2019-12-18 13:46:36', '2019-12-22 13:25:24', 'admin,editor'),
(4, 'Radu Eduard Nicolae', 'nicolaeeduard99@gmail.com', '$2y$10$zNqUUv4oGmY11lDq3aMS6uX/QkU2j8g4/hzkZ7dzlUrtbEjKxxkgy', '2019-12-20 17:23:01', '2019-12-21 14:40:56', 'editor'),
(5, 'test tester', 'test@test.test', '$2y$10$QggMqGoEzkMnY6Elz8W3F.yGABA3uJbu5QXLC/bUvsgiz14a4f8He', '2019-12-22 22:01:30', '0000-00-00 00:00:00', 'admin,editor'),
(7, 'a', 'a@g.c', '$2y$10$jMyU68FkDO0.8zVWtyTvPOIbJej460xJiwO10V06CUFQePkv5RGT6', '2019-12-22 22:07:45', '0000-00-00 00:00:00', 'editor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
