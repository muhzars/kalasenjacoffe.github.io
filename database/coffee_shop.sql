-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 17, 2024 at 12:47 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffee_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_acc`
--

CREATE TABLE `tbl_acc` (
  `id_ta` int NOT NULL,
  `name_ta` varchar(50) NOT NULL,
  `status_ta` varchar(50) NOT NULL,
  `email_ta` varchar(50) NOT NULL,
  `foto_ta` blob,
  `password_ta` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_d_order`
--

CREATE TABLE `tbl_d_order` (
  `idDetailOrder_tdo` int NOT NULL,
  `idOrder_tdo` int DEFAULT NULL,
  `idMenu_tdo` int DEFAULT NULL,
  `quantity_tdo` int DEFAULT NULL,
  `note` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_m_menu`
--

CREATE TABLE `tbl_m_menu` (
  `idMenu_tmm` int NOT NULL,
  `nameMenu_tmm` varchar(100) NOT NULL,
  `priceMenu_tmm` decimal(8,2) NOT NULL,
  `descMenu_tmm` text,
  `categoryMenu_tmm` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_m_order`
--

CREATE TABLE `tbl_m_order` (
  `idOrder_tmo` int NOT NULL,
  `nameCust_tmo` varchar(50) NOT NULL,
  `dateOrder_tmo` date NOT NULL,
  `numberTable_tmo` int DEFAULT NULL,
  `orderType_tmo` enum('Dine in','Take away') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

CREATE TABLE `tbl_payment` (
  `idPayment_tp` int NOT NULL,
  `datePayment_tp` date NOT NULL,
  `idOrder_tp` int DEFAULT NULL,
  `idWallet_tp` int DEFAULT NULL,
  `totalPayment` decimal(10,2) NOT NULL,
  `paymentStatus_tp` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wallet`
--

CREATE TABLE `tbl_wallet` (
  `idWallet_tw` int NOT NULL,
  `typeWallet_tw` varchar(50) NOT NULL,
  `nameBank` varchar(50) NOT NULL,
  `numberRekening` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_acc`
--
ALTER TABLE `tbl_acc`
  ADD PRIMARY KEY (`id_ta`);

--
-- Indexes for table `tbl_d_order`
--
ALTER TABLE `tbl_d_order`
  ADD PRIMARY KEY (`idDetailOrder_tdo`),
  ADD KEY `idOrder_tdo` (`idOrder_tdo`),
  ADD KEY `idMenu_tdo` (`idMenu_tdo`);

--
-- Indexes for table `tbl_m_menu`
--
ALTER TABLE `tbl_m_menu`
  ADD PRIMARY KEY (`idMenu_tmm`);

--
-- Indexes for table `tbl_m_order`
--
ALTER TABLE `tbl_m_order`
  ADD PRIMARY KEY (`idOrder_tmo`);

--
-- Indexes for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD PRIMARY KEY (`idPayment_tp`),
  ADD KEY `idOrder_tp` (`idOrder_tp`),
  ADD KEY `idWallet_tp` (`idWallet_tp`);

--
-- Indexes for table `tbl_wallet`
--
ALTER TABLE `tbl_wallet`
  ADD PRIMARY KEY (`idWallet_tw`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_acc`
--
ALTER TABLE `tbl_acc`
  MODIFY `id_ta` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_d_order`
--
ALTER TABLE `tbl_d_order`
  MODIFY `idDetailOrder_tdo` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_m_menu`
--
ALTER TABLE `tbl_m_menu`
  MODIFY `idMenu_tmm` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_m_order`
--
ALTER TABLE `tbl_m_order`
  MODIFY `idOrder_tmo` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  MODIFY `idPayment_tp` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_wallet`
--
ALTER TABLE `tbl_wallet`
  MODIFY `idWallet_tw` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_d_order`
--
ALTER TABLE `tbl_d_order`
  ADD CONSTRAINT `tbl_d_order_ibfk_1` FOREIGN KEY (`idOrder_tdo`) REFERENCES `tbl_m_order` (`idOrder_tmo`),
  ADD CONSTRAINT `tbl_d_order_ibfk_2` FOREIGN KEY (`idMenu_tdo`) REFERENCES `tbl_m_menu` (`idMenu_tmm`);

--
-- Constraints for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD CONSTRAINT `tbl_payment_ibfk_1` FOREIGN KEY (`idOrder_tp`) REFERENCES `tbl_m_order` (`idOrder_tmo`),
  ADD CONSTRAINT `tbl_payment_ibfk_2` FOREIGN KEY (`idWallet_tp`) REFERENCES `tbl_wallet` (`idWallet_tw`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
