-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2024 at 01:54 AM
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
-- Database: `notes`
--

-- --------------------------------------------------------

--
-- Table structure for table `notetable`
--

CREATE TABLE `notetable` (
  `note_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `note_title` varchar(100) NOT NULL,
  `note_desc` longtext NOT NULL,
  `note_date` date NOT NULL,
  `note_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notetable`
--

INSERT INTO `notetable` (`note_id`, `user_id`, `note_title`, `note_desc`, `note_date`, `note_status`) VALUES
(50, 12, 'qweqwe', 'qweqweqw', '2024-04-27', 'Favorites'),
(51, 12, 'qweqwe', 'qweqweqw', '2024-04-27', 'Deleted'),
(52, 12, 'qweqe', 'qweqweqweq', '2024-04-27', 'Deleted'),
(53, 12, 'QWEQWE', 'QWEQWE', '2024-04-27', 'Deleted');

-- --------------------------------------------------------

--
-- Table structure for table `usertable`
--

CREATE TABLE `usertable` (
  `user_id` int(11) NOT NULL,
  `user_fname` varchar(20) NOT NULL,
  `user_lname` varchar(20) NOT NULL,
  `user_bdate` date NOT NULL,
  `user_age` int(11) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_username` varchar(20) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_image` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usertable`
--

INSERT INTO `usertable` (`user_id`, `user_fname`, `user_lname`, `user_bdate`, `user_age`, `user_email`, `user_username`, `user_password`, `user_image`) VALUES
(6, 'Ian', 'Taregaaa', '2008-02-13', 16, 'Sagerat@gmail.com', 'Iannix', '$2y$10$DpvmYy.cTzBm/x7Ug3bSse0y/DpFUOx3x3lFaWT4dxWamc9o.l0le', ''),
(7, 'Sagerat', 'Tarega', '2009-02-03', 15, 'Tarega@gmail.com', 'Sagerat', '$2y$10$iflSyq/hedGv9zeJU5od8.a6Aw76JDF9t7G.FBj8Sz1gR5CMqtkia', ''),
(8, 'Christian23', 'Tabelon32', '2003-03-12', 21, 'Tabelon@gmail.com32', 'Iansagerat', '$2y$10$MoG9fxK3xuOcjblGmRZ6CuXqu6gew8xOqvmIJkq7GEu8PT6EtmUa6', ''),
(9, 'Cyndie', 'Abella', '2003-05-27', 20, 'Cyndieabella@gmail.com', 'Cyndie', '$2y$10$DvCoqo1DB35PUFQxwaFiYulpcHQmtoiPOCTHr5hmT2WmmwoYxfjgu', ''),
(10, 'Cyndie', 'Abella', '2003-03-26', 21, 'cyndieabella@gmail.com', 'cyndie', '$2y$10$pZZdhNrme3DyMJhU4xSGZO77RlANGcAuiRY7r.L6OZzukmEGmstMm', ''),
(11, 'Cyndie', 'Tarega', '2003-05-27', 20, 'abellacyndie@gmail.com', 'Cyndie', '$2y$10$RSwGIpeJhTTfyv8tR9jy6e2nDLYEiMIqCgMX4CbJf5sOmDnTUveCe', ''),
(12, 'Cyndie', 'Tarega', '2001-03-31', 23, 'Iantarega@gmail.com', 'IanTarega', '$2y$10$GY00s06CJsPHuG5rnxN07udp5kT3zoz7/clD/eWx4f0DDZZ1ufWXu', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notetable`
--
ALTER TABLE `notetable`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `UserxNote` (`user_id`);

--
-- Indexes for table `usertable`
--
ALTER TABLE `usertable`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notetable`
--
ALTER TABLE `notetable`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `usertable`
--
ALTER TABLE `usertable`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notetable`
--
ALTER TABLE `notetable`
  ADD CONSTRAINT `UserxNote` FOREIGN KEY (`user_id`) REFERENCES `usertable` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
