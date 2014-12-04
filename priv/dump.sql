-- phpMyAdmin SQL Dump
-- version 4.0.10.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 01, 2014 at 05:45 PM
-- Server version: 5.5.24-55
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `klerik_popup_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `popup_app_data`
--

CREATE TABLE IF NOT EXISTS `popup_app_data` (
  `shop_domain` varchar(254) NOT NULL DEFAULT '',
  `access_token` varchar(32) NOT NULL,
  `title` text NOT NULL,
  `body` mediumtext NOT NULL,
  `installed_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`shop_domain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `popup_app_data`
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
