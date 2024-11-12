-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2024 at 08:06 AM
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
(1, 'bipin', 'sainjubipin24746@gmail.com', '$2y$10$nBrneGxlFdotk.56Ca/MFeFsr1S63IY9pB8TBUJP8FlBZPXou4bge', 1234567890),
(2, 'admin', 'admin12@gmail.com', '$2y$10$zbaoaE2nX.aidHcxB9mZHeRv7Zi4X/C.qVUAamRSWa1ye9FZp5zCC', 1234567890);

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
  `user_id` int(11) NOT NULL,
  `paid` varchar(150) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `canceled` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `movie_id`, `show_date`, `show_time`, `seat_num`, `total_price`, `booking_date`, `booking_time`, `user_id`, `paid`, `image_path`, `canceled`) VALUES
(1, 7, '2024-01-07', '12:00:00', 1, 2500, '2024-01-06', '12:46:05', 4, '1', '6598fad165499_vice der zweite man.jpg', 0),
(2, 7, '2024-01-07', '12:00:00', 2, 2500, '2024-01-06', '12:46:05', 4, '1', '6598fad165499_vice der zweite man.jpg', 0),
(3, 7, '2024-01-07', '12:00:00', 7, 2500, '2024-01-06', '12:46:05', 4, '1', '6598fad165499_vice der zweite man.jpg', 0),
(4, 7, '2024-01-07', '12:00:00', 8, 2500, '2024-01-06', '12:46:05', 4, '1', '6598fad165499_vice der zweite man.jpg', 0),
(5, 7, '2024-01-07', '12:00:00', 12, 2500, '2024-01-06', '12:46:05', 4, '1', '6598fad165499_vice der zweite man.jpg', 0),
(6, 7, '2024-01-07', '12:00:00', 18, 1000, '2024-01-06', '12:47:55', 4, '1', '', 0),
(7, 7, '2024-01-07', '12:00:00', 22, 1000, '2024-01-06', '12:47:55', 4, '1', '', 0),
(8, 7, '2024-01-07', '12:00:00', 28, 500, '2024-01-06', '12:49:26', 4, '', '', 0),
(9, 7, '2024-01-07', '12:00:00', 14, 1000, '2024-01-06', '12:49:41', 4, '', '6598fb8e52046_LEGO movie.jpg', 0),
(10, 7, '2024-01-07', '12:00:00', 21, 1000, '2024-01-06', '12:49:41', 4, '', '6598fb8e52046_LEGO movie.jpg', 0),
(11, 7, '2024-01-07', '12:00:00', 6, 1500, '2024-01-06', '12:49:59', 4, '', '6598fba5ca7a6_Avengers EndGame.jpg', 0),
(12, 7, '2024-01-07', '12:00:00', 11, 1500, '2024-01-06', '12:49:59', 4, '', '6598fba5ca7a6_Avengers EndGame.jpg', 0),
(13, 7, '2024-01-07', '12:00:00', 16, 1500, '2024-01-06', '12:49:59', 4, '', '6598fba5ca7a6_Avengers EndGame.jpg', 0);

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
(1, 'ANTMAN', 'action', 'hollywood', 'english', '24/07/2022', 'antman', '', 0, 'antman.jpg', '2024-01-07', '2024-01-07', '0000-00-00', '00:00:00', '00:00:00', '00:00:00', '2hrs 34min 6sec', 'marvel'),
(2, 'AVENGERS', 'action', 'hollywood', 'english', '24/07/2023', 'avengers', '', 500, 'Avengers.jpg', '2024-01-07', '2024-01-07', '2024-01-07', '00:00:00', '00:00:00', '00:00:00', '2hrs 34min 6sec', 'marvel'),
(3, 'AVENGERS ENDGAME', 'action', 'hollywood', 'english', '24/07/2023', 'avengers', '', 500, 'Avengers EndGame.jpg', '2024-01-07', '2024-01-07', '2024-01-07', '10:00:00', '00:00:00', '00:00:00', '2hrs 34min 6sec', 'marvel'),
(4, 'AVENGERS INFINITY WAR', 'action', 'hollywood', 'english', '24/07/2023', 'avengers', '', 500, 'Avengers EndGame.jpg', '2024-01-07', '2024-01-07', '2024-01-07', '01:56:00', '00:00:00', '00:00:00', '2hrs 34min 6sec', 'marvel'),
(5, 'CAPTAIN MARVEL', 'action', 'hollywood', 'english', '24/07/2023', 'avengers', '', 500, 'Captain Marvel.jpg', '2024-01-07', '2024-01-07', '2024-01-07', '02:57:00', '00:00:00', '00:00:00', '2hrs 34min 6sec', 'marvel'),
(6, 'LEGO the Movie', 'action', 'hollywood', 'english', '24/07/2023', 'avengers', '', 500, 'LEGO movie.jpg', '2024-01-07', '2024-01-07', '2024-01-07', '23:58:00', '00:00:00', '00:00:00', '2hrs 34min 6sec', 'marvel'),
(7, 'The Vanishing', 'action', 'hollywood', 'english', '24/07/2023', 'avengers', '', 500, 'vanishing.jpg', '2024-01-07', '2024-01-07', '2024-01-07', '12:00:00', '00:00:00', '00:00:00', '2hrs 34min 6sec', 'marvel'),
(8, 'VICE DER ZWEITE MANN', 'action', 'hollywood', 'english', '24/07/2023', 'avengers', '', 500, 'vice der zweite man.jpg', '2024-01-07', '2024-01-07', '2024-01-07', '10:00:00', '00:00:00', '00:00:00', '2hrs 34min 6sec', 'marvel');

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
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
