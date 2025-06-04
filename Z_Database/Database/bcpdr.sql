-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2025 at 05:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bcpdr`
--

-- --------------------------------------------------------

--
-- Table structure for table `asset_class`
--

CREATE TABLE `asset_class` (
  `id` int(11) NOT NULL,
  `asset_class_code` varchar(10) NOT NULL,
  `asset_class_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asset_class`
--

INSERT INTO `asset_class` (`id`, `asset_class_code`, `asset_class_name`) VALUES
(2, '1', 'gear');

-- --------------------------------------------------------

--
-- Table structure for table `asset_master`
--

CREATE TABLE `asset_master` (
  `id` int(11) NOT NULL,
  `asset_id_code` varchar(10) NOT NULL,
  `asset_class_code` varchar(10) NOT NULL,
  `is_new_old` enum('New','Old') NOT NULL,
  `purchase_date` date NOT NULL,
  `invoice_no` varchar(20) NOT NULL,
  `vendor_code` varchar(10) NOT NULL,
  `location_code` varchar(10) NOT NULL,
  `department_code` varchar(10) NOT NULL,
  `asset_owner` varchar(10) NOT NULL,
  `asset_value` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asset_master`
--

INSERT INTO `asset_master` (`id`, `asset_id_code`, `asset_class_code`, `is_new_old`, `purchase_date`, `invoice_no`, `vendor_code`, `location_code`, `department_code`, `asset_owner`, `asset_value`) VALUES
(4, '1', '1', 'New', '2025-05-24', '1', '1', '1', '11', 'arvind', 5000.00);

-- --------------------------------------------------------

--
-- Table structure for table `audit_report`
--

