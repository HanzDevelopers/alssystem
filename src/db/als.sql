-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2024 at 07:35 PM
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
(52, 52, 'Highschool Graduate', 'No', 'N/A', 'N/A', 'Yes', 'Yes', 'Operator in Rebisco', 'No'),
(53, 53, 'Highschool Graduate', 'No', 'N/A', 'N/A', 'Yes', 'No', 'N/A', 'No'),
(54, 54, 'Grade 2', 'Yes', 'Grade 3', 'N/A', 'Yes', 'No', 'N/A', 'No'),
(55, 55, 'Highschool Graduate', 'No', 'N/A', 'N/A', 'Yes', 'Yes', 'Operator in Rebisco', 'No'),
(56, 56, 'Highschool Graduate', 'No', 'N/A', 'N/A', 'Yes', 'No', 'N/A', 'No'),
(57, 57, 'Grade 2', 'Yes', 'Grade 3', 'N/A', 'Yes', 'No', 'N/A', 'No'),
(58, 58, 'Grade 2', 'No', 'N/A', 'N/A', 'Yes', 'No', 'N/A', 'No'),
(59, 59, 'Elementary Graduate', 'No', 'N/A', 'N/A', 'Yes', 'Yes', 'Utility', 'No'),
(60, 60, 'Grade 11', 'Yes', 'Grade 12', 'N/A', 'Yes', 'No', 'N/A', 'No'),
(61, 61, 'Grade 2', 'No', 'N/A', 'N/A', 'Yes', 'No', 'N/A', 'No'),
(62, 62, 'Elementary Graduate', 'No', 'N/A', 'N/A', 'Yes', 'Yes', 'Utility', 'No'),
(63, 63, 'Grade 11', 'Yes', 'Grade 12', 'N/A', 'Yes', 'No', 'N/A', 'No'),
(64, 64, 'Grade 3', 'No', 'N/A', 'N/A', 'Yes', 'Yes', 'Labor', 'No'),
(65, 65, 'Elementary Graduate', 'No', 'N/A', 'N/A', 'Yes', 'Yes', 'Housekeeper', 'No'),
(66, 66, 'Grade 11', 'Yes', 'Grade 12', 'N/A', 'Yes', 'No', 'N/A', 'No'),
(67, 67, 'Grade 3', 'No', 'N/A', 'N/A', 'Yes', 'Yes', 'Labor', 'No'),
(68, 68, 'Elementary Graduate', 'No', 'N/A', 'N/A', 'Yes', 'Yes', 'Housekeeper', 'No'),
(69, 69, 'Grade 11', 'Yes', 'Grade 12', 'N/A', 'Yes', 'No', 'N/A', 'No'),
(70, 70, 'Grade 8', 'No', 'N/A', 'N/A', 'Yes', 'No', 'N/A', 'No'),
(71, 71, 'ALS Grade 11', 'Yes', 'ALS Grade 12', 'N/A', 'Yes', 'No', 'N/A', 'Yes'),
(72, 72, 'Grade 3', 'Yes', 'Grade 4', 'N/A', 'Yes', 'No', 'N/A', 'No'),
(73, 73, 'Grade 8', 'No', 'N/A', 'N/A', 'Yes', 'No', 'N/A', 'No'),
(74, 74, 'ALS Grade 11', 'Yes', 'ALS Grade 12', 'N/A', 'Yes', 'No', 'N/A', 'Yes'),
(75, 75, 'Grade 3', 'Yes', 'Grade 4', 'N/A', 'Yes', 'No', 'N/A', 'No'),
(76, 76, 'College Grad', 'no', 'n/a', 'n/a', 'Yes', 'Police ', 'Police', 'No'),
(77, 77, '3rd Year College', 'Yes', '4th Year College ', 'n/a', 'Yes', 'Housewife', 'Housewife', 'No'),
(78, 78, 'Grade 9 ', 'No', 'Grade 10', 'Discrimination', 'Yes', 'N/A', 'N/A', 'Yes'),
(79, 79, 'College Grad', 'no', 'n/a', 'n/a', 'Yes', 'Police ', 'Police', 'No'),
(80, 80, '3rd Year College', 'Yes', '4th Year College ', 'n/a', 'Yes', 'Housewife', 'Housewife', 'No'),
(81, 81, 'Grade 9 ', 'No', 'Grade 10', 'Discrimination', 'Yes', 'N/A', 'N/A', 'Yes'),
(82, 82, 'Grade 10', 'Yes', 'Grade 11', 'Financial problem ', 'Yes', 'Maid', 'Maid', 'Yes'),
(83, 83, 'Grade 10', 'Yes', 'Grade 11', 'Financial problem ', 'Yes', 'Maid', 'Maid', 'Yes'),
(84, 84, 'Elementary Level', 'no', 'n/a', 'Family Problem', 'No', 'farmer', 'Farmer', 'Yes'),
(85, 85, 'Grade 8', 'no', 'n/a', 'family problem', 'Yes', 'N/A', 'N/A', 'Yes'),
(86, 86, 'Elementary Level', 'no', 'n/a', 'Family Problem', 'No', 'farmer', 'Farmer', 'Yes'),
(87, 87, 'Grade 8', 'no', 'n/a', 'family problem', 'Yes', 'N/A', 'N/A', 'Yes'),
(88, 88, 'Grade 9', 'Yes', 'Grade 10 ', 'Financial problem ', 'Yes', 'Construction ', 'Construction ', 'Yes'),
(89, 89, 'Grade 9', 'Yes', 'Grade 10 ', 'Financial problem ', 'Yes', 'Construction ', 'Construction ', 'Yes'),
(90, 90, 'Grade 11', 'No', 'Grade 12', 'Financial problem ', 'Yes', 'Construction ', 'Construction ', 'Yes'),
(91, 91, 'Grade 11', 'No', 'Grade 12', 'Financial problem ', 'Yes', 'Construction ', 'Construction ', 'Yes'),
(92, 92, 'Grade 6', 'No', 'n/a', 'family Problem', 'Yes', 'Laborer', 'Laborer', 'No'),
(93, 93, 'Grade 7', 'No', 'n/a', 'tirediness', 'yes', 'labandera', 'Labandera', 'Yes'),
(94, 94, 'Grade 11', 'No', 'n/a', 'n/a', 'Yes', 'N/A', 'N/A', 'No'),
(95, 95, 'Grade 9', 'No', 'n/a', 'tirediness', 'No', 'laborer', 'Laborer', 'No'),
(96, 96, 'Grade 6', 'No', 'n/a', 'family Problem', 'Yes', 'Laborer', 'Laborer', 'No'),
(97, 97, 'Grade 7', 'No', 'n/a', 'tirediness', 'yes', 'labandera', 'Labandera', 'Yes'),
(98, 98, 'Grade 11', 'No', 'n/a', 'n/a', 'Yes', 'N/A', 'N/A', 'No'),
(99, 99, 'Grade 9', 'No', 'n/a', 'tirediness', 'No', 'laborer', 'Laborer', 'No'),
(100, 100, 'Grade 10 ', 'No', 'Grade 11', 'Financial problem ', 'Yes', 'Regular', 'Factory worker ', 'Yes'),
(101, 101, 'Grade 10 ', 'No', 'Grade 11', 'Financial problem ', 'Yes', 'Regular', 'Factory worker ', 'Yes'),
(102, 102, 'Grade 11', 'No', 'Grade 12', 'Lack of transportation ', 'Yes', 'Job order', 'Utility ', 'Yes'),
(103, 103, 'Grade 11', 'No', 'Grade 12', 'Lack of transportation ', 'Yes', 'Job order', 'Utility ', 'Yes'),
(109, 109, 'College grad', 'No', 'N/A', 'N/A', 'Yes', 'Web developer', 'Front-end Developer', 'No'),
(110, 110, 'College grad', 'No', 'N/A', 'N/A', 'Yes', 'Engineer', 'Construction', 'No'),
(111, 111, '4th year college', 'No', 'N/A', 'N/A', 'Yes', 'N/A', 'N/A', 'Yes'),
(112, 112, '1st year college', 'Yes', '2nd year college', 'N/A', 'Yes', 'N/A', 'N/A', 'No'),
(113, 113, 'Grade 9', 'Yes', 'Grade 10', 'N/A', 'Yes', 'N/A', 'N/A', 'Yes');

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
(21, 'Evelyn', '2024-09-21', 'Bukidnon', 'Manolo Fortich', 'Tankulan', 'Mangima', '2314', 8000.00, ''),
(22, 'Evelyn', '2024-09-21', 'Bukidnon', 'Manolo Fortich', 'Tankulan', 'Mangima', '2314', 8000.00, ''),
(23, 'Evelyn', '2024-09-21', 'Bukidnon', 'Manolo Fortich', 'Alae', 'Zone 2', '2414', 10000.00, ''),
(24, 'Evelyn', '2024-09-21', 'Bukidnon', 'Manolo Fortich', 'Alae', 'Zone 2', '2414', 10000.00, ''),
(25, 'Evelyn', '2024-09-21', 'Bukidnon', 'Manolo Fortich', 'Dalirig', 'Sitio Mangima', '3457', 9000.00, ''),
(26, 'Evelyn', '2024-09-21', 'Bukidnon', 'Manolo Fortich', 'Dalirig', 'Sitio Mangima', '3457', 9000.00, ''),
(27, 'Evelyn', '2024-09-21', 'Bukidnon', 'Manolo Fortich', 'Mampayag', 'Zone 4', '4562', 8000.00, ''),
(28, 'Evelyn', '2024-09-21', 'Bukidnon', 'Manolo Fortich', 'Mampayag', 'Zone 4', '4562', 8000.00, ''),
(29, 'Jaylah', '2024-09-21', 'Bukidnon', 'Manolo Fortich', 'Maluko', 'Zone 3', '001', 21000.00, ''),
(30, 'Jaylah', '2024-09-21', 'Bukidnon', 'Manolo Fortich', 'Maluko', 'Zone 3', '001', 21000.00, ''),
(31, 'Jessa', '2024-09-21', 'Bukidnon ', 'Manolo fortich ', 'Dalirig ', 'Sitio mangima ', '2', 10000.00, ''),
(32, 'Jessa', '2024-09-21', 'Bukidnon ', 'Manolo fortich ', 'Dalirig ', 'Sitio mangima ', '2', 10000.00, ''),
(33, 'Jaylah', '2024-09-21', 'Bukidnon', 'Manolo Fortich', 'Dalirig', 'Purok 5', '1234', 15000.00, ''),
(34, 'Jaylah', '2024-09-21', 'Bukidnon', 'Manolo Fortich', 'Dalirig', 'Purok 5', '1234', 15000.00, ''),
(35, 'Jessa', '2024-09-21', 'Bukidnon ', 'Manolo fortich ', 'Dalirig ', 'Sitio mangima ', '02', 10000.00, ''),
(36, 'Jessa', '2024-09-21', 'Bukidnon ', 'Manolo fortich ', 'Dalirig ', 'Sitio mangima ', '02', 10000.00, ''),
(37, 'Jessa', '2024-09-21', 'Bukidnon ', 'Manolo fortich ', 'Maluko', 'Zone 2', '12', 11000.00, ''),
(38, 'Jessa', '2024-09-21', 'Bukidnon ', 'Manolo fortich ', 'Maluko', 'Zone 2', '12', 11000.00, ''),
(39, 'Jaylah', '2024-09-21', 'Bukidnon', 'Manolo Fortich', 'Santiago', 'zone 1', '2345', 15000.00, ''),
(40, 'Jaylah', '2024-09-21', 'Bukidnon', 'Manolo Fortich', 'Santiago', 'zone 1', '2345', 15000.00, ''),
(41, 'Jessa', '2024-09-21', 'Bukidnon ', 'Manolo fortich ', 'Maluko ', 'Sitio Malambago', '3', 12000.00, ''),
(42, 'Jessa', '2024-09-21', 'Bukidnon ', 'Manolo fortich ', 'Maluko ', 'Sitio Malambago', '3', 12000.00, ''),
(43, 'Jessa', '2024-09-21', 'Bukidnon ', 'Manolo fortich ', 'Dalirig ', 'Zone 1', '10', 15000.00, ''),
(44, 'Jessa', '2024-09-21', 'Bukidnon ', 'Manolo fortich ', 'Dalirig ', 'Zone 1', '10', 15000.00, ''),
(46, 'admin Bimbo', '2024-09-21', 'Bukidnon', 'Manolo Fortich', 'Sankanan', 'Purok 5 Upper Pol-Oton', '1000', 10000.00, '');

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
(52, 21, 'Aljie Gonzales', 'Father', '1992-05-02', 32, 'Male', 'Married', 'N/A', 'Lumad', 'Roman Catholic'),
(53, 21, 'Christy Fe Gonzales', 'Mother', '1995-09-25', 29, 'Female', 'Married', 'N/A', 'N/A', 'Roman Catholic'),
(54, 21, 'Ace Eshell Jane Gonzales', 'Daughter', '2016-06-14', 8, 'Female', 'Single', 'N/A', 'Manolo Fortich', 'Roman Catholic'),
(55, 22, 'Aljie Gonzales', 'Father', '1992-05-02', 32, 'Male', 'Married', 'N/A', 'Lumad', 'Roman Catholic'),
(56, 22, 'Christy Fe Gonzales', 'Mother', '1995-09-25', 29, 'Female', 'Married', 'N/A', 'N/A', 'Roman Catholic'),
(57, 22, 'Ace Eshell Jane Gonzales', 'Daughter', '2016-06-14', 8, 'Female', 'Single', 'N/A', 'Manolo Fortich', 'Roman Catholic'),
(58, 23, 'Pedro Smith', 'Father', '1970-08-02', 54, 'Male', 'Married', 'N/A', 'N/A', 'Roman Catholic'),
(59, 23, 'Cresencia Smith', 'Mother', '1973-03-01', 51, 'Female', 'Married', 'N/A', 'N', 'Roman Catholic'),
(60, 23, 'DJ Secuya', 'Son', '2006-12-29', 17, 'Male', 'Single', 'N/A', 'N/A', 'Roman Catholic'),
(61, 24, 'Pedro Smith', 'Father', '1970-08-02', 54, 'Male', 'Married', 'N/A', 'N/A', 'Roman Catholic'),
(62, 24, 'Cresencia Smith', 'Mother', '1973-03-01', 51, 'Female', 'Married', 'N/A', 'N', 'Roman Catholic'),
(63, 24, 'DJ Secuya', 'Son', '2006-12-29', 17, 'Male', 'Single', 'N/A', 'N/A', 'Roman Catholic'),
(64, 25, 'Wilson Mag-aso', 'Father', '1969-07-17', 55, 'Male', 'Married', 'N/A', 'N', 'Roman Catholic'),
(65, 25, 'Jellie Mag-aso', 'Mother', '1976-08-19', 48, 'Female', 'Married', 'N/A', 'N/A', 'Roman Catholic'),
(66, 25, 'Wilson Mag-aso Jr. ', 'Son', '2004-02-19', 20, 'Male', 'Single', 'N/A', 'N/A', 'Roman Catholic'),
(67, 26, 'Wilson Mag-aso', 'Father', '1969-07-17', 55, 'Male', 'Married', 'N/A', 'N', 'Roman Catholic'),
(68, 26, 'Jellie Mag-aso', 'Mother', '1976-08-19', 48, 'Female', 'Married', 'N/A', 'N/A', 'Roman Catholic'),
(69, 26, 'Wilson Mag-aso Jr. ', 'Son', '2004-02-19', 20, 'Male', 'Single', 'N/A', 'N/A', 'Roman Catholic'),
(70, 27, 'Arlo Abejuela', 'Father', '1988-04-12', 36, 'Male', 'Married', 'N/A', 'N/A', 'Roman Catholic'),
(71, 27, 'Christine Abejuela', 'Mother', '1993-10-31', 31, 'Female', 'Married', 'N/A', 'N/A', 'Roman Catholic'),
(72, 27, 'Inigo Abejuela', 'Son', '2014-03-21', 10, 'Male', 'Single', 'N/A', 'N/A', 'Roman Catholic'),
(73, 28, 'Arlo Abejuela', 'Father', '1988-04-12', 36, 'Male', 'Married', 'N/A', 'N/A', 'Roman Catholic'),
(74, 28, 'Christine Abejuela', 'Mother', '1993-10-31', 31, 'Female', 'Married', 'N/A', 'N/A', 'Roman Catholic'),
(75, 28, 'Inigo Abejuela', 'Son', '2014-03-21', 10, 'Male', 'Single', 'N/A', 'N/A', 'Roman Catholic'),
(76, 29, 'Warvin Cinco', 'Father ', '1976-02-19', 48, 'Male', 'Married', 'N/A', 'Bukidnon', 'Baptist'),
(77, 29, 'Flor T. Cinco', 'Mother', '1978-12-19', 46, 'Female', 'Married', 'N/A', 'Bukidnon', 'Baptist'),
(78, 29, 'Vina Cinco', 'Daughter ', '2000-05-04', 24, 'Female', 'Single', 'N/A', 'Bukidnon', 'Baptist'),
(79, 30, 'Warvin Cinco', 'Father ', '1976-02-19', 48, 'Male', 'Married', 'N/A', 'Bukidnon', 'Baptist'),
(80, 30, 'Flor T. Cinco', 'Mother', '1978-12-19', 46, 'Female', 'Married', 'N/A', 'Bukidnon', 'Baptist'),
(81, 30, 'Vina Cinco', 'Daughter ', '2000-05-04', 24, 'Female', 'Single', 'N/A', 'Bukidnon', 'Baptist'),
(82, 31, 'lalay', 'N/A', '2024-09-19', 24, 'F', 'Single ', 'N/A', 'Filipino ', 'RC'),
(83, 32, 'lalay', 'N/A', '2024-09-19', 24, 'F', 'Single ', 'N/A', 'Filipino ', 'RC'),
(84, 33, 'Onel Turay', 'Father ', '1993-01-26', 31, 'Male', 'Married', 'N/A', 'Bukidnon', 'Catholic'),
(85, 33, 'Nobet A. Turay', 'Mother', '1996-09-24', 28, 'Female', 'Married', 'N/A', 'Bukidnon', 'Baptist'),
(86, 34, 'Onel Turay', 'Father ', '1993-01-26', 31, 'Male', 'Married', 'N/A', 'Bukidnon', 'Catholic'),
(87, 34, 'Nobet A. Turay', 'Mother', '1996-09-24', 28, 'Female', 'Married', 'N/A', 'Bukidnon', 'Baptist'),
(88, 35, 'Jhonlee', 'Brother ', '2005-09-24', 19, 'M', 'Single ', 'No', 'Filipino ', 'RC'),
(89, 36, 'Jhonlee', 'Brother ', '2005-09-24', 19, 'M', 'Single ', 'No', 'Filipino ', 'RC'),
(90, 37, 'Greg Abella', 'Brother ', '2000-09-21', 24, 'M', 'Maried', 'No', 'Filipino ', 'RC'),
(91, 38, 'Greg Abella', 'Brother ', '2000-09-21', 24, 'M', 'Maried', 'No', 'Filipino ', 'RC'),
(92, 39, 'James Yap', 'Father ', '1999-03-01', 25, 'Male', 'Live-in', 'N/A', 'Higaonon', 'Catholic'),
(93, 39, 'Ivy H. Halasan', 'Mother', '2000-07-06', 24, 'Female', 'Live-in', 'N/A', 'Bukidnon', 'Catholic'),
(94, 39, 'Jerome H. Yap', 'Son', '2006-09-15', 18, 'Male', 'Single', 'N/A', 'Bukidnon', 'Catholic'),
(95, 39, 'Vanessa H. Yap', 'Daughter', '2007-12-27', 17, 'Female', 'Single', 'N/A', 'Bukidnon', 'Catholic'),
(96, 40, 'James Yap', 'Father ', '1999-03-01', 25, 'Male', 'Live-in', 'N/A', 'Higaonon', 'Catholic'),
(97, 40, 'Ivy H. Halasan', 'Mother', '2000-07-06', 24, 'Female', 'Live-in', 'N/A', 'Bukidnon', 'Catholic'),
(98, 40, 'Jerome H. Yap', 'Son', '2006-09-15', 18, 'Male', 'Single', 'N/A', 'Bukidnon', 'Catholic'),
(99, 40, 'Vanessa H. Yap', 'Daughter', '2007-12-27', 17, 'Female', 'Single', 'N/A', 'Bukidnon', 'Catholic'),
(100, 41, 'Jane Garcia', 'Sister', '2001-05-17', 23, 'F', 'Single ', 'No', 'Talaandig ', 'RC'),
(101, 42, 'Jane Garcia', 'Sister', '2001-05-17', 23, 'F', 'Single ', 'No', 'Talaandig ', 'RC'),
(102, 43, 'Jenny Beno', 'Sister ', '1997-09-21', 27, 'F', 'Maried', 'No', 'Visaya', 'Rc'),
(103, 44, 'Jenny Beno', 'Sister ', '1997-09-21', 27, 'F', 'Maried', 'No', 'Visaya', 'Rc'),
(109, 46, 'Liam Bennett', 'Father', '1982-03-14', 42, 'Male', 'married', 'N/A', 'lomad', 'R-Catholic'),
(110, 46, 'Evelyn Harper Bennett', 'Mother', '1984-07-22', 40, 'FEMALE', 'married', 'N/A', 'lomad', 'R-Catholic'),
(111, 46, 'Isabella Bennett', 'Daughter', '2003-11-05', 20, 'FEMALE', 'single', 'N/A', 'lomad', 'R-Catholic'),
(112, 46, 'Noah Bennett', 'Son', '2006-04-28', 18, 'Male', 'single', 'N/A', 'lomad', 'R-Catholic'),
(113, 46, 'Sophia Bennett', 'Daughter', '2009-09-16', 14, 'FEMALE', 'single', 'N/A', 'lomad', 'R-Catholic');

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
(95, 3, 'sample', '2024-09-19 08:49:33', '2024-09-19 14:52:59'),
(96, 2, 'admin Bimbo', '2024-09-19 08:54:46', '2024-09-19 14:55:40'),
(97, 2, 'admin Bimbo', '2024-09-19 08:56:42', '2024-09-19 14:57:03'),
(98, 32, 'user5', '2024-09-19 08:57:11', NULL),
(99, 2, 'admin Bimbo', '2024-09-19 08:57:38', NULL),
(100, 2, 'admin Bimbo', '2024-09-19 09:12:08', NULL),
(101, 2, 'admin Bimbo', '2024-09-21 08:49:42', '2024-09-21 17:41:35'),
(102, 2, 'admin Bimbo', '2024-09-21 11:41:47', '2024-09-21 06:54:50'),
(103, 2, 'admin Bimbo', '2024-09-21 07:52:13', NULL),
(104, 2, 'admin Bimbo', '2024-09-21 07:53:15', NULL),
(105, 2, 'admin Bimbo', '2024-09-21 07:55:08', NULL),
(106, 36, 'Jaylah', '2024-09-21 08:00:09', NULL),
(107, 35, 'Evelyn', '2024-09-21 08:02:32', NULL),
(108, 35, 'Evelyn', '2024-09-21 08:02:59', NULL),
(109, 36, 'Jaylah', '2024-09-21 09:51:38', NULL),
(110, 2, 'admin Bimbo', '2024-09-21 09:55:50', '2024-09-22 01:31:57'),
(111, 33, 'Jessa', '2024-09-21 10:27:41', NULL),
(112, 2, 'admin Bimbo', '2024-09-21 19:33:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `district` int(50) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`user_id`, `user_name`, `email`, `pass`, `district`, `user_type`, `status`) VALUES
(2, 'admin Bimbo', 'admin@gmail.com', '$2y$10$KnOAEPlAWwiTr.WUe3qmhep9I3phYEvQCyjjLSAXkWbcahBcpQuMW', 1, 'admin', ''),
(3, 'sample', 'villaganasbimbo123@gmail.com', '$2y$10$UdoQYJ6a4QeipkC1pLAoIuWeMcUwG8UzIyT0L2KAgXT7xVQh4hOEK', 2, 'admin', ''),
(8, 'BIMBO', 'Bimbo@gmail.com', '$2y$10$rSElVQ7x9iE.OExyOc5maOCcLVQHpvgt2L0vX/.BRvRcqQumlUsFm', 3, 'admin', ''),
(27, 'bo', 'bo@gmail.com', '$2y$10$HWg15K4hZ6YUSNOkKxiQoem75ZYBn.DT9rp/5c37I/Ig4KaJUlaJ.', 1, 'user', 'disable'),
(28, 'bitok', 'bitok@gmail.com', '$2y$10$Xfl6Zih.IJM3xWhKQ/QQvOxsb97qpVnGfNjA08jrwlBNr.FL.au/O', 2, 'user', 'disable'),
(30, 'basta admin', 'villaganasbimbo123@gmail.com', '$2y$10$roFTcdJ61dq4t5lRZO2z4uVWWcZE6xAC17ez53BeUFf.YvGZSCtpa', 4, 'admin', ''),
(31, 'sample', 'villaganasbimbo123@gmail.com', '$2y$10$qcq6bZ3To23D9rxEgkRYFeBI.SUGuhlBHuSTYfmRZwk5KVQmPLjP.', 1, 'user', 'disable'),
(32, 'user5', 'villaganasbimbo123@gmail.com', '$2y$10$Vhsp3UbPL27NCcZZomRUEue3pRRNGDXSXfidC9ilxYQs8zTDBMDYO', 1, 'user', 'enable'),
(33, 'Jessa', 'jessa@gmail.com', '$2y$10$YM.TWnLxWJfSfoJDdTzU7uUpmkE2XA/fmHBIq9acvxmxJDmiG/xE.', 0, 'admin', ''),
(34, 'Jessa', 'jessa@gmail.com', '$2y$10$2HCp.vJPguSrTjnVgSd1tuj3HAsAjp82pZzArU3N8MUtt6p/k1MCy', 0, 'admin', ''),
(35, 'Evelyn', 'evelyn@gmail.com', '$2y$10$ALybksMn6c0..ZNBd99tVOxS8WHnwDLtven6vSOQxSKx2bUHE89hS', 0, 'admin', ''),
(36, 'Jaylah', 'jaylah@gmail.com', '$2y$10$vtYVwpmVp84v9u8Ld/rBb.sK/coVU4uH.eCiWEZ7knlA4iTBRml.2', 0, 'admin', '');

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
  MODIFY `background_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `location_tbl`
--
ALTER TABLE `location_tbl`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `members_tbl`
--
ALTER TABLE `members_tbl`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
