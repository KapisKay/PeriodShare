-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2018 at 05:33 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skelee`
--

-- --------------------------------------------------------

--
-- Table structure for table `communities`
--

CREATE TABLE `communities` (
  `community_id` int(11) NOT NULL,
  `community_name` varchar(120) NOT NULL,
  `community_region` varchar(120) NOT NULL,
  `num_of_girls` int(12) NOT NULL,
  `community_contact_name` varchar(120) NOT NULL,
  `community_contact_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `communities`
--

INSERT INTO `communities` (`community_id`, `community_name`, `community_region`, `num_of_girls`, `community_contact_name`, `community_contact_number`) VALUES
(1, 'Goaso', 'Brong Ahafo Region', 64, 'Asare Benjamin', '0241212121'),
(2, 'Adowso', 'Eastern Region', 124, 'Jonas Adjei', '0261354232'),
(3, 'Keta', 'Volta Region', 231, 'Paul Dogbe', '05412321232');

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `donation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_name` varchar(200) NOT NULL,
  `item_quanity` varchar(200) NOT NULL,
  `community_id` int(11) NOT NULL,
  `status` varchar(120) NOT NULL DEFAULT 'Not Received',
  `date_donated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`donation_id`, `user_id`, `item_name`, `item_quanity`, `community_id`, `status`, `date_donated`) VALUES
(1, 2, 'Yazz Sanitary Pad', '12', 1, 'Not Received', '2018-10-31 14:51:56'),
(2, 2, 'Yazz Sanitary Pad', '12', 1, 'Not Received', '2018-10-31 14:52:20'),
(3, 2, 'Yazz Sanitary Pad', '12', 1, 'Not Received', '2018-10-31 14:52:25'),
(4, 2, 'Always', '10', 2, 'Not Received', '2018-10-31 15:05:08'),
(5, 2, 'Always', '4', 3, 'Not Received', '2018-10-31 15:05:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fullname` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(150) NOT NULL,
  `user_type` varchar(100) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `email`, `password`, `user_type`, `date_created`) VALUES
(1, 'Julius Asante', 'asante@gmail.com', '6eea9b7ef19179a06954edd0f6c05ceb', 'admin', '2018-10-30 10:53:05'),
(2, 'Mercy Asare', 'mercy@gmail.com', '6eea9b7ef19179a06954edd0f6c05ceb', 'donor', '2018-10-31 13:50:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `communities`
--
ALTER TABLE `communities`
  ADD PRIMARY KEY (`community_id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`donation_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `communities`
--
ALTER TABLE `communities`
  MODIFY `community_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
