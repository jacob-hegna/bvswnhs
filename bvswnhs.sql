-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 26, 2014 at 06:27 PM
-- Server version: 5.5.37
-- PHP Version: 5.4.4-14+deb7u9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bvswnhs`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `hours` varchar(2) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(180) NOT NULL DEFAULT 'The NHS administrators have not added a description for this event :(',
  `maxmembers` int(3) NOT NULL,
  `members` varchar(512) NOT NULL DEFAULT '[]',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `bvid` varchar(8) NOT NULL,
  `hours` int(11) NOT NULL,
  `rank` int(1) NOT NULL DEFAULT '0',
  `events` varchar(512) NOT NULL DEFAULT '[]',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `meetings` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `description` varchar(180) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `bvswnhs`.`members` (`id`, `name`, `email`, `phone`, `bvid`, `hours`, `rank`, `events`) VALUES (NULL, 'Root User', 'example@bluevalleyk12.net', '5555555555', '12345678', '0', '2', '[]');
INSERT INTO `bvswnhs`.`members` (`id`, `name`, `email`, `phone`, `bvid`, `hours`, `rank`, `events`) VALUES (NULL, 'Wes Caldwell', 'wcaldwell.email@gmail.com', '9137317023', '10033877', '0', '2', '[]');
INSERT INTO `bvswnhs`.`members` (`id`, `name`, `email`, `phone`, `bvid`, `hours`, `rank`, `events`) VALUES (NULL, 'Jacob Hegna', 'jacobhegna@gmail.com', '9139450706', '10055451', '0', '2', '[]');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
