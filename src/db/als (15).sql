-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2024 at 04:46 PM
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
(52, 52, '4th year', 'Yes', '4th year', 'n/a', 'Yes', 'n/a', 'n/a', 'no'),
(53, 53, '4th year', 'Yes', '4th year', 'n/a', 'Yes', 'n/a', 'n/a', 'no'),
(55, 55, 'Highschool Graduate', 'No', 'N/A', 'N/A', 'Yes', 'Yes', 'Operator in Rebisco', 'No'),
(56, 56, 'Highschool Graduate', 'No', 'N/A', '	tirediness', 'Yes', 'No', 'N/A', 'No'),
(57, 57, 'Grade 2', 'Yes', 'Grade 3', 'N/A', 'Yes', 'No', 'N/A', 'No'),
(58, 58, 'Grade 2', 'No', 'N/A', 'N/A', 'Yes', 'No', 'N/A', 'No'),
(59, 59, 'Elementary Graduate', 'No', 'N/A', 'N/A', 'Yes', 'Yes', 'Utility', 'No'),
(60, 60, 'Grade 11', 'No', 'N/A', 'tirediness', 'Yes', 'No', 'N/A', 'Yes'),
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
(71, 71, 'ALS Grade 11', 'No', 'ALS Grade 12', 'N/A', 'Yes', 'No', 'N/A', 'Yes'),
(72, 72, 'Grade 3', 'No', 'Grade 4', 'N/A', 'Yes', 'No', 'N/A', 'No'),
(73, 73, 'Grade 8', 'No', 'N/A', 'N/A', 'Yes', 'No', 'N/A', 'No'),
(74, 74, 'ALS Grade 11', 'Yes', 'ALS Grade 12', 'N/A', 'Yes', 'No', 'N/A', 'Yes'),
(75, 75, 'Grade 3', 'Yes', 'Grade 4', 'N/A', 'Yes', 'No', 'N/A', 'No'),
(76, 76, 'College Grad', 'no', 'n/a', 'n/a', 'Yes', 'Police ', 'Police', 'No'),
(77, 77, '3rd Year College', 'Yes', '4th Year College ', 'n/a', 'Yes', 'Housewife', 'Housewife', 'No'),
(78, 78, 'Grade 9 ', 'No', 'Grade 10', 'Discrimination', 'Yes', 'N/A', 'N/A', 'Yes'),
(79, 79, 'College Grad', 'no', 'n/a', 'n/a', 'Yes', 'Police ', 'Police', 'No'),
(80, 80, '3rd Year College', 'Yes', '4th Year College ', 'n/a', 'Yes', 'Housewife', 'Housewife', 'No'),
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
(97, 97, 'Grade 7', 'No', 'n/a', 'tirediness', 'Yes', 'labandera', 'Labandera', 'Yes'),
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
(113, 113, 'Grade 9', 'No', 'Grade 10', 'N/A', 'Yes', 'N/A', 'N/A', 'Yes'),
(114, 114, '3rd year college', 'yes', '4th year college', 'n/a', 'yes', 'n/a', 'n/a', 'no'),
(115, 115, '1st year college', 'yes', '2nd year college', 'n/a', 'yes', 'n/a', 'n/a', 'no'),
(125, 125, '3th year college', 'Yes', '4th year', 'N/A', 'Yes', 'N/A', 'N/A', 'No'),
(127, 127, 'Grade 2', 'Yes', 'Grade 3', 'N/A', 'Yes', 'No', 'N/A', 'No'),
(128, 128, 'na', 'na', 'na', 'N/A', 'na', 'N/A', 'N/A', 'Yes'),
(133, 133, '3rd Yr College', 'Yes', '4th Yr College', 'None', 'Yes', 'No', 'N/A', 'No');

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
(21, 'Evelyn', '2024-09-21', 'Bukidnon', 'Manolo Fortich', 'Tankulan', 'Mangima', '2314', 8000.00, 'sample notes'),
(22, 'evelyn', '2023-05-09', 'Bukidnon', 'Manolo Fortich', 'Tankulan', 'Mangima', '2314', 8000.00, ''),
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
(46, 'admin Bimbo', '2024-09-21', 'Bukidnon', 'Manolo Fortich', 'Sankanan', 'Purok 5 Upper Pol-Oton', '1000', 10000.00, ''),
(47, 'admin Bimbo', '2024-09-25', 'Bukidnon', 'Manolo Fortich', 'Tankulan', 'zone 7', '1', 1222.00, ''),
(48, 'admin Bimbo', '2024-09-25', 'Davao', 'Manolo Fortich', 'Tankulan', 'Purok 5 Upper Pol-Oton', '20001', 1.00, ''),
(49, 'admin Bimbo', '2022-01-25', 'Bukidnon', 'Manolo Fortich', 'Tankulan', 'zone 7', '1', 23.00, ''),
(50, 'admin Bimbo', '2024-09-26', 'Bukidnon', 'Manolo Fortich', 'Alae', 'Purok 5 Upper Pol-Oton', '00197', 18000.00, ''),
(51, 'admin Bimbo', '2023-06-27', 'Bukidnon', 'Manolo Fortich', 'Tankulan', 'zone 8', '3', 10000.00, ''),
(54, 'admin Bimbo', '2024-10-06', 'Bukidnon', 'Manolo Fortich', 'Tankulan', 'Purok 5 Upper Pol-Oton', '1000', 121313.00, ''),
(55, 'admin Bimbo', '2024-10-06', 'Bukidnon', 'Manolo Fortich', 'Tankulan', 'Purok 5 Upper Pol-Oton', '00001', 3000.00, '<h1>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil voluptatibus repellendus cum sapiente aspernatur in reiciendis quos, nostrum voluptas molestias ratione, dolorem eligendi fugit ipsam necessitatibus officia aliquam omnis repudiandae excepturi sunt non, quaerat ex earum! Illo adipisci placeat reiciendis totam? Quaerat, libero dolorem praesentium hic rerum quo obcaecati, quae ullam non, aliquid atque facere! Animi quis repellendus modi, architecto tenetur, recusandae id ratione adipisci non nisi reiciendis quos aliquam, atque asperiores amet voluptate odit beatae molestias delectus. Similique, nemo doloribus repudiandae suscipit voluptatum quis vitae dolor autem deleniti ullam error mollitia doloremque consequuntur quidem nam neque tenetur exercitationem fugiat.</h1>'),
(56, 'evelyn', '2023-05-09', 'Bukidnon', 'Manolo Fortich', 'Tankulan', 'Mangima', '2314', 8000.00, ''),
(57, 'admin Bimbo', '2024-10-23', 'Davao', 'Manolo Fortich', 'Sto.Nino', 'Purok 5 Upper Pol-Oton', '000', 1.00, ''),
(58, 'admin Bimbo', '2024-10-23', 'Bukidnon', 'Manolo Fortich', 'tankulan', 'Purok 5 Upper Pol-Oton', '001', 8000.00, ''),
(59, 'admin Bimbo', '2024-10-23', 'Bukidnon', 'Manolo Fortich', 'tankulan', 'Purok 5 Upper Pol-Oton', '001', 8.00, ''),
(60, 'head', '2024-10-23', 'Bukidnon', 'Manolo Fortich', 'tankulan', 'Purok 5 Upper Pol-Oton', '001', 5.00, ''),
(61, 'teacher', '2024-10-23', 'Bukidnon', 'Manolo Fortich', 'tankulan', 'Purok 5 Upper Pol-Oton', '001', 2.00, ''),
(62, 'teacher', '2024-10-23', 'Bukidnon', 'Manolo Fortich', 'tankulan', 'Purok 5 Upper Pol-Oton', '001', 1.00, '');

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
(52, 21, 'Aljie Gonzales', 'Father', '1992-05-02', 32, 'Male', 'Married', 'Yes', 'Lumad', 'catholic'),
(53, 21, 'Christy Fe Gonzales', 'Mother', '1995-09-25', 29, 'Female', 'Married', 'Yes', 'N/A', 'catholic'),
(55, 22, 'Aljie Gonzales', 'Father', '1992-05-02', 32, 'Male', 'Married', 'Yes', 'Lumad', 'Roman Catholic'),
(56, 22, 'Christy Fe Gonzales', 'Mother', '1995-09-25', 29, 'Female', 'Married', 'Yes', 'N/A', 'Roman Catholic'),
(57, 22, 'Ace Eshell Jane Gonzales', 'Daughter', '2016-06-14', 8, 'Female', 'Single', 'Yes', 'Manolo Fortich', 'Roman Catholic'),
(58, 23, 'Pedro Smith', 'Father', '1970-08-02', 54, 'Male', 'Married', 'Yes', 'N/A', 'Roman Catholic'),
(59, 23, 'Cresencia Smith', 'Mother', '1973-03-01', 51, 'Female', 'Married', 'Yes', 'N', 'Roman Catholic'),
(60, 23, 'DJ Secuya', 'Son', '2005-08-29', 18, 'Male', 'Single', 'Yes', 'N/A', 'Roman Catholic'),
(61, 24, 'Pedro Smith', 'Father', '1970-08-02', 54, 'Male', 'Married', 'N/A', 'N/A', 'Roman Catholic'),
(62, 24, 'Cresencia Smith', 'Mother', '1973-03-01', 51, 'Female', 'Married', 'N/A', 'N', 'Roman Catholic'),
(63, 24, 'DJ Secuya', 'Son', '2006-12-29', 17, 'Male', 'Single', 'N/A', 'N/A', 'Roman Catholic'),
(64, 25, 'Wilson Mag-aso', 'Father', '1969-07-17', 55, 'Male', 'Married', 'N/A', 'N', 'Roman Catholic'),
(65, 25, 'Jellie Mag-aso', 'Mother', '1976-08-19', 48, 'Female', 'Married', 'N/A', 'N/A', 'Roman Catholic'),
(66, 25, 'Wilson Mag-aso Jr. ', 'Son', '2004-02-19', 20, 'Male', 'Single', 'N/A', 'N/A', 'Roman Catholic'),
(67, 26, 'Wilson Mag-aso', 'Father', '1969-07-17', 55, 'Male', 'Married', 'N/A', 'N', 'Roman Catholic'),
(68, 26, 'Jellie Mag-aso', 'Mother', '1976-08-19', 48, 'Female', 'Married', 'N/A', 'N/A', 'Roman Catholic'),
(69, 26, 'Wilson Mag-aso Jr. ', 'Son', '2004-02-19', 20, 'Male', 'Single', 'N/A', 'N/A', 'Roman Catholic'),
(70, 27, 'Arlo Abejuela', 'Father', '1988-04-12', 36, 'Male', 'Married', 'Yes', 'N/A', 'Roman Catholic'),
(71, 27, 'Christine Abejuela', 'Mother', '1993-10-31', 31, 'Female', 'Married', 'Yes', 'N/A', 'Roman Catholic'),
(72, 27, 'Inigo Abejuela', 'Son', '2014-03-21', 10, 'Male', 'Single', 'Yes', 'N/A', 'Roman Catholic'),
(73, 28, 'Arlo Abejuela', 'Father', '1988-04-12', 36, 'Male', 'Married', 'N/A', 'N/A', 'Roman Catholic'),
(74, 28, 'Christine Abejuela', 'Mother', '1993-10-31', 31, 'Female', 'Married', 'N/A', 'N/A', 'Roman Catholic'),
(75, 28, 'Inigo Abejuela', 'Son', '2014-03-21', 10, 'Male', 'Single', 'N/A', 'N/A', 'Roman Catholic'),
(76, 29, 'Warvin Cinco', 'Father ', '1976-02-19', 48, 'Male', 'Married', 'N/A', 'Bukidnon', 'Baptist'),
(77, 29, 'Flor T. Cinco', 'Mother', '1978-12-19', 46, 'Female', 'Married', 'N/A', 'Bukidnon', 'Baptist'),
(78, 29, 'Vina Cinco', 'Daughter ', '2000-05-04', 24, 'Female', 'Single', 'N/A', 'Bukidnon', 'Baptist'),
(79, 30, 'Warvin Cinco', 'Father ', '1976-02-19', 48, 'Male', 'Married', 'N/A', 'Bukidnon', 'Baptist'),
(80, 30, 'Flor T. Cinco', 'Mother', '1978-12-19', 46, 'Female', 'Married', 'N/A', 'Bukidnon', 'Baptist'),
(82, 31, 'lalay', 'N/A', '2024-09-19', 24, 'F', 'Single ', 'N/A', 'Filipino ', 'RC'),
(83, 32, 'lalay', 'N/A', '2024-09-19', 24, 'F', 'Single ', 'N/A', 'Filipino ', 'RC'),
(84, 33, 'Onel Turay', 'Father ', '1993-01-26', 31, 'Male', 'Married', 'N/A', 'Bukidnon', 'Catholic'),
(85, 33, 'Nobet A. Turay', 'Mother', '1996-09-24', 28, 'Female', 'Married', 'N/A', 'Bukidnon', 'Baptist'),
(86, 34, 'Onel Turay', 'Father ', '1993-01-26', 31, 'Male', 'Married', 'N/A', 'Bukidnon', 'Catholic'),
(87, 34, 'Nobet A. Turay', 'Mother', '1996-09-24', 28, 'Female', 'Married', 'N/A', 'Bukidnon', 'Baptist'),
(88, 35, 'Jhonlee', 'Brother ', '2005-09-24', 19, 'Male', 'Single', 'No', 'Filipino ', 'RC'),
(89, 36, 'Jhonlee', 'Brother ', '2005-09-24', 19, 'M', 'Single ', 'No', 'Filipino ', 'RC'),
(90, 37, 'Greg Abella', 'Brother ', '2000-09-21', 24, 'M', 'Maried', 'No', 'Filipino ', 'RC'),
(91, 38, 'Greg Abella', 'Brother ', '2000-09-21', 24, 'M', 'Maried', 'No', 'Filipino ', 'RC'),
(92, 39, 'James Yap', 'Father ', '1999-03-01', 25, 'Male', 'Live-in', 'N/A', 'Higaonon', 'Catholic'),
(93, 39, 'Ivy H. Halasan', 'Mother', '2000-07-06', 24, 'Female', 'Live-in', 'N/A', 'Bukidnon', 'Catholic'),
(94, 39, 'Jerome H. Yap', 'Son', '2006-09-15', 18, 'Male', 'Single', 'N/A', 'Bukidnon', 'Catholic'),
(95, 39, 'Vanessa H. Yap', 'Daughter', '2007-12-27', 17, 'Female', 'Single', 'N/A', 'Bukidnon', 'Catholic'),
(96, 40, 'James Yap', 'Father ', '1999-03-01', 25, 'Male', 'Live-in', 'Yes', 'Higaonon', 'catholic'),
(97, 40, 'Ivy H. Halasan', 'Mother', '2000-07-06', 24, 'Female', 'Live-in', 'Yes', 'Bukidnon', 'catholic'),
(98, 40, 'Jerome H. Yap', 'Son', '2006-09-15', 18, 'Male', 'Single', 'Yes', 'Bukidnon', 'catholic'),
(99, 40, 'Vanessa H. Yap', 'Daughter', '2007-12-27', 17, 'Female', 'Single', 'Yes', 'Bukidnon', 'catholic'),
(100, 41, 'Jane Garcia', 'Sister', '2001-05-17', 23, 'F', 'Single ', 'No', 'Talaandig ', 'RC'),
(101, 42, 'Jane Garcia', 'Sister', '2001-05-17', 23, 'F', 'Single ', 'No', 'Talaandig ', 'RC'),
(102, 43, 'Jenny Beno', 'Sister ', '1997-09-21', 27, 'F', 'Maried', 'No', 'Visaya', 'Rc'),
(103, 44, 'Jenny Beno', 'Sister ', '1997-09-21', 27, 'F', 'Maried', 'No', 'Visaya', 'Rc'),
(109, 46, 'Liam Bennett', 'Father', '1982-03-14', 42, 'Male', 'Single', 'Yes', 'lomad', 'R-Catholic'),
(110, 46, 'Evelyn Harper Bennett', 'Mother', '1984-07-22', 40, 'Male', 'Single', 'Yes', 'lomad', 'R-Catholic'),
(111, 46, 'Isabella Bennett', 'Daughter', '2003-11-05', 20, 'Male', 'Single', 'Yes', 'lomad', 'R-Catholic'),
(112, 46, 'Noah Bennett', 'Son', '2006-04-28', 18, 'Male', 'Single', 'Yes', 'lomad', 'R-Catholic'),
(113, 46, 'Sophia Bennett', 'Daughter', '2007-01-16', 17, 'Male', 'Single', 'Yes', 'lomad', 'R-Catholic'),
(114, 47, 'Bimbo', 'son', '2024-09-25', 19, 'male', 'single', 'None', 'manobo', 'r-catholic'),
(115, 47, 'sample', 'son', '2024-09-25', 26, 'male', 'single', 'None', 'manobo', 'r-catholic'),
(125, 54, 'Bimbo Escodero', 'na', '2001-08-27', 23, 'MALE', 'SINGLE', 'N/A', 'Manolo Fortich', 'R-Catholic'),
(127, 56, 'Ace Eshell Jane Gonzales', 'Daughter', '2016-06-14', 8, 'Female', 'Single', 'Yes', 'Manolo Fortich', 'Roman Catholic'),
(128, 57, 'salas', 'Father', '2001-08-27', 23, 'Male', 'married', 'N/A', 'Manolo Fortich', 'R-Catholic'),
(133, 62, 'Bimbo Escodero', 'Son', '1999-12-09', 24, 'Male', 'Single', 'None', 'Bukidnon', 'Roman Catholic');

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
(170, 50, 'head1', '2024-10-08 07:19:06', NULL),
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
(236, 55, 'head2', '2024-10-17 16:21:20', NULL),
(237, 54, 'head', '2024-10-18 06:41:54', '2024-10-18 12:42:56'),
(238, 55, 'head2', '2024-10-18 06:43:08', '2024-10-18 12:43:17'),
(239, 55, 'head2', '2024-10-18 06:43:57', '2024-10-18 15:29:57'),
(240, 2, 'admin Bimbo', '2024-10-18 07:24:40', NULL),
(241, 55, 'head2', '2024-10-18 09:30:04', '2024-10-18 15:31:00'),
(242, 42, 'teacher', '2024-10-18 09:31:09', '2024-10-18 15:39:06'),
(243, 55, 'head2', '2024-10-18 09:39:13', '2024-10-18 15:57:54'),
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
(254, 42, 'teacher', '2024-10-23 16:29:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `user_id` int(11) NOT NULL,
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

INSERT INTO `user_tbl` (`user_id`, `user_name`, `email`, `phone_number`, `pass`, `district`, `user_type`, `status`) VALUES
(2, 'admin Bimbo', 'admin@gmail.com', '0556282485', '$2y$10$TWyAZbbDQcms2lAoXPvqzOsotVJHvS/Cc9Ef5gi1MxrnXIhMqEHQm', '1', 'supervisor', ''),
(42, 'teacher', 'teacher@gmail.com', '0', '$2y$10$fSy0.UXmf0caJjNZT2I/MOj4yWApbWGuGFYu986fDvNFAsnQFLucm', 'District 2', 'Implementer', 'enable'),
(50, 'head1', 'bimbovillaganas10@gmail.com', '09999999999', '$2y$10$.q5BkZJQDpUvhxQFsFMZ6.pOwTFAG/r1fIxfxyDi4n2WKGUBVXdla', 'District 3', 'Coordinator', 'enable'),
(51, 'user', 'user@gmail.com', '09123456789', '$2y$10$t5s1OamaFxb/lfKweuNyQeNYAUo/GOXgxDapPsMdj2LNqFv3ZMa22', 'District 4', 'Implementer', 'enable'),
(52, 'vol', 'vol@gmail.com', '09912122111', '$2y$10$GcEwMYw9YTUSS7G01GfFH.bs4abGXGwoXs3xD/HeNCtUlfxplCoNS', 'District 1', 'Implementer', 'enable'),
(53, 'admin Bimbo', 'bimbo@gmail.com', '09999999999', '$2y$10$zF0Odp6OP26PXE.jzDHqdOJ625TNUjWS72yk8gXrlvaqvxFPgTK7W', 'District 1', 'Supervisor', ''),
(54, 'head', 'head@gmail.com', '09999999999', '$2y$10$GSs8oNclWUeOBJ7iWWEw0ud..gK280MMpebi7WFt.uwdrrv.7PneO', 'District 1', 'Coordinator', ''),
(55, 'head2', 'head2@gmail.com', '09999999999', '$2y$10$FwdaYn70AbiQOrNQtWtwdeSfA5Xmpej6wxkx2h2n1//LFIaki5Asq', 'District 4', 'Coordinator', ''),
(56, 'haha', 'haha@gmail.com', '09556282485', '$2y$10$p0MTpDQUpYs9cr/ZjDwNZuSKmT4xMpe4DHA6U6OzfWClv/RjLNo02', 'District 3', 'Implementer', ''),
(57, 'haha', 'haha@gmail.com', '09123456789', '$2y$10$.kyBJcWUwJbUOOqPBY8tqOLdhMmqG1uqAh955mCNLfAP9zwEy53vu', 'District 3', 'Implementer', ''),
(59, 'sample ni', 'sample@gmail.com', '09123456789', '$2y$10$xmSQRGim16iGd1p/RHK4cuUY4f6rdfGGbU1DcUU0CFbzs5En.5bH6', 'District 4', 'Implementer', ''),
(60, 'wala', 'wala@gmail.com', '09123456789', '$2y$10$52mfN5hkuZcKCkPMW1y3i.ytu0d1MN6Mec637GYvUGwI5f0pxWwNm', 'District 4', 'Implementer', '');

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
  MODIFY `background_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `location_tbl`
--
ALTER TABLE `location_tbl`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `members_tbl`
--
ALTER TABLE `members_tbl`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

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
