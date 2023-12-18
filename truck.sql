-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2023 at 10:00 AM
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
-- Database: `truck`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `updfeequotation` (IN `xquotationid` VARCHAR(20), IN `xrateid` VARCHAR(20), IN `xnominal` DOUBLE)   update detailratequotation
set nominal=xnominal, jumlah=xnominal
where quotationid=xquotationid and rateid=xrateid$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updfeeshipment` (IN `xshipmentid` VARCHAR(20), IN `xrateid` VARCHAR(20), IN `xnominal` FLOAT UNSIGNED)   update detailrateshipment
set nominal=xnominal, jumlah=xnominal
where shipmentid=xshipmentid and rateid=xrateid$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `kdakun` varchar(10) NOT NULL,
  `namaakun` varchar(50) NOT NULL,
  `kelakun` varchar(10) NOT NULL,
  `dk` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`kdakun`, `namaakun`, `kelakun`, `dk`) VALUES
('1001', 'Revenue', '1000', 'K'),
('5001', 'Fee', '5000', 'D'),
('5002', 'Driver', '5000', 'D'),
('5003', 'Pajak', '5000', 'D');

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `nobill` varchar(20) NOT NULL,
  `shipmentid` varchar(20) NOT NULL,
  `tglbill` date DEFAULT NULL,
  `tglpayment` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `f_status` set('notpaid','paid') NOT NULL DEFAULT 'notpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `kdcustomer` varchar(50) NOT NULL,
  `namacustomer` text NOT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detailbill`
--

