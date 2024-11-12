-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2023 at 04:40 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movieproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `phone_no`) VALUES
(1, 'bipin', 'sainjubipin24746@gmail.com', '$2y$10$nBrneGxlFdotk.56Ca/MFeFsr1S63IY9pB8TBUJP8FlBZPXou4bge', 1234567890);

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `show_date` date NOT NULL,
  `show_time` time NOT NULL,
  `seat_num` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `movie_id`, `show_date`, `show_time`, `seat_num`, `total_price`, `booking_date`, `booking_time`, `user_id`) VALUES
(87, 3, '2023-11-13', '19:02:00', 4, 6, '2023-11-12', '20:57:25', 4),
(88, 3, '2023-11-13', '19:02:00', 8, 6, '2023-11-12', '20:57:25', 4),
(89, 3, '2023-11-12', '20:59:00', 1, 3, '2023-11-12', '20:58:15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `genre` varchar(250) NOT NULL,
  `industry` varchar(250) NOT NULL,
  `language` varchar(250) NOT NULL,
  `release_date` varchar(255) NOT NULL,
  `actor` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `first_date` date NOT NULL,
  `second_date` date NOT NULL,
  `third_date` date NOT NULL,
  `first_show` time NOT NULL,
  `second_show` time NOT NULL,
  `third_show` time NOT NULL,
  `movie_duration` varchar(255) NOT NULL,
  `movie_director` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`id`, `name`, `genre`, `industry`, `language`, `release_date`, `actor`, `description`, `price`, `image`, `first_date`, `second_date`, `third_date`, `first_show`, `second_show`, `third_show`, `movie_duration`, `movie_director`) VALUES
(3, 'bipins', '1', 'Bollywood', 'Hindi', '24/07/2023', 'heroes', '', 3, 'kgf.jpg', '2023-11-13', '2023-11-12', '2023-11-01', '20:59:00', '14:58:00', '14:58:00', '2hrs 34min 6sec', 'villians'),
(5, 'movie', 'mo', 'a', 'b', '2', 'uiouoiu', '', 200, 'kgf.jpg', '2023-11-13', '2023-11-14', '2023-11-15', '18:16:00', '17:17:00', '19:16:00', '2', 'a'),
(6, 'movies', 'mo', 'a', 'b', '2', 'uiouoiu', '', 200, '382443721_699011088945468_3018011469807826507_n.jpg', '2023-11-13', '2023-11-14', '2023-11-15', '18:16:00', '17:17:00', '19:16:00', '2', 'a'),
(7, 'kgf', 'action', 'bollywood', 'hindi', '2022/01/23', 'yash', '', 2000, 'kgf.jpg', '2023-11-13', '2023-11-14', '2023-11-15', '08:00:00', '12:00:00', '13:00:00', '2hrs 37min 27sec', 'hero'),
(8, 'movie', 'mo', 'a', 'b', 'oiuiu', 'jkljl', '', 200, '', '2023-11-13', '2023-11-20', '1970-01-01', '22:01:00', '22:01:00', '22:01:00', '2 hrs', 'hgf'),
(9, 'movie', 'mo', '', '', '', '', '', 0, '', '1970-01-01', '1970-01-01', '1970-01-01', '00:00:00', '00:00:00', '00:00:00', '', ''),
(10, 'movie', 'mo', 'a', 'b', '2', 'jkljl', '', 200, '', '1970-01-01', '1970-01-01', '1970-01-01', '00:00:00', '00:00:00', '00:00:00', '2', 'a'),
(11, 'fdsfsd', 'mo', 'a', 'b', '', '', '', 0, '', '1970-01-01', '1970-01-01', '1970-01-01', '00:00:00', '00:00:00', '00:00:00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `phone_no`) VALUES
(1, 'Bipin Sainju Shrestha', 'sainjubipin247460@gmail.com', '$2y$10$f/CZ0FAFyisV2yK7ucyjguzgFwqvwM1nmla7ECbNjC6T7FM6U/yqe', 0),
(4, 'bipin', 'sainjubipin24746@gmail.com', '$2y$10$c1eDbyNP3heO85FDqHvCROFsnhWuO2WwFQLklX8bMR2KMj0adC8dq', 0),
(5, 'bipin', 'sainjubipin2474@gmail.com', '$2y$10$.EEl1ZhTJoepZTXwFQ8HWezi8bHceumTJDaAeejE6zX93bDHu.VX.', 1234567890),
(6, 'bipin', 'sainjubipin2746@gmail.com', '$2y$10$IT0JeAOJ7QyOp4lAjchMTu.M3KVs5PEmASASsJK6pLHbe1rcNgmeK', 1234567890),
(7, 'bipin', 'sainjubipin24746@gmail.com', '$2y$10$/YnxBquA2152BkbB1tptku0ZcI3wssfc8DnHwBoB3wj0JNe2.YrhS', 1234567890),
(8, 'bipin', 'sainjubipin24746@gmail.com', '$2y$10$wbiCaphCgvV6NSto1lrl6OCOZ70BKJBRVQ6w4EThXWW/b5BKp9LHe', 1234567890);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
