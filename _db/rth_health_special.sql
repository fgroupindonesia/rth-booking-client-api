-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2023 at 08:25 AM
-- Server version: 5.5.39
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fgi_client_rth`
--

-- --------------------------------------------------------

--
-- Table structure for table `rth_health_special`
--

CREATE TABLE `rth_health_special` (
  `id` int(4) NOT NULL,
  `ritual` tinyint(1) NOT NULL,
  `tenaga` tinyint(1) NOT NULL,
  `mimpi` tinyint(1) NOT NULL,
  `kunjungan` tinyint(1) NOT NULL,
  `ghaib` tinyint(1) NOT NULL,
  `username` varchar(75) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rth_health_special`
--

INSERT INTO `rth_health_special` (`id`, `ritual`, `tenaga`, `mimpi`, `kunjungan`, `ghaib`, `username`, `created_date`) VALUES
(1, 1, 1, 1, 1, 1, 'udin', '2023-04-01 14:35:36'),
(2, 1, 1, 1, 1, 1, 'ninik', '2023-04-01 14:43:43'),
(4, 1, 1, 1, 1, 1, 'sandi', '2023-04-04 09:15:08'),
(6, 0, 0, 0, 0, 0, 'sahawe', '2023-04-06 12:53:22'),
(14, 0, 0, 0, 0, 0, 'saiful', '2023-04-06 15:58:05'),
(15, 0, 0, 0, 0, 0, 'indahputri', '2023-04-06 23:18:00'),
(16, 0, 0, 0, 0, 0, 'syahmimuallij', '2023-04-07 08:41:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rth_health_special`
--
ALTER TABLE `rth_health_special`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rth_health_special`
--
ALTER TABLE `rth_health_special`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
