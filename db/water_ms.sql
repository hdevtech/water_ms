-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2024 at 09:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `water_ms`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`` FUNCTION `get_m3_price` () RETURNS DECIMAL(10,2)  BEGIN
                        DECLARE price DECIMAL(10, 2);
                        SET price = 600;
                        RETURN price;
                    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `a_id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`a_id`, `username`, `password`) VALUES
(1, 'admin@gmail.com', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `c_id` int(11) NOT NULL,
  `meter_id` int(11) NOT NULL,
  `c_tell` text NOT NULL,
  `c_name` text NOT NULL,
  `c_nid` text NOT NULL,
  `pin` text NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`c_id`, `meter_id`, `c_tell`, `c_name`, `c_nid`, `pin`, `reg_date`) VALUES
(1, 1, '785569911', 'Roger', '123456', '123', '2024-03-13 10:22:28'),
(6, 4, '+250798760888', 'IZERE HIRWA Roger', '123456', '123', '2024-05-07 12:36:10');

-- --------------------------------------------------------

--
-- Table structure for table `meters`
--

CREATE TABLE `meters` (
  `meter_id` int(11) NOT NULL,
  `meter_name` text NOT NULL,
  `meter_owner` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meters`
--

INSERT INTO `meters` (`meter_id`, `meter_name`, `meter_owner`) VALUES
(1, 'tt', 'Rogers'),
(3, 'ahdasd', 'Elisa'),
(4, 'M Water meter', 'M tech ltd'),
(5, 'CVBM', 'HEIXING'),
(6, 'TTFGH', 'HW TECH Ltd'),
(7, 'yyyy', 'VVV');

-- --------------------------------------------------------

--
-- Table structure for table `meter_logs`
--

CREATE TABLE `meter_logs` (
  `meter_log_id` int(11) NOT NULL,
  `meter_reading` double NOT NULL,
  `meter_log_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `meter_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meter_logs`
--

INSERT INTO `meter_logs` (`meter_log_id`, `meter_reading`, `meter_log_date`, `meter_id`) VALUES
(1, 0, '2024-04-03 00:55:53', 1),
(2, 10, '2024-04-03 00:55:54', 1),
(4, 12, '2024-04-03 01:33:41', 4),
(5, 20, '2024-04-03 08:32:30', 6),
(6, 20, '2024-04-03 08:32:53', 6),
(7, 5, '2024-04-03 09:09:00', 7);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `meter_id` int(11) DEFAULT NULL,
  `m3_price` decimal(10,2) DEFAULT NULL,
  `m3_qty` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `payment_slip` varchar(50) DEFAULT NULL,
  `payment_date_time` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `meter_id`, `m3_price`, `m3_qty`, `total_price`, `payment_status`, `payment_slip`, `payment_date_time`) VALUES
(1, 1, 500.00, 2.00, 1000.00, 'success', '0785569911', '2024-04-03 01:05:23'),
(2, 4, 500.00, 0.80, 400.00, 'paid', 'tghybv', '2024-04-03 07:52:26'),
(3, 6, 500.00, 20.00, 10000.00, 'paid', 'ujkop', '2024-04-03 08:38:43'),
(4, 7, 600.00, 1.67, 1000.00, 'paid', '1234567890', '2024-04-03 09:11:54');

-- --------------------------------------------------------

--
-- Stand-in structure for view `water_total_usage`
-- (See below for the actual view)
--
CREATE TABLE `water_total_usage` (
`meter_id` int(11)
,`total_m3_usage` double
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `water_total_usage_paid`
-- (See below for the actual view)
--
CREATE TABLE `water_total_usage_paid` (
`meter_id` int(11)
,`total_m3_qty_paid` decimal(32,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `water_usage_unpaid`
-- (See below for the actual view)
--
CREATE TABLE `water_usage_unpaid` (
`meter_id` int(11)
,`total_m3_usage_unpaid` double
,`remaining_amount_to_pay` double
);

-- --------------------------------------------------------

--
-- Structure for view `water_total_usage`
--
DROP TABLE IF EXISTS `water_total_usage`;

CREATE `water_total_usage`  AS SELECT `meter_logs`.`meter_id` AS `meter_id`, sum(`meter_logs`.`meter_reading`) AS `total_m3_usage` FROM `meter_logs` GROUP BY `meter_logs`.`meter_id` ;

-- --------------------------------------------------------

--
-- Structure for view `water_total_usage_paid`
--
DROP TABLE IF EXISTS `water_total_usage_paid`;

CREATE `water_total_usage_paid`  AS SELECT `payments`.`meter_id` AS `meter_id`, sum(`payments`.`m3_qty`) AS `total_m3_qty_paid` FROM `payments` GROUP BY `payments`.`meter_id` ;

-- --------------------------------------------------------

--
-- Structure for view `water_usage_unpaid`
--
DROP TABLE IF EXISTS `water_usage_unpaid`;

CREATE `water_usage_unpaid`  AS SELECT `tu`.`meter_id` AS `meter_id`, `tu`.`total_m3_usage`- coalesce(`tp`.`total_m3_qty_paid`,0) AS `total_m3_usage_unpaid`, (`tu`.`total_m3_usage` - coalesce(`tp`.`total_m3_qty_paid`,0)) * `get_m3_price`() AS `remaining_amount_to_pay` FROM (`water_total_usage` `tu` left join `water_total_usage_paid` `tp` on(`tu`.`meter_id` = `tp`.`meter_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `meters`
--
ALTER TABLE `meters`
  ADD PRIMARY KEY (`meter_id`);

--
-- Indexes for table `meter_logs`
--
ALTER TABLE `meter_logs`
  ADD PRIMARY KEY (`meter_log_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `meter_id` (`meter_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `meters`
--
ALTER TABLE `meters`
  MODIFY `meter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `meter_logs`
--
ALTER TABLE `meter_logs`
  MODIFY `meter_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`meter_id`) REFERENCES `meters` (`meter_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
