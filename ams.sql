-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 01:24 PM
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
-- Database: `ams`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `pass`, `fullname`) VALUES
(1, 'Admin', '142b1770f7426daaf0a03c03afbc3fe6c023de163a31b5d87517cf78d16dffdb', 'Jelina Pentecoste');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `rfid_card` varchar(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `department` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `rfid_card`, `firstname`, `middlename`, `lastname`, `age`, `department`) VALUES
(6, '0008275467', 'Mark', 'Ang', 'Castillo', 26, 'Admin Section'),
(7, '0008873267', 'Jorly', 'NA', 'Biscarra', 22, 'Client Support Section'),
(8, '0008083945', 'Jelina', 'NA', 'Pentecoste', 22, 'Compliance Section'),
(9, '0007737251', 'Jane', 'Sample', 'Doe', 31, 'Collection Section'),
(10, '00083791190', 'Christian', 'Sadian', 'Verona', 26, 'Collection Section'),
(11, '0008395911', 'Carlos', 'Malbas', 'Merino', 28, 'Client Support Section'),
(12, '0008248519', 'Niel Florenz', 'Bayson', 'Almariego', 22, 'Compliance Section'),
(13, '0007765093', 'John Bnedict', 'Insorio', 'Pentecoste', 28, 'Collection Section'),
(14, '0008293749', 'Sonny', 'Patricio', 'Marfil', 30, 'Client Support Section'),
(15, '0008410115', 'John Patrick', 'Banconcillo', 'Malijan', 27, 'Compliance Section');

-- --------------------------------------------------------

--
-- Table structure for table `timein`
--

CREATE TABLE `timein` (
  `id` int(11) NOT NULL,
  `rfid_card` varchar(11) NOT NULL,
  `date` date NOT NULL,
  `time_in` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timein`
--

INSERT INTO `timein` (`id`, `rfid_card`, `date`, `time_in`) VALUES
(28, '0007737251', '2024-05-15', '07:46:17'),
(29, '0008083945', '2024-05-15', '07:58:02'),
(30, '0008873267', '2024-05-15', '07:55:25'),
(31, '0008275467', '2024-05-15', '07:58:59'),
(32, '0007737251', '2024-05-16', '07:58:28'),
(33, '0008083945', '2024-05-16', '07:57:20'),
(34, '0008873267', '2024-05-16', '07:48:03'),
(35, '0008275467', '2024-05-16', '07:59:00'),
(36, '0007737251', '2024-05-17', '08:00:00'),
(37, '0008873267', '2024-05-17', '07:51:07'),
(38, '0008083945', '2024-05-22', '07:57:17'),
(39, '0008873267', '2024-05-22', '07:57:20'),
(41, '0008410115', '2024-05-23', '07:15:54');

-- --------------------------------------------------------

--
-- Table structure for table `timeout`
--

CREATE TABLE `timeout` (
  `id` int(11) NOT NULL,
  `rfid_card` varchar(11) NOT NULL,
  `date` date NOT NULL,
  `time_out` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timeout`
--

INSERT INTO `timeout` (`id`, `rfid_card`, `date`, `time_out`) VALUES
(20, '0007737251', '2024-05-15', '17:05:40'),
(21, '0008083945', '2024-05-15', '17:01:23'),
(22, '0008873267', '2024-05-15', '17:03:26'),
(23, '0008275467', '2024-05-15', '17:00:59'),
(24, '0007737251', '2024-05-16', '17:01:40'),
(25, '0008083945', '2024-05-16', '17:04:48'),
(26, '0008873267', '2024-05-16', '17:01:38'),
(27, '0008275467', '2024-05-16', '17:03:59'),
(28, '0007737251', '2024-05-17', '17:09:08'),
(29, '0008873267', '2024-05-17', '17:08:25'),
(30, '0008083945', '2024-05-22', '17:02:40'),
(31, '0008873267', '2024-05-22', '17:02:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timein`
--
ALTER TABLE `timein`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timeout`
--
ALTER TABLE `timeout`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `timein`
--
ALTER TABLE `timein`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `timeout`
--
ALTER TABLE `timeout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
