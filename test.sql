-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: localhost:3307
-- Generation Time: Aug 09, 2015 at 11:30 PM
-- Server version: 5.6.26-log
-- PHP Version: 5.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `system_id` int(11) NOT NULL COMMENT 'System ID',
  `id` int(11) DEFAULT NULL COMMENT 'File ID',
  `user_id` int(11) NOT NULL COMMENT 'User ID',
  `orig_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Original file name',
  `hash` varchar(255) NOT NULL COMMENT 'Hashed name',
  `size` int(11) NOT NULL DEFAULT '0' COMMENT 'File size',
  `current` tinyint(4) DEFAULT '1' COMMENT 'Actual row'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `files_view`
--
CREATE TABLE IF NOT EXISTS `files_view` (
`id` int(11)
,`user_id` int(11)
,`orig_name` varchar(255)
,`hash` varchar(255)
,`size` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `system_id` int(11) NOT NULL COMMENT 'Generated ID',
  `id` int(11) DEFAULT NULL COMMENT 'User ID',
  `login` varchar(100) NOT NULL DEFAULT '' COMMENT 'Login',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT 'Password',
  `salt` char(3) NOT NULL DEFAULT '',
  `first_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'First name',
  `last_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Last name',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT 'E-mail',
  `phone` varchar(100) NOT NULL DEFAULT '' COMMENT 'Phone',
  `birth_date` date DEFAULT NULL COMMENT 'Birthdate',
  `current` tinyint(1) DEFAULT '1' COMMENT 'Actual row'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `users_view`
--
CREATE TABLE IF NOT EXISTS `users_view` (
`id` int(11)
,`login` varchar(100)
,`password` varchar(50)
,`salt` char(3)
,`first_name` varchar(255)
,`last_name` varchar(255)
,`email` varchar(255)
,`phone` varchar(100)
,`birth_date` date
);

-- --------------------------------------------------------

--
-- Structure for view `files_view`
--
DROP TABLE IF EXISTS `files_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `files_view` AS select `files`.`id` AS `id`,`files`.`user_id` AS `user_id`,`files`.`orig_name` AS `orig_name`,`files`.`hash` AS `hash`,`files`.`size` AS `size` from `files` where (`files`.`current` = 1);

-- --------------------------------------------------------

--
-- Structure for view `users_view`
--
DROP TABLE IF EXISTS `users_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `users_view` AS select `users`.`id` AS `id`,`users`.`login` AS `login`,`users`.`password` AS `password`,`users`.`salt` AS `salt`,`users`.`first_name` AS `first_name`,`users`.`last_name` AS `last_name`,`users`.`email` AS `email`,`users`.`phone` AS `phone`,`users`.`birth_date` AS `birth_date` from `users` where (`users`.`current` = 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`system_id`),
  ADD UNIQUE KEY `id` (`id`,`current`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`system_id`),
  ADD UNIQUE KEY `login` (`login`,`current`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `system_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'System ID';
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `system_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Generated ID';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
