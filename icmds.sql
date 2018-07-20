-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2018 at 02:01 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `icmds`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `token` text NOT NULL,
  `designation` varchar(20) NOT NULL DEFAULT 'sub_admin'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `token`, `designation`) VALUES
(1, 'Shouvik Mohanta', 'shouvik@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `cevent`
--

CREATE TABLE `cevent` (
  `id` int(11) NOT NULL,
  `event_id` text NOT NULL,
  `event_name` text NOT NULL,
  `event_description` text NOT NULL,
  `event_venue` text NOT NULL,
  `start_time` text NOT NULL,
  `end_time` text NOT NULL,
  `cover` varchar(100) NOT NULL DEFAULT 'cover.png',
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cevent`
--

INSERT INTO `cevent` (`id`, `event_id`, `event_name`, `event_description`, `event_venue`, `start_time`, `end_time`, `cover`, `active`) VALUES
(1, '2018040001', 'Com Event 1', 'Desc', 'Com Venue 1', 'Wednesday 04 April 2018 - 11:11', 'Thursday 05 April 2018 - 11:11', '1525505541.jpeg', 1),
(2, '2018040002', 'Com Event 2', 'Desc', 'Com Venue 2', 'Wednesday 04 April 2018 - 12:12', 'Friday 13 April 2018 - 12:12', 'cover.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ceventdocs`
--

CREATE TABLE `ceventdocs` (
  `id` int(11) NOT NULL,
  `event_id` text NOT NULL,
  `docs` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ceventdocs`
--

INSERT INTO `ceventdocs` (`id`, `event_id`, `docs`) VALUES
(5, '2018040001', '15255055911.jpeg'),
(7, '2018040001', '15255055913.jpeg'),
(8, '2018040001', '15255055914.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `event_id` text NOT NULL,
  `event_name` text NOT NULL,
  `event_description` text NOT NULL,
  `event_venue` text NOT NULL,
  `start_time` text NOT NULL,
  `end_time` text NOT NULL,
  `day` text NOT NULL,
  `month` text NOT NULL,
  `year` text NOT NULL,
  `discount` text,
  `document_id` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `cover` varchar(100) NOT NULL DEFAULT 'cover.png',
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `event_id`, `event_name`, `event_description`, `event_venue`, `start_time`, `end_time`, `day`, `month`, `year`, `discount`, `document_id`, `status`, `cover`, `active`) VALUES
(1, '201804000001', 'Event 1', 'Desc 1', 'Venue 1', 'Wednesday 01 April 2018 - 15:49', 'Friday 06 April 2018 - 15:49', '04', 'April', '2018', '', '', 1, 'cover.png', 1),
(2, '201804000002', 'Event 1', 'Desc 1', 'Venue 1', 'Tuesday 03 April 2018 - 17:32', 'Thursday 05 April 2018 - 17:32', '03', 'April', '2018', '0', '', 0, 'cover.png', 1),
(3, '201804000003', 'Event 2', 'Desc 2', 'Venue 2', 'Wednesday 04 April 2018 - 17:33', 'Thursday 05 April 2018 - 17:33', '04', 'April', '2018', '', '', 1, 'cover.png', 1),
(4, '201804000004', 'Test Event', 'Test Desc', 'Test Venue', 'Thursday 05 April 2018 - 15:05', 'Friday 06 April 2018 - 15:05', '05', 'April', '2018', '10', '', 1, '1522834570.png', 1),
(5, '201805000001', 'New Event', 'Event DESC', 'Event Venue', 'Thursday 10 May 2018 - 12:35', 'Friday 11 May 2018 - 10:00', '10', 'May', '2018', '10', '', 1, '1525505145.jpeg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `eventdocs`
--

CREATE TABLE `eventdocs` (
  `id` int(11) NOT NULL,
  `document_id` text NOT NULL,
  `event_id` text NOT NULL,
  `docs` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eventdocs`
--

INSERT INTO `eventdocs` (`id`, `document_id`, `event_id`, `docs`) VALUES
(1, '', '201804000001', '15255057451.jpeg'),
(2, '', '201804000001', '15255057452.jpeg'),
(3, '', '201804000001', '15255057453.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `event_ticket_category_map`
--

CREATE TABLE `event_ticket_category_map` (
  `id` int(11) NOT NULL,
  `event_id` text NOT NULL,
  `category` text NOT NULL,
  `seat` text NOT NULL,
  `price` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_ticket_category_map`
--

INSERT INTO `event_ticket_category_map` (`id`, `event_id`, `category`, `seat`, `price`) VALUES
(2, '20180400003', 'Cat 1', '0', '300'),
(3, '201804000004', 'Test Cat', '20', '300'),
(4, '201805000001', 'General Category', '530', '30');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `user_id` text NOT NULL,
  `membership_id` text NOT NULL,
  `level` text NOT NULL,
  `start_date` text NOT NULL,
  `end_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role_id` text NOT NULL,
  `role_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `ticket_id` text NOT NULL,
  `event_id` text NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `ticket_price` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_category_map`
--

CREATE TABLE `ticket_category_map` (
  `id` int(11) NOT NULL,
  `ticket_id` text NOT NULL,
  `event_id` text NOT NULL,
  `category` text NOT NULL,
  `seat` text NOT NULL,
  `price` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `timedate` text NOT NULL,
  `amount` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` text NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `role_id` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cevent`
--
ALTER TABLE `cevent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ceventdocs`
--
ALTER TABLE `ceventdocs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eventdocs`
--
ALTER TABLE `eventdocs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_ticket_category_map`
--
ALTER TABLE `event_ticket_category_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_category_map`
--
ALTER TABLE `ticket_category_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
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
-- AUTO_INCREMENT for table `cevent`
--
ALTER TABLE `cevent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ceventdocs`
--
ALTER TABLE `ceventdocs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `eventdocs`
--
ALTER TABLE `eventdocs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `event_ticket_category_map`
--
ALTER TABLE `event_ticket_category_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_category_map`
--
ALTER TABLE `ticket_category_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
