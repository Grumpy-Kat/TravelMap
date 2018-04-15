-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 16, 2017 at 07:24 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `travelmap`
--
CREATE DATABASE `travelmap` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `travelmap`;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `latitude` varchar(25) NOT NULL,
  `longitude` varchar(25) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `type` enum('want to visit','visited') DEFAULT 'want to visit',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;


INSERT INTO `locations` (`id`, `user`, `latitude`, `longitude`, `location`, `type`) VALUES
(1, 3, '40.6781784', '-73.9441579', 'Brooklyn, NY, USA', 'visited'),
(10, 3, '18.735693', '-70.162651', 'Dominican Republic', 'want to visit'),
(11, 3, '45.5016889', '-73.567256', 'Montreal, QC, Canada', 'want to visit'),
(18, 3, '48.856614', '2.3522219', 'Paris, France', 'want to visit'),
(19, 3, '40.7830603', '-73.9712488', 'Manhattan, New York, NY, USA', 'visited');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(41) NOT NULL,
  `name` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;


INSERT INTO `users` (`id`, `username`, `password`, `name`) VALUES
(1, 'ariela', '*B8EA509234E12B901BC27EA701B92FA8D01A2269', 'Ariela'),
(3, 'root', '*FBE80A32268CF1840523C19F1AEC4A3537A4E426', 'admin'),
(16, 'test', '*94BDCEBE19083CE2A1F959FD02F964C7AF4CFC29', 'test'),
(17, 'test2', '*7CEB3FDE5F7A9C4CE5FBE610D7D8EDA62EBE5F4E', 'test2');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
