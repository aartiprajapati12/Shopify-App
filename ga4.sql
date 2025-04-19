-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 29, 2024 at 06:05 PM
-- Server version: 8.0.40-0ubuntu0.22.04.1
-- PHP Version: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ga4`
--

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` int NOT NULL,
  `shop_url` varchar(255) NOT NULL,
  `status` int DEFAULT NULL,
  `access_token` varchar(255) NOT NULL,
  `hmac` varchar(255) NOT NULL,
  `install_date` datetime NOT NULL,
  `charge_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `shop_url`, `status`, `access_token`, `hmac`, `install_date`, `charge_id`) VALUES
(76, 'demostorevdc.myshopify.com', 1, 'shpua_b8fdb05ed750e775b6e501d4ed1dc1e4', '276f9d602812b57ff1ff389ef016917da40a79f7dfa82db6938a4684c9f9631f', '2024-09-26 13:02:15', '33365491996'),
(77, 'snapstylebazaar.myshopify.com', 1, 'shpua_20be7be58d6106244ed97f983361c907', 'd04f355c7a354900beb3f8c3d624b142eb018759e2db55eeb4361f6a62abd449', '2024-10-02 10:30:13', '29868032224');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shop_url` (`shop_url`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
