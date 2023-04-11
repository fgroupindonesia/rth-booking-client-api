-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2023 at 08:24 AM
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
-- Table structure for table `rth_family_users`
--

CREATE TABLE `rth_family_users` (
  `id` int(4) NOT NULL,
  `full_name` varchar(75) NOT NULL,
  `username_incharge` varchar(75) NOT NULL,
  `rel_connection` tinyint(1) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rth_family_users`
--

INSERT INTO `rth_family_users` (`id`, `full_name`, `username_incharge`, `rel_connection`, `created_date`) VALUES
(1, 'indah putri', 'gumuruh', 3, '2023-04-06 23:18:00'),
(2, 'syahmi muallij', 'gumuruh', 5, '2023-04-07 08:41:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rth_family_users`
--
ALTER TABLE `rth_family_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rth_family_users`
--
ALTER TABLE `rth_family_users`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
