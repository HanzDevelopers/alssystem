-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2024 at 09:11 AM
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
-- Database: `als`
--

-- --------------------------------------------------------

--
-- Table structure for table `osy_tbl`
--

CREATE TABLE `osy_tbl` (
  `encoder_id` int(12) NOT NULL,
  `date_encoded` varchar(100) DEFAULT NULL,
  `year` varchar(10) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `city_municipality` varchar(100) DEFAULT NULL,
  `barangay` varchar(100) DEFAULT NULL,
  `sitio_zone_purok` varchar(100) DEFAULT NULL,
  `housenumber` varchar(50) DEFAULT NULL,
  `estimated_family_income` varchar(100) DEFAULT NULL,
  `household_members` varchar(255) DEFAULT NULL,
  `relationship_to_head` varchar(100) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `age` int(5) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `civil_status` varchar(50) DEFAULT NULL,
  `person_with_disability` varchar(100) DEFAULT NULL,
  `ethnicity` varchar(100) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `highest_grade_completed` varchar(50) DEFAULT NULL,
  `currently_attending_school` varchar(50) DEFAULT NULL,
  `grade_level_enrolled` varchar(100) DEFAULT NULL,
  `reasons_for_not_attending_school` varchar(255) DEFAULT NULL,
  `can_read_write_simple_messages_inanylanguage` varchar(50) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `work` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `osy_tbl`
--

INSERT INTO `osy_tbl` (`encoder_id`, `date_encoded`, `year`, `province`, `city_municipality`, `barangay`, `sitio_zone_purok`, `housenumber`, `estimated_family_income`, `household_members`, `relationship_to_head`, `birthdate`, `age`, `gender`, `civil_status`, `person_with_disability`, `ethnicity`, `religion`, `highest_grade_completed`, `currently_attending_school`, `grade_level_enrolled`, `reasons_for_not_attending_school`, `can_read_write_simple_messages_inanylanguage`, `occupation`, `work`, `status`) VALUES
(2, NULL, NULL, NULL, 'Manolo Fortich', 'Tankulan', 'Purok 5 Upper Pol-Oton', NULL, NULL, 'bimbo', NULL, '2001-08-27', 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `login_date` datetime DEFAULT NULL,
  `logout_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`log_id`, `user_id`, `user_name`, `login_date`, `logout_date`) VALUES
(1, 1, 'user', '2024-07-20 18:41:50', NULL),
(2, 1, 'user', '2024-07-20 18:49:59', NULL),
(3, 2, 'admin', '2024-07-20 18:50:10', NULL),
(4, 1, 'user', '2024-07-20 21:18:08', NULL),
(5, 2, 'admin', '2024-07-24 15:24:51', NULL),
(6, 2, 'admin', '2024-07-24 15:56:23', NULL),
(7, 1, 'user', '2024-07-27 22:33:19', NULL),
(8, 2, 'admin', '2024-07-27 22:45:11', NULL),
(9, 2, 'admin', '2024-07-28 03:05:42', NULL),
(10, 2, 'admin', '2024-07-30 11:15:19', NULL),
(11, 2, 'admin', '2024-08-04 20:37:03', NULL),
(12, 2, 'admin', '2024-08-04 20:41:11', NULL),
(13, 2, 'admin', '2024-08-10 15:43:22', NULL),
(14, 2, 'admin', '2024-08-19 08:51:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `user_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`user_id`, `user_name`, `email`, `pass`, `user_type`) VALUES
(1, 'user', 'user@gmail.com', '$2y$10$9.qAGoiyjTSexyrz6D91T.ijpl2WLX4aQjcH20c8bhwiVrapzgmo6', 'user'),
(2, 'admin', 'admin@gmail.com', '$2y$10$KnOAEPlAWwiTr.WUe3qmhep9I3phYEvQCyjjLSAXkWbcahBcpQuMW', 'admin'),
(3, 'sample', 'villaganasbimbo123@gmail.com', '$2y$10$UdoQYJ6a4QeipkC1pLAoIuWeMcUwG8UzIyT0L2KAgXT7xVQh4hOEK', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `osy_tbl`
--
ALTER TABLE `osy_tbl`
  ADD PRIMARY KEY (`encoder_id`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `osy_tbl`
--
ALTER TABLE `osy_tbl`
  ADD CONSTRAINT `osy_tbl_ibfk_1` FOREIGN KEY (`encoder_id`) REFERENCES `user_tbl` (`user_id`);

--
-- Constraints for table `user_log`
--
ALTER TABLE `user_log`
  ADD CONSTRAINT `user_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_tbl` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
