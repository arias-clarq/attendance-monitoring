-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2024 at 08:55 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `attendanceID` int(255) NOT NULL,
  `staffID` int(200) NOT NULL,
  `date` date NOT NULL,
  `timeIn` time DEFAULT NULL,
  `timeOut` time DEFAULT NULL,
  `statusID` int(200) NOT NULL,
  `workhoursID` int(200) NOT NULL,
  `worktime_statusID` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_attendance`
--

INSERT INTO `tbl_attendance` (`attendanceID`, `staffID`, `date`, `timeIn`, `timeOut`, `statusID`, `workhoursID`, `worktime_statusID`) VALUES
(12, 9, '2024-02-17', '15:54:53', '15:55:00', 2, 1, 3);

--
-- Triggers `tbl_attendance`
--
DELIMITER $$
CREATE TRIGGER `auto_mark_absent` AFTER INSERT ON `tbl_attendance` FOR EACH ROW BEGIN
    DECLARE attendance_exists INT;

    -- Check if an attendance record already exists for the staff member and current date
    SELECT COUNT(*) INTO attendance_exists
    FROM tbl_attendance
    WHERE staffID = NEW.staffID AND date = CURDATE();

    -- If no attendance record exists, insert a record with status indicating absent
    IF attendance_exists = 0 THEN
        INSERT INTO tbl_attendance (staffID, date, statusID)
        VALUES (NEW.staffID, CURDATE(), 3); -- Assuming 3 is the statusID for "absent"
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_position`
--

CREATE TABLE `tbl_position` (
  `positionID` int(255) NOT NULL,
  `position` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_position`
--

INSERT INTO `tbl_position` (`positionID`, `position`) VALUES
(1, '@admin'),
(2, '@staff');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE `tbl_staff` (
  `staffID` int(255) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `Fname` varchar(200) NOT NULL,
  `Mname` varchar(200) NOT NULL,
  `Lname` varchar(200) NOT NULL,
  `contactNo` bigint(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `workhoursID` int(200) NOT NULL,
  `shift_start` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_staff`
--

INSERT INTO `tbl_staff` (`staffID`, `username`, `password`, `Fname`, `Mname`, `Lname`, `contactNo`, `email`, `workhoursID`, `shift_start`) VALUES
(2, 'clarq@staff', 'arias', 'clarq', 'pangan', 'arias', 9123456789, 'clarq@gmail.com', 1, '09:00:00'),
(5, 'james@staff', 'james', 'Mark James', '', 'Montoya', 0, '', 1, '08:30:00'),
(9, 'noel@staff', 'noel', 'noel', '', '', 0, '', 1, '10:30:00'),
(10, 'marshiella@staff', 'marshiella', '', '', '', 0, '', 1, '19:00:00'),
(11, 'angeline@staff', 'angeline', '', '', '', 0, '', 1, '22:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status`
--

CREATE TABLE `tbl_status` (
  `statusID` int(255) NOT NULL,
  `status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_status`
--

INSERT INTO `tbl_status` (`statusID`, `status`) VALUES
(1, 'PRESENT'),
(2, 'LATE'),
(3, 'ABSENT');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `userID` int(255) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userID`, `username`, `password`) VALUES
(1, 'admin@admin', 'admin'),
(20, 'clarq@admin', 'arias');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_workhours`
--

CREATE TABLE `tbl_workhours` (
  `workhoursID` int(255) NOT NULL,
  `workhours` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_workhours`
--

INSERT INTO `tbl_workhours` (`workhoursID`, `workhours`) VALUES
(1, 6),
(2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_worktime_status`
--

CREATE TABLE `tbl_worktime_status` (
  `worktime_statusID` int(11) NOT NULL,
  `worktime_status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_worktime_status`
--

INSERT INTO `tbl_worktime_status` (`worktime_statusID`, `worktime_status`) VALUES
(1, 'NORMAL'),
(2, 'OVERTIME'),
(3, 'UNDERTIME'),
(4, 'WORKING');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`attendanceID`);

--
-- Indexes for table `tbl_position`
--
ALTER TABLE `tbl_position`
  ADD PRIMARY KEY (`positionID`);

--
-- Indexes for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`staffID`);

--
-- Indexes for table `tbl_status`
--
ALTER TABLE `tbl_status`
  ADD PRIMARY KEY (`statusID`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `tbl_workhours`
--
ALTER TABLE `tbl_workhours`
  ADD PRIMARY KEY (`workhoursID`);

--
-- Indexes for table `tbl_worktime_status`
--
ALTER TABLE `tbl_worktime_status`
  ADD PRIMARY KEY (`worktime_statusID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  MODIFY `attendanceID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_position`
--
ALTER TABLE `tbl_position`
  MODIFY `positionID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  MODIFY `staffID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_status`
--
ALTER TABLE `tbl_status`
  MODIFY `statusID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_workhours`
--
ALTER TABLE `tbl_workhours`
  MODIFY `workhoursID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_worktime_status`
--
ALTER TABLE `tbl_worktime_status`
  MODIFY `worktime_statusID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
