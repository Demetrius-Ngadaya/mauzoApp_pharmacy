-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2024 at 09:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmacy`
--

-- --------------------------------------------------------

--
-- Table structure for table `broken_products`
--

CREATE TABLE `broken_products` (
  `id` int(191) NOT NULL,
  `returned_invoice` varchar(200) NOT NULL,
  `returned_medicines` varchar(100) NOT NULL,
  `returned_quantity` int(100) NOT NULL,
  `returned_amount` varchar(100) NOT NULL,
  `profit_lost` varchar(100) NOT NULL,
  `sold_by` varchar(100) NOT NULL,
  `sold_date` date NOT NULL,
  `returned_by` varchar(191) NOT NULL,
  `returned_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `broken_products`
--

INSERT INTO `broken_products` (`id`, `returned_invoice`, `returned_medicines`, `returned_quantity`, `returned_amount`, `profit_lost`, `sold_by`, `sold_date`, `returned_by`, `returned_date`) VALUES
(13, 'CA-0929902', 'Altretamine', 1, '800', '500', 'Demetrius', '2024-08-27', 'Demetrius', '2024-08-27');

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
(1, 'umeme', 17000, 'kulipia umeme dukani', '2024-01-26', '2024-01-26'),
(2, 'wabebaji', 20000, 'kulipa vijana walioshusha mzigo wa mbao', '2024-02-26', '2024-02-26'),
(3, 'umeme', 20000, 'kulipia umeme dukani', '2024-03-26', '2024-03-26'),
(4, 'Umeme', 15000, 'kulipia umeme dukani', '2024-04-26', '2024-04-26'),
(5, 'umeme', 14000, 'kulipia umeme dukani', '2024-05-26', '2024-05-26'),
(6, 'Umeme', 20000, 'kulipia umeme dukani', '2024-06-26', '2024-06-26'),
(7, 'umeme', 18000, 'kulipia umeme dukani', '2024-07-26', '2024-07-26'),
(8, 'umeme', 15000, 'kulipia umeme dukani', '2024-09-26', '2024-08-26'),
(9, 'umeme', 28000, 'kulipia umeme dukani', '2024-08-26', '2024-09-26'),
(10, 'umeme', 22000, 'kulipia umeme dukani', '2024-10-26', '2024-10-26'),
(11, 'umeme', 24000, 'kulipia umeme dukani', '2024-11-26', '2024-11-26'),
(12, 'umeme', 21000, 'kulipia umeme dukani', '2024-12-26', '2024-12-26');

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
  `discount` int(191) NOT NULL,
  `profit_amount` bigint(11) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `on_hold`
--

