-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 30, 2022 at 08:39 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wellness_is`
--

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `mrn` varchar(10) NOT NULL,
  `name` varchar(70) NOT NULL,
  `ic_passport` varchar(14) NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(320) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `sex` varchar(6) NOT NULL,
  `occupation` varchar(30) DEFAULT NULL,
  `race` varchar(20) NOT NULL,
  `religion` varchar(20) NOT NULL,
  `marital_status` varchar(10) NOT NULL,
  `next_of_kin` varchar(70) NOT NULL,
  `relationship` varchar(20) NOT NULL,
  `telephone_nok` varchar(15) NOT NULL,
  `smoker` varchar(10) DEFAULT NULL,
  `asthma` varchar(10) DEFAULT NULL,
  `diabetes` varchar(10) DEFAULT NULL,
  `heart_disease` varchar(10) DEFAULT NULL,
  `hypertension` varchar(10) DEFAULT NULL,
  `stroke` varchar(10) DEFAULT NULL,
  `cancer` varchar(10) DEFAULT NULL,
  `tuberculosis` varchar(10) DEFAULT NULL,
  `skin_disease` varchar(10) DEFAULT NULL,
  `kidneyp` varchar(10) DEFAULT NULL,
  `fits_psychiatric` varchar(10) DEFAULT NULL,
  `father_history` varchar(50) DEFAULT NULL,
  `mother_history` varchar(50) DEFAULT NULL,
  `siblings_history` varchar(50) DEFAULT NULL,
  `habits` varchar(50) DEFAULT NULL,
  `allergy` varchar(50) DEFAULT NULL,
  `others` varchar(60) DEFAULT NULL,
  `medication` varchar(100) DEFAULT NULL,
  `package` varchar(20) DEFAULT NULL,
  `lastUpdateMH` datetime DEFAULT NULL,
  `registeredOn` datetime DEFAULT NULL,
  `lastUpdateOn` datetime DEFAULT NULL,
  `addons` varchar(100) DEFAULT NULL,
  `pic` varchar(50) NOT NULL,
  `appearance` varchar(20) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `height` float DEFAULT NULL,
  `bmi` float DEFAULT NULL,
  `systolic` int(11) DEFAULT NULL,
  `diastolic` int(11) DEFAULT NULL,
  `pulse` int(11) DEFAULT NULL,
  `va_aidedr` varchar(10) DEFAULT NULL,
  `va_aidedl` varchar(10) DEFAULT NULL,
  `va_unaidedr` varchar(10) DEFAULT NULL,
  `va_unaidedl` varchar(10) DEFAULT NULL,
  `colour_r` varchar(10) DEFAULT NULL,
  `colour_l` varchar(10) DEFAULT NULL,
  `fundoscopy_r` varchar(10) DEFAULT NULL,
  `fundoscopy_l` varchar(10) DEFAULT NULL,
  `phyExam` datetime DEFAULT NULL,
  PRIMARY KEY (`mrn`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `record`
--

DROP TABLE IF EXISTS `record`;
CREATE TABLE IF NOT EXISTS `record` (
  `recordID` int(11) NOT NULL AUTO_INCREMENT,
  `mrn` varchar(10) NOT NULL,
  `smokerUsed` varchar(10) DEFAULT NULL,
  `asthmaUsed` varchar(10) DEFAULT NULL,
  `diabetesUsed` varchar(10) DEFAULT NULL,
  `heart_diseaseUsed` varchar(10) DEFAULT NULL,
  `hypertensionUsed` varchar(10) DEFAULT NULL,
  `strokeUsed` varchar(10) DEFAULT NULL,
  `cancerUsed` varchar(10) DEFAULT NULL,
  `tuberculosisUsed` varchar(10) DEFAULT NULL,
  `skin_diseaseUsed` varchar(10) DEFAULT NULL,
  `kidneypUsed` varchar(10) DEFAULT NULL,
  `fits_psychiatricUsed` varchar(10) DEFAULT NULL,
  `fatherUsed` varchar(50) DEFAULT NULL,
  `motherUsed` varchar(50) DEFAULT NULL,
  `siblingsUsed` varchar(50) DEFAULT NULL,
  `habitsUsed` varchar(50) DEFAULT NULL,
  `allergyUsed` varchar(50) DEFAULT NULL,
  `othersUsed` varchar(60) DEFAULT NULL,
  `medicationUsed` varchar(100) NOT NULL,
  `historyDate` datetime DEFAULT NULL,
  `appearanceUsed` varchar(20) DEFAULT NULL,
  `weightUsed` float DEFAULT NULL,
  `heightUsed` float DEFAULT NULL,
  `bmiUsed` float DEFAULT NULL,
  `systolicUsed` int(11) DEFAULT NULL,
  `diastolicUsed` int(11) DEFAULT NULL,
  `pulseUsed` int(11) DEFAULT NULL,
  `va_aidedrUsed` varchar(10) DEFAULT NULL,
  `va_aidedlUsed` varchar(10) DEFAULT NULL,
  `va_unaidedrUsed` varchar(10) DEFAULT NULL,
  `va_unaidedlUsed` varchar(10) DEFAULT NULL,
  `colour_rUsed` varchar(10) DEFAULT NULL,
  `colour_lUsed` varchar(10) DEFAULT NULL,
  `fundoscopy_rUsed` varchar(10) DEFAULT NULL,
  `fundoscopy_lUsed` varchar(10) DEFAULT NULL,
  `nose` varchar(10) DEFAULT NULL,
  `throat` varchar(10) DEFAULT NULL,
  `neck` varchar(10) DEFAULT NULL,
  `skin` varchar(10) DEFAULT NULL,
  `excanal_r` varchar(10) DEFAULT NULL,
  `excanal_l` varchar(10) DEFAULT NULL,
  `eardrum_r` varchar(10) DEFAULT NULL,
  `eardrum_l` varchar(10) DEFAULT NULL,
  `discharged_r` varchar(10) DEFAULT NULL,
  `discharged_l` varchar(10) DEFAULT NULL,
  `sound` varchar(20) DEFAULT NULL,
  `murmur` varchar(20) DEFAULT NULL,
  `airentry` varchar(10) DEFAULT NULL,
  `chestexp` varchar(10) DEFAULT NULL,
  `breathsound` varchar(10) DEFAULT NULL,
  `liver` varchar(15) DEFAULT NULL,
  `spleen` varchar(15) DEFAULT NULL,
  `kidney` varchar(15) DEFAULT NULL,
  `mentalfunct` varchar(10) DEFAULT NULL,
  `coordination` varchar(10) DEFAULT NULL,
  `gait` varchar(10) DEFAULT NULL,
  `genitalia` varchar(10) DEFAULT NULL,
  `rectal` varchar(10) DEFAULT NULL,
  `lpow_r` varchar(10) DEFAULT NULL,
  `lpow_l` varchar(10) DEFAULT NULL,
  `lref_r` varchar(10) DEFAULT NULL,
  `lref_l` varchar(10) DEFAULT NULL,
  `lsen_r` varchar(10) DEFAULT NULL,
  `lsen_l` varchar(10) DEFAULT NULL,
  `upow_r` varchar(10) DEFAULT NULL,
  `upow_l` varchar(10) DEFAULT NULL,
  `uref_r` varchar(10) DEFAULT NULL,
  `uref_l` varchar(10) DEFAULT NULL,
  `usen_r` varchar(10) DEFAULT NULL,
  `usen_l` varchar(10) DEFAULT NULL,
  `breast` varchar(30) DEFAULT NULL,
  `lmp` varchar(20) DEFAULT NULL,
  `gynaecology` varchar(20) DEFAULT NULL,
  `lastps` varchar(20) DEFAULT NULL,
  `cxr` varchar(50) DEFAULT NULL,
  `ecg` varchar(50) DEFAULT NULL,
  `mammogram` varchar(50) DEFAULT NULL,
  `us_breast` varchar(50) DEFAULT NULL,
  `us_abdopel` varchar(50) DEFAULT NULL,
  `stresstest` varchar(50) DEFAULT NULL,
  `pta` varchar(50) DEFAULT NULL,
  `lft` varchar(50) DEFAULT NULL,
  `urine` varchar(50) DEFAULT NULL,
  `blood` varchar(50) DEFAULT NULL,
  `impression` varchar(600) DEFAULT NULL,
  `recommendation` varchar(600) DEFAULT NULL,
  `lastUpdate` datetime DEFAULT NULL,
  `doneBy` varchar(40) DEFAULT NULL,
  `visits` int(11) NOT NULL DEFAULT '0',
  `packageUsed` varchar(20) DEFAULT NULL,
  `addonsUsed` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`recordID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password` varchar(30) NOT NULL,
  `name` varchar(60) NOT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `username`, `password`, `name`, `type`) VALUES
(1, 'admin', '@dm1n', 'admin', 'admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
