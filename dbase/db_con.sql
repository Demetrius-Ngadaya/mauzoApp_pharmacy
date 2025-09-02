-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2017 at 11:17 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_con`
--

-- --------------------------------------------------------

--
-- Table structure for table `classsched`
--

CREATE TABLE `classsched` (
  `classid` int(11) NOT NULL,
  `day` varchar(255) NOT NULL,
  `time_start` varchar(255) NOT NULL,
  `time_end` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `room_name` varchar(255) NOT NULL,
  `course_year_section` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `sy` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classsched`
--

INSERT INTO `classsched` (`classid`, `day`, `time_start`, `time_end`, `fname`, `subject_code`, `room_name`, `course_year_section`, `semester`, `sy`, `department`, `status`) VALUES
(79, 'Friday', '7:30am', '8:30am', 'Yrika Marie', 'IS 212', '314', 'BSIS 2A', '1ST', '2016-2017', 'CIT', 'checked'),
(89, 'Monday', '8:30am', '9:30am', 'Ruby Mae', 'IS 122', '314', 'BSIS 2B', '1ST', '2016-2017', 'CIT', 'checked'),
(90, 'Monday', '10:30am', '11:30am', 'Jomar', 'IS 221', '313 Lab', 'BSIS 2B', '1ST', '2016-2017', 'CIT', 'checked'),
(91, 'Monday', '10:30am', '11:30am', 'Ruby Mae', 'IS 122', '316', 'BSIS 3C', '2ND', '2016-2017', 'CIT', 'checked'),
(92, 'Monday', '7:30am', '8:30am', 'Rammel', 'IS 112', '315', 'BSIS 1C', '2ND', '2016-2017', 'CIT', 'checked'),
(97, 'Monday', '7:30am', '8:30am', 'Neil Gabriel', 'Lang 102', 'LSAB 103', 'AB SOCSCI 4A', '1ST', '2016-2017', 'SAS', 'unsaved'),
(98, 'Monday', '1:30pm', '2:30pm', 'Hertzell', 'IS 112', '315', 'BSIS 1C', '1ST', '2016-2017', 'CIT', 'checked'),
(105, 'Monday', '1:30pm', '2:30pm', 'Charwin', 'IS 112', '315', 'BSIS 2B', '1ST', '2016-2017', 'CIT', 'checked'),
(106, 'Wednesday', '9:30am', '10:30am', 'Charwin', 'IS 112', '313 Lab', 'BSIS 2B', '1ST', '2016-2017', 'CIT', 'checked'),
(107, 'Monday', '8:30am', '9:30am', 'Marcelino', 'MECDEF 305', '411', 'BSCE 1A', '1ST', '2016-2017', 'CIT', 'checked'),
(108, 'Monday', '7:30am', '8:30am', 'Ariel', 'HRM 1', 'FT1', 'BSHRM 3B', '1ST', '2016-2017', 'CIT', 'checked'),
(112, 'Monday  Wednesday  Friday ', '9:30am', '10:30am', 'Marcelo', 'PE 1', '410', 'BSIS 4B', '1ST', '2016-2017', 'CIT', 'checked'),
(113, 'Monday  Wednesday  Friday ', '9:30am', '10:30am', 'Perico', 'FW INTROWIK', 'TEB 201', 'BSED2A', '1ST', '2016-2017', 'COED', 'checked'),
(114, 'Monday  Wednesday  Friday ', '7:30am', '8:30am', 'Apolonio', 'NS BIO SCI', '405', 'BSHRM 1A', '1ST', '2016-2017', 'CIT', 'checked'),
(115, 'Wednesday', '9:30am', '3:00pm', 'Perico', 'SS ECOTAR', '', 'bnbmÂ mnbmnb', '1ST', '2016-2017', 'CIT', 'checked'),
(118, 'Monday', '7:30am', '8:30am', 'Judy', 'ENG PLUS', '410', 'BSISÂ 1', '1ST', '2016-2017', 'CIT', 'checked'),
(119, 'Monday', '7:30am', '8:30am', 'Zenaida', 'M COL ALG', '410', 'BSISÂ 2A', '1ST', '2016-2017', 'CIT', 'checked'),
(120, 'Friday', '7:30am', '8:30am', 'Yrika Marie', 'HUM 1', '311 lab', 'BSISÂ 1', '1ST', '2016-2017', 'CIT', 'checked'),
(121, 'Wednesday', '8:30am', '12:30pm', 'Jo-an', 'IS 112', '319', 'BSISÂ 4A', '1ST', '2016-2017', 'CIT', 'checked'),
(122, 'Thursday', '10:30am', '11:30am', 'Jo-an', 'IS 111', '319', 'BSISÂ 2A', '1ST', '2016-2017', 'CIT', 'checked'),
(123, 'Friday', '8:30am', '9:30am', 'Jo-an', 'NS BIO SCI', '404', 'BSISÂ 1', '1ST', '2016-2017', 'CIT', 'checked'),
(124, 'Wednesday', '7:30am', '8:30am', 'Marnyl John', 'Eng 1', '410', 'BSISÂ 4A', '1ST', '2016-2017', 'CIT', 'checked'),
(129, 'Monday Wednesday Friday', '8:00am', '9:00am', 'Marcelo', 'M TRIGO', '311 lab', 'BSISÂ 4A', '1ST', '2016-2017', 'CIT', 'unsaved'),
(135, 'Monday Wednesday Friday', '8:00am', '9:00am', 'Ruby Mae', 'SS PHIL HIST', '410', 'BSISÂ 1', '1ST', '2016-2017', 'CIT', 'unsaved'),
(136, 'Monday Wednesday Friday', '8:30am', '9:30am', 'Marcelo', 'M COL ALG', '410', 'BSISÂ 2A', '1ST', '2016-2017', 'CIT', 'unsaved'),
(137, 'Monday', '8:00am', '9:00am', 'Marcelo', 'M COL ALG', '410', 'BSISÂ 2A', '1ST', '2016-2017', '', 'unsaved'),
(141, 'Monday  Wednesday  Friday ', '9:30am', '10:30am', 'Ruby Mae', 'IS 121', '317', 'BSISÂ 2A', '1ST', '2016-2017', 'CIT', 'unsaved'),
(142, 'Monday  Wednesday  Friday ', '8:30am', '9:30am', 'Ariel', 'NS BIO SCI', '317', 'BSHRMÂ 1A', '1ST', '2016-2017', 'CIT', 'unsaved'),
(146, 'Tuesday Thursday', '7:30am', '9:00am', 'Perico', 'NS BIO SCI', '314', 'BSISÂ 2A', '1ST', '2016-2017', 'CIT', 'unsaved'),
(147, 'Monday  Wednesday  Friday ', '10:30am', '11:30am', 'Aurelio', 'NS PHYSCI', '317', 'BSISÂ 2A', '1ST', '2016-2017', 'CIT', 'unsaved'),
(148, 'Monday  Wednesday  Friday ', '12:30pm', '1:30pm', 'Judy', 'IS 121', '317', 'BSISÂ 2A', '1ST', '2016-2017', 'CIT', 'unsaved'),
(149, ' Tuesday  Thursday  ', '12:00pm', '1:30pm', 'Yrika Marie', 'IS 122', '316', 'BSISÂ 2A', '1ST', '2016-2017', 'CIT', 'unsaved'),
(150, 'Saturday', '9:00am', '10:30am', 'Yrika Marie', 'IS 213', '316', 'BSISÂ 2A', '1ST', '2016-2017', 'CIT', 'unsaved');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `courseid` int(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `year_section` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `major` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseid`, `course`, `year_section`, `department`, `major`) VALUES
(117, 'BSIS', '1A', 'CIT', ''),
(119, 'BSIS', '2A', 'C', ''),
(120, 'BSIS', '4A', '', ''),
(121, 'BSIS', '4 A', 'CIT', ''),
(122, 'BSHRM', '1A', 'CIT', ''),
(128, 'BSED Mapeh', '1A', 'COED', ''),
(129, 'AB English', '1B', 'SAS', ''),
(130, 'AB Soc Sci', '1A', 'SAS', ''),
(131, 'BSCE', '1A', 'CIT', ''),
(133, 'BSCE', '2A', 'CIT', ''),
(134, 'BSCE', '2B', 'CIT', ''),
(135, 'BSCE', '2C', 'CIT', ''),
(136, 'BSCE', '3A', 'CIT', ''),
(137, 'BSCE', '3B', 'CIT', ''),
(138, 'BSCE', '4A', 'CIT', ''),
(139, 'BSCE', '4B', 'CIT', ''),
(140, 'BSCE', '5A', 'CIT', ''),
(141, 'BSIS', '2A', 'CIT', ''),
(143, 'BSIS', '1B', 'CIT', ''),
(144, 'BSIS', '1C', 'CIT', ''),
(145, 'BSIS', '2B', 'CIT', ''),
(146, 'BSIS', '2C', 'CIT', ''),
(147, 'BSIS', '3A', 'CIT', ''),
(148, 'BSIS', '3B', 'CIT', ''),
(149, 'BSIS', '3C', 'CIT', ''),
(150, 'BSIS', '4A', 'CIT', ''),
(151, 'BSIS', '4B', 'CIT', '');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `deptid` int(255) NOT NULL,
  `incharge` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`deptid`, `incharge`, `position`, `department`) VALUES
(1, 'Dr. Antonio L. Deraja', 'Dean', 'College of Industrial Technology');

-- --------------------------------------------------------

--
-- Table structure for table `examsched`
--

CREATE TABLE `examsched` (
  `examid` int(11) NOT NULL,
  `day` varchar(255) NOT NULL,
  `time_start` varchar(255) NOT NULL,
  `time_end` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `room_name` varchar(255) NOT NULL,
  `course_year_section` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `sy` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `examsched`
--

INSERT INTO `examsched` (`examid`, `day`, `time_start`, `time_end`, `fname`, `subject_code`, `room_name`, `course_year_section`, `semester`, `sy`, `department`, `status`) VALUES
(11, 'firstday', '7:00am', '8:00am', 'Judy', 'NS BIO SCI', '316', 'BSISÂ 4A', '1ST', '2016-2017', 'CIT', 'checked'),
(12, 'secondday', '8:00am', '9:00am', 'Melanie', 'GELCHEM 114', '410', 'BSCEÂ 1A', '1ST', '2016-2017', 'CIT', 'checked'),
(14, 'firstday', '10:am', '11:00am', 'Lucillos', 'PE 1', '410', 'BSCEÂ 1A', '1ST', '2016-2017', 'CIT', 'checked'),
(15, 'firstday', '1:00pm', '2:00pm', 'Lucillos', 'Fil 1', '410', 'BSCEÂ 1A', '1ST', '2016-2017', 'CIT', 'checked'),
(16, 'firstday', '3:00pm', '4:00pm', 'Melanie', 'CALGEB 105', '413', 'BSCEÂ 1A', '1ST', '2016-2017', 'CIT', 'checked'),
(17, 'secondday', '1:00pm', '2:00pm', 'Melanie', 'Eng 1', '413', 'BSCEÂ 1A', '1ST', '2016-2017', 'CIT', 'checked'),
(19, 'thirdday', '1:00pm', '2:00pm', 'Robert', 'PSTRIG 104', '413', 'BSCEÂ 1A', '1ST', '2016-2017', 'CIT', 'checked'),
(20, 'thirdday', '2:00pm', '3:00pm', 'Robert', 'PSTRIG 104', '413', 'BSCEÂ 1A', '1ST', '2016-2017', 'CIT', 'checked'),
(21, 'thirdday', '4:00pm', '5:00pm', 'Robert', 'Draw 1', '411', 'BSCEÂ 1A', '1ST', '2016-2017', 'CIT', 'checked'),
(22, 'thirdday', '10:am', '11:00am', 'Lucillos', 'SS ECOTAR', '409', 'BSCEÂ 1A', '1ST', '2016-2017', 'CIT', 'checked'),
(23, 'firstday', '8:00am', '9:00am', 'Ruby Mae', 'IS 121', '407', 'BSISÂ 1C', '1ST', '2016-2017', 'CIT', 'unsaved'),
(25, 'firstday', '1:00pm', '2:00pm', 'Ruby Mae', 'PE 1', '407', 'BSISÂ 1C', '1ST', '2016-2017', 'CIT', 'unsaved'),
(27, 'firstday', '10:am', '11:00am', 'Ruby Mae', 'PE 1', '407', 'BSISÂ 1C', '1ST', '2016-2017', 'CIT', 'unsaved'),
(28, 'secondday', '10:am', '11:00am', 'Ruby Mae', 'Eng 1', '407', 'BSISÂ 1C', '1ST', '2016-2017', 'CIT', 'unsaved'),
(29, 'secondday', '8:00am', '10:am', 'Ruby Mae', 'IS 121', '407', 'BSISÂ 1C', '1ST', '2016-2017', 'CIT', 'unsaved'),
(30, 'secondday', '1:00pm', '2:00pm', 'Yrika Marie', 'IS 111', '407', 'BSISÂ 1C', '1ST', '2016-2017', 'CIT', 'unsaved'),
(31, 'thirdday', '3:00pm', '4:00pm', 'Ariel', 'IS 121', '408', 'BSISÂ 1C', '1ST', '2016-2017', 'CIT', 'unsaved');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `roomid` int(255) NOT NULL,
  `room_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`roomid`, `room_name`, `description`, `department`) VALUES
