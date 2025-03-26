-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2024 at 01:25 AM
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
(27, 'Commercial Project in Quezon', 22, '1500 sq. ft.', '2024-12-26', 10000000.00, 'pending', 'commercial', 'Quezon City', 'High-quality Wood', 'Eco-Friendly', 'source for high-quality woods suppliers.', '2024-12-19 18:57:48', NULL);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`id`, `username`, `structural_options`, `architectural_options`, `civil_options`, `mechanical_options`, `electrical_options`, `plumbing_options`, `property_type`, `project_location`, `project_size`, `start_date`, `end_date`, `budget_range`, `communication_mode`, `contact_time`, `materials_preference`, `design_requirements`, `services_needed`, `scope_of_work`, `special_requests`, `site_visit_date`, `site_visit_time`, `attachments`, `created_at`, `status`) VALUES
(30, 'seanagustin', 'Foundation Works, Reinforced Concrete, Steel Work', 'Flooring, Ceiling, Wall Finishes', 'Stormwater Management, Retaining Walls, Fencing and Gate Installation', 'Air-Handling Units, Pumps and Motors, Chillers and Boilers', 'Power Supply Systems, Lighting Systems, Others', 'Water Supply Systems, Drainage Systems, Sewage Treatment', 'commercial', 'Quezon City', '1500 sq. ft.', '2024-12-21', '2025-01-31', 10000000.00, 'Email', '10am - 9pm', 'High-quality Wood', '', '', 'Interior Design', 'Eco-friendly', '2024-12-24', '10:00:00', 'uploads/dsc00032-Yle5ajrOKOCVxQ9v.jpg', '2024-12-19 18:54:50', 'Pending');

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
(13, 27, 'Week 1', '2024-12-31 10:00:00', 'uploads/67646e8ed9ed24.57689128.jpg', 'Insufficient Concretes', 'Bulldozers', 'Insufficient Concretes', '2024-12-19 19:05:50', NULL);

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
(22, 'Sean', 'Agustin', 'seanariel', 'sean@gmail.com', '$2y$10$wGegTDF/2D1omBVT.CU50u.innnd3QjLBPF0XrvxY2M1Tln4x5FdC', 1, 'client', '2024-12-19 18:50:24'),
(23, 'Sam', 'Agagas', 'samagagas', 'sam@gmail.com', '$2y$10$0tF9DEnCwihdY22WHC1OUOUf2TZaI2rLOmpunrh6ipep/V94iehvO', 0, 'admin', '2024-12-19 18:50:49'),
(24, 'Erwin', 'Lebrino', 'erwinlebrino', 'erwin@gmail.com', '$2y$10$11uKNF6zw9ZVoCd5.KI7iuZHPYU.JuBY4ByqOlV2wYL.OsOAjVHmO', 0, 'manager', '2024-12-19 18:51:33');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tracking_reports`
--
ALTER TABLE `tracking_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
