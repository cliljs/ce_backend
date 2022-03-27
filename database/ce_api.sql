-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2022 at 01:16 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ce_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `ce_accounts`
--

CREATE TABLE `ce_accounts` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `gender` text NOT NULL,
  `contact_number` text NOT NULL,
  `job_position` text DEFAULT NULL,
  `verification_token` varchar(100) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `employee_id` varchar(100) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Pang CRUD ng project sa app'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ce_accounts`
--

INSERT INTO `ce_accounts` (`id`, `email`, `firstname`, `lastname`, `gender`, `contact_number`, `job_position`, `verification_token`, `date_created`, `employee_id`, `is_admin`) VALUES
(8, 'brynikkococ@gmail.com', 'bryan', 'nikko', 'Male', '1234-456', 'Steel Man', '110878772055035080091', '2022-03-13 06:43:42', 'LOGBI-2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ce_compute`
--

CREATE TABLE `ce_compute` (
  `id` bigint(20) NOT NULL,
  `project_id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `sub_category` varchar(255) NOT NULL,
  `cat_key` double NOT NULL,
  `value` double NOT NULL,
  `optional_param` varchar(100) NOT NULL COMMENT 'For Dropdown Columns[Optional]',
  `worker1_count` int(11) NOT NULL,
  `worker2_count` int(11) NOT NULL,
  `work_days` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ce_compute`
--

INSERT INTO `ce_compute` (`id`, `project_id`, `category`, `sub_category`, `cat_key`, `value`, `optional_param`, `worker1_count`, `worker2_count`, `work_days`) VALUES
(1, 1, 'Earthworks', 'Excavation', 50, 1, 'Soft', 17, 0, 1),
(2, 1, 'Steelworks', 'Footings', 900, 1, 'none', 5, 0, 1),
(3, 1, 'Steelworks', 'Column', 300, 1, 'none', 2, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ce_files`
--

CREATE TABLE `ce_files` (
  `id` int(11) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `filesize` int(100) NOT NULL,
  `created_by` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `file_link` varchar(100) NOT NULL,
  `timestamp_tick` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ce_files`
--

INSERT INTO `ce_files` (`id`, `filename`, `filesize`, `created_by`, `date_created`, `file_link`, `timestamp_tick`) VALUES
(8, 'files/wews_1647652727.jpg', 90380, 8, '2022-03-19 02:18:47', 'files/wews_1647652727.jpg', 1647652727);

-- --------------------------------------------------------

--
-- Table structure for table `ce_labor`
--

CREATE TABLE `ce_labor` (
  `id` int(11) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `job_salary` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ce_labor`
--

INSERT INTO `ce_labor` (`id`, `job_title`, `job_salary`, `created_at`) VALUES
(3, 'Carpenter', 600, '2022-03-27 02:10:15'),
(4, 'Laborer', 400, '2022-03-27 02:10:25'),
(5, 'Mason', 550, '2022-03-27 02:10:32'),
(6, 'Steel Man', 550, '2022-03-27 02:10:44'),
(7, 'Painter', 600, '2022-03-27 02:10:54'),
(8, 'Electrician', 600, '2022-03-27 02:11:04'),
(9, 'Plumber', 550, '2022-03-27 02:11:12'),
(10, 'Tile Man', 600, '2022-03-27 02:11:18'),
(11, 'Door Installer', 500, '2022-03-27 02:11:29'),
(12, 'Tinsmith', 600, '2022-03-27 02:11:38'),
(13, 'Welder', 600, '2022-03-27 02:11:45');

-- --------------------------------------------------------

--
-- Table structure for table `ce_logs`
--

CREATE TABLE `ce_logs` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL,
  `log_date` date NOT NULL,
  `project` varchar(150) NOT NULL,
  `tasks` varchar(100) NOT NULL,
  `emp_signature` varchar(255) NOT NULL,
  `supervisor_signature` varchar(255) NOT NULL,
  `email_to` varchar(100) NOT NULL,
  `is_daily_log` tinyint(1) DEFAULT 0,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ce_logs`
--

INSERT INTO `ce_logs` (`id`, `name`, `time_in`, `time_out`, `log_date`, `project`, `tasks`, `emp_signature`, `supervisor_signature`, `email_to`, `is_daily_log`, `email`) VALUES
(1, 'bryan nikko', '00:08:00', '00:15:00', '2022-03-16', 'Sample House', 'Ceiling', '/images/logbi_1647407798.png', '/images/patootie_1647407798.png', 'asd', 1, 'brynikkococ@gmail.com'),
(2, 'bryan nikko', '00:07:00', '00:08:00', '2022-03-16', 'Sample House', 'Sample', '/images/logbi_1647408509.png', '/images/patootie_1647408509.png', 'asd', 1, 'brynikkococ@gmail.com'),
(3, 'bryan nikko', '17:04:00', '21:00:00', '2022-03-27', 'Sample House', '123', '/images/logbi_1648371881.png', '/images/patootie_1648371881.png', 'asd', 1, 'brynikkococ@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `ce_notes`
--

CREATE TABLE `ce_notes` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` varchar(255) NOT NULL,
  `date_updated` datetime NOT NULL,
  `date_created` datetime NOT NULL,
  `author_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ce_notes`
--

INSERT INTO `ce_notes` (`id`, `title`, `content`, `date_updated`, `date_created`, `author_id`) VALUES
(1, '111', '23456', '0000-00-00 00:00:00', '2022-03-16 12:43:29', 8),
(2, '222', '45156415', '0000-00-00 00:00:00', '2022-03-16 12:43:40', 8);

-- --------------------------------------------------------

--
-- Table structure for table `ce_projects`
--

CREATE TABLE `ce_projects` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `created_by` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `sq_meters` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ce_projects`
--

INSERT INTO `ce_projects` (`id`, `name`, `description`, `type`, `created_by`, `date_created`, `sq_meters`) VALUES
(1, 'Sample House', 'Testing cloud server', '2-Storey', 8, '2022-03-16 06:12:52', 80);

-- --------------------------------------------------------

--
-- Table structure for table `ce_todo`
--

CREATE TABLE `ce_todo` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `author_id` int(11) NOT NULL COMMENT 'ACCOUNT ID OF AUTH USER',
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ce_todo`
--

INSERT INTO `ce_todo` (`id`, `title`, `description`, `author_id`, `date_created`, `date_updated`) VALUES
(6, 'qwertyaasd', 'asdsadasdas', 8, '2022-03-16 13:39:10', '0000-00-00 00:00:00'),
(7, 'pewpewpew', 'asxaxasxasefewfewfw', 8, '2022-03-18 02:03:58', '2022-03-18 02:08:01');

-- --------------------------------------------------------

--
-- Table structure for table `ce_worksettings`
--

CREATE TABLE `ce_worksettings` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `subcategory` varchar(100) NOT NULL,
  `optional_param` varchar(100) NOT NULL,
  `default_value` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ce_accounts`
--
ALTER TABLE `ce_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_compute`
--
ALTER TABLE `ce_compute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_files`
--
ALTER TABLE `ce_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_labor`
--
ALTER TABLE `ce_labor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_logs`
--
ALTER TABLE `ce_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_notes`
--
ALTER TABLE `ce_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_projects`
--
ALTER TABLE `ce_projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_todo`
--
ALTER TABLE `ce_todo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ce_worksettings`
--
ALTER TABLE `ce_worksettings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ce_accounts`
--
ALTER TABLE `ce_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ce_compute`
--
ALTER TABLE `ce_compute`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ce_files`
--
ALTER TABLE `ce_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ce_labor`
--
ALTER TABLE `ce_labor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ce_logs`
--
ALTER TABLE `ce_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ce_notes`
--
ALTER TABLE `ce_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ce_projects`
--
ALTER TABLE `ce_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ce_todo`
--
ALTER TABLE `ce_todo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ce_worksettings`
--
ALTER TABLE `ce_worksettings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
