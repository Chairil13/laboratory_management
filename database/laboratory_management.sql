-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2026 at 03:26 PM
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
-- Database: `laboratory_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `total_quantity` int(11) NOT NULL DEFAULT 0,
  `available_quantity` int(11) NOT NULL DEFAULT 0,
  `location` varchar(200) DEFAULT NULL,
  `condition` enum('baik','rusak ringan','rusak berat') DEFAULT 'baik',
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `qty_good` int(11) NOT NULL DEFAULT 0,
  `qty_minor_damage` int(11) NOT NULL DEFAULT 0,
  `qty_major_damage` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `code`, `name`, `category_id`, `total_quantity`, `available_quantity`, `location`, `condition`, `description`, `created_at`, `updated_at`, `qty_good`, `qty_minor_damage`, `qty_major_damage`) VALUES
(7, 'ss', 'infokus', 6, 10, 2, 'gedung A', 'baik', 'tes', '2026-05-15 20:22:21', '2026-05-15 22:24:29', 0, 0, 8);

-- --------------------------------------------------------

--
-- Table structure for table `borrowings`
--

CREATE TABLE `borrowings` (
  `id` int(11) NOT NULL,
  `borrow_code` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `borrow_date` date NOT NULL,
  `return_date` date NOT NULL,
  `purpose` text NOT NULL,
  `status` enum('pending','approved','rejected','returned','cancelled','pending_return') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowings`
--

