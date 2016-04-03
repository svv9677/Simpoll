-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 03, 2016 at 07:17 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `westwood`
--

-- --------------------------------------------------------

--
-- Table structure for table `poll_data`
--

DROP TABLE IF EXISTS `poll_data`;
CREATE TABLE IF NOT EXISTS `poll_data` (
  `id` int(11) NOT NULL,
  `user_id` varchar(128) NOT NULL,
  `user_name` varchar(256) NOT NULL,
  `vote_time` datetime NOT NULL,
  `choice1` tinyint(4) NOT NULL,
  `choice2` tinyint(4) NOT NULL,
  `choice3` tinyint(4) NOT NULL,
  `choice4` tinyint(4) NOT NULL,
  `choice5` tinyint(4) NOT NULL,
  `choice6` tinyint(4) NOT NULL,
  `choice7` tinyint(4) NOT NULL,
  `choice8` tinyint(4) NOT NULL,
  `choice9` tinyint(4) NOT NULL,
  `choice10` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `poll_info`
--

DROP TABLE IF EXISTS `poll_info`;
CREATE TABLE IF NOT EXISTS `poll_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  `show_id` tinyint(4) NOT NULL,
  `show_vote` tinyint(4) NOT NULL,
  `select_multiple` tinyint(4) NOT NULL,
  `question` varchar(500) CHARACTER SET utf8 NOT NULL,
  `choice1` varchar(250) CHARACTER SET utf8 NOT NULL,
  `choice2` varchar(250) CHARACTER SET utf8 NOT NULL,
  `choice3` varchar(250) CHARACTER SET utf8 NOT NULL,
  `choice4` varchar(250) CHARACTER SET utf8 NOT NULL,
  `choice5` varchar(250) CHARACTER SET utf8 NOT NULL,
  `choice6` varchar(250) CHARACTER SET utf8 NOT NULL,
  `choice7` varchar(250) CHARACTER SET utf8 NOT NULL,
  `choice8` varchar(250) CHARACTER SET utf8 NOT NULL,
  `choice9` varchar(250) CHARACTER SET utf8 NOT NULL,
  `choice10` varchar(250) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