(27, '311 lab', 'LSAB', 'CIT'),
(28, '312 lab', 'LSAB', 'CIT'),
(29, '313 Lab', 'LSAB', 'CIT'),
(30, '314', 'LSAB', 'CIT'),
(31, '315', 'LSAB', 'CIT'),
(32, '316', 'LSAB', 'CIT'),
(33, '317', 'LSAB', 'CIT'),
(36, '319', 'LSAB', 'CIT'),
(37, '321', 'LSAB', 'CIT'),
(38, '322', 'LSAB', 'CIT'),
(39, '401 lab', 'LSAB', 'CIT'),
(40, '402 lab', 'LSAB', 'CIT'),
(41, '404', 'LSAB', 'CIT'),
(42, '405', 'LSAB', 'CIT'),
(43, '407', 'LSAB', 'CIT'),
(44, '408', 'LSAB', 'CIT'),
(45, '409', 'LSAB', 'CIT'),
(46, '410', 'LSAB', 'CIT'),
(47, '411', 'LSAB', 'CIT'),
(48, '412', 'LSAB', 'CIT'),
(49, '413', 'LSAB', 'CIT'),
(59, 'TEB 101', 'TEB', 'COED'),
(60, 'TEB 102', 'TEB', 'COED'),
(61, 'TEB 103', 'TEB', 'COED'),
(62, 'TEB 104', 'TEB', 'COED'),
(63, 'TEB 105', 'TEB', 'COED'),
(64, 'TEB 106', 'TEB', 'COED'),
(65, 'TEB 201', 'TEB', 'COED'),
(66, 'TEB 202', 'TEB', 'COED'),
(67, 'TEB 203', 'TEB', 'COED'),
(68, 'TEB 204', 'TEB', 'COED'),
(69, 'TEB 205', 'TEB', 'COED'),
(70, 'TEB 206', 'TEB', 'COED'),
(71, 'LS 204', 'Ceramics', 'COED'),
(72, 'LS 206', 'Ceramics', 'COED'),
(73, 'LS 207', 'Ceramics', 'COED'),
(74, 'LS 208', 'Ceramics', 'COED'),
(75, 'LS 209', 'Ceramics', 'COED'),
(76, 'LS 302', 'Ceramics', 'COED'),
(77, 'LS 303', 'Ceramics', 'COED'),
(78, 'FT1', 'FT', 'CIT'),
(79, 'FT2', 'FT', 'CIT'),
(80, 'FT3', 'FT', 'CIT'),
(81, 'FT4', 'FT', 'CIT'),
(82, 'FT5', 'FT', 'CIT'),
(83, 'FT6', 'FT', 'CIT'),
(84, 'LSAB 103', 'LSAB', 'SAS'),
(85, 'LSAB 103', 'LSAB', 'SAS'),
(86, 'LSAB 103', 'LSAB', 'CIT'),
(88, '103', 'LSAB', 'SAS'),
(90, '312', 'LSAB', 'SAS'),
(91, '311', 'LSAB', 'CAS'),
(92, '312', 'LSAB', 'CAS'),
(93, '312', 'LSAB', 'SAS'),
(94, '311', 'LSAB', 'SAS'),
(95, '409', 'LSAB', '');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `semesterid` int(255) NOT NULL,
  `semester` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`semesterid`, `semester`) VALUES
