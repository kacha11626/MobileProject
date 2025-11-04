-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2025 at 02:40 PM
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
-- Database: `fitness_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `full_name`, `created_at`) VALUES
(1, 'test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Test User', '2025-10-19 11:08:32'),
(2, 'chalumarichard62@gmail.com', '$2y$10$kDJQyPlr4lCtf0c43/hlMuW.vtQFDPWOL/s3ngvGFtQ9NWIMaVhNC', 'Richard Chaluma', '2025-10-19 11:43:30'),
(4, 'kacha62@gmail.com', '$2y$10$usdsx.Op0UWXRFCZ.1CYDOPj/0D5/yVUojTKkwTx3nE2vKDnZvG4u', 'Richard Chaluma', '2025-10-19 11:44:42'),
(5, 'peter@gmail.com', '$2y$10$VlXF1LvGxKGqgloGNhNjd.X4AF4DeHREwNk4BGnrzIvJW68Rm8vWS', 'peter', '2025-10-27 08:31:12');

-- --------------------------------------------------------

--
-- Table structure for table `workouts`
--

CREATE TABLE `workouts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('Running','Cycling','Swimming','Yoga','Weightlifting') NOT NULL,
  `distance` decimal(8,2) DEFAULT NULL,
  `duration` int(11) NOT NULL,
  `calories` int(11) NOT NULL,
  `date` varchar(50) NOT NULL,
  `details` text DEFAULT NULL,
  `coordinates` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workouts`
--

INSERT INTO `workouts` (`id`, `user_id`, `type`, `distance`, `duration`, `calories`, `date`, `details`, `coordinates`, `created_at`) VALUES
(1, 1, 'Running', 5.20, 28, 320, 'Oct 20, 2024', 'Morning run', NULL, '2025-10-23 09:23:34'),
(2, 1, 'Cycling', 15.50, 45, 480, 'Oct 19, 2024', 'Evening cycling', NULL, '2025-10-23 09:23:34'),
(3, 1, 'Swimming', 1.00, 30, 240, 'Oct 18, 2024', 'Laps: 20', NULL, '2025-10-23 09:23:34'),
(4, 1, 'Yoga', NULL, 60, 180, 'Oct 17, 2024', 'Hatha yoga session', NULL, '2025-10-23 09:23:34'),
(5, 1, 'Weightlifting', NULL, 45, 280, 'Oct 16, 2024', 'Bench press and squats', NULL, '2025-10-23 09:23:34'),
(6, 1, 'Running', 12.00, 14, 720, 'Oct 23, 2025', '', '', '2025-10-23 09:44:25'),
(7, 1, 'Running', 12.00, 14, 720, 'Oct 23, 2025', '', '', '2025-10-23 09:44:25'),
(8, 1, 'Running', 12.00, 14, 720, 'Oct 23, 2025', '', '', '2025-10-23 09:44:25'),
(9, 1, 'Running', 12.00, 14, 720, 'Oct 23, 2025', '', '', '2025-10-23 09:44:25'),
(10, 1, 'Running', 12.00, 45, 720, 'Oct 23, 2025', '', '', '2025-10-23 09:49:11'),
(11, 1, 'Running', 12.00, 45, 720, 'Oct 27, 2025', '', '', '2025-10-27 08:17:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `workouts`
--
ALTER TABLE `workouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `workouts`
--
ALTER TABLE `workouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `workouts`
--
ALTER TABLE `workouts`
  ADD CONSTRAINT `workouts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