INSERT INTO `on_hold` (`id`, `invoice_number`, `medicine_name`, `category`, `expire_date`, `qty`, `type`, `cost`, `amount`, `discount`, `profit_amount`, `date`) VALUES
(1, 'CA-3309900', 'Altretamine', 'Antineoplastics', '2024-08-20', 25, 'Sachet', 800, 20000, 800, 12500, '08/27/2024'),
(2, 'CA-2200339', 'Paracetemol', 'Painkiller', '2079-11-14', 100, 'Bot', 500, 50000, 500, 30000, '08/27/2024'),
(3, 'CA-2099022', 'Paracetemol', 'Painkiller', '2079-11-14', 120, 'Bot', 500, 60000, 500, 36000, '08/27/2024'),
(4, 'CA-9900092', 'Doxycycline', 'Antibiotic', '2061-10-12', 20, 'Tab', 6000, 120000, 6000, 60000, '08/27/2024'),
(5, 'CA-0393090', 'Methisazone', 'Antiviral', '2075-10-08', 70, 'Tab', 5000, 350000, 5000, 210000, '08/27/2024'),
(6, 'CA-3300309', 'Methisazone', 'Antiviral', '2075-10-08', 50, 'Tab', 5000, 250000, 5000, 150000, '08/27/2024'),
(7, 'CA-0909902', 'Deplin', 'Vitamins', '2046-10-16', 20, 'Sachet', 12000, 240000, 12000, 120000, '08/27/2024'),
(8, 'CA-2992020', 'Vitamin B12	', 'Vitamins', '2024-10-27', 30, 'Tab', 800, 24000, 800, 15000, '08/27/2024'),
(9, 'CA-2220920', 'Vitamin B12	', 'Vitamins', '2024-10-27', 50, 'Tab', 800, 40000, 800, 25000, '08/27/2024'),
(10, 'CA-9322020', 'Estazolam', 'Sedatives', '2024-11-27', 30, 'Bot', 1000, 30000, 1000, 15000, '08/27/2024'),
(11, 'CA-9920000', 'Mucinex', 'Expectorant', '2071-10-06', 95, 'Bot', 5000, 475000, 5000, 285000, '08/27/2024'),
(12, 'CA-3223002', 'Mucinex', 'Expectorant', '2071-10-06', 160, 'Bot', 5000, 800000, 5000, 480000, '08/27/2024'),
(13, 'CA-0929902', 'Altretamine', 'Antineoplastics', '2024-08-20', 1, 'Sachet', 800, 800, 800, 500, '08/27/2024'),
(14, 'CA-0393029', 'Altretamine', 'Antineoplastics', '2024-08-20', 4, 'Sachet', 800, 3200, 800, 2000, '08/27/2024');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `medicine_id` int(200) NOT NULL,
  `invoice_number` varchar(13) NOT NULL,
  `medicines` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `total_amount` bigint(11) NOT NULL,
  `total_profit` bigint(11) NOT NULL,
  `created_by` varchar(200) NOT NULL,
  `Date` date NOT NULL,
  `customer_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `medicine_id`, `invoice_number`, `medicines`, `category`, `quantity`, `total_amount`, `total_profit`, `created_by`, `Date`, `customer_name`) VALUES
(1, 7, 'CA-3309900', 'Altretamine', 'Antineoplastics', '25(Sachet)', 20000, 12500, 'Demetrius', '2024-10-27', 'John'),
(2, 1, 'CA-2200339', 'Paracetemol', 'Painkiller', '100(Bot)', 50000, 30000, 'Demetrius', '2024-09-27', 'Iddi'),
(3, 1, 'CA-2099022', 'Paracetemol', 'Painkiller', '120(Bot)', 60000, 36000, 'Demetrius', '2024-08-27', 'moses'),
(4, 3, 'CA-9900092', 'Doxycycline', 'Antibiotic', '20(Tab)', 120000, 60000, 'Demetrius', '2024-07-27', 'abdully'),
(5, 4, 'CA-0393090', 'Methisazone', 'Antiviral', '70(Tab)', 350000, 210000, 'Demetrius', '2024-06-27', 'gaspa'),
(6, 4, 'CA-3300309', 'Methisazone', 'Antiviral', '50(Tab)', 250000, 150000, 'Demetrius', '2024-05-27', 'musa'),
(7, 5, 'CA-0909902', 'Deplin', 'Vitamins', '20(Sachet)', 240000, 120000, 'Demetrius', '2024-04-27', 'Sami'),
(8, 6, 'CA-2992020', 'Vitamin B12	', 'Vitamins', '30(Tab)', 24000, 15000, 'Demetrius', '2024-03-27', 'Hamis'),
(9, 6, 'CA-2220920', 'Vitamin B12	', 'Vitamins', '50(Tab)', 40000, 25000, 'Demetrius', '2024-02-27', 'Niko'),
(10, 8, 'CA-9322020', 'Estazolam', 'Sedatives', '30(Bot)', 30000, 15000, 'Demetrius', '2024-01-27', 'lazaro'),
(11, 9, 'CA-9920000', 'Mucinex', 'Expectorant', '95(Bot)', 475000, 285000, 'Demetrius', '2024-12-27', 'casto'),
(12, 9, 'CA-3223002', 'Mucinex', 'Expectorant', '160(Bot)', 800000, 480000, 'Demetrius', '2024-11-27', 'Deme'),
(14, 7, 'CA-0393029', 'Altretamine', 'Antineoplastics', '4(Sachet)', 3200, 2000, 'Demetrius', '2024-08-27', 'moses');

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
(1, '', 'Paracetemol', 'Painkiller', 300, 220, 80, 80, '2024-08-27', '2079-11-14', 30, 'Non', 'Bot', 200, 500, '300(150%)', 'Demetrius', 'Available'),
(2, '', 'Biogesic', 'Painkiller', 100, 0, 100, 100, '2024-08-27', '2058-10-22', 20, 'Non', 'Bot', 1100, 2000, '900(82%)', 'Demetrius', 'Available'),
(3, '', 'Doxycycline', 'Antibiotic', 40, 20, 20, 20, '2024-08-27', '2061-10-12', 10, 'Non', 'Tab', 3000, 6000, '3000(100%)', 'Demetrius', 'Available'),
(4, '', 'Methisazone', 'Antiviral', 200, 120, 80, 80, '2024-08-27', '2075-10-08', 30, 'Non', 'Tab', 2000, 5000, '3000(150%)', 'Demetrius', 'Available'),
(5, '', 'Deplin', 'Vitamins', 50, 20, 30, 30, '2024-08-27', '2046-10-16', 10, 'Non', 'Sachet', 6000, 12000, '6000(100%)', 'Demetrius', 'Available'),
(6, '', 'Vitamin B12	', 'Vitamins', 200, 80, 120, 120, '2024-08-27', '2024-10-27', 20, 'Non', 'Tab', 300, 800, '500(167%)', 'Demetrius', 'Available'),
(7, '', 'Altretamine', 'Antineoplastics', 30, 30, 0, 0, '2024-08-27', '2024-08-20', 20, '30', 'Sachet', 300, 800, '500(167%)', 'Demetrius', 'Unavailable'),
(8, '', 'Estazolam', 'Sedatives', 90, 30, 60, 60, '2024-08-27', '2024-11-27', 10, 'Non', 'Bot', 500, 1000, '500(100%)', 'Demetrius', 'Available'),
(9, '', 'Mucinex', 'Expectorant', 300, 255, 45, 45, '2024-08-27', '2071-10-06', 30, 'non', 'Bot', 2000, 5000, '3000(150%)', 'Demetrius', 'Available'),
(10, '', 'Cetrin', 'Antibiotic', 30, 0, 30, 30, '2024-08-27', '2024-06-11', 10, 'Non', 'Tab', 300, 500, '200(67%)', 'Demetrius', 'Available');

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
(2, 'doto', 'cashier', '$2y$10$VNtMcnhpcsb9CCSwsrMgBOLikxKGkjYJlQ0erU5OKq8sKi/54mkDO'),
(10, 'jenny', 'admin', '$2y$10$q.UxN.lJp3SYXL7HExxDfeeoBcBC3U0xT8vstr4kiUXvEisX.t9yu'),
(13, 'wengine', 'wengine', '$2y$10$bzhC7p4rR0GeNxA.plFQWe.XUn5g0hbEmtMqkh3mondo77R69yEfC'),
(14, 'Demetrius', 'admin', '$2y$10$PwRogXplJbaWBeidXKx1UO1Wji/VV8R4QJB3T.QVM4M2BoGCkpXPu'),
(15, 'Mtumishi', 'admin', '$2y$10$2HtnVy/p0VNmrdaENG.cVOEnTtJ2BasSBvINeMiv9mw7JJHnqKfdq'),
(17, 'Biyaa', 'cashier', '$2y$10$04AhSTnoisQzQfxUGmVhOuR5B43f2fSMCWEtZEkcq4BcOOhSgd1ZO'),
(18, 'Love', 'cashier', '$2y$10$7lpTVrcD4i4OIExk3jW84uS9Xj3M8rSe7mb/rJrxu6ZIS9ORCAFA.'),
(19, 'Kiuno', 'cashier', '$2y$10$xCK7403gcR7WH7i3rPUgQ.Ln9nZOfAbFvrp4W24gQlIEiwuF6o7eG'),
(20, 'Sarah ', 'admin', '$2y$10$s15MjrAdtIiO2Cgx7WiC7emytjQNBQy26TZK4dFjhOsV2s6I6IOeO'),
(21, 'Msuya', 'wengine', '$2y$10$dhtaGcO9XW8uBD8b8fsKiu7oOBH5mgLGkGmaPFQEto6O4i838hfY.'),
(22, 'Juma', 'wengine', '$2y$10$c.FZhiK8.MUxoEZgXbdxeurMmWGf15nGJVS29mj9qpRks.yiN4g3G'),
(24, 'mama sungo', 'admin', '$2y$10$LTbrjSRUGcyppc5XXonFVeEMujOkNy9gmpUOjqlUe9cK5DeK6/sKC'),
(25, 'test', '3ff', '$2y$10$gyoo4alF4WOf2tL9dypBo.87N1nwitapL9nhOqrCxQTD2KIRgxy2.'),
(27, 'Chuga', 'cashier', '$2y$10$g7Z1TD7FmJ/sukHf.SbGKevikamS.WzbfLgWMQn6oECAlrNZqKYxW'),
(28, 'leoddd', 'cashier', '$2y$10$8Tl8atl6fyzLmb9LIxtXGOLroUUPB9CIx9bDAVf0DOB2ts9Rfe/TS'),
(29, 'sss', 'sss', '$2y$10$QzxXd1UuhMPkMZdHraP5KOFT8uHid6HyeluYiFW0TpYjNV63ELBJq'),
(30, 'yat', 'ee', '$2y$10$9Ae.FTkjCz1CkZtbWJqZw.O3pmMLaxMt4tibuMNFloQDeb0aHtFdK'),
(31, 'hgvgg', 'gggg', '$2y$10$ilm4Dv3zUBwe4QHhwMLwSu4zWORXIZB2DRJ2u0tV.Y0l8FsSj1O3q');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `broken_products`
--
ALTER TABLE `broken_products`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `broken_products`
--
ALTER TABLE `broken_products`
  MODIFY `id` int(191) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `expenditure`
--
ALTER TABLE `expenditure`
  MODIFY `expenditure_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `on_hold`
--
ALTER TABLE `on_hold`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