(1, '1ST'),
(2, '2ND');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subjectid` int(255) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `subject_title` varchar(255) NOT NULL,
  `subject_category` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subjectid`, `subject_code`, `subject_title`, `subject_category`, `semester`, `department`) VALUES
(9, 'ENG PLUS', 'Communicative Grammar', 'Minor', '1ST', 'CIT'),
(10, 'M COL ALG', 'College Algebra', 'Minor', '1ST', 'CIT'),
(11, 'NS PHYSCI', 'Foundation of Physical Sciences', 'Minor', '2ND', 'CIT'),
(12, 'HUM 1', 'Arts, Man and Society', 'Minor', '2ND', 'CIT'),
(13, 'Fil 1', 'Komunikasyon sa Akademikong Filipino', 'Minor', '1ST', 'CIT'),
(14, 'SS GEN PSYCH', 'general Psychology with Drug Addiction Education', 'Minor', '1ST', 'CIT'),
(15, 'SS PHIL HIST', 'Philippine History', 'Minor', '1ST', 'CIT'),
(16, 'IS 111', 'Fundamentals of Info. system/Info. Management', 'Major', '1ST', 'CIT'),
(17, 'IS 112', 'Personal Productive using Information System', 'Major', '1ST', 'CIT'),
(18, 'PE 1', 'Physical Fitness', 'Minor', '1ST', 'CIT'),
(19, 'NSTP 1', 'CWTS/ROTC/LTS', 'Minor', '1ST', 'CIT'),
(20, 'M TRIGO', 'Trigonometry', 'Minor', '2ND', 'CIT'),
(21, 'NS BIO SCI', 'Foundations of biological Sciences', 'Minor', '1ST', 'CIT'),
(22, 'FIL 2', 'Pagbasa at Pagsulat tungo sa Pananaliksik', 'Minor', '2ND', 'CIT'),
(23, 'SS ECOTAR', 'Economics with Taxation and agrarian Reform', 'Minor', '2ND', 'CIT'),
(24, 'RIZAL', 'Life, Works and Writings of Rizal', 'Minor', '2ND', 'CIT'),
(25, 'Eng 1', 'Study and Thinking Skills', 'Minor', '2ND', 'CIT'),
(27, 'IS 121', 'Human Computer Interaction', 'Major', '2ND', 'CIT'),
(28, 'IS 122', 'Data, File and Objects Structures ', 'Major', '2ND', 'CIT'),
(29, 'IS 123', 'Fundamental of Business and Management', 'Major', '2ND', 'CIT'),
(30, 'PE 2', 'Rhythmic and Activities', 'Minor', '2ND', 'CIT'),
(31, 'NSTP 2', 'ROTC/CWTS/LTS', 'Minor', '2ND', 'CIT'),
(32, 'Eng 2', 'Speech Communication', 'Minor', '1ST', 'CIT'),
(33, 'IS 316', 'Statistic', 'Major', '1ST', 'CIT'),
(34, 'HUM 2', 'Logic and Ethics', 'Minor', '1ST', 'CIT'),
(35, 'ACCTG FUND', 'Fundamental of Accounting', 'Minor', '1ST', 'CIT'),
(36, 'IS 212', 'Database management System', 'Major', '1ST', 'CIT'),
(37, 'IS 213', 'Multrimedia Authoring', 'Major', '1ST', 'CIT'),
(38, 'IS 214', 'IS Programming 1', 'Major', '1ST', 'CIT'),
(39, 'IS 313', 'Evaluation of Business Performance', 'Major', '2ND', 'CIT'),
(40, 'PE 3', 'Individual/Dual Sports', 'Minor', '1ST', 'CIT'),
(41, 'LIT 1', 'Philippine Literature', 'Minor', '2ND', 'CIT'),
(42, 'IS 224', 'Discrete Structure', 'Minor', '2ND', 'CIT'),
(43, 'IS 314', 'Operating System', 'Major', '2ND', 'CIT'),
(44, 'IS PROG 2', 'IS Programming 2', 'Major', '2ND', 'CIT'),
(45, 'IS 222', 'Networks and Internet Technology', 'Major', '2ND', 'CIT'),
(46, 'IS 324', 'System Analysis and Design', 'Major', '2ND', 'CIT'),
(47, 'IS 301', 'Information system w/ Non-experimental Reseach', 'Major', '1ST', 'CIT'),
(48, 'Eng 3', 'Writing in the Discipline', 'Minor', '1ST', 'CIT'),
(49, 'IS 311', 'Project Development and Quality Systems', 'Major', '1ST', 'CIT'),
(50, 'IS 312', 'Deployment, Maintenance and services', 'Major', '1ST', 'CIT'),
(51, 'IS 221', 'Application Development (adv. DBMS)', 'Major', '2ND', 'CIT'),
(52, 'IS 315', 'Web Development', 'Major', '1ST', 'CIT'),
(53, 'IS 302', 'Survey Programming Languages', 'Major', '2ND', 'CIT'),
(54, 'IS 211', 'System Infrastructure and Integration', 'Major', '1ST', 'CIT'),
(55, 'M QTB', 'Quantitative Techniques in Business', 'Minor', '2ND', 'CIT'),
(56, 'IS 323', 'E-Commerce Strategy, Architecture', 'Major', '2ND', 'CIT'),
(57, 'SS SOC CUL', 'Society and Culture with Family Planning', 'Minor', '2ND', 'CIT'),
(58, 'IS 303', 'Structured query language', 'Major', '2ND', 'CIT'),
(59, 'FREE ELEC 1', 'Free Elective 1', 'Major', '2ND', 'CIT'),
(60, 'IS321', 'Information System Planning', 'Major', '2ND', 'CIT'),
(61, 'IS 411A', 'Senior System Project 1', 'Major', '1ST', 'CIT'),
(62, 'IS 413', 'Introduction to the IM Profession and Ethics', 'Minor', '1ST', 'CIT'),
(63, 'IS 322', 'Management of technology', 'Major', '2ND', 'CIT'),
(64, 'SMSVCCU', 'Service Culture', 'Major', '2ND', 'CIT'),
(65, 'IS ELEC 4', 'FREE ELEC 2', 'Major', '1ST', 'CIT'),
(66, 'FREE ELEC 3', 'Free Elective 3', 'Major', '1ST', 'CIT'),
(67, 'IS 411 B', 'Senior Systems Project 2', 'Major', '2ND', 'CIT'),
(68, 'IS412', 'Effective Communication for IT Professional', 'Minor', '1ST', 'CIT'),
(69, 'IS MNGTIT', 'Management in Information Technology', 'Major', '1ST', 'CIT'),
(70, 'IS TRENDS', 'IT Trends/Seminar/Fieldtrips', 'Major', '1ST', 'CIT'),
(71, 'SMSYSTH', 'Principles of System Thinking', 'Major', '1ST', 'CIT'),
(72, 'ITE OJT', 'IT/IS Internship/On-the-Job Training', 'Major', '2ND', 'CIT'),
(73, 'M BUS', 'Business Mathematics', 'Minor', '1ST', 'CIT'),
(75, 'HRM 1', 'Introduction to Hospitality Industry', 'Major', '1ST', 'CIT'),
(76, 'HRM 2', 'Sanitation and Safety', 'Major', '1ST', 'CIT'),
(77, 'NS G CHEM', 'General Chemistry', 'Minor', '2ND', 'CIT'),
(78, 'HRM FOOD 1', 'Hot Kitchen', 'Major', '2ND', 'CIT'),
(79, 'HRM FOOD 2', 'Cold Kitchen', 'Major', '2ND', 'CIT'),
(80, 'HRM 5', 'Housekeeping Operations & Procedures with Lab', 'Major', '2ND', 'CIT'),
(81, 'Tour 1', 'Prinsciple of Tourism/Intro to Tourism', 'Major', '1ST', 'CIT'),
(82, 'PDPR', 'Personality Development  and Public Relation', 'Major', '1ST', 'CIT'),
(83, 'M STAT', 'Statistics', 'Minor', '1ST', 'CIT'),
(84, 'COMP LIT', 'Computer Literacy', 'Minor', '1ST', 'CIT'),
(85, 'FOR LANG', 'Chinese', 'Minor', '1ST', 'CIT'),
(86, 'HRM FOOD 3', 'Menu Design & Law Management with Lab', 'Major', '1ST', 'CIT'),
(87, 'HRM FOOD 4', 'Baking With Lab', 'Major', '1ST', 'CIT'),
(88, 'Research 1', 'Feasibility/Project Study Part-1', 'Major', '2ND', 'CIT'),
(89, 'HRM 8', 'Bar Service Management (w/ Lab)', 'Major', '2ND', 'CIT'),
(90, 'HRM 9', 'Front Office Operation and Management', 'Major', '2ND', 'CIT'),
(91, 'PRACTICUM 1', 'Restaurant Phase/Cruise Ship', 'Major', 'Summer', 'CIT'),
(92, 'M INV', 'Mathematics of Investment', 'Minor', '1ST', 'CIT'),
(93, 'Philo 1', 'Work Ethics and Moral Philosophy', 'Minor', '1ST', 'CIT'),
(94, 'Finance', 'Basic Finance', 'Minor', '1ST', 'CIT'),
(95, 'Tour 2', 'Travel and Tour Operation', 'Major', '1ST', 'CIT'),
(96, 'HRM 10', 'F & B Cost Control/ Operation & Mgt', 'Major', '1ST', 'CIT'),
(97, 'HRM 11', 'Sales and Marketing Mgt', 'Major', '1ST', 'CIT'),
(98, 'HRM 21', 'Rooms Division Management & Central System', 'Major', '1ST', 'CIT'),
(99, 'Draw 1H', 'Facilities, Design and Layout', 'Major', '2ND', 'CIT'),
(100, 'Mgt 1', 'Principles of Management', 'Minor', '2ND', 'CIT'),
(101, 'Entrep', 'Entrepreneurship', 'Major', '2ND', 'CIT'),
(102, 'HRM 13', 'Interior Design', 'Major', '2ND', 'CIT'),
(103, 'HRM 14', 'Asian Cuisine', 'Major', '2ND', 'CIT'),
(104, 'HRM 15', 'Catering & Banquet Mgt.', 'Major', '2ND', 'CIT'),
(105, 'HRM 18', 'Business Policy', 'Major', '2ND', 'CIT'),
(106, 'Practicum 2', 'Hotel Phase', 'Major', 'Summer', 'CIT'),
(107, 'Mktg 1', 'Hospitality marketing', 'Major', '1ST', 'CIT'),
(108, 'Tour 3', 'Tourism Planning and Development', 'Major', '1ST', 'CIT'),
(109, 'HRM 16', 'F & B Merchandising & sales', 'Major', '1ST', 'CIT'),
(110, 'HRM 17', 'International cuisine', 'Major', '1ST', 'CIT'),
(111, 'HRM 19', 'Hospitality Operation Mgt', 'Major', '1ST', 'CIT'),
(112, 'HRM 20', 'Convention Mgt', 'Major', '1ST', 'CIT'),
(113, 'PRACTICUM 3', 'Tourism Phase', 'Major', '2ND', 'CIT'),
(114, 'PRACTICUM 4', 'National/International Training', 'Major', '2ND', 'CIT'),
(115, 'TECHNO 1', '(Shop major)Fundamental of technical Sketching, Instrument ', 'Major', '1ST', 'CIT'),
(116, 'Draw 1', 'Drawing and Blueprint Reading', 'Major', '1ST', 'CIT'),
(117, 'Comp Lit 1', 'Computer literacy and Operations', 'Major', '1ST', 'CIT'),
(118, 'TECHNO 2', 'Advance Technical Sketching, Instrument', 'Major', '2ND', 'CIT'),
(119, 'Draw 2', 'Blueprint Reading', 'Major', '2ND', 'CIT'),
(120, 'NS STUMAT', 'Study of Materials', 'Major', '2ND', 'CIT'),
(121, 'ELECTIVE', '(Choose from the List)', 'Major', '2ND', 'CIT'),
(122, 'TECHNO 3', '(Shop Major)', 'Major', '1ST', 'CIT'),
(123, 'VALUES ED', 'Values Education and works ethics', 'Minor', '1ST', 'CIT'),
(124, 'M AP IND', 'Applied Industrial Mathematics', 'Minor', '1ST', 'CIT'),
(126, 'NS PHY 1', 'Physics 1', 'Minor', '1ST', 'CIT'),
(127, 'SS Pol Gov', 'Politics and Governance with Phil Constitution', 'Minor', '1ST', 'CIT'),
(128, 'TECHNO 4', '(Shop Major)', 'Major', '2ND', 'CIT'),
(129, 'NS PHY 2', 'Physics 2', 'Minor', '2ND', 'CIT'),
(130, 'TECHNO 5', '(Shop Major)', 'Major', '1ST', 'CIT'),
(131, 'ENG TWR', 'Technical writing and reporting', 'Minor', '1ST', 'CIT'),
(132, 'IND PSYCH', 'Industrial Psychology', 'Minor', '1ST', 'CIT'),
(133, 'MNGT LAB CO', 'Managment with Labor Code', 'Major', '1ST', 'CIT'),
(134, 'Ind Techno 2', 'Principles of IndustrialOrganization', 'Major', '1ST', 'CIT'),
(135, 'TECHNO 6', '(Shop Major)', 'Major', '2ND', 'CIT'),
(136, 'Ind Techno 4', 'Personnel Administration', 'Major', '2ND', 'CIT'),
(137, 'Ind Techno 5', 'Entrepreneurship with Fundamentals of Coopertive', 'Major', '2ND', 'CIT'),
(138, 'Ind Techno 6', 'Operations and Production Management', 'Major', '2ND', 'CIT'),
(139, 'Ind Techno 7', 'Quality Control Management', 'Major', '2ND', 'CIT'),
(140, 'Ind Techno 8', 'Environmental Education', 'Major', '2ND', 'CIT'),
(141, 'Research 2', 'Feasibility/Project Study Part-2', 'Minor', '2ND', 'CIT'),
(142, 'OJT 1', 'On-the-Job Training', 'Major', '1ST', 'CIT'),
(143, 'OJT 2', 'On-the-Job Training', 'Major', '2ND', 'CIT'),
(144, 'ENG PLUS', 'Communicative Grammar', 'Minor', '1ST', 'SAS'),
(145, 'Eng 1', 'Study and Thinking Skills', 'Minor', '1ST', 'SAS'),
(146, 'MATH 1', 'Integrated Mathematics', 'Minor', '1ST', 'SAS'),
(148, 'Fil 1', 'Komunikasyon sa Akademikong Filipino', 'Minor', '1ST', 'SAS'),
(151, 'NS EARTH SCI', 'EARTH SCIENCES', 'Minor', '1ST', 'SAS'),
(152, 'SS GEN PSYCH', 'general Psychology with Drug Addiction Education', 'Minor', '1ST', 'SAS'),
(153, 'Com 101', 'Communications, Values and Ethics', 'Major', '1ST', 'SAS'),
(154, 'Com 102', 'Introduction to Communication Theory', 'Major', '1ST', 'SAS'),
(155, 'Lang 101 ', 'Introduction to language Study', 'Major', '1ST', 'SAS'),
(156, 'P.E 1', 'Physical Fitness', 'Minor', '1ST', 'SAS'),
(157, 'NSTP 1', 'ROTC/CWTS/LTS', 'Minor', '1ST', 'SAS'),
(158, 'Eng 2', 'Speech Communication', 'Minor', '2ND', 'SAS'),
(159, 'FIL 2', 'Pagbasa at Pagsulat tungo sa Pananaliksik', 'Minor', '2ND', 'SAS'),
(160, 'NS BIO SCI', 'Foundations of biological Sciences', 'Minor', '2ND', 'SAS'),
(161, 'Philo 1', 'Social Philosophy and Logic', 'Minor', '2ND', 'SAS'),
(162, 'Lit 101', 'Introduction to Drama & Theater Arts', 'Major', '2ND', 'SAS'),
(163, 'COMP LIT1', 'Computer Literacy', 'Major', '2ND', 'SAS'),
(164, 'Lang 102', 'Language and society', 'Major', '2ND', 'SAS'),
(165, 'Com 103', 'Audio-Visual Communication', 'Major', '2ND', 'SAS'),
(166, 'P.E 2', 'Rhythmic and Activities', 'Minor', '2ND', 'SAS'),
(167, 'NSTP 2', 'ROTC/CWTS/LTS', 'Minor', '2ND', 'SAS'),
(168, 'Eng 3', 'Writing in the Discipline', 'Minor', '1ST', 'SAS'),
(169, 'Fil 3', 'Masining na Pagpapahayag', 'Minor', '1ST', 'SAS'),
(170, 'MATH 2', 'Contemporary Mathematics', 'Minor', '1ST', 'SAS'),
(171, 'HUM 1', 'Arts, Man and Society', 'Minor', '1ST', 'SAS'),
(172, 'ELECTIVE 1', 'Advance Computer literacy', 'Minor', '1ST', 'SAS'),
(173, 'Lang 103', 'Introduction to Linguistic', 'Major', '1ST', 'SAS'),
(174, 'Com 105', 'Development Communication', 'Major', '1ST', 'SAS'),
(175, 'LIT 1', 'Philippine Literature', 'Minor', '1ST', 'SAS'),
(176, 'P.E 3', 'Individual/Dual Sports', 'Minor', '1ST', 'SAS'),
(177, 'HUM 6', 'Ethics', 'Minor', '2ND', 'SAS'),
(178, 'Gen Ed 8', 'Panitikan ng Pilipinas', 'Minor', '2ND', 'SAS'),
(179, 'SS Pol Gov', 'Politics and Governance with Phil Constitution', 'Major', '2ND', 'SAS'),
(180, 'SS ECOTAR', 'Basic Economics with Taxation and agrarian Reform', 'Minor', '2ND', 'SAS'),
(181, 'NS ENV SCI', 'Environmental Science', 'Minor', '2ND', 'SAS'),
(182, 'Com 104', 'Community Communication', 'Major', '2ND', 'SAS'),
(183, 'Com 106', 'Print Media Principles and Practices', 'Major', '2ND', 'SAS'),
(184, 'Com 107', 'Radio & TV Principles and Practices', 'Major', '2ND', 'SAS'),
(185, 'P.E 4', 'Team Sports', 'Minor', '2ND', 'SAS'),
(186, 'SS PHIL HIST', 'Philippine History', 'Minor', '1ST', 'SAS'),
(187, 'Educ 1A', 'Educational and Industrial Psychology', 'Major', '1ST', 'SAS'),
(188, 'Com 108', 'Advertising and public Information', 'Major', '1ST', 'SAS'),
(189, 'Com 109', 'Writing for Print Media', 'Major', '1ST', 'SAS'),
(190, 'Com 110', 'Interpesonal Communication', 'Major', '1ST', 'SAS'),
(191, 'Com 111', 'Desktop Publishing', 'Major', '1ST', 'SAS'),
(192, 'Com 112', 'Media Management & Entrepreneurship', 'Major', '2ND', 'SAS'),
(193, 'Lang 112', 'FOREIGN LANGUAGE', 'Major', '2ND', 'SAS'),
(194, 'Com 113', 'Writing for Radio  & TV', 'Major', '2ND', 'SAS'),
(195, 'Com 114', 'Intro to Book Publishing', 'Major', '2ND', 'SAS'),
(196, 'Com 115', 'Radio and TV Production', 'Major', '2ND', 'SAS'),
(197, 'Com 116', 'Organizational Communication', 'Major', '2ND', 'SAS'),
(198, 'Anthro 1', 'Antrhopology', 'Minor', '1ST', 'SAS'),
(199, 'RIZAL', 'Life, Works and Writings', 'Minor', '1ST', 'SAS'),
(200, 'Lang 113', 'FOREIGN LANGUAGE 2', 'Major', '1ST', 'SAS'),
(201, 'Com 117', 'Intro to Communication Research', 'Major', '1ST', 'SAS'),
(202, 'Com 118', 'Educational Broadcasting', 'Major', '1ST', 'SAS'),
(203, 'Thesis 101', 'Thesis Writing', 'Major', '2ND', 'SAS'),
(204, 'Intern 101', 'Internship', 'Major', '2ND', 'SAS'),
(205, 'Hist 2', 'Asian History', 'Major', '2ND', 'SAS'),
(206, 'Hist 3', 'World history and civilaztion (Prehistory-1500)', 'Major', '1ST', 'SAS'),
(207, 'SS BASGEO', 'Basic Geography', 'Major', '2ND', 'SAS'),
(208, 'SS 101', 'Introduction to Political Science & Political Theories', 'Major', '2ND', 'SAS'),
(209, 'SS 102', 'World Geography', 'Major', '2ND', 'SAS'),
(210, 'SS 103', 'Advanced Economics', 'Major', '2ND', 'SAS'),
(211, 'SS 104', 'Advanced Philippine History', 'Major', '2ND', 'SAS'),
(212, 'SS 105', 'Cultural Anthropolgy', 'Major', '2ND', 'SAS'),
(213, 'SS 106', 'Parliamentary Rules and Procedures', 'Major', '2ND', 'SAS'),
(214, 'SS 107', 'Current Trends and Issues in Social Studies', 'Major', '2ND', 'SAS'),
(215, 'HUM 2', 'Philosopy (Logic & Ethics)', 'Minor', '1ST', 'SAS'),
(216, 'Lit 2', 'World Literature', 'Minor', '1ST', 'SAS'),
(217, 'SS SOC CUL', 'Society and Culture with Family Planning', 'Minor', '1ST', 'SAS'),
(218, 'SS 108', 'Comparative Government and Politics', 'Major', '1ST', 'SAS'),
(219, 'SS 109', 'Local Government Units', 'Major', '1ST', 'SAS'),
(220, 'SS 110', 'Public Administration and Systems of Government', 'Major', '1ST', 'SAS'),
(221, 'SS 111', 'World history and civilaztion (1500-Present)', 'Major', '1ST', 'SAS'),
(222, 'SS 112', 'Asian Studies (Middleand Far East)', 'Major', '1ST', 'SAS'),
(223, 'Philo 2', 'Philosophy of Man', 'Minor', '2ND', 'SAS'),
(224, 'M STAT', 'Statistics', 'Minor', '2ND', 'SAS'),
(225, 'SS 114', 'African Studies', 'Major', '2ND', 'SAS'),
(226, 'SS 115', 'Latin American Studies', 'Major', '2ND', 'SAS'),
(227, 'SS 116', 'American Politics, Government & Foreign Relations', 'Major', '2ND', 'SAS'),
(228, 'SS 117', 'European Studies', 'Major', '2ND', 'SAS'),
(229, 'SS 118', 'Australian Studies', 'Major', '2ND', 'SAS'),
(230, 'Philo 3', 'Inductive Reasoning', 'Minor', '1ST', 'SAS'),
(231, 'SS 120', 'labor Code of the Philippines', 'Major', '1ST', 'SAS'),
(232, 'SS 121', 'Human Rights and Peace Education', 'Major', '1ST', 'SAS'),
(233, 'SS 122', 'International Relation and Politics', 'Major', '1ST', 'SAS'),
(234, 'SS 123', 'Economic Planning and Development', 'Major', '1ST', 'SAS'),
(235, 'SS 125', 'The Family Code of The Philippines', 'Major', '1ST', 'SAS'),
(236, 'SS 126', 'Researches in Social Science', 'Major', '1ST', 'SAS'),
(237, 'SS 127', 'Internship', 'Major', '2ND', 'SAS'),
(238, 'ENG PLUS', 'Communicative Grammar', 'Minor', '1ST', 'COED'),
(239, 'MATH 1', 'Integrated Mathematics', 'Minor', '1ST', 'COED'),
(240, 'Fil 1', 'Komunikasyon sa Akademikong Filipino', 'Major', '1ST', 'COED'),
(241, 'NS BIO SCI', 'Foundations of biological Sciences', 'Minor', '1ST', 'COED'),
(242, 'HUM 1', 'Arts, Man and Society', 'Minor', '1ST', 'COED'),
(243, 'SS GEN PSYCH', 'general Psychology with Drug Addiction Education', 'Minor', '1ST', 'COED'),
(244, 'FW INTROWIK', 'Introduction sa pag-aaral ng Wika', 'Major', '1ST', 'COED'),
(245, 'FP PANFIL', 'Panitikang Filipino', 'Major', '1ST', 'COED'),
(246, 'P.E 1', 'Physical Fitness', 'Minor', '1ST', 'COED'),
(247, 'NSTP 1', 'ROTC/CWTS/LTS', 'Minor', '1ST', 'COED'),
(248, 'Eng 1', 'Study and Thinking Skills', 'Minor', '2ND', 'COED'),
(249, 'MATH 2', 'Contemporary Mathematics', 'Minor', '2ND', 'COED'),
(250, 'FIL 2', 'Pagbasa at Pagsulat tungo sa Pananaliksik', 'Minor', '2ND', 'COED'),
(251, 'LIT 1', 'Philippine Literature', 'Minor', '2ND', 'COED'),
(253, 'Emajor 2', 'Introduction to Linguistic', 'Major', '2ND', 'COED'),
(254, 'Emajor 3', 'Structure of English', 'Major', '2ND', 'COED'),
(255, 'Emajor 6', 'Afro-Asian Literaure', 'Major', '2ND', 'COED'),
(256, 'Emajor 20', 'Campus Journalism', 'Major', '2ND', 'COED'),
(257, 'PE 2', 'Rhythmic Activities', 'Minor', '2ND', 'COED'),
(258, 'NSTP 2', 'ROTC/CWTS/LTS', 'Minor', '2ND', 'COED'),
(259, 'Eng 2', 'Speech Communication', 'Minor', '1ST', 'COED'),
(260, 'Fil 3', 'Masining na Pagpapahayag', 'Minor', '1ST', 'COED'),
(261, 'LIT 2', 'World Literature', 'Minor', '1ST', 'COED'),
(262, 'Educ 1', 'Child and Adolescent Development', 'Minor', '1ST', 'COED'),
(264, 'Educ 2', 'Social Dimensions of Education', 'Minor', '1ST', 'COED'),
(265, 'FS 1', 'The Learners development and environment', 'Minor', '1ST', 'COED'),
(266, 'Emajor 5', 'Translation and Editing of text', 'Major', '1ST', 'COED'),
(267, 'Emajor 9', 'The teaching of listening and Reading', 'Major', '1ST', 'COED'),
(268, 'Emajor 10', 'Teaching of Literature', 'Major', '1ST', 'COED'),
(269, 'P.E 3', 'Individual/Dual Sports', 'Minor', '1ST', 'COED'),
(270, 'Eng 3', 'Writing in discipline', 'Minor', '2ND', 'COED'),
(271, 'FS 2', 'Experiencing the Teaching-Learning Process', 'Minor', '2ND', 'COED'),
(272, 'Educ 3', 'Facilitating Learning', 'Major', '2ND', 'COED'),
(273, 'Educ 4', 'Principles of Teaching 1', 'Major', '2ND', 'COED'),
(274, 'Educ 6', 'Development Reading 1', 'Major', '2ND', 'COED'),
(275, 'Educ 11', 'Assessment of Student Learning 1', 'Major', '2ND', 'COED'),
(276, 'Emajor 4', 'LiteraryCriticism', 'Major', '2ND', 'COED'),
(277, 'Emajor 7', 'English and American Literature', 'Minor', '2ND', 'COED'),
(278, 'Emajor 8', 'teaching of speaking', 'Major', '2ND', 'COED'),
(279, 'P.E 4', 'Team Sports', 'Minor', '2ND', 'COED'),
(280, 'Educ 5', 'Principles of Teaching 2', 'Major', '1ST', 'COED'),
(281, 'Educ 8', 'Curriculum Development', 'Major', '1ST', 'COED'),
(282, 'FS 4', 'Exploring the Curriculum', 'Minor', '1ST', 'COED'),
(283, 'Educ 9', 'Educational technology 1', 'Major', '1ST', 'COED'),
(284, 'Educ 12', 'Assessment of Student Learning 2', 'Major', '1ST', 'COED'),
(285, 'FS 5', 'learning and Assessment Strategy', 'Minor', '1ST', 'COED'),
(286, 'Emajor 11', 'language and literature assessment', 'Major', '1ST', 'COED'),
(287, 'Emajor 12', 'Language and society', 'Major', '1ST', 'COED'),
(288, 'SS Pol Gov', 'Politics and Governance w/ New Constitution', 'Minor', '1ST', 'COED'),
(289, 'Educ 10', 'Educational technology 2', 'Major', '2ND', 'COED'),
(290, 'FS 3', 'Technology in the learning environment', 'Minor', '2ND', 'COED'),
(291, 'Educ 13', 'Non-Formal education and Community Immersion', 'Major', '2ND', 'COED'),
(292, 'Educ 15', 'the Teaching Professions', 'Major', '2ND', 'COED'),
(293, 'FS 6', 'On Becoming a Teacher', 'Minor', '2ND', 'COED'),
(294, 'Emajor 13', 'Methodology and Folklore', 'Major', '2ND', 'COED'),
(295, 'Emajor 14', 'Preparation and Evaluation of Teaching Materials', 'Major', '2ND', 'COED'),
(296, 'Emajor 15', 'Remedial Instruction in english', 'Major', '2ND', 'COED'),
(297, 'Emajor 16', 'Creative writing', 'Major', '2ND', 'COED'),
(298, 'Emajor 17', 'Speech and Stage Arts', 'Major', '2ND', 'COED'),
(299, 'SS PHIL HIST', 'Philippine History', 'Minor', '2ND', 'COED'),
(300, 'Elective', '(Choose from the List)', 'Minor', '1ST', 'COED'),
(301, 'RIZAL', 'Life, Works and Writings', 'Major', '1ST', 'COED'),
(302, 'SP 1,2,3', 'Special Topics 1,2, & 3', 'Major', '1ST', 'COED'),
(303, 'SS ECOTAR', 'Basic Economics with Taxation and agrarian Reform', 'Minor', '1ST', 'COED'),
(304, 'SS SOC CUL', 'Society and Culture with Family Planning', 'Minor', '1ST', 'COED'),
(305, 'HUM 2', 'Logic and Ethics', 'Minor', '1ST', 'COED'),
(306, 'Emajor 18 ', 'Introduction to Stylistics', 'Major', '1ST', 'COED'),
(307, 'Emajor 19', 'English for specific Purpose', 'Major', '1ST', 'COED'),
(308, 'Educ 16', 'Student Teaching', 'Major', '2ND', 'COED'),
(309, 'NS ENV SCI', 'Environmental Science', 'Minor', '2ND', 'COED'),
(310, 'Gen Ed 13', 'Ecology', 'Major', '2ND', 'COED'),
(311, 'Gen Ed 11', 'Atronomy', 'Major', '2ND', 'COED'),
(312, 'CALGEB 105', 'College and Advance Algebra', 'Major', '1ST', 'CIT'),
(313, 'PSTRIG 104', 'Plane and Spherical Trigonometry', 'Major', '1ST', 'CIT'),
(314, 'GELCHEM 114', 'General Chemistry', 'Major', '1ST', 'CIT'),
(315, 'ANAGEO 104', 'Analytic Geometry', 'Major', '2ND', 'CIT'),
(316, 'SOLIDM103', 'Solid mensuration', 'Major', '2ND', 'CIT'),
(317, 'PHYSIC 114', 'Physics 1 (Mechanics)', 'Major', '2ND', 'CIT'),
(318, 'DIFCAL 204', 'Differential Calculus', 'Major', '1ST', 'CIT'),
(319, 'PHYSIC 214', 'Physics 2(Heat, Electricity & Magnetism, Sound & Light)', 'Major', '1ST', 'CIT'),
(320, 'COMFUN 222', 'Computer Fundamentals and Programming', 'Major', '1ST', 'CIT'),
(321, 'INTCAL 204', 'Intregal  Calculus', 'Major', '2ND', 'CIT'),
(322, 'STATCS 203', 'Probability and Statistic', 'Major', '2ND', 'CIT'),
(323, 'ELCENG 203', 'Basic electrical Engineering', 'Major', '2ND', 'CIT'),
(324, 'MECRIG 305', 'Mechanics of Rigid Bodies', 'Major', '1ST', 'CIT'),
(325, 'ELSUV 314', 'Elementary Surveying', 'Major', '1ST', 'CIT'),
(326, 'DIFFEQ 303', 'Differential Equation', 'Major', '1ST', 'CIT'),
(328, 'MECENG 303', 'Basic Mechanical Engineering', 'Major', '1ST', 'CIT'),
(329, 'EMANGT 303', 'Engineering Management', 'Major', '1ST', 'CIT'),
(330, 'BDSGN1 313', 'Building Design 1(Basic Architecture 1)', 'Major', '1ST', 'CIT'),
(331, 'MECDEF 305', 'Mechanics of Deformable Bodies', 'Major', '2ND', 'CIT');

