-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 14, 2018 at 09:53 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `airbnb-like_schema`
--

-- --------------------------------------------------------

--
-- Table structure for table `accommodations`
--

CREATE TABLE `accommodations` (
  `accom_id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8_bin NOT NULL,
  `location` varchar(25) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `rating` float DEFAULT '0',
  `votes` int(11) DEFAULT '0',
  `checkin` time NOT NULL,
  `checkout` time NOT NULL,
  `path_to_image` varchar(100) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `accommodations`
--

INSERT INTO `accommodations` (`accom_id`, `title`, `location`, `description`, `rating`, `votes`, `checkin`, `checkout`, `path_to_image`, `user_id`) VALUES
(2, 'Test', 'Test location', 'This is really a test.      	      	', 0, 0, '01:00:00', '05:00:00', '', 19),
(3, 'Test_2', 'Test_2 loc', 'This is the second test actually!      	', 0, 0, '13:37:00', '23:00:00', '', 20);

-- --------------------------------------------------------

--
-- Table structure for table `accom_rentals`
--

CREATE TABLE `accom_rentals` (
  `rent_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `accom_id` int(11) NOT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `status` enum('"completed"','"active"','','') COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(16) COLLATE utf8_bin NOT NULL,
  `password` varchar(60) COLLATE utf8_bin NOT NULL,
  `firstname` varchar(25) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(25) COLLATE utf8_bin NOT NULL,
  `path_to_avatar` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT 'pictures\\avatars\\generic-avatar.png',
  `email` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `firstname`, `lastname`, `path_to_avatar`, `email`) VALUES
(19, 'klido', '$2y$10$FkD2tTYYSt6xBlj4cI8sRuEaKcP6qf9L4aOFGS5Uzi7ebOOdRoQW.', 'nikos', 'kouniabella', 'pictures\\avatars\\generic-avatar.png', 'koun@mail.com'),
(20, 'delusional', '$2y$10$N8GPSCx1uWy/em64QKmop.G1fVrTjCymxPYemsK0k50LaH0WfMHVG', 'Kotsos', 'Lucifer', 'pictures\\avatars\\generic-avatar.png', 'lucy@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accommodations`
--
ALTER TABLE `accommodations`
  ADD PRIMARY KEY (`accom_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `accom_rentals`
--
ALTER TABLE `accom_rentals`
  ADD PRIMARY KEY (`rent_id`),
  ADD KEY `fk_rent_userid` (`user_id`),
  ADD KEY `fk_rent_accomid` (`accom_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accommodations`
--
ALTER TABLE `accommodations`
  MODIFY `accom_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accommodations`
--
ALTER TABLE `accommodations`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `accom_rentals`
--
ALTER TABLE `accom_rentals`
  ADD CONSTRAINT `fk_rent_accomid` FOREIGN KEY (`accom_id`) REFERENCES `accommodations` (`accom_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
