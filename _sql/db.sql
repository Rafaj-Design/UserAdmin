-- phpMyAdmin SQL Dump
-- version 4.2.0-dev
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jan 08, 2015 at 04:00 PM
-- Server version: 5.6.22
-- PHP Version: 5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fuertechef`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(80) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(40) NOT NULL,
  `lastlogin` datetime NOT NULL,
  `password_token` varchar(40) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`,`password`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `firstname`, `lastname`, `email`, `password`, `lastlogin`, `password_token`, `created`, `modified`) VALUES
(1, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(2, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(3, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(4, 'admin', 'Super', 'Admin 2', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(5, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(6, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(7, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(8, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(9, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(10, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(11, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(12, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(13, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(14, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(15, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(16, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(17, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(18, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(19, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(20, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(21, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(22, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(23, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(24, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(25, 'admin', 'Ondrej', 'Rafaj', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(26, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(27, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(28, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(29, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(30, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(31, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(32, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(33, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(34, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(35, 'admin', 'Katerina', 'Rafaj', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32'),
(36, 'admin', 'Super', 'Admin', 'admin@example.com', 'bbd17b1a5e347158034a2c910847ad097833a4b1', '2014-12-22 16:44:32', NULL, '2014-12-22 16:44:32', '2014-12-22 16:44:32');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(140) NOT NULL,
  `identifier` varchar(80) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `identifier` (`identifier`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `identifier`, `created`, `modified`) VALUES
(1, 'Admin Team', 'admin', '2014-12-22 16:42:38', '2014-12-22 16:42:38');

-- --------------------------------------------------------

--
-- Table structure for table `teams_accounts`
--

CREATE TABLE IF NOT EXISTS `teams_accounts` (
  `team_id` int(11) unsigned NOT NULL,
  `account_id` int(11) unsigned NOT NULL,
  KEY `team_id` (`team_id`,`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teams_accounts`
--

INSERT INTO `teams_accounts` (`team_id`, `account_id`) VALUES
(1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
