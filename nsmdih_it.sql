-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2025 at 02:56 AM
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
-- Database: `nsmdih_it`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `type` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `password`, `type`, `status`) VALUES
('admin.gelo', '$2a$12$0WPc3WHLD8rlx.HJ2v7WB.T5meE9lGBYGx77RdpvxS/lK8/OcZnu2', 'Administrator', 'Active'),
('admin.jedrick', '$2a$12$t8SQGurDU6rC3SuxojT7a.wIzIg3ozeL2VEgxSF8k.3nixhfTkCuG', 'Administrator', 'Active'),
('superadmin', '$2a$12$Yin4MBloIJfUtt7lwzz74Oa4bF6TT8kVvzYEwQeHeAUKO9AVjLvTG', 'Super Administrator', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `category_job_order`
--

CREATE TABLE `category_job_order` (
  `id` int(11) NOT NULL,
  `category` varchar(500) NOT NULL,
  `type` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_job_order`
--

INSERT INTO `category_job_order` (`id`, `category`, `type`) VALUES
(1, 'Others', 'Job Order'),
(2, 'Printer', 'Job Order'),
(3, 'IT Department', 'Department'),
(4, 'HR Department', 'Department'),
(7, 'PC', 'Job Order'),
(8, 'Pharmacy', 'Department'),
(9, 'Hardware', 'Job Order');

-- --------------------------------------------------------

--
-- Table structure for table `records_job_order`
--

CREATE TABLE `records_job_order` (
  `id` int(250) NOT NULL,
  `name` varchar(500) NOT NULL,
  `department` varchar(500) NOT NULL,
  `job_order_nature` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL,
  `issue_year` int(250) NOT NULL,
  `issue_month` varchar(500) NOT NULL,
  `issue_day` int(250) NOT NULL,
  `issue_time` varchar(500) NOT NULL,
  `satisfied` varchar(500) NOT NULL,
  `unsatisfied` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `records_job_order`
--

INSERT INTO `records_job_order` (`id`, `name`, `department`, `job_order_nature`, `description`, `issue_year`, `issue_month`, `issue_day`, `issue_time`, `satisfied`, `unsatisfied`) VALUES
(144, 'Ryan', 'IT Department', 'Printer', 'Lan Cable', 2025, 'February', 10, '14:17:46', '80', '20'),
(145, 'Jay Tee Talibsao', 'IT Department', 'Others', 'Managing Computer WIre', 2025, 'February', 10, '14:18:31', '100', '0'),
(146, 'Dominic', 'HR Department', 'Printer', '', 2025, 'February', 10, '14:18:54', '60', '40'),
(147, 'Jay Yare', 'Pharmacy', 'PC', '', 2025, 'February', 10, '16:09:23', '80', '20'),
(148, 'jay', 'IT Department', 'PC', 'connection', 2025, 'February', 11, '15:39:35', '100', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `category_job_order`
--
ALTER TABLE `category_job_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `records_job_order`
--
ALTER TABLE `records_job_order`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category_job_order`
--
ALTER TABLE `category_job_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `records_job_order`
--
ALTER TABLE `records_job_order`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
