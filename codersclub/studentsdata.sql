-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2025 at 03:38 PM
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
-- Table structure for table `studentsdata`
--

CREATE TABLE `studentsdata` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `plain_password` varchar(100) DEFAULT NULL,
  `hashed_password` varchar(255) DEFAULT NULL,
  `score` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `studentsdata`
--

INSERT INTO `studentsdata` (`id`, `name`, `email`, `plain_password`, `hashed_password`, `score`) VALUES
(1, 'WILLIAM JAMES A', 'williamjames4219@gmail.com', 'Williamjames@805656#', '$2y$10$V6PisnIZOaDL6JZTaQlNoe4fJ0KjFk6XKEJ7/AUD1ClpNMV3HM7rK', 0),
(2, 'Cinthiya Sri', 'sri@gmail.com', 'sri123', '$2y$10$WeZwMw6GRNe2UkQXWWtEKuyJ4vENTvROV4KE/JvsSqJfkZHqED7/2', 0),
(3, 'Thanuja shree', 'thanujadoll@gmail.com', 'shree@123', '$2y$10$t/QERMLwEhARJELDute9IOJd8Bb.CXPRbBrZfTAbJXLx739zG0DOO', 0),
(4, 'Rakesh', 'rakesh@gmail.com', '12345', '$2y$10$sytSiNqKl3UW/FC/VnVQLOj6p9HvOL9jUkPfPB97zMOTRSIu1ToGK', 0),
(5, 'Subashini', 'suba@gmail.com', '12345', '$2y$10$ZcNMkolFVFjWYF86G3dYOezvx5zwoqp.fEI3uognFT25wJySQl5O2', 0),
(6, 'Jeeva', 'jeeva@gmail.com', '12345', '$2y$10$oWMoshDSlphOiCyQF1gFEOuzr1onpX69bmJzfHSzrFf3S6nmbbpzm', 0),
(7, 'Nandhakumar', 'nandha@gmail.com', '12345', '$2y$10$f4jCORDKv/upg8HbX008U.02o5fCnqOguhnlanR9q.YaH9.Ldn1W6', 0),
(8, 'Shri Harish', 'hari@gmail.com', '12345', '$2y$10$fAZwmUgC4mjGSdC7WSlR8e4r1UXrzmKCXCRZa/qXk85osvnLl7kVe', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `studentsdata`
--
ALTER TABLE `studentsdata`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `studentsdata`
--
ALTER TABLE `studentsdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
