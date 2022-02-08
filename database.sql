-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Feb 08, 2022 at 09:43 AM
-- Server version: 8.0.26
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inftest`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_agents`
--

CREATE TABLE `user_agents` (
  `id` int NOT NULL,
  `useragent` text COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(32) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_agents`
--

INSERT INTO `user_agents` (`id`, `useragent`, `hash`) VALUES
(6, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.36', '5cbb497b34a75dbc3ec764cf8f9f8b49');

-- --------------------------------------------------------

--
-- Table structure for table `user_tracks`
--

CREATE TABLE `user_tracks` (
  `id` int NOT NULL,
  `ip_address` int UNSIGNED NOT NULL,
  `user_agent` int NOT NULL,
  `view_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `page_url` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `views_count` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_tracks`
--

INSERT INTO `user_tracks` (`id`, `ip_address`, `user_agent`, `view_date`, `page_url`, `views_count`) VALUES
(6, 2886860801, 6, '2022-02-08 09:36:44', '/index2.html', 4),
(7, 2886860801, 6, '2022-02-08 09:36:47', '/index1.html', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_agents`
--
ALTER TABLE `user_agents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_tracks`
--
ALTER TABLE `user_tracks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_agent_id` (`user_agent`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_agents`
--
ALTER TABLE `user_agents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_tracks`
--
ALTER TABLE `user_tracks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_tracks`
--
ALTER TABLE `user_tracks`
  ADD CONSTRAINT `user_agent_id` FOREIGN KEY (`user_agent`) REFERENCES `user_agents` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
