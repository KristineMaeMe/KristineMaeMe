-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2024 at 07:29 AM
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
-- Database: `appdev`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `about` text NOT NULL,
  `posted_by` varchar(255) NOT NULL,
  `specific_type` varchar(50) NOT NULL,
  `course` varchar(50) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `section` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `about` text NOT NULL,
  `posted_by` varchar(255) NOT NULL,
  `general_or_specific` enum('general','specific') NOT NULL,
  `course` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `date`, `time`, `location`, `about`, `posted_by`, `general_or_specific`, `course`, `created_at`) VALUES
(1, 'INTRAMS', '2024-05-27', '10:00:00', 'USTP JASAAN MISAMIS ORIENTAL', 'Panagtigi 2024', 'USG', 'specific', 'BSIT', '2024-05-27 04:54:48'),
(2, 'ACQUINTANCE PARTY', '2024-05-27', '10:00:00', 'USTP JASAAN MISAMIS ORIENTAL', 'Panagtigi 2024', 'USG', 'general', 'BSIT', '2024-05-27 04:56:36'),
(3, 'BLOOD LETTING', '2024-05-27', '10:00:00', 'USTP JASAAN MISAMIS ORIENTAL', 'Panagtigi 2024', 'USG', 'general', 'BSIT', '2024-05-27 05:10:47'),
(4, 'IT DAYS', '2024-05-27', '10:00:00', 'USTP JASAAN MISAMIS ORIENTAL', 'Panagtigi 2024', 'USG', 'specific', 'BSIT', '2024-05-27 05:12:22');

-- --------------------------------------------------------

--
-- Table structure for table `event_responses`
--

CREATE TABLE `event_responses` (
  `id` int(11) UNSIGNED NOT NULL,
  `event_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `response` varchar(255) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_responses`
--

INSERT INTO `event_responses` (`id`, `event_id`, `name`, `user_id`, `response`, `reason`, `created_at`) VALUES
(1, 2, 'ACQUINTANCE PARTY', '2020200077', '', '', '2024-05-27 05:25:29'),
(2, 3, 'BLOOD LETTING', '2020200077', '', '', '2024-05-27 05:26:29'),
(3, 3, 'BLOOD LETTING', '2020200077', 'Going', '', '2024-05-27 05:28:33'),
(4, 2, 'ACQUINTANCE PARTY', '2020200077', 'Not Going', 'Kapoy man', '2024-05-27 05:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `course` varchar(50) NOT NULL,
  `year` int(4) NOT NULL,
  `section` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `student_id`, `name`, `password`, `course`, `year`, `section`) VALUES
(1, '2020200077', 'Jan Chester Madrelejos', '2020200077', 'BSNAME', 3, 'b'),
(2, '2020200076', 'Miguelito Tajuda', '2020200076', 'BSIT', 3, 'B');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_event_id` (`id`);

--
-- Indexes for table `event_responses`
--
ALTER TABLE `event_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD UNIQUE KEY `student_id_2` (`student_id`),
  ADD KEY `idx_student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `event_responses`
--
ALTER TABLE `event_responses`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_responses`
--
ALTER TABLE `event_responses`
  ADD CONSTRAINT `event_responses_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `event_responses_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