CREATE TABLE `audit_report` (
  `id` int(11) NOT NULL,
  `audit_no` varchar(20) NOT NULL,
  `report_no` varchar(20) NOT NULL,
  `department_code` varchar(20) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `auditor_employee_code` varchar(20) NOT NULL,
  `auditor_employee_name` varchar(100) NOT NULL,
  `auditee_employee_code` varchar(20) NOT NULL,
  `auditee_employee_name` varchar(100) NOT NULL,
  `std_doc_ref` varchar(50) DEFAULT NULL,
  `problems_identified` text NOT NULL,
  `proposed_action` text NOT NULL,
  `target_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_report`
--

INSERT INTO `audit_report` (`id`, `audit_no`, `report_no`, `department_code`, `department_name`, `auditor_employee_code`, `auditor_employee_name`, `auditee_employee_code`, `auditee_employee_name`, `std_doc_ref`, `problems_identified`, `proposed_action`, `target_date`) VALUES
(5, '1', '1', '1', 'HR', '1', 'ARVIND', '1', 'ARVIND', NULL, 'nill', 'nill', '2025-05-10');

-- --------------------------------------------------------

--
-- Table structure for table `city_master`
--

CREATE TABLE `city_master` (
  `id` int(11) NOT NULL,
  `city_code` varchar(3) NOT NULL,
  `city_name` varchar(40) NOT NULL,
  `state_code` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `city_master`
--

INSERT INTO `city_master` (`id`, `city_code`, `city_name`, `state_code`) VALUES
(1, '1', 'banglore', '560');

-- --------------------------------------------------------

--
-- Table structure for table `companymaster`
--

CREATE TABLE `companymaster` (
  `CompanyCode` varchar(50) NOT NULL,
  `CompanyName` varchar(100) NOT NULL,
  `Address1` varchar(255) NOT NULL,
  `Address2` varchar(255) DEFAULT NULL,
  `Address3` varchar(255) DEFAULT NULL,
  `CityCode` varchar(50) NOT NULL,
  `Pincode` varchar(10) NOT NULL,
  `PrimaryContactName` varchar(100) NOT NULL,
  `OfficePhoneNumber` varchar(15) NOT NULL,
  `EmergencyPhoneNumber` varchar(15) DEFAULT NULL,
  `SecondaryContactName` varchar(100) DEFAULT NULL,
  `EmailAddress` varchar(100) NOT NULL,
  `SpecialInstructions` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companymaster`
--

INSERT INTO `companymaster` (`CompanyCode`, `CompanyName`, `Address1`, `Address2`, `Address3`, `CityCode`, `Pincode`, `PrimaryContactName`, `OfficePhoneNumber`, `EmergencyPhoneNumber`, `SecondaryContactName`, `EmailAddress`, `SpecialInstructions`) VALUES
('1', 'Finpro', '965 6th cross oil mill road lingarajapuram,', '965 6th cross oil mill road lingarajapuramBangalore, Karnataka, 560084, India, ', '965 6th cross oil mill road lingarajapuram, Ufuf, Bangalore, Karnataka, 560084, India, ', '560084', '560084', 'Arvind', '8971505277', '', 'Arvind H ', 'arvind261202@gmail.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `corrective_preventive_action_report`
--

CREATE TABLE `corrective_preventive_action_report` (
  `id` int(11) NOT NULL,
  `employee_code` varchar(20) NOT NULL,
  `employee_name` varchar(100) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `action_date` date NOT NULL,
  `system_code` varchar(20) NOT NULL,
  `system_name` varchar(100) NOT NULL,
  `ref_transaction_batch_no` varchar(50) NOT NULL,
  `problems_identified` text NOT NULL,
  `target_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `corrective_preventive_action_report`
--

INSERT INTO `corrective_preventive_action_report` (`id`, `employee_code`, `employee_name`, `designation`, `department`, `action_date`, `system_code`, `system_name`, `ref_transaction_batch_no`, `problems_identified`, `target_date`) VALUES
(1, '1', 'arvind', 'manager', 'cs', '2025-05-29', '1', 'arvind', '123', 'nill', '2025-05-29');

-- --------------------------------------------------------

--
-- Table structure for table `department_master`
--

CREATE TABLE `department_master` (
  `DepartmentCode` varchar(10) NOT NULL,
  `DepartmentName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_master`
--

INSERT INTO `department_master` (`DepartmentCode`, `DepartmentName`) VALUES
('1', 'HR');

-- --------------------------------------------------------

--
-- Table structure for table `designation_repository`
--

CREATE TABLE `designation_repository` (
  `EmployeeCode` varchar(10) DEFAULT NULL,
  `DepartmentCode` varchar(10) DEFAULT NULL,
  `LocationCode` varchar(10) DEFAULT NULL,
  `DesignationName` varchar(40) DEFAULT NULL,
  `CurrentInPosition` char(1) DEFAULT NULL CHECK (`CurrentInPosition` in ('Y','N')),
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designation_repository`
--

INSERT INTO `designation_repository` (`EmployeeCode`, `DepartmentCode`, `LocationCode`, `DesignationName`, `CurrentInPosition`, `StartDate`, `EndDate`) VALUES
('1', '1', '1', 'manager', 'Y', '2025-05-01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employee_code` varchar(50) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `phone1` varchar(20) NOT NULL,
  `phone2` varchar(20) DEFAULT NULL,
  `email1` varchar(100) NOT NULL,
  `email2` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_code`, `first_name`, `middle_name`, `last_name`, `company`, `department`, `designation`, `location`, `phone1`, `phone2`, `email1`, `email2`, `created_at`) VALUES
(2, '1', 'ARVIND', '', 'Krishna', 'Finpro', 'HR', 'maager', 'banglore', '9740641613', '9898592517', 'arvind@gmail.com', 'arvind261202@gmail.com', '2025-05-27 14:35:52'),
(3, '2', 'Arvind', '', 'Krishna', '1', '1', 'maager', '1', '756789876', '', 'arvind26@gmail.com', 'arvind@gmail.com', '2025-05-31 05:59:23'),
(4, '3', 'arvindh', '', 'krishna', 'Finpro', '', 'maager', 'banglore', '8765456789', '', 'arvind2@gmail.com', 'arvind3@gmail.com', '2025-05-31 06:02:12');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `location_code` varchar(10) NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `building_name` varchar(100) DEFAULT NULL,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(101) DEFAULT NULL,
  `address3` varchar(102) DEFAULT NULL,
  `city` varchar(3) DEFAULT NULL,
  `pincode` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `location_code`, `location_name`, `building_name`, `address1`, `address2`, `address3`, `city`, `pincode`) VALUES
(2, '1', 'banglore', '965', 'Bhagmane tech park', '965 6th cross oil mill road lingarajapuram, Ufuf, Bangalore, Karnataka, 560084, India', 'banglore', 'Ben', 560084);

-- --------------------------------------------------------

--
-- Table structure for table `state_master`
--

CREATE TABLE `state_master` (
  `id` int(11) NOT NULL,
  `state_code` varchar(3) NOT NULL,
  `state_name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `state_master`
--

INSERT INTO `state_master` (`id`, `state_code`, `state_name`) VALUES
(1, '561', 'karnataka');

-- --------------------------------------------------------

--
-- Table structure for table `system_asset_repository`
--

CREATE TABLE `system_asset_repository` (
  `id` int(11) NOT NULL,
  `system_code` varchar(10) NOT NULL,
  `asset_code` varchar(10) NOT NULL,
  `effective_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_asset_repository`
--

INSERT INTO `system_asset_repository` (`id`, `system_code`, `asset_code`, `effective_date`) VALUES
(1, '1', '1', '2025-05-28');

-- --------------------------------------------------------

--
-- Table structure for table `system_master`
--

CREATE TABLE `system_master` (
  `id` int(11) NOT NULL,
  `system_code` varchar(10) NOT NULL,
  `system_name` varchar(40) NOT NULL,
  `system_owner` varchar(10) NOT NULL,
  `criticality` enum('Tier 1 – Mission-Critical','Tier 2 – Critical','Tier 3 - Important','Tier 4 – Noncritical (Deferrable)') NOT NULL,
  `mtd` int(11) NOT NULL,
  `rpo` int(11) NOT NULL,
  `rto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_master`
--

INSERT INTO `system_master` (`id`, `system_code`, `system_name`, `system_owner`, `criticality`, `mtd`, `rpo`, `rto`) VALUES
(1, '1', 'arvind', 'arvind', '', 12, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `vendor_code` varchar(10) NOT NULL,
  `company_code` varchar(10) NOT NULL,
  `category_code` varchar(10) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('1','2','3') NOT NULL COMMENT '1: Active, 2: Suspended, 3: Terminated',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `vendor_code`, `company_code`, `category_code`, `start_date`, `end_date`, `status`, `created_at`) VALUES
(1, '1', '1', '1', '2025-05-31', '2025-05-28', '1', '2025-05-27 16:12:37');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_category`
--

CREATE TABLE `vendor_category` (
  `id` int(11) NOT NULL,
  `category_code` varchar(10) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor_category`
--

INSERT INTO `vendor_category` (`id`, `category_code`, `category_name`) VALUES
(1, '1', 'ven');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asset_class`
--
ALTER TABLE `asset_class`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `asset_class_code` (`asset_class_code`);

--
-- Indexes for table `asset_master`
--
ALTER TABLE `asset_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `asset_id_code` (`asset_id_code`);

--
-- Indexes for table `audit_report`
--
ALTER TABLE `audit_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city_master`
--
ALTER TABLE `city_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companymaster`
--
ALTER TABLE `companymaster`
  ADD PRIMARY KEY (`CompanyCode`);

--
-- Indexes for table `corrective_preventive_action_report`
--
ALTER TABLE `corrective_preventive_action_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department_master`
--
ALTER TABLE `department_master`
  ADD PRIMARY KEY (`DepartmentCode`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `location_code` (`location_code`);

--
-- Indexes for table `state_master`
--
ALTER TABLE `state_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_asset_repository`
--
ALTER TABLE `system_asset_repository`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_master`
--
ALTER TABLE `system_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_category`
--
ALTER TABLE `vendor_category`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asset_class`
--
ALTER TABLE `asset_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `asset_master`
--
ALTER TABLE `asset_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `audit_report`
--
ALTER TABLE `audit_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `city_master`
--
ALTER TABLE `city_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `corrective_preventive_action_report`
--
ALTER TABLE `corrective_preventive_action_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `state_master`
--
ALTER TABLE `state_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_asset_repository`
--
ALTER TABLE `system_asset_repository`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_master`
--
ALTER TABLE `system_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendor_category`
--
ALTER TABLE `vendor_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
