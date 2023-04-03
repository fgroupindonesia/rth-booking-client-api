-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2023 at 07:06 AM
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
(2, 'pengen dipijit', 1, 1, 1, 1, 1, 1, 1, 1, 'ninik', '2023-04-01 14:43:43');

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
(2, 1, 1, 1, 1, 1, 'ninik', '2023-04-01 14:43:43');

-- --------------------------------------------------------

--
-- Table structure for table `rth_ruqyah`
--

CREATE TABLE `rth_ruqyah` (
  `id` int(4) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `gender_therapist` tinyint(1) NOT NULL,
  `date_chosen` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rth_ruqyah`
--

INSERT INTO `rth_ruqyah` (`id`, `status`, `gender_therapist`, `date_chosen`) VALUES
(1, 0, 1, '2022-04-17'),
(2, 1, 0, '2022-04-18'),
(3, 0, 0, '2022-04-19'),
(4, 0, 0, '2022-04-20');

-- --------------------------------------------------------

--
-- Table structure for table `rth_schedules`
--

CREATE TABLE `rth_schedules` (
  `id` int(4) NOT NULL,
  `date_chosen` date NOT NULL,
  `specific_hour` varchar(5) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `gender_therapist` tinyint(1) NOT NULL,
  `description` varchar(200) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rth_schedules`
--

INSERT INTO `rth_schedules` (`id`, `date_chosen`, `specific_hour`, `status`, `gender_therapist`, `description`, `date_created`) VALUES
(2, '2022-02-08', '08:00', 0, 1, '', '2022-02-07 13:18:59'),
(3, '2022-02-08', '10:00', 0, 1, '', '2022-02-07 13:19:32'),
(4, '2022-02-08', '13:00', 0, 1, '', '2022-02-07 13:18:31'),
(5, '2022-02-08', '16:00', 0, 1, '', '2022-02-07 13:18:59'),
(6, '2022-02-08', '20:00', 0, 1, '', '2022-02-07 13:19:32'),
(7, '2022-02-10', '10:00', 1, 1, '', '2022-02-07 13:18:31'),
(8, '2022-02-10', '13:00', 1, 1, '', '2022-02-07 13:18:59'),
(9, '2022-02-10', '20:00', 1, 1, '', '2022-02-07 13:19:32'),
(10, '2022-02-10', '16:00', 1, 1, '', '2022-02-07 13:18:31'),
(11, '2022-02-10', '08:00', 1, 1, 'keterangan', '2022-02-07 13:18:59'),
(12, '2022-02-11', '08:00', 0, 1, '', '2022-02-27 04:16:58'),
(13, '2022-02-11', '10:00', 0, 1, '', '2022-02-27 04:16:58'),
(14, '2022-02-11', '13:00', 0, 1, '', '2022-02-27 04:16:58'),
(15, '2022-02-11', '16:00', 0, 1, '', '2022-02-27 04:16:58'),
(16, '2022-02-11', '20:00', 0, 1, '', '2022-02-27 04:16:58'),
(17, '2022-02-12', '08:00', 1, 1, '', '2022-02-27 04:30:58'),
(18, '2022-02-12', '10:00', 1, 1, '', '2022-02-27 04:30:58'),
(19, '2022-02-12', '13:00', 1, 1, '', '2022-02-27 04:30:58'),
(20, '2022-02-12', '16:00', 0, 1, '', '2022-02-27 04:30:58'),
(21, '2022-02-12', '20:00', 0, 1, '', '2022-02-27 04:30:59'),
(22, '2022-02-09', '08:00', 1, 1, '', '2022-02-27 04:49:00'),
(23, '2022-02-09', '10:00', 0, 1, '', '2022-02-27 04:49:00'),
(24, '2022-02-09', '13:00', 0, 1, '', '2022-02-27 04:49:00'),
(25, '2022-02-09', '16:00', 0, 1, '', '2022-02-27 04:49:00'),
(26, '2022-02-09', '20:00', 0, 1, '', '2022-02-27 04:49:00'),
(27, '2022-02-16', '08:00', 0, 1, '', '2022-02-27 04:53:35'),
(28, '2022-02-16', '10:00', 1, 1, '', '2022-02-27 04:53:36'),
(29, '2022-02-16', '13:00', 0, 1, '', '2022-02-27 04:53:36'),
(30, '2022-02-16', '16:00', 0, 1, '', '2022-02-27 04:53:36'),
(31, '2022-02-16', '20:00', 0, 1, '', '2022-02-27 04:53:36'),
(32, '2022-02-17', '08:00', 0, 1, '', '2022-02-27 04:56:13'),
(33, '2022-02-17', '10:00', 1, 1, 'jam ibu ibu tgl cantik 17', '2022-02-27 04:56:13'),
(34, '2022-02-17', '13:00', 1, 1, 'bapak bapak', '2022-02-27 04:56:13'),
(35, '2022-02-17', '16:00', 1, 1, 'internal fulll', '2022-02-27 04:56:13'),
(36, '2022-02-17', '20:00', 1, 1, 'rehaaat', '2022-02-27 04:56:13'),
(37, '2022-02-25', '08:00', 0, 1, '', '2022-02-27 05:02:39'),
(38, '2022-02-25', '10:00', 0, 1, '', '2022-02-27 05:02:39'),
(39, '2022-02-25', '13:00', 0, 1, '', '2022-02-27 05:02:39'),
(40, '2022-02-25', '16:00', 0, 1, '', '2022-02-27 05:02:40'),
(41, '2022-02-25', '20:00', 0, 1, '', '2022-02-27 05:02:40'),
(42, '2022-02-22', '08:00', 1, 1, 'siap kan', '2022-02-27 05:07:42'),
(43, '2022-02-22', '10:00', 1, 1, 'anak santri', '2022-02-27 05:07:42'),
(44, '2022-02-22', '13:00', 1, 1, 'bapa rt 01', '2022-02-27 05:07:42'),
(45, '2022-02-22', '16:00', 1, 1, 'ibu rt 02', '2022-02-27 05:07:42'),
(46, '2022-02-22', '20:00', 1, 1, 'campoeeer', '2022-02-27 05:07:43'),
(47, '2022-02-24', '08:00', 1, 1, 'testing satu', '2022-02-27 05:08:50'),
(48, '2022-02-24', '10:00', 1, 1, 'testing lagei', '2022-02-27 05:08:50'),
(49, '2022-02-24', '13:00', 0, 1, '', '2022-02-27 05:08:50'),
(50, '2022-02-24', '16:00', 0, 1, '', '2022-02-27 05:08:50'),
(51, '2022-02-24', '20:00', 0, 1, '', '2022-02-27 05:08:50'),
(52, '2022-02-07', '08:00', 1, 1, 'terapi lintah', '2022-02-27 10:19:03'),
(53, '2022-02-07', '10:00', 0, 1, '', '2022-02-27 10:19:03'),
(54, '2022-02-07', '13:00', 0, 1, '', '2022-02-27 10:19:03'),
(55, '2022-02-07', '16:00', 0, 1, '', '2022-02-27 10:19:03'),
(56, '2022-02-07', '20:00', 0, 1, '', '2022-02-27 10:19:03'),
(57, '2022-02-26', '08:00', 0, 1, '', '2022-02-27 11:24:51'),
(58, '2022-02-26', '10:00', 0, 1, '', '2022-02-27 11:24:51'),
(59, '2022-02-26', '13:00', 0, 1, '', '2022-02-27 11:24:51'),
(60, '2022-02-26', '16:00', 1, 1, 'electric\n', '2022-02-27 11:24:51'),
(61, '2022-02-26', '20:00', 0, 1, '', '2022-02-27 11:24:51'),
(62, '2022-02-14', '08:00', 0, 0, '', '2022-02-28 06:48:07'),
(63, '2022-02-14', '10:00', 0, 0, '', '2022-02-28 06:48:07'),
(64, '2022-02-14', '13:00', 0, 0, '', '2022-02-28 06:48:08'),
(65, '2022-02-14', '16:00', 0, 0, '', '2022-02-28 06:48:08'),
(66, '2022-02-14', '20:00', 1, 0, 'sdsd\n', '2022-02-28 06:48:08'),
(67, '2022-02-23', '08:00', 0, 0, '', '2022-02-28 06:48:43'),
(68, '2022-02-23', '10:00', 0, 0, '', '2022-02-28 06:48:44'),
(69, '2022-02-23', '13:00', 0, 0, '', '2022-02-28 06:48:44'),
(70, '2022-02-23', '16:00', 0, 0, '', '2022-02-28 06:48:45'),
(71, '2022-02-23', '20:00', 0, 0, '', '2022-02-28 06:48:45'),
(72, '2022-02-28', '08:00', 1, 1, 'hhh', '2022-02-28 06:50:30'),
(73, '2022-02-28', '10:00', 1, 1, 'yyy', '2022-02-28 06:50:31'),
(74, '2022-02-28', '13:00', 0, 1, '', '2022-02-28 06:50:31'),
(75, '2022-02-28', '16:00', 0, 1, '', '2022-02-28 06:50:31'),
(76, '2022-02-28', '20:00', 0, 1, '', '2022-02-28 06:50:31'),
(77, '2022-02-01', '08:00', 0, 0, '', '2022-02-28 08:14:05'),
(78, '2022-02-01', '10:00', 0, 0, '', '2022-02-28 08:14:06'),
(79, '2022-02-01', '13:00', 0, 0, '', '2022-02-28 08:14:06'),
(80, '2022-02-01', '16:00', 0, 0, '', '2022-02-28 08:14:06'),
(81, '2022-02-01', '20:00', 0, 0, '', '2022-02-28 08:14:06'),
(82, '2022-03-01', '08:00', 1, 0, 'testtt', '2022-02-28 08:19:49'),
(83, '2022-03-01', '10:00', 0, 0, '', '2022-02-28 08:19:49'),
(84, '2022-03-01', '13:00', 0, 0, '', '2022-02-28 08:19:49'),
(85, '2022-03-01', '16:00', 0, 0, '', '2022-02-28 08:19:51'),
(86, '2022-03-01', '20:00', 0, 0, '', '2022-02-28 08:19:51'),
(87, '2022-03-01', '08:00', 1, 1, 'cbain aja', '2022-02-28 09:23:17'),
(88, '2022-03-01', '10:00', 1, 1, 'samaaa', '2022-02-28 09:23:17'),
(89, '2022-03-01', '13:00', 0, 1, '', '2022-02-28 09:23:17'),
(90, '2022-03-01', '16:00', 0, 1, '', '2022-02-28 09:23:17'),
(91, '2022-03-01', '20:00', 0, 1, '', '2022-02-28 09:23:17'),
(92, '2022-03-02', '08:00', 1, 1, 'penuh', '2022-02-28 09:24:04'),
(93, '2022-03-02', '10:00', 1, 1, 'penuh', '2022-02-28 09:24:04'),
(94, '2022-03-02', '13:00', 1, 1, 'penuh', '2022-02-28 09:24:05'),
(95, '2022-03-02', '16:00', 1, 1, 'penuh', '2022-02-28 09:24:05'),
(96, '2022-03-02', '20:00', 1, 1, 'penuh', '2022-02-28 09:24:05'),
(97, '2022-03-03', '08:00', 0, 1, '', '2022-02-28 09:37:29'),
(98, '2022-03-03', '10:00', 0, 1, '', '2022-02-28 09:37:29'),
(99, '2022-03-03', '13:00', 0, 1, '', '2022-02-28 09:37:30'),
(100, '2022-03-03', '16:00', 0, 1, '', '2022-02-28 09:37:30'),
(101, '2022-03-03', '20:00', 0, 1, '', '2022-02-28 09:37:30'),
(102, '2022-03-04', '08:00', 1, 1, 'electric\n', '2022-02-28 09:37:40'),
(103, '2022-03-04', '10:00', 0, 1, '', '2022-02-28 09:37:40'),
(104, '2022-03-04', '13:00', 0, 1, '', '2022-02-28 09:37:40'),
(105, '2022-03-04', '16:00', 0, 1, '', '2022-02-28 09:37:40'),
(106, '2022-03-04', '20:00', 0, 1, '', '2022-02-28 09:37:40'),
(107, '2022-03-02', '08:00', 0, 0, '', '2022-02-28 09:38:05'),
(108, '2022-03-02', '10:00', 1, 0, 'bekam', '2022-02-28 09:38:05'),
(109, '2022-03-02', '13:00', 0, 0, '', '2022-02-28 09:38:05'),
(110, '2022-03-02', '16:00', 0, 0, '', '2022-02-28 09:38:05'),
(111, '2022-03-02', '20:00', 0, 0, '', '2022-02-28 09:38:05'),
(112, '2022-04-17', '08:00', 0, 0, '', '2022-04-17 15:23:11'),
(113, '2022-04-17', '10:00', 0, 0, '', '2022-04-17 15:23:11'),
(114, '2022-04-17', '13:00', 0, 0, '', '2022-04-17 15:23:11'),
(115, '2022-04-17', '16:00', 0, 0, '', '2022-04-17 15:23:12'),
(116, '2022-04-17', '20:00', 0, 0, '', '2022-04-17 15:23:12'),
(117, '2022-04-18', '08:00', 0, 0, '', '2022-04-17 15:29:20'),
(118, '2022-04-18', '10:00', 0, 0, '', '2022-04-17 15:29:20'),
(119, '2022-04-18', '13:00', 0, 0, '', '2022-04-17 15:29:20'),
(120, '2022-04-18', '16:00', 0, 0, '', '2022-04-17 15:29:21'),
(121, '2022-04-18', '20:00', 0, 0, '', '2022-04-17 15:29:21'),
(122, '2022-04-19', '08:00', 0, 0, '', '2022-04-17 15:37:00'),
(123, '2022-04-19', '10:00', 0, 0, '', '2022-04-17 15:37:01'),
(124, '2022-04-19', '13:00', 0, 0, '', '2022-04-17 15:37:01'),
(125, '2022-04-19', '16:00', 0, 0, '', '2022-04-17 15:37:01'),
(126, '2022-04-19', '20:00', 0, 0, '', '2022-04-17 15:37:01'),
(127, '2022-04-20', '08:00', 0, 0, '', '2022-04-17 16:14:34'),
(128, '2022-04-20', '10:00', 0, 0, '', '2022-04-17 16:14:34'),
(129, '2022-04-20', '13:00', 0, 0, '', '2022-04-17 16:14:34'),
(130, '2022-04-20', '16:00', 0, 0, '', '2022-04-17 16:14:35'),
(131, '2022-04-20', '20:00', 0, 0, '', '2022-04-17 16:14:35');

-- --------------------------------------------------------

--
-- Table structure for table `rth_users`
--

CREATE TABLE `rth_users` (
  `id` int(4) NOT NULL,
  `username` varchar(75) NOT NULL,
  `home_address` varchar(200) NOT NULL,
  `contact` varchar(75) NOT NULL,
  `email` varchar(75) NOT NULL,
  `pass` varchar(75) NOT NULL,
  `full_name` varchar(75) NOT NULL,
  `alive` tinyint(1) NOT NULL DEFAULT '0',
  `membership` tinyint(1) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `propic` varchar(75) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rth_users`
--

INSERT INTO `rth_users` (`id`, `username`, `home_address`, `contact`, `email`, `pass`, `full_name`, `alive`, `membership`, `gender`, `propic`, `created_date`) VALUES
(1, 'admin', 'jakarta', '085721261437', 'admin@home.com', '1234', 'admin keren', 0, 2, 0, 'default.png', '2023-04-02 13:32:17'),
(2, 'a', 's', 'a', 'e', 'b', 'a', 0, 0, 0, 'default.png', '0000-00-00 00:00:00'),
(3, 'aa', 'addd', '123838', 'cc', 'bb', 'jsjsjsjs', 0, 0, 0, 'default.png', '0000-00-00 00:00:00'),
(4, 'gumuruh', 'addd', '123838', 'gumuruh@gmail.com', 'callme28', 'Gumuruh S.', 0, 0, 0, '1642487015_chap3.PNG', '2023-04-02 09:38:31'),
(5, 'aacaa', 'addd', '123838', 'cc@home.coms', 'bb', 'jsjsjsjs', 0, 0, 0, '1642489369_Chrysanthemum.jpg', '0000-00-00 00:00:00'),
(6, 'aacaaxx', 'addd', '123838', 'cc@home.comsxx', 'bb', 'jsjsjsjs', 0, 0, 0, 'default.png', '0000-00-00 00:00:00'),
(9, 'ninik', 'rumah', '0129292', 'ninik@home.com', 'XofWgFq', 'ninik', 0, 0, 0, 'default.png', '2023-04-01 14:43:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rth_booking_request`
--
ALTER TABLE `rth_booking_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rth_health_common`
--
ALTER TABLE `rth_health_common`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rth_health_special`
--
ALTER TABLE `rth_health_special`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rth_ruqyah`
--
ALTER TABLE `rth_ruqyah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rth_schedules`
--
ALTER TABLE `rth_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rth_users`
--
ALTER TABLE `rth_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rth_booking_request`
--
ALTER TABLE `rth_booking_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `rth_health_common`
--
ALTER TABLE `rth_health_common`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rth_health_special`
--
ALTER TABLE `rth_health_special`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rth_ruqyah`
--
ALTER TABLE `rth_ruqyah`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rth_schedules`
--
ALTER TABLE `rth_schedules`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `rth_users`
--
ALTER TABLE `rth_users`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
