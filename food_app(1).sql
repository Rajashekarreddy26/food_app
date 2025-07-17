-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 16, 2025 at 07:47 AM
-- Server version: 8.0.42-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `district` int DEFAULT NULL,
  `state` int DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `food_items`
--

CREATE TABLE `food_items` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `category` tinyint DEFAULT '0' COMMENT '0 => tiffin, 1 => lunch, 2 => snacks, 4 => dinner',
  `vendor_id` int NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `approval_status` tinyint DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `food_orders`
--

CREATE TABLE `food_orders` (
  `id` int NOT NULL,
  `employee_id` int DEFAULT NULL,
  `vendor_id` int DEFAULT NULL,
  `client_id` int DEFAULT NULL,
  `item_id` int DEFAULT NULL,
  `delivery_status` tinyint DEFAULT NULL,
  `feedback` varchar(255) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int NOT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `client_id` int DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `price` double DEFAULT NULL,
  `sgst` double DEFAULT NULL,
  `cgst` double DEFAULT NULL,
  `igst` double DEFAULT NULL,
  `base_amount` double DEFAULT NULL,
  `tax_amount` double DEFAULT NULL,
  `invoice_total` double DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `payment_type` int DEFAULT NULL,
  `payment_status` tinyint DEFAULT NULL,
  `transaction_no` varchar(255) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_payment`
--

CREATE TABLE `invoice_payment` (
  `id` int NOT NULL,
  `invoice_id` int DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `payment_type` int DEFAULT NULL,
  `transaction_no` varchar(255) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `till_paid_amount` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id` int NOT NULL,
  `name` varchar(220) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `code` int DEFAULT NULL,
  `status` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `payment_type`
--

CREATE TABLE `payment_type` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `rights` varchar(225) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `rights`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super Admin', NULL, NULL, '2023-12-19 11:38:27', NULL),
(2, 'Admin', NULL, NULL, '2023-12-19 11:39:04', NULL),
(3, 'Employee', '1,2,3,4,5,6,7,8', NULL, '2024-02-27 17:27:42', NULL),
(4, 'Employee 2', '1,2,3,5,7,8,9,10,11,13,14', NULL, '2023-12-21 06:42:03', NULL),
(5, 'Employee 3', '7,11,14', '2023-12-19 12:08:30', '2024-04-24 14:38:51', '2024-04-24 14:38:51'),
(6, 'Employee 4', NULL, '2023-12-21 06:42:40', '2024-04-24 14:39:08', '2024-04-24 14:39:08');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `user_type` tinyint DEFAULT '0',
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `emp_id` int DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `district` int DEFAULT NULL,
  `state` int DEFAULT NULL,
  `client_id` int DEFAULT NULL,
  `vendor_id` int DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_type`, `fname`, `lname`, `username`, `password`, `emp_id`, `email`, `mobile`, `location`, `district`, `state`, `client_id`, `vendor_id`, `status`, `role`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(2, 1, 'Admin', 'Super', 'superadmin', '25d55ad283aa400af464c76d713c07ad', NULL, 'superadmin@gmail.com', '1234567890', '1', NULL, NULL, NULL, NULL, 1, ',1,', '2025-06-18 20:55:41', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `district` int DEFAULT NULL,
  `state` int DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clients_ibfk_1` (`created_by`),
  ADD KEY `clients_ibfk_2` (`updated_by`),
  ADD KEY `clients_ibfk_3` (`deleted_by`),
  ADD KEY `clients_ibfk_5` (`district`),
  ADD KEY `clients_ibfk_4` (`state`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_items`
--
ALTER TABLE `food_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `food_items_ibfk_2` (`created_by`),
  ADD KEY `food_items_ibfk_3` (`updated_by`),
  ADD KEY `food_items_ibfk_4` (`deleted_by`),
  ADD KEY `food_items_ibfk_1` (`vendor_id`);

--
-- Indexes for table `food_orders`
--
ALTER TABLE `food_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `food_orders_ibfk_1` (`created_by`),
  ADD KEY `food_orders_ibfk_2` (`updated_by`),
  ADD KEY `food_orders_ibfk_3` (`deleted_by`),
  ADD KEY `food_orders_ibfk_5` (`client_id`),
  ADD KEY `food_orders_ibfk_4` (`vendor_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_ibfk_1` (`created_by`),
  ADD KEY `invoices_ibfk_2` (`updated_by`),
  ADD KEY `invoices_ibfk_3` (`deleted_by`),
  ADD KEY `invoices_ibfk_4` (`client_id`),
  ADD KEY `invoices_ibfk_5` (`payment_type`);

--
-- Indexes for table `invoice_payment`
--
ALTER TABLE `invoice_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_payment_ibfk_1` (`created_by`),
  ADD KEY `invoice_payment_ibfk_2` (`updated_by`),
  ADD KEY `invoice_payment_ibfk_3` (`deleted_by`),
  ADD KEY `invoice_payment_ibfk_4` (`invoice_id`),
  ADD KEY `invoice_payment_ibfk_5` (`payment_type`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_type`
--
ALTER TABLE `payment_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_ibfk_2` (`district`),
  ADD KEY `user_ibfk_1` (`state`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendors_ibfk_1` (`created_by`),
  ADD KEY `vendors_ibfk_2` (`updated_by`),
  ADD KEY `vendors_ibfk_3` (`deleted_by`),
  ADD KEY `vendors_ibfk_5` (`district`),
  ADD KEY `vendors_ibfk_4` (`state`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `food_orders`
--
ALTER TABLE `food_orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_payment`
--
ALTER TABLE `invoice_payment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_type`
--
ALTER TABLE `payment_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `clients_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `clients_ibfk_3` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `clients_ibfk_4` FOREIGN KEY (`state`) REFERENCES `state` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `clients_ibfk_5` FOREIGN KEY (`district`) REFERENCES `district` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `food_items`
--
ALTER TABLE `food_items`
  ADD CONSTRAINT `food_items_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `food_items_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `food_items_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `food_items_ibfk_4` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `food_orders`
--
ALTER TABLE `food_orders`
  ADD CONSTRAINT `food_orders_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `food_orders_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `food_orders_ibfk_3` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `food_orders_ibfk_4` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `food_orders_ibfk_5` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `invoices_ibfk_3` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `invoices_ibfk_4` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `invoices_ibfk_5` FOREIGN KEY (`payment_type`) REFERENCES `payment_type` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `invoice_payment`
--
ALTER TABLE `invoice_payment`
  ADD CONSTRAINT `invoice_payment_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `invoice_payment_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `invoice_payment_ibfk_3` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `invoice_payment_ibfk_4` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `invoice_payment_ibfk_5` FOREIGN KEY (`payment_type`) REFERENCES `payment_type` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`state`) REFERENCES `state` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`district`) REFERENCES `district` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `vendors`
--
ALTER TABLE `vendors`
  ADD CONSTRAINT `vendors_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `vendors_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `vendors_ibfk_3` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `vendors_ibfk_4` FOREIGN KEY (`state`) REFERENCES `state` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `vendors_ibfk_5` FOREIGN KEY (`district`) REFERENCES `district` (`id`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
