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
-- Table structure for table `rth_health_common`
--

CREATE TABLE `rth_health_common` (
  `id` int(11) NOT NULL,
  `keluhan` varchar(75) NOT NULL,
  `smoking` tinyint(1) NOT NULL,
  `rawat_inap` tinyint(1) NOT NULL,
  `obat_bius` tinyint(1) NOT NULL,
  `tbc` tinyint(1) NOT NULL,
  `kanker` tinyint(1) NOT NULL,
  `jantung` tinyint(1) NOT NULL,
  `stroke` tinyint(1) NOT NULL,
  `anjuran_dokter_terapis` tinyint(1) NOT NULL,
  `username` varchar(75) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rth_health_common`
--

INSERT INTO `rth_health_common` (`id`, `keluhan`, `smoking`, `rawat_inap`, `obat_bius`, `tbc`, `kanker`, `jantung`, `stroke`, `anjuran_dokter_terapis`, `username`, `created_date`) VALUES
(1, 'pengen aja', 1, 1, 1, 1, 1, 1, 1, 1, 'udin', '2023-04-01 14:35:36'),
(2, 'pengen dipijit', 1, 1, 1, 1, 1, 1, 1, 1, 'ninik', '2023-04-01 14:43:43'),
(4, 'ingin dibekam', 1, 1, 1, 1, 1, 1, 1, 1, 'sandi', '2023-04-04 09:15:08'),
(6, 'pengen aja', 1, 1, 1, 1, 1, 1, 1, 1, 'sahawe', '2023-04-06 12:53:22'),
(14, 'pengen dipijit', 0, 1, 1, 1, 1, 1, 1, 1, 'saiful', '2023-04-06 15:58:05'),
(15, 'pengen dipijit', 0, 1, 1, 1, 1, 1, 1, 1, 'indahputri', '2023-04-06 23:18:00'),
(16, 'pengen dipijit', 0, 1, 1, 1, 1, 1, 1, 1, 'syahmimuallij', '2023-04-07 08:41:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rth_health_common`
--
ALTER TABLE `rth_health_common`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rth_health_common`
--
ALTER TABLE `rth_health_common`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
