-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2018 at 03:12 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accounts`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

DROP DATABASE IF EXISTS YKdatabase ;
CREATE DATABASE YKdatabase;
USE YKdatabase;

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `logcounter` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `email`, `username`, `password`, `logcounter`) VALUES
(1, 'Maciej Sudol', 'sudolm9', 'sudolm9', 'sudol', '4'),
(2, 'David Sapida', 'sapidad1', 'sapida1', 'sapida', '4'),
(3, 'Yong Bum Kim', 'kimy24', 'kimy24', 'kim', '4'),
(4, 'Alex Kim', 'ybkim0902', 'ybkim0902', '1234qwer', '4');

-- --------------------------------------------------------
CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `admin` (`id`, `name`, `email`, `username`, `password`) VALUES
(1, 'Maciej Sudol', 'sudolm9', 'maciej', 'sudol'),
(2, 'David Sapida', 'sapidad1', 'david', 'sapida'),
(3, 'Alex Kim', 'ybkim0902', 'yong', 'kim');
--
-- Table structure for table `balance`
--

CREATE TABLE `balance` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `savings` float NOT NULL,
  `checking` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--
INSERT INTO `balance` (`id`, `name`, `savings`, `checking`) VALUES
(1, 'Maciej Sudol', 100, 25),
(2, 'David Sapida', 100000, 100),
(3, 'Yong Bum Kim', 100, 25),
(4, 'Alex Kim', 100, 25);
COMMIT;

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
flush privileges;
CREATE USER
'yongbum'@localhost
IDENTIFIED BY 'kim';

GRANT ALL
ON YKdatabase.*
TO 'yongbum'@localhost
IDENTIFIED BY 'kim';
