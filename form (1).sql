-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2017 at 05:09 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `form`
--
CREATE DATABASE IF NOT EXISTS `form` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `form`;

-- --------------------------------------------------------

--
-- Table structure for table `categories_table`
--

CREATE TABLE `categories_table` (
  `id` int(11) NOT NULL,
  `category` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories_table`
--

INSERT INTO `categories_table` (`id`, `category`) VALUES
(3, 'Finance'),
(6, 'Human Resources'),
(1, 'IT / Software Engineering'),
(2, 'Managment'),
(4, 'Research & Development'),
(5, 'Technician');

-- --------------------------------------------------------

--
-- Table structure for table `entries_table`
--

CREATE TABLE `entries_table` (
  `id` int(11) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `address` varchar(32) NOT NULL,
  `category` varchar(32) NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `entries_table`
--

INSERT INTO `entries_table` (`id`, `first_name`, `last_name`, `email`, `address`, `category`, `date_time`) VALUES
(1, 'Mohamed', 'Ahmed', 'ms.yazeed@gmail.com', 'weidener str. 35', 'IT / Software Engineering', '2017-07-30 15:08:22'),
(2, 'Sayed', 'Fawzy', 'msa_yazeed@yahoo.com', 'Sama tower 33', 'Managment', '2017-07-30 15:08:59'),
(3, 'Medhat', 'Samy', 'Mann100@yahoo.com', 'Haram Str. 33', 'Finance', '2017-07-30 15:09:54'),
(4, 'Zaky', 'Ahmed', 'Toot100@gmail.com', 'Maxx Str. 88', 'Research &amp; Development', '2017-07-30 15:10:46'),
(5, 'Samy', 'Gamal', 'Sam100@gmail.com', 'Faisel Str. 66', 'Technician', '2017-07-30 15:11:25'),
(6, 'Osama', 'Hosny', 'Osos100@yahoo.com', 'Faisel Str.  44', 'Human Resources', '2017-07-30 15:12:13'),
(7, 'Mohamed', 'Zad', 'msa_y@yahoo.com', 'weidener str. 35', 'Technician', '2017-07-30 15:13:11'),
(8, 'Max', 'Heinz', 'MaxHax@gmail.com', 'Sonnen Str. 34', 'IT / Software Engineering', '2017-07-30 15:22:07'),
(9, 'Chloe', 'Hmam', 'ChloeHam@gmail.com', 'Frann Str. 87', 'Finance', '2017-07-30 15:24:35'),
(10, 'Fransizka', 'Heinz', 'FranziskaHeinz@yahoo.com', 'weidener str. 30', 'Human Resources', '2017-07-30 15:25:38'),
(11, 'Sofia', 'Hamza', 'Sofiaa@gmail.com', 'Karls Str, 89', 'Research &amp; Development', '2017-07-30 15:26:25'),
(12, 'Hala', 'Fawzy', 'Halol@yahoo.com', 'Trank Str. 46', 'IT / Software Engineering', '2017-07-30 15:26:57'),
(13, 'Melissa', 'Tom', 'MelTom@gmail.com', 'Dransok Str. 22', 'Managment', '2017-07-30 15:27:38'),
(14, 'Thomas', 'Ahmed', 'TomTom@yahoo.com', 'Ton Str. 34', 'IT / Software Engineering', '2017-07-30 15:28:05'),
(15, 'Zaak', 'Don', 'Don@gmail.com', 'Rama Str. 22', 'IT / Software Engineering', '2017-07-30 15:29:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories_table`
--
ALTER TABLE `categories_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category` (`category`);

--
-- Indexes for table `entries_table`
--
ALTER TABLE `entries_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories_table`
--
ALTER TABLE `categories_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `entries_table`
--
ALTER TABLE `entries_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
