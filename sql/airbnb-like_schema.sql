-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2018 at 07:08 PM
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
  `description` text COLLATE utf8_bin,
  `rating` float DEFAULT '1',
  `votes` int(11) DEFAULT '0',
  `checkin` time NOT NULL,
  `checkout` time NOT NULL,
  `path_to_image` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT 'pictures\\accommodations\\not_available.jpg',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `accommodations`
--

INSERT INTO `accommodations` (`accom_id`, `title`, `location`, `description`, `rating`, `votes`, `checkin`, `checkout`, `path_to_image`, `user_id`) VALUES
(21, 'Good accommodation', 'Athens', 'Accommodation at athens greece very good.      	', 1, 0, '12:00:00', '00:09:00', 'pictures/accommodations/klido_room1.jpg', 31),
(22, 'Very good accommodation', 'Athens', 'Very good accommodation athens color purple very large, very best       	', 1, 0, '09:00:00', '12:00:00', 'pictures/accommodations/klido_room2.jpg', 31),
(23, 'The best Accommodation', 'Kos', 'Kos island, pool, sea ,water sport, breakfast the best ever.    	', 1, 0, '12:00:00', '09:00:00', 'pictures/accommodations/klido_room3.jpg', 31),
(24, 'GODLIKE Accommodation', 'Cyprus', 'Very Very good, people like 5 star, easy gg well played      	', 1, 0, '12:00:00', '00:09:00', 'pictures/accommodations/klido_room4.jpg', 31),
(25, 'Bad accommodation', 'Xaidari', 'Very far away from. Not that good very expensive      	', 1, 0, '00:01:00', '00:10:00', 'pictures/accommodations/delusional_room5.jpg', 32),
(26, 'Not that bad Accommodation', 'Crete', 'Not that expensive, close to airport if you need to leave for any reason', 1, 0, '09:00:00', '12:00:00', 'pictures/accommodations/delusional_room6.jpg', 32),
(27, 'Pretty normal Accommodation', 'Crete', 'Center, close to shops, very bad view but no expensive so no problem yes?       	', 1, 0, '09:00:00', '12:00:00', 'pictures/accommodations/delusional_room7.jpg', 32),
(28, 'Decent Accommodation', 'Crete', 'Crete very good place, very very decent room.      	', 1, 0, '12:00:00', '09:00:00', 'pictures/accommodations/delusional_room8.jpg', 32);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `rent_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `accom_id` int(11) NOT NULL,
  `checkin_date` date NOT NULL,
  `checkout_date` date NOT NULL,
  `status` enum('completed','active') COLLATE utf8_bin NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`rent_id`, `user_id`, `accom_id`, `checkin_date`, `checkout_date`, `status`) VALUES
(19, 32, 24, '2018-05-17', '2018-05-18', 'completed'),
(20, 32, 21, '2018-05-19', '2018-05-23', 'active'),
(21, 33, 21, '2018-06-01', '2018-06-09', 'active'),
(22, 31, 28, '2018-05-17', '2018-05-18', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `user_id` int(11) NOT NULL,
  `accom_id` int(11) NOT NULL,
  `rating` enum('1','2','3','4','5') COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`user_id`, `accom_id`, `rating`) VALUES
(32, 24, '4');

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
(31, 'klido', '$2y$10$a.Djx4MweGahvdnuXaw.fuHwAZT.JZ/Ax2iAZ6OEpxkNnQvwNsO9m', 'Nikos', 'Plebeloper', 'pictures/avatars/klido_kurotsuchi_mayuri.jpg', 'nikods@kappas.com'),
(32, 'delusional', '$2y$10$2EL2VQM51nCg/gvEFigSpOGfQg4BNQ4bZCFABehpLEHOmH99ffUUS', 'delu', 'zion', 'pictures/avatars/generic-avatar.png', 'delu@zion.com'),
(33, 'hckzen', '$2y$10$uTeIqjCYLKeVhbtDlH5Eze0utm/Q3fnq.A92IdbqPDrfxTiiyIwXG', 'HC', 'ZEN', 'pictures/avatars/hckzen_kyro.jpg', 'zen10@gmis.com');

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
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`rent_id`),
  ADD KEY `fk_rent_userid` (`user_id`),
  ADD KEY `fk_rent_accomid` (`accom_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`user_id`,`accom_id`),
  ADD KEY `fk_rating_accomid` (`accom_id`);

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
  MODIFY `accom_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `rent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accommodations`
--
ALTER TABLE `accommodations`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_rent_accomid` FOREIGN KEY (`accom_id`) REFERENCES `accommodations` (`accom_id`);

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `fk_rating_accomid` FOREIGN KEY (`accom_id`) REFERENCES `accommodations` (`accom_id`),
  ADD CONSTRAINT `fk_rating_userid` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
