-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2022 at 06:45 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_sdf`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `salary` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `address`, `salary`) VALUES
(2, 'asdg', '123', 123);

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

CREATE TABLE `userdata` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `subscription` varchar(50) NOT NULL,
  `serviceprovider` varchar(50) NOT NULL,
  `amount` int(50) NOT NULL,
  `renewaldate` date NOT NULL,
  `paymentportal` varchar(50) NOT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`id`, `category`, `subscription`, `serviceprovider`, `amount`, `renewaldate`, `paymentportal`, `remarks`, `userid`) VALUES
(12, 'testtest', 'test6', 'test6', 124, '1999-02-03', '124', '124', 4),
(19, 'test', 'test', 'test', 125, '1999-01-24', 'test', 'test', 1),
(20, 'test', 'test', 'test', 12125125, '1999-02-03', 'test', 'tset', 1),
(21, 'test', 'test', 'test', 125125, '1999-01-24', 'test', 'test', 1),
(22, 'qwe', 'qwe', 'qwe', 123142124, '1999-02-04', '123', 'qwe', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `password`, `created_at`) VALUES
(1, 'test', '$2y$10$fqyWjBEuYKffVOJhb4Oa7O4BRVYtkTL44GHyIxdIaCHDKCyOUzbEu', '2022-12-10 14:36:30'),
(2, 'test1', '$2y$10$WUmJ7AQjBh7xjNSMG2C25ut1VY.IohXjh9QdnhOIzdAqWIQ.lobDS', '2022-12-10 23:08:26'),
(3, 'test2', '$2y$10$ANf2tqS3kCIoQdr0sHq3JOWDl1QbfJwh3I390iaB/739Fi3Nawn1.', '2022-12-10 23:29:04'),
(4, 'test6', '$2y$10$/rI8BupsNAyvMlQWTry/d.BIUJkGKArUVoNw3cctTyX5yo8V78XZO', '2022-12-11 01:28:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `userdata`
--
ALTER TABLE `userdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
