-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2026 at 04:40 AM
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
-- Database: `jfa_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `activity` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Kamera'),
(2, 'Lensa'),
(3, 'Audio'),
(4, 'Lighting'),
(5, 'Tripod');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `purchase_price` bigint(20) NOT NULL,
  `stock` int(11) DEFAULT 1,
  `condition_status` enum('Baik','Rusak') DEFAULT 'Baik',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `category_id`, `name`, `brand`, `purchase_price`, `stock`, `condition_status`, `created_at`) VALUES
(1, 1, 'Cinema Camera 6K Pro', 'Blackmagic', 39000000, 0, 'Baik', '2026-02-11 02:00:11'),
(2, 1, 'Pocket Cinema Camera 6K', 'Blackmagic', 33000000, -1, 'Baik', '2026-02-11 02:00:11'),
(3, 1, 'FX3', 'Sony', 63000000, 0, 'Baik', '2026-02-11 02:00:11'),
(4, 1, 'FX30', 'Sony', 32000000, 0, 'Baik', '2026-02-11 02:00:11'),
(5, 1, 'EOS C70', 'Canon', 98000000, 1, 'Baik', '2026-02-11 02:00:11'),
(6, 1, 'EOS C200', 'Canon', 85000000, 0, 'Baik', '2026-02-11 02:00:11'),
(7, 1, 'URSA Mini Pro', 'Blackmagic', 110000000, 1, 'Rusak', '2026-02-11 02:00:11'),
(8, 1, 'GH6', 'Panasonic', 35000000, 1, 'Baik', '2026-02-11 02:00:11'),
(9, 1, 'RED Komodo', 'RED', 110000000, 1, 'Baik', '2026-02-11 02:00:11'),
(10, 1, 'DJI Ronin 4D', 'DJI', 125000000, 1, 'Baik', '2026-02-11 02:00:11'),
(11, 2, 'Cine 35mm T1.5', 'Sigma', 55000000, 1, 'Baik', '2026-02-11 02:00:11'),
(12, 2, 'Cine 50mm T1.5', 'Sigma', 55000000, 1, 'Baik', '2026-02-11 02:00:11'),
(13, 2, 'Cine 85mm T1.5', 'Sigma', 55000000, 1, 'Baik', '2026-02-11 02:00:11'),
(14, 2, 'RF 24-70mm', 'Canon', 45000000, 1, 'Baik', '2026-02-11 02:00:11'),
(15, 2, 'RF 70-200mm', 'Canon', 50000000, 1, 'Baik', '2026-02-11 02:00:11'),
(16, 2, 'FE 24-70mm GM II', 'Sony', 42000000, 1, 'Baik', '2026-02-11 02:00:11'),
(17, 2, 'FE 70-200mm GM II', 'Sony', 45000000, 1, 'Rusak', '2026-02-11 02:00:11'),
(18, 2, 'Cine 24mm T1.5', 'Meike', 19000000, 1, 'Baik', '2026-02-11 02:00:11'),
(19, 2, 'Cine 35mm T2.1', 'Rokinon', 22000000, 1, 'Baik', '2026-02-11 02:00:11'),
(20, 2, 'Anamorphic 50mm', 'Sirui', 24000000, 1, 'Baik', '2026-02-11 02:00:11'),
(21, 3, 'MKH 416', 'Sennheiser', 18000000, 1, 'Rusak', '2026-02-11 02:00:11'),
(22, 3, 'NTG-5', 'Rode', 8500000, 1, 'Baik', '2026-02-11 02:00:11'),
(23, 3, 'Wireless G4', 'Sennheiser', 12000000, 1, 'Baik', '2026-02-11 02:00:11'),
(24, 3, 'AXIENT Digital', 'Shure', 75000000, 1, 'Baik', '2026-02-11 02:00:11'),
(25, 3, 'MixPre-6 II', 'Sound Devices', 18000000, 1, 'Baik', '2026-02-11 02:00:11'),
(26, 3, 'Zoom F8n', 'Zoom', 17000000, 1, 'Baik', '2026-02-11 02:00:11'),
(27, 3, 'Boom Pole', 'Rode', 4500000, 1, 'Baik', '2026-02-11 02:00:11'),
(28, 3, 'Field Mixer 302', 'Sound Devices', 28000000, 1, 'Rusak', '2026-02-11 02:00:11'),
(29, 3, 'HD 280 Pro', 'Sennheiser', 2500000, 1, 'Baik', '2026-02-11 02:00:11'),
(30, 3, 'COS-11D', 'Sanken', 6000000, 1, 'Baik', '2026-02-11 02:00:11'),
(31, 4, '300D II', 'Aputure', 20000000, 1, 'Rusak', '2026-02-11 02:00:11'),
(32, 4, '600D Pro', 'Aputure', 35000000, 1, 'Baik', '2026-02-11 02:00:11'),
(33, 4, 'Titan Tube', 'Astera', 38000000, 1, 'Baik', '2026-02-11 02:00:11'),
(34, 4, 'Gemini 2x1', 'Litepanels', 95000000, 1, 'Baik', '2026-02-11 02:00:11'),
(35, 4, 'Nova P300c', 'Aputure', 30000000, 1, 'Baik', '2026-02-11 02:00:11'),
(36, 4, 'Spotlight 36', 'Aputure', 12000000, 1, 'Baik', '2026-02-11 02:00:11'),
(37, 4, 'Fresnel F10', 'Aputure', 9000000, 0, 'Baik', '2026-02-11 02:00:11'),
(38, 4, 'Light Dome II', 'Aputure', 4500000, 1, 'Rusak', '2026-02-11 02:00:11'),
(39, 4, 'C-Stand Kit', 'Avenger', 7000000, 0, 'Baik', '2026-02-11 02:00:11'),
(40, 4, 'Power Station', 'EcoFlow', 25000000, 1, 'Baik', '2026-02-11 02:00:11');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('pending','approved','borrowed','on_loan','returned','rejected') DEFAULT 'pending',
  `start_date` datetime DEFAULT NULL,
  `condition_start` text DEFAULT NULL,
  `condition_end` text DEFAULT NULL,
  `fine` bigint(20) DEFAULT 0,
  `qr_code` varchar(255) DEFAULT NULL,
  `pickup_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `returned_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `user_id`, `item_id`, `return_date`, `status`, `start_date`, `condition_start`, `condition_end`, `fine`, `qr_code`, `pickup_code`, `created_at`, `returned_at`) VALUES
(1, 5, 3, NULL, 'rejected', NULL, 'awdad', NULL, 0, NULL, NULL, '2026-02-11 05:59:16', NULL),
(2, 4, 1, NULL, 'rejected', NULL, 'aman sih\r\n', NULL, 0, NULL, NULL, '2026-02-11 06:55:29', NULL),
(3, 5, 2, NULL, 'rejected', NULL, 'bvagus ', NULL, 0, NULL, NULL, '2026-02-12 01:46:10', NULL),
(4, 5, 2, NULL, 'rejected', NULL, 'mantap', NULL, 0, NULL, NULL, '2026-02-24 02:07:37', NULL),
(5, 5, 3, '2026-02-24', 'rejected', NULL, 'mantap', NULL, 0, NULL, NULL, '2026-02-24 02:18:17', NULL),
(6, 5, 4, '2026-02-28', 'rejected', NULL, 'mantap', NULL, 0, 'JFA-308B4A', NULL, '2026-02-24 02:47:06', NULL),
(7, 5, 2, '2026-02-27', 'rejected', NULL, 'AD', NULL, 0, 'JFA-92C66C', 'JFA-92C66C', '2026-02-24 03:57:47', NULL),
(8, 5, 1, '2026-02-24', 'rejected', NULL, 'adad', NULL, 0, 'JFA-66904F', 'JFA-66904F', '2026-02-24 07:17:28', NULL),
(9, 5, 3, '2026-02-26', 'rejected', NULL, 'bagus', NULL, 0, 'JFA-34A304', 'JFA-34A304', '2026-02-24 07:51:16', NULL),
(10, 5, 6, '2026-02-27', 'rejected', NULL, 'jelek', NULL, 0, 'JFA-27C804', 'JFA-27C804', '2026-02-26 07:03:40', NULL),
(11, 5, 37, '2026-03-05', 'approved', NULL, 'bodi kamera jelek', NULL, 0, 'JFA-62DD10', 'JFA-62DD10', '2026-03-02 02:12:12', NULL),
(12, 5, 39, '2026-03-04', 'approved', NULL, 'adad', NULL, 0, 'JFA-1AAE51', 'JFA-1AAE51', '2026-03-02 02:27:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loan_items`
--

