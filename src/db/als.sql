-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2024 at 06:29 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
-- Table structure for table `archive_tbl`
--

CREATE TABLE `archive_tbl` (
  `record_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `encoder_name` varchar(255) DEFAULT NULL,
  `date_encoded` date DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city_municipality` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `sitio_zone_purok` varchar(255) DEFAULT NULL,
  `housenumber` varchar(255) DEFAULT NULL,
  `estimated_family_income` decimal(10,2) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `household_members` varchar(255) DEFAULT NULL,
  `relationship_to_head` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `civil_status` varchar(50) DEFAULT NULL,
  `person_with_disability` varchar(50) DEFAULT NULL,
  `ethnicity` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `highest_grade_completed` varchar(255) DEFAULT NULL,
  `currently_attending_school` varchar(50) DEFAULT NULL,
  `grade_level_enrolled` varchar(255) DEFAULT NULL,
  `reasons_for_not_attending_school` text DEFAULT NULL,
  `can_read_write_simple_messages_inanylanguage` varchar(50) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `work` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `deletion_timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archive_tbl`
--

INSERT INTO `archive_tbl` (`record_id`, `member_id`, `encoder_name`, `date_encoded`, `province`, `city_municipality`, `barangay`, `sitio_zone_purok`, `housenumber`, `estimated_family_income`, `notes`, `household_members`, `relationship_to_head`, `birthdate`, `age`, `gender`, `civil_status`, `person_with_disability`, `ethnicity`, `religion`, `highest_grade_completed`, `currently_attending_school`, `grade_level_enrolled`, `reasons_for_not_attending_school`, `can_read_write_simple_messages_inanylanguage`, `occupation`, `work`, `status`, `deleted_by`, `deletion_timestamp`) VALUES
(165, 272, 'admin Bimbo', '2024-11-13', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'mangima', '112', 15000.00, '', 'Mark A. Balandra', 'Head', '1979-12-05', 44, 'Male', 'Married', 'None', 'Cebuano', 'Roman Catholic', 'Grade 6', 'No', 'N/A', 'No regular transportation', 'Yes', 'Yes', 'Farmer', 'No', 'admin Bimbo', '2024-11-25 02:28:05'),
(151, 228, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 1', '12', 15000.00, '', 'Gia Honlay Sural ', 'Daughter', '2001-12-13', 22, 'Female', 'Single', 'None', 'Cebuano', 'Roman Catholic', 'Grade 9/3rd YR HS', 'Yes', 'Grade 10/4th YR HS', 'Schools are very far', 'Yes', 'Yes', 'Janitor', 'Yes', 'Jessa', '2024-11-25 02:29:47');

-- --------------------------------------------------------

--
-- Table structure for table `background_tbl`
--

CREATE TABLE `background_tbl` (
  `background_id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `highest_grade_completed` varchar(255) DEFAULT NULL,
  `currently_attending_school` varchar(100) DEFAULT NULL,
  `grade_level_enrolled` varchar(50) DEFAULT NULL,
  `reasons_for_not_attending_school` text DEFAULT NULL,
  `can_read_write_simple_messages_inanylanguage` varchar(10) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `work` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `background_tbl`
--

INSERT INTO `background_tbl` (`background_id`, `member_id`, `highest_grade_completed`, `currently_attending_school`, `grade_level_enrolled`, `reasons_for_not_attending_school`, `can_read_write_simple_messages_inanylanguage`, `occupation`, `work`, `status`) VALUES
(219, 223, 'Grade 9/3rd YR HS', 'No', 'N/A', 'No regular transportation', 'Yes', 'Yes', 'Farmer', 'No'),
(220, 224, 'Grade 7/1st YR HS', 'No', 'N/A', 'Schools are very far', 'Yes', 'No', 'N/A', 'No'),
(221, 225, 'Grade 8/2nd YR HS', 'Yes', 'Grade 9/3rd YR HS', 'No regular transportation', 'Yes', 'Yes', 'Laborer', 'Yes'),
(223, 227, 'Grade 8/2nd YR HS', 'No', 'N/A', 'No regular transportation', 'Yes', 'No', 'N/A', 'No'),
(225, 229, 'Grade 6', 'No', 'N/A', 'No regular transportation', 'Yes', 'Yes', 'Farmer', 'No'),
(226, 230, 'Grade 7/1st YR HS', 'No', 'N/A', 'Schools are very far', 'Yes', 'No', 'N/A', 'No'),
(227, 231, 'Grade 7/1st YR HS', 'Yes', 'Grade 8/2nd YR HS', 'Schools are very far', 'Yes', 'Yes', 'Construction worker', 'Yes'),
(228, 232, 'Grade 6', 'No', 'N/A', 'Schools are very far', 'Yes', 'Yes', '', 'No'),
(229, 233, 'Grade 7/1st YR HS', 'No', 'N/A', 'High cost of education', 'Yes', 'No', 'N/A', 'No'),
(231, 235, 'Grade 9/3rd YR HS', 'No', 'N/A', 'No regular transportation', 'Yes', 'Yes', 'Farmer', 'No'),
(232, 236, 'Grade 7/1st YR HS', 'No', 'N/A', 'No regular transportation', 'Yes', 'No', 'N/A', 'No'),
(233, 237, 'Grade 9/3rd YR HS', 'Yes', 'Grade 10/4th YR HS', 'Employment/Looking for work', 'Yes', 'Yes', 'LGU utility worker', 'Yes'),
(234, 238, 'Grade 6', 'No', 'N/A', 'None', 'Yes', 'No', 'N/A', 'No'),
(235, 239, 'Grade 7/1st YR HS', 'No', 'N/A', 'No regular transportation', 'Yes', 'Yes', 'Baby setter', 'No'),
(236, 240, 'Grade 9/3rd YR HS', 'Yes', 'Grade 10/4th YR HS', 'Schools are very far', 'Yes', 'Yes', 'Baker', 'Yes'),
(238, 242, 'Grade 7/1st YR HS', 'No', 'N/A', 'None', 'Yes', 'No', 'N/A', 'No'),
(240, 244, 'Grade 6', 'No', 'N/A', 'Employment/Looking for work', 'Yes', 'Yes', 'Construction worker', 'No'),
(241, 245, 'Grade 6', 'No', 'N/A', 'No regular transportation', 'Yes', 'Yes', 'N/A', 'No'),
(242, 246, 'Grade 9/3rd YR HS', 'Yes', 'Grade 10/4th YR HS', 'Schools are very far', 'Yes', 'Yes', 'Construction worker', 'Yes'),
(245, 249, 'Grade 9/3rd YR HS', 'Yes', 'Grade 10/4th YR HS', 'No regular transportation', 'Yes', 'Yes', 'Farmer', 'Yes'),
(247, 251, 'Grade 6', 'No', 'N/A', 'High cost of education', 'Yes', 'No', 'N/A', 'No'),
(249, 253, 'Grade 9/3rd YR HS', 'No', 'N/A', 'Employment/Looking for work', 'Yes', 'Yes', 'Farmer', 'No'),
(250, 254, 'Grade 4', 'No', 'N/A', 'No regular transportation', 'Yes', 'No', 'N/A', 'No'),
(251, 255, 'Grade 6', 'Yes', 'Grade 7/1st YR HS', 'High cost of education', 'Yes', 'Yes', 'Construction worker', 'Yes'),
(257, 261, 'Grade 6', 'No', 'N/A', 'No regular transportation', 'Yes', 'Yes', 'Farmer', 'No'),
(258, 262, 'Grade 7/1st YR HS', 'No', 'N/A', 'No regular transportation', 'Yes', 'No', 'N/A', 'Yes'),
(259, 263, 'Grade 8/2nd YR HS', 'No', 'N/A', 'No regular transportation', 'Yes', 'yes', 'caregiver', 'Yes'),
(260, 264, 'Grade 4', 'No', 'N/A', 'No regular transportation', 'Yes', 'No', 'N/A', 'Yes'),
(262, 266, 'Grade 6', 'No', 'N/A', 'Employment/Looking for work', 'Yes', 'Yes', 'Laborer', 'No'),
(263, 267, 'Grade 6', 'No', 'N/A', 'Schools are very far', 'Yes', 'No', 'N/A', 'No'),
(264, 268, 'Grade 7/1st YR HS', 'Yes', 'Grade 8/2nd YR HS', 'None', 'Yes', 'No', 'N/A', 'Yes'),
(265, 269, 'Grade 7/1st YR HS', 'No', 'N/A', 'None', 'Yes', 'No', 'N/A', 'Yes'),
(266, 270, 'Grade 8/2nd YR HS', 'No', 'N/A', 'None', 'Yes', 'No', 'N/A', 'Yes'),
(269, 273, 'Grade 8/2nd YR HS', 'No', 'N/A', 'No regular transportation', 'Yes', 'No', 'N/A', 'No'),
(271, 275, 'Grade 5', 'No', 'N/A', 'None', 'Yes', 'No', 'N/A', 'Yes'),
(272, 276, 'Grade 9/3rd YR HS', 'No', 'N/A', 'No regular transportation', 'Yes', 'No', 'N/A', 'Yes'),
(273, 277, 'Grade 6', 'No', 'N/A', 'No regular transportation', 'Yes', 'Yes', 'Farmer', 'No'),
(274, 278, 'Grade 7/1st YR HS', 'No', 'N/A', 'No regular transportation', 'Yes', 'Yes', 'Farmer', 'No'),
(275, 279, 'Grade 7/1st YR HS', 'No', 'N/A', 'No regular transportation', 'Yes', 'No', 'N/A', 'Yes'),
(276, 280, 'Grade 9/3rd YR HS', 'No', 'N/A', 'No regular transportation', 'Yes', 'No', 'N/A', 'Yes'),
(277, 281, 'Grade 7/1st YR HS', 'No', 'N/A', 'Lack of personal interest', 'Yes', 'No', 'N/A', 'No'),
(278, 282, 'Grade 6', 'Yes', 'Grade 7/1st YR HS', 'None', 'Yes', 'No', 'N/A', 'Yes'),
(279, 283, 'Grade 7/1st YR HS', 'No', 'N/A', 'No regular transportation', 'Yes', 'Yes', 'Farmer', 'No'),
(280, 284, 'Grade 6', 'No', 'N/A', 'No regular transportation', 'Yes', 'Yes', 'Farmer', 'No'),
(281, 285, 'Grade 9/3rd YR HS', 'No', 'N/A', 'No regular transportation', 'Yes', 'No', 'N/A', 'Yes'),
(282, 286, 'Grade 9/3rd YR HS', 'No', 'N/A', 'No regular transportation', 'Yes', 'No', 'N/A', 'Yes'),
(283, 287, 'Grade 8/2nd YR HS', 'No', 'N/A', 'No regular transportation', 'Yes', 'No', 'N/A', 'Yes'),
(284, 288, 'Grade 10/4th YR HS', 'No', 'N/A', 'Graduated', 'Yes', 'Yes', 'Farmer', 'No'),
(285, 289, 'Grade 8/2nd YR HS', 'No', 'N/A', 'Schools are very far', 'Yes', 'Yes', 'Housewife', 'No'),
(286, 290, 'Grade 4', 'Yes', 'Grade 5', 'None', 'Yes', 'No', 'N/A', 'Yes'),
(287, 291, 'Grade 9/3rd YR HS', 'No', 'N/A', 'Employment/Looking for work', 'Yes', 'No', 'N/A', 'Yes'),
(288, 292, 'Grade 5', 'No', 'N/A', 'Employment/Looking for work', 'Yes', 'Yes', 'Laborer', 'No'),
(289, 293, 'Grade 8/2nd YR HS', 'No', 'N/A', 'Employment/Looking for work', 'Yes', 'No', 'N/A', 'No'),
(290, 294, 'Grade 8/2nd YR HS', 'Yes', 'Grade 9/3rd YR HS', 'None', 'Yes', 'Yes', 'OEW', 'Yes'),
(291, 295, 'Grade 7/1st YR HS', 'Yes', 'Grade 8/2nd YR HS', 'None', 'Yes', 'No', 'N/A', 'Yes'),
(292, 296, 'College Grad', 'No', 'N/A', 'Graduated', 'Yes', 'Yes', 'Police', 'No'),
(293, 297, '4th Yr College', 'No', 'N/A', 'Graduated', 'Yes', 'Yes', 'Brgy. Clerk', 'No'),
(294, 298, 'Grade 5', 'Yes', 'Grade 6', 'None', 'Yes', 'No', 'N/A', 'Yes'),
(295, 299, 'Grade 10/4th YR HS', 'No', 'N/A', 'Graduated', 'Yes', 'Yes', 'Farmer', 'No'),
(296, 300, 'Grade 8/2nd YR HS', 'No', 'N/A', 'Tardness', 'Yes', 'No', 'N/A', 'No'),
(297, 301, 'Grade 4', 'Yes', 'Grade 5', 'None', 'Yes', 'No', 'N/A', 'Yes'),
(298, 302, 'Grade 4', 'No', 'N/A', 'NA', 'Yes', 'Yes', 'Laborer', 'No'),
(299, 303, 'Grade 6', 'No', 'N/A', 'NA', 'Yes', 'No', 'N/A', 'No'),
(300, 304, 'Grade 9/3rd YR HS', 'No', 'N/A', 'Lack of personal interest', 'Yes', 'Yes', 'Laborer', 'Yes'),
(301, 305, 'College Grad', 'No', 'N/A', 'Graduated', 'Yes', 'Yes', 'Police', 'No'),
(302, 306, 'College Grad', 'No', 'N/A', 'Graduated', 'Yes', 'Yes', 'Teacher', 'No'),
(303, 307, 'Grade 9/3rd YR HS', 'Yes', '2nd Yr College', 'None', 'Yes', 'No', 'N/A', 'Yes'),
(304, 308, 'Grade 6', 'No', 'N/A', 'Schools are very far', 'Yes', 'Yes', 'farmer', 'No'),
(305, 309, 'Grade 7/1st YR HS', 'No', 'N/A', 'Schools are very far', 'Yes', 'Yes', 'farmer', 'No'),
(306, 310, 'Grade 8/2nd YR HS', 'No', 'N/A', 'Illness/Disability', 'Yes', 'No', 'N/A', 'Yes'),
(307, 311, 'Grade 8/2nd YR HS', 'No', 'N/A', 'Illness/Disability', 'Yes', 'No', 'N/A', 'Yes'),
(310, 314, 'Grade 6', 'No', 'N/A', 'Others (specify)', 'Yes', 'Yes', 'Labor', 'Yes'),
(311, 315, 'Grade 7/1st YR HS', 'No', 'N/A', 'Schools are very far', 'Yes', 'Yes', 'farmer', 'No'),
(312, 316, 'Grade 8/2nd YR HS', 'No', 'N/A', 'Schools are very far', 'Yes', 'No', 'N/A', 'Yes'),
(313, 317, 'Grade 7/1st YR HS', 'No', 'N/A', 'Schools are very far', 'Yes', 'No', 'N/A', 'Yes'),
(314, 318, 'Grade 8/2nd YR HS', 'No', 'N/A', 'Schools are very far', 'Yes', 'No', 'N/A', 'Yes'),
(315, 319, 'Grade 6', 'No', 'N/A', 'N', 'Yes', 'Yes', '', ''),
(316, 320, 'Grade 5', 'No', 'N/A', 'Schools are very far', 'Yes', 'Yes', '', ''),
(317, 321, 'Grade 7/1st YR HS', 'No', 'N/A', 'Schools are very far', 'Yes', '', '', ''),
(318, 322, 'Grade 7/1st YR HS', 'No', 'N/A', 'Schools are very far', 'Yes', '', '', ''),
(319, 323, 'Grade 7/1st YR HS', 'No', 'N/A', 'Schools are very far', 'Yes', '', '', ''),
(320, 324, 'Grade 8/2nd YR HS', 'No', 'N/A', 'Schools are very far', 'Yes', '', '', ''),
(321, 325, 'Grade 6', 'No', 'N/A', 'None', 'Yes', 'Yes', 'farmer', 'No'),
(322, 326, 'Grade 5', 'No', 'N/A', 'Schools are very far', 'Yes', 'Yes', 'farmer', 'No'),
(323, 327, 'Grade 7/1st YR HS', 'No', 'N/A', 'Schools are very far', 'Yes', 'No', 'N/A', 'Yes'),
(324, 328, 'Grade 7/1st YR HS', 'No', 'N/A', 'Schools are very far', 'Yes', 'No', 'N/A', 'Yes'),
(325, 329, 'Grade 7/1st YR HS', 'No', 'N/A', 'Schools are very far', 'Yes', 'Yes', 'Cashier', 'Yes'),
(326, 330, 'Grade 8/2nd YR HS', 'No', 'N/A', 'Schools are very far', 'Yes', 'Yes', 'Cashier', 'Yes'),
(327, 331, 'Elementary Level', 'No', 'N/A', 'n/a', 'Yes', 'Yes', 'Farmer', 'No'),
(328, 332, 'Grade 6', 'Yes', 'Grade 7/1st YR HS', 'None', 'Yes', 'No', 'N/A', 'Yes'),
(329, 333, 'Grade 4', 'No', 'N/A', 'n/a', 'Yes', 'yes', 'Housewife', 'No'),
(330, 334, 'Grade 5', 'Yes', 'Grade 6', 'None', 'Yes', 'No', 'N/A', 'Yes'),
(331, 335, 'Grade 4', 'No', 'N/A', 'n/a', 'Yes', 'farmer', '', 'No'),
(332, 336, 'Grade 4', 'No', 'N/A', 'Graduated', 'Yes', 'housewife', '', 'No'),
(333, 337, 'Grade 4', 'Yes', 'Grade 5', 'None', 'Yes', 'No', 'N/A', 'Yes'),
(334, 338, 'College Grad', 'No', 'N/A', 'No regular transportation', 'Yes', 'Yes', 'sample work', 'No'),
(335, 339, '2nd Yr College', 'No', 'N/A', 'High cost of education', 'Yes', 'Yes', 'samle work', 'No'),
(336, 340, '2nd Yr College', 'No', 'N/A', 'Schools are very far', 'Yes', 'No', 'N/A', 'Yes'),
(346, NULL, 'Grade 9/3rd YR HS', 'Yes', 'Grade 10/4th YR HS', 'No regular transportation', 'Yes', 'Yes', 'Construction worker', 'Yes'),
(347, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(357, 241, 'Grade 6', 'No', 'N/A', 'No regular transportation', 'Yes', 'Yes', 'Farmer', 'No'),
(367, 352, '3rd Yr College', 'Yes', '4th Yr College', 'None', 'Yes', 'No', 'N/A', 'No'),
(370, 353, '3rd Yr College', 'Yes', '4th Yr College', 'None', 'Yes', 'No', 'N/A', 'Yes'),
(372, 260, 'Grade 5', 'No', 'N/A', 'Employment/Looking for work', 'Yes', 'Yes', 'Farmer', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `location_tbl`
--

CREATE TABLE `location_tbl` (
  `record_id` int(11) NOT NULL,
  `encoder_name` varchar(255) DEFAULT NULL,
  `date_encoded` date DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city_municipality` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `sitio_zone_purok` varchar(255) DEFAULT NULL,
  `housenumber` varchar(50) DEFAULT NULL,
  `estimated_family_income` decimal(10,2) DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location_tbl`
--

INSERT INTO `location_tbl` (`record_id`, `encoder_name`, `date_encoded`, `province`, `city_municipality`, `barangay`, `sitio_zone_purok`, `housenumber`, `estimated_family_income`, `notes`) VALUES
(150, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 1', '001', 10000.00, ''),
(151, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 1', '12', 15000.00, ''),
(152, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 4', '03', 5000.00, ''),
(153, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 2', '123', 6000.00, ''),
(154, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 2', '123', 6000.00, ''),
(155, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 4', '012', 8000.00, ''),
(156, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 1', '14', 10000.00, ''),
(157, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 2', '4562', 15000.00, ''),
(158, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 2', '2345', 16000.00, ''),
(159, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 1', '001000', 12000.00, ''),
(160, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 4', '019', 16000.00, ''),
(161, 'admin Bimbo', '2024-11-13', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 1', '18', 10000.00, ''),
(162, 'admin Bimbo', '2024-11-13', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 1', '9', 12500.00, ''),
(163, 'admin Bimbo', '2024-11-13', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 1', '10', 16500.00, ''),
(165, 'admin Bimbo', '2024-11-13', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'mangima', '112', 15000.00, ''),
(166, 'admin Bimbo', '2024-11-13', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 4', '13', 15500.00, ''),
(167, 'Jaylah Binayao', '2024-11-13', 'Bukidnon', 'Manolo Fortich', 'tankulan', 'Upper Calanawan', '001', 10000.00, ''),
(168, 'admin Bimbo', '2024-11-13', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 1', '13', 16000.00, ''),
(169, 'Jaylah Binayao', '2024-11-13', 'Bukidnon', 'Manolo Fortich', 'diclum', 'zone 1', '003', 20000.00, ''),
(170, 'Evelyn Secuya', '2024-11-13', 'Bukidnon', 'Manolo Fortich', 'agusan canyon', 'Old Coralles', '01', 10000.00, ''),
(171, 'Jaylah Binayao', '2024-11-13', 'Bukidnon', 'Manolo Fortich', 'lingion', 'Zone 7', '001', 30000.00, ''),
(172, 'Jaylah Binayao', '2024-11-13', 'Bukidnon', 'Manolo Fortich', 'san miguel', 'Purok 1B', '1234', 50000.00, ''),
(173, 'Jaylah Binayao', '2024-11-13', 'Bukidnon', 'Manolo Fortich', 'tankulan', 'Purok 1A', '1237', 40000.00, ''),
(174, 'Evelyn Secuya', '2024-11-13', 'Bukidnon', 'Manolo Fortich', 'sankanan', 'Gauron', '01', 9000.00, ''),
(175, 'Jaylah Binayao', '2024-11-13', 'Bukidnon', 'Manolo Fortich', 'san miguel', 'Zone 6', '1239', 50000.00, ''),
(176, 'lalay', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'agusan canyon', 'Purok 1', '001', 15000.00, ''),
(179, 'lalay', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'agusan canyon', 'purok 5', '002', 13000.00, ''),
(180, 'lalay', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'damilag', 'purok 5', '003', 15000.00, ''),
(181, 'lalay', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'damilag', 'purok 5', '003', 15000.00, ''),
(182, 'Jaylah Jamaica Binayao', '2024-11-08', 'Bukidnon', 'Manolo Fortich', 'tankulan', 'Upper Calanawan', '001', 10000.00, ''),
(183, 'Jaylah Jamaica Binayao', '2024-11-08', 'Bukidnon', 'Manolo Fortich', 'tankulan', 'Upper Calanawan', '001', 10000.00, ''),
(184, 'Jaylah Jamaica Binayao', '2024-11-08', 'Bukidnon', 'Manolo Fortich', 'tankulan', 'Zone 2', '002', 9000.00, ''),
(185, 'Jaylah Jamaica Binayao', '2024-11-08', 'Bukidnon', 'Manolo Fortich', 'tankulan', 'Zone 2', '002', 9000.00, ''),
(186, 'Evelyn Secuya', '2024-11-09', 'Bukidnon', 'Manolo Fortich', 'damilag', 'Purok 6', '001', 15000.00, ''),
(187, 'Evelyn Secuya', '2024-11-09', 'Bukidnon', 'Manolo Fortich', 'damilag', 'Purok 6', '001', 15000.00, ''),
(188, 'Evelyn Secuya', '2024-11-09', 'Bukidnon', 'Manolo Fortich', 'damilag', 'Purok 6', '001', 15000.00, ''),
(189, 'admin Bimbo', '2024-11-10', 'Bukidnon', 'Manolo Fortich', 'mambatangan', 'Zone 4', '001', 90000.00, ''),
(190, 'admin Bimbo', '2024-11-10', 'Bukidnon', 'Manolo Fortich', 'mambatangan', 'Zone 4', '001', 90000.00, ''),
(191, 'admin Bimbo', '2024-11-10', 'Bukidnon', 'Manolo Fortich', 'mambatangan', 'Zone 4', '001', 90000.00, ''),
(192, 'Jessa', '2024-11-15', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 4', '001', 10000.00, ''),
(193, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 1', '001000', 12000.00, ''),
(194, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(195, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 1', '001000', 12000.00, ''),
(196, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(197, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 1', '001000', 12000.00, ''),
(198, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(199, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(200, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 1', '001000', 12000.00, ''),
(201, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 1', '001000', 12000.00, ''),
(202, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(203, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 1', '14', 10000.00, ''),
(204, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(205, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 1', '12', 15000.00, ''),
(206, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 1', '12', 15000.00, ''),
(207, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 1', '12', 15000.00, ''),
(208, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 1', '12', 15000.00, ''),
(209, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(210, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 1', '12', 15000.00, ''),
(211, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(212, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 1', '12', 15000.00, ''),
(213, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(214, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 1', '12', 15000.00, ''),
(215, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(216, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 1', '14', 10000.00, ''),
(217, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(218, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 1', '14', 10000.00, ''),
(219, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 1', '14', 10000.00, ''),
(220, 'Jessa', '2024-11-14', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'zone 1', '14', 10000.00, ''),
(221, 'Jessa', '2024-11-15', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 4', '001', 10000.00, ''),
(222, 'Jessa', '2024-11-15', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 4', '001', 10000.00, ''),
(223, 'Jessa', '2024-11-15', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 4', '001', 10000.00, ''),
(224, 'Jessa', '2024-11-15', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 4', '001', 10000.00, ''),
(225, 'Jessa', '2024-11-15', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 4', '001', 10000.00, ''),
(226, 'Jessa', '2024-11-15', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 4', '001', 10000.00, ''),
(227, 'Jessa', '2024-11-15', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 4', '001', 10000.00, ''),
(228, 'admin Bimbo', '2024-11-13', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 1', '9', 12500.00, ''),
(229, 'admin Bimbo', '2024-11-13', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 1', '9', 12500.00, ''),
(230, 'Teacher', '2024-11-24', 'Bukidnon', 'Manolo Fortich', 'tankulan', ' Purok 5', '213', 243.00, ''),
(231, 'user', '2024-11-24', 'Bukidnon', 'Manolo Fortich', 'dalirig', ' Purok 5', '456', 12345.00, ''),
(232, 'user', '2024-11-24', 'Bukidnon', 'Manolo Fortich', 'mangima', ' Purok 5', '456', 12345.00, ''),
(233, 'user', '2024-11-24', 'Bukidnon', 'Manolo Fortich', 'dalirig', ' Purok 5', '456', 12345.00, ''),
(234, 'admin Bimbo', '2024-11-13', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 1', '9', 12500.00, ''),
(235, 'admin Bimbo', '2024-11-13', 'Bukidnon', 'Manolo Fortich', 'dalirig', 'Zone 1', '9', 12500.00, '');

-- --------------------------------------------------------

--
-- Table structure for table `members_tbl`
--

CREATE TABLE `members_tbl` (
  `member_id` int(11) NOT NULL,
  `record_id` int(11) DEFAULT NULL,
  `household_members` varchar(255) DEFAULT NULL,
  `relationship_to_head` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `civil_status` varchar(50) DEFAULT NULL,
  `person_with_disability` varchar(250) DEFAULT NULL,
  `ethnicity` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members_tbl`
--

INSERT INTO `members_tbl` (`member_id`, `record_id`, `household_members`, `relationship_to_head`, `birthdate`, `age`, `gender`, `civil_status`, `person_with_disability`, `ethnicity`, `religion`) VALUES
(223, 150, 'Albert F. Gonzaga', 'Head', '1980-12-06', 43, 'Male', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(224, 150, 'Matisty Delastrico', 'Spouse', '1982-01-13', 42, 'Female', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(225, 150, 'Gonzaga, John Eubert Banay', 'Son', '2000-01-01', 24, 'Male', 'Single', 'None', 'Cebuano', 'Roman Catholic'),
(227, 151, 'Loregen Sural', 'Spouse', '1977-12-03', 46, 'Female', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(229, 152, 'Diosdado, Alimbog', 'Head', '1978-10-12', 46, 'Male', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(230, 152, 'Juvelin Alimbog', 'Spouse', '1988-12-12', 35, 'Male', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(231, 152, 'Jake Alimbog', 'Son', '2001-03-12', 23, 'Male', 'Single', 'None', 'Cebuano', 'Roman Catholic'),
(232, 153, 'Jerry Lumala', 'Head', '1980-12-23', 43, 'Male', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(233, 153, 'Hermilyna Camat', 'Spouse', '1989-03-04', 35, 'Female', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(235, 154, 'Jerry Lumala', 'Head', '1980-12-23', 43, 'Male', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(236, 154, 'Hermilyna Camat', 'Spouse', '1981-12-31', 42, 'Female', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(237, 154, 'Pauleen V. Camat', 'Daughter', '2000-01-13', 24, 'Female', 'Single', 'None', 'Cebuano', 'Roman Catholic'),
(238, 155, 'N/A', 'Head', '1987-12-23', 36, 'Male', 'Single', 'None', 'Cebuano', 'Roman Catholic'),
(239, 155, 'Vanessa Paculba Bernados', 'Spouse', '1977-01-07', 47, 'Female', 'Single', 'None', 'Cebuano', 'Roman Catholic'),
(240, 155, 'Nathanile P. Bernados', 'Son', '2002-02-12', 22, 'Male', 'Single', 'None', 'Cebuano', 'Roman Catholic'),
(241, 156, 'Jenard Sumanghid', 'Head', '1980-12-31', 43, 'Male', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(242, 156, 'Charyl Mae Dalmento', 'Spouse', '1989-03-21', 35, 'Female', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(244, 157, 'Jordan Guino-ay ', 'Head', '1977-03-04', 47, 'Male', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(245, 157, 'Saralyn Guinoay', 'Spouse', '1989-02-11', 35, 'Female', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(246, 157, 'Rengean Y. Yacapen', 'Daughter', '2000-12-20', 23, 'Male', 'Single', 'None', 'Cebuano', 'Roman Catholic'),
(249, 158, 'Marane Jaysel Jnae N.', 'Daughter', '2000-12-07', 23, 'Female', 'Single', 'None', 'Cebuano', 'Roman Catholic'),
(251, 159, 'Lucy Benruhan Neri', 'Spouse', '1983-07-09', 41, 'Female', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(253, 160, 'Johnny A. Alahaya', 'Head', '1987-12-04', 36, 'Male', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(254, 160, 'Norie Jnae A. Briones', 'Spouse', '1977-12-03', 46, 'Female', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(255, 160, 'Tampipi Jhonrey Briones ', 'Son', '2001-02-01', 23, 'Male', 'Single', 'None', 'Bukidnon', 'Roman Catholic'),
(260, 162, 'Melvin S. Aguilar', 'Head', '1977-02-03', 47, 'Male', 'Married', 'Yes', 'Cebuano', 'Roman Catholic'),
(261, 162, 'Marlyn M. Aguilar', 'Spouse', '1984-03-17', 40, 'Female', 'Married', 'Yes', 'Cebuano', 'Roman Catholic'),
(262, 162, 'Melody L. Aguilar ', 'Daughter', '2008-06-23', 16, 'Female', 'Single', 'Yes', 'Cebuano', 'Roman Catholic'),
(263, 162, 'Mariel L. Aguilar', 'Daughter', '2001-12-30', 22, 'Female', 'Single', 'Yes', 'Cebuano', 'Roman Catholic'),
(264, 162, 'James L. Aguilar', 'Son', '2004-09-27', 20, 'Male', 'Single', 'Yes', 'Cebuano', 'Roman Catholic'),
(266, 163, 'Ariel Sayagnon', 'Head', '1967-09-09', 57, 'Male', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(267, 163, 'Grace Sayagnon', 'Spouse', '1965-05-31', 59, 'Female', 'Married', 'Physically Impaired', 'Cebuano', 'Roman Catholic'),
(268, 163, 'Mariel Sayagnon', 'Daughter', '2000-11-28', 23, 'Female', 'Single', 'None', 'Cebuano', 'Roman Catholic'),
(269, 163, 'Neil Sayagnon', 'Son', '2002-04-02', 22, 'Male', 'Single', 'Partially Hearing Impaired', 'Cebuano', 'Roman Catholic'),
(270, 163, 'Jojo Sayagnon', 'Son', '2008-02-08', 16, 'Male', 'Single', 'Partially Visually Impaired', 'Cebuano', 'Roman Catholic'),
(273, 165, 'CristineA.  Balandra', 'Spouse', '1967-02-05', 57, 'Female', 'Married', 'Partially Hearing Impaired', 'Cebuano', 'Roman Catholic'),
(275, 165, 'Joyce Mae A. Balandra', 'Daughter', '2006-08-04', 18, 'Female', 'Single', 'Totally Visually Impaired', 'Cebuano', 'Roman Catholic'),
(276, 165, 'Faith A. Balandra', 'Daughter', '2004-07-09', 20, 'Female', 'Single', 'None', 'Cebuano', 'Roman Catholic'),
(277, 166, 'Alberto Cupas', 'Head', '1965-07-25', 59, 'Male', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(278, 166, 'Lan Bayson Cupas', 'Spouse', '1977-08-12', 47, 'Female', 'Married', 'Totally Visually Impaired', 'Cebuano', 'Roman Catholic'),
(279, 166, 'Vicente Bayson Cupas', 'Son', '2007-12-08', 16, 'Male', 'Single', 'Partially Hearing Impaired', 'Cebuano', 'Roman Catholic'),
(280, 166, 'shaira mae Bayson Cupas ', 'Daughter', '2009-01-18', 15, 'Female', 'Single', 'Partially Visually Impaired', 'Cebuano', 'Roman Catholic'),
(281, 167, 'Alburo, Marcilita Pongautan', 'Spouse', '1971-02-12', 53, 'Female', 'Separated', 'None', 'Bukidnon', 'Roman Catholic'),
(282, 167, 'Alburo,Aljereco ', 'Son', '2008-02-22', 16, 'Male', 'Single', 'None', 'Bukidnon', 'Roman Catholic'),
(283, 168, 'Jerwin Mancawan', 'Head', '1978-03-09', 46, 'Male', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(284, 168, 'Gina Mancawan', 'Spouse', '1978-09-02', 46, 'Female', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(285, 168, 'Rephedim Mancawan ', 'Son', '2007-08-23', 17, 'Male', 'Single', 'Totally Visually Impaired', 'Cebuano', 'Roman Catholic'),
(286, 168, 'Jane Mancawan', 'Daughter', '2005-01-25', 19, 'Female', 'Single', 'Totally Hearing Impaired', 'Cebuano', 'Roman Catholic'),
(287, 168, 'Hazel Mancawan', 'Daughter', '2007-12-08', 16, 'Female', 'Single', 'W/ Special Needs', 'Cebuano', 'Roman Catholic'),
(288, 169, 'Mendez, Jerodias  V. ', 'Head', '1986-06-23', 38, 'Male', 'Married', 'None', 'Bukidnon', 'Roman Catholic'),
(289, 169, 'Mendez, Rosalina  S. ', 'Spouse', '1984-04-26', 40, 'Female', 'Married', 'None', 'Bukidnon', 'Roman Catholic'),
(290, 169, 'Mendez, Razzel S. ', 'Son', '2006-04-06', 18, 'Male', 'Single', 'None', 'Bukidnon', 'Roman Catholic'),
(291, 170, 'Ivy Joy Sanipa', 'Daughter', '2005-01-04', 19, 'Female', 'Single', 'None', 'Cebuano', 'Roman Catholic'),
(292, 170, 'Alfredo Sanipa', 'Head', '1969-08-13', 55, 'Male', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(293, 170, 'Adelaida Sanipa', 'Spouse', '1979-11-26', 44, 'Female', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(294, 171, 'Andilan, Mayaline', 'Spouse', '1971-02-15', 53, 'Female', 'Single', 'None', 'Higa-onon', 'Roman Catholic'),
(295, 171, 'Andilan, Ksthy', 'Daughter', '2007-10-04', 17, 'Female', 'Single', 'None', 'Higa-onon', 'Roman Catholic'),
(296, 172, ' Bienvenido M. Pagadura', 'Head', '1964-12-19', 59, 'Male', 'Married', 'Yes', 'Ilonggo', 'Roman Catholic'),
(297, 172, ' PAGADURA, MARY CHEL', 'Spouse', '1971-07-09', 53, 'Female', 'Married', 'Yes', 'Cebuano', 'Roman Catholic'),
(298, 172, 'PAGADURA, JANREY VEN K', 'Son', '2007-12-09', 16, 'Male', 'Single', 'Yes', 'Ilonggo', 'Roman Catholic'),
(299, 173, 'Yonson, Ricky S.', 'Head', '1993-01-28', 31, 'Male', 'Married', 'None', 'Higa-onon', 'Roman Catholic'),
(300, 173, 'Yonson, Maria Luz', 'Spouse', '1994-03-16', 30, 'Female', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(301, 173, 'Yonson, Precious ', 'Daughter', '2007-10-24', 17, 'Female', 'Single', 'None', 'Higa-onon', 'Roman Catholic'),
(302, 174, 'Gat Ganol', 'Head', '1979-03-21', 45, 'Male', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(303, 174, 'Anie Ganol', 'Spouse', '1981-11-28', 42, 'Female', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(304, 174, 'Joshua Ganol', 'Son', '2004-09-27', 20, 'Male', 'Single', 'None', 'Cebuano', 'Roman Catholic'),
(305, 175, 'Pacifico B. Ocday', 'Head', '1964-08-08', 60, 'Male', 'Married', 'None', 'Bukidnon', 'Baptist'),
(306, 175, 'Ruby A. Ocday', 'Spouse', '1972-09-07', 52, 'Female', 'Married', 'None', 'Bukidnon', 'Baptist'),
(307, 175, 'Cyrine A. Ocday', 'Daughter', '2000-07-30', 24, 'Female', 'Single', 'None', 'Bukidnon', 'Baptist'),
(308, 176, 'Melecio Pacaldo', 'Head', '1967-01-06', 57, 'Male', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(309, 176, 'Ronita Pacaldo', 'Spouse', '1969-03-21', 55, 'Female', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(310, 176, 'Rommel Pacaldo', 'Son', '1999-08-12', 25, 'Male', 'Single', 'W/ Special Needs', 'Cebuano', 'Roman Catholic'),
(311, 176, 'Jemwell Pacaldo', 'Son', '2002-07-21', 22, 'Male', 'Single', 'Totally Hearing Impaired', 'Cebuano', 'Roman Catholic'),
(314, 179, 'Ernesto Abroguena ', 'Head', '1967-10-23', 57, 'Male', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(315, 179, 'Jasmine Abroguena', 'Spouse', '1965-12-12', 58, 'Female', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(316, 179, 'Lord Ernesto Abroguena', 'Son', '2007-09-23', 17, 'Male', 'Single', 'Totally Visually Impaired', 'Cebuano', 'Roman Catholic'),
(317, 179, 'jenna Abroguena', 'Daughter', '2001-03-04', 23, 'Female', 'Single', 'Partially Visually Impaired', 'Cebuano', 'Roman Catholic'),
(318, 179, 'karl Abroguena', 'Son', '2006-02-05', 18, 'Male', 'Single', 'None', 'Cebuano', 'Roman Catholic'),
(319, 180, 'Juan Bercede', 'Head', '1956-02-05', 68, 'Male', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(320, 180, 'Jhona Bercede', 'Spouse', '1959-12-04', 64, 'Female', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(321, 180, 'Soy-Soy Bercede', 'Son', '2005-12-08', 18, 'Male', 'Single', 'Totally Visually Impaired', 'Cebuano', 'Roman Catholic'),
(322, 180, 'Samuel Bercede', 'Son', '1999-12-02', 24, 'Male', 'Single', 'Partially Hearing Impaired', 'Cebuano', 'Roman Catholic'),
(323, 180, 'lara Bercede', 'Daughter', '2007-12-24', 16, 'Female', 'Single', 'None', 'Cebuano', 'Roman Catholic'),
(324, 180, 'Mara Bercede', 'Daughter', '2004-12-05', 19, 'Female', 'Single', 'None', 'Cebuano', 'Roman Catholic'),
(325, 181, 'Juan Bercede', 'Head', '1956-02-05', 68, 'Male', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(326, 181, 'Jhona Bercede', 'Spouse', '1959-12-04', 64, 'Female', 'Married', 'None', 'Cebuano', 'Roman Catholic'),
(327, 181, 'Soy-Soy Bercede', 'Son', '2005-12-08', 18, 'Male', 'Single', 'Totally Visually Impaired', 'Cebuano', 'Roman Catholic'),
(328, 181, 'Samuel Bercede', 'Son', '1999-12-02', 24, 'Male', 'Single', 'Partially Hearing Impaired', 'Cebuano', 'Roman Catholic'),
(329, 181, 'lara Bercede', 'Daughter', '2007-12-24', 16, 'Female', 'Single', 'None', 'Cebuano', 'Roman Catholic'),
(330, 181, 'Mara Bercede', 'Daughter', '2004-12-05', 19, 'Female', 'Single', 'None', 'Cebuano', 'Roman Catholic'),
(331, 182, 'Alburo, Marcilita Pongautan', 'Mother', '1975-08-06', 49, 'Female', 'Married', 'N/A', 'Bukidnon', 'Roman Catholic'),
(332, 183, 'Alburo,Aljereco', 'Son', '2008-02-02', 16, 'Male', 'Single', 'N/A', 'Bukidnon', 'Roman Catholic'),
(333, 184, 'Salait, Raquiza Buna ', 'Mother', '1971-07-09', 53, 'Female', 'Married', 'N/A', 'Cebuano', 'Roman Catholic'),
(334, 185, 'Salait, Ricoyan', 'Son', '2002-02-07', 22, 'Male', 'Single', 'N/A', 'Cebuano', 'Roman Catholic'),
(335, 186, 'Montero, Michael Evangelista	', 'Head', '1962-02-26', 62, 'Male', 'Married', 'None', 'Tagalog', 'Roman Catholic'),
(336, 187, 'Marjalino, Mirasol Ponce	', 'Mother', '1971-07-12', 53, 'Female', 'Married', 'None', 'tagalog', 'Roman Catholic'),
(337, 188, 'Montero, Ivan Marjalino', 'Son', '2009-10-06', 15, 'Male', 'Single', 'None', 'Tagalog', 'Roman Catholic'),
(338, 189, 'Mark Tahimik', 'Father', '1989-09-09', 35, 'Male', 'Married', 'None', 'Boholano', 'Roman Catholic'),
(339, 190, 'Angela Tahimik', 'Mother', '1990-08-05', 34, 'Female', 'Married', 'None', 'Boholano', 'Roman Catholic'),
(340, 191, 'Jake Tahimik', 'Son', '2005-05-06', 19, 'Male', 'Single', 'None', 'Boholano', 'Roman Catholic'),
(352, 230, 'Jaylah Binayao', 'Daughter', '2001-03-11', 23, 'Female', 'Single', 'None', 'Bukidnon', 'Roman Catholic'),
(353, 231, 'Jessa Abarquez', 'Daughter', '2001-02-03', 23, 'Female', 'Single', 'Yes', 'Boholano', 'Roman Catholic');

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
(156, 2, 'admin Bimbo', '2024-10-05 11:36:10', '2024-10-05 17:36:33'),
(157, 2, 'admin Bimbo', '2024-10-05 11:36:49', '2024-10-05 23:20:03'),
(159, 2, 'admin Bimbo', '2024-10-05 17:28:37', '2024-10-05 23:32:50'),
(160, 2, 'admin Bimbo', '2024-10-05 17:33:01', NULL),
(161, 2, 'admin Bimbo', '2024-10-05 17:33:18', '2024-10-05 23:33:46'),
(162, 2, 'admin Bimbo', '2024-10-05 17:33:55', NULL),
(163, 2, 'admin Bimbo', '2024-10-06 12:12:06', '2024-10-06 18:27:24'),
(165, 2, 'admin Bimbo', '2024-10-06 12:28:27', NULL),
(166, 2, 'admin Bimbo', '2024-10-08 03:59:13', '2024-10-08 11:54:45'),
(168, 2, 'admin Bimbo', '2024-10-08 05:56:58', NULL),
(171, 2, 'admin Bimbo', '2024-10-08 14:17:56', '2024-10-08 20:18:03'),
(176, 42, 'teacher', '2024-10-08 15:23:01', '2024-10-08 21:25:51'),
(177, 42, 'teacher', '2024-10-08 15:26:03', NULL),
(178, 42, 'teacher', '2024-10-08 15:26:48', '2024-10-08 21:32:26'),
(179, 2, 'admin Bimbo', '2024-10-08 15:30:56', NULL),
(181, 51, 'user', '2024-10-08 15:34:31', NULL),
(187, 42, 'teacher', '2024-10-09 00:40:14', NULL),
(188, 2, 'admin Bimbo', '2024-10-10 07:11:25', NULL),
(189, 2, 'admin Bimbo', '2024-10-12 08:47:59', '2024-10-12 16:34:49'),
(190, 2, 'admin Bimbo', '2024-10-12 10:35:01', NULL),
(191, 2, 'admin Bimbo', '2024-10-12 10:36:35', NULL),
(192, 2, 'admin Bimbo', '2024-10-13 14:32:00', '2024-10-14 00:12:45'),
(193, 54, 'head', '2024-10-13 17:45:11', '2024-10-13 23:51:25'),
(194, 54, 'head', '2024-10-13 17:51:35', '2024-10-13 23:53:16'),
(195, 2, 'admin Bimbo', '2024-10-13 17:53:29', '2024-10-14 00:01:23'),
(196, 54, 'head', '2024-10-13 18:01:31', NULL),
(197, 2, 'admin Bimbo', '2024-10-13 18:12:48', '2024-10-14 03:19:11'),
(198, 54, 'head', '2024-10-13 21:19:16', '2024-10-14 03:22:30'),
(199, 2, 'admin Bimbo', '2024-10-13 21:22:33', '2024-10-14 03:23:32'),
(200, 54, 'head', '2024-10-13 21:23:35', '2024-10-14 03:43:19'),
(201, 54, 'head', '2024-10-13 21:43:23', NULL),
(202, 54, 'head', '2024-10-14 01:18:05', NULL),
(203, 42, 'teacher', '2024-10-14 01:18:44', '2024-10-14 07:18:50'),
(204, 54, 'head', '2024-10-14 01:18:54', '2024-10-14 07:19:18'),
(205, 2, 'admin Bimbo', '2024-10-14 01:19:28', NULL),
(206, 54, 'head', '2024-10-14 01:31:07', '2024-10-14 08:59:26'),
(207, 54, 'head', '2024-10-14 01:42:28', '2024-10-14 08:58:14'),
(208, 2, 'admin Bimbo', '2024-10-14 02:59:31', '2024-10-14 09:01:40'),
(209, 51, 'user', '2024-10-14 03:00:04', '2024-10-14 09:00:57'),
(210, 51, 'user', '2024-10-14 03:01:05', NULL),
(211, 54, 'head', '2024-10-14 03:01:46', NULL),
(212, 51, 'user', '2024-10-14 03:03:24', '2024-10-14 09:04:48'),
(213, 2, 'admin Bimbo', '2024-10-14 03:04:06', NULL),
(214, 51, 'user', '2024-10-14 03:04:55', NULL),
(215, 2, 'admin Bimbo', '2024-10-14 14:26:48', NULL),
(216, 2, 'admin Bimbo', '2024-10-14 15:30:50', NULL),
(217, 2, 'admin Bimbo', '2024-10-15 02:19:01', '2024-10-15 11:40:23'),
(218, 2, 'admin Bimbo', '2024-10-15 02:36:48', '2024-10-15 09:05:10'),
(219, 54, 'head', '2024-10-15 03:05:30', '2024-10-15 09:05:48'),
(220, 54, 'head', '2024-10-15 03:05:56', '2024-10-15 12:04:14'),
(221, 54, 'head', '2024-10-15 05:40:29', '2024-10-15 11:54:19'),
(222, 2, 'admin Bimbo', '2024-10-15 05:54:22', '2024-10-15 12:05:20'),
(223, 54, 'head', '2024-10-15 06:04:22', NULL),
(224, 54, 'head', '2024-10-15 06:05:25', '2024-10-15 12:08:55'),
(225, 54, 'head', '2024-10-15 06:09:02', '2024-10-15 12:11:32'),
(226, 54, 'head', '2024-10-15 06:11:38', '2024-10-15 12:14:10'),
(227, 2, 'admin Bimbo', '2024-10-15 06:14:14', '2024-10-15 12:14:19'),
(228, 51, 'user', '2024-10-15 06:14:25', NULL),
(229, 51, 'user', '2024-10-15 06:16:54', '2024-10-15 12:17:30'),
(230, 54, 'head', '2024-10-15 06:17:53', NULL),
(231, 2, 'admin Bimbo', '2024-10-16 08:22:57', NULL),
(232, 2, 'admin Bimbo', '2024-10-17 15:03:08', NULL),
(233, 2, 'admin Bimbo', '2024-10-17 15:37:35', '2024-10-17 22:17:44'),
(234, 54, 'head', '2024-10-17 16:17:52', '2024-10-17 22:18:24'),
(235, 54, 'head', '2024-10-17 16:18:37', '2024-10-17 22:21:12'),
(237, 54, 'head', '2024-10-18 06:41:54', '2024-10-18 12:42:56'),
(240, 2, 'admin Bimbo', '2024-10-18 07:24:40', NULL),
(242, 42, 'teacher', '2024-10-18 09:31:09', '2024-10-18 15:39:06'),
(244, 42, 'teacher', '2024-10-18 09:58:02', '2024-10-18 16:52:21'),
(245, 2, 'admin Bimbo', '2024-10-23 04:46:00', NULL),
(246, 2, 'admin Bimbo', '2024-10-23 06:38:41', NULL),
(247, 2, 'admin Bimbo', '2024-10-23 09:21:02', NULL),
(248, 2, 'admin Bimbo', '2024-10-23 09:21:41', '2024-10-23 21:45:19'),
(249, 54, 'head', '2024-10-23 15:45:26', '2024-10-23 21:48:42'),
(250, 42, 'teacher', '2024-10-23 15:48:50', '2024-10-23 22:07:55'),
(251, 42, 'teacher', '2024-10-23 16:08:03', '2024-10-23 22:26:15'),
(252, 2, 'admin Bimbo', '2024-10-23 16:26:27', '2024-10-23 22:27:13'),
(253, 54, 'head', '2024-10-23 16:27:20', '2024-10-23 22:29:08'),
(254, 42, 'teacher', '2024-10-23 16:29:18', NULL),
(255, 42, 'teacher', '2024-10-24 08:46:00', '2024-10-24 14:51:21'),
(256, 2, 'admin Bimbo', '2024-10-24 08:51:35', NULL),
(257, 2, 'admin Bimbo', '2024-10-24 08:51:35', NULL),
(258, 2, 'admin Bimbo', '2024-10-25 09:14:33', NULL),
(259, 2, 'admin Bimbo', '2024-10-27 07:12:03', '2024-10-27 14:14:29'),
(260, 2, 'admin Bimbo', '2024-10-27 07:23:25', '2024-10-27 14:23:59'),
(261, 2, 'admin Bimbo', '2024-10-27 07:24:40', NULL),
(262, 2, 'admin Bimbo', '2024-10-27 12:21:37', NULL),
(263, 2, 'admin Bimbo', '2024-11-01 15:04:02', NULL),
(264, 54, 'head', '2024-11-01 15:17:09', '2024-11-01 22:58:04'),
(265, 2, 'admin Bimbo', '2024-11-01 15:58:09', '2024-11-01 23:43:25'),
(266, 54, 'head', '2024-11-01 16:43:32', NULL),
(267, 2, 'admin Bimbo', '2024-11-04 06:51:25', '2024-11-04 13:59:28'),
(268, 42, 'teacher', '2024-11-04 06:59:46', NULL),
(269, 42, 'teacher', '2024-11-04 14:48:24', NULL),
(270, 42, 'teacher', '2024-11-04 17:59:42', '2024-11-05 04:20:18'),
(271, 42, 'teacher', '2024-11-04 19:39:49', '2024-11-05 03:06:33'),
(272, 54, 'head', '2024-11-04 20:06:43', '2024-11-05 03:21:03'),
(273, 2, 'admin Bimbo', '2024-11-04 20:21:33', NULL),
(274, 54, 'head', '2024-11-04 20:32:28', NULL),
(275, 2, 'admin Bimbo', '2024-11-04 21:20:25', '2024-11-05 04:29:07'),
(276, 54, 'head', '2024-11-04 21:29:14', '2024-11-05 04:29:59'),
(277, 54, 'head', '2024-11-04 21:30:27', '2024-11-05 04:30:56'),
(278, 54, 'head', '2024-11-04 21:33:07', '2024-11-05 04:33:43'),
(280, 54, 'head', '2024-11-04 21:41:56', '2024-11-05 04:57:52'),
(281, 2, 'admin Bimbo', '2024-11-04 21:57:57', NULL),
(282, 54, 'head', '2024-11-04 21:59:44', NULL),
(283, 2, 'admin Bimbo', '2024-11-05 01:25:37', '2024-11-05 08:39:47'),
(284, 54, 'head', '2024-11-05 01:39:59', '2024-11-05 09:04:08'),
(285, 42, 'teacher', '2024-11-05 02:04:22', NULL),
(286, 2, 'admin Bimbo', '2024-11-05 02:37:28', '2024-11-05 10:04:43'),
(287, 42, 'teacher', '2024-11-05 03:05:17', '2024-11-05 10:08:11'),
(288, 42, 'Teacher', '2024-11-05 03:08:33', '2024-11-05 10:10:17'),
(289, 54, 'head', '2024-11-05 03:10:34', '2024-11-05 10:13:23'),
(290, 66, 'BIMBO', '2024-11-05 03:13:45', '2024-11-05 10:14:35'),
(291, 54, 'head', '2024-11-05 03:16:28', '2024-11-05 10:26:23'),
(292, 2, 'admin Bimbo', '2024-11-05 03:17:11', NULL),
(293, 2, 'admin Bimbo', '2024-11-05 03:26:41', NULL),
(294, 54, 'head', '2024-11-05 04:59:09', NULL),
(295, 2, 'admin Bimbo', '2024-11-05 07:03:31', '2024-11-05 14:12:42'),
(296, 54, 'head', '2024-11-05 07:13:34', '2024-11-05 14:14:48'),
(297, 42, 'Teacher', '2024-11-05 07:15:24', NULL),
(298, 2, 'admin Bimbo', '2024-11-08 07:21:40', NULL),
(299, 2, 'admin Bimbo', '2024-11-09 11:56:25', NULL),
(300, 2, 'admin Bimbo', '2024-11-13 15:16:09', NULL),
(301, 2, 'admin Bimbo', '2024-11-13 15:38:01', NULL),
(302, 2, 'admin Bimbo', '2024-11-13 22:42:33', '2024-11-14 06:21:14'),
(303, 54, 'head', '2024-11-13 23:21:25', '2024-11-14 07:27:31'),
(304, 2, 'admin Bimbo', '2024-11-14 00:28:30', '2024-11-14 07:31:00'),
(305, 79, 'Jessa', '2024-11-14 00:34:24', NULL),
(306, 2, 'admin Bimbo', '2024-11-13 20:50:21', NULL),
(307, 2, 'admin Bimbo', '2024-11-13 21:53:17', '2024-11-13 19:21:54'),
(308, 80, 'Jaylah Binayao', '2024-11-13 22:18:37', '2024-11-13 20:34:02'),
(309, 81, 'Evelyn Secuya', '2024-11-13 22:22:14', NULL),
(310, 2, 'admin Bimbo', '2024-11-13 23:18:24', NULL),
(311, 2, 'admin Bimbo', '2024-11-13 23:34:55', NULL),
(312, 2, 'admin Bimbo', '2024-11-14 04:28:16', '2024-11-14 02:30:27'),
(313, 2, 'admin Bimbo', '2024-11-14 09:00:17', '2024-11-14 06:03:53'),
(314, 82, 'lalay', '2024-11-14 09:04:48', '2024-11-14 07:22:57'),
(315, 2, 'admin Bimbo', '2024-11-14 10:23:26', '2024-11-15 00:54:25'),
(316, 54, 'head', '2024-11-14 17:54:32', NULL),
(317, 2, 'admin Bimbo', '2024-11-14 22:15:51', NULL),
(318, 2, 'admin Bimbo', '2024-11-14 23:08:49', '2024-11-15 06:10:14'),
(319, 79, 'Jessa', '2024-11-14 23:11:40', NULL),
(320, 2, 'admin Bimbo', '2024-11-15 01:46:04', '2024-11-15 09:27:28'),
(321, 54, 'head', '2024-11-15 01:49:59', '2024-11-15 08:50:14'),
(322, 54, 'head', '2024-11-15 01:52:41', '2024-11-15 08:53:17'),
(323, 54, 'head', '2024-11-15 01:53:27', NULL),
(324, 54, 'head', '2024-11-15 02:27:54', '2024-11-15 09:31:42'),
(325, 2, 'admin Bimbo', '2024-11-15 02:33:03', '2024-11-15 09:33:23'),
(326, 79, 'Jessa', '2024-11-15 02:33:30', '2024-11-15 09:38:38'),
(327, 2, 'admin Bimbo', '2024-11-15 02:41:57', '2024-11-15 10:04:02'),
(328, 2, 'admin Bimbo', '2024-11-15 03:04:54', NULL),
(329, 2, 'admin Bimbo', '2024-11-22 08:22:41', '2024-11-22 15:35:48'),
(330, 54, 'head', '2024-11-22 08:35:54', '2024-11-23 03:44:57'),
(331, 2, 'admin Bimbo', '2024-11-22 08:55:17', NULL),
(332, 51, 'user', '2024-11-22 09:15:11', '2024-11-22 16:15:20'),
(333, 79, 'Jessa', '2024-11-22 09:17:28', NULL),
(334, 79, 'Jessa', '2024-11-22 10:17:50', NULL),
(335, 79, NULL, '2024-11-22 20:45:08', NULL),
(336, 79, NULL, '2024-11-22 20:45:19', NULL),
(337, 79, NULL, '2024-11-22 20:45:45', NULL),
(338, 79, NULL, '2024-11-22 20:46:29', NULL),
(339, 79, NULL, '2024-11-22 20:46:57', NULL),
(340, 79, NULL, '2024-11-22 20:47:14', NULL),
(341, 2, NULL, '2024-11-22 20:47:29', '2024-11-23 03:47:33'),
(342, 79, NULL, '2024-11-22 20:48:04', NULL),
(343, 54, NULL, '2024-11-22 21:44:25', NULL),
(344, 79, NULL, '2024-11-22 21:53:06', NULL),
(345, 79, 'Jessa', '2024-11-22 21:53:48', NULL),
(346, 79, 'Jessa', '2024-11-24 17:20:42', '2024-11-25 02:24:10'),
(347, 54, 'head', '2024-11-24 17:24:05', '2024-11-25 02:12:31'),
(348, 2, 'admin Bimbo', '2024-11-24 18:17:24', NULL),
(349, 42, 'Teacher', '2024-11-24 18:18:28', '2024-11-25 01:20:46'),
(350, 51, 'user', '2024-11-24 18:20:54', '2024-11-25 01:22:17'),
(351, 61, 'coordinator', '2024-11-24 18:23:31', '2024-11-25 01:23:40'),
(352, 82, 'lalay', '2024-11-24 18:25:08', '2024-11-25 01:26:13'),
(353, 51, 'user', '2024-11-24 18:26:26', NULL),
(354, 2, 'admin Bimbo', '2024-11-24 19:12:36', NULL),
(355, 54, 'head', '2024-11-24 19:24:17', NULL),
(356, 79, 'Jessa', '2024-11-24 19:29:41', NULL),
(357, 2, 'admin Bimbo', '2024-11-25 08:06:39', NULL),
(358, 2, 'admin Bimbo', '2024-11-28 17:30:49', NULL),
(359, 2, 'admin Bimbo', '2024-12-21 11:06:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `user_id` int(11) NOT NULL,
  `id_number` int(12) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `district` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`user_id`, `id_number`, `user_name`, `email`, `phone_number`, `pass`, `district`, `user_type`, `status`) VALUES
(2, 20201259, 'admin Bimbo', 'admin@gmail.com', '0556282485', '$2y$10$TWyAZbbDQcms2lAoXPvqzOsotVJHvS/Cc9Ef5gi1MxrnXIhMqEHQm', '1', 'supervisor', ''),
(42, 20201259, 'Teacher', 'teacher@gmail.com', '0', '$2y$10$fSy0.UXmf0caJjNZT2I/MOj4yWApbWGuGFYu986fDvNFAsnQFLucm', 'District 2', 'Implementer', 'enable'),
(51, 20201259, 'user', 'user@gmail.com', '09123456789', '$2y$10$t5s1OamaFxb/lfKweuNyQeNYAUo/GOXgxDapPsMdj2LNqFv3ZMa22', 'District 4', 'Implementer', 'enable'),
(53, 20201259, 'admin Bimbo', 'bimbo@gmail.com', '09999999999', '$2y$10$zF0Odp6OP26PXE.jzDHqdOJ625TNUjWS72yk8gXrlvaqvxFPgTK7W', 'District 1', 'Supervisor', ''),
(54, 20201259, 'head', 'head@gmail.com', '09999999999', '$2y$10$GSs8oNclWUeOBJ7iWWEw0ud..gK280MMpebi7WFt.uwdrrv.7PneO', 'District 4', 'Coordinator', ''),
(61, 20201259, 'coordinator', 'villaganasbimbo123@gmail.com', '09123456789', '$2y$10$GFq61ulnZjNdHtz2GHft5eaUVc1cA2XpmCpmmzrD.MhMsYUeyYVOG', 'District 4', 'Coordinator', ''),
(66, 20201259, 'BIMBO', 'villaganasbimbo123@gmail.com', '09123456789', '$2y$10$KYj4K3Jp5Dzr.hDV0ROoS.HRL4g7xP9jWuyxncqYLWG884Fz0UjOm', 'District 1', 'Coordinator', ''),
(74, 20201259, 'ako', 'bimbo@gmail.com', '09999999999', '$2y$10$kqy6y5pXXkPVkrcd6GKaOu6R9oUE2duy1xQNPCvLsYmgUWoaEmGLm', 'District 4', 'Volunteer', ''),
(75, 20201259, 'ako', 'villaganasbimbo123@gmail.com', '09123456789', '$2y$10$pknYoNr90SkUH0roWZ7VJ.sGDVdNbvU1WuEe9v3AguRIEztyEbg4C', 'District 1', 'Volunteer', ''),
(78, 20201259, 'BIMBO', 'villaganasbimbo123@gmail.com', '09123456789', '$2y$10$6x21rbpXSzLYCKwk31fdeus9feHrQsKnYwGBG73bkmaSiLtO3yW2G', 'District 1', 'Implementer', 'enable'),
(79, 20211629, 'Jessa', '20211629@nbsc.edu.ph', '09350147772', '$2y$10$m1dqhzG9R9kEVlG9Fk2gIe5Ood.L7UE.HrRxduvAcKBERA5Dbj0ma', 'District 4', 'Implementer', 'enable'),
(80, 20201299, 'Jaylah Binayao', 'jaylahbinayao@gmail.com', '09658517377', '$2y$10$WfJtETOOW3MfdHmYpGrM0e2DAKrUNXMSvSctsDpz4RhJPnGcNYuj.', 'District 1', 'Implementer', 'enable'),
(81, 20211476, 'Evelyn Secuya', 'secuyaevelyn@gmail.com', '09262377595', '$2y$10$W2u8KCGP4nx3uLLG85SrTOV8uUrKRhoO7xzORjlwOwiMNMQvbdH7q', 'District 3', 'Implementer', ''),
(82, 20211629, 'lalay', 'abarquezjessa34@gmail.com', '09350147772', '$2y$10$L2btX6JseZVXqmYHXDgGLeEJMPpVdtwU.9OPtCJn7y1qJlgnb9k5K', 'District 3', 'Implementer', ''),
(83, 20211629, 'lalay', 'abarquezjessa34@gmail.com', '09350147772', '$2y$10$lGoT9hi.Y1nA2S.8CGkyJesvkF8iZ0rah6YqfScNkiAIVqQr/xnxG', 'District 3', 'Implementer', ''),
(84, 20211629, 'lalay', 'abarquezjessa34@gmail.com', '09350147772', '$2y$10$GM66j0v.sdH3s9uVnPOLk.PwAQRzSUN89oz6DDJSOicW09nAVf1Ye', 'District 3', 'Implementer', ''),
(85, 20201299, 'Jessa Bakang', '20201299@gmail.com', '09658517377', '$2y$10$l0dnPNcrfsTjpu2so6tWSuLsenh.geQHOuP937ddcFjE6wkGj/dF2', 'District 1', 'Implementer', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `background_tbl`
--
ALTER TABLE `background_tbl`
  ADD PRIMARY KEY (`background_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `location_tbl`
--
ALTER TABLE `location_tbl`
  ADD PRIMARY KEY (`record_id`);

--
-- Indexes for table `members_tbl`
--
ALTER TABLE `members_tbl`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `record_id` (`record_id`);

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
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `background_tbl`
--
ALTER TABLE `background_tbl`
  MODIFY `background_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=373;

--
-- AUTO_INCREMENT for table `location_tbl`
--
ALTER TABLE `location_tbl`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- AUTO_INCREMENT for table `members_tbl`
--
ALTER TABLE `members_tbl`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=354;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=360;

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `background_tbl`
--
ALTER TABLE `background_tbl`
  ADD CONSTRAINT `background_tbl_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members_tbl` (`member_id`);

--
-- Constraints for table `members_tbl`
--
ALTER TABLE `members_tbl`
  ADD CONSTRAINT `members_tbl_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `location_tbl` (`record_id`);

--
-- Constraints for table `user_log`
--
ALTER TABLE `user_log`
  ADD CONSTRAINT `user_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_tbl` (`user_id`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `delete_old_archived_records` ON SCHEDULE EVERY 1 DAY STARTS '2024-11-22 17:08:28' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM archive_tbl WHERE deletion_timestamp < NOW() - INTERVAL 30 DAY$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
