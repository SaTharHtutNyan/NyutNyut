-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2018 at 12:21 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emnk_clinicms`
--

-- --------------------------------------------------------

--
-- Table structure for table `activeingredient`
--

CREATE TABLE IF NOT EXISTS `activeingredient` (
  `AIID` varchar(50) NOT NULL,
  `ActiveIngredientName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activeingredient`
--

INSERT INTO `activeingredient` (`AIID`, `ActiveIngredientName`) VALUES
('AI-000001', 'Anti-Virus');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE IF NOT EXISTS `appointment` (
  `TokenNo` varchar(50) NOT NULL,
  `AppointmentDate` varchar(100) NOT NULL,
  `PatientID` varchar(100) NOT NULL,
  `TokenDate` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`TokenNo`, `AppointmentDate`, `PatientID`, `TokenDate`) VALUES
('T-001', '', 'P-000001', '2018-07-21'),
('T-002', '', 'P-000001', '2018-07-21'),
('T-003', '2018-07-24', 'P-000004', '2018-07-21');

-- --------------------------------------------------------

--
-- Table structure for table `dosageform`
--

CREATE TABLE IF NOT EXISTS `dosageform` (
  `DFID` varchar(50) NOT NULL,
  `DosageFormName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dosageform`
--

INSERT INTO `dosageform` (`DFID`, `DosageFormName`) VALUES
('D-000001', 'Paracetamol');

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE IF NOT EXISTS `medicine` (
  `MedicineID` varchar(100) NOT NULL,
  `MedicineName` varchar(100) NOT NULL,
  `Price` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `DFID` varchar(50) NOT NULL,
  `AIID` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`MedicineID`, `MedicineName`, `Price`, `Quantity`, `DFID`, `AIID`) VALUES
('M-000001', 'Biogesic', 3000, 80, 'D-000001', 'AI-000001'),
('M-000002', 'D ko gin', 3000, 80, 'D-000002', 'AI-000001');

-- --------------------------------------------------------

--
-- Table structure for table `medicineusage`
--

CREATE TABLE IF NOT EXISTS `medicineusage` (
  `TreatmentID` varchar(50) NOT NULL,
  `MedicineID` varchar(50) NOT NULL,
  `Quantity` int(50) NOT NULL,
  `Price` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medicineusage`
--

INSERT INTO `medicineusage` (`TreatmentID`, `MedicineID`, `Quantity`, `Price`) VALUES
('T-000001', 'M-000001', 10, 400),
('T-000001', 'M-000002', 10, 300);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `PatientID` varchar(50) NOT NULL,
  `PatientName` varchar(100) NOT NULL,
  `Age` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `FatherName` varchar(100) NOT NULL,
  `RegDate` varchar(100) NOT NULL,
  `PhoneNumber` varchar(100) NOT NULL,
  `DOB` varchar(50) NOT NULL,
  `Gender` varchar(50) NOT NULL,
  `BloodType` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`PatientID`, `PatientName`, `Age`, `Address`, `FatherName`, `RegDate`, `PhoneNumber`, `DOB`, `Gender`, `BloodType`) VALUES
('P-000001', 'Htun Htun', '18', 'YGN', 'Aung Tun', '2018-07-21', '0991652494', '1997-07-21', 'Male', 'A'),
('P-000003', 'Thuta', '17', 'YGN', 'Aung Tun', '2018-07-21', '0991652494', '964130400', 'Male', 'O'),
('P-000004', 'Zwe', '18', 'YGN', 'Aung Tun', '2018-07-21', '09876545676', '964044000', 'Female', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE IF NOT EXISTS `purchase` (
  `PurchaseID` varchar(50) NOT NULL,
  `PurchaseDate` varchar(100) NOT NULL,
  `SupplierID` int(50) NOT NULL,
  `TotalAmount` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`PurchaseID`, `PurchaseDate`, `SupplierID`, `TotalAmount`) VALUES
('Pu_000001', '2018-07-21', 2, 464000);

-- --------------------------------------------------------

--
-- Table structure for table `purchasedetails`
--

CREATE TABLE IF NOT EXISTS `purchasedetails` (
  `PurchaseID` varchar(50) NOT NULL,
  `Quantity` int(50) NOT NULL,
  `Amount` int(50) NOT NULL,
  `ExpireDate` varchar(100) NOT NULL,
  `ProductID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchasedetails`
--

INSERT INTO `purchasedetails` (`PurchaseID`, `Quantity`, `Amount`, `ExpireDate`, `ProductID`) VALUES
('Pu_000003', 116, 4000, '2020-07-31', 'M-000002');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `StaffID` varchar(50) NOT NULL,
  `StaffName` varchar(100) NOT NULL,
  `StaffAge` varchar(50) NOT NULL,
  `StaffPhoneNo` varchar(100) NOT NULL,
  `Salary` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `RegDate` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `SupplierID` int(11) NOT NULL,
  `SupplierName` varchar(100) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `PhoneNo` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`SupplierID`, `SupplierName`, `Address`, `PhoneNo`) VALUES
(1, 'Mahar', 'YGN', '0912345623'),
(2, 'YarMa', 'YGN', '0992345623');

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

CREATE TABLE IF NOT EXISTS `treatment` (
  `TreatmentID` varchar(50) NOT NULL,
  `TokenNo` varchar(50) NOT NULL,
  `Charges` int(50) NOT NULL,
  `TreatmentDate` varchar(50) NOT NULL,
  `TotalAmount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `treatment`
--

INSERT INTO `treatment` (`TreatmentID`, `TokenNo`, `Charges`, `TreatmentDate`, `TotalAmount`) VALUES
('T-000001', 'T-003', 5000, '2018-07-21', 5700),
('T-000001', 'T-003', 5000, '2018-07-21', 5000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SupplierID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `SupplierID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
