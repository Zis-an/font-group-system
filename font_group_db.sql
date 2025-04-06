-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2025 at 11:26 AM
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
-- Database: `font_group_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `fonts`
--

CREATE TABLE `fonts` (
  `id` int(11) NOT NULL,
  `font_name` varchar(255) NOT NULL,
  `font_file` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fonts`
--

INSERT INTO `fonts` (`id`, `font_name`, `font_file`, `created_at`) VALUES
(12, 'HappySwirly-KVB7l.ttf', '67f0f6bfea04f.ttf', '2025-04-05 09:24:15'),
(13, 'InflateptxBase-ax3da.ttf', '67f0fe3883c72.ttf', '2025-04-05 09:56:08'),
(14, 'InflateptxRegular-Wyg8V.ttf', '67f0ffc4bb497.ttf', '2025-04-05 10:02:44'),
(15, 'BrownieStencil-8O8MJ.ttf', '67f0ffe11a579.ttf', '2025-04-05 10:03:13'),
(16, 'PlayfulTime-BLBB8.ttf', '67f0ffe6512fe.ttf', '2025-04-05 10:03:18'),
(17, 'LoveDays-2v7Oe.ttf', '67f0ffeaf3fb5.ttf', '2025-04-05 10:03:23'),
(18, 'Monas-BLBW8.ttf', '67f0fff34bae7.ttf', '2025-04-05 10:03:31'),
(19, 'Helvetica.ttf', '67f0fffa2277d.ttf', '2025-04-05 10:03:38');

-- --------------------------------------------------------

--
-- Table structure for table `font_groups`
--

CREATE TABLE `font_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `font_groups`
--

INSERT INTO `font_groups` (`id`, `group_name`, `created_at`) VALUES
(7, 'Group One', '2025-04-05 10:04:23');

-- --------------------------------------------------------

--
-- Table structure for table `font_group_items`
--

CREATE TABLE `font_group_items` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `font_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `font_group_items`
--

INSERT INTO `font_group_items` (`id`, `group_id`, `font_id`) VALUES
(37, 7, 12),
(38, 7, 13);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fonts`
--
ALTER TABLE `fonts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `font_groups`
--
ALTER TABLE `font_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `font_group_items`
--
ALTER TABLE `font_group_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `font_id` (`font_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fonts`
--
ALTER TABLE `fonts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `font_groups`
--
ALTER TABLE `font_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `font_group_items`
--
ALTER TABLE `font_group_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `font_group_items`
--
ALTER TABLE `font_group_items`
  ADD CONSTRAINT `font_group_items_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `font_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `font_group_items_ibfk_2` FOREIGN KEY (`font_id`) REFERENCES `fonts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