CREATE TABLE `detailbill` (
  `id` int(11) NOT NULL,
  `nobill` varchar(20) DEFAULT NULL,
  `iddetailrateshipment` int(11) NOT NULL,
  `shipmentid` varchar(20) NOT NULL,
  `routeid` varchar(10) NOT NULL,
  `rateid` varchar(10) NOT NULL,
  `descript` text DEFAULT NULL,
  `nominal` float NOT NULL DEFAULT 0,
  `qty` int(11) NOT NULL DEFAULT 1,
  `jumlah` float NOT NULL DEFAULT 0,
  `pph` float NOT NULL DEFAULT 0,
  `pajak` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detailinvoice`
--

CREATE TABLE `detailinvoice` (
  `id` int(11) NOT NULL,
  `noinvoice` varchar(20) DEFAULT NULL,
  `iddetailrateshipment` int(11) NOT NULL,
  `shipmentid` varchar(20) NOT NULL,
  `rateid` varchar(10) NOT NULL,
  `descript` text DEFAULT NULL,
  `nominal` float NOT NULL DEFAULT 0,
  `qty` int(11) NOT NULL DEFAULT 1,
  `jumlah` float NOT NULL DEFAULT 0,
  `pph` float NOT NULL DEFAULT 0,
  `pajak` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detailpreinvoice`
--

CREATE TABLE `detailpreinvoice` (
  `id` int(11) NOT NULL,
  `shipmentid` varchar(50) NOT NULL,
  `piid` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `detailpreinvoice`
--
DELIMITER $$
CREATE TRIGGER `inpreinvoice` AFTER INSERT ON `detailpreinvoice` FOR EACH ROW update shipment set f_pi="1" 
where shipmentid=NEW.shipmentid
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `outopreinvoice` AFTER DELETE ON `detailpreinvoice` FOR EACH ROW update shipment set f_pi="0" 
where shipmentid=OLD.shipmentid
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `detailratequotation`
--

CREATE TABLE `detailratequotation` (
  `id` int(11) NOT NULL,
  `quotationid` varchar(20) NOT NULL,
  `rateid` varchar(10) NOT NULL,
  `descript` text DEFAULT NULL,
  `nominal` float NOT NULL DEFAULT 0,
  `qty` int(11) NOT NULL DEFAULT 1,
  `jumlah` float NOT NULL DEFAULT 0,
  `pph` float NOT NULL DEFAULT 0,
  `pajak` float NOT NULL DEFAULT 0,
  `f_invoice` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detailraterute`
--

CREATE TABLE `detailraterute` (
  `id` int(11) NOT NULL,
  `routeid` varchar(50) NOT NULL,
  `rateid` varchar(10) NOT NULL,
  `nominal` float NOT NULL DEFAULT 0,
  `qty` int(11) NOT NULL DEFAULT 1,
  `jumlah` float NOT NULL DEFAULT 0,
  `pph` float NOT NULL DEFAULT 0,
  `pajak` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detailrateshipment`
--

CREATE TABLE `detailrateshipment` (
  `id` int(11) NOT NULL,
  `noujo` varchar(20) NOT NULL,
  `rateid` varchar(10) NOT NULL,
  `descript` text DEFAULT NULL,
  `nominal` float NOT NULL DEFAULT 0,
  `qty` int(11) NOT NULL DEFAULT 1,
  `jumlah` float NOT NULL DEFAULT 0,
  `nominalsettle` double NOT NULL DEFAULT 0,
  `pph` float NOT NULL DEFAULT 0,
  `pajak` float NOT NULL DEFAULT 0,
  `f_edit` varchar(1) NOT NULL DEFAULT '0',
  `f_invoice` varchar(1) NOT NULL DEFAULT '0',
  `f_settle` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detailrevenue`
--

CREATE TABLE `detailrevenue` (
  `id` int(11) NOT NULL,
  `shipmentid` varchar(20) NOT NULL,
  `rateid` varchar(10) NOT NULL,
  `descript` text DEFAULT NULL,
  `nominal` float NOT NULL DEFAULT 0,
  `qty` int(11) NOT NULL DEFAULT 1,
  `jumlah` float NOT NULL DEFAULT 0,
  `pph` float NOT NULL DEFAULT 0,
  `pajak` float NOT NULL DEFAULT 0,
  `f_edit` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detailujoongoing`
--

CREATE TABLE `detailujoongoing` (
  `id` int(11) NOT NULL,
  `noujo` varchar(20) NOT NULL,
  `rateid` varchar(10) NOT NULL,
  `descript` text DEFAULT NULL,
  `nominal` float NOT NULL DEFAULT 0,
  `qty` int(11) NOT NULL DEFAULT 1,
  `jumlah` float NOT NULL DEFAULT 0,
  `pph` float NOT NULL DEFAULT 0,
  `pajak` float NOT NULL DEFAULT 0,
  `f_edit` varchar(1) NOT NULL DEFAULT '0',
  `nominalsettle` double DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docpod`
--

CREATE TABLE `docpod` (
  `id` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `shipmentid` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `kddriver` varchar(10) NOT NULL,
  `namadriver` text NOT NULL,
  `nohp` varchar(50) DEFAULT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `namarekening` text NOT NULL,
  `norekening` varchar(100) DEFAULT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groupquotations`
--

CREATE TABLE `groupquotations` (
  `groupquotationid` varchar(20) NOT NULL,
  `kdcustomer` varchar(20) NOT NULL,
  `kdkategori` varchar(10) NOT NULL,
  `description` text DEFAULT NULL,
  `datecreated` date NOT NULL,
  `f_accquotation` varchar(1) NOT NULL DEFAULT '0',
  `f_accso` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `noinvoice` varchar(20) NOT NULL,
  `noujo` varchar(20) NOT NULL,
  `tglinvoice` date DEFAULT NULL,
  `total` double NOT NULL DEFAULT 0,
  `tglpayment` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `f_status` set('notpaid','paid') NOT NULL DEFAULT 'notpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jurnal`
--

CREATE TABLE `jurnal` (
  `idjurnal` int(11) NOT NULL,
  `shipmentid` varchar(20) NOT NULL,
  `kdakun` varchar(10) NOT NULL,
  `rateid` varchar(10) NOT NULL,
  `kodetr` varchar(10) DEFAULT NULL,
  `debet` double NOT NULL DEFAULT 0,
  `kredit` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kdkategori` varchar(10) NOT NULL,
  `namakategori` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locationpoint`
--

CREATE TABLE `locationpoint` (
  `id` int(11) NOT NULL,
  `shipmentid` varchar(20) NOT NULL,
  `location` text NOT NULL,
  `nodo` text DEFAULT NULL,
  `noshipment` varchar(20) DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `typelocation` set('drop','pickup') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loglogin`
--

CREATE TABLE `loglogin` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `noinvoice` varchar(50) NOT NULL,
  `noujo` varchar(20) NOT NULL,
  `datepayment` date NOT NULL,
  `jumlah` double NOT NULL,
  `bank` varchar(100) NOT NULL,
  `namarekening` text NOT NULL,
  `norekening` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `preinvoice`
--

CREATE TABLE `preinvoice` (
  `piid` varchar(20) NOT NULL,
  `kdcustomer` varchar(50) NOT NULL,
  `project` text DEFAULT NULL,
  `kdkategori` varchar(20) NOT NULL,
  `datecreate` date NOT NULL,
  `f_status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `kdproject` varchar(50) NOT NULL,
  `namaproject` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` varchar(20) NOT NULL,
  `groupquotationid` varchar(20) DEFAULT NULL,
  `tglrequest` date NOT NULL,
  `tglaccso` date DEFAULT NULL,
  `origin` text NOT NULL,
  `destination` text NOT NULL,
  `kdcustomer` varchar(20) NOT NULL,
  `typetruckid` varchar(10) NOT NULL,
  `typeroute` set('trip','load') NOT NULL DEFAULT 'trip',
  `minqty` int(11) NOT NULL DEFAULT 0,
  `mrc` double DEFAULT 0,
  `ujo` double DEFAULT 0,
  `f_status` varchar(20) NOT NULL DEFAULT 'new',
  `f_accquotation` varchar(1) NOT NULL DEFAULT '0',
  `f_accso` varchar(1) NOT NULL DEFAULT '0',
  `f_request` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE `rate` (
  `rateid` varchar(10) NOT NULL,
  `kdakun` varchar(10) NOT NULL,
  `namarate` text NOT NULL,
  `f_pajak` varchar(1) NOT NULL DEFAULT '0',
  `persenpajak` float NOT NULL DEFAULT 0,
  `f_default` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rate`
--

INSERT INTO `rate` (`rateid`, `kdakun`, `namarate`, `f_pajak`, `persenpajak`, `f_default`) VALUES
('10011', '1001', 'MRC', '0', 0, '0'),
('10012', '1001', 'Drop', '0', 0, '0'),
('10013', '1001', 'Pickup', '0', 0, '0'),
('10014', '1001', 'Additional  MRC', '0', 0, '0'),
('50011', '5001', 'Fee', '0', 0, '0'),
('50021', '5002', 'Fuel', '0', 0, '1'),
('50022', '5002', 'Tol', '0', 0, '1'),
('50023', '5002', 'Kapal', '0', 0, '1'),
('50024', '5002', 'Komisi dan Bonus', '1', 3, '1'),
('50025', '5002', 'Lain-Lain', '1', 3, '1'),
('50026', '5002', 'Additional Ujo', '0', 0, '0'),
('50027', '5002', 'Mobilisasi', '0', 0, '0'),
('50031', '5003', 'Pajak Pph 21', '0', 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `ratealn`
--

CREATE TABLE `ratealn` (
  `routeid` varchar(50) NOT NULL,
  `rateid` varchar(10) NOT NULL,
  `nominal` float NOT NULL DEFAULT 0,
  `qty` int(11) NOT NULL DEFAULT 1,
  `jumlah` float NOT NULL DEFAULT 0,
  `pph` float NOT NULL DEFAULT 0,
  `pajak` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2020-12-22 09:12:09', '2020-12-22 09:12:09'),
(2, 'manajer', '2020-12-22 09:12:09', '2020-12-22 09:12:09'),
(3, 'marketing', NULL, NULL),
(4, 'operational', NULL, NULL),
(5, 'finance', NULL, NULL),
(6, 'driver', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rute`
--

CREATE TABLE `rute` (
  `routeid` varchar(20) NOT NULL,
  `origin` text DEFAULT NULL,
  `destination` text DEFAULT NULL,
  `route` text NOT NULL,
  `mrc` double NOT NULL DEFAULT 0,
  `ujo` double NOT NULL DEFAULT 0,
  `kdkategori` varchar(10) NOT NULL,
  `kdproject` varchar(50) NOT NULL,
  `typetruckid` varchar(50) NOT NULL,
  `keterangan` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rutedouble`
--

CREATE TABLE `rutedouble` (
  `routeid` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `kdsales` varchar(10) NOT NULL,
  `namasales` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipment`
--

CREATE TABLE `shipment` (
  `shipmentid` varchar(20) NOT NULL,
  `groupquotationid` varchar(20) NOT NULL,
  `quotationid` varchar(20) NOT NULL,
  `kdkategori` varchar(20) NOT NULL,
  `origin` text NOT NULL,
  `destination` text NOT NULL,
  `kdcustomer` varchar(20) NOT NULL,
  `kdsales` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `multidrop` varchar(1) DEFAULT NULL,
  `qtydrop` int(11) DEFAULT NULL,
  `ratedrop` double DEFAULT NULL,
  `locationdrop` text DEFAULT NULL,
  `multipickup` varchar(1) DEFAULT NULL,
  `qtypickup` int(11) DEFAULT NULL,
  `ratepickup` double DEFAULT NULL,
  `locationpickup` text DEFAULT NULL,
  `mrc` double NOT NULL DEFAULT 0,
  `unitmrc` double NOT NULL DEFAULT 0,
  `ujo` double NOT NULL DEFAULT 0,
  `kdproject` varchar(20) NOT NULL,
  `typeroute` varchar(10) DEFAULT NULL,
  `kdunit` varchar(20) DEFAULT NULL,
  `kddriver` varchar(20) DEFAULT NULL,
  `typetruckid` varchar(20) DEFAULT NULL,
  `tglorder` date DEFAULT NULL,
  `tglloading` date DEFAULT NULL,
  `tglshipment` date DEFAULT NULL,
  `tglarrival` date DEFAULT NULL,
  `tglpayment` date DEFAULT NULL,
  `f_status` varchar(20) NOT NULL DEFAULT 'New',
  `f_operational` varchar(1) NOT NULL DEFAULT '0',
  `f_pi` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tempdetailrate`
--

CREATE TABLE `tempdetailrate` (
  `id` int(11) NOT NULL,
  `shipmentid` varchar(20) NOT NULL,
  `routeid` varchar(10) NOT NULL,
  `rateid` varchar(10) NOT NULL,
  `nominal` float NOT NULL DEFAULT 0,
  `qty` int(11) NOT NULL DEFAULT 1,
  `jumlah` float NOT NULL DEFAULT 0,
  `pph` float NOT NULL DEFAULT 0,
  `pajak` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `typetruck`
--

CREATE TABLE `typetruck` (
  `typetruckid` varchar(20) NOT NULL,
  `namatypetruck` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ujo`
--

CREATE TABLE `ujo` (
  `noujo` varchar(20) NOT NULL,
  `shipmentid` varchar(20) DEFAULT NULL,
  `statusujo` varchar(10) DEFAULT 'ongoing',
  `tglujo` date DEFAULT NULL,
  `terbayar` double DEFAULT NULL,
  `nominalujo` double DEFAULT NULL,
  `f_lunas` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `ujo`
--
DELIMITER $$
CREATE TRIGGER `ujo` AFTER UPDATE ON `ujo` FOR EACH ROW update shipment set shipment.ujo=NEW.nominalujo 
where shipment.shipmentid=NEW.shipmentid
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `kdunit` varchar(10) NOT NULL,
  `plat` text NOT NULL,
  `merk` text NOT NULL,
  `typeunit` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `roles_id` int(11) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `roles_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$10$tH4j2/.E43JRJD/BDhr5hOLN8IyEUsIqyq.FH1wyWMcFhE0chiFLm', 1, NULL, '2023-09-04 19:00:31', '2023-09-19 16:20:12'),
(2, 'Manajer', 'manajer@gmail.com', NULL, '$2y$10$YxkZuwU7dwY/X1i831EBretWAtSVqyPJq8h9s6gVLW6qL2eKdrzF2', 2, NULL, '2023-09-04 20:21:20', '2023-11-07 07:47:22'),
(3, 'Marketing', 'marketing@gmail.com', NULL, '$2y$10$H0x6Gkd3KIHI9p0jja8teuJq9Rd1uyr/.QV7rsr9u1l0neEXBmK02', 3, NULL, '2023-09-04 20:21:20', '2023-11-11 23:09:05'),
(4, 'Operational', 'operational@gmail.com', NULL, '$2y$10$QiHXDJHjbNVRUt4gv.u1juvngCi2T2b3C4IoXvDdZZtCYIsuZ/nsK', 4, NULL, '2023-09-19 16:09:14', '2023-11-11 23:38:18'),
(5, 'Finance', 'finance@gmail.com', NULL, '$2y$10$QiHXDJHjbNVRUt4gv.u1juvngCi2T2b3C4IoXvDdZZtCYIsuZ/nsK', 5, NULL, '2023-11-07 07:48:29', '2023-11-07 07:48:29'),
(6, 'Driver', 'driver@gmail.com', NULL, '$2y$10$cUMYnLRpx.olYTfh3VL1cuHrpMKWrNaf0jBz/eb1vgfXk4nvTjvh6', 6, NULL, '2023-11-07 07:48:50', '2023-11-07 07:48:50'),
(7, 'Driver2', 'driver2@gmail.com', NULL, '$2y$10$cUMYnLRpx.olYTfh3VL1cuHrpMKWrNaf0jBz/eb1vgfXk4nvTjvh6', 6, NULL, '2023-11-07 07:48:50', '2023-11-07 07:48:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`kdakun`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`nobill`),
  ADD KEY `shipmentid` (`shipmentid`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`kdcustomer`);

--
-- Indexes for table `detailbill`
--
ALTER TABLE `detailbill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iddetailrateshipment` (`iddetailrateshipment`),
  ADD KEY `shipmentid` (`shipmentid`),
  ADD KEY `routeid` (`routeid`),
  ADD KEY `rateid` (`rateid`);

--
-- Indexes for table `detailinvoice`
--
ALTER TABLE `detailinvoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iddetailrateshipment` (`iddetailrateshipment`),
  ADD KEY `noinvoice` (`noinvoice`);

--
-- Indexes for table `detailpreinvoice`
--
ALTER TABLE `detailpreinvoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detailratequotation`
--
ALTER TABLE `detailratequotation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotationid` (`quotationid`),
  ADD KEY `rateid` (`rateid`);

--
-- Indexes for table `detailraterute`
--
ALTER TABLE `detailraterute`
  ADD PRIMARY KEY (`id`),
  ADD KEY `routeid` (`routeid`),
  ADD KEY `rateid` (`rateid`);

--
-- Indexes for table `detailrateshipment`
--
ALTER TABLE `detailrateshipment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rateid` (`rateid`),
  ADD KEY `noujo` (`noujo`);

--
-- Indexes for table `detailrevenue`
--
ALTER TABLE `detailrevenue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rateid` (`rateid`);

--
-- Indexes for table `detailujoongoing`
--
ALTER TABLE `detailujoongoing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rateid` (`rateid`),
  ADD KEY `noujo` (`noujo`);

--
-- Indexes for table `docpod`
--
ALTER TABLE `docpod`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`kddriver`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `groupquotations`
--
ALTER TABLE `groupquotations`
  ADD PRIMARY KEY (`groupquotationid`),
  ADD KEY `kdcustomer` (`kdcustomer`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`noinvoice`),
  ADD KEY `noujo` (`noujo`);

--
-- Indexes for table `jurnal`
--
ALTER TABLE `jurnal`
  ADD PRIMARY KEY (`idjurnal`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kdkategori`);

--
-- Indexes for table `locationpoint`
--
ALTER TABLE `locationpoint`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipmentid` (`shipmentid`);

--
-- Indexes for table `loglogin`
--
ALTER TABLE `loglogin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `preinvoice`
--
ALTER TABLE `preinvoice`
  ADD PRIMARY KEY (`piid`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`kdproject`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kdcustomer` (`kdcustomer`);

--
-- Indexes for table `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`rateid`),
  ADD KEY `kdakun` (`kdakun`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rute`
--
ALTER TABLE `rute`
  ADD PRIMARY KEY (`routeid`),
  ADD KEY `kdkategori` (`kdkategori`),
  ADD KEY `kdproject` (`kdproject`),
  ADD KEY `typetruckid` (`typetruckid`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`kdsales`);

--
-- Indexes for table `shipment`
--
ALTER TABLE `shipment`
  ADD PRIMARY KEY (`shipmentid`),
  ADD KEY `kdcustomer` (`kdcustomer`),
  ADD KEY `kdsales` (`kdsales`);

--
-- Indexes for table `tempdetailrate`
--
ALTER TABLE `tempdetailrate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `typetruck`
--
ALTER TABLE `typetruck`
  ADD PRIMARY KEY (`typetruckid`);

--
-- Indexes for table `ujo`
--
ALTER TABLE `ujo`
  ADD PRIMARY KEY (`noujo`),
  ADD KEY `shipmentid` (`shipmentid`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`kdunit`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detailbill`
--
ALTER TABLE `detailbill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detailinvoice`
--
ALTER TABLE `detailinvoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detailpreinvoice`
--
ALTER TABLE `detailpreinvoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detailratequotation`
--
ALTER TABLE `detailratequotation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detailraterute`
--
ALTER TABLE `detailraterute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detailrateshipment`
--
ALTER TABLE `detailrateshipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detailrevenue`
--
ALTER TABLE `detailrevenue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detailujoongoing`
--
ALTER TABLE `detailujoongoing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `docpod`
--
ALTER TABLE `docpod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jurnal`
--
ALTER TABLE `jurnal`
  MODIFY `idjurnal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locationpoint`
--
ALTER TABLE `locationpoint`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loglogin`
--
ALTER TABLE `loglogin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tempdetailrate`
--
ALTER TABLE `tempdetailrate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detailinvoice`
--
ALTER TABLE `detailinvoice`
  ADD CONSTRAINT `detailinvoice_ibfk_1` FOREIGN KEY (`noinvoice`) REFERENCES `invoice` (`noinvoice`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detailratequotation`
--
ALTER TABLE `detailratequotation`
  ADD CONSTRAINT `detailratequotation_ibfk_1` FOREIGN KEY (`quotationid`) REFERENCES `quotations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detailraterute`
--
ALTER TABLE `detailraterute`
  ADD CONSTRAINT `detailraterute_ibfk_1` FOREIGN KEY (`routeid`) REFERENCES `rute` (`routeid`) ON UPDATE CASCADE;

--
-- Constraints for table `detailrateshipment`
--
ALTER TABLE `detailrateshipment`
  ADD CONSTRAINT `detailrateshipment_ibfk_2` FOREIGN KEY (`rateid`) REFERENCES `rate` (`rateid`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detailrateshipment_ibfk_3` FOREIGN KEY (`noujo`) REFERENCES `ujo` (`noujo`) ON UPDATE CASCADE;

--
-- Constraints for table `detailujoongoing`
--
ALTER TABLE `detailujoongoing`
  ADD CONSTRAINT `detailujoongoing_ibfk_1` FOREIGN KEY (`noujo`) REFERENCES `ujo` (`noujo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `locationpoint`
--
ALTER TABLE `locationpoint`
  ADD CONSTRAINT `locationpoint_ibfk_1` FOREIGN KEY (`shipmentid`) REFERENCES `shipment` (`shipmentid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quotations`
--
ALTER TABLE `quotations`
  ADD CONSTRAINT `quotations_ibfk_1` FOREIGN KEY (`kdcustomer`) REFERENCES `customer` (`kdcustomer`) ON UPDATE CASCADE;

--
-- Constraints for table `rate`
--
ALTER TABLE `rate`
  ADD CONSTRAINT `rate_ibfk_1` FOREIGN KEY (`kdakun`) REFERENCES `akun` (`kdakun`) ON UPDATE CASCADE;

--
-- Constraints for table `rute`
--
ALTER TABLE `rute`
  ADD CONSTRAINT `rute_ibfk_1` FOREIGN KEY (`kdkategori`) REFERENCES `kategori` (`kdkategori`) ON UPDATE CASCADE,
  ADD CONSTRAINT `rute_ibfk_2` FOREIGN KEY (`kdproject`) REFERENCES `project` (`kdproject`) ON UPDATE CASCADE,
  ADD CONSTRAINT `rute_ibfk_3` FOREIGN KEY (`typetruckid`) REFERENCES `typetruck` (`typetruckid`) ON UPDATE CASCADE;

--
-- Constraints for table `ujo`
--
ALTER TABLE `ujo`
  ADD CONSTRAINT `ujo_ibfk_1` FOREIGN KEY (`shipmentid`) REFERENCES `shipment` (`shipmentid`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
