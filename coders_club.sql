-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2025 at 04:26 PM
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
-- Database: `coders_club`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$YXRMjsM7fSmxZRDmZ8ce.e1o6GT/9r8ZB0bsZo0dI7Ipr/gAB9liC');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `question_text` text DEFAULT NULL,
  `option_a` varchar(100) DEFAULT NULL,
  `option_b` varchar(100) DEFAULT NULL,
  `option_c` varchar(100) DEFAULT NULL,
  `option_d` varchar(100) DEFAULT NULL,
  `correct_option` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `quiz_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`) VALUES
(7, 4, 'What is 2+1?', '3', '4', '0', '5', 'A'),
(8, 4, 'What is 10 x 10?', '10', '100', '1', '1000', 'B'),
(9, 4, 'What is 10-5?', '15', '50', '5', '1', 'C'),
(10, 4, 'What is 10/10?', '10', '1000', '100', '1', 'D'),
(11, 4, 'What is 1+10 x 20 - 50/ 10?', '17', '215', '196', '150', 'C'),
(12, 5, 'what is your name?', 'William', 'James', 'Cinthiya', 'Sri', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `time_limit` int(11) DEFAULT 5,
  `status` enum('inactive','active') DEFAULT 'inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `title`, `description`, `time_limit`, `status`) VALUES
(4, 'General', 'This is general quiz', 2, 'active'),
(5, 'Test', '', 30, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `attempted` int(11) DEFAULT NULL,
  `unanswered` int(11) DEFAULT NULL,
  `wrong` int(11) DEFAULT NULL,
  `percentage` decimal(5,2) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `quiz_id`, `student_id`, `score`, `total`, `attempted`, `unanswered`, `wrong`, `percentage`, `submitted_at`) VALUES
(6, 4, 8, 1, 5, 1, 4, 0, 20.00, '2025-07-27 05:30:57'),
(7, 4, 8, 1, 5, 1, 4, 0, 20.00, '2025-07-27 05:50:31'),
(8, 4, 8, 1, 5, 1, 4, 0, 20.00, '2025-07-27 05:51:49'),
(9, 4, 8, 5, 5, 5, 0, 0, 100.00, '2025-07-27 05:58:46'),
(10, 4, 8, 5, 5, 5, 0, 0, 100.00, '2025-07-27 06:00:18'),
(11, 4, 8, 5, 5, 5, 0, 0, 100.00, '2025-07-27 13:58:41'),
(12, 4, 8, 5, 5, 5, 0, 0, 100.00, '2025-07-27 14:05:58'),
(13, 4, 8, 5, 5, 5, 0, 0, 100.00, '2025-07-27 14:06:39'),
(14, 4, 8, 5, 5, 5, 0, 0, 100.00, '2025-07-27 14:10:16'),
(15, 4, 8, 5, 5, 5, 0, 0, 100.00, '2025-07-27 14:10:20'),
(16, 4, 8, 5, 5, 5, 0, 0, 100.00, '2025-07-27 14:14:23');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `reg_no` varchar(20) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile_no` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `reg_no`, `department`, `password`, `email`, `mobile_no`) VALUES
(8, 'WILLIAM JAMES A', '25PAI818', 'Artificial Intelligence', '$2y$10$izmqH.kWBpu33eLjjcQMPOd5IHBPQUr3yeCrmEQ8dp1bGXOLI2Q3K', 'williamjames4219@gmail.com', '8056560315'),
(9, 'Cinthiya Sri', '25PAI807', 'Artificial Intelligence', '$2y$10$zNSG3zUfTt02eyGUM0RQouzhVO7trw2AKzIawiZL02Pa8wr9fPTIC', 'cinthiya@gmail.comq', '7896547856');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reg_no` (`reg_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`);

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`),
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
