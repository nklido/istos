-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2018 at 04:12 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

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
  `descr_id` int(11) NOT NULL,
  `rating` float DEFAULT '0',
  `votes` int(11) DEFAULT '0',
  `checkin` time NOT NULL,
  `checkout` time NOT NULL,
  `path_to_image` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `accom_registrations`
--

CREATE TABLE `accom_registrations` (
  `registration_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `accom_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `descriptions`
--

CREATE TABLE `descriptions` (
  `descr_id` int(11) NOT NULL,
  `description` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `rents`
--

CREATE TABLE `rents` (
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
  `password` varchar(40) COLLATE utf8_bin NOT NULL,
  `firstname` varchar(25) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(25) COLLATE utf8_bin NOT NULL,
  `path_to_avatar` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT 'pictures\\avatars\\generic-avatar.png',
  `email` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `firstname`, `lastname`, `path_to_avatar`, `email`) VALUES
(1, 'klido', 'admin1234', 'nikos', 'klido', 'pictures\\avatars\\generic-avatar.png', ''),
(2, 'deluzional', 'kobolobo', 'kwstis', 'anifas', 'pictures\\avatars\\generic-avatar.png', ''),
(17, 'suka', 'datcat', 'bliet', 'svidoi', 'pictures\\avatars\\generic-avatar.png', 'pocfdafda@fafdaf.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accommodations`
--
ALTER TABLE `accommodations`
  ADD PRIMARY KEY (`accom_id`),
  ADD KEY `fk_description_id` (`descr_id`);

--
-- Indexes for table `accom_registrations`
--
ALTER TABLE `accom_registrations`
  ADD PRIMARY KEY (`registration_id`),
  ADD KEY `fk_registr_userid` (`user_id`) USING BTREE,
  ADD KEY `fk_registr_accomid` (`accom_id`);

--
-- Indexes for table `descriptions`
--
ALTER TABLE `descriptions`
  ADD PRIMARY KEY (`descr_id`);

--
-- Indexes for table `rents`
--
ALTER TABLE `rents`
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
  MODIFY `accom_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accom_registrations`
--
ALTER TABLE `accom_registrations`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `descriptions`
--
ALTER TABLE `descriptions`
  MODIFY `descr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accommodations`
--
ALTER TABLE `accommodations`
  ADD CONSTRAINT `fk_description_id` FOREIGN KEY (`descr_id`) REFERENCES `descriptions` (`descr_id`);

--
-- Constraints for table `accom_registrations`
--
ALTER TABLE `accom_registrations`
  ADD CONSTRAINT `fk_registr_accomid` FOREIGN KEY (`accom_id`) REFERENCES `accommodations` (`accom_id`),
  ADD CONSTRAINT `fk_registr_userid` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `rents`
--
ALTER TABLE `rents`
  ADD CONSTRAINT `fk_rent_accomid` FOREIGN KEY (`accom_id`) REFERENCES `accommodations` (`accom_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
