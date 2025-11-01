-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2025 at 06:42 PM
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
-- Database: `device_stock`
--

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `serial_id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `color` varchar(50) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `serial_id`, `name`, `model`, `color`, `branch`, `city`, `created_at`) VALUES
(11, '57', 'wef', 'dwq', 'White', 'Kurunegala', 'Kurunegala', '2025-10-09 09:32:38'),
(15, '80', 'wef', 'dwq', 'White', 'Kurunegala', 'Kurunegala', '2025-10-09 09:33:12'),
(16, '81', 'wef', 'dwq', 'White', 'Kurunegala', 'Kurunegala', '2025-10-09 09:33:39'),
(17, '60', 'wef', 'dwq', 'White', 'Kurunegala', 'Kurunegala', '2025-10-09 09:35:13'),
(18, '45', 'Harsha Bandara', 'dwq', 'White', 'Colombo', 'Colombo', '2025-10-09 09:36:38'),
(20, '01', 'aa', 'dwq', 'White', 'Colombo', 'Kurunegala', '2025-10-09 09:39:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `address`) VALUES
(1, 'sanjula', 'sanjula', '$2y$10$pzXu7CY.sqshAsuFcGQg/OmBDFU9okEqYTAF52vUxqWu5W8jBbv5G', 'minneriya'),
(2, 'niki', 'nikiasd', '$2y$10$wYcQoLi35u9IifejmBCU8.c11V/lpBLYzrrJ9wbUITdox3QqTFBe6', 'ddqwwd'),
(3, 'harsha', 'harsha123', '$2y$10$dXT7dxeuLICRPBBlrkCRzex19bjpuRzKSBSy8hym/OZnEkkyQM7Lq', 'swqwdqwd'),
(4, 'harsha', 'harshab', '$2y$10$LI0YCvkSBJE0x4v8lUqMUuZS1dPBK6rPWB0O1O9kipLZtL6fIK11m', 'wqdqw');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_id` (`serial_id`);

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
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
