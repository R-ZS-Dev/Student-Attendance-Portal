-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2024 at 06:07 PM
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
-- Database: `attendance_system_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `f_name` varchar(255) DEFAULT NULL,
  `l_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `f_name`, `l_name`, `email`, `status`, `created_at`, `updated_at`) VALUES
(2, 'uCiSBsMoQD', 'TcfsyJSvRT', '5gn3z@qagj.com', 'Present', '2024-07-17 08:15:50', '2024-07-17 11:15:50'),
(3, 'Test', 'Testing', 'test@gmail.com', 'Present', '2024-07-17 12:21:12', '2024-07-17 15:21:12'),
(4, 'PDHRRc7Ukq', 'HhoQyNv4LQ', '2xvmx@ugpi.com', 'Present', '2024-07-17 12:22:03', '2024-07-17 15:22:03'),
(5, 'lnpkDleIQF', 'mBiwe5poXJ', 'sbnry@ryoh.com', 'Present', '2024-07-17 12:22:28', '2024-07-17 15:22:28');

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `f_name` varchar(255) DEFAULT NULL,
  `l_name` varchar(255) DEFAULT NULL,
  `leave_reason` text DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `status` varchar(255) DEFAULT 'Pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `email`, `f_name`, `l_name`, `leave_reason`, `from_date`, `to_date`, `status`, `created_at`, `updated_at`) VALUES
(1, '5gn3z@qagj.com', 'uCiSBsMoQD', 'TcfsyJSvRT', 'mm', '2024-07-20', '2024-07-21', NULL, '2024-07-17 13:16:23', '2024-07-17 16:16:23'),
(2, '5gn3z@qagj.com', 'uCiSBsMoQD', 'TcfsyJSvRT', 'ok', '2024-07-20', '2024-07-20', 'Rejected', '2024-07-17 13:18:42', '2024-07-17 16:18:42'),
(3, 'sbnry@ryoh.com', 'lnpkDleIQF', 'mBiwe5poXJ', 'Urgent Work.', '2024-07-19', '2024-07-20', 'Rejected', '2024-07-17 17:22:49', '2024-07-17 20:22:49');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `f_name` varchar(255) DEFAULT NULL,
  `l_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phn_num` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `f_name`, `l_name`, `email`, `phn_num`, `password`, `address`, `created_at`, `updated_at`) VALUES
(1, 'uCiSBsMoQD', 'TcfsyJSvRT', '5gn3z@qagj.com', 'KqLucyyb5C', '$2y$10$TmBXWxZndx2Qnc4.n1ujO.9XkcdauLZS4IXtuv4kG1sKW6Hc.fYDm', 'WrXsKEHagZ', '2024-07-17 11:15:13', '2024-07-17 11:15:13'),
(2, 'Test', 'Testing', 'test@gmail.com', '01821234567', '$2y$10$br6AwpJ3qImLhv6fGKOG3esHonkzAeCIBTrdg/O7gTRJjbq1T/bL6', 'N/A', '2024-07-17 15:20:40', '2024-07-17 15:20:40'),
(3, 'PDHRRc7Ukq', 'HhoQyNv4LQ', '2xvmx@ugpi.com', 'djOAw6VJ39', '$2y$10$A6JbJS0Eziu1V0nLN6gIcuJyT5gCF0wyI8ZCmOV9o34QJRryhNsTy', 'ip7xJRFOEa', '2024-07-17 15:21:51', '2024-07-17 15:21:51'),
(4, 'lnpkDleIQF', 'mBiwe5poXJ', 'sbnry@ryoh.com', 'IH44FwZ2So', '$2y$10$uSpm0OziU2/el6aDovgEBuPMvCIlsVnQrlg5jCarQoRK4FcCgh13G', 'LRZlTTcWxD', '2024-07-17 15:22:17', '2024-07-17 15:22:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