-- --------------------------------------------------------

--
-- Table structure for table `sy`
--

CREATE TABLE `sy` (
  `syid` int(11) NOT NULL,
  `sy` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sy`
--

INSERT INTO `sy` (`syid`, `sy`) VALUES
(2, '2016-2017'),
(3, '2015-2016'),
(4, '2017-2018'),
(5, '2018-2019');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teachid` int(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `arank` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teachid`, `fname`, `lname`, `arank`, `designation`, `department`) VALUES
(9, 'Marnyl John', 'Abeto', '', 'Part-Time', 'CIT'),
(10, 'Judy', 'Astodillo', '', 'Part-Time', 'CIT'),
(12, 'Zenaida', 'Aungon', '', 'Part-Time', 'CIT'),
(13, 'Mark Dave', 'baylosis', '', 'Part-Time', 'CIT'),
(14, 'Reno', 'Bentinganan', '', 'Part-Time', 'CIT'),
(15, 'Lucillos', 'Buyco', '', 'Part-Time', 'CIT'),
(17, 'Yrika Marie', 'Dusaran', '', 'Part-Time', 'CIT'),
(18, 'Neil Gabriel', 'Esgra', '', 'Part-Time', 'CIT'),
(19, 'Gegantoni', '', 'dasdasda', 'Part-Time', 'CIT'),
(20, 'Jerry', 'Gumata', '', 'Part-Time', 'CIT'),
(21, 'Perico', 'Hernaez', '', 'Part-Time', 'CIT'),
(22, 'Marcelo', 'Jandongan', '', 'Part-Time', 'CIT'),
(23, 'Jo-an', 'Juesna', '', 'Part-Time', 'CIT'),
(24, 'Aurelio', 'Lacson', '', 'Part-Time', 'CIT'),
(25, 'Marcelino', 'Laruan', '', 'Part-Time', 'CIT'),
(26, 'Ariel', 'Magbanua', '', 'Full Time', 'CIT'),
(28, 'Ruby Mae', 'Morante', '', 'Part-Time', 'CIT'),
(29, 'Robert', 'Navarez', '', 'Part-Time', 'CIT'),
(31, 'Charwin', 'Padilla', '', 'Part-Time', 'CIT'),
(32, 'Melanie', 'Porquez', '', 'Part-Time', 'CIT'),
(33, 'Jose Leo', 'Redoblo', '', 'Part-Time', 'CIT'),
(34, 'Ramon', 'Romblon III', '', 'Part-Time', 'CIT'),
(35, 'Hertzell', 'Sian', '', 'Part-Time', 'CIT'),
(36, 'Reynaldo', 'Soguilon', '', 'Part-Time', 'CIT'),
(37, 'Gloria', 'Sorilla', '', 'Part-Time', 'CIT'),
(38, 'Maricel', 'Suyo', '', 'Part-Time', 'CIT'),
(39, 'Kaj Neil', 'Ta-ala', '', 'Part-Time', 'CIT'),
(40, 'Jonah', 'Tarrosa', '', 'Part-Time', 'CIT'),
(42, 'Engiemar', 'Tupas', '', 'Part-Time', 'CIT'),
(43, 'Samuel Fredco', 'Villena', '', 'Part-Time', 'CIT'),
(44, 'Philamae', 'Yula', '', 'Part-Time', 'CIT'),
(46, 'Jomar', 'Pabuaya', 'Instructor 1 ', 'Permanent', 'CIT'),
(47, 'Rammel', 'Cadagat', 'Instructor 1 ', 'Permanent', 'CIT'),
(48, 'Sally', 'Cadiz', 'Prof. V', 'Permanent', 'CIT'),
(49, 'Nieves', 'Barato', 'Instructor 1 ', 'Permanent', 'CIT'),
(50, 'Neuyer', 'Bala-an', 'Instructor III', 'Permanent', 'CIT'),
(51, 'Rogelio', 'Cango', 'Prof. V', 'Permanent', 'CIT'),
(52, 'Jaaziel', 'Abellana', '', 'Part-Time', 'CIT'),
(53, 'Aurora', 'Apuhin', 'Instructor 1 ', 'Part-Time', 'CIT'),
(54, 'Joelyn', 'Arquio', '', 'Part-Time', 'CIT'),
(55, 'John Rey', 'Baylosis', '', 'Part-Time', 'CIT'),
(56, 'Billy June', 'Caballero', '', 'Part-Time', 'CIT'),
(57, 'Lorna', 'Cabusog', '', 'Part-Time', 'CIT'),
(58, 'Gemma', 'Card', '', 'Part-Time', 'CIT'),
(59, 'Divine Grace', 'Cataluna', '', 'Part-Time', 'CIT'),
(60, 'Riza', 'Deocadez', '', 'Part-Time', 'CIT'),
(61, 'Romeo', 'Desabella Jr.', '', 'Part-Time', 'CIT'),
(62, 'Edwin', 'Ditching', '', 'Part-Time', 'CIT'),
(63, 'Merilyn', 'Gaitan', '', 'Part-Time', 'CIT'),
(64, 'Vicky', 'Gasper', 'n/a', 'Part-Time', 'CIT'),
(65, 'Christine Thel', 'Geollegue', '', 'Part-Time', 'CIT'),
(66, 'Marjorie', 'Jalea', '', 'Part-Time', 'CIT'),
(67, 'Rufus', 'Javier', 'n/a', 'Part-Time', 'CIT'),
(68, 'Shiela Mae', 'Lim', 'n/a', 'Part-Time', 'CIT'),
(69, 'Christian', 'Montoho', 'n/a', 'Part-Time', 'CIT'),
(70, 'Joni cleo', 'Pacalioga', 'n/a', 'Part-Time', 'CIT'),
(71, 'Febe', 'Quingco', 'n/a', 'Part-Time', 'CIT'),
(72, 'Joshua Lancelot', 'Sabio', 'n/a', 'Part-Time', 'CIT'),
(73, 'Rhoderick', 'Samonte', '', 'Part-Time', 'CIT'),
(74, 'Nino', 'Santillan', '', 'Part-Time', 'CIT'),
(75, 'Enriquita', 'Sazon', 'n/a', 'Part-Time', 'CIT'),
(76, 'Jescel', 'Sison', 'n/a', 'Part-Time', 'CIT'),
(77, 'Yvette', 'Ybanes', 'n/a', 'Part-Time', 'CIT'),
(78, 'Ma. Lourdes', 'Li', 'n/a', 'Part-Time', 'CIT'),
(79, 'Reynelie', 'Alcansare', 'n/a', 'Part-Time', 'CIT'),
(80, 'Manuel Andres', 'Buncio', 'n/a', 'Part-Time', 'CIT'),
(87, 'Jessica', 'Agiurre', 'n/a', 'Part-Time', 'CIT'),
(89, 'Norberto', 'Mangulabnan', '', 'Part-Time', 'SAS'),
(90, 'Roselyn', 'Alegarbes', 'n/a', 'Part', 'COED'),
(91, 'Rosita', 'Arandilla', 'n/a', 'Permanent', 'COED'),
(92, 'Lilibeth', 'Balsicas', 'n/a', 'Permanent', 'COED'),
(93, 'Mary Rose ', 'Banyas', 'n/a', 'Permanent', 'COED'),
(94, 'Ma. Luisa', 'Bayona', 'n/a', 'Permanent', 'COED'),
(95, 'Orlando', 'Benales', 'n/a', 'Part-Time', 'COED'),
(96, 'Calopez', '', 'Prof. V', 'Part-Time', 'COED'),
(97, 'Orlando', 'Benales', 'n/a', 'Part-Time', 'COED'),
(98, 'Ma. Victoria', 'Cango', 'n/a', 'Permanent', 'COED'),
(99, 'Maria Luna', 'Dela Cerna', 'Assisstant Prof 1', 'Permanent', 'COED'),
(100, 'Dicto', 'Dante', 'Assisstant Prof III', 'Permanent', 'COED'),
(101, 'Baby Jean', 'Flores', 'Instructor 1 ', 'Part-Time', ''),
(102, 'Joelyn', 'Gaitan', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `name`, `department`, `username`, `password`) VALUES
(1, 'Cherylda Ohiman', 'CIT', 'CIT', 'ohiman123'),
(3, 'jemelyn', 'COED', 'COED', 'jemelyn'),
(4, 'ching', 'Admin', 'ADMIN', 'admin'),
(5, 'Rose ann', 'CIT', 'rose123', '12345'),
(7, 'Babyjean', 'CAS', 'CAS', 'flores');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classsched`
--
ALTER TABLE `classsched`
  ADD PRIMARY KEY (`classid`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`courseid`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`deptid`);

--
-- Indexes for table `examsched`
--
ALTER TABLE `examsched`
  ADD PRIMARY KEY (`examid`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`roomid`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`semesterid`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subjectid`);

--
-- Indexes for table `sy`
--
ALTER TABLE `sy`
  ADD PRIMARY KEY (`syid`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teachid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classsched`
--
ALTER TABLE `classsched`
  MODIFY `classid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `courseid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `deptid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `examsched`
--
ALTER TABLE `examsched`
  MODIFY `examid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `roomid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `semesterid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subjectid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=332;
--
-- AUTO_INCREMENT for table `sy`
--
ALTER TABLE `sy`
  MODIFY `syid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teachid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
