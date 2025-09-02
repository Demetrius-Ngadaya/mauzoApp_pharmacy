-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2024 at 05:33 PM
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
-- Database: `simplepharmacy`
--

-- --------------------------------------------------------

--
-- Table structure for table `expenditure`
--

CREATE TABLE `expenditure` (
  `expenditure_id` int(200) NOT NULL,
  `expenditure_name` varchar(200) NOT NULL,
  `expenditure_amount` int(200) NOT NULL,
  `expenditure_description` varchar(222) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenditure`
--

INSERT INTO `expenditure` (`expenditure_id`, `expenditure_name`, `expenditure_amount`, `expenditure_description`, `created_at`, `updated_at`) VALUES
(1, 'WWW', 44, 'SS', '2024-08-21', '2024-12-27'),
(2, 'ee', 444, 'e', '2024-11-19', '2024-10-19'),
(4, 'bbbbbbb', 1000, 'h', '2024-03-19', '2024-03-19'),
(5, 'leo', 900, 'majaribio', '2029-03-20', '2024-03-20'),
(8, 'uu', 777, 'yyy', '2024-03-21', '2024-12-12');

-- --------------------------------------------------------

--
-- Table structure for table `on_hold`
--

CREATE TABLE `on_hold` (
  `id` int(11) NOT NULL,
  `invoice_number` varchar(13) NOT NULL,
  `medicine_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `expire_date` date NOT NULL,
  `qty` bigint(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `cost` bigint(11) NOT NULL,
  `amount` bigint(11) NOT NULL,
  `profit_amount` bigint(11) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `on_hold`
--

INSERT INTO `on_hold` (`id`, `invoice_number`, `medicine_name`, `category`, `expire_date`, `qty`, `type`, `cost`, `amount`, `profit_amount`, `date`) VALUES
(149, 'CA-0929992', 'Demo Med', 'Demo Category', '2022-08-17', 2, 'Tab', 18, 36, 16, '02/28/2024'),
(150, 'CA-9992220', 'Doxycycline', 'Antibiotics', '2025-08-09', 3, 'Tab', 4, 12, 6, '02/28/2024'),
(152, 'CA-2990902', 'Doxycycline', 'Antibiotics', '2025-08-09', 2, 'Tab', 4, 8, 4, '02/28/2024'),
(157, 'CA-0992099', '', '', '0000-00-00', 3, '', 0, 0, 0, '02/28/2024'),
(158, '$invoice_numb', 'Fluconazole', 'Antifungals', '2026-08-13', 3, 'Tab', 29, 87, 21, '02/28/2024'),
(169, 'CA-99302033', 'Alprazolam', 'Tranquilizer', '2026-10-06', 10, 'Tab', 19, 190, 90, '02/28/2024'),
(171, 'CA-9920030', 'Mucinex', 'Expectorant', '2026-08-25', 9, 'Bot', 37, 333, 72, '02/28/2024'),
(172, 'CA-0300009', 'Fluconazole', 'Antifungals', '2026-08-13', 9, 'Tab', 29, 261, 63, '02/28/2024'),
(173, 'CA-2920900', 'Doxycycline', 'Antibiotics', '2025-08-09', 2, 'Tab', 4, 8, 4, '02/28/2024'),
(174, 'CA-0920923', 'Methisazone', 'Antiviral', '2026-08-03', 4, 'Tab', 12, 48, 16, '02/28/2024'),
(175, 'CA-9299200', 'Deplin', 'Vitamins', '2026-09-14', 3, 'Sachet', 141, 423, 84, '02/28/2024'),
(176, '$invoice_numb', 'Doxycycline', 'Antibiotics', '2025-08-09', 3, 'Tab', 4, 12, 6, '02/28/2024'),
(177, '292292', 'Alprazolam', 'Tranquilizer', '2026-10-06', 1, 'Tab', 19, 19, 9, '02/28/2024'),
(178, 'CA-3993200', 'Biogesic', 'Painkiller', '2023-03-06', 1, 'Bot', 9, 9, 4, '02/28/2024'),
(179, 'CA-3993200', 'Doxycycline', 'Antibiotics', '2025-08-09', 10, 'Tab', 4, 40, 20, '02/28/2024'),
(181, '$invoice_numb', 'Biogesic', 'Painkiller', '2023-03-06', 3, 'Bot', 9, 27, 12, '02/28/2024'),
(183, 'CA-3900200', 'Biogesic', 'Painkiller', '2023-03-06', 5, 'Bot', 9, 45, 20, '02/29/2024'),
(184, '$invoice_numb', 'Demo Med', 'Demo Category', '2022-08-17', 3, 'Tab', 18, 54, 24, '02/29/2024'),
(188, 'CA-993020300', 'Mucinex', 'Expectorant', '2026-08-25', 10, 'Bot', 37, 370, 80, '02/29/2024'),
(189, '$invoice_numb', 'Demo Med', 'Demo Category', '2022-08-17', 2, 'Tab', 18, 36, 16, '02/29/2024'),
(192, 'CA-2390900', 'Biogesic', 'Painkiller', '2023-03-06', 4, 'Bot', 9, 36, 16, '02/29/2024'),
(193, 'CA-9009939', 'Demo Med', 'Demo Category', '2022-08-17', 7, 'Tab', 18, 126, 56, '02/29/2024'),
(194, '$invoice_numb', 'Methisazone', 'Antiviral', '2026-08-03', 9, 'Tab', 12, 108, 36, '02/29/2024'),
(195, '$invoice_numb', 'Methisazone', 'Antiviral', '2026-08-03', 3, 'Tab', 12, 36, 12, '02/29/2024'),
(196, 'CA-2099022', 'Methisazone', 'Antiviral', '2026-08-03', 9, 'Tab', 12, 108, 36, '02/29/2024'),
(197, 'CA-0020003', 'Demo Med', 'Demo Category', '2022-08-17', 8, 'Tab', 18, 144, 64, '02/29/2024'),
(198, 'CA-0020003', 'Demo Med', 'Demo Category', '2022-08-17', 7, 'Tab', 18, 126, 56, '02/29/2024'),
(202, 'CA-0399290', 'Doxycycline', 'Antibiotics', '2025-08-09', 9, 'Tab', 4, 36, 18, '03/16/2024'),
(203, 'CA-9320300', 'JJJ', 'JJJ', '2024-02-29', 7, 'Bot', 222, 1554, 1477, '03/17/2024'),
(206, 'CA-0909030', 'Mwendo', 'Mikono', '2024-03-08', 5, 'Bot', 900, 4500, 2500, '03/19/2024'),
(207, 'CA-0009293', 'Methisazone', 'Antiviral', '2026-08-03', 6, 'Tab', 12, 72, 24, '03/19/2024'),
(208, 'CA-0009293', 'Methisazone', 'Antiviral', '2026-08-03', 6, 'Tab', 12, 72, 24, '03/19/2024'),
(209, 'CA-0999029', 'Fluconazole', 'Antifungals', '2026-08-13', 9, 'Tab', 29, 261, 63, '03/20/2024'),
(210, 'CA-2030090', 'SS', 'DDD', '2024-02-29', 4, 'Bot', 222, 888, 844, '03/23/2024'),
(211, 'CA-0300990', 'Biogesic', 'Painkiller', '2023-03-06', 9, 'Bot', 9, 81, 36, '03/23/2024'),
(212, 'CA-0009900', 'Fluconazole', 'Antifungals', '2026-08-13', 7, 'Tab', 29, 203, 49, '03/25/2024'),
(213, 'CA-9090032', 'Demo Med', 'Demo Category', '2022-08-17', 4, 'Tab', 18, 72, 32, '03/25/2024'),
(214, 'CA-2090002', 'Biogesic', 'Painkiller', '2023-03-06', 8, 'Bot', 9, 72, 32, '03/25/2024'),
(215, '$invoice_numb', 'Dawa', 'SSSS', '2024-02-29', 9, 'Bot', 2, 18, -981, '03/25/2024'),
(216, 'CA-9929022', 'Doxycycline', 'Antibiotics', '2025-08-09', 6, 'Tab', 4, 24, 12, '03/25/2024'),
(217, 'CA-2220299', 'Deplin', 'Vitamins', '2026-09-14', 4, 'Sachet', 141, 564, 112, '03/26/2024'),
(219, 'CA-9003300', 'Biogesic', 'Painkiller', '2023-03-06', 3, 'Bot', 9, 27, 12, '03/26/2024'),
(220, 'CA-9000902', 'Doxycycline', 'Antibiotics', '2025-08-09', 8, 'Tab', 4, 32, 16, '03/26/2024'),
(221, 'CA-2029009', 'Methisazone', 'Antiviral', '2026-08-03', 8, 'Tab', 12, 96, 32, '03/28/2024'),
(222, 'CA-3223939', 'Altretamine', 'Antineoplastics', '2026-08-12', 4, 'Sachet', 87, 348, 56, '03/29/2024'),
(223, 'CA-0009030', 'Deplin', 'Vitamins', '2026-09-14', 4, 'Sachet', 141, 564, 112, '03/29/2024'),
(224, 'CA-9902099', 'Doxycycline', 'Antibiotics', '2025-08-09', 3, 'Tab', 4, 12, 6, '03/29/2024'),
(225, 'CA-0030009', 'Mwendo', 'Mikono', '2024-03-08', 2, 'Bot', 900, 1800, 1000, '03/29/2024'),
(226, 'CA-3002909', 'Biogesic', 'Painkiller', '2023-03-06', 7, 'Bot', 9, 63, 28, '03/29/2024'),
(227, 'CA-0330203', 'Doxycycline', 'Antibiotics', '2025-08-09', 8, 'Tab', 4, 32, 16, '03/29/2024'),
(228, 'CA-9020320', 'Doxycycline', 'Antibiotics', '2025-08-09', 1, 'Tab', 4, 4, 2, '03/29/2024'),
(229, 'CA-9009902', 'Deplin', 'Vitamins', '2026-09-14', 3, 'Sachet', 141, 423, 84, '03/29/2024'),
(230, 'CA-3022900', 'SS', 'DDD', '2024-02-29', 1, 'Bot', 222, 222, 211, '03/29/2024'),
(232, 'CA-9039900', 'Doxycycline', 'Antibiotics', '2025-08-09', 3, 'Tab', 4, 12, 6, '03/31/2024'),
(233, 'CA-9303003', 'Deme', 'ANTIBIOTIC', '2024-03-09', 8, 'Tab', 1000, 8000, 1600, '04/03/2024'),
(234, 'CA-0099099', 'Fluconazole', 'Antifungals', '2026-08-13', 8, 'Tab', 29, 232, 56, '04/08/2024'),
(237, 'CA-0020032', 'Fluconazole', 'Antifungals', '2026-08-13', 1, 'Tab', 29, 29, 7, '04/09/2024'),
(238, 'CA-9992000', 'Doxycycline', 'Antibiotics', '2025-08-09', 1, 'Tab', 4, 4, 2, '04/09/2024'),
(239, 'CA-9092900', 'Doxycycline', 'Antibiotics', '2025-08-09', 1, 'Tab', 4, 4, 2, '04/09/2024'),
(240, 'CA-9209390', 'Deme', 'ANTIBIOTIC', '2024-03-09', 2, 'Tab', 1000, 2000, 400, '04/09/2024'),
(241, 'CA-2300032', 'Doxycycline', 'Antibiotics', '2025-08-09', 1, 'Tab', 4, 4, 2, '04/09/2024'),
(242, 'CA-3320023', 'Deme', 'ANTIBIOTIC', '2024-03-09', 2, 'Tab', 1000, 2000, 400, '04/09/2024'),
(243, 'CA-0090039', 'Alprazolam', 'Tranquilizer', '2026-10-06', 10, 'Tab', 19, 190, 90, '04/09/2024'),
(244, 'CA-9202920', 'Altretamine', 'Antineoplastics', '2026-08-12', 1, 'Sachet', 87, 87, 14, '04/09/2024'),
(245, 'CA-0922029', 'Doxycycline', 'Antibiotics', '2025-08-09', 2, 'Tab', 4, 8, 4, '04/09/2024'),
(246, 'CA-9923309', 'Altretamine', 'Antineoplastics', '2026-08-12', 1, 'Sachet', 87, 87, 14, '04/09/2024'),
(247, 'CA-0900039', 'Doxycycline', 'Antibiotics', '2025-08-09', 1, 'Tab', 4, 4, 2, '04/09/2024');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `invoice_number` varchar(13) NOT NULL,
  `medicines` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `total_amount` bigint(11) NOT NULL,
  `total_profit` bigint(11) NOT NULL,
  `created_by` varchar(200) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `invoice_number`, `medicines`, `quantity`, `total_amount`, `total_profit`, `created_by`, `Date`) VALUES
(66, 'CA-2390900', 'Biogesic', '4(Bot)', 1000, 16, '', '2024-01-17'),
(72, 'CA-9003300', 'Biogesic', '3(Bot)', 8000, 12, '', '2024-08-26'),
(75, 'CA-0009030', 'Deplin', '4(Sachet)', 564, 112, '', '2024-03-29'),
(78, 'CA-3002909', 'Biogesic', '7(Bot)', 63, 28, '', '2024-03-29'),
(79, 'CA-0330203', 'Doxycycline', '8(Tab)', 0, 0, 'deme', '2024-03-29'),
(80, 'CA-0330203', 'Doxycycline', '8(Tab)', 0, 0, 'deme', '2024-03-29'),
(81, 'CA-9020320', 'Doxycycline', '1(Tab)', 0, 0, 'deme', '2024-03-29'),
(83, 'CA-9009902', 'Deplin', '3(Sachet)', 423, 84, 'deme', '2024-03-29'),
(85, 'CA-9020320', 'Doxycycline', '1(Tab)', 4, 2, 'deme', '2024-03-29'),
(86, 'CA-9039900', 'Doxycycline', '3(Tab)', 12, 6, 'deme', '2024-03-31'),
(87, 'CA-0099099', 'Fluconazole', '8(Tab)', 232, 56, 'deme', '2024-04-08'),
(88, 'CA-0020032', 'Fluconazole', '1(Tab)', 29, 7, 'deme', '2024-04-09'),
(89, 'CA-9992000', 'Doxycycline', '1(Tab)', 4, 2, 'deme', '2024-04-09'),
(90, 'CA-9992000', 'Doxycycline', '1(Tab)', 4, 2, 'deme', '2024-04-09'),
(91, 'CA-9092900', 'Doxycycline', '1(Tab)', 4, 2, 'deme', '2024-04-09'),
(92, 'CA-9209390', 'Deme', '2(Tab)', 2000, 400, 'deme', '2024-04-09'),
(93, 'CA-9209390', 'Deme', '2(Tab)', 2000, 400, 'deme', '2024-04-09'),
(94, 'CA-2300032', 'Doxycycline', '1(Tab)', 4, 2, 'deme', '2024-04-09'),
(95, 'CA-2300032', 'Doxycycline', '1(Tab)', 4, 2, 'deme', '2024-04-09'),
(96, 'CA-3320023', 'Deme', '2(Tab)', 2000, 400, 'deme', '2024-04-09'),
(97, 'CA-0090039', 'Alprazolam', '10(Tab)', 190, 90, 'deme', '2024-04-09'),
(98, 'CA-9202920', 'Altretamine', '1(Sachet)', 87, 14, 'deme', '2024-04-09'),
(99, 'CA-0922029', 'Doxycycline', '2(Tab)', 8, 4, 'deme', '2024-04-09'),
(100, 'CA-9923309', 'Altretamine', '1(Sachet)', 87, 14, 'deme', '2024-04-09'),
(101, 'CA-0900039', 'Doxycycline', '1(Tab)', 4, 2, 'deme', '2024-04-09');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(100) NOT NULL,
  `bar_code` varchar(255) NOT NULL,
  `medicine_name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `used_quantity` int(100) NOT NULL,
  `remain_quantity` int(100) NOT NULL,
  `act_remain_quantity` int(10) NOT NULL,
  `register_date` date NOT NULL,
  `expire_date` date NOT NULL,
  `stock_alert` int(200) NOT NULL,
  `company` varchar(100) NOT NULL,
  `sell_type` varchar(100) NOT NULL,
  `actual_price` int(100) NOT NULL,
  `selling_price` int(100) NOT NULL,
  `profit_price` varchar(100) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `bar_code`, `medicine_name`, `category`, `quantity`, `used_quantity`, `remain_quantity`, `act_remain_quantity`, `register_date`, `expire_date`, `stock_alert`, `company`, `sell_type`, `actual_price`, `selling_price`, `profit_price`, `created_by`, `status`) VALUES
(21, '1112', 'Paracetemol', 'Painkiller', 20, 22, -2, -2, '2020-03-04', '2022-10-01', 0, 'none', 'Bot', 1, 2, '1(100%)', '', 'Unavailable'),
(23, '1121', 'Biogesic', 'Painkiller', 50, 56, -6, -6, '2020-03-05', '2023-03-06', 0, 'none', 'Bot', 5, 9, '4(80%)', '', 'Unavailable'),
(24, '101', 'Demo Med', 'Demo Category', 100, 100, 0, 1, '2022-08-06', '2022-08-17', 0, 'none', 'Tab', 10, 18, '8(80%)', '', 'Unavailable'),
(25, '1001', 'Doxycycline', 'Antibiotics', 203, 81, 122, 122, '2022-08-11', '2025-08-09', 0, 'none', 'Tab', 2, 4, '2(100%)', '', 'Available'),
(26, '1003', 'Methisazone', 'Antiviral', 300, 74, 226, 226, '2022-08-13', '2026-08-03', 0, 'none', 'Tab', 8, 12, '4(50%)', '', 'Available'),
(27, '1020', 'Deplin', 'Vitamins', 129, 26, 103, 103, '2022-08-10', '2026-09-14', 0, 'none', 'Sachet', 113, 141, '28(25%)', '', 'Available'),
(28, '1169', 'Vitamin B12', 'Vitamins', 288, 10, 278, 278, '2022-08-12', '2026-11-10', 0, 'none', 'Tab', 10, 19, '9(90%)', '', 'Available'),
(29, '2220', 'Altretamine', 'Antineoplastics', 177, 20, 157, 157, '2022-08-13', '2026-08-12', 0, 'none', 'Sachet', 73, 87, '14(19%)', '', 'Available'),
(30, '2022', 'Econazole', 'Antifungals', 247, 4459, -4212, 239, '2022-08-13', '2027-11-17', 0, 'none', 'Sachet', 17, 24, '7(41%)', '', 'Unavailable'),
(31, '1779', 'Fluconazole', 'Antifungals', 155, 75, 80, 80, '2022-08-13', '2026-08-13', 0, 'none', 'Tab', 22, 29, '7(32%)', '', 'Available'),
(32, '1906', 'Mucinex', 'Expectorant', 109, 24, 85, 85, '2022-08-13', '2026-08-25', 0, 'none', 'Bot', 29, 37, '8(28%)', '', 'Available'),
(33, '2779', 'Estazolam', 'Sedatives', 366, 53, 313, 313, '2022-08-13', '2026-08-26', 0, 'none', 'Bot', 41, 54, '13(32%)', '', 'Available'),
(34, '2269', 'Alprazolam', 'Tranquilizer', 287, 26, 261, 261, '2022-08-13', '2026-10-06', 0, 'none', 'Tab', 10, 19, '9(90%)', '', 'Available'),
(36, '', 'Deme', 'ANTIBIOTIC', 90, 12, 78, 78, '2024-02-29', '2024-03-09', 0, '', 'Tab', 800, 1000, '200(25%)', '', 'Available'),
(37, '', 'T', 'L', 0, 0, 0, 0, '2024-02-29', '2024-04-29', 0, '', 'Bot', 33, 33, '0(0%)', '', 'Available'),
(38, '', 'Deme', 'SS', 1, 0, 1, 1, '2024-02-29', '2024-02-29', 0, '', 'Bot', 22, 1, '-21(-95%)', '', 'Available'),
(39, '', 'Mwendo', 'Mikono', 80, 7, 73, 73, '2024-02-29', '2024-03-08', 0, 'D_TECH', 'Bot', 400, 900, '500(125%)', '', 'Available'),
(40, '', 'JJJ', 'JJJ', 22, 7, 15, 22, '2024-02-29', '2024-02-29', 0, 'JJJJ', 'Bot', 11, 222, '211(1918%)', '', 'Available'),
(41, '', 'Dawa', 'SSSS', 33, 9, 24, 33, '2024-02-29', '2024-02-29', 0, 'CCD', 'Bot', 111, 2, '-109(-98%)', '', 'Available'),
(42, '', 'SS', 'DDD', 22, 5, 17, 17, '2024-02-29', '2024-02-29', 0, 'DD', 'Bot', 11, 222, '211(1918%)', '', 'Available'),
(43, '', '22', 'DD`', 22, 0, 22, 22, '2024-02-29', '2024-02-29', 0, 'DD', 'Bot', 11, 22, '11(100%)', '', 'Available'),
(44, '', 'WWW', 'DD', 33, 0, 33, 33, '2024-02-29', '2024-02-29', 0, 'DD', 'Bot', 222, 22, '-200(-90%)', '', 'Available'),
(45, '', '22', 'WW2', 22, 0, 22, 22, '2024-02-29', '2024-02-29', 0, 'WW', 'Bot', 222, 22, '-200(-90%)', '', 'Available'),
(46, '', 'S', 'DUUUUUUUUUU', 22, 0, 22, 22, '2024-02-24', '2024-02-16', 0, 'SS', 'Bot', 221, 2, '-219(-99%)', '', 'Available'),
(47, '', '', '', 0, 0, 0, 0, '1970-01-01', '1970-01-01', 0, '', '', 0, 0, '', '', 'Available'),
(48, '', '', '', 0, 0, 0, 0, '1970-01-01', '1970-01-01', 0, '', '', 0, 0, '', '', 'Available'),
(49, '', 'Sami', 'Sami', 2, 0, 2, 2, '2024-03-29', '2024-04-06', 2, 'sami', 'Bot', 200, 2000, '1800(900%)', 'created_by', 'Ipo'),
(50, '', 'Leo', 'Leo', 20, 0, 20, 20, '2024-03-29', '2024-04-06', 3, 'leo', 'Bot', 100, 150, '50(50%)', 'created_by', 'Ipo'),
(51, '', 'Test', 'Test', 30, 0, 30, 30, '2024-03-29', '2024-04-06', 0, 'test', 'Bot', 2, 3, '1(50%)', 'deme', 'Ipo');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `role` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `role`, `password`) VALUES
(1, 'deme', 'admin', 'deme'),
(2, 'doto', 'cashier', 'doto'),
(3, 'test', 'test', 'test');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expenditure`
--
ALTER TABLE `expenditure`
  ADD PRIMARY KEY (`expenditure_id`);

--
-- Indexes for table `on_hold`
--
ALTER TABLE `on_hold`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `expenditure`
--
ALTER TABLE `expenditure`
  MODIFY `expenditure_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `on_hold`
--
ALTER TABLE `on_hold`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
