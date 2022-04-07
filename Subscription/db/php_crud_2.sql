-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2021 at 03:09 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpcrud2`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created`, `modified`) VALUES
(1, 'Sports', 'Products you use for sports.', '2015-08-02 23:56:46', '2015-08-03 05:59:36'),
(2, 'Personal', 'Products for you personal needs.', '2015-08-02 23:56:46', '2015-08-03 05:59:36');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `image` varchar(512) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `category_id`, `created`, `modified`) VALUES
(1, 'Basketball', 'A ball used in the NBA.', 49.99, '', 1, '2015-08-02 12:04:03', '2015-08-02 15:57:13'),
(3, 'Gatorade', 'This is a very good drink for athletes.', 1.99, '', 1, '2015-08-02 12:14:29', '2015-08-02 15:57:13'),
(4, 'Eye Glasses', 'It will make you read better.', 6, '', 1, '2015-08-02 12:15:04', '2015-08-02 15:57:13'),
(5, 'Trash Can', 'It will help you maintain cleanliness.', 3.95, '', 1, '2015-08-02 12:16:08', '2015-08-02 15:57:13'),
(6, 'Mouse', 'Very useful if you love your computer.', 11.35, '', 2, '2015-08-02 12:17:58', '2015-08-02 15:57:38'),
(7, 'Earphone', 'You need this one if you love music.', 9, '', 2, '2015-08-02 12:18:21', '2015-08-03 06:40:41'),
(8, 'Pillow', 'Sleeping well is important.', 8.99, 'a693a22feb3dc1e7a97e7b47a3b2d9aea1492dad-pillow-1738023_640.jpg', 2, '2015-08-02 12:18:56', '2017-01-15 03:11:54'),
(13, 'Cellphone Stand', 'Very useful if you are a developer.', 5.55, '', 2, '2015-08-03 08:00:16', '2015-08-03 06:00:42');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
