-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 19, 2024 at 11:24 AM
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
-- Database: `hsma`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL,
  `size` varchar(50) NOT NULL,
  `timeline` date NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `status` enum('pending','ongoing','completed') NOT NULL,
  `property_type` enum('residential','commercial','industrial','agricultural','mixed-use','special','vacant-land','recreational') NOT NULL,
  `location` varchar(255) NOT NULL,
  `material_preference` varchar(255) NOT NULL,
  `design_requirements` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `client_id`, `size`, `timeline`, `budget`, `status`, `property_type`, `location`, `material_preference`, `design_requirements`, `notes`, `created_at`, `updated_at`) VALUES
(26, 'asdasd', 18, 'asdas', '2025-01-01', 200000.00, 'completed', 'mixed-use', 'asdas', 'asdas', 'ada', 'asdas', '2024-12-19 09:32:23', '2024-12-19 09:53:16');

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `structural_options` text DEFAULT NULL,
  `architectural_options` text DEFAULT NULL,
  `civil_options` text DEFAULT NULL,
  `mechanical_options` text DEFAULT NULL,
  `electrical_options` text DEFAULT NULL,
  `plumbing_options` text DEFAULT NULL,
  `property_type` varchar(255) DEFAULT NULL,
  `project_location` varchar(255) DEFAULT NULL,
  `project_size` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `budget_range` decimal(10,2) DEFAULT NULL,
  `communication_mode` varchar(255) DEFAULT NULL,
  `contact_time` varchar(255) DEFAULT NULL,
  `materials_preference` varchar(255) DEFAULT NULL,
  `design_requirements` varchar(255) DEFAULT NULL,
  `services_needed` varchar(255) DEFAULT NULL,
  `scope_of_work` varchar(255) DEFAULT NULL,
  `special_requests` text DEFAULT NULL,
  `site_visit_date` date DEFAULT NULL,
  `site_visit_time` time DEFAULT NULL,
  `attachments` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`id`, `username`, `structural_options`, `architectural_options`, `civil_options`, `mechanical_options`, `electrical_options`, `plumbing_options`, `property_type`, `project_location`, `project_size`, `start_date`, `end_date`, `budget_range`, `communication_mode`, `contact_time`, `materials_preference`, `design_requirements`, `services_needed`, `scope_of_work`, `special_requests`, `site_visit_date`, `site_visit_time`, `attachments`, `created_at`) VALUES
(28, 'seangay', 'Foundation Works, Masonry Works', 'Flooring, Wall Finishes', 'Site Development, Earthworks', 'Fire Protection Systems, Lifts/Elevators', 'Auxiliary Services, Audio-Visual Systems', 'Sewage Treatment, Gas Systems', 'residential', 'Michael Street', '500', '2024-12-06', '2024-12-09', 50000.00, 'email', '9pm', 'Woody', 'Aesthetic', 'None', 'Amazing', 'None', '2024-12-26', '22:21:00', 'uploads/Screenshot 2024-12-14 203127.png', '2024-12-17 14:16:41'),
(29, 'seangay', 'Masonry Works', 'Wall Finishes, Partitions', 'Earthworks, Retaining Walls', 'Lifts/Elevators, Air-Handling Units', 'Auxiliary Services', 'Sewage Treatment, Hot Water Systems', 'industrial', 'Michael Street', '500', '2024-12-31', '2025-01-08', 99999999.99, 'email', '9pm', 'Woody', 'Aesthetic', 'None', 'Amazing', 'None', '2025-01-09', '23:56:00', '', '2024-12-17 15:51:39');

-- --------------------------------------------------------

--
-- Table structure for table `tracking_reports`
--

CREATE TABLE `tracking_reports` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `work_performed` text NOT NULL,
  `equipment_used` text DEFAULT NULL,
  `additional_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tracking_reports`
--

INSERT INTO `tracking_reports` (`id`, `project_id`, `title`, `datetime`, `image`, `work_performed`, `equipment_used`, `additional_notes`, `created_at`, `updated_at`) VALUES
(11, 26, 'adasd', '2024-12-05 20:32:00', 'uploads/6763e84b68b6f9.45747827.png,uploads/6763e84b68e187.17278769.png,uploads/6763e84b690776.87328188.png', 'adas', 'adasd,sadas', 'adas', '2024-12-19 09:32:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `terms_conditions` tinyint(1) NOT NULL DEFAULT 0,
  `role` enum('admin','manager','client') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `terms_conditions`, `role`, `created_at`) VALUES
(17, 'Michael', 'Ursal', 'maykelorsal', 'maykel@gmail.com', '$2y$10$Se2dG6L9B0Y.FXlfl.fNk.0yN0TA6by//mHFLvd1y.g9HxAJf6.9m', 0, 'admin', '2024-12-17 13:56:43'),
(18, 'Sean', 'Agustin', 'seangay', 'seanbading@gmail.com', '$2y$10$BE6IVVfYlXRiFpPtZ/E.R.Gycx2WfInV9ZoKgpkcgZa5L3REEXsae', 1, 'client', '2024-12-17 13:57:03'),
(19, 'Sammy', 'Agagas', 'sammy', 'sammy@gmail.com', '$2y$10$4bJsI6OPGwE4g/UmKuyDi.MtHBGPz0LsZA7dPrOS.ofYITqDRWyoW', 0, 'manager', '2024-12-17 14:01:57'),
(20, 'Neil', 'Malas', 'neilmalas', 'neil@gmail.com', '$2y$10$G3vnbdMZ89.dLnusJlvkgOk0Ur16DSMNDgDY/vl9XCWs/F7LA/0eO', 1, 'client', '2024-12-19 07:47:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tracking_reports`
--
ALTER TABLE `tracking_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tracking_reports`
--
ALTER TABLE `tracking_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tracking_reports`
--
ALTER TABLE `tracking_reports`
  ADD CONSTRAINT `tracking_reports_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
