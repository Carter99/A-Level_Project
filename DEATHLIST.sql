-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 19, 2017 at 12:57 PM
-- Server version: 5.7.20
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
-- Database: `DEATHLIST`
--

-- --------------------------------------------------------

DROP DATABASE DEATHLIST;
CREATE DATABASE DEATHLIST;

--
-- Table structure for table `Celebrities`
--

CREATE TABLE `Celebrities` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Wiki_Name` varchar(255) DEFAULT NULL,
  `dead` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Celebrities`
--

INSERT INTO `Celebrities` (`ID`, `Name`, `Wiki_Name`, `dead`) VALUES
(1, 'Slava Polunin', 'Slava_Polunin', 0),
(2, 'Elon Musk', 'Elon_Musk', 0),
(3, 'Donald Trump', 'Donald_Trump', 0),
(4, 'Stephen Hawking', 'Stephen_Hawking', 0),
(5, 'Kanye West', 'Kanye_West', 0),
(6, 'Jack Robinson (footballer, born 1993)', 'Jack_Robinson_(footballer,_born_1993)', 0),
(7, 'Theresa May', 'Theresa_May', 0),
(8, 'Carrie Fisher', 'Carrie_Fisher', 1),
(9, 'Keith Chegwin', 'Keith_Chegwin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Groups`
--

CREATE TABLE `Groups` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `CycleDuration` int(11) DEFAULT NULL,
  `CycleInput` double DEFAULT NULL,
  `LastDeath` int(11) DEFAULT NULL,
  `MaxSelect` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Groups`
--

INSERT INTO `Groups` (`ID`, `Name`, `CycleDuration`, `CycleInput`, `LastDeath`, `MaxSelect`) VALUES
(2, 'group2', 176400, 2, 1513346885, 5),
(17, 'test group', 86400, 0.5, 1513346885, 3),
(20, '42', 3628800, 0.42, 1513346885, 6),
(21, 'bobby', 345600, 0.52, 1513285700, 5),
(22, 'Rapid Fire', 21600, 0.1, 1511523443, 7),
(23, 'bello', 3628800, 3.14, 1513285700, 7);

-- --------------------------------------------------------

--
-- Table structure for table `Memberships`
--

CREATE TABLE `Memberships` (
  `GroupID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Memberships`
--

INSERT INTO `Memberships` (`GroupID`, `UserID`) VALUES
(17, 2),
(2, 5),
(2, 15),
(2, 1),
(17, 1),
(2, 18),
(20, 1),
(21, 17),
(2, 17),
(17, 17),
(20, 17),
(20, 19),
(17, 19),
(21, 1),
(17, 20),
(20, 20),
(22, 20),
(22, 1),
(17, 21),
(21, 22),
(22, 22),
(22, 21),
(21, 21),
(20, 21),
(2, 21),
(23, 21),
(23, 2),
(23, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Payouts`
--

CREATE TABLE `Payouts` (
  `GroupID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `PayTo` int(11) DEFAULT NULL,
  `CelebID` int(11) DEFAULT NULL,
  `UnixTime` int(11) DEFAULT NULL,
  `Amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Payouts`
--

INSERT INTO `Payouts` (`GroupID`, `UserID`, `PayTo`, `CelebID`, `UnixTime`, `Amount`) VALUES
(21, -1, 1, 9, 1513285700, 10.92),
(21, 17, 1, 9, 1513285700, -3.64),
(21, 22, 1, 9, 1513285700, -3.64),
(21, 21, 1, 9, 1513285700, -3.64),
(23, -1, 1, 9, 1513285700, 6.28),
(23, 21, 1, 9, 1513285700, -3.14),
(23, 2, 1, 9, 1513285700, -3.14),
(2, -1, 1, 8, 1513346885, 70),
(2, 5, 1, 8, 1513346885, -14),
(2, 15, 1, 8, 1513346885, -14),
(2, 18, 1, 8, 1513346885, -14),
(2, 17, 1, 8, 1513346885, -14),
(2, 21, 1, 8, 1513346885, -14),
(20, -1, 1, 8, 1513346885, 3.36),
(20, 17, 1, 8, 1513346885, -0.84),
(20, 19, 1, 8, 1513346885, -0.84),
(20, 20, 1, 8, 1513346885, -0.84),
(20, 21, 1, 8, 1513346885, -0.84),
(17, -1, 2, 8, 1513346885, 5),
(17, 1, 2, 8, 1513346885, -1),
(17, 17, 2, 8, 1513346885, -1),
(17, 19, 2, 8, 1513346885, -1),
(17, 20, 2, 8, 1513346885, -1),
(17, 21, 2, 8, 1513346885, -1);

-- --------------------------------------------------------

--
-- Table structure for table `Selection`
--

CREATE TABLE `Selection` (
  `GroupID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `CelebrityID` int(11) DEFAULT NULL,
  `UnixTime` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Selection`
--

INSERT INTO `Selection` (`GroupID`, `UserID`, `CelebrityID`, `UnixTime`) VALUES
(17, 2, 1, 1511796307),
(17, 1, 2, 1511981679),
(17, 1, 3, 1511991640),
(17, 2, 4, 1511995353),
(20, 19, 5, 1512036266),
(20, 19, 6, 1512036301),
(17, 1, 7, 1512058186),
(2, 1, 8, 1513012746),
(2, 1, 3, 1513030325),
(21, 1, 9, 1513188480),
(23, 1, 9, 1513188661),
(20, 1, 8, 1513188694),
(17, 2, 8, 1513188714);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `UNIXJoined` int(11) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(128) DEFAULT NULL,
  `Balance` double DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`ID`, `Name`, `UNIXJoined`, `Email`, `Password`, `Balance`) VALUES
(1, 'Connor Carter', 1508857454, 'connor@email.com', 'fe0d8456dd3f1a0f68cde11860c34bddce97dcbc20f389f534af8c4c49e225f6307ca16e414ac04c8d67b80821690edceb86f8de0d5286dd37ee562e3dcf2e80', 0),
(2, 'Generic User 2', 1508931456, '2@email.com', 'fe0d8456dd3f1a0f68cde11860c34bddce97dcbc20f389f534af8c4c49e225f6307ca16e414ac04c8d67b80821690edceb86f8de0d5286dd37ee562e3dcf2e80', 0),
(3, 'Daniel', 1509586935, 'daniel@testemail.com', 'fe0d8456dd3f1a0f68cde11860c34bddce97dcbc20f389f534af8c4c49e225f6307ca16e414ac04c8d67b80821690edceb86f8de0d5286dd37ee562e3dcf2e80', 0),
(4, 'IF YOU ARE SEEING THIS, THEN SOMETHING HAS SERIOUSLY GONE WRONG', 42, '42', '42', 0),
(15, 'bob', 1509625436, 'bob@email.com', 'fa585d89c851dd338a70dcf535aa2a92fee7836dd6aff1226583e88e0996293f16bc009c652826e0fc5c706695a03cddce372f139eff4d13959da6f1f5d3eabe', 0),
(16, 'tim', 1509722110, 'tim@email.com', '12b03226a6d8be9c6e8cd5e55dc6c7920caaa39df14aab92d5e3ea9340d1c8a4d3d0b8e4314f1f6ef131ba4bf1ceb9186ab87c801af0d5c95b1befb8cedae2b9', 0),
(17, 'bob ross', 1509927247, 'bobross@realbobross.org', '22a6bed8e97a377a3bf513b4d9213e98a9aad2c5618c561e046dbb360d7c7756aa75d8736264e74cb5fa6d5da05a63c029f4970c3032de97c1b94280d871a17d', 0),
(18, 'Charlie War', 1510137695, 'charlie@email.com', 'fec0504afe8461cfa88322520bf172c32154ab1e5eff94bb234bfc242def250829b4163dc7428916a49a94dc4bcbadad27b1bbbd236d0eb8fea9076024651383', 0),
(19, 'Jack Robinson', 1510586022, 'robinson.jack6973@gmail.com', 'fe0d8456dd3f1a0f68cde11860c34bddce97dcbc20f389f534af8c4c49e225f6307ca16e414ac04c8d67b80821690edceb86f8de0d5286dd37ee562e3dcf2e80', 0),
(20, 'HERE IS A TEST', 1511464611, 'TEST@TEST.com', '2e998a2c3f3bdfbc60653c2c4e046f7fe7e5a4b16bccb5bcc36d3fcb8b3e0d9b30a5e98951a976465f3897c6b224d0c7350b69670eb2ee511d90d4d65ffeaf3b', 0),
(21, 'SJ', 1511716764, 'SJ@email.com', 'fe0d8456dd3f1a0f68cde11860c34bddce97dcbc20f389f534af8c4c49e225f6307ca16e414ac04c8d67b80821690edceb86f8de0d5286dd37ee562e3dcf2e80', 0),
(22, 'AJC', 1511727650, 'Andy@email.com', '12b03226a6d8be9c6e8cd5e55dc6c7920caaa39df14aab92d5e3ea9340d1c8a4d3d0b8e4314f1f6ef131ba4bf1ceb9186ab87c801af0d5c95b1befb8cedae2b9', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Celebrities`
--
ALTER TABLE `Celebrities`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Groups`
--
ALTER TABLE `Groups`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Celebrities`
--
ALTER TABLE `Celebrities`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Groups`
--
ALTER TABLE `Groups`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
