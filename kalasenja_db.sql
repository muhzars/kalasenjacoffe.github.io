-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 27, 2024 at 09:23 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kalasenja_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_m_category`
--

CREATE TABLE `tbl_m_category` (
  `id_tmc` int NOT NULL,
  `categoryName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_m_menu`
--

CREATE TABLE `tbl_m_menu` (
  `id_tmm` int NOT NULL,
  `menu_tmm` varchar(50) NOT NULL,
  `price_tmm` decimal(10,2) NOT NULL,
  `desc_tmm` text,
  `photo_tmm` blob,
  `id_tmc` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_m_paymentmethod`
--

CREATE TABLE `tbl_m_paymentmethod` (
  `id_tmpm` int NOT NULL,
  `paymentMethod_tmpm` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_m_user`
--

CREATE TABLE `tbl_m_user` (
  `id_tmu` int NOT NULL,
  `email_tmu` varchar(50) NOT NULL,
  `name_tmu` varchar(50) NOT NULL,
  `password_tmu` varchar(50) NOT NULL,
  `role_tmu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_t_order`
--

CREATE TABLE `tbl_t_order` (
  `id_tto` int NOT NULL,
  `id_tmu` int NOT NULL,
  `dateOrder` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `typeOrder` enum('Dine-in','Take away') NOT NULL,
  `id_tts` int NOT NULL,
  `note_tto` text,
  `statusOrder_tto` enum('OPEN','CLOSED') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_t_payment`
--

CREATE TABLE `tbl_t_payment` (
  `id_ttp` int NOT NULL,
  `id_tto` int NOT NULL,
  `id_tmpm` int NOT NULL,
  `totalPayment_ttp` decimal(10,2) NOT NULL,
  `cashNominal_ttp` decimal(10,2) DEFAULT NULL,
  `statusPayment_ttp` enum('PAID','UNPAID') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_t_stock`
--

CREATE TABLE `tbl_t_stock` (
  `id_tts` int NOT NULL,
  `id_tmm` int NOT NULL,
  `stock_tts` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_m_category`
--
ALTER TABLE `tbl_m_category`
  ADD PRIMARY KEY (`id_tmc`),
  ADD UNIQUE KEY `categoryName` (`categoryName`);

--
-- Indexes for table `tbl_m_menu`
--
ALTER TABLE `tbl_m_menu`
  ADD PRIMARY KEY (`id_tmm`),
  ADD KEY `id_tmc` (`id_tmc`);

--
-- Indexes for table `tbl_m_paymentmethod`
--
ALTER TABLE `tbl_m_paymentmethod`
  ADD PRIMARY KEY (`id_tmpm`),
  ADD UNIQUE KEY `paymentMethod_tmpm` (`paymentMethod_tmpm`);

--
-- Indexes for table `tbl_m_user`
--
ALTER TABLE `tbl_m_user`
  ADD PRIMARY KEY (`id_tmu`),
  ADD UNIQUE KEY `email_tmu` (`email_tmu`);

--
-- Indexes for table `tbl_t_order`
--
ALTER TABLE `tbl_t_order`
  ADD PRIMARY KEY (`id_tto`),
  ADD KEY `id_tmu` (`id_tmu`),
  ADD KEY `id_tts` (`id_tts`);

--
-- Indexes for table `tbl_t_payment`
--
ALTER TABLE `tbl_t_payment`
  ADD PRIMARY KEY (`id_ttp`),
  ADD KEY `id_tto` (`id_tto`),
  ADD KEY `id_tmpm` (`id_tmpm`);

--
-- Indexes for table `tbl_t_stock`
--
ALTER TABLE `tbl_t_stock`
  ADD PRIMARY KEY (`id_tts`),
  ADD KEY `id_tmm` (`id_tmm`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_m_category`
--
ALTER TABLE `tbl_m_category`
  MODIFY `id_tmc` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_m_menu`
--
ALTER TABLE `tbl_m_menu`
  MODIFY `id_tmm` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_m_paymentmethod`
--
ALTER TABLE `tbl_m_paymentmethod`
  MODIFY `id_tmpm` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_m_user`
--
ALTER TABLE `tbl_m_user`
  MODIFY `id_tmu` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_t_order`
--
ALTER TABLE `tbl_t_order`
  MODIFY `id_tto` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_t_payment`
--
ALTER TABLE `tbl_t_payment`
  MODIFY `id_ttp` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_t_stock`
--
ALTER TABLE `tbl_t_stock`
  MODIFY `id_tts` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_m_menu`
--
ALTER TABLE `tbl_m_menu`
  ADD CONSTRAINT `tbl_m_menu_ibfk_1` FOREIGN KEY (`id_tmc`) REFERENCES `tbl_m_category` (`id_tmc`);

--
-- Constraints for table `tbl_t_order`
--
ALTER TABLE `tbl_t_order`
  ADD CONSTRAINT `tbl_t_order_ibfk_1` FOREIGN KEY (`id_tmu`) REFERENCES `tbl_m_user` (`id_tmu`),
  ADD CONSTRAINT `tbl_t_order_ibfk_2` FOREIGN KEY (`id_tts`) REFERENCES `tbl_t_stock` (`id_tts`);

--
-- Constraints for table `tbl_t_payment`
--
ALTER TABLE `tbl_t_payment`
  ADD CONSTRAINT `tbl_t_payment_ibfk_1` FOREIGN KEY (`id_tto`) REFERENCES `tbl_t_order` (`id_tto`),
  ADD CONSTRAINT `tbl_t_payment_ibfk_2` FOREIGN KEY (`id_tmpm`) REFERENCES `tbl_m_paymentmethod` (`id_tmpm`);

--
-- Constraints for table `tbl_t_stock`
--
ALTER TABLE `tbl_t_stock`
  ADD CONSTRAINT `tbl_t_stock_ibfk_1` FOREIGN KEY (`id_tmm`) REFERENCES `tbl_m_menu` (`id_tmm`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