INSERT INTO `borrowings` (`id`, `borrow_code`, `user_id`, `borrow_date`, `return_date`, `purpose`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(8, 'BRW-20260512-5313', 3, '2026-05-13', '2026-05-20', 'untuk presentasi di matakuliah elekro', 'returned', NULL, '2026-05-12 18:27:48', '2026-05-12 20:33:28'),
(9, 'BRW-20260515-9591', 3, '2026-05-15', '2026-05-22', 'cek', 'returned', NULL, '2026-05-15 19:14:21', '2026-05-15 22:08:14'),
(10, 'BRW-20260515-1365', 3, '2026-05-16', '2026-05-22', 'cc', 'cancelled', NULL, '2026-05-15 19:52:34', '2026-05-15 21:56:08'),
(11, 'BRW-20260515-9793', 3, '2026-05-15', '2026-05-22', 'cek', 'returned', NULL, '2026-05-15 20:14:23', '2026-05-15 22:17:04'),
(12, 'BRW-20260515-9460', 3, '2026-05-15', '2026-05-22', 'ddd', 'returned', NULL, '2026-05-15 20:17:59', '2026-05-15 22:19:05'),
(13, 'BRW-20260515-2407', 3, '2026-05-15', '2026-05-22', 'test', 'returned', NULL, '2026-05-15 20:22:55', '2026-05-15 22:24:29');

-- --------------------------------------------------------

--
-- Table structure for table `borrow_details`
--

CREATE TABLE `borrow_details` (
  `id` int(11) NOT NULL,
  `borrowing_id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrow_details`
--

INSERT INTO `borrow_details` (`id`, `borrowing_id`, `asset_id`, `quantity`) VALUES
(12, 13, 7, 8);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(6, 'Penunjang Belajar', 'contoh', '2026-05-12 18:24:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `type` enum('info','success','warning','danger') DEFAULT 'info',
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created_at`) VALUES
(9, 3, 'Peminjaman Disetujui', 'Peminjaman dengan kode BRW-20260512-5313 telah disetujui', 'success', 0, '2026-05-12 18:29:57'),
(10, 3, 'Pengembalian Diajukan', 'Pengembalian untuk peminjaman BRW-20260512-5313 sedang diproses admin', 'info', 0, '2026-05-12 18:32:51'),
(11, 3, 'Pengembalian Disetujui', 'Pengembalian untuk peminjaman BRW-20260512-5313 telah disetujui', 'success', 0, '2026-05-12 18:33:28'),
(12, 3, 'Peminjaman Disetujui', 'Peminjaman dengan kode BRW-20260515-9591 telah disetujui', 'success', 0, '2026-05-15 19:34:09'),
(13, 3, 'Pengembalian Diajukan', 'Pengembalian untuk peminjaman BRW-20260515-9591 sedang diproses admin', 'info', 0, '2026-05-15 19:38:17'),
(14, 3, 'Pengembalian Disetujui', 'Pengembalian untuk peminjaman BRW-20260515-9591 telah disetujui', 'success', 0, '2026-05-15 20:08:14'),
(15, 3, 'Peminjaman Disetujui', 'Peminjaman dengan kode BRW-20260515-9793 telah disetujui', 'success', 0, '2026-05-15 20:14:48'),
(16, 3, 'Pengembalian Diajukan', 'Pengembalian untuk peminjaman BRW-20260515-9793 sedang diproses admin', 'info', 0, '2026-05-15 20:15:59'),
(17, 3, 'Pengembalian Disetujui', 'Pengembalian untuk peminjaman BRW-20260515-9793 telah disetujui', 'success', 0, '2026-05-15 20:17:04'),
(18, 3, 'Peminjaman Disetujui', 'Peminjaman dengan kode BRW-20260515-9460 telah disetujui', 'success', 0, '2026-05-15 20:18:23'),
(19, 3, 'Pengembalian Diajukan', 'Pengembalian untuk peminjaman BRW-20260515-9460 sedang diproses admin', 'info', 0, '2026-05-15 20:18:48'),
(20, 3, 'Pengembalian Disetujui', 'Pengembalian untuk peminjaman BRW-20260515-9460 telah disetujui', 'success', 0, '2026-05-15 20:19:05'),
(21, 3, 'Peminjaman Disetujui', 'Peminjaman dengan kode BRW-20260515-2407 telah disetujui', 'success', 0, '2026-05-15 20:23:17'),
(22, 3, 'Pengembalian Diajukan', 'Pengembalian untuk peminjaman BRW-20260515-2407 sedang diproses admin', 'info', 0, '2026-05-15 20:24:09'),
(23, 3, 'Pengembalian Disetujui', 'Pengembalian untuk peminjaman BRW-20260515-2407 telah disetujui', 'success', 0, '2026-05-15 20:24:29');

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` int(11) NOT NULL,
  `borrowing_id` int(11) NOT NULL,
  `return_date` datetime NOT NULL,
  `condition` enum('baik','rusak ringan','rusak berat') DEFAULT 'baik',
  `status` enum('pending_return','returned','rejected') DEFAULT 'pending_return',
  `verified_by` int(11) DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`id`, `borrowing_id`, `return_date`, `condition`, `status`, `verified_by`, `verified_at`, `rejection_reason`, `notes`, `created_at`) VALUES
(3, 8, '2026-05-12 18:32:51', 'rusak berat', 'returned', 1, '2026-05-12 18:33:28', NULL, 'sorry pak, infokus sempat jatuh dari lantai 2', '2026-05-12 18:32:51'),
(4, 9, '2026-05-15 19:38:17', 'rusak berat', 'returned', 1, '2026-05-15 20:08:14', NULL, 'rusak kak', '2026-05-15 19:38:17'),
(5, 11, '2026-05-15 20:15:59', 'rusak ringan', 'returned', 1, '2026-05-15 20:17:04', NULL, 'maaf pak', '2026-05-15 20:15:59'),
(6, 12, '2026-05-15 20:18:48', 'rusak berat', 'returned', 1, '2026-05-15 20:19:05', NULL, 've', '2026-05-15 20:18:48'),
(7, 13, '2026-05-15 20:24:09', 'rusak berat', 'returned', 1, '2026-05-15 20:24:29', NULL, 'test', '2026-05-15 20:24:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `nim_nip` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin','kepala_lab') DEFAULT 'user',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `nim_nip`, `email`, `username`, `password`, `role`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'ADMIN001', 'admin@lab.com', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2026-05-15 22:24:21', '2026-05-04 23:53:47', '2026-05-15 22:24:21'),
(2, 'Kepala Lab', 'KEPALA001', 'kepala@lab.com', 'kepala_lab', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'kepala_lab', '2026-05-15 22:24:49', '2026-05-04 23:53:47', '2026-05-15 22:24:49'),
(3, 'User Demo', 'USER001', 'user@lab.com', 'user', '$2y$10$ykGfcGMOe8Y6et/KOyuwIenWVFqVFod75nXlZFLeqirqChDlMiEhm', 'user', '2026-05-15 22:25:09', '2026-05-04 23:53:47', '2026-05-15 22:25:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `borrow_code` (`borrow_code`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `borrow_details`
--
ALTER TABLE `borrow_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrowing_id` (`borrowing_id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrowing_id` (`borrowing_id`),
  ADD KEY `verified_by` (`verified_by`),
  ADD KEY `idx_returns_status` (`status`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim_nip` (`nim_nip`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `borrow_details`
--
ALTER TABLE `borrow_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD CONSTRAINT `borrowings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `borrow_details`
--
ALTER TABLE `borrow_details`
  ADD CONSTRAINT `borrow_details_ibfk_1` FOREIGN KEY (`borrowing_id`) REFERENCES `borrowings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `borrow_details_ibfk_2` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `returns_ibfk_1` FOREIGN KEY (`borrowing_id`) REFERENCES `borrowings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `returns_ibfk_2` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
