-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2016 at 04:49 AM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zoo`
--

-- --------------------------------------------------------

--
-- Table structure for table `animal`
--

CREATE TABLE IF NOT EXISTS `animal` (
  `animalID` int(11) NOT NULL AUTO_INCREMENT,
  `animalName` varchar(20) NOT NULL,
  `animalClassificationID` int(11) NOT NULL,
  `animalSpecies` varchar(20) NOT NULL,
  `animalBirthDate` date NOT NULL,
  `animalArrivalDate` date NOT NULL,
  `animalSex` char(1) NOT NULL,
  `animalPictureURL` text NOT NULL,
  `animalCreatedOn` datetime NOT NULL,
  `animalCreatedBy` int(11) NOT NULL,
  `animalUpdatedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `animalUpdatedBy` int(11) NOT NULL,
  PRIMARY KEY (`animalID`),
  KEY `animalClassificationID` (`animalClassificationID`),
  KEY `animalCreatedBy` (`animalCreatedBy`),
  KEY `animalUpdatedBy` (`animalUpdatedBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

--
-- Dumping data for table `animal`
--

INSERT INTO `animal` (`animalID`, `animalName`, `animalClassificationID`, `animalSpecies`, `animalBirthDate`, `animalArrivalDate`, `animalSex`, `animalPictureURL`, `animalCreatedOn`, `animalCreatedBy`, `animalUpdatedOn`, `animalUpdatedBy`) VALUES
(54, 'Bob', 47, 'King Penguin', '2016-04-04', '2016-04-14', 'M', 'http://i.imgur.com/b3XDYyZ.jpg', '2016-04-26 01:37:05', 1, '2016-04-26 01:37:05', 1),
(55, 'Sam', 47, 'Emperor Penguin', '2016-04-13', '2016-04-15', 'M', 'http://i.imgur.com/lxzTgH9.jpg', '2016-04-26 01:37:55', 1, '2016-04-26 01:37:55', 1),
(56, 'Mike', 47, 'Bald Eagle', '2016-04-04', '2016-04-19', 'M', 'http://i.imgur.com/jOFZcex.jpg', '2016-04-26 01:39:10', 1, '2016-04-26 03:03:14', 1),
(57, 'Joe', 47, 'Humming Bird', '2016-04-04', '2016-04-19', 'M', 'http://i.imgur.com/EGDE9T2.gif', '2016-04-26 01:39:50', 1, '2016-04-26 01:39:50', 1),
(58, 'Tom', 48, 'Hyena', '2016-04-05', '2016-04-07', 'F', 'https://45.media.tumblr.com/27c7de730541167a6bb2a03c29b5550c/tumblr_mzn4fdffwh1qh9dubo1_500.gif', '2016-04-26 01:41:18', 1, '2016-04-26 01:41:18', 1),
(59, 'Tim', 48, 'Tiger', '2016-04-03', '2016-04-13', 'F', 'http://media2.giphy.com/media/pmKeoRvDh0FZC/giphy.gif', '2016-04-26 01:42:50', 1, '2016-04-26 03:21:47', 1);

--
-- Triggers `animal`
--
DROP TRIGGER IF EXISTS `sum_class_delete`;
DELIMITER //
CREATE TRIGGER `sum_class_delete` AFTER DELETE ON `animal`
 FOR EACH ROW update classification set classificationSum = classificationSum - 1 WHERE classificationID = OLD.animalClassificationID
//
DELIMITER ;
DROP TRIGGER IF EXISTS `sum_class_insert`;
DELIMITER //
CREATE TRIGGER `sum_class_insert` AFTER INSERT ON `animal`
 FOR EACH ROW update classification set classificationSum = classificationSum + 1 WHERE classificationID = NEW.animalClassificationID
//
DELIMITER ;
DROP TRIGGER IF EXISTS `sum_class_update_after`;
DELIMITER //
CREATE TRIGGER `sum_class_update_after` AFTER UPDATE ON `animal`
 FOR EACH ROW update classification set classificationSum = classificationSum + 1 WHERE classificationID = NEW.animalClassificationID
//
DELIMITER ;
DROP TRIGGER IF EXISTS `sum_class_update_before`;
DELIMITER //
CREATE TRIGGER `sum_class_update_before` BEFORE UPDATE ON `animal`
 FOR EACH ROW update classification set classificationSum = classificationSum - 1 WHERE classificationID = OLD.animalClassificationID
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `animal_Del`
--

CREATE TABLE IF NOT EXISTS `animal_Del` (
  `animalID` int(11) NOT NULL,
  `animalName` varchar(20) NOT NULL,
  `animalClassificationID` int(11) NOT NULL,
  `animalSpecies` varchar(20) NOT NULL,
  `animalBirthDate` date NOT NULL,
  `animalArrivalDate` date NOT NULL,
  `animalSex` char(1) NOT NULL,
  `animalPictureURL` text NOT NULL,
  `animalDeletedOn` datetime NOT NULL,
  `animalDeletedBy` int(11) NOT NULL,
  PRIMARY KEY (`animalID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `classification`
--

CREATE TABLE IF NOT EXISTS `classification` (
  `classificationID` int(11) NOT NULL AUTO_INCREMENT,
  `classificationName` varchar(20) NOT NULL,
  `classificationAbout` text NOT NULL,
  `classificationSum` int(11) NOT NULL DEFAULT '0',
  `classificationCreatedOn` datetime NOT NULL,
  `classificationCreatedBy` int(11) NOT NULL,
  `classificationUpdatedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `classificationUpdatedBy` int(11) NOT NULL,
  PRIMARY KEY (`classificationID`),
  UNIQUE KEY `classificationName` (`classificationName`),
  KEY `classificationCreatedBy` (`classificationCreatedBy`),
  KEY `classificationUpdatedBy` (`classificationUpdatedBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `classification`
--

INSERT INTO `classification` (`classificationID`, `classificationName`, `classificationAbout`, `classificationSum`, `classificationCreatedOn`, `classificationCreatedBy`, `classificationUpdatedOn`, `classificationUpdatedBy`) VALUES
(47, 'Bird', 'Birds have an outer covering of feathers, are endothermic, have front limbs modified into wings, and lay eggs.', 4, '2016-04-25 07:46:42', 1, '2016-04-26 03:03:14', 1),
(48, 'Mammal', 'They all have either fur or hair.', 2, '2016-04-25 07:55:56', 1, '2016-04-26 03:21:47', 1),
(50, 'Reptile', 'Covered in scales.', 0, '2016-04-25 08:06:10', 1, '2016-04-26 00:33:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `classification_Del`
--

CREATE TABLE IF NOT EXISTS `classification_Del` (
  `classificationID` int(11) NOT NULL,
  `classificationName` varchar(20) NOT NULL,
  `classificationAbout` text NOT NULL,
  `classificationSum` int(11) NOT NULL DEFAULT '0',
  `classificationDeletedOn` datetime NOT NULL,
  `classificationDeletedBy` int(11) NOT NULL,
  PRIMARY KEY (`classificationID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classification_Del`
--

INSERT INTO `classification_Del` (`classificationID`, `classificationName`, `classificationAbout`, `classificationSum`, `classificationDeletedOn`, `classificationDeletedBy`) VALUES
(1, 'test', 'test', 1, '2016-04-25 07:41:29', 1),
(45, 'testt', 'ttt', 0, '2016-04-25 07:40:31', 1),
(46, 'asdf', 'asdf', 0, '2016-04-25 07:45:09', 1),
(49, 'ki', '(', 0, '2016-04-25 08:00:49', 1),
(51, 'sdf', 'sdf', 0, '2016-04-26 01:32:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `customerID` int(11) NOT NULL AUTO_INCREMENT,
  `customerAddress` varchar(30) NOT NULL,
  `customerCity` varchar(20) NOT NULL,
  `customerState` varchar(2) NOT NULL,
  `customerZipCode` int(11) NOT NULL,
  `customerLastName` varchar(20) NOT NULL,
  `customerFirstName` varchar(20) NOT NULL,
  `customerPhoneNumber` bigint(20) NOT NULL,
  `customerEmail` varchar(20) NOT NULL,
  `customerPassword` varchar(20) NOT NULL,
  `MembershipID` int(11) NOT NULL,
  `MembershipExp` date NOT NULL,
  `customerCreatedOn` date NOT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `customerLastUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `UpdatedBy` int(11) DEFAULT NULL,
  `UserTypeID` int(11) NOT NULL,
  PRIMARY KEY (`customerID`),
  UNIQUE KEY `Email` (`customerEmail`),
  KEY `CreatedBy` (`CreatedBy`),
  KEY `UpdatedBy` (`UpdatedBy`),
  KEY `MembershipId` (`MembershipID`),
  KEY `UserTypeID` (`UserTypeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerID`, `customerAddress`, `customerCity`, `customerState`, `customerZipCode`, `customerLastName`, `customerFirstName`, `customerPhoneNumber`, `customerEmail`, `customerPassword`, `MembershipID`, `MembershipExp`, `customerCreatedOn`, `CreatedBy`, `customerLastUpdated`, `UpdatedBy`, `UserTypeID`) VALUES
(0, '', '', '', 0, '', 'Visitor', 0, '', '', 0, '2025-06-30', '0000-00-00', 0, '2016-04-26 02:35:02', 0, 0),
(22, '', '', '', 77443, 'Smith', 'Carrol', 5555556666, 'rcsmith@zoo9.com', 'csmith123', 100, '0000-00-00', '2016-04-20', 1, '2016-04-25 04:00:44', 1, 1),
(26, '123 Main St', 'Houston', 'TX', 77080, 'Brooks', 'Larry', 0, 'customer@zoo9.com', 'Zoo9Customer', 100, '2016-04-25', '2016-04-25', 1, '0000-00-00 00:00:00', 1, 1),
(32, '314 Pi Street', 'Somewhere', 'MA', 0, 'Sim', 'Silver', 0, 'ssim@zoo9.com', 'silver', 102, '2016-05-11', '2016-04-26', 1, '2016-04-26 02:51:59', 1, 0),
(33, '777 Gold Rush Ave.', 'Sim City', 'AZ', 0, 'Gale', 'Gold', 0, 'gold@zoo9.com', 'gold', 103, '2016-06-22', '2016-04-26', 1, '2016-04-26 02:53:24', 1, 0),
(60, 'science', 'rules', 'tx', 77890, 'nye', 'bill', 1231231234, 'you@gmail.com', '123', 100, '2020-04-26', '2016-04-26', NULL, '2016-04-26 04:23:41', NULL, 0),
(62, 'science', 'rules', 'tx', 77890, 'nye', 'bill', 1231231234, 'youguy@gmail.com', '123', 100, '2020-04-26', '2016-04-26', NULL, '2016-04-26 04:27:02', NULL, 0),
(63, '111 test test', 'test', 'TX', 77479, 'test', 'register', 0, 'regtest@gmail.com', 'test', 102, '2020-04-26', '2016-04-26', NULL, '2016-04-26 04:29:23', NULL, 0),
(64, 'somewhere', 'houstin', 'tx', 77890, 'bob', 'billy', 12312312345, 'iop@gmail.com', '123', 100, '2020-04-26', '2016-04-26', NULL, '2016-04-26 04:41:40', NULL, 0),
(66, 'somewher', 'houstin', 'tx', 77892, 'smith', 'jake', 2342342345, 'youme@gmail.com', '123', 100, '2020-04-26', '2016-04-26', NULL, '2016-04-26 04:44:49', NULL, 1),
(67, '300 Star Labs Way', 'Central City', 'MO', 64101, 'Wells', 'Harrison', 8165551234, 'hwells@starlabs.com', 'deadforcenturies', 103, '2016-04-30', '2016-04-26', 1, '2016-04-26 04:45:30', 1, 1),
(69, 'somewhere', 'houston', 'tx', 77890, 'one', 'last', 1231231221, 'last@gmail.com', '123', 100, '2020-04-26', '2016-04-26', NULL, '2016-04-26 04:48:16', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_del`
--

CREATE TABLE IF NOT EXISTS `customer_del` (
  `customerID` int(11) NOT NULL AUTO_INCREMENT,
  `customerAddress` varchar(30) NOT NULL,
  `customerCity` varchar(20) NOT NULL,
  `customerState` varchar(2) NOT NULL,
  `customerZipCode` int(11) NOT NULL,
  `customerLastName` varchar(20) NOT NULL,
  `customerFirstName` varchar(20) NOT NULL,
  `customerPhoneNumber` int(11) NOT NULL,
  `customerEmail` varchar(20) NOT NULL,
  `MembershipID` int(11) NOT NULL,
  `DeletedBy` int(11) NOT NULL,
  `DeletedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `UserTypeID` int(11) NOT NULL,
  PRIMARY KEY (`customerID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `customer_del`
--

INSERT INTO `customer_del` (`customerID`, `customerAddress`, `customerCity`, `customerState`, `customerZipCode`, `customerLastName`, `customerFirstName`, `customerPhoneNumber`, `customerEmail`, `MembershipID`, `DeletedBy`, `DeletedOn`, `UserTypeID`) VALUES
(30, 'aerf', 'aerf', 'ae', 77890, 'aerf', 'aerf', 2147483647, 'aerf@gmail.com', 100, 0, '2016-04-26 02:18:22', 0),
(42, '300 Star Labs Way', 'Central City', 'MO', 64101, 'Wells', 'Harrison', 2147483647, 'hwells@starlabs.com', 103, 0, '2016-04-26 04:45:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `itemID` int(11) NOT NULL AUTO_INCREMENT,
  `itemDescription` varchar(25) NOT NULL,
  `itemTypeID` int(11) NOT NULL,
  `itemPrice` decimal(7,2) NOT NULL,
  `itemCreatedOn` datetime NOT NULL,
  `itemCreatedBy` int(11) NOT NULL,
  `itemUpdatedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `itemUpdatedBy` int(11) NOT NULL,
  PRIMARY KEY (`itemID`),
  KEY `itemTypeID` (`itemTypeID`),
  KEY `itemCreatedBy` (`itemCreatedBy`),
  KEY `itemUpdatedBy` (`itemUpdatedBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemID`, `itemDescription`, `itemTypeID`, `itemPrice`, `itemCreatedOn`, `itemCreatedBy`, `itemUpdatedOn`, `itemUpdatedBy`) VALUES
(13, 'Group Ticket', 7, '299.99', '2016-04-23 10:26:17', 1, '2016-04-25 23:44:10', 2),
(14, 'Senior Ticket', 7, '4.99', '2016-04-23 10:26:36', 1, '2016-04-23 10:26:36', 1),
(15, 'Sparkles the Unicorn', 8, '12.99', '2016-04-24 06:56:17', 1, '2016-04-24 06:56:17', 1),
(16, 'Angron the Destroyer', 8, '999.99', '2016-04-24 07:49:27', 1, '2016-04-24 07:49:27', 1),
(17, 'Fried Butter', 9, '0.99', '2016-04-25 02:31:05', 1, '2016-04-25 02:31:05', 1),
(18, 'Grilled Cheese', 9, '7.99', '2016-04-25 04:23:33', 1, '2016-04-25 04:23:33', 1),
(19, 'Adult Ticket', 7, '17.00', '2016-04-25 04:24:19', 1, '2016-04-25 04:24:19', 1),
(20, 'Child Ticket', 7, '13.00', '2016-04-25 04:24:43', 1, '2016-04-25 04:24:43', 1),
(21, 'Flappy Bird', 8, '19.99', '2016-04-25 04:26:14', 1, '2016-04-25 04:26:14', 1),
(22, 'Large Drink', 10, '4.99', '2016-04-25 04:32:12', 1, '2016-04-25 04:32:12', 1),
(23, 'Water Bottle', 10, '1.99', '2016-04-25 04:32:26', 1, '2016-04-25 04:32:26', 1),
(24, 'Beast Boy', 11, '4.99', '2016-04-25 04:33:15', 1, '2016-04-25 04:34:26', 1),
(25, 'Ocean Decor Name Mug', 12, '19.99', '2016-04-25 04:33:52', 1, '2016-04-25 04:33:52', 1),
(26, 'Stuffed Lion', 8, '7.99', '2016-04-25 04:35:14', 1, '2016-04-25 04:35:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `itemType`
--

CREATE TABLE IF NOT EXISTS `itemType` (
  `itemTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `itemTypeName` varchar(20) NOT NULL,
  `itemTypeCreatedOn` datetime NOT NULL,
  `itemTypeCreatedBy` int(11) NOT NULL,
  `itemTypeUpdatedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `itemTypeUpdatedBy` int(11) NOT NULL,
  PRIMARY KEY (`itemTypeID`),
  UNIQUE KEY `itemTypeName` (`itemTypeName`),
  KEY `itemTypeCreatedBy` (`itemTypeCreatedBy`),
  KEY `itemTypeUpdatedBy` (`itemTypeUpdatedBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `itemType`
--

INSERT INTO `itemType` (`itemTypeID`, `itemTypeName`, `itemTypeCreatedOn`, `itemTypeCreatedBy`, `itemTypeUpdatedOn`, `itemTypeUpdatedBy`) VALUES
(7, 'Ticket', '2016-04-23 08:46:23', 1, '2016-04-25 03:55:41', 1),
(8, 'Stuffed Animal', '2016-04-24 06:55:42', 1, '2016-04-25 04:31:22', 1),
(9, 'Food', '2016-04-25 02:30:48', 1, '2016-04-25 04:30:29', 1),
(10, 'Drink', '2016-04-25 04:30:22', 1, '2016-04-25 04:30:22', 1),
(11, 'Action Figure', '2016-04-25 04:30:54', 1, '2016-04-25 04:31:30', 1),
(12, 'Mug', '2016-04-25 04:31:02', 1, '2016-04-25 04:31:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `itemType_Del`
--

CREATE TABLE IF NOT EXISTS `itemType_Del` (
  `itemTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `itemTypeName` varchar(20) NOT NULL,
  `itemTypeDeletedOn` datetime NOT NULL,
  `itemTypeDeletedBy` int(11) NOT NULL,
  PRIMARY KEY (`itemTypeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `item_Del`
--

CREATE TABLE IF NOT EXISTS `item_Del` (
  `itemID` int(11) NOT NULL,
  `itemDescription` varchar(25) NOT NULL,
  `itemTypeID` int(11) NOT NULL,
  `itemPrice` decimal(7,2) NOT NULL,
  `itemDeletedOn` datetime NOT NULL,
  `itemDeletedBy` int(11) NOT NULL,
  PRIMARY KEY (`itemID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_Del`
--

INSERT INTO `item_Del` (`itemID`, `itemDescription`, `itemTypeID`, `itemPrice`, `itemDeletedOn`, `itemDeletedBy`) VALUES
(1, 'Ticket', 1, '29.99', '2016-04-10 04:24:44', 6),
(10, 'Test', 1, '12.99', '2016-04-10 11:07:59', 6),
(11, 'Stuffed Toy', 1, '14.99', '2016-04-11 03:34:25', 6),
(27, 'Test', 12, '0.01', '2016-04-25 06:09:12', 1),
(28, 'Taco', 9, '1.82', '2016-04-25 06:11:13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE IF NOT EXISTS `membership` (
  `membershipID` int(11) NOT NULL AUTO_INCREMENT,
  `membershipName` varchar(25) NOT NULL,
  `memberDiscount` decimal(10,2) NOT NULL,
  `CreatedOn` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastUpdatedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `LastUpdatedBy` int(11) NOT NULL,
  PRIMARY KEY (`membershipID`),
  UNIQUE KEY `MembershipName` (`membershipName`),
  KEY `CreatedBy` (`CreatedBy`),
  KEY `LastUpdatedBy` (`LastUpdatedBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=112 ;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`membershipID`, `membershipName`, `memberDiscount`, `CreatedOn`, `CreatedBy`, `LastUpdatedOn`, `LastUpdatedBy`) VALUES
(0, 'Visitor', '0.00', '2016-04-25 00:00:00', 0, '2016-04-26 02:34:02', 0),
(100, 'Bronze', '10.00', '2016-04-20 00:00:00', 1, '2016-04-25 04:04:16', 1),
(102, 'Silver', '15.00', '2016-04-23 01:56:29', 1, '2016-04-25 04:04:40', 1),
(103, 'Gold', '20.00', '2016-04-23 01:56:37', 1, '2016-04-25 04:04:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `membership_del`
--

CREATE TABLE IF NOT EXISTS `membership_del` (
  `membershipID` int(11) NOT NULL,
  `membershipName` varchar(25) NOT NULL,
  `memberDiscount` decimal(10,2) NOT NULL,
  `DeletedOn` datetime NOT NULL,
  `DeletedBy` int(11) NOT NULL,
  PRIMARY KEY (`membershipID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `membership_del`
--

INSERT INTO `membership_del` (`membershipID`, `membershipName`, `memberDiscount`, `DeletedOn`, `DeletedBy`) VALUES
(3, 'Cacti', '2.00', '2016-04-10 06:00:21', 6),
(12, 'Nonsequiter', '1.10', '2016-04-10 11:52:57', 6),
(14, 'Delete', '1.00', '2016-04-11 03:31:10', 6),
(15, 'Delete', '0.00', '2016-04-11 10:11:52', 6),
(100, 'Student', '5.00', '2016-04-23 12:44:53', 1),
(101, 'Test', '2.50', '2016-04-23 12:48:58', 1),
(104, 'Veterans', '15.00', '2016-04-23 03:38:59', 1),
(107, '', '10.00', '2016-04-25 09:25:23', 1),
(110, '', '1.00', '2016-04-25 09:46:13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Menu`
--

CREATE TABLE IF NOT EXISTS `Menu` (
  `menuPage` int(11) NOT NULL AUTO_INCREMENT,
  `menutext` varchar(30) NOT NULL,
  `menuLink` varchar(30) NOT NULL,
  `menuParent` int(11) NOT NULL,
  `menuSort` int(11) NOT NULL,
  `menuSecurity` int(11) NOT NULL,
  PRIMARY KEY (`menuPage`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `Menu`
--

INSERT INTO `Menu` (`menuPage`, `menutext`, `menuLink`, `menuParent`, `menuSort`, `menuSecurity`) VALUES
(1, 'Home', 'index.php', 0, 1, 0),
(2, 'Gallery', 'gallery.php', 0, 2, 0),
(3, 'Animal', 'Animal.php', 13, 1, 3),
(4, 'Classification', 'Classification.php', 13, 2, 3),
(5, 'Customer Search', 'customer.php', 14, 1, 3),
(6, 'Logout', 'logout.php?logout', 0, 9, -1),
(7, 'Item Search', 'itemSearch.php', 15, 1, 3),
(8, 'Item Type', 'itemTypeSearch.php', 15, 2, 3),
(9, 'Memberships', 'membership.php', 14, 2, 3),
(10, 'Totalizers', 'totalTypes.php', 16, 3, 3),
(13, 'Animal', '', 0, 2, 3),
(14, 'Customer', '', 0, 3, 3),
(15, 'Item', '', 0, 4, 4),
(16, 'Sales', '', 0, 5, 3),
(17, 'Sales Report', 'salesRpt.php', 16, 1, 3),
(18, 'Transactions', 'trsSearch.php', 16, 2, 3),
(19, 'Animal Report', 'AnimalReport.php', 13, 3, 3),
(20, 'Item Report', 'itemReport.php', 15, 3, 3),
(21, 'Member Report', 'membershipReport.php', 14, 3, 3),
(22, 'Login', 'login.php', 0, 999, 0),
(23, 'Gift Shop', 'ProductList.php', 0, 3, 0),
(24, 'View Cart', 'cart.php', 0, 6, 0),
(25, 'Events', 'events.php', 0, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Purchase_Details`
--

CREATE TABLE IF NOT EXISTS `Purchase_Details` (
  `TransactionID` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `ItemDesc` varchar(20) NOT NULL,
  `ItemQty` int(11) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `ItemBarcode` int(11) DEFAULT NULL,
  UNIQUE KEY `ItemBarcode` (`ItemBarcode`),
  KEY `TransactionID` (`TransactionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Purchase_Details`
--

INSERT INTO `Purchase_Details` (`TransactionID`, `ItemID`, `ItemDesc`, `ItemQty`, `Amount`, `ItemBarcode`) VALUES
(1, 14, 'tas', 2, '1.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Purchase_Hdr`
--

CREATE TABLE IF NOT EXISTS `Purchase_Hdr` (
  `TransactionID` int(11) NOT NULL AUTO_INCREMENT,
  `TransactionDate` date NOT NULL,
  `MemberID` int(11) DEFAULT NULL,
  PRIMARY KEY (`TransactionID`),
  KEY `MemberID` (`MemberID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `Purchase_Hdr`
--

INSERT INTO `Purchase_Hdr` (`TransactionID`, `TransactionDate`, `MemberID`) VALUES
(1, '2016-04-25', 22),
(2, '2016-01-01', 0),
(4, '2016-04-26', 0),
(5, '2016-04-26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Purchase_Totals`
--

CREATE TABLE IF NOT EXISTS `Purchase_Totals` (
  `TransactionID` int(11) NOT NULL,
  `TotalTypeID` int(11) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  KEY `TransactionID` (`TransactionID`),
  KEY `TotalTypeID` (`TotalTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Purchase_Totals`
--

INSERT INTO `Purchase_Totals` (`TransactionID`, `TotalTypeID`, `Amount`) VALUES
(1, 1, '1.08'),
(1, 2, '1.00'),
(1, 3, '0.08'),
(2, 1, '2.17'),
(2, 2, '2.00'),
(2, 3, '0.17');

-- --------------------------------------------------------

--
-- Table structure for table `Sales`
--

CREATE TABLE IF NOT EXISTS `Sales` (
  `Date` date NOT NULL,
  `TotalTypeID` int(11) NOT NULL,
  `TotalSales` decimal(10,2) NOT NULL,
  KEY `TotalTypeID` (`TotalTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Sales`
--

INSERT INTO `Sales` (`Date`, `TotalTypeID`, `TotalSales`) VALUES
('2016-04-01', 1, '369.99'),
('2016-04-01', 2, '360.00'),
('2016-04-01', 3, '9.99'),
('2016-04-24', 1, '248.98'),
('2016-04-24', 2, '230.96'),
('2016-04-24', 3, '18.02');

-- --------------------------------------------------------

--
-- Table structure for table `Staff`
--

CREATE TABLE IF NOT EXISTS `Staff` (
  `staffID` int(11) NOT NULL AUTO_INCREMENT,
  `staffrLastName` varchar(20) NOT NULL,
  `staffFirstName` varchar(20) NOT NULL,
  `staffEmail` varchar(20) NOT NULL,
  `staffPassword` varchar(20) NOT NULL,
  `staffCreatedOn` date NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `staffrLastUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `UpdatedBy` int(11) NOT NULL,
  `LastLogin` date NOT NULL,
  `UserTypeID` int(11) NOT NULL,
  PRIMARY KEY (`staffID`),
  UNIQUE KEY `Email` (`staffEmail`),
  KEY `CreatedBy` (`CreatedBy`),
  KEY `UpdatedBy` (`UpdatedBy`),
  KEY `UserTypeID` (`UserTypeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `Staff`
--

INSERT INTO `Staff` (`staffID`, `staffrLastName`, `staffFirstName`, `staffEmail`, `staffPassword`, `staffCreatedOn`, `CreatedBy`, `staffrLastUpdated`, `UpdatedBy`, `LastLogin`, `UserTypeID`) VALUES
(0, '', 'Public', '', '', '2016-04-25', 0, '2016-04-25 14:46:35', 0, '0000-00-00', 0),
(1, 'Smith', 'Jonh', 'jons@zoo9.com', 'jsmith123', '2016-04-20', 0, '0000-00-00 00:00:00', 0, '0000-00-00', 6),
(2, 'Salgado', 'Jhovani', 'jhovani@zoo9.com', 'J123456', '2016-04-22', 0, '2016-04-25 22:46:07', 0, '0000-00-00', 6),
(5, 'admin', 'admin', 'admin@zoo9.com', 'Zoo9', '2016-04-25', 0, '0000-00-00 00:00:00', 0, '2016-04-25', 6);

-- --------------------------------------------------------

--
-- Table structure for table `Totals_Type`
--

CREATE TABLE IF NOT EXISTS `Totals_Type` (
  `TotalTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `TotalTypeName` varchar(30) NOT NULL,
  `CreatedOn` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `UpdateOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `UpdateBy` int(11) NOT NULL,
  PRIMARY KEY (`TotalTypeID`),
  UNIQUE KEY `TotalTypeName` (`TotalTypeName`),
  KEY `CreatedBy` (`CreatedBy`),
  KEY `UpdateBy` (`UpdateBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `Totals_Type`
--

INSERT INTO `Totals_Type` (`TotalTypeID`, `TotalTypeName`, `CreatedOn`, `CreatedBy`, `UpdateOn`, `UpdateBy`) VALUES
(1, 'TOTAL SALES', '2016-04-24 00:00:00', 2, '0000-00-00 00:00:00', 2),
(2, 'Net Sales', '2016-04-24 00:00:00', 1, '0000-00-00 00:00:00', 1),
(3, 'Tax 1', '2016-04-24 00:00:00', 2, '2016-04-25 04:24:11', 2),
(4, 'Discounts', '2016-04-25 08:27:48', 2, '2016-04-25 20:28:06', 2);

-- --------------------------------------------------------

--
-- Table structure for table `Totals_Type_Del`
--

CREATE TABLE IF NOT EXISTS `Totals_Type_Del` (
  `TotalTypeID` int(11) NOT NULL,
  `TotalTypeName` varchar(30) NOT NULL,
  `DeletedOn` datetime NOT NULL,
  `DeletedBy` int(11) NOT NULL,
  PRIMARY KEY (`TotalTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Totals_Type_Del`
--

INSERT INTO `Totals_Type_Del` (`TotalTypeID`, `TotalTypeName`, `DeletedOn`, `DeletedBy`) VALUES
(27, '', '2016-04-10 07:07:02', 6),
(29, 'jkl', '2016-04-11 09:21:19', 6),
(30, 'are', '2016-04-11 05:46:29', 6),
(32, 'Test', '2016-04-11 09:21:22', 6);

-- --------------------------------------------------------

--
-- Table structure for table `WebUserType`
--

CREATE TABLE IF NOT EXISTS `WebUserType` (
  `UserTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `UserTypeDescription` varchar(20) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` date NOT NULL,
  `UpdateBy` int(11) NOT NULL,
  `UpdateOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`UserTypeID`),
  UNIQUE KEY `UserTypeDescription` (`UserTypeDescription`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `WebUserType`
--

INSERT INTO `WebUserType` (`UserTypeID`, `UserTypeDescription`, `CreatedBy`, `CreatedOn`, `UpdateBy`, `UpdateOn`) VALUES
(0, 'Public', 1, '2016-04-25', 1, '2016-04-25 14:45:41'),
(1, 'Customer', 1, '2016-04-20', 1, '0000-00-00 00:00:00'),
(6, 'Administrator', 1, '2016-04-20', 1, '0000-00-00 00:00:00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `animal`
--
ALTER TABLE `animal`
  ADD CONSTRAINT `animal_ibfk_1` FOREIGN KEY (`animalClassificationID`) REFERENCES `classification` (`classificationID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `animal_ibfk_2` FOREIGN KEY (`animalCreatedBy`) REFERENCES `Staff` (`staffID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `animal_ibfk_3` FOREIGN KEY (`animalUpdatedBy`) REFERENCES `Staff` (`staffID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `classification`
--
ALTER TABLE `classification`
  ADD CONSTRAINT `classification_ibfk_1` FOREIGN KEY (`classificationCreatedBy`) REFERENCES `Staff` (`staffID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `classification_ibfk_2` FOREIGN KEY (`classificationUpdatedBy`) REFERENCES `Staff` (`staffID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`MembershipId`) REFERENCES `membership` (`MembershipID`),
  ADD CONSTRAINT `customer_ibfk_2` FOREIGN KEY (`MembershipID`) REFERENCES `membership` (`membershipID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `customer_ibfk_3` FOREIGN KEY (`CreatedBy`) REFERENCES `Staff` (`staffID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `customer_ibfk_4` FOREIGN KEY (`UpdatedBy`) REFERENCES `Staff` (`staffID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `customer_ibfk_5` FOREIGN KEY (`UserTypeID`) REFERENCES `WebUserType` (`UserTypeID`) ON UPDATE CASCADE;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_3` FOREIGN KEY (`itemUpdatedBy`) REFERENCES `Staff` (`staffID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`itemTypeID`) REFERENCES `itemType` (`itemTypeID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`itemCreatedBy`) REFERENCES `Staff` (`staffID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `itemType`
--
ALTER TABLE `itemType`
  ADD CONSTRAINT `itemType_ibfk_2` FOREIGN KEY (`itemTypeUpdatedBy`) REFERENCES `Staff` (`staffID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `itemType_ibfk_1` FOREIGN KEY (`itemTypeCreatedBy`) REFERENCES `Staff` (`staffID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `membership`
--
ALTER TABLE `membership`
  ADD CONSTRAINT `membership_ibfk_2` FOREIGN KEY (`LastUpdatedBy`) REFERENCES `Staff` (`staffID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `membership_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `Staff` (`staffID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `Purchase_Details`
--
ALTER TABLE `Purchase_Details`
  ADD CONSTRAINT `Purchase_Details_ibfk_1` FOREIGN KEY (`TransactionID`) REFERENCES `Purchase_Hdr` (`TransactionID`) ON UPDATE CASCADE;

--
-- Constraints for table `Purchase_Hdr`
--
ALTER TABLE `Purchase_Hdr`
  ADD CONSTRAINT `Purchase_Hdr_ibfk_1` FOREIGN KEY (`MemberID`) REFERENCES `customer` (`customerID`) ON UPDATE CASCADE;

--
-- Constraints for table `Purchase_Totals`
--
ALTER TABLE `Purchase_Totals`
  ADD CONSTRAINT `Purchase_Totals_ibfk_1` FOREIGN KEY (`TransactionID`) REFERENCES `Purchase_Hdr` (`TransactionID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Purchase_Totals_ibfk_2` FOREIGN KEY (`TotalTypeID`) REFERENCES `Totals_Type` (`TotalTypeID`) ON UPDATE CASCADE;

--
-- Constraints for table `Sales`
--
ALTER TABLE `Sales`
  ADD CONSTRAINT `Sales_ibfk_1` FOREIGN KEY (`TotalTypeID`) REFERENCES `Totals_Type` (`TotalTypeID`) ON UPDATE CASCADE;

--
-- Constraints for table `Staff`
--
ALTER TABLE `Staff`
  ADD CONSTRAINT `Staff_ibfk_1` FOREIGN KEY (`UserTypeID`) REFERENCES `WebUserType` (`UserTypeID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `Totals_Type`
--
ALTER TABLE `Totals_Type`
  ADD CONSTRAINT `Totals_Type_ibfk_1` FOREIGN KEY (`CreatedBy`) REFERENCES `Staff` (`staffID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `Totals_Type_ibfk_2` FOREIGN KEY (`UpdateBy`) REFERENCES `Staff` (`staffID`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