CREATE TABLE `loan_items` (
  `id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `umur` int(11) NOT NULL,
  `semester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `search_history`
--

CREATE TABLE `search_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `search_history`
--

INSERT INTO `search_history` (`id`, `user_id`, `keyword`, `created_at`) VALUES
(1, 5, 'fx', '2026-03-02 02:11:45'),
(2, 5, 'sony', '2026-03-02 02:11:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','petugas','mahasiswa') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `role`, `created_at`) VALUES
(3, '', 'admin', '$2y$10$CS2uerkn2kIcLmT7Id/noOxulLLYl//cgNrm2LA5u3T19bxgZAIm6', 'admin', '2026-02-11 02:45:23'),
(4, '', 'petugas', '$2y$10$CS2uerkn2kIcLmT7Id/noOxulLLYl//cgNrm2LA5u3T19bxgZAIm6', 'petugas', '2026-02-11 02:45:23'),
(5, '', 'mahasiswa', '$2y$10$CS2uerkn2kIcLmT7Id/noOxulLLYl//cgNrm2LA5u3T19bxgZAIm6', 'mahasiswa', '2026-02-11 02:45:23');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_item` (`item_id`);

--
-- Indexes for table `loan_items`
--
ALTER TABLE `loan_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_id` (`loan_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `search_history`
--
ALTER TABLE `search_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_id` (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `loan_items`
--
ALTER TABLE `loan_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `search_history`
--
ALTER TABLE `search_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `fk_item` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loan_items`
--
ALTER TABLE `loan_items`
  ADD CONSTRAINT `loan_items_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loan_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `search_history`
--
ALTER TABLE `search_history`
  ADD CONSTRAINT `search_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
