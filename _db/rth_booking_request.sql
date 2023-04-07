-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2023 at 06:06 AM
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
-- Table structure for table `rth_booking_request`
--

CREATE TABLE `rth_booking_request` (
  `id` int(11) NOT NULL,
  `code` varchar(75) NOT NULL,
  `treatment` varchar(200) NOT NULL,
  `schedule_date` datetime NOT NULL,
  `username` varchar(75) NOT NULL,
  `status` varchar(75) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rth_booking_request`
--

INSERT INTO `rth_booking_request` (`id`, `code`, `treatment`, `schedule_date`, `username`, `status`, `created_date`, `modified_date`) VALUES
(13, '6VlJ-7ZA', '{\\\"tindakan_umum\\\":\\\"0\\\",\\\"bekam\\\":\\\"0\\\",\\\"ruqyah\\\":\\\"0\\\",\\\"elektrik\\\":\\\"0\\\",\\\"fashdu\\\":\\\"1\\\",\\\"lintah\\\":\\\"0\\\",\\\"pijat\\\":\\\"1\\\"}', '2023-04-12 13:00:00', 'gumuruh', 'completed', '2023-04-03 08:18:53', '2023-04-03 01:18:54'),
(14, 'btWd-JRJ', '{\\\"tindakan_umum\\\":\\\"0\\\",\\\"bekam\\\":\\\"0\\\",\\\"ruqyah\\\":\\\"0\\\",\\\"elektrik\\\":\\\"1\\\",\\\"fashdu\\\":\\\"1\\\",\\\"lintah\\\":\\\"1\\\",\\\"pijat\\\":\\\"0\\\"}', '2023-04-07 20:00:00', 'gumuruh', 'cancelled', '2023-04-03 11:01:39', '2023-04-03 04:01:39'),
(15, 'pOjX-BSH', '{\\\"tindakan_umum\\\":\\\"0\\\",\\\"bekam\\\":\\\"0\\\",\\\"ruqyah\\\":\\\"0\\\",\\\"elektrik\\\":\\\"1\\\",\\\"fashdu\\\":\\\"0\\\",\\\"lintah\\\":\\\"1\\\",\\\"pijat\\\":\\\"0\\\"}', '2023-04-07 08:00:00', 'gumuruh', 'cancelled', '2023-04-03 11:34:26', '2023-04-03 04:34:26'),
(16, 'l7I9-dBW', '{\\\"tindakan_umum\\\":\\\"0\\\",\\\"bekam\\\":\\\"0\\\",\\\"ruqyah\\\":\\\"0\\\",\\\"elektrik\\\":\\\"0\\\",\\\"fashdu\\\":\\\"1\\\",\\\"lintah\\\":\\\"1\\\",\\\"pijat\\\":\\\"0\\\"}', '2023-04-04 13:00:00', 'gumuruh', 'cancelled', '2023-04-03 11:37:05', '2023-04-03 04:37:05'),
(17, 'aE4w-B8e', '{\\\"tindakan_umum\\\":\\\"0\\\",\\\"bekam\\\":\\\"0\\\",\\\"ruqyah\\\":\\\"0\\\",\\\"elektrik\\\":\\\"1\\\",\\\"fashdu\\\":\\\"0\\\",\\\"lintah\\\":\\\"1\\\",\\\"pijat\\\":\\\"0\\\"}', '2023-04-04 08:00:00', 'gumuruh', 'cancelled', '2023-04-03 11:40:35', '2023-04-03 04:40:35'),
(18, 'MoNe-l1T', '{\\\"tindakan_umum\\\":\\\"0\\\",\\\"bekam\\\":\\\"0\\\",\\\"ruqyah\\\":\\\"0\\\",\\\"elektrik\\\":\\\"0\\\",\\\"fashdu\\\":\\\"1\\\",\\\"lintah\\\":\\\"1\\\",\\\"pijat\\\":\\\"0\\\"}', '2023-04-04 10:00:00', 'gumuruh', 'cancelled', '2023-04-03 11:44:06', '2023-04-03 04:44:06'),
(19, 'jibo-1FW', '{\\\"tindakan_umum\\\":\\\"0\\\",\\\"bekam\\\":\\\"1\\\",\\\"ruqyah\\\":\\\"0\\\",\\\"elektrik\\\":\\\"1\\\",\\\"fashdu\\\":\\\"0\\\",\\\"lintah\\\":\\\"0\\\",\\\"pijat\\\":\\\"0\\\"}', '2023-04-06 10:00:00', 'gumuruh', 'pending', '2023-04-03 11:57:55', '2023-04-03 04:57:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rth_booking_request`
--
ALTER TABLE `rth_booking_request`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rth_booking_request`
--
ALTER TABLE `rth_booking_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
