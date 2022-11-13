-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 13, 2022 at 09:58 PM
-- Server version: 5.7.11
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tiketing`
--
CREATE DATABASE IF NOT EXISTS `db_tiketing` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `db_tiketing`;

-- --------------------------------------------------------

--
-- Table structure for table `t_accounts`
--

CREATE TABLE `t_accounts` (
  `idAccount` int(11) NOT NULL,
  `accUsername` varchar(50) NOT NULL,
  `accPassword` varchar(255) NOT NULL,
  `accAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_accounts`
--

INSERT INTO `t_accounts` (`idAccount`, `accUsername`, `accPassword`, `accAdmin`) VALUES
(1, 'admin', '$2y$10$7HKzpJkFzp56lgbuYZnyVu8rYNqopK4y1gA8FJlQZeD1j1a4XfXMm', 1),
(2, 'pl03jlu', '$2y$10$728vkYFjCeb2ZZVGfzNyYOOAhtS.rLCJNd/hE/tTF7qPioimtn0hy', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_accounts`
--
ALTER TABLE `t_accounts`
  ADD PRIMARY KEY (`idAccount`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_accounts`
--
ALTER TABLE `t_accounts`
  MODIFY `idAccount` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
