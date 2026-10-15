-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 27, 2026 at 05:32 PM
-- Server version: 8.0.45-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `MakeItAll`
--

-- --------------------------------------------------------

--
-- Table structure for table `Attachments`
--

CREATE TABLE `Attachments` (
  `attachment_id` int NOT NULL,
  `uploader_id` int DEFAULT NULL,
  `file_url` varchar(300) DEFAULT NULL,
  `file_name` varchar(100) DEFAULT NULL,
  `doc_type` enum('image','pdf','doc','powerpoint','excel') DEFAULT NULL,
  `file_size` bigint DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Attachments`
--

INSERT INTO `Attachments` (`attachment_id`, `uploader_id`, `file_url`, `file_name`, `doc_type`, `file_size`, `created_at`) VALUES
(1, 36, 'filler', 'filler', 'doc', 4500, '2026-03-28 10:35:13'),
(2, 1, 'test', 'test', 'excel', 1200, '2026-03-28 10:46:10');

-- --------------------------------------------------------

--
-- Table structure for table `Categories`
--

CREATE TABLE `Categories` (
  `category_id` int NOT NULL,
  `categories` set('frontend dev','backend dev','sales','management','python','web dev','SQL') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Categories`
--

INSERT INTO `Categories` (`category_id`, `categories`) VALUES
(1, 'frontend dev'),
(2, 'backend dev'),
(3, 'sales'),
(4, 'management'),
(5, 'python'),
(6, 'web dev'),
(7, 'SQL');

-- --------------------------------------------------------

--
-- Table structure for table `Category_Assignment`
--

CREATE TABLE `Category_Assignment` (
  `assignment_id` int NOT NULL,
  `category_id` int NOT NULL,
  `project_id` int DEFAULT NULL,
  `employee_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Category_Assignment`
--

INSERT INTO `Category_Assignment` (`assignment_id`, `category_id`, `project_id`, `employee_id`) VALUES
(1, 4, NULL, 1),
(2, 4, NULL, 2),
(3, 4, NULL, 3),
(4, 4, NULL, 4),
(5, 1, NULL, 4),
(6, 6, NULL, 4),
(7, 4, NULL, 5),
(8, 2, NULL, 5),
(9, 7, NULL, 5),
(10, 4, NULL, 6),
(11, 5, NULL, 6),
(12, 7, NULL, 6),
(13, 4, NULL, 7),
(14, 6, NULL, 7),
(15, 1, NULL, 7),
(16, 4, NULL, 8),
(17, 7, NULL, 8),
(18, 5, NULL, 8),
(19, 4, NULL, 9),
(20, 3, NULL, 9),
(21, 6, NULL, 9),
(22, 1, NULL, 10),
(23, 6, NULL, 10),
(24, 1, NULL, 11),
(25, 6, NULL, 11),
(26, 1, NULL, 12),
(27, 6, NULL, 12),
(28, 1, NULL, 13),
(29, 1, NULL, 14),
(30, 6, NULL, 14),
(31, 1, NULL, 15),
(32, 6, NULL, 15),
(33, 2, NULL, 16),
(34, 7, NULL, 16),
(35, 2, NULL, 17),
(36, 2, NULL, 18),
(37, 7, NULL, 18),
(38, 2, NULL, 19),
(39, 6, NULL, 19),
(40, 2, NULL, 20),
(41, 2, NULL, 21),
(42, 6, NULL, 21),
(43, 5, NULL, 22),
(44, 5, NULL, 23),
(45, 7, NULL, 23),
(46, 5, NULL, 24),
(47, 7, NULL, 24),
(48, 5, NULL, 25),
(49, 5, NULL, 26),
(50, 6, NULL, 27),
(51, 1, NULL, 27),
(52, 6, NULL, 28),
(53, 2, NULL, 28),
(54, 6, NULL, 29),
(55, 1, NULL, 29),
(56, 6, NULL, 30),
(57, 2, NULL, 30),
(58, 6, NULL, 31),
(59, 2, NULL, 31),
(60, 7, NULL, 32),
(61, 7, NULL, 33),
(62, 5, NULL, 33),
(63, 7, NULL, 34),
(64, 2, NULL, 34),
(65, 7, NULL, 35),
(66, 5, NULL, 35),
(67, 3, NULL, 36),
(68, 6, NULL, 36),
(69, 3, NULL, 37),
(70, 7, NULL, 37),
(71, 3, NULL, 38),
(72, 6, NULL, 38),
(73, 3, NULL, 39),
(74, 6, NULL, 39),
(75, 3, NULL, 40),
(76, 6, NULL, 40),
(77, 1, 1, NULL),
(78, 2, 1, NULL),
(79, 6, 1, NULL),
(80, 1, 2, NULL),
(81, 6, 2, NULL),
(82, 3, 2, NULL),
(83, 2, 3, NULL),
(84, 6, 3, NULL),
(85, 7, 3, NULL),
(86, 5, 4, NULL),
(87, 7, 4, NULL),
(88, 3, 5, NULL),
(89, 6, 5, NULL),
(90, 7, 5, NULL),
(91, 5, 6, NULL),
(92, 7, 6, NULL),
(93, 2, 6, NULL),
(94, 5, 7, NULL),
(95, 6, 7, NULL),
(96, 2, 7, NULL),
(97, 1, 8, NULL),
(98, 2, 8, NULL),
(99, 6, 8, NULL),
(100, 7, 8, NULL),
(101, 7, 9, NULL),
(102, 2, 9, NULL),
(103, 2, 10, NULL),
(104, 6, 10, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Chat_Project_Link`
--

CREATE TABLE `Chat_Project_Link` (
  `conversation_id` int NOT NULL,
  `project_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Chat_Project_Link`
--

INSERT INTO `Chat_Project_Link` (`conversation_id`, `project_id`) VALUES
(1, 1),
(2, 2),
(5, 3),
(9, 4),
(10, 5),
(11, 6),
(17, 7),
(18, 8);

-- --------------------------------------------------------

--
-- Table structure for table `Conversations`
--

CREATE TABLE `Conversations` (
  `conversation_id` int NOT NULL,
  `type` set('DM','GC') DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `creator_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `last_message_id` int DEFAULT NULL,
  `visibility` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Conversations`
--

INSERT INTO `Conversations` (`conversation_id`, `type`, `title`, `creator_id`, `created_at`, `last_message_id`, `visibility`) VALUES
(1, 'GC', 'Frontend Team Sync', 4, '2026-03-01 09:00:00', 7, 1),
(2, 'GC', 'Backend Core Platform', 5, '2026-03-02 10:15:00', 13, 1),
(3, 'GC', 'Data & Analytics Hub', 6, '2026-03-05 11:30:00', 18, 1),
(4, 'GC', 'Management Sync', 1, '2026-03-10 08:00:00', 22, 1),
(5, 'GC', 'CRM Automation Rollout', 9, '2026-03-12 14:00:00', 26, 1),
(6, 'DM', 'Olivia & Marcus 1:1', 1, '2026-03-14 09:30:00', 29, 1),
(7, 'DM', 'Ethan & Chloe (API Sync)', 4, '2026-03-15 10:00:00', 32, 1),
(8, 'DM', 'Priya & Daniel 1:1', 3, '2026-03-16 13:45:00', 34, 1),
(9, 'GC', 'Project Apollo Launch', 2, '2026-03-17 09:00:00', 39, 1),
(10, 'GC', 'Web Platform Updates', 7, '2026-03-17 11:00:00', 42, 1),
(11, 'GC', 'SQL Performance Tuning', 8, '2026-03-18 10:20:00', 46, 1),
(12, 'DM', 'Ava & Noah Chatter', 10, '2026-03-18 15:30:00', 49, 1),
(13, 'GC', 'Social & Lunch Crew 🍕', 14, '2026-03-01 12:00:00', 52, 1),
(14, 'GC', 'Bug Triage - Critical', 2, '2026-03-18 09:00:00', 56, 1),
(15, 'DM', 'Sophie & Benjamin 1:1', 7, '2026-03-15 14:00:00', 58, 1),
(16, 'GC', 'DevOps & Infrastructure', 1, '2026-02-15 09:00:00', 61, 1),
(17, 'GC', 'Design System V2', 12, '2026-03-10 10:00:00', 64, 1),
(18, 'GC', 'Machine Learning Research', 26, '2026-03-05 16:00:00', 67, 1),
(19, 'DM', 'Ryan & George (Reporting)', 8, '2026-03-18 11:00:00', 69, 1),
(20, 'GC', 'All Hands Announcements', 1, '2026-01-10 09:00:00', 72, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Conversation_User_Settings`
--

CREATE TABLE `Conversation_User_Settings` (
  `conversation_id` int NOT NULL,
  `user_id` int NOT NULL,
  `role` set('Owner','Admin','Member') DEFAULT NULL,
  `joined_at` datetime DEFAULT NULL,
  `left_at` datetime DEFAULT NULL,
  `favourited` tinyint(1) DEFAULT NULL,
  `visibility` tinyint(1) DEFAULT NULL,
  `is_muted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Conversation_User_Settings`
--

INSERT INTO `Conversation_User_Settings` (`conversation_id`, `user_id`, `role`, `joined_at`, `left_at`, `favourited`, `visibility`, `is_muted`) VALUES
(1, 4, 'Owner', '2026-03-01 09:00:00', NULL, 1, 1, 0),
(1, 10, 'Member', '2026-03-01 09:00:00', NULL, 0, 1, 0),
(1, 11, 'Member', '2026-03-01 09:00:00', NULL, 0, 1, 0),
(1, 12, 'Member', '2026-03-01 09:00:00', NULL, 0, 1, 0),
(1, 13, 'Member', '2026-03-01 09:00:00', NULL, 0, 1, 0),
(1, 14, 'Member', '2026-03-01 09:00:00', NULL, 0, 1, 0),
(1, 15, 'Member', '2026-03-01 09:00:00', NULL, 0, 1, 0),
(2, 5, 'Owner', '2026-03-02 10:15:00', NULL, 1, 1, 0),
(2, 16, 'Member', '2026-03-02 10:15:00', NULL, 0, 1, 0),
(2, 17, 'Member', '2026-03-02 10:15:00', NULL, 0, 1, 0),
(2, 18, 'Member', '2026-03-02 10:15:00', NULL, 1, 1, 0),
(2, 19, 'Member', '2026-03-02 10:15:00', NULL, 0, 1, 0),
(2, 20, 'Member', '2026-03-02 10:15:00', NULL, 0, 1, 0),
(2, 21, 'Member', '2026-03-02 10:15:00', NULL, 0, 1, 0),
(3, 6, 'Owner', '2026-03-05 11:30:00', NULL, 1, 1, 0),
(3, 22, 'Member', '2026-03-05 11:30:00', NULL, 0, 1, 0),
(3, 23, 'Member', '2026-03-05 11:30:00', NULL, 0, 1, 0),
(3, 24, 'Member', '2026-03-05 11:30:00', NULL, 1, 1, 0),
(3, 25, 'Member', '2026-03-05 11:30:00', NULL, 0, 1, 0),
(3, 26, 'Member', '2026-03-05 11:30:00', NULL, 0, 1, 0),
(4, 1, 'Owner', '2026-03-10 08:00:00', NULL, 1, 1, 0),
(4, 2, 'Admin', '2026-03-10 08:00:00', NULL, 1, 1, 0),
(4, 3, 'Admin', '2026-03-10 08:00:00', NULL, 1, 1, 0),
(4, 4, 'Member', '2026-03-10 08:00:00', NULL, 0, 1, 0),
(4, 5, 'Member', '2026-03-10 08:00:00', NULL, 0, 1, 0),
(4, 6, 'Member', '2026-03-10 08:00:00', NULL, 0, 1, 0),
(4, 7, 'Member', '2026-03-10 08:00:00', NULL, 0, 1, 0),
(4, 8, 'Member', '2026-03-10 08:00:00', NULL, 0, 1, 0),
(4, 9, 'Member', '2026-03-10 08:00:00', NULL, 0, 1, 0),
(5, 9, 'Owner', '2026-03-12 14:00:00', NULL, 1, 1, 0),
(5, 36, 'Member', '2026-03-12 14:00:00', NULL, 0, 1, 0),
(5, 38, 'Member', '2026-03-12 14:00:00', NULL, 1, 1, 0),
(5, 40, 'Member', '2026-03-12 14:00:00', NULL, 0, 1, 0),
(6, 1, 'Owner', '2026-03-14 09:30:00', NULL, 1, 1, 0),
(6, 2, 'Admin', '2026-03-14 09:30:00', NULL, 1, 1, 0),
(7, 4, 'Owner', '2026-03-15 10:00:00', NULL, 1, 1, 0),
(7, 5, 'Admin', '2026-03-15 10:00:00', NULL, 1, 1, 0),
(8, 3, 'Owner', '2026-03-16 13:45:00', NULL, 1, 1, 0),
(8, 6, 'Admin', '2026-03-16 13:45:00', NULL, 0, 1, 0),
(9, 2, 'Owner', '2026-03-17 09:00:00', NULL, 1, 1, 0),
(9, 7, 'Admin', '2026-03-17 09:00:00', NULL, 1, 1, 0),
(9, 27, 'Member', '2026-03-17 09:00:00', NULL, 0, 1, 0),
(10, 7, 'Owner', '2026-03-17 11:00:00', NULL, 1, 1, 0),
(10, 28, 'Member', '2026-03-17 11:00:00', NULL, 1, 1, 0),
(10, 30, 'Member', '2026-03-17 11:00:00', NULL, 0, 1, 0),
(11, 8, 'Owner', '2026-03-18 10:20:00', NULL, 1, 1, 0),
(11, 32, 'Member', '2026-03-18 10:20:00', NULL, 0, 1, 0),
(11, 34, 'Member', '2026-03-18 10:20:00', NULL, 1, 1, 0),
(12, 10, 'Owner', '2026-03-18 15:30:00', NULL, 1, 1, 0),
(12, 11, 'Admin', '2026-03-18 15:30:00', NULL, 0, 1, 0),
(13, 10, 'Member', '2026-03-01 12:00:00', NULL, 1, 1, 0),
(13, 11, 'Member', '2026-03-01 12:00:00', NULL, 0, 1, 0),
(13, 14, 'Owner', '2026-03-01 12:00:00', NULL, 1, 1, 0),
(13, 31, 'Member', '2026-03-01 12:00:00', NULL, 0, 1, 0),
(14, 2, 'Owner', '2026-03-18 09:00:00', NULL, 1, 1, 0),
(14, 5, 'Admin', '2026-03-18 09:00:00', NULL, 1, 1, 0),
(14, 16, 'Member', '2026-03-18 09:00:00', NULL, 0, 1, 0),
(15, 7, 'Owner', '2026-03-15 14:00:00', NULL, 1, 1, 0),
(15, 29, 'Admin', '2026-03-15 14:00:00', NULL, 0, 1, 0),
(19, 8, 'Owner', '2026-03-18 11:00:00', NULL, 1, 1, 0),
(19, 35, 'Admin', '2026-03-18 11:00:00', NULL, 0, 1, 0),
(20, 1, 'Owner', '2026-01-10 09:00:00', NULL, 1, 1, 0),
(20, 2, 'Admin', '2026-01-10 09:00:00', NULL, 0, 1, 0),
(20, 3, 'Admin', '2026-01-10 09:00:00', NULL, 0, 1, 0),
(20, 10, 'Member', '2026-01-10 09:00:00', NULL, 1, 1, 0),
(20, 16, 'Member', '2026-01-10 09:00:00', NULL, 0, 1, 0),
(20, 24, 'Member', '2026-01-10 09:00:00', NULL, 0, 1, 0),
(20, 32, 'Member', '2026-01-10 09:00:00', NULL, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Employees`
--

CREATE TABLE `Employees` (
  `employee_id` int NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `role_type` set('employee','teamLeader','manager') DEFAULT NULL,
  `job_title` varchar(200) DEFAULT NULL,
  `profile_picture` varbinary(8000) DEFAULT NULL,
  `manager_id` int DEFAULT NULL,
  `status` set('online','offline','busy') DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `visibility` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Employees`
--

INSERT INTO `Employees` (`employee_id`, `first_name`, `last_name`, `email`, `role_type`, `job_title`, `profile_picture`, `manager_id`, `status`, `last_login`, `created_at`, `password`, `visibility`) VALUES
(1, 'Olivia', 'Bennett', 'olivia.bennett@northstarapps.co.uk', 'manager', 'Operations Manager', NULL, NULL, 'online', '2026-03-15 11:37:00', '2024-01-25 09:00:00', 'test', 1),
(2, 'Marcus', 'Reed', 'marcus.reed@northstarapps.co.uk', 'manager', 'Engineering Manager', NULL, NULL, 'busy', '2026-03-15 14:44:00', '2024-02-11 09:00:00', 'test', 1),
(3, 'Priya', 'Shah', 'priya.shah@northstarapps.co.uk', 'manager', 'Delivery Manager', NULL, NULL, 'offline', '2026-03-15 17:51:00', '2024-02-28 09:00:00', 'test', 1),
(4, 'Ethan', 'Clarke', 'ethan.clarke@northstarapps.co.uk', 'teamLeader', 'Frontend Team Leader', NULL, 2, 'online', '2026-03-15 20:58:00', '2024-03-16 09:00:00', 'test', 1),
(5, 'Chloe', 'Martin', 'chloe.martin@northstarapps.co.uk', 'teamLeader', 'Backend Team Leader', NULL, 2, 'online', '2026-03-16 00:05:00', '2024-04-02 09:00:00', 'test', 1),
(6, 'Daniel', 'Hughes', 'daniel.hughes@northstarapps.co.uk', 'teamLeader', 'Data Engineering Team Leader', NULL, 3, 'offline', '2026-03-16 03:12:00', '2024-04-19 09:00:00', 'test', 1),
(7, 'Sophie', 'Patel', 'sophie.patel@northstarapps.co.uk', 'teamLeader', 'Web Platform Team Leader', NULL, 2, 'busy', '2026-03-16 06:19:00', '2024-05-06 09:00:00', 'test', 1),
(8, 'Ryan', 'Cooper', 'ryan.cooper@northstarapps.co.uk', 'teamLeader', 'BI and SQL Team Leader', NULL, 3, 'offline', '2026-03-16 08:36:00', '2024-05-23 09:00:00', 'test', 1),
(9, 'Amelia', 'Lewis', 'amelia.lewis@northstarapps.co.uk', 'teamLeader', 'CRM Automation Team Leader', NULL, 1, 'online', '2026-03-16 11:43:00', '2024-06-09 09:00:00', 'test', 1),
(10, 'Ava', 'Thompson', 'ava.thompson@northstarapps.co.uk', 'employee', 'Frontend Developer', NULL, 4, 'offline', '2026-03-16 14:50:00', '2024-06-26 09:00:00', 'test', 1),
(11, 'Noah', 'Walker', 'noah.walker@northstarapps.co.uk', 'employee', 'Frontend Developer', NULL, 4, 'offline', '2026-03-16 17:57:00', '2024-07-13 09:00:00', 'test', 1),
(12, 'Mia', 'Foster', 'mia.foster@northstarapps.co.uk', 'employee', 'UI Developer', NULL, 4, 'busy', '2026-03-16 21:04:00', '2024-07-30 09:00:00', 'test', 1),
(13, 'Leo', 'Price', 'leo.price@northstarapps.co.uk', 'employee', 'Frontend Developer', NULL, 4, 'offline', '2026-03-17 00:11:00', '2024-08-16 09:00:00', 'test', 1),
(14, 'Grace', 'Murphy', 'grace.murphy@northstarapps.co.uk', 'employee', 'UX Engineer', NULL, 4, 'online', '2026-03-17 03:18:00', '2024-09-02 09:00:00', 'test', 1),
(15, 'Isaac', 'Bell', 'isaac.bell@northstarapps.co.uk', 'employee', 'Frontend Developer', NULL, 4, 'online', '2026-03-17 05:35:00', '2024-09-19 09:00:00', 'test', 1),
(16, 'Ruby', 'Turner', 'ruby.turner@northstarapps.co.uk', 'employee', 'Backend Developer', NULL, 5, 'offline', '2026-03-17 08:42:00', '2024-10-06 09:00:00', 'test', 1),
(17, 'Jack', 'Collins', 'jack.collins@northstarapps.co.uk', 'employee', 'Backend Developer', NULL, 5, 'busy', '2026-03-17 11:49:00', '2024-10-23 09:00:00', 'test', 1),
(18, 'Lily', 'Ward', 'lily.ward@northstarapps.co.uk', 'employee', 'Backend Developer', NULL, 5, 'offline', '2026-03-17 14:56:00', '2024-11-09 09:00:00', 'test', 1),
(19, 'Oscar', 'Bryant', 'oscar.bryant@northstarapps.co.uk', 'employee', 'API Developer', NULL, 5, 'online', '2026-03-17 18:03:00', '2024-11-26 09:00:00', 'test', 1),
(20, 'Ella', 'Cox', 'ella.cox@northstarapps.co.uk', 'employee', 'Backend Developer', NULL, 5, 'online', '2026-03-15 09:10:00', '2024-12-13 09:00:00', 'test', 1),
(21, 'Henry', 'Powell', 'henry.powell@northstarapps.co.uk', 'employee', 'Integration Developer', NULL, 5, 'offline', '2026-03-15 12:17:00', '2024-12-30 09:00:00', 'test', 1),
(22, 'Freya', 'Brooks', 'freya.brooks@northstarapps.co.uk', 'employee', 'Python Developer', NULL, 6, 'busy', '2026-03-15 14:34:00', '2025-01-16 09:00:00', 'test', 1),
(23, 'Thomas', 'Kelly', 'thomas.kelly@northstarapps.co.uk', 'employee', 'Data Analyst', NULL, 6, 'offline', '2026-03-15 17:41:00', '2025-02-02 09:00:00', 'test', 1),
(24, 'Hannah', 'Richardson', 'hannah.richardson@northstarapps.co.uk', 'employee', 'Data Engineer', NULL, 6, 'online', '2026-03-15 20:48:00', '2025-02-19 09:00:00', 'test', 1),
(25, 'James', 'Bailey', 'james.bailey@northstarapps.co.uk', 'employee', 'Python Developer', NULL, 6, 'online', '2026-03-15 23:55:00', '2025-03-08 09:00:00', 'test', 1),
(26, 'Emily', 'Bennett', 'emily.bennett@northstarapps.co.uk', 'employee', 'Machine Learning Analyst', NULL, 6, 'offline', '2026-03-16 03:02:00', '2025-03-25 09:00:00', 'test', 1),
(27, 'Lucas', 'Gray', 'lucas.gray@northstarapps.co.uk', 'employee', 'Web Developer', NULL, 7, 'busy', '2026-03-16 06:09:00', '2025-04-11 09:00:00', 'test', 1),
(28, 'Zoe', 'Cooper', 'zoe.cooper@northstarapps.co.uk', 'employee', 'Full Stack Web Developer', NULL, 7, 'offline', '2026-03-16 09:16:00', '2025-04-28 09:00:00', 'test', 1),
(29, 'Benjamin', 'Adams', 'benjamin.adams@northstarapps.co.uk', 'employee', 'Web Developer', NULL, 7, 'online', '2026-03-16 11:33:00', '2025-05-15 09:00:00', 'test', 1),
(30, 'Charlotte', 'Evans', 'charlotte.evans@northstarapps.co.uk', 'employee', 'Platform Developer', NULL, 7, 'online', '2026-03-16 14:40:00', '2025-06-01 09:00:00', 'test', 1),
(31, 'Samuel', 'Foster', 'samuel.foster@northstarapps.co.uk', 'employee', 'Full Stack Developer', NULL, 7, 'offline', '2026-03-16 17:47:00', '2025-06-18 09:00:00', 'test', 1),
(32, 'Aria', 'Hughes', 'aria.hughes@northstarapps.co.uk', 'employee', 'SQL Developer', NULL, 8, 'busy', '2026-03-16 20:54:00', '2025-07-05 09:00:00', 'test', 1),
(33, 'William', 'Fisher', 'william.fisher@northstarapps.co.uk', 'employee', 'BI Developer', NULL, 8, 'offline', '2026-03-17 00:01:00', '2025-07-22 09:00:00', 'test', 1),
(34, 'Evie', 'Long', 'evie.long@northstarapps.co.uk', 'employee', 'Database Developer', NULL, 8, 'online', '2026-03-17 03:08:00', '2025-08-08 09:00:00', 'test', 1),
(35, 'George', 'Russell', 'george.russell@northstarapps.co.uk', 'employee', 'Reporting Analyst', NULL, 8, 'online', '2026-03-17 06:15:00', '2025-08-25 09:00:00', 'test', 1),
(36, 'Isla', 'Dixon', 'isla.dixon@northstarapps.co.uk', 'employee', 'CRM Analyst', NULL, 9, 'offline', '2026-03-17 08:32:00', '2025-09-11 09:00:00', 'test', 1),
(37, 'Mason', 'Carter', 'mason.carter@northstarapps.co.uk', 'employee', 'Sales Operations Analyst', NULL, 9, 'busy', '2026-03-17 11:39:00', '2025-09-28 09:00:00', 'test', 1),
(38, 'Poppy', 'Hughes', 'poppy.hughes@northstarapps.co.uk', 'employee', 'CRM Automation Specialist', NULL, 9, 'offline', '2026-03-17 14:46:00', '2025-10-15 09:00:00', 'test', 1),
(39, 'Arthur', 'Mason', 'arthur.mason@northstarapps.co.uk', 'employee', 'Client Systems Analyst', NULL, 9, 'online', '2026-03-17 17:53:00', '2025-11-01 09:00:00', 'test', 1),
(40, 'Niamh', 'Perry', 'niamh.perry@northstarapps.co.uk', 'employee', 'Sales Systems Coordinator', NULL, 9, 'online', '2026-03-15 09:00:00', '2025-11-18 09:00:00', 'test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Favourites`
--

CREATE TABLE `Favourites` (
  `employee_id` int NOT NULL,
  `favourited_employee_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Favourites`
--

INSERT INTO `Favourites` (`employee_id`, `favourited_employee_id`) VALUES
(2, 1),
(3, 1),
(4, 1),
(9, 1),
(1, 2),
(5, 2),
(7, 2),
(1, 3),
(6, 3),
(8, 3),
(1, 4),
(10, 4),
(2, 5),
(16, 5),
(3, 6),
(24, 6),
(28, 7),
(32, 8),
(4, 10),
(14, 10),
(10, 11),
(4, 13),
(5, 16),
(5, 19),
(6, 24),
(6, 26),
(7, 27),
(7, 30),
(8, 32),
(8, 34),
(9, 36);

-- --------------------------------------------------------

--
-- Table structure for table `Mentions`
--

CREATE TABLE `Mentions` (
  `message_id` int NOT NULL,
  `mentioned_user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Mentions`
--

INSERT INTO `Mentions` (`message_id`, `mentioned_user_id`) VALUES
(3, 4),
(16, 6),
(37, 7),
(25, 9),
(9, 17),
(46, 34);

-- --------------------------------------------------------

--
-- Table structure for table `Messages`
--

CREATE TABLE `Messages` (
  `message_id` int NOT NULL,
  `conversation_id` int DEFAULT NULL,
  `sender_id` int DEFAULT NULL,
  `parent_message_id` int DEFAULT NULL,
  `body` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `visibility` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Messages`
--

INSERT INTO `Messages` (`message_id`, `conversation_id`, `sender_id`, `parent_message_id`, `body`, `created_at`, `visibility`) VALUES
(1, 1, 4, NULL, 'Welcome to the new frontend sync chat, team!', '2026-03-01 09:05:00', 1),
(2, 1, 10, 1, 'Thanks Ethan! Glad to be here.', '2026-03-01 09:10:00', 1),
(3, 1, 13, NULL, '@Ethan, are the new UX wireframes from Grace ready for review?', '2026-03-02 14:00:00', 1),
(4, 1, 4, 3, 'Yes, I will pin them to this chat shortly.', '2026-03-02 14:05:00', 1),
(5, 1, 14, 3, 'Wireframes are good to go! Let me know if you need walkthroughs.', '2026-03-02 14:10:00', 1),
(6, 1, 15, NULL, 'Anyone else having issues with the local dev server today?', '2026-03-18 09:30:00', 1),
(7, 1, 11, 6, 'Yeah, clear your npm cache. Worked for me.', '2026-03-18 09:35:00', 1),
(8, 2, 5, NULL, 'Hey backend team, please review the latest API merge requests.', '2026-03-03 10:15:00', 1),
(9, 2, 16, 8, 'Looking at them now. @Jack, can you check the auth middleware?', '2026-03-03 10:20:00', 1),
(10, 2, 17, 9, 'On it. Give me 20 mins.', '2026-03-03 10:25:00', 1),
(11, 2, 19, NULL, 'I just deployed the new endpoints to staging.', '2026-03-04 16:00:00', 1),
(12, 2, 20, 11, 'Awesome, I will run the integration tests against them.', '2026-03-04 16:15:00', 1),
(13, 2, 21, NULL, 'Is the payment gateway webhook failing for anyone else in dev?', '2026-03-19 10:00:00', 1),
(14, 3, 6, NULL, 'Monthly data pipeline review at 3 PM today.', '2026-03-06 09:00:00', 1),
(15, 3, 24, 14, 'I have updated the ETL scripts for the new batch.', '2026-03-06 09:30:00', 1),
(16, 3, 26, NULL, '@Daniel, the ML models are retraining now. Results by tomorrow.', '2026-03-07 11:00:00', 1),
(17, 3, 23, NULL, 'Dashboard loading times have improved by 40% after the indexing update!', '2026-03-18 14:00:00', 1),
(18, 3, 25, 17, 'Great news. Good job team.', '2026-03-18 14:15:00', 1),
(19, 4, 1, NULL, 'Team, let us discuss Q2 OKRs.', '2026-03-10 08:05:00', 1),
(20, 4, 2, 19, 'Engineering OKRs are drafted. I will share the doc.', '2026-03-10 08:30:00', 1),
(21, 4, 3, 19, 'Delivery timelines might need adjustment based on staffing.', '2026-03-10 08:45:00', 1),
(22, 4, 1, NULL, 'Just uploaded the finalized Q2 OKR document.', '2026-03-19 11:00:00', 1),
(23, 5, 9, NULL, 'Kickoff for the new CRM workflows.', '2026-03-12 14:05:00', 1),
(24, 5, 36, 23, 'I have mapped out the current sales stages.', '2026-03-12 14:30:00', 1),
(25, 5, 38, NULL, '@Amelia, do we have sandbox access yet?', '2026-03-13 10:00:00', 1),
(26, 5, 40, NULL, 'Sales team requested an export feature for the new leads table.', '2026-03-18 16:00:00', 1),
(27, 6, 1, NULL, 'Marcus, can we review the backend team capacity?', '2026-03-14 09:35:00', 1),
(28, 6, 2, 27, 'Sure. Chloe is managing well, but we might need a senior hire.', '2026-03-14 10:00:00', 1),
(29, 6, 1, 28, 'Draft a job spec and I will approve the budget.', '2026-03-14 10:15:00', 1),
(30, 7, 4, NULL, 'Chloe, the frontend is hitting CORS errors on the new staging server.', '2026-03-15 10:05:00', 1),
(31, 7, 5, 30, 'My bad, I forgot to whitelist the new preview domains. Fixing now.', '2026-03-15 10:12:00', 1),
(32, 7, 4, 31, 'Awesome, works now. Thanks!', '2026-03-15 10:20:00', 1),
(33, 8, 3, NULL, 'Daniel, how are the data migration tests looking?', '2026-03-16 13:50:00', 1),
(34, 8, 6, 33, 'Pass rate is 98%. Just a few edge cases with legacy characters.', '2026-03-16 14:10:00', 1),
(35, 9, 2, NULL, 'Welcome to Project Apollo. This is our top priority for Q2.', '2026-03-17 09:05:00', 1),
(36, 9, 7, 35, 'Web platform is ready to scale up the infrastructure.', '2026-03-17 09:20:00', 1),
(37, 9, 27, NULL, '@Sophie, should we provision the AWS resources today?', '2026-03-17 09:45:00', 1),
(38, 9, 7, 37, 'Yes, let us start with the load balancers.', '2026-03-17 10:00:00', 1),
(39, 9, 2, NULL, 'Apollo kickoff meeting in 10 minutes, grab a coffee!', '2026-03-19 12:00:00', 1),
(40, 10, 7, NULL, 'Node version upgrade scheduled for this weekend.', '2026-03-17 11:05:00', 1),
(41, 10, 28, 40, 'Will there be any downtime for the internal tools?', '2026-03-17 11:15:00', 1),
(42, 10, 30, 41, 'Max 15 minutes around 2 AM Sunday.', '2026-03-17 11:30:00', 1),
(43, 11, 8, NULL, 'We have some slow queries bogging down the reporting dashboard.', '2026-03-18 10:25:00', 1),
(44, 11, 32, 43, 'I am looking at the execution plans now. Missing indexes on the sales tables.', '2026-03-18 10:40:00', 1),
(45, 11, 34, 44, 'I can write the migration script for those indexes.', '2026-03-18 11:00:00', 1),
(46, 11, 8, 45, 'Perfect. @Evie submit it for review by EOD.', '2026-03-18 11:15:00', 1),
(47, 12, 10, NULL, 'Did you manage to fix that weird CSS grid bug?', '2026-03-18 15:35:00', 1),
(48, 12, 11, 47, 'Yeah, turns out Safari handles `fr` units slightly differently.', '2026-03-18 15:45:00', 1),
(49, 12, 10, 48, 'Classic Safari. Thanks!', '2026-03-18 15:50:00', 1),
(50, 13, 14, NULL, 'Who is up for Thai food today?', '2026-03-18 11:45:00', 1),
(51, 13, 10, 50, 'Me! Meet in the lobby in 10?', '2026-03-18 11:50:00', 1),
(52, 13, 31, 50, 'Count me in. I need noodles.', '2026-03-18 11:52:00', 1),
(53, 14, 2, NULL, 'P1 Bug: Users cannot reset passwords on mobile.', '2026-03-18 09:05:00', 1),
(54, 14, 5, 53, 'Investigating the email sending service right now.', '2026-03-18 09:10:00', 1),
(55, 14, 16, 54, 'Looks like SendGrid API key expired. I am rotating it.', '2026-03-18 09:25:00', 1),
(56, 14, 2, 55, 'Great catch. Let me know when it is deployed.', '2026-03-18 09:30:00', 1),
(57, 15, 7, NULL, 'Benjamin, how is the responsive design looking on the tablet view?', '2026-03-15 14:05:00', 1),
(58, 15, 29, 57, 'Looking solid. Just tweaking some padding on the hero banner.', '2026-03-15 14:20:00', 1),
(59, 16, 1, NULL, 'Reminder: We are migrating to the new Kubernetes cluster next month.', '2026-02-15 09:05:00', 1),
(60, 16, 2, 59, 'The migration plan is mapped out in Jira.', '2026-02-15 09:30:00', 1),
(61, 16, 21, NULL, 'Do we have a staging environment for the new cluster yet?', '2026-03-10 11:00:00', 1),
(62, 17, 12, NULL, 'I have finalized the new color palette in Figma.', '2026-03-10 10:05:00', 1),
(63, 17, 14, 62, 'Looks much more modern! Love the new primary blue.', '2026-03-10 10:15:00', 1),
(64, 17, 10, 62, 'When can we start importing these into the CSS variables?', '2026-03-11 09:00:00', 1),
(65, 18, 26, NULL, 'Interesting paper on transformer models for time-series forecasting.', '2026-03-05 16:05:00', 1),
(66, 18, 6, 65, 'Can we apply this to the sales data prediction?', '2026-03-05 16:30:00', 1),
(67, 18, 22, 66, 'Potentially. I can run a quick POC in Python next week.', '2026-03-06 10:00:00', 1),
(68, 19, 8, NULL, 'George, the Q1 financial report query is timing out.', '2026-03-18 11:05:00', 1),
(69, 19, 35, 68, 'I will optimize the joins and run it async.', '2026-03-18 11:15:00', 1),
(70, 20, 1, NULL, 'Welcome to the new Northstar Apps internal chat! Please keep this channel for official updates only.', '2026-01-10 09:05:00', 1),
(71, 20, 1, NULL, 'Townhall meeting this Friday at 4 PM in the main conference room.', '2026-02-01 10:00:00', 1),
(72, 20, 1, NULL, 'Please remember to submit your expenses by end of day tomorrow.', '2026-03-10 14:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Message_Attachments`
--

CREATE TABLE `Message_Attachments` (
  `message_id` int NOT NULL,
  `attachment_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Message_Attachments`
--

INSERT INTO `Message_Attachments` (`message_id`, `attachment_id`) VALUES
(24, 1),
(22, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Message_Interactions`
--

CREATE TABLE `Message_Interactions` (
  `message_id` int NOT NULL,
  `user_id` int NOT NULL,
  `read_at` datetime DEFAULT NULL,
  `emoji` varchar(100) DEFAULT NULL,
  `reacted_at` datetime DEFAULT NULL,
  `bookmarked_at` datetime DEFAULT NULL,
  `pinned_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Message_Interactions`
--

INSERT INTO `Message_Interactions` (`message_id`, `user_id`, `read_at`, `emoji`, `reacted_at`, `bookmarked_at`, `pinned_at`) VALUES
(1, 10, '2026-03-01 09:15:00', '👋', '2026-03-01 09:15:00', NULL, NULL),
(1, 13, '2026-03-01 09:20:00', '👍', '2026-03-01 09:20:00', NULL, NULL),
(4, 13, '2026-03-02 14:15:00', '✅', '2026-03-02 14:15:00', NULL, '2026-03-02 14:15:00'),
(8, 16, '2026-03-03 10:18:00', '👀', '2026-03-03 10:18:00', NULL, NULL),
(8, 17, '2026-03-03 10:22:00', NULL, NULL, '2026-03-03 10:22:00', NULL),
(11, 5, '2026-03-04 16:10:00', '🚀', '2026-03-04 16:10:00', NULL, NULL),
(14, 24, '2026-03-06 09:10:00', '👍', '2026-03-06 09:10:00', NULL, NULL),
(19, 2, '2026-03-10 08:10:00', '✅', '2026-03-10 08:10:00', NULL, NULL),
(22, 2, '2026-03-19 11:05:00', '🔥', '2026-03-19 11:05:00', '2026-03-19 11:05:00', NULL),
(27, 2, '2026-03-14 09:40:00', '👀', '2026-03-14 09:40:00', NULL, NULL),
(32, 5, '2026-03-15 10:25:00', '❤️', '2026-03-15 10:25:00', NULL, NULL),
(35, 7, '2026-03-17 09:10:00', '🚀', '2026-03-17 09:10:00', NULL, '2026-03-17 09:15:00'),
(40, 28, '2026-03-17 11:10:00', '👀', '2026-03-17 11:10:00', '2026-03-17 11:10:00', NULL),
(43, 32, '2026-03-18 10:30:00', '🔍', '2026-03-18 10:30:00', NULL, NULL),
(46, 34, '2026-03-18 11:20:00', '✅', '2026-03-18 11:20:00', '2026-03-18 11:20:00', NULL),
(49, 11, '2026-03-18 15:55:00', '😂', '2026-03-18 15:55:00', NULL, NULL),
(50, 10, '2026-03-18 11:46:00', '🍜', '2026-03-18 11:46:00', NULL, NULL),
(53, 5, '2026-03-18 09:06:00', '😨', '2026-03-18 09:06:00', NULL, '2026-03-18 09:07:00'),
(62, 14, '2026-03-10 10:10:00', '🎨', '2026-03-10 10:10:00', NULL, NULL),
(70, 4, '2026-01-10 09:30:00', '👍', '2026-01-10 09:30:00', NULL, NULL),
(71, 10, '2026-02-01 10:15:00', '📅', '2026-02-01 10:15:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Notifications`
--

CREATE TABLE `Notifications` (
  `notification_id` int NOT NULL,
  `sender_id` int DEFAULT NULL,
  `receiver_id` int DEFAULT NULL,
  `priority` set('low','medium','high','urgent') DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `message` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Notifications`
--

INSERT INTO `Notifications` (`notification_id`, `sender_id`, `receiver_id`, `priority`, `is_read`, `title`, `message`, `created_at`) VALUES
(1, 13, 4, 'medium', 1, 'New Mention', 'Leo Price mentioned you in Frontend Team Sync.', '2026-03-24 14:50:01'),
(2, 16, 17, 'high', 1, 'New Mention', 'Ruby Turner mentioned you in Backend Core Platform.', '2026-03-24 00:00:00'),
(3, 26, 6, 'low', 1, 'New Mention', 'Emily Bennett mentioned you in Data & Analytics Hub.', '1900-01-01 00:00:00'),
(4, 38, 9, 'medium', 0, 'New Mention', 'Poppy Hughes mentioned you in CRM Automation Rollout.', '1900-01-06 14:50:19'),
(5, 27, 7, 'high', 1, 'New Mention', 'Lucas Gray mentioned you in Project Apollo Launch.', '1900-01-06 00:00:00'),
(6, 8, 34, 'high', 1, 'New Mention', 'Ryan Cooper mentioned you in SQL Performance Tuning.', '1900-01-13 00:00:00'),
(7, 1, 2, 'high', 1, 'Direct Message', 'Olivia Bennett sent you a direct message.', '1900-01-11 00:00:00'),
(8, 4, 5, 'medium', 1, 'Direct Message', 'Ethan Clarke sent you a direct message.', '1900-01-03 00:00:00'),
(9, 3, 6, 'high', 1, 'Direct Message', 'Priya Shah sent you a direct message.', '1900-01-15 00:00:00'),
(10, 10, 11, 'low', 1, 'Direct Message', 'Ava Thompson sent you a direct message.', '1900-01-17 00:00:00'),
(11, 1, 4, 'high', 0, 'Document Uploaded', 'Olivia Bennett uploaded Q2 OKR document in Management Sync.', '1900-01-12 00:00:00'),
(12, 2, 7, 'urgent', 0, 'Meeting Reminder', 'Project Apollo kickoff starts in 10 minutes.', '1900-01-25 00:00:00'),
(13, 2, 5, 'urgent', 1, 'System Alert', 'P1 Bug: Users cannot reset passwords on mobile.', '1900-01-09 00:00:00'),
(14, 7, 28, 'medium', 1, 'Downtime Notice', 'Web Platform Updates scheduled for weekend.', '1900-01-10 00:00:00'),
(15, 9, 36, 'low', 1, 'Group Added', 'Amelia Lewis added you to CRM Automation Rollout.', '1900-01-16 00:00:00'),
(16, 12, 10, 'low', 1, 'Group Added', 'Mia Foster added you to Design System V2.', '1900-01-24 00:00:00'),
(17, 26, 22, 'low', 1, 'Group Added', 'Emily Bennett added you to Machine Learning Research.', '1900-01-03 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `Projects`
--

CREATE TABLE `Projects` (
  `project_id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `status` set('On Time','Behind Schedule','Ahead of Schedule','At Risk') DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `summary` varchar(300) DEFAULT NULL,
  `milestone` varchar(100) DEFAULT NULL,
  `risk_level` set('Low','Medium','High','Urgent') DEFAULT NULL,
  `risk_desc` varchar(100) DEFAULT NULL,
  `teamleader_id` int DEFAULT NULL,
  `visibility` tinyint(1) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `conversation_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Projects`
--

INSERT INTO `Projects` (`project_id`, `name`, `status`, `start_date`, `due_date`, `summary`, `milestone`, `risk_level`, `risk_desc`, `teamleader_id`, `visibility`, `created_by`, `conversation_id`) VALUES
(1, 'Customer Portal Redesign', 'On Time', '2026-04-01 09:00:00', '2026-06-30 17:00:00', 'Refresh the self-service portal and simplify core support journeys.', 'Prototype approved', 'Medium', 'Auth sign-off still pending', 7, 1, 2, NULL),
(2, 'Field Sales Mobile UI Refresh', 'On Time', '2026-04-06 09:00:00', '2026-06-06 17:00:00', 'Refresh the sales mobile UI for faster quoting, notes and lead updates.', 'Mobile design aligned', 'Low', 'Device testing window is tight', 4, 1, 3, NULL),
(3, 'API Gateway Modernisation', 'At Risk', '2026-04-08 09:00:00', '2026-07-10 17:00:00', 'Modernise legacy endpoints behind a shared gateway with better observability.', 'Route inventory complete', 'High', 'Two legacy endpoints lack owners', 5, 1, 2, NULL),
(4, 'Inventory Reporting Dashboard', 'Behind Schedule', '2026-04-03 09:00:00', '2026-06-20 17:00:00', 'Build stock and replenishment reporting for operations managers.', 'KPI list agreed', 'Medium', 'Historic stock data needs cleansing', 8, 1, 1, NULL),
(5, 'Sales Pipeline Automation', 'On Time', '2026-04-10 09:00:00', '2026-07-01 17:00:00', 'Automate lead routing, reminders and sales handoff steps.', 'Workflow mapped', 'Medium', 'Training content needs early review', 9, 1, 1, NULL),
(6, 'Analytics ETL Upgrade', 'Ahead of Schedule', '2026-04-14 09:00:00', '2026-07-18 17:00:00', 'Refactor analytics ingestion for better reliability and scale.', 'Staging pipeline drafted', 'Low', 'Warehouse credentials need refresh', 6, 1, 2, NULL),
(7, 'Knowledge Base Search', 'On Time', '2026-04-16 09:00:00', '2026-06-28 17:00:00', 'Improve internal search with better indexing, filters and ranking.', 'Search scope signed off', 'Medium', 'Tagging standards are inconsistent', 7, 1, 3, NULL),
(8, 'Internal Timesheet App', 'On Time', '2026-04-20 09:00:00', '2026-06-24 17:00:00', 'Build a lightweight internal app for time entry and approvals.', 'MVP workflow agreed', 'Low', 'Approval edge cases still being captured', 7, 1, 1, NULL),
(9, 'Database Performance Tuning', 'At Risk', '2026-04-22 09:00:00', '2026-06-18 17:00:00', 'Tune slow queries, indexing and archival patterns for reporting data.', 'Slow query list confirmed', 'High', 'Some production plans are outdated', 8, 1, 2, NULL),
(10, 'Notification Service Rollout', 'On Time', '2026-04-24 09:00:00', '2026-07-05 17:00:00', 'Roll out shared alerts and reminder handling across key products.', 'Event catalogue reviewed', 'Medium', 'Template ownership is shared', 5, 1, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Project_Assignment`
--

CREATE TABLE `Project_Assignment` (
  `project_id` int NOT NULL,
  `employee_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Project_Assignment`
--

INSERT INTO `Project_Assignment` (`project_id`, `employee_id`) VALUES
(4, 1),
(5, 1),
(8, 1),
(3, 2),
(6, 2),
(9, 2),
(2, 3),
(7, 3),
(10, 3),
(1, 4),
(2, 4),
(3, 5),
(10, 5),
(3, 6),
(6, 6),
(1, 7),
(7, 7),
(8, 7),
(4, 8),
(9, 8),
(2, 9),
(5, 9),
(1, 10),
(7, 10),
(1, 11),
(8, 11),
(2, 12),
(7, 12),
(2, 13),
(8, 13),
(2, 14),
(8, 14),
(2, 15),
(1, 16),
(9, 16),
(3, 17),
(3, 18),
(9, 18),
(3, 19),
(10, 19),
(3, 20),
(7, 20),
(10, 20),
(7, 21),
(8, 21),
(3, 22),
(6, 22),
(4, 23),
(6, 23),
(4, 24),
(6, 24),
(9, 24),
(4, 25),
(6, 25),
(6, 26),
(7, 26),
(1, 27),
(7, 27),
(1, 28),
(8, 28),
(2, 29),
(7, 29),
(2, 30),
(3, 30),
(5, 31),
(10, 31),
(4, 32),
(9, 32),
(4, 33),
(6, 33),
(9, 33),
(4, 34),
(6, 34),
(9, 34),
(5, 35),
(8, 35),
(9, 35),
(1, 36),
(5, 36),
(10, 36),
(4, 37),
(5, 37),
(5, 38),
(10, 38),
(1, 39),
(5, 39),
(10, 39),
(5, 40),
(8, 40),
(10, 40);

-- --------------------------------------------------------

--
-- Table structure for table `Project_Budget_Transactions`
--

CREATE TABLE `Project_Budget_Transactions` (
  `transaction_id` int NOT NULL,
  `project_id` int NOT NULL,
  `transaction_type` enum('allocation','adjustment_increase','adjustment_decrease','expense','refund') NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `description` text,
  `receipt_path` varchar(255) DEFAULT NULL,
  `transaction_date` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `Tasks`
--

CREATE TABLE `Tasks` (
  `task_id` int NOT NULL,
  `project_id` int DEFAULT NULL,
  `assigner_id` int DEFAULT NULL,
  `assignee_id` int DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `status` set('Not Started','In Progress','Awaiting Validation','Completed') DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `priority` set('High','Medium','Low') DEFAULT NULL,
  `estimated_effort` set('XS','S','M','L','XL') DEFAULT NULL,
  `task_type` set('project','private') DEFAULT NULL,
  `started_date` datetime DEFAULT NULL,
  `submitted_date` datetime DEFAULT NULL,
  `completed_date` datetime DEFAULT NULL,
  `completion_wait_time` time DEFAULT NULL,
  `completed_by_id` int DEFAULT NULL,
  `visibility` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Tasks`
--

INSERT INTO `Tasks` (`task_id`, `project_id`, `assigner_id`, `assignee_id`, `title`, `description`, `status`, `created_date`, `due_date`, `priority`, `estimated_effort`, `task_type`, `started_date`, `submitted_date`, `completed_date`, `completion_wait_time`, `completed_by_id`, `visibility`) VALUES
(1, 1, 7, 4, 'Plan portal backlog', 'Break the next sprint for the Customer Portal Redesign into clear work items.', 'Not Started', '2026-04-03 09:00:00', '2026-04-21 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(2, 1, 7, 4, 'Assign portal work', 'Assign role-based work and balance capacity for the Customer Portal Redesign.', 'Not Started', '2026-04-04 09:00:00', '2026-04-27 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(3, 1, 7, 4, 'Review portal design', 'Review the planned design approach for the Customer Portal Redesign.', 'Not Started', '2026-04-05 09:00:00', '2026-05-03 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(4, 1, 7, 4, 'Resolve portal blockers', 'Log blockers and escalation needs for the Customer Portal Redesign.', 'Not Started', '2026-04-06 09:00:00', '2026-05-09 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(5, 1, 7, 4, 'Prep portal review', 'Prepare the sprint review and demo checklist for the Customer Portal Redesign.', 'Not Started', '2026-04-07 09:00:00', '2026-05-15 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(6, 1, 2, 7, 'Plan portal backlog', 'Break the next sprint for the Customer Portal Redesign into clear work items.', 'Not Started', '2026-04-03 09:00:00', '2026-04-24 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(7, 1, 2, 7, 'Assign portal work', 'Assign role-based work and balance capacity for the Customer Portal Redesign.', 'Not Started', '2026-04-04 09:00:00', '2026-04-30 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(8, 1, 2, 7, 'Review portal design', 'Review the planned design approach for the Customer Portal Redesign.', 'Not Started', '2026-04-05 09:00:00', '2026-05-06 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(9, 1, 2, 7, 'Resolve portal blockers', 'Log blockers and escalation needs for the Customer Portal Redesign.', 'Not Started', '2026-04-06 09:00:00', '2026-05-12 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(10, 1, 2, 7, 'Prep portal review', 'Prepare the sprint review and demo checklist for the Customer Portal Redesign.', 'Not Started', '2026-04-07 09:00:00', '2026-05-18 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(11, 1, 7, 10, 'Design portal states', 'Sketch key UI states needed for the Customer Portal Redesign.', 'Not Started', '2026-04-03 09:00:00', '2026-04-23 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(12, 1, 7, 10, 'Build portal components', 'Build the reusable UI pieces for the Customer Portal Redesign.', 'Not Started', '2026-04-04 09:00:00', '2026-04-29 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(13, 1, 7, 10, 'Hook portal API', 'Connect agreed API calls for the Customer Portal Redesign.', 'Not Started', '2026-04-05 09:00:00', '2026-05-05 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(14, 1, 7, 10, 'QA portal flows', 'Check responsive flows and states for the Customer Portal Redesign.', 'Not Started', '2026-04-06 09:00:00', '2026-05-11 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(15, 1, 7, 10, 'Update portal notes', 'Document UI assumptions for the Customer Portal Redesign.', 'Not Started', '2026-04-07 09:00:00', '2026-05-17 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(16, 1, 7, 11, 'Design portal states', 'Sketch key UI states needed for the Customer Portal Redesign.', 'Not Started', '2026-04-04 09:00:00', '2026-04-24 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(17, 1, 7, 11, 'Build portal components', 'Build the reusable UI pieces for the Customer Portal Redesign.', 'Not Started', '2026-04-05 09:00:00', '2026-04-30 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(18, 1, 7, 11, 'Hook portal API', 'Connect agreed API calls for the Customer Portal Redesign.', 'Not Started', '2026-04-06 09:00:00', '2026-05-06 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(19, 1, 7, 11, 'QA portal flows', 'Check responsive flows and states for the Customer Portal Redesign.', 'Not Started', '2026-04-07 09:00:00', '2026-05-12 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(20, 1, 7, 11, 'Update portal notes', 'Document UI assumptions for the Customer Portal Redesign.', 'Not Started', '2026-04-08 09:00:00', '2026-05-18 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(21, 1, 7, 16, 'Draft portal API', 'Define the API contract and rules for the Customer Portal Redesign.', 'Not Started', '2026-04-03 09:00:00', '2026-04-21 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(22, 1, 7, 16, 'Build portal service', 'Implement the service layer for the Customer Portal Redesign.', 'Not Started', '2026-04-04 09:00:00', '2026-04-27 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(23, 1, 7, 16, 'Test portal integration', 'Write integration checks for the Customer Portal Redesign.', 'Not Started', '2026-04-05 09:00:00', '2026-05-03 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(24, 1, 7, 16, 'Refine portal errors', 'Refine error handling for the Customer Portal Redesign.', 'Not Started', '2026-04-06 09:00:00', '2026-05-09 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(25, 1, 7, 16, 'Document portal endpoints', 'Document service endpoints for the Customer Portal Redesign.', 'Not Started', '2026-04-07 09:00:00', '2026-05-15 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(26, 1, 7, 27, 'Plan portal pages', 'Plan the page flow for the Customer Portal Redesign.', 'Not Started', '2026-04-02 09:00:00', '2026-04-24 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(27, 1, 7, 27, 'Build portal views', 'Build the web views for the Customer Portal Redesign.', 'Not Started', '2026-04-03 09:00:00', '2026-04-30 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(28, 1, 7, 27, 'Wire portal forms', 'Wire shared forms for the Customer Portal Redesign.', 'Not Started', '2026-04-04 09:00:00', '2026-05-06 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(29, 1, 7, 27, 'Test portal access', 'Test access paths for the Customer Portal Redesign.', 'Not Started', '2026-04-05 09:00:00', '2026-05-12 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(30, 1, 7, 27, 'Note portal release', 'Note release checks for the Customer Portal Redesign.', 'Not Started', '2026-04-06 09:00:00', '2026-05-18 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(31, 1, 7, 28, 'Plan portal pages', 'Plan the page flow for the Customer Portal Redesign.', 'Not Started', '2026-04-03 09:00:00', '2026-04-21 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(32, 1, 7, 28, 'Build portal views', 'Build the web views for the Customer Portal Redesign.', 'Not Started', '2026-04-04 09:00:00', '2026-04-27 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(33, 1, 7, 28, 'Wire portal forms', 'Wire shared forms for the Customer Portal Redesign.', 'Not Started', '2026-04-05 09:00:00', '2026-05-03 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(34, 1, 7, 28, 'Test portal access', 'Test access paths for the Customer Portal Redesign.', 'Not Started', '2026-04-06 09:00:00', '2026-05-09 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(35, 1, 7, 28, 'Note portal release', 'Note release checks for the Customer Portal Redesign.', 'Not Started', '2026-04-07 09:00:00', '2026-05-15 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(36, 1, 7, 36, 'Map portal flow', 'Map the business flow for the Customer Portal Redesign.', 'Not Started', '2026-04-02 09:00:00', '2026-04-21 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(37, 1, 7, 36, 'Review portal scenarios', 'Review user scenarios for the Customer Portal Redesign.', 'Not Started', '2026-04-03 09:00:00', '2026-04-27 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(38, 1, 7, 36, 'Prepare portal training', 'Prepare training notes for the Customer Portal Redesign.', 'Not Started', '2026-04-04 09:00:00', '2026-05-03 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(39, 1, 7, 36, 'Check portal rules', 'Check business rules for the Customer Portal Redesign.', 'Not Started', '2026-04-05 09:00:00', '2026-05-09 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(40, 1, 7, 36, 'Update portal rollout', 'Update rollout notes for the Customer Portal Redesign.', 'Not Started', '2026-04-06 09:00:00', '2026-05-15 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(41, 1, 7, 39, 'Map portal flow', 'Map the business flow for the Customer Portal Redesign.', 'Not Started', '2026-04-02 09:00:00', '2026-04-24 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(42, 1, 7, 39, 'Review portal scenarios', 'Review user scenarios for the Customer Portal Redesign.', 'Not Started', '2026-04-03 09:00:00', '2026-04-30 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(43, 1, 7, 39, 'Prepare portal training', 'Prepare training notes for the Customer Portal Redesign.', 'Not Started', '2026-04-04 09:00:00', '2026-05-06 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(44, 1, 7, 39, 'Check portal rules', 'Check business rules for the Customer Portal Redesign.', 'Not Started', '2026-04-05 09:00:00', '2026-05-12 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(45, 1, 7, 39, 'Update portal rollout', 'Update rollout notes for the Customer Portal Redesign.', 'Not Started', '2026-04-06 09:00:00', '2026-05-18 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(46, 2, 4, 3, 'Approve mobile UI scope', 'Approve scope and success measures for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-07 09:00:00', '2026-04-29 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(47, 2, 4, 3, 'Review mobile UI risk', 'Review delivery risk and open dependencies for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-08 09:00:00', '2026-05-05 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(48, 2, 4, 3, 'Align mobile UI stakeholders', 'Align stakeholders and decision points for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-09 09:00:00', '2026-05-11 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(49, 2, 4, 3, 'Confirm mobile UI plan', 'Confirm milestones and checkpoints for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-10 09:00:00', '2026-05-17 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(50, 2, 4, 3, 'Status update: mobile UI', 'Prepare the weekly status update for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-11 09:00:00', '2026-05-23 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(51, 2, 3, 4, 'Plan mobile UI backlog', 'Break the next sprint for the Field Sales Mobile UI Refresh into clear work items.', 'Not Started', '2026-04-08 09:00:00', '2026-04-26 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(52, 2, 3, 4, 'Assign mobile UI work', 'Assign role-based work and balance capacity for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-09 09:00:00', '2026-05-02 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(53, 2, 3, 4, 'Review mobile UI design', 'Review the planned design approach for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-10 09:00:00', '2026-05-08 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(54, 2, 3, 4, 'Resolve mobile UI blockers', 'Log blockers and escalation needs for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-11 09:00:00', '2026-05-14 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(55, 2, 3, 4, 'Prep mobile UI review', 'Prepare the sprint review and demo checklist for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-12 09:00:00', '2026-05-20 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(56, 2, 4, 9, 'Plan mobile UI backlog', 'Break the next sprint for the Field Sales Mobile UI Refresh into clear work items.', 'Not Started', '2026-04-07 09:00:00', '2026-04-27 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(57, 2, 4, 9, 'Assign mobile UI work', 'Assign role-based work and balance capacity for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-08 09:00:00', '2026-05-03 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(58, 2, 4, 9, 'Review mobile UI design', 'Review the planned design approach for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-09 09:00:00', '2026-05-09 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(59, 2, 4, 9, 'Resolve mobile UI blockers', 'Log blockers and escalation needs for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-10 09:00:00', '2026-05-15 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(60, 2, 4, 9, 'Prep mobile UI review', 'Prepare the sprint review and demo checklist for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-11 09:00:00', '2026-05-21 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(61, 2, 4, 12, 'Design mobile UI states', 'Sketch key UI states needed for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-07 09:00:00', '2026-04-26 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(62, 2, 4, 12, 'Build mobile UI components', 'Build the reusable UI pieces for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-08 09:00:00', '2026-05-02 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(63, 2, 4, 12, 'Hook mobile UI API', 'Connect agreed API calls for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-09 09:00:00', '2026-05-08 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(64, 2, 4, 12, 'QA mobile UI flows', 'Check responsive flows and states for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-10 09:00:00', '2026-05-14 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(65, 2, 4, 12, 'Update mobile UI notes', 'Document UI assumptions for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-11 09:00:00', '2026-05-20 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(66, 2, 4, 13, 'Design mobile UI states', 'Sketch key UI states needed for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-08 09:00:00', '2026-04-27 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(67, 2, 4, 13, 'Build mobile UI components', 'Build the reusable UI pieces for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-09 09:00:00', '2026-05-03 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(68, 2, 4, 13, 'Hook mobile UI API', 'Connect agreed API calls for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-10 09:00:00', '2026-05-09 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(69, 2, 4, 13, 'QA mobile UI flows', 'Check responsive flows and states for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-11 09:00:00', '2026-05-15 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(70, 2, 4, 13, 'Update mobile UI notes', 'Document UI assumptions for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-12 09:00:00', '2026-05-21 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(71, 2, 4, 14, 'Design mobile UI states', 'Sketch key UI states needed for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-09 09:00:00', '2026-04-28 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(72, 2, 4, 14, 'Build mobile UI components', 'Build the reusable UI pieces for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-10 09:00:00', '2026-05-04 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(73, 2, 4, 14, 'Hook mobile UI API', 'Connect agreed API calls for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-11 09:00:00', '2026-05-10 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(74, 2, 4, 14, 'QA mobile UI flows', 'Check responsive flows and states for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-12 09:00:00', '2026-05-16 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(75, 2, 4, 14, 'Update mobile UI notes', 'Document UI assumptions for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-13 09:00:00', '2026-05-22 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(76, 2, 4, 15, 'Design mobile UI states', 'Sketch key UI states needed for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-07 09:00:00', '2026-04-29 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(77, 2, 4, 15, 'Build mobile UI components', 'Build the reusable UI pieces for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-08 09:00:00', '2026-05-05 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(78, 2, 4, 15, 'Hook mobile UI API', 'Connect agreed API calls for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-09 09:00:00', '2026-05-11 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(79, 2, 4, 15, 'QA mobile UI flows', 'Check responsive flows and states for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-10 09:00:00', '2026-05-17 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(80, 2, 4, 15, 'Update mobile UI notes', 'Document UI assumptions for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-11 09:00:00', '2026-05-23 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(81, 2, 4, 29, 'Plan mobile UI pages', 'Plan the page flow for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-09 09:00:00', '2026-04-27 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(82, 2, 4, 29, 'Build mobile UI views', 'Build the web views for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-10 09:00:00', '2026-05-03 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(83, 2, 4, 29, 'Wire mobile UI forms', 'Wire shared forms for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-11 09:00:00', '2026-05-09 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(84, 2, 4, 29, 'Test mobile UI access', 'Test access paths for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-12 09:00:00', '2026-05-15 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(85, 2, 4, 29, 'Note mobile UI release', 'Note release checks for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-13 09:00:00', '2026-05-21 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(86, 2, 4, 30, 'Plan mobile UI pages', 'Plan the page flow for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-07 09:00:00', '2026-04-28 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(87, 2, 4, 30, 'Build mobile UI views', 'Build the web views for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-08 09:00:00', '2026-05-04 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(88, 2, 4, 30, 'Wire mobile UI forms', 'Wire shared forms for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-09 09:00:00', '2026-05-10 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(89, 2, 4, 30, 'Test mobile UI access', 'Test access paths for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-10 09:00:00', '2026-05-16 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(90, 2, 4, 30, 'Note mobile UI release', 'Note release checks for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-11 09:00:00', '2026-05-22 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(91, 3, 5, 2, 'Approve gateway scope', 'Approve scope and success measures for the API Gateway Modernisation.', 'Not Started', '2026-04-11 09:00:00', '2026-04-30 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(92, 3, 5, 2, 'Review gateway risk', 'Review delivery risk and open dependencies for the API Gateway Modernisation.', 'Not Started', '2026-04-12 09:00:00', '2026-05-06 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(93, 3, 5, 2, 'Align gateway stakeholders', 'Align stakeholders and decision points for the API Gateway Modernisation.', 'Not Started', '2026-04-13 09:00:00', '2026-05-12 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(94, 3, 5, 2, 'Confirm gateway plan', 'Confirm milestones and checkpoints for the API Gateway Modernisation.', 'Not Started', '2026-04-14 09:00:00', '2026-05-18 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(95, 3, 5, 2, 'Status update: gateway', 'Prepare the weekly status update for the API Gateway Modernisation.', 'Not Started', '2026-04-15 09:00:00', '2026-05-24 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(96, 3, 2, 5, 'Plan gateway backlog', 'Break the next sprint for the API Gateway Modernisation into clear work items.', 'Not Started', '2026-04-11 09:00:00', '2026-04-29 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(97, 3, 2, 5, 'Assign gateway work', 'Assign role-based work and balance capacity for the API Gateway Modernisation.', 'Not Started', '2026-04-12 09:00:00', '2026-05-05 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(98, 3, 2, 5, 'Review gateway design', 'Review the planned design approach for the API Gateway Modernisation.', 'Not Started', '2026-04-13 09:00:00', '2026-05-11 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(99, 3, 2, 5, 'Resolve gateway blockers', 'Log blockers and escalation needs for the API Gateway Modernisation.', 'Not Started', '2026-04-14 09:00:00', '2026-05-17 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(100, 3, 2, 5, 'Prep gateway review', 'Prepare the sprint review and demo checklist for the API Gateway Modernisation.', 'Not Started', '2026-04-15 09:00:00', '2026-05-23 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(101, 3, 5, 6, 'Plan gateway backlog', 'Break the next sprint for the API Gateway Modernisation into clear work items.', 'Not Started', '2026-04-09 09:00:00', '2026-04-30 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(102, 3, 5, 6, 'Assign gateway work', 'Assign role-based work and balance capacity for the API Gateway Modernisation.', 'Not Started', '2026-04-10 09:00:00', '2026-05-06 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(103, 3, 5, 6, 'Review gateway design', 'Review the planned design approach for the API Gateway Modernisation.', 'Not Started', '2026-04-11 09:00:00', '2026-05-12 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(104, 3, 5, 6, 'Resolve gateway blockers', 'Log blockers and escalation needs for the API Gateway Modernisation.', 'Not Started', '2026-04-12 09:00:00', '2026-05-18 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(105, 3, 5, 6, 'Prep gateway review', 'Prepare the sprint review and demo checklist for the API Gateway Modernisation.', 'Not Started', '2026-04-13 09:00:00', '2026-05-24 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(106, 3, 5, 17, 'Draft gateway API', 'Define the API contract and rules for the API Gateway Modernisation.', 'Not Started', '2026-04-11 09:00:00', '2026-04-29 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(107, 3, 5, 17, 'Build gateway service', 'Implement the service layer for the API Gateway Modernisation.', 'Not Started', '2026-04-12 09:00:00', '2026-05-05 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(108, 3, 5, 17, 'Test gateway integration', 'Write integration checks for the API Gateway Modernisation.', 'Not Started', '2026-04-13 09:00:00', '2026-05-11 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(109, 3, 5, 17, 'Refine gateway errors', 'Refine error handling for the API Gateway Modernisation.', 'Not Started', '2026-04-14 09:00:00', '2026-05-17 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(110, 3, 5, 17, 'Document gateway endpoints', 'Document service endpoints for the API Gateway Modernisation.', 'Not Started', '2026-04-15 09:00:00', '2026-05-23 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(111, 3, 5, 18, 'Draft gateway API', 'Define the API contract and rules for the API Gateway Modernisation.', 'Not Started', '2026-04-09 09:00:00', '2026-04-30 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(112, 3, 5, 18, 'Build gateway service', 'Implement the service layer for the API Gateway Modernisation.', 'Not Started', '2026-04-10 09:00:00', '2026-05-06 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(113, 3, 5, 18, 'Test gateway integration', 'Write integration checks for the API Gateway Modernisation.', 'Not Started', '2026-04-11 09:00:00', '2026-05-12 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(114, 3, 5, 18, 'Refine gateway errors', 'Refine error handling for the API Gateway Modernisation.', 'Not Started', '2026-04-12 09:00:00', '2026-05-18 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(115, 3, 5, 18, 'Document gateway endpoints', 'Document service endpoints for the API Gateway Modernisation.', 'Not Started', '2026-04-13 09:00:00', '2026-05-24 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(116, 3, 5, 19, 'Draft gateway API', 'Define the API contract and rules for the API Gateway Modernisation.', 'Not Started', '2026-04-10 09:00:00', '2026-05-01 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(117, 3, 5, 19, 'Build gateway service', 'Implement the service layer for the API Gateway Modernisation.', 'Not Started', '2026-04-11 09:00:00', '2026-05-07 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(118, 3, 5, 19, 'Test gateway integration', 'Write integration checks for the API Gateway Modernisation.', 'Not Started', '2026-04-12 09:00:00', '2026-05-13 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(119, 3, 5, 19, 'Refine gateway errors', 'Refine error handling for the API Gateway Modernisation.', 'Not Started', '2026-04-13 09:00:00', '2026-05-19 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(120, 3, 5, 19, 'Document gateway endpoints', 'Document service endpoints for the API Gateway Modernisation.', 'Not Started', '2026-04-14 09:00:00', '2026-05-25 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(121, 3, 5, 20, 'Draft gateway API', 'Define the API contract and rules for the API Gateway Modernisation.', 'Not Started', '2026-04-11 09:00:00', '2026-04-28 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(122, 3, 5, 20, 'Build gateway service', 'Implement the service layer for the API Gateway Modernisation.', 'Not Started', '2026-04-12 09:00:00', '2026-05-04 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(123, 3, 5, 20, 'Test gateway integration', 'Write integration checks for the API Gateway Modernisation.', 'Not Started', '2026-04-13 09:00:00', '2026-05-10 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(124, 3, 5, 20, 'Refine gateway errors', 'Refine error handling for the API Gateway Modernisation.', 'Not Started', '2026-04-14 09:00:00', '2026-05-16 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(125, 3, 5, 20, 'Document gateway endpoints', 'Document service endpoints for the API Gateway Modernisation.', 'Not Started', '2026-04-15 09:00:00', '2026-05-22 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(126, 3, 5, 22, 'Map gateway data', 'Map source fields and transforms for the API Gateway Modernisation.', 'Not Started', '2026-04-10 09:00:00', '2026-04-30 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(127, 3, 5, 22, 'Build gateway ETL', 'Build the core ETL job for the API Gateway Modernisation.', 'Not Started', '2026-04-11 09:00:00', '2026-05-06 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(128, 3, 5, 22, 'Validate gateway source', 'Validate source data and schema for the API Gateway Modernisation.', 'Not Started', '2026-04-12 09:00:00', '2026-05-12 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(129, 3, 5, 22, 'Prep gateway checks', 'Prepare data quality checks for the API Gateway Modernisation.', 'Not Started', '2026-04-13 09:00:00', '2026-05-18 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(130, 3, 5, 22, 'Document gateway pipeline', 'Document the pipeline flow for the API Gateway Modernisation.', 'Not Started', '2026-04-14 09:00:00', '2026-05-24 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(131, 3, 5, 30, 'Plan gateway pages', 'Plan the page flow for the API Gateway Modernisation.', 'Not Started', '2026-04-09 09:00:00', '2026-04-30 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(132, 3, 5, 30, 'Build gateway views', 'Build the web views for the API Gateway Modernisation.', 'Not Started', '2026-04-10 09:00:00', '2026-05-06 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(133, 3, 5, 30, 'Wire gateway forms', 'Wire shared forms for the API Gateway Modernisation.', 'Not Started', '2026-04-11 09:00:00', '2026-05-12 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(134, 3, 5, 30, 'Test gateway access', 'Test access paths for the API Gateway Modernisation.', 'Not Started', '2026-04-12 09:00:00', '2026-05-18 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(135, 3, 5, 30, 'Note gateway release', 'Note release checks for the API Gateway Modernisation.', 'Not Started', '2026-04-13 09:00:00', '2026-05-24 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(136, 4, 8, 1, 'Approve inventory dashboard scope', 'Approve scope and success measures for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-05 09:00:00', '2026-04-24 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(137, 4, 8, 1, 'Review inventory dashboard risk', 'Review delivery risk and open dependencies for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-06 09:00:00', '2026-04-30 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(138, 4, 8, 1, 'Align inventory dashboard stakeholders', 'Align stakeholders and decision points for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-07 09:00:00', '2026-05-06 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(139, 4, 8, 1, 'Confirm inventory dashboard plan', 'Confirm milestones and checkpoints for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-08 09:00:00', '2026-05-12 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(140, 4, 8, 1, 'Status update: inventory dashboard', 'Prepare the weekly status update for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-09 09:00:00', '2026-05-18 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(141, 4, 1, 8, 'Plan inventory dashboard backlog', 'Break the next sprint for the Inventory Reporting Dashboard into clear work items.', 'Not Started', '2026-04-06 09:00:00', '2026-04-23 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(142, 4, 1, 8, 'Assign inventory dashboard work', 'Assign role-based work and balance capacity for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-07 09:00:00', '2026-04-29 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(143, 4, 1, 8, 'Review inventory dashboard design', 'Review the planned design approach for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-08 09:00:00', '2026-05-05 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(144, 4, 1, 8, 'Resolve inventory dashboard blockers', 'Log blockers and escalation needs for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-09 09:00:00', '2026-05-11 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(145, 4, 1, 8, 'Prep inventory dashboard review', 'Prepare the sprint review and demo checklist for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-10 09:00:00', '2026-05-17 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(146, 4, 8, 23, 'Map inventory dashboard data', 'Map source fields and transforms for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-06 09:00:00', '2026-04-26 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(147, 4, 8, 23, 'Build inventory dashboard ETL', 'Build the core ETL job for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-07 09:00:00', '2026-05-02 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(148, 4, 8, 23, 'Validate inventory dashboard source', 'Validate source data and schema for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-08 09:00:00', '2026-05-08 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(149, 4, 8, 23, 'Prep inventory dashboard checks', 'Prepare data quality checks for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-09 09:00:00', '2026-05-14 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(150, 4, 8, 23, 'Document inventory dashboard pipeline', 'Document the pipeline flow for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-10 09:00:00', '2026-05-20 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(151, 4, 8, 24, 'Map inventory dashboard data', 'Map source fields and transforms for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-04 09:00:00', '2026-04-23 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(152, 4, 8, 24, 'Build inventory dashboard ETL', 'Build the core ETL job for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-05 09:00:00', '2026-04-29 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(153, 4, 8, 24, 'Validate inventory dashboard source', 'Validate source data and schema for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-06 09:00:00', '2026-05-05 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(154, 4, 8, 24, 'Prep inventory dashboard checks', 'Prepare data quality checks for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-07 09:00:00', '2026-05-11 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(155, 4, 8, 24, 'Document inventory dashboard pipeline', 'Document the pipeline flow for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-08 09:00:00', '2026-05-17 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(156, 4, 8, 25, 'Map inventory dashboard data', 'Map source fields and transforms for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-05 09:00:00', '2026-04-24 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(157, 4, 8, 25, 'Build inventory dashboard ETL', 'Build the core ETL job for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-06 09:00:00', '2026-04-30 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(158, 4, 8, 25, 'Validate inventory dashboard source', 'Validate source data and schema for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-07 09:00:00', '2026-05-06 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(159, 4, 8, 25, 'Prep inventory dashboard checks', 'Prepare data quality checks for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-08 09:00:00', '2026-05-12 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(160, 4, 8, 25, 'Document inventory dashboard pipeline', 'Document the pipeline flow for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-09 09:00:00', '2026-05-18 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(161, 4, 8, 32, 'Model inventory dashboard schema', 'Model schema changes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-06 09:00:00', '2026-04-23 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(162, 4, 8, 32, 'Write inventory dashboard SQL', 'Write SQL changes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-07 09:00:00', '2026-04-29 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(163, 4, 8, 32, 'Tune inventory dashboard queries', 'Review indexes and query paths for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-08 09:00:00', '2026-05-05 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(164, 4, 8, 32, 'Prep inventory dashboard validation', 'Prepare validation queries for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-09 09:00:00', '2026-05-11 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(165, 4, 8, 32, 'Document inventory dashboard rules', 'Document joins and rules for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-10 09:00:00', '2026-05-17 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(166, 4, 8, 33, 'Model inventory dashboard schema', 'Model schema changes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-04 09:00:00', '2026-04-24 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(167, 4, 8, 33, 'Write inventory dashboard SQL', 'Write SQL changes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-05 09:00:00', '2026-04-30 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(168, 4, 8, 33, 'Tune inventory dashboard queries', 'Review indexes and query paths for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-06 09:00:00', '2026-05-06 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(169, 4, 8, 33, 'Prep inventory dashboard validation', 'Prepare validation queries for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-07 09:00:00', '2026-05-12 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(170, 4, 8, 33, 'Document inventory dashboard rules', 'Document joins and rules for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-08 09:00:00', '2026-05-18 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(171, 4, 8, 34, 'Map inventory dashboard data', 'Map source fields and transforms for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-05 09:00:00', '2026-04-25 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(172, 4, 8, 34, 'Build inventory dashboard ETL', 'Build the core ETL job for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-06 09:00:00', '2026-05-01 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(173, 4, 8, 34, 'Validate inventory dashboard source', 'Validate source data and schema for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-07 09:00:00', '2026-05-07 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(174, 4, 8, 34, 'Prep inventory dashboard checks', 'Prepare data quality checks for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-08 09:00:00', '2026-05-13 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(175, 4, 8, 34, 'Document inventory dashboard pipeline', 'Document the pipeline flow for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-09 09:00:00', '2026-05-19 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(176, 4, 8, 37, 'Map inventory dashboard flow', 'Map the business flow for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-05 09:00:00', '2026-04-24 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(177, 4, 8, 37, 'Review inventory dashboard scenarios', 'Review user scenarios for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-06 09:00:00', '2026-04-30 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(178, 4, 8, 37, 'Prepare inventory dashboard training', 'Prepare training notes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-07 09:00:00', '2026-05-06 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(179, 4, 8, 37, 'Check inventory dashboard rules', 'Check business rules for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-08 09:00:00', '2026-05-12 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(180, 4, 8, 37, 'Update inventory dashboard rollout', 'Update rollout notes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-09 09:00:00', '2026-05-18 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(181, 5, 9, 1, 'Approve sales automation scope', 'Approve scope and success measures for the Sales Pipeline Automation.', 'Not Started', '2026-04-12 09:00:00', '2026-05-01 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(182, 5, 9, 1, 'Review sales automation risk', 'Review delivery risk and open dependencies for the Sales Pipeline Automation.', 'Not Started', '2026-04-13 09:00:00', '2026-05-07 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(183, 5, 9, 1, 'Align sales automation stakeholders', 'Align stakeholders and decision points for the Sales Pipeline Automation.', 'Not Started', '2026-04-14 09:00:00', '2026-05-13 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(184, 5, 9, 1, 'Confirm sales automation plan', 'Confirm milestones and checkpoints for the Sales Pipeline Automation.', 'Not Started', '2026-04-15 09:00:00', '2026-05-19 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(185, 5, 9, 1, 'Status update: sales automation', 'Prepare the weekly status update for the Sales Pipeline Automation.', 'Not Started', '2026-04-16 09:00:00', '2026-05-25 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(186, 5, 1, 9, 'Plan sales automation backlog', 'Break the next sprint for the Sales Pipeline Automation into clear work items.', 'Not Started', '2026-04-11 09:00:00', '2026-05-01 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(187, 5, 1, 9, 'Assign sales automation work', 'Assign role-based work and balance capacity for the Sales Pipeline Automation.', 'Not Started', '2026-04-12 09:00:00', '2026-05-07 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(188, 5, 1, 9, 'Review sales automation design', 'Review the planned design approach for the Sales Pipeline Automation.', 'Not Started', '2026-04-13 09:00:00', '2026-05-13 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(189, 5, 1, 9, 'Resolve sales automation blockers', 'Log blockers and escalation needs for the Sales Pipeline Automation.', 'Not Started', '2026-04-14 09:00:00', '2026-05-19 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(190, 5, 1, 9, 'Prep sales automation review', 'Prepare the sprint review and demo checklist for the Sales Pipeline Automation.', 'Not Started', '2026-04-15 09:00:00', '2026-05-25 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(191, 5, 9, 31, 'Plan sales automation pages', 'Plan the page flow for the Sales Pipeline Automation.', 'Not Started', '2026-04-12 09:00:00', '2026-05-03 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(192, 5, 9, 31, 'Build sales automation views', 'Build the web views for the Sales Pipeline Automation.', 'Not Started', '2026-04-13 09:00:00', '2026-05-09 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(193, 5, 9, 31, 'Wire sales automation forms', 'Wire shared forms for the Sales Pipeline Automation.', 'Not Started', '2026-04-14 09:00:00', '2026-05-15 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(194, 5, 9, 31, 'Test sales automation access', 'Test access paths for the Sales Pipeline Automation.', 'Not Started', '2026-04-15 09:00:00', '2026-05-21 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(195, 5, 9, 31, 'Note sales automation release', 'Note release checks for the Sales Pipeline Automation.', 'Not Started', '2026-04-16 09:00:00', '2026-05-27 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(196, 5, 9, 35, 'Model sales automation schema', 'Model schema changes for the Sales Pipeline Automation.', 'Not Started', '2026-04-13 09:00:00', '2026-05-03 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(197, 5, 9, 35, 'Write sales automation SQL', 'Write SQL changes for the Sales Pipeline Automation.', 'Not Started', '2026-04-14 09:00:00', '2026-05-09 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(198, 5, 9, 35, 'Tune sales automation queries', 'Review indexes and query paths for the Sales Pipeline Automation.', 'Not Started', '2026-04-15 09:00:00', '2026-05-15 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(199, 5, 9, 35, 'Prep sales automation validation', 'Prepare validation queries for the Sales Pipeline Automation.', 'Not Started', '2026-04-16 09:00:00', '2026-05-21 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(200, 5, 9, 35, 'Document sales automation rules', 'Document joins and rules for the Sales Pipeline Automation.', 'Not Started', '2026-04-17 09:00:00', '2026-05-27 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(201, 5, 9, 36, 'Map sales automation flow', 'Map the business flow for the Sales Pipeline Automation.', 'Not Started', '2026-04-11 09:00:00', '2026-04-30 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(202, 5, 9, 36, 'Review sales automation scenarios', 'Review user scenarios for the Sales Pipeline Automation.', 'Not Started', '2026-04-12 09:00:00', '2026-05-06 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(203, 5, 9, 36, 'Prepare sales automation training', 'Prepare training notes for the Sales Pipeline Automation.', 'Not Started', '2026-04-13 09:00:00', '2026-05-12 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(204, 5, 9, 36, 'Check sales automation rules', 'Check business rules for the Sales Pipeline Automation.', 'Not Started', '2026-04-14 09:00:00', '2026-05-18 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(205, 5, 9, 36, 'Update sales automation rollout', 'Update rollout notes for the Sales Pipeline Automation.', 'Not Started', '2026-04-15 09:00:00', '2026-05-24 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(206, 5, 9, 37, 'Map sales automation flow', 'Map the business flow for the Sales Pipeline Automation.', 'Not Started', '2026-04-12 09:00:00', '2026-05-01 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(207, 5, 9, 37, 'Review sales automation scenarios', 'Review user scenarios for the Sales Pipeline Automation.', 'Not Started', '2026-04-13 09:00:00', '2026-05-07 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(208, 5, 9, 37, 'Prepare sales automation training', 'Prepare training notes for the Sales Pipeline Automation.', 'Not Started', '2026-04-14 09:00:00', '2026-05-13 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(209, 5, 9, 37, 'Check sales automation rules', 'Check business rules for the Sales Pipeline Automation.', 'Not Started', '2026-04-15 09:00:00', '2026-05-19 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(210, 5, 9, 37, 'Update sales automation rollout', 'Update rollout notes for the Sales Pipeline Automation.', 'Not Started', '2026-04-16 09:00:00', '2026-05-25 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(211, 5, 9, 38, 'Map sales automation flow', 'Map the business flow for the Sales Pipeline Automation.', 'Not Started', '2026-04-13 09:00:00', '2026-05-02 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(212, 5, 9, 38, 'Review sales automation scenarios', 'Review user scenarios for the Sales Pipeline Automation.', 'Not Started', '2026-04-14 09:00:00', '2026-05-08 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(213, 5, 9, 38, 'Prepare sales automation training', 'Prepare training notes for the Sales Pipeline Automation.', 'Not Started', '2026-04-15 09:00:00', '2026-05-14 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(214, 5, 9, 38, 'Check sales automation rules', 'Check business rules for the Sales Pipeline Automation.', 'Not Started', '2026-04-16 09:00:00', '2026-05-20 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(215, 5, 9, 38, 'Update sales automation rollout', 'Update rollout notes for the Sales Pipeline Automation.', 'Not Started', '2026-04-17 09:00:00', '2026-05-26 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(216, 5, 9, 39, 'Map sales automation flow', 'Map the business flow for the Sales Pipeline Automation.', 'Not Started', '2026-04-11 09:00:00', '2026-05-03 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1);
INSERT INTO `Tasks` (`task_id`, `project_id`, `assigner_id`, `assignee_id`, `title`, `description`, `status`, `created_date`, `due_date`, `priority`, `estimated_effort`, `task_type`, `started_date`, `submitted_date`, `completed_date`, `completion_wait_time`, `completed_by_id`, `visibility`) VALUES
(217, 5, 9, 39, 'Review sales automation scenarios', 'Review user scenarios for the Sales Pipeline Automation.', 'Not Started', '2026-04-12 09:00:00', '2026-05-09 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(218, 5, 9, 39, 'Prepare sales automation training', 'Prepare training notes for the Sales Pipeline Automation.', 'Not Started', '2026-04-13 09:00:00', '2026-05-15 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(219, 5, 9, 39, 'Check sales automation rules', 'Check business rules for the Sales Pipeline Automation.', 'Not Started', '2026-04-14 09:00:00', '2026-05-21 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(220, 5, 9, 39, 'Update sales automation rollout', 'Update rollout notes for the Sales Pipeline Automation.', 'Not Started', '2026-04-15 09:00:00', '2026-05-27 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(221, 5, 9, 40, 'Map sales automation flow', 'Map the business flow for the Sales Pipeline Automation.', 'Not Started', '2026-04-12 09:00:00', '2026-04-30 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(222, 5, 9, 40, 'Review sales automation scenarios', 'Review user scenarios for the Sales Pipeline Automation.', 'Not Started', '2026-04-13 09:00:00', '2026-05-06 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(223, 5, 9, 40, 'Prepare sales automation training', 'Prepare training notes for the Sales Pipeline Automation.', 'Not Started', '2026-04-14 09:00:00', '2026-05-12 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(224, 5, 9, 40, 'Check sales automation rules', 'Check business rules for the Sales Pipeline Automation.', 'Not Started', '2026-04-15 09:00:00', '2026-05-18 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(225, 5, 9, 40, 'Update sales automation rollout', 'Update rollout notes for the Sales Pipeline Automation.', 'Not Started', '2026-04-16 09:00:00', '2026-05-24 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(226, 6, 6, 2, 'Approve ETL scope', 'Approve scope and success measures for the Analytics ETL Upgrade.', 'Not Started', '2026-04-17 09:00:00', '2026-05-06 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(227, 6, 6, 2, 'Review ETL risk', 'Review delivery risk and open dependencies for the Analytics ETL Upgrade.', 'Not Started', '2026-04-18 09:00:00', '2026-05-12 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(228, 6, 6, 2, 'Align ETL stakeholders', 'Align stakeholders and decision points for the Analytics ETL Upgrade.', 'Not Started', '2026-04-19 09:00:00', '2026-05-18 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(229, 6, 6, 2, 'Confirm ETL plan', 'Confirm milestones and checkpoints for the Analytics ETL Upgrade.', 'Not Started', '2026-04-20 09:00:00', '2026-05-24 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(230, 6, 6, 2, 'Status update: ETL', 'Prepare the weekly status update for the Analytics ETL Upgrade.', 'Not Started', '2026-04-21 09:00:00', '2026-05-30 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(231, 6, 2, 6, 'Plan ETL backlog', 'Break the next sprint for the Analytics ETL Upgrade into clear work items.', 'Not Started', '2026-04-15 09:00:00', '2026-05-06 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(232, 6, 2, 6, 'Assign ETL work', 'Assign role-based work and balance capacity for the Analytics ETL Upgrade.', 'Not Started', '2026-04-16 09:00:00', '2026-05-12 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(233, 6, 2, 6, 'Review ETL design', 'Review the planned design approach for the Analytics ETL Upgrade.', 'Not Started', '2026-04-17 09:00:00', '2026-05-18 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(234, 6, 2, 6, 'Resolve ETL blockers', 'Log blockers and escalation needs for the Analytics ETL Upgrade.', 'Not Started', '2026-04-18 09:00:00', '2026-05-24 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(235, 6, 2, 6, 'Prep ETL review', 'Prepare the sprint review and demo checklist for the Analytics ETL Upgrade.', 'Not Started', '2026-04-19 09:00:00', '2026-05-30 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(236, 6, 6, 22, 'Map ETL data', 'Map source fields and transforms for the Analytics ETL Upgrade.', 'Not Started', '2026-04-16 09:00:00', '2026-05-06 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(237, 6, 6, 22, 'Build ETL ETL', 'Build the core ETL job for the Analytics ETL Upgrade.', 'Not Started', '2026-04-17 09:00:00', '2026-05-12 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(238, 6, 6, 22, 'Validate ETL source', 'Validate source data and schema for the Analytics ETL Upgrade.', 'Not Started', '2026-04-18 09:00:00', '2026-05-18 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(239, 6, 6, 22, 'Prep ETL checks', 'Prepare data quality checks for the Analytics ETL Upgrade.', 'Not Started', '2026-04-19 09:00:00', '2026-05-24 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(240, 6, 6, 22, 'Document ETL pipeline', 'Document the pipeline flow for the Analytics ETL Upgrade.', 'Not Started', '2026-04-20 09:00:00', '2026-05-30 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(241, 6, 6, 23, 'Map ETL data', 'Map source fields and transforms for the Analytics ETL Upgrade.', 'Not Started', '2026-04-17 09:00:00', '2026-05-07 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(242, 6, 6, 23, 'Build ETL ETL', 'Build the core ETL job for the Analytics ETL Upgrade.', 'Not Started', '2026-04-18 09:00:00', '2026-05-13 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(243, 6, 6, 23, 'Validate ETL source', 'Validate source data and schema for the Analytics ETL Upgrade.', 'Not Started', '2026-04-19 09:00:00', '2026-05-19 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(244, 6, 6, 23, 'Prep ETL checks', 'Prepare data quality checks for the Analytics ETL Upgrade.', 'Not Started', '2026-04-20 09:00:00', '2026-05-25 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(245, 6, 6, 23, 'Document ETL pipeline', 'Document the pipeline flow for the Analytics ETL Upgrade.', 'Not Started', '2026-04-21 09:00:00', '2026-05-31 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(246, 6, 6, 24, 'Map ETL data', 'Map source fields and transforms for the Analytics ETL Upgrade.', 'Not Started', '2026-04-15 09:00:00', '2026-05-04 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(247, 6, 6, 24, 'Build ETL ETL', 'Build the core ETL job for the Analytics ETL Upgrade.', 'Not Started', '2026-04-16 09:00:00', '2026-05-10 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(248, 6, 6, 24, 'Validate ETL source', 'Validate source data and schema for the Analytics ETL Upgrade.', 'Not Started', '2026-04-17 09:00:00', '2026-05-16 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(249, 6, 6, 24, 'Prep ETL checks', 'Prepare data quality checks for the Analytics ETL Upgrade.', 'Not Started', '2026-04-18 09:00:00', '2026-05-22 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(250, 6, 6, 24, 'Document ETL pipeline', 'Document the pipeline flow for the Analytics ETL Upgrade.', 'Not Started', '2026-04-19 09:00:00', '2026-05-28 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(251, 6, 6, 25, 'Map ETL data', 'Map source fields and transforms for the Analytics ETL Upgrade.', 'Not Started', '2026-04-16 09:00:00', '2026-05-05 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(252, 6, 6, 25, 'Build ETL ETL', 'Build the core ETL job for the Analytics ETL Upgrade.', 'Not Started', '2026-04-17 09:00:00', '2026-05-11 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(253, 6, 6, 25, 'Validate ETL source', 'Validate source data and schema for the Analytics ETL Upgrade.', 'Not Started', '2026-04-18 09:00:00', '2026-05-17 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(254, 6, 6, 25, 'Prep ETL checks', 'Prepare data quality checks for the Analytics ETL Upgrade.', 'Not Started', '2026-04-19 09:00:00', '2026-05-23 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(255, 6, 6, 25, 'Document ETL pipeline', 'Document the pipeline flow for the Analytics ETL Upgrade.', 'Not Started', '2026-04-20 09:00:00', '2026-05-29 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(256, 6, 6, 26, 'Map ETL data', 'Map source fields and transforms for the Analytics ETL Upgrade.', 'Not Started', '2026-04-17 09:00:00', '2026-05-06 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(257, 6, 6, 26, 'Build ETL ETL', 'Build the core ETL job for the Analytics ETL Upgrade.', 'Not Started', '2026-04-18 09:00:00', '2026-05-12 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(258, 6, 6, 26, 'Validate ETL source', 'Validate source data and schema for the Analytics ETL Upgrade.', 'Not Started', '2026-04-19 09:00:00', '2026-05-18 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(259, 6, 6, 26, 'Prep ETL checks', 'Prepare data quality checks for the Analytics ETL Upgrade.', 'Not Started', '2026-04-20 09:00:00', '2026-05-24 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(260, 6, 6, 26, 'Document ETL pipeline', 'Document the pipeline flow for the Analytics ETL Upgrade.', 'Not Started', '2026-04-21 09:00:00', '2026-05-30 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(261, 6, 6, 33, 'Model ETL schema', 'Model schema changes for the Analytics ETL Upgrade.', 'Not Started', '2026-04-15 09:00:00', '2026-05-05 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(262, 6, 6, 33, 'Write ETL SQL', 'Write SQL changes for the Analytics ETL Upgrade.', 'Not Started', '2026-04-16 09:00:00', '2026-05-11 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(263, 6, 6, 33, 'Tune ETL queries', 'Review indexes and query paths for the Analytics ETL Upgrade.', 'Not Started', '2026-04-17 09:00:00', '2026-05-17 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(264, 6, 6, 33, 'Prep ETL validation', 'Prepare validation queries for the Analytics ETL Upgrade.', 'Not Started', '2026-04-18 09:00:00', '2026-05-23 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(265, 6, 6, 33, 'Document ETL rules', 'Document joins and rules for the Analytics ETL Upgrade.', 'Not Started', '2026-04-19 09:00:00', '2026-05-29 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(266, 6, 6, 34, 'Map ETL data', 'Map source fields and transforms for the Analytics ETL Upgrade.', 'Not Started', '2026-04-16 09:00:00', '2026-05-06 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(267, 6, 6, 34, 'Build ETL ETL', 'Build the core ETL job for the Analytics ETL Upgrade.', 'Not Started', '2026-04-17 09:00:00', '2026-05-12 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(268, 6, 6, 34, 'Validate ETL source', 'Validate source data and schema for the Analytics ETL Upgrade.', 'Not Started', '2026-04-18 09:00:00', '2026-05-18 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(269, 6, 6, 34, 'Prep ETL checks', 'Prepare data quality checks for the Analytics ETL Upgrade.', 'Not Started', '2026-04-19 09:00:00', '2026-05-24 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(270, 6, 6, 34, 'Document ETL pipeline', 'Document the pipeline flow for the Analytics ETL Upgrade.', 'Not Started', '2026-04-20 09:00:00', '2026-05-30 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(271, 7, 7, 3, 'Approve knowledge search scope', 'Approve scope and success measures for the Knowledge Base Search.', 'Not Started', '2026-04-17 09:00:00', '2026-05-09 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(272, 7, 7, 3, 'Review knowledge search risk', 'Review delivery risk and open dependencies for the Knowledge Base Search.', 'Not Started', '2026-04-18 09:00:00', '2026-05-15 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(273, 7, 7, 3, 'Align knowledge search stakeholders', 'Align stakeholders and decision points for the Knowledge Base Search.', 'Not Started', '2026-04-19 09:00:00', '2026-05-21 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(274, 7, 7, 3, 'Confirm knowledge search plan', 'Confirm milestones and checkpoints for the Knowledge Base Search.', 'Not Started', '2026-04-20 09:00:00', '2026-05-27 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(275, 7, 7, 3, 'Status update: knowledge search', 'Prepare the weekly status update for the Knowledge Base Search.', 'Not Started', '2026-04-21 09:00:00', '2026-06-02 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(276, 7, 3, 7, 'Plan knowledge search backlog', 'Break the next sprint for the Knowledge Base Search into clear work items.', 'Not Started', '2026-04-18 09:00:00', '2026-05-09 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(277, 7, 3, 7, 'Assign knowledge search work', 'Assign role-based work and balance capacity for the Knowledge Base Search.', 'Not Started', '2026-04-19 09:00:00', '2026-05-15 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(278, 7, 3, 7, 'Review knowledge search design', 'Review the planned design approach for the Knowledge Base Search.', 'Not Started', '2026-04-20 09:00:00', '2026-05-21 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(279, 7, 3, 7, 'Resolve knowledge search blockers', 'Log blockers and escalation needs for the Knowledge Base Search.', 'Not Started', '2026-04-21 09:00:00', '2026-05-27 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(280, 7, 3, 7, 'Prep knowledge search review', 'Prepare the sprint review and demo checklist for the Knowledge Base Search.', 'Not Started', '2026-04-22 09:00:00', '2026-06-02 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(281, 7, 7, 10, 'Design knowledge search states', 'Sketch key UI states needed for the Knowledge Base Search.', 'Not Started', '2026-04-18 09:00:00', '2026-05-08 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(282, 7, 7, 10, 'Build knowledge search components', 'Build the reusable UI pieces for the Knowledge Base Search.', 'Not Started', '2026-04-19 09:00:00', '2026-05-14 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(283, 7, 7, 10, 'Hook knowledge search API', 'Connect agreed API calls for the Knowledge Base Search.', 'Not Started', '2026-04-20 09:00:00', '2026-05-20 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(284, 7, 7, 10, 'QA knowledge search flows', 'Check responsive flows and states for the Knowledge Base Search.', 'Not Started', '2026-04-21 09:00:00', '2026-05-26 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(285, 7, 7, 10, 'Update knowledge search notes', 'Document UI assumptions for the Knowledge Base Search.', 'Not Started', '2026-04-22 09:00:00', '2026-06-01 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(286, 7, 7, 12, 'Design knowledge search states', 'Sketch key UI states needed for the Knowledge Base Search.', 'In Progress', '2026-04-17 09:00:00', '2026-05-06 09:00:00', 'Medium', 'S', 'project', '2026-04-08 16:57:59', NULL, NULL, NULL, NULL, 1),
(287, 7, 7, 12, 'Build knowledge search components', 'Build the reusable UI pieces for the Knowledge Base Search.', 'Not Started', '2026-04-18 09:00:00', '2026-05-12 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(288, 7, 7, 12, 'Hook knowledge search API', 'Connect agreed API calls for the Knowledge Base Search.', 'Not Started', '2026-04-19 09:00:00', '2026-05-18 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(289, 7, 7, 12, 'QA knowledge search flows', 'Check responsive flows and states for the Knowledge Base Search.', 'Not Started', '2026-04-20 09:00:00', '2026-05-24 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(290, 7, 7, 12, 'Update knowledge search notes', 'Document UI assumptions for the Knowledge Base Search.', 'Not Started', '2026-04-21 09:00:00', '2026-05-30 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(291, 7, 7, 20, 'Draft knowledge search API', 'Define the API contract and rules for the Knowledge Base Search.', 'Not Started', '2026-04-19 09:00:00', '2026-05-06 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(292, 7, 7, 20, 'Build knowledge search service', 'Implement the service layer for the Knowledge Base Search.', 'Not Started', '2026-04-20 09:00:00', '2026-05-12 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(293, 7, 7, 20, 'Test knowledge search integration', 'Write integration checks for the Knowledge Base Search.', 'Not Started', '2026-04-21 09:00:00', '2026-05-18 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(294, 7, 7, 20, 'Refine knowledge search errors', 'Refine error handling for the Knowledge Base Search.', 'Not Started', '2026-04-22 09:00:00', '2026-05-24 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(295, 7, 7, 20, 'Document knowledge search endpoints', 'Document service endpoints for the Knowledge Base Search.', 'Not Started', '2026-04-23 09:00:00', '2026-05-30 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(296, 7, 7, 21, 'Draft knowledge search API', 'Define the API contract and rules for the Knowledge Base Search.', 'Not Started', '2026-04-17 09:00:00', '2026-05-07 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(297, 7, 7, 21, 'Build knowledge search service', 'Implement the service layer for the Knowledge Base Search.', 'Not Started', '2026-04-18 09:00:00', '2026-05-13 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(298, 7, 7, 21, 'Test knowledge search integration', 'Write integration checks for the Knowledge Base Search.', 'Not Started', '2026-04-19 09:00:00', '2026-05-19 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(299, 7, 7, 21, 'Refine knowledge search errors', 'Refine error handling for the Knowledge Base Search.', 'Not Started', '2026-04-20 09:00:00', '2026-05-25 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(300, 7, 7, 21, 'Document knowledge search endpoints', 'Document service endpoints for the Knowledge Base Search.', 'Not Started', '2026-04-21 09:00:00', '2026-05-31 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(301, 7, 7, 26, 'Map knowledge search data', 'Map source fields and transforms for the Knowledge Base Search.', 'Not Started', '2026-04-19 09:00:00', '2026-05-08 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(302, 7, 7, 26, 'Build knowledge search ETL', 'Build the core ETL job for the Knowledge Base Search.', 'Not Started', '2026-04-20 09:00:00', '2026-05-14 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(303, 7, 7, 26, 'Validate knowledge search source', 'Validate source data and schema for the Knowledge Base Search.', 'Not Started', '2026-04-21 09:00:00', '2026-05-20 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(304, 7, 7, 26, 'Prep knowledge search checks', 'Prepare data quality checks for the Knowledge Base Search.', 'Not Started', '2026-04-22 09:00:00', '2026-05-26 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(305, 7, 7, 26, 'Document knowledge search pipeline', 'Document the pipeline flow for the Knowledge Base Search.', 'Not Started', '2026-04-23 09:00:00', '2026-06-01 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(306, 7, 7, 27, 'Plan knowledge search pages', 'Plan the page flow for the Knowledge Base Search.', 'Not Started', '2026-04-17 09:00:00', '2026-05-09 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(307, 7, 7, 27, 'Build knowledge search views', 'Build the web views for the Knowledge Base Search.', 'Not Started', '2026-04-18 09:00:00', '2026-05-15 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(308, 7, 7, 27, 'Wire knowledge search forms', 'Wire shared forms for the Knowledge Base Search.', 'Not Started', '2026-04-19 09:00:00', '2026-05-21 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(309, 7, 7, 27, 'Test knowledge search access', 'Test access paths for the Knowledge Base Search.', 'Not Started', '2026-04-20 09:00:00', '2026-05-27 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(310, 7, 7, 27, 'Note knowledge search release', 'Note release checks for the Knowledge Base Search.', 'Not Started', '2026-04-21 09:00:00', '2026-06-02 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(311, 7, 7, 29, 'Plan knowledge search pages', 'Plan the page flow for the Knowledge Base Search.', 'Not Started', '2026-04-19 09:00:00', '2026-05-07 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(312, 7, 7, 29, 'Build knowledge search views', 'Build the web views for the Knowledge Base Search.', 'Not Started', '2026-04-20 09:00:00', '2026-05-13 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(313, 7, 7, 29, 'Wire knowledge search forms', 'Wire shared forms for the Knowledge Base Search.', 'Not Started', '2026-04-21 09:00:00', '2026-05-19 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(314, 7, 7, 29, 'Test knowledge search access', 'Test access paths for the Knowledge Base Search.', 'Not Started', '2026-04-22 09:00:00', '2026-05-25 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(315, 7, 7, 29, 'Note knowledge search release', 'Note release checks for the Knowledge Base Search.', 'Not Started', '2026-04-23 09:00:00', '2026-05-31 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(316, 8, 7, 1, 'Approve timesheet app scope', 'Approve scope and success measures for the Internal Timesheet App.', 'Not Started', '2026-04-22 09:00:00', '2026-05-11 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(317, 8, 7, 1, 'Review timesheet app risk', 'Review delivery risk and open dependencies for the Internal Timesheet App.', 'Not Started', '2026-04-23 09:00:00', '2026-05-17 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(318, 8, 7, 1, 'Align timesheet app stakeholders', 'Align stakeholders and decision points for the Internal Timesheet App.', 'Not Started', '2026-04-24 09:00:00', '2026-05-23 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(319, 8, 7, 1, 'Confirm timesheet app plan', 'Confirm milestones and checkpoints for the Internal Timesheet App.', 'Not Started', '2026-04-25 09:00:00', '2026-05-29 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(320, 8, 7, 1, 'Status update: timesheet app', 'Prepare the weekly status update for the Internal Timesheet App.', 'Not Started', '2026-04-26 09:00:00', '2026-06-04 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(321, 8, 1, 7, 'Plan timesheet app backlog', 'Break the next sprint for the Internal Timesheet App into clear work items.', 'Not Started', '2026-04-22 09:00:00', '2026-05-13 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(322, 8, 1, 7, 'Assign timesheet app work', 'Assign role-based work and balance capacity for the Internal Timesheet App.', 'Not Started', '2026-04-23 09:00:00', '2026-05-19 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(323, 8, 1, 7, 'Review timesheet app design', 'Review the planned design approach for the Internal Timesheet App.', 'Not Started', '2026-04-24 09:00:00', '2026-05-25 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(324, 8, 1, 7, 'Resolve timesheet app blockers', 'Log blockers and escalation needs for the Internal Timesheet App.', 'Not Started', '2026-04-25 09:00:00', '2026-05-31 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(325, 8, 1, 7, 'Prep timesheet app review', 'Prepare the sprint review and demo checklist for the Internal Timesheet App.', 'Not Started', '2026-04-26 09:00:00', '2026-06-06 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(326, 8, 7, 11, 'Design timesheet app states', 'Sketch key UI states needed for the Internal Timesheet App.', 'Not Started', '2026-04-23 09:00:00', '2026-05-13 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(327, 8, 7, 11, 'Build timesheet app components', 'Build the reusable UI pieces for the Internal Timesheet App.', 'Not Started', '2026-04-24 09:00:00', '2026-05-19 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(328, 8, 7, 11, 'Hook timesheet app API', 'Connect agreed API calls for the Internal Timesheet App.', 'Not Started', '2026-04-25 09:00:00', '2026-05-25 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(329, 8, 7, 11, 'QA timesheet app flows', 'Check responsive flows and states for the Internal Timesheet App.', 'Not Started', '2026-04-26 09:00:00', '2026-05-31 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(330, 8, 7, 11, 'Update timesheet app notes', 'Document UI assumptions for the Internal Timesheet App.', 'Not Started', '2026-04-27 09:00:00', '2026-06-06 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(331, 8, 7, 13, 'Design timesheet app states', 'Sketch key UI states needed for the Internal Timesheet App.', 'Not Started', '2026-04-22 09:00:00', '2026-05-11 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(332, 8, 7, 13, 'Build timesheet app components', 'Build the reusable UI pieces for the Internal Timesheet App.', 'Not Started', '2026-04-23 09:00:00', '2026-05-17 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(333, 8, 7, 13, 'Hook timesheet app API', 'Connect agreed API calls for the Internal Timesheet App.', 'Not Started', '2026-04-24 09:00:00', '2026-05-23 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(334, 8, 7, 13, 'QA timesheet app flows', 'Check responsive flows and states for the Internal Timesheet App.', 'Not Started', '2026-04-25 09:00:00', '2026-05-29 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(335, 8, 7, 13, 'Update timesheet app notes', 'Document UI assumptions for the Internal Timesheet App.', 'Not Started', '2026-04-26 09:00:00', '2026-06-04 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(336, 8, 7, 14, 'Design timesheet app states', 'Sketch key UI states needed for the Internal Timesheet App.', 'Not Started', '2026-04-23 09:00:00', '2026-05-12 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(337, 8, 7, 14, 'Build timesheet app components', 'Build the reusable UI pieces for the Internal Timesheet App.', 'Not Started', '2026-04-24 09:00:00', '2026-05-18 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(338, 8, 7, 14, 'Hook timesheet app API', 'Connect agreed API calls for the Internal Timesheet App.', 'Not Started', '2026-04-25 09:00:00', '2026-05-24 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(339, 8, 7, 14, 'QA timesheet app flows', 'Check responsive flows and states for the Internal Timesheet App.', 'Not Started', '2026-04-26 09:00:00', '2026-05-30 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(340, 8, 7, 14, 'Update timesheet app notes', 'Document UI assumptions for the Internal Timesheet App.', 'Not Started', '2026-04-27 09:00:00', '2026-06-05 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(341, 8, 7, 21, 'Draft timesheet app API', 'Define the API contract and rules for the Internal Timesheet App.', 'Not Started', '2026-04-21 09:00:00', '2026-05-11 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(342, 8, 7, 21, 'Build timesheet app service', 'Implement the service layer for the Internal Timesheet App.', 'Not Started', '2026-04-22 09:00:00', '2026-05-17 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(343, 8, 7, 21, 'Test timesheet app integration', 'Write integration checks for the Internal Timesheet App.', 'Not Started', '2026-04-23 09:00:00', '2026-05-23 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(344, 8, 7, 21, 'Refine timesheet app errors', 'Refine error handling for the Internal Timesheet App.', 'Not Started', '2026-04-24 09:00:00', '2026-05-29 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(345, 8, 7, 21, 'Document timesheet app endpoints', 'Document service endpoints for the Internal Timesheet App.', 'Not Started', '2026-04-25 09:00:00', '2026-06-04 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(346, 8, 7, 28, 'Plan timesheet app pages', 'Plan the page flow for the Internal Timesheet App.', 'Not Started', '2026-04-22 09:00:00', '2026-05-10 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(347, 8, 7, 28, 'Build timesheet app views', 'Build the web views for the Internal Timesheet App.', 'Not Started', '2026-04-23 09:00:00', '2026-05-16 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(348, 8, 7, 28, 'Wire timesheet app forms', 'Wire shared forms for the Internal Timesheet App.', 'Not Started', '2026-04-24 09:00:00', '2026-05-22 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(349, 8, 7, 28, 'Test timesheet app access', 'Test access paths for the Internal Timesheet App.', 'Not Started', '2026-04-25 09:00:00', '2026-05-28 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(350, 8, 7, 28, 'Note timesheet app release', 'Note release checks for the Internal Timesheet App.', 'Not Started', '2026-04-26 09:00:00', '2026-06-03 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(351, 8, 7, 35, 'Model timesheet app schema', 'Model schema changes for the Internal Timesheet App.', 'Not Started', '2026-04-23 09:00:00', '2026-05-13 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(352, 8, 7, 35, 'Write timesheet app SQL', 'Write SQL changes for the Internal Timesheet App.', 'Not Started', '2026-04-24 09:00:00', '2026-05-19 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(353, 8, 7, 35, 'Tune timesheet app queries', 'Review indexes and query paths for the Internal Timesheet App.', 'Not Started', '2026-04-25 09:00:00', '2026-05-25 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(354, 8, 7, 35, 'Prep timesheet app validation', 'Prepare validation queries for the Internal Timesheet App.', 'Not Started', '2026-04-26 09:00:00', '2026-05-31 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(355, 8, 7, 35, 'Document timesheet app rules', 'Document joins and rules for the Internal Timesheet App.', 'Not Started', '2026-04-27 09:00:00', '2026-06-06 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(356, 8, 7, 40, 'Map timesheet app flow', 'Map the business flow for the Internal Timesheet App.', 'Not Started', '2026-04-22 09:00:00', '2026-05-10 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(357, 8, 7, 40, 'Review timesheet app scenarios', 'Review user scenarios for the Internal Timesheet App.', 'Not Started', '2026-04-23 09:00:00', '2026-05-16 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(358, 8, 7, 40, 'Prepare timesheet app training', 'Prepare training notes for the Internal Timesheet App.', 'Not Started', '2026-04-24 09:00:00', '2026-05-22 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(359, 8, 7, 40, 'Check timesheet app rules', 'Check business rules for the Internal Timesheet App.', 'Not Started', '2026-04-25 09:00:00', '2026-05-28 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(360, 8, 7, 40, 'Update timesheet app rollout', 'Update rollout notes for the Internal Timesheet App.', 'Not Started', '2026-04-26 09:00:00', '2026-06-03 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(361, 9, 8, 2, 'Approve DB tuning scope', 'Approve scope and success measures for the Database Performance Tuning.', 'Not Started', '2026-04-25 09:00:00', '2026-05-14 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(362, 9, 8, 2, 'Review DB tuning risk', 'Review delivery risk and open dependencies for the Database Performance Tuning.', 'Not Started', '2026-04-26 09:00:00', '2026-05-20 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(363, 9, 8, 2, 'Align DB tuning stakeholders', 'Align stakeholders and decision points for the Database Performance Tuning.', 'Not Started', '2026-04-27 09:00:00', '2026-05-26 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(364, 9, 8, 2, 'Confirm DB tuning plan', 'Confirm milestones and checkpoints for the Database Performance Tuning.', 'Not Started', '2026-04-28 09:00:00', '2026-06-01 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(365, 9, 8, 2, 'Status update: DB tuning', 'Prepare the weekly status update for the Database Performance Tuning.', 'Not Started', '2026-04-29 09:00:00', '2026-06-07 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(366, 9, 2, 8, 'Plan DB tuning backlog', 'Break the next sprint for the Database Performance Tuning into clear work items.', 'Not Started', '2026-04-25 09:00:00', '2026-05-12 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(367, 9, 2, 8, 'Assign DB tuning work', 'Assign role-based work and balance capacity for the Database Performance Tuning.', 'Not Started', '2026-04-26 09:00:00', '2026-05-18 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(368, 9, 2, 8, 'Review DB tuning design', 'Review the planned design approach for the Database Performance Tuning.', 'Not Started', '2026-04-27 09:00:00', '2026-05-24 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(369, 9, 2, 8, 'Resolve DB tuning blockers', 'Log blockers and escalation needs for the Database Performance Tuning.', 'Not Started', '2026-04-28 09:00:00', '2026-05-30 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(370, 9, 2, 8, 'Prep DB tuning review', 'Prepare the sprint review and demo checklist for the Database Performance Tuning.', 'Not Started', '2026-04-29 09:00:00', '2026-06-05 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(371, 9, 8, 16, 'Draft DB tuning API', 'Define the API contract and rules for the Database Performance Tuning.', 'Not Started', '2026-04-24 09:00:00', '2026-05-12 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(372, 9, 8, 16, 'Build DB tuning service', 'Implement the service layer for the Database Performance Tuning.', 'Not Started', '2026-04-25 09:00:00', '2026-05-18 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(373, 9, 8, 16, 'Test DB tuning integration', 'Write integration checks for the Database Performance Tuning.', 'Not Started', '2026-04-26 09:00:00', '2026-05-24 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(374, 9, 8, 16, 'Refine DB tuning errors', 'Refine error handling for the Database Performance Tuning.', 'Not Started', '2026-04-27 09:00:00', '2026-05-30 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(375, 9, 8, 16, 'Document DB tuning endpoints', 'Document service endpoints for the Database Performance Tuning.', 'Not Started', '2026-04-28 09:00:00', '2026-06-05 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(376, 9, 8, 18, 'Draft DB tuning API', 'Define the API contract and rules for the Database Performance Tuning.', 'Not Started', '2026-04-23 09:00:00', '2026-05-14 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(377, 9, 8, 18, 'Build DB tuning service', 'Implement the service layer for the Database Performance Tuning.', 'Not Started', '2026-04-24 09:00:00', '2026-05-20 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(378, 9, 8, 18, 'Test DB tuning integration', 'Write integration checks for the Database Performance Tuning.', 'Not Started', '2026-04-25 09:00:00', '2026-05-26 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(379, 9, 8, 18, 'Refine DB tuning errors', 'Refine error handling for the Database Performance Tuning.', 'Not Started', '2026-04-26 09:00:00', '2026-06-01 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(380, 9, 8, 18, 'Document DB tuning endpoints', 'Document service endpoints for the Database Performance Tuning.', 'Not Started', '2026-04-27 09:00:00', '2026-06-07 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(381, 9, 8, 24, 'Map DB tuning data', 'Map source fields and transforms for the Database Performance Tuning.', 'Not Started', '2026-04-23 09:00:00', '2026-05-12 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(382, 9, 8, 24, 'Build DB tuning ETL', 'Build the core ETL job for the Database Performance Tuning.', 'Not Started', '2026-04-24 09:00:00', '2026-05-18 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(383, 9, 8, 24, 'Validate DB tuning source', 'Validate source data and schema for the Database Performance Tuning.', 'Not Started', '2026-04-25 09:00:00', '2026-05-24 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(384, 9, 8, 24, 'Prep DB tuning checks', 'Prepare data quality checks for the Database Performance Tuning.', 'Not Started', '2026-04-26 09:00:00', '2026-05-30 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(385, 9, 8, 24, 'Document DB tuning pipeline', 'Document the pipeline flow for the Database Performance Tuning.', 'Not Started', '2026-04-27 09:00:00', '2026-06-05 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(386, 9, 8, 32, 'Model DB tuning schema', 'Model schema changes for the Database Performance Tuning.', 'Not Started', '2026-04-25 09:00:00', '2026-05-12 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(387, 9, 8, 32, 'Write DB tuning SQL', 'Write SQL changes for the Database Performance Tuning.', 'Not Started', '2026-04-26 09:00:00', '2026-05-18 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(388, 9, 8, 32, 'Tune DB tuning queries', 'Review indexes and query paths for the Database Performance Tuning.', 'Not Started', '2026-04-27 09:00:00', '2026-05-24 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(389, 9, 8, 32, 'Prep DB tuning validation', 'Prepare validation queries for the Database Performance Tuning.', 'Not Started', '2026-04-28 09:00:00', '2026-05-30 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(390, 9, 8, 32, 'Document DB tuning rules', 'Document joins and rules for the Database Performance Tuning.', 'Not Started', '2026-04-29 09:00:00', '2026-06-05 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(391, 9, 8, 33, 'Model DB tuning schema', 'Model schema changes for the Database Performance Tuning.', 'Not Started', '2026-04-23 09:00:00', '2026-05-13 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(392, 9, 8, 33, 'Write DB tuning SQL', 'Write SQL changes for the Database Performance Tuning.', 'Not Started', '2026-04-24 09:00:00', '2026-05-19 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(393, 9, 8, 33, 'Tune DB tuning queries', 'Review indexes and query paths for the Database Performance Tuning.', 'Not Started', '2026-04-25 09:00:00', '2026-05-25 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(394, 9, 8, 33, 'Prep DB tuning validation', 'Prepare validation queries for the Database Performance Tuning.', 'Not Started', '2026-04-26 09:00:00', '2026-05-31 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(395, 9, 8, 33, 'Document DB tuning rules', 'Document joins and rules for the Database Performance Tuning.', 'Not Started', '2026-04-27 09:00:00', '2026-06-06 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(396, 9, 8, 34, 'Map DB tuning data', 'Map source fields and transforms for the Database Performance Tuning.', 'Not Started', '2026-04-24 09:00:00', '2026-05-14 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(397, 9, 8, 34, 'Build DB tuning ETL', 'Build the core ETL job for the Database Performance Tuning.', 'Not Started', '2026-04-25 09:00:00', '2026-05-20 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(398, 9, 8, 34, 'Validate DB tuning source', 'Validate source data and schema for the Database Performance Tuning.', 'Not Started', '2026-04-26 09:00:00', '2026-05-26 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(399, 9, 8, 34, 'Prep DB tuning checks', 'Prepare data quality checks for the Database Performance Tuning.', 'Not Started', '2026-04-27 09:00:00', '2026-06-01 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(400, 9, 8, 34, 'Document DB tuning pipeline', 'Document the pipeline flow for the Database Performance Tuning.', 'Not Started', '2026-04-28 09:00:00', '2026-06-07 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(401, 9, 8, 35, 'Model DB tuning schema', 'Model schema changes for the Database Performance Tuning.', 'Not Started', '2026-04-25 09:00:00', '2026-05-15 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(402, 9, 8, 35, 'Write DB tuning SQL', 'Write SQL changes for the Database Performance Tuning.', 'Not Started', '2026-04-26 09:00:00', '2026-05-21 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(403, 9, 8, 35, 'Tune DB tuning queries', 'Review indexes and query paths for the Database Performance Tuning.', 'Not Started', '2026-04-27 09:00:00', '2026-05-27 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(404, 9, 8, 35, 'Prep DB tuning validation', 'Prepare validation queries for the Database Performance Tuning.', 'Not Started', '2026-04-28 09:00:00', '2026-06-02 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(405, 9, 8, 35, 'Document DB tuning rules', 'Document joins and rules for the Database Performance Tuning.', 'Not Started', '2026-04-29 09:00:00', '2026-06-08 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(406, 10, 5, 3, 'Approve notification service scope', 'Approve scope and success measures for the Notification Service Rollout.', 'Not Started', '2026-04-25 09:00:00', '2026-05-17 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(407, 10, 5, 3, 'Review notification service risk', 'Review delivery risk and open dependencies for the Notification Service Rollout.', 'Not Started', '2026-04-26 09:00:00', '2026-05-23 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(408, 10, 5, 3, 'Align notification service stakeholders', 'Align stakeholders and decision points for the Notification Service Rollout.', 'Not Started', '2026-04-27 09:00:00', '2026-05-29 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(409, 10, 5, 3, 'Confirm notification service plan', 'Confirm milestones and checkpoints for the Notification Service Rollout.', 'Not Started', '2026-04-28 09:00:00', '2026-06-04 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(410, 10, 5, 3, 'Status update: notification service', 'Prepare the weekly status update for the Notification Service Rollout.', 'Not Started', '2026-04-29 09:00:00', '2026-06-10 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(411, 10, 3, 5, 'Plan notification service backlog', 'Break the next sprint for the Notification Service Rollout into clear work items.', 'Not Started', '2026-04-27 09:00:00', '2026-05-15 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(412, 10, 3, 5, 'Assign notification service work', 'Assign role-based work and balance capacity for the Notification Service Rollout.', 'Not Started', '2026-04-28 09:00:00', '2026-05-21 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(413, 10, 3, 5, 'Review notification service design', 'Review the planned design approach for the Notification Service Rollout.', 'Not Started', '2026-04-29 09:00:00', '2026-05-27 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(414, 10, 3, 5, 'Resolve notification service blockers', 'Log blockers and escalation needs for the Notification Service Rollout.', 'Not Started', '2026-04-30 09:00:00', '2026-06-02 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(415, 10, 3, 5, 'Prep notification service review', 'Prepare the sprint review and demo checklist for the Notification Service Rollout.', 'Not Started', '2026-05-01 09:00:00', '2026-06-08 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(416, 10, 5, 19, 'Draft notification service API', 'Define the API contract and rules for the Notification Service Rollout.', 'Not Started', '2026-04-26 09:00:00', '2026-05-17 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(417, 10, 5, 19, 'Build notification service service', 'Implement the service layer for the Notification Service Rollout.', 'Not Started', '2026-04-27 09:00:00', '2026-05-23 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(418, 10, 5, 19, 'Test notification service integration', 'Write integration checks for the Notification Service Rollout.', 'Not Started', '2026-04-28 09:00:00', '2026-05-29 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(419, 10, 5, 19, 'Refine notification service errors', 'Refine error handling for the Notification Service Rollout.', 'Not Started', '2026-04-29 09:00:00', '2026-06-04 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(420, 10, 5, 19, 'Document notification service endpoints', 'Document service endpoints for the Notification Service Rollout.', 'Not Started', '2026-04-30 09:00:00', '2026-06-10 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(421, 10, 5, 20, 'Draft notification service API', 'Define the API contract and rules for the Notification Service Rollout.', 'Not Started', '2026-04-27 09:00:00', '2026-05-14 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(422, 10, 5, 20, 'Build notification service service', 'Implement the service layer for the Notification Service Rollout.', 'Not Started', '2026-04-28 09:00:00', '2026-05-20 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(423, 10, 5, 20, 'Test notification service integration', 'Write integration checks for the Notification Service Rollout.', 'Not Started', '2026-04-29 09:00:00', '2026-05-26 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(424, 10, 5, 20, 'Refine notification service errors', 'Refine error handling for the Notification Service Rollout.', 'Not Started', '2026-04-30 09:00:00', '2026-06-01 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(425, 10, 5, 20, 'Document notification service endpoints', 'Document service endpoints for the Notification Service Rollout.', 'Not Started', '2026-05-01 09:00:00', '2026-06-07 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(426, 10, 5, 31, 'Plan notification service pages', 'Plan the page flow for the Notification Service Rollout.', 'Not Started', '2026-04-26 09:00:00', '2026-05-17 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(427, 10, 5, 31, 'Build notification service views', 'Build the web views for the Notification Service Rollout.', 'Not Started', '2026-04-27 09:00:00', '2026-05-23 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(428, 10, 5, 31, 'Wire notification service forms', 'Wire shared forms for the Notification Service Rollout.', 'Not Started', '2026-04-28 09:00:00', '2026-05-29 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(429, 10, 5, 31, 'Test notification service access', 'Test access paths for the Notification Service Rollout.', 'Not Started', '2026-04-29 09:00:00', '2026-06-04 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(430, 10, 5, 31, 'Note notification service release', 'Note release checks for the Notification Service Rollout.', 'Not Started', '2026-04-30 09:00:00', '2026-06-10 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(431, 10, 5, 36, 'Map notification service flow', 'Map the business flow for the Notification Service Rollout.', 'Not Started', '2026-04-25 09:00:00', '2026-05-14 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(432, 10, 5, 36, 'Review notification service scenarios', 'Review user scenarios for the Notification Service Rollout.', 'Not Started', '2026-04-26 09:00:00', '2026-05-20 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(433, 10, 5, 36, 'Prepare notification service training', 'Prepare training notes for the Notification Service Rollout.', 'Not Started', '2026-04-27 09:00:00', '2026-05-26 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1);
INSERT INTO `Tasks` (`task_id`, `project_id`, `assigner_id`, `assignee_id`, `title`, `description`, `status`, `created_date`, `due_date`, `priority`, `estimated_effort`, `task_type`, `started_date`, `submitted_date`, `completed_date`, `completion_wait_time`, `completed_by_id`, `visibility`) VALUES
(434, 10, 5, 36, 'Check notification service rules', 'Check business rules for the Notification Service Rollout.', 'Not Started', '2026-04-28 09:00:00', '2026-06-01 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(435, 10, 5, 36, 'Update notification service rollout', 'Update rollout notes for the Notification Service Rollout.', 'Not Started', '2026-04-29 09:00:00', '2026-06-07 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(436, 10, 5, 38, 'Map notification service flow', 'Map the business flow for the Notification Service Rollout.', 'Not Started', '2026-04-27 09:00:00', '2026-05-16 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(437, 10, 5, 38, 'Review notification service scenarios', 'Review user scenarios for the Notification Service Rollout.', 'Not Started', '2026-04-28 09:00:00', '2026-05-22 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(438, 10, 5, 38, 'Prepare notification service training', 'Prepare training notes for the Notification Service Rollout.', 'Not Started', '2026-04-29 09:00:00', '2026-05-28 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(439, 10, 5, 38, 'Check notification service rules', 'Check business rules for the Notification Service Rollout.', 'Not Started', '2026-04-30 09:00:00', '2026-06-03 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(440, 10, 5, 38, 'Update notification service rollout', 'Update rollout notes for the Notification Service Rollout.', 'Not Started', '2026-05-01 09:00:00', '2026-06-09 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(441, 10, 5, 39, 'Map notification service flow', 'Map the business flow for the Notification Service Rollout.', 'Not Started', '2026-04-25 09:00:00', '2026-05-17 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(442, 10, 5, 39, 'Review notification service scenarios', 'Review user scenarios for the Notification Service Rollout.', 'Not Started', '2026-04-26 09:00:00', '2026-05-23 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(443, 10, 5, 39, 'Prepare notification service training', 'Prepare training notes for the Notification Service Rollout.', 'Not Started', '2026-04-27 09:00:00', '2026-05-29 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(444, 10, 5, 39, 'Check notification service rules', 'Check business rules for the Notification Service Rollout.', 'Not Started', '2026-04-28 09:00:00', '2026-06-04 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(445, 10, 5, 39, 'Update notification service rollout', 'Update rollout notes for the Notification Service Rollout.', 'Not Started', '2026-04-29 09:00:00', '2026-06-10 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(446, 10, 5, 40, 'Map notification service flow', 'Map the business flow for the Notification Service Rollout.', 'Not Started', '2026-04-26 09:00:00', '2026-05-14 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(447, 10, 5, 40, 'Review notification service scenarios', 'Review user scenarios for the Notification Service Rollout.', 'Not Started', '2026-04-27 09:00:00', '2026-05-20 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(448, 10, 5, 40, 'Prepare notification service training', 'Prepare training notes for the Notification Service Rollout.', 'Not Started', '2026-04-28 09:00:00', '2026-05-26 09:00:00', 'High', 'M', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(449, 10, 5, 40, 'Check notification service rules', 'Check business rules for the Notification Service Rollout.', 'Not Started', '2026-04-29 09:00:00', '2026-06-01 09:00:00', 'Medium', 'S', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(450, 10, 5, 40, 'Update notification service rollout', 'Update rollout notes for the Notification Service Rollout.', 'Not Started', '2026-04-30 09:00:00', '2026-06-07 09:00:00', 'Low', 'XS', 'project', NULL, NULL, NULL, NULL, NULL, 1),
(512, 4, 1, 1, 'Prep notes: inventory dashboard', 'Set up personal prep notes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-06 09:00:00', '2026-04-16 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(513, 8, 1, 1, 'Organise files: timesheet app', 'Organise working files for the Internal Timesheet App.', 'Not Started', '2026-04-24 09:00:00', '2026-05-06 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(514, 4, 1, 1, 'Checklist: inventory dashboard', 'Draft a personal checklist for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-08 09:00:00', '2026-04-22 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(515, 8, 1, 1, 'Clean test data: timesheet app', 'Prepare small sample data for the Internal Timesheet App.', 'Not Started', '2026-04-26 09:00:00', '2026-05-12 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(516, 4, 1, 1, 'Handoff notes: inventory dashboard', 'Write handoff notes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-10 09:00:00', '2026-04-28 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(517, 3, 2, 2, 'Prep notes: gateway', 'Set up personal prep notes for the API Gateway Modernisation.', 'Not Started', '2026-04-10 09:00:00', '2026-04-20 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(518, 9, 2, 2, 'Organise files: DB tuning', 'Organise working files for the Database Performance Tuning.', 'Not Started', '2026-04-25 09:00:00', '2026-05-07 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(519, 3, 2, 2, 'Checklist: gateway', 'Draft a personal checklist for the API Gateway Modernisation.', 'Not Started', '2026-04-12 09:00:00', '2026-04-26 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(520, 9, 2, 2, 'Clean test data: DB tuning', 'Prepare small sample data for the Database Performance Tuning.', 'Not Started', '2026-04-27 09:00:00', '2026-05-13 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(521, 3, 2, 2, 'Handoff notes: gateway', 'Write handoff notes for the API Gateway Modernisation.', 'Not Started', '2026-04-14 09:00:00', '2026-05-02 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(522, 2, 3, 3, 'Prep notes: mobile UI', 'Set up personal prep notes for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-09 09:00:00', '2026-04-19 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(523, 10, 3, 3, 'Organise files: notification service', 'Organise working files for the Notification Service Rollout.', 'Not Started', '2026-04-28 09:00:00', '2026-05-10 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(524, 2, 3, 3, 'Checklist: mobile UI', 'Draft a personal checklist for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-11 09:00:00', '2026-04-25 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(525, 10, 3, 3, 'Clean test data: notification service', 'Prepare small sample data for the Notification Service Rollout.', 'Not Started', '2026-04-30 09:00:00', '2026-05-16 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(526, 2, 3, 3, 'Handoff notes: mobile UI', 'Write handoff notes for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-13 09:00:00', '2026-05-01 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(527, 1, 4, 4, 'Prep notes: portal', 'Set up personal prep notes for the Customer Portal Redesign.', 'Not Started', '2026-04-03 09:00:00', '2026-04-13 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(528, 2, 4, 4, 'Organise files: mobile UI', 'Organise working files for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-09 09:00:00', '2026-04-21 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(529, 1, 4, 4, 'Checklist: portal', 'Draft a personal checklist for the Customer Portal Redesign.', 'Not Started', '2026-04-05 09:00:00', '2026-04-19 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(530, 2, 4, 4, 'Clean test data: mobile UI', 'Prepare small sample data for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-11 09:00:00', '2026-04-27 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(531, 1, 4, 4, 'Handoff notes: portal', 'Write handoff notes for the Customer Portal Redesign.', 'Not Started', '2026-04-07 09:00:00', '2026-04-25 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(532, 3, 5, 5, 'Prep notes: gateway', 'Set up personal prep notes for the API Gateway Modernisation.', 'Not Started', '2026-04-11 09:00:00', '2026-04-21 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(533, 10, 5, 5, 'Organise files: notification service', 'Organise working files for the Notification Service Rollout.', 'Not Started', '2026-04-28 09:00:00', '2026-05-10 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(534, 3, 5, 5, 'Checklist: gateway', 'Draft a personal checklist for the API Gateway Modernisation.', 'Not Started', '2026-04-13 09:00:00', '2026-04-27 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(535, 10, 5, 5, 'Clean test data: notification service', 'Prepare small sample data for the Notification Service Rollout.', 'Not Started', '2026-04-30 09:00:00', '2026-05-16 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(536, 3, 5, 5, 'Handoff notes: gateway', 'Write handoff notes for the API Gateway Modernisation.', 'Not Started', '2026-04-15 09:00:00', '2026-05-03 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(537, 3, 6, 6, 'Prep notes: gateway', 'Set up personal prep notes for the API Gateway Modernisation.', 'Not Started', '2026-04-10 09:00:00', '2026-04-20 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(538, 6, 6, 6, 'Organise files: ETL', 'Organise working files for the Analytics ETL Upgrade.', 'Not Started', '2026-04-17 09:00:00', '2026-04-29 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(539, 3, 6, 6, 'Checklist: gateway', 'Draft a personal checklist for the API Gateway Modernisation.', 'Not Started', '2026-04-12 09:00:00', '2026-04-26 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(540, 6, 6, 6, 'Clean test data: ETL', 'Prepare small sample data for the Analytics ETL Upgrade.', 'Not Started', '2026-04-19 09:00:00', '2026-05-05 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(541, 3, 6, 6, 'Handoff notes: gateway', 'Write handoff notes for the API Gateway Modernisation.', 'Not Started', '2026-04-14 09:00:00', '2026-05-02 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(542, 1, 7, 7, 'Prep notes: portal', 'Set up personal prep notes for the Customer Portal Redesign.', 'Not Started', '2026-04-04 09:00:00', '2026-04-14 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(543, 8, 7, 7, 'Organise files: timesheet app', 'Organise working files for the Internal Timesheet App.', 'Not Started', '2026-04-24 09:00:00', '2026-05-06 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(544, 1, 7, 7, 'Checklist: portal', 'Draft a personal checklist for the Customer Portal Redesign.', 'Not Started', '2026-04-06 09:00:00', '2026-04-20 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(545, 8, 7, 7, 'Clean test data: timesheet app', 'Prepare small sample data for the Internal Timesheet App.', 'Not Started', '2026-04-26 09:00:00', '2026-05-12 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(546, 1, 7, 7, 'Handoff notes: portal', 'Write handoff notes for the Customer Portal Redesign.', 'Not Started', '2026-04-08 09:00:00', '2026-04-26 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(547, 4, 8, 8, 'Prep notes: inventory dashboard', 'Set up personal prep notes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-05 09:00:00', '2026-04-15 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(548, 9, 8, 8, 'Organise files: DB tuning', 'Organise working files for the Database Performance Tuning.', 'Not Started', '2026-04-25 09:00:00', '2026-05-07 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(549, 4, 8, 8, 'Checklist: inventory dashboard', 'Draft a personal checklist for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-07 09:00:00', '2026-04-21 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(550, 9, 8, 8, 'Clean test data: DB tuning', 'Prepare small sample data for the Database Performance Tuning.', 'Not Started', '2026-04-27 09:00:00', '2026-05-13 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(551, 4, 8, 8, 'Handoff notes: inventory dashboard', 'Write handoff notes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-09 09:00:00', '2026-04-27 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(552, 2, 9, 9, 'Prep notes: mobile UI', 'Set up personal prep notes for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-09 09:00:00', '2026-04-19 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(553, 5, 9, 9, 'Organise files: sales automation', 'Organise working files for the Sales Pipeline Automation.', 'Not Started', '2026-04-14 09:00:00', '2026-04-26 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(554, 2, 9, 9, 'Checklist: mobile UI', 'Draft a personal checklist for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-11 09:00:00', '2026-04-25 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(555, 5, 9, 9, 'Clean test data: sales automation', 'Prepare small sample data for the Sales Pipeline Automation.', 'Not Started', '2026-04-16 09:00:00', '2026-05-02 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(556, 2, 9, 9, 'Handoff notes: mobile UI', 'Write handoff notes for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-13 09:00:00', '2026-05-01 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(557, 1, 10, 10, 'Prep notes: portal', 'Set up personal prep notes for the Customer Portal Redesign.', 'Not Started', '2026-04-03 09:00:00', '2026-04-13 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(558, 7, 10, 10, 'Organise files: knowledge search', 'Organise working files for the Knowledge Base Search.', 'Not Started', '2026-04-19 09:00:00', '2026-05-01 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(559, 1, 10, 10, 'Checklist: portal', 'Draft a personal checklist for the Customer Portal Redesign.', 'Not Started', '2026-04-05 09:00:00', '2026-04-19 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(560, 7, 10, 10, 'Clean test data: knowledge search', 'Prepare small sample data for the Knowledge Base Search.', 'Not Started', '2026-04-21 09:00:00', '2026-05-07 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(561, 1, 10, 10, 'Handoff notes: portal', 'Write handoff notes for the Customer Portal Redesign.', 'Not Started', '2026-04-07 09:00:00', '2026-04-25 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(562, 1, 11, 11, 'Prep notes: portal', 'Set up personal prep notes for the Customer Portal Redesign.', 'Not Started', '2026-04-04 09:00:00', '2026-04-14 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(563, 8, 11, 11, 'Organise files: timesheet app', 'Organise working files for the Internal Timesheet App.', 'Not Started', '2026-04-24 09:00:00', '2026-05-06 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(564, 1, 11, 11, 'Checklist: portal', 'Draft a personal checklist for the Customer Portal Redesign.', 'Not Started', '2026-04-06 09:00:00', '2026-04-20 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(565, 8, 11, 11, 'Clean test data: timesheet app', 'Prepare small sample data for the Internal Timesheet App.', 'Not Started', '2026-04-26 09:00:00', '2026-05-12 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(566, 1, 11, 11, 'Handoff notes: portal', 'Write handoff notes for the Customer Portal Redesign.', 'Not Started', '2026-04-08 09:00:00', '2026-04-26 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(567, 2, 12, 12, 'Prep notes: mobile UI', 'Set up personal prep notes for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-08 09:00:00', '2026-04-18 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(568, 7, 12, 12, 'Organise files: knowledge search', 'Organise working files for the Knowledge Base Search.', 'Not Started', '2026-04-19 09:00:00', '2026-05-01 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(569, 2, 12, 12, 'Checklist: mobile UI', 'Draft a personal checklist for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-10 09:00:00', '2026-04-24 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(570, 7, 12, 12, 'Clean test data: knowledge search', 'Prepare small sample data for the Knowledge Base Search.', 'Not Started', '2026-04-21 09:00:00', '2026-05-07 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(571, 2, 12, 12, 'Handoff notes: mobile UI', 'Write handoff notes for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-12 09:00:00', '2026-04-30 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(572, 2, 13, 13, 'Prep notes: mobile UI', 'Set up personal prep notes for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-09 09:00:00', '2026-04-19 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(573, 8, 13, 13, 'Organise files: timesheet app', 'Organise working files for the Internal Timesheet App.', 'Not Started', '2026-04-24 09:00:00', '2026-05-06 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(574, 2, 13, 13, 'Checklist: mobile UI', 'Draft a personal checklist for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-11 09:00:00', '2026-04-25 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(575, 8, 13, 13, 'Clean test data: timesheet app', 'Prepare small sample data for the Internal Timesheet App.', 'Not Started', '2026-04-26 09:00:00', '2026-05-12 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(576, 2, 13, 13, 'Handoff notes: mobile UI', 'Write handoff notes for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-13 09:00:00', '2026-05-01 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(577, 2, 14, 14, 'Prep notes: mobile UI', 'Set up personal prep notes for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-08 09:00:00', '2026-04-18 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(578, 8, 14, 14, 'Organise files: timesheet app', 'Organise working files for the Internal Timesheet App.', 'Not Started', '2026-04-23 09:00:00', '2026-05-05 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(579, 2, 14, 14, 'Checklist: mobile UI', 'Draft a personal checklist for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-10 09:00:00', '2026-04-24 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(580, 8, 14, 14, 'Clean test data: timesheet app', 'Prepare small sample data for the Internal Timesheet App.', 'Not Started', '2026-04-25 09:00:00', '2026-05-11 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(581, 2, 14, 14, 'Handoff notes: mobile UI', 'Write handoff notes for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-12 09:00:00', '2026-04-30 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(582, 2, 15, 15, 'Prep notes: mobile UI', 'Set up personal prep notes for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-09 09:00:00', '2026-04-19 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(583, 2, 15, 15, 'Organise files: mobile UI', 'Organise working files for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-10 09:00:00', '2026-04-22 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(584, 2, 15, 15, 'Checklist: mobile UI', 'Draft a personal checklist for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-11 09:00:00', '2026-04-25 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(585, 2, 15, 15, 'Clean test data: mobile UI', 'Prepare small sample data for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-12 09:00:00', '2026-04-28 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(586, 2, 15, 15, 'Handoff notes: mobile UI', 'Write handoff notes for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-13 09:00:00', '2026-05-01 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(587, 1, 16, 16, 'Prep notes: portal', 'Set up personal prep notes for the Customer Portal Redesign.', 'Not Started', '2026-04-03 09:00:00', '2026-04-13 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(588, 9, 16, 16, 'Organise files: DB tuning', 'Organise working files for the Database Performance Tuning.', 'Not Started', '2026-04-25 09:00:00', '2026-05-07 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(589, 1, 16, 16, 'Checklist: portal', 'Draft a personal checklist for the Customer Portal Redesign.', 'Not Started', '2026-04-05 09:00:00', '2026-04-19 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(590, 9, 16, 16, 'Clean test data: DB tuning', 'Prepare small sample data for the Database Performance Tuning.', 'Not Started', '2026-04-27 09:00:00', '2026-05-13 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(591, 1, 16, 16, 'Handoff notes: portal', 'Write handoff notes for the Customer Portal Redesign.', 'Not Started', '2026-04-07 09:00:00', '2026-04-25 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(592, 3, 17, 17, 'Prep notes: gateway', 'Set up personal prep notes for the API Gateway Modernisation.', 'Not Started', '2026-04-11 09:00:00', '2026-04-21 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(593, 3, 17, 17, 'Organise files: gateway', 'Organise working files for the API Gateway Modernisation.', 'Not Started', '2026-04-12 09:00:00', '2026-04-24 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(594, 3, 17, 17, 'Checklist: gateway', 'Draft a personal checklist for the API Gateway Modernisation.', 'Not Started', '2026-04-13 09:00:00', '2026-04-27 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(595, 3, 17, 17, 'Clean test data: gateway', 'Prepare small sample data for the API Gateway Modernisation.', 'Not Started', '2026-04-14 09:00:00', '2026-04-30 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(596, 3, 17, 17, 'Handoff notes: gateway', 'Write handoff notes for the API Gateway Modernisation.', 'Not Started', '2026-04-15 09:00:00', '2026-05-03 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(597, 3, 18, 18, 'Prep notes: gateway', 'Set up personal prep notes for the API Gateway Modernisation.', 'Not Started', '2026-04-10 09:00:00', '2026-04-20 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(598, 9, 18, 18, 'Organise files: DB tuning', 'Organise working files for the Database Performance Tuning.', 'Not Started', '2026-04-25 09:00:00', '2026-05-07 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(599, 3, 18, 18, 'Checklist: gateway', 'Draft a personal checklist for the API Gateway Modernisation.', 'Not Started', '2026-04-12 09:00:00', '2026-04-26 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(600, 9, 18, 18, 'Clean test data: DB tuning', 'Prepare small sample data for the Database Performance Tuning.', 'Not Started', '2026-04-27 09:00:00', '2026-05-13 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(601, 3, 18, 18, 'Handoff notes: gateway', 'Write handoff notes for the API Gateway Modernisation.', 'Not Started', '2026-04-14 09:00:00', '2026-05-02 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(602, 3, 19, 19, 'Prep notes: gateway', 'Set up personal prep notes for the API Gateway Modernisation.', 'Not Started', '2026-04-11 09:00:00', '2026-04-21 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(603, 10, 19, 19, 'Organise files: notification service', 'Organise working files for the Notification Service Rollout.', 'Not Started', '2026-04-28 09:00:00', '2026-05-10 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(604, 3, 19, 19, 'Checklist: gateway', 'Draft a personal checklist for the API Gateway Modernisation.', 'Not Started', '2026-04-13 09:00:00', '2026-04-27 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(605, 10, 19, 19, 'Clean test data: notification service', 'Prepare small sample data for the Notification Service Rollout.', 'Not Started', '2026-04-30 09:00:00', '2026-05-16 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(606, 3, 19, 19, 'Handoff notes: gateway', 'Write handoff notes for the API Gateway Modernisation.', 'Not Started', '2026-04-15 09:00:00', '2026-05-03 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(607, 3, 20, 20, 'Prep notes: gateway', 'Set up personal prep notes for the API Gateway Modernisation.', 'Not Started', '2026-04-10 09:00:00', '2026-04-20 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(608, 10, 20, 20, 'Organise files: notification service', 'Organise working files for the Notification Service Rollout.', 'Not Started', '2026-04-27 09:00:00', '2026-05-09 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(609, 3, 20, 20, 'Checklist: gateway', 'Draft a personal checklist for the API Gateway Modernisation.', 'Not Started', '2026-04-12 09:00:00', '2026-04-26 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(610, 10, 20, 20, 'Clean test data: notification service', 'Prepare small sample data for the Notification Service Rollout.', 'Not Started', '2026-04-29 09:00:00', '2026-05-15 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(611, 3, 20, 20, 'Handoff notes: gateway', 'Write handoff notes for the API Gateway Modernisation.', 'Not Started', '2026-04-14 09:00:00', '2026-05-02 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(612, 7, 21, 21, 'Prep notes: knowledge search', 'Set up personal prep notes for the Knowledge Base Search.', 'Not Started', '2026-04-19 09:00:00', '2026-04-29 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(613, 8, 21, 21, 'Organise files: timesheet app', 'Organise working files for the Internal Timesheet App.', 'Not Started', '2026-04-24 09:00:00', '2026-05-06 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(614, 7, 21, 21, 'Checklist: knowledge search', 'Draft a personal checklist for the Knowledge Base Search.', 'Not Started', '2026-04-21 09:00:00', '2026-05-05 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(615, 8, 21, 21, 'Clean test data: timesheet app', 'Prepare small sample data for the Internal Timesheet App.', 'Not Started', '2026-04-26 09:00:00', '2026-05-12 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(616, 7, 21, 21, 'Handoff notes: knowledge search', 'Write handoff notes for the Knowledge Base Search.', 'Not Started', '2026-04-23 09:00:00', '2026-05-11 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(617, 3, 22, 22, 'Prep notes: gateway', 'Set up personal prep notes for the API Gateway Modernisation.', 'Not Started', '2026-04-10 09:00:00', '2026-04-20 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(618, 6, 22, 22, 'Organise files: ETL', 'Organise working files for the Analytics ETL Upgrade.', 'Not Started', '2026-04-17 09:00:00', '2026-04-29 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(619, 3, 22, 22, 'Checklist: gateway', 'Draft a personal checklist for the API Gateway Modernisation.', 'Not Started', '2026-04-12 09:00:00', '2026-04-26 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(620, 6, 22, 22, 'Clean test data: ETL', 'Prepare small sample data for the Analytics ETL Upgrade.', 'Not Started', '2026-04-19 09:00:00', '2026-05-05 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(621, 3, 22, 22, 'Handoff notes: gateway', 'Write handoff notes for the API Gateway Modernisation.', 'Not Started', '2026-04-14 09:00:00', '2026-05-02 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(622, 4, 23, 23, 'Prep notes: inventory dashboard', 'Set up personal prep notes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-06 09:00:00', '2026-04-16 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(623, 6, 23, 23, 'Organise files: ETL', 'Organise working files for the Analytics ETL Upgrade.', 'Not Started', '2026-04-18 09:00:00', '2026-04-30 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(624, 4, 23, 23, 'Checklist: inventory dashboard', 'Draft a personal checklist for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-08 09:00:00', '2026-04-22 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(625, 6, 23, 23, 'Clean test data: ETL', 'Prepare small sample data for the Analytics ETL Upgrade.', 'Not Started', '2026-04-20 09:00:00', '2026-05-06 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(626, 4, 23, 23, 'Handoff notes: inventory dashboard', 'Write handoff notes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-10 09:00:00', '2026-04-28 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(627, 4, 24, 24, 'Prep notes: inventory dashboard', 'Set up personal prep notes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-05 09:00:00', '2026-04-15 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(628, 9, 24, 24, 'Organise files: DB tuning', 'Organise working files for the Database Performance Tuning.', 'Not Started', '2026-04-25 09:00:00', '2026-05-07 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(629, 4, 24, 24, 'Checklist: inventory dashboard', 'Draft a personal checklist for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-07 09:00:00', '2026-04-21 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(630, 9, 24, 24, 'Clean test data: DB tuning', 'Prepare small sample data for the Database Performance Tuning.', 'Not Started', '2026-04-27 09:00:00', '2026-05-13 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(631, 4, 24, 24, 'Handoff notes: inventory dashboard', 'Write handoff notes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-09 09:00:00', '2026-04-27 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(632, 4, 25, 25, 'Prep notes: inventory dashboard', 'Set up personal prep notes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-06 09:00:00', '2026-04-16 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(633, 6, 25, 25, 'Organise files: ETL', 'Organise working files for the Analytics ETL Upgrade.', 'Not Started', '2026-04-18 09:00:00', '2026-04-30 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(634, 4, 25, 25, 'Checklist: inventory dashboard', 'Draft a personal checklist for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-08 09:00:00', '2026-04-22 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(635, 6, 25, 25, 'Clean test data: ETL', 'Prepare small sample data for the Analytics ETL Upgrade.', 'Not Started', '2026-04-20 09:00:00', '2026-05-06 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(636, 4, 25, 25, 'Handoff notes: inventory dashboard', 'Write handoff notes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-10 09:00:00', '2026-04-28 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(637, 6, 26, 26, 'Prep notes: ETL', 'Set up personal prep notes for the Analytics ETL Upgrade.', 'Not Started', '2026-04-16 09:00:00', '2026-04-26 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(638, 7, 26, 26, 'Organise files: knowledge search', 'Organise working files for the Knowledge Base Search.', 'Not Started', '2026-04-19 09:00:00', '2026-05-01 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(639, 6, 26, 26, 'Checklist: ETL', 'Draft a personal checklist for the Analytics ETL Upgrade.', 'Not Started', '2026-04-18 09:00:00', '2026-05-02 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(640, 7, 26, 26, 'Clean test data: knowledge search', 'Prepare small sample data for the Knowledge Base Search.', 'Not Started', '2026-04-21 09:00:00', '2026-05-07 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(641, 6, 26, 26, 'Handoff notes: ETL', 'Write handoff notes for the Analytics ETL Upgrade.', 'Not Started', '2026-04-20 09:00:00', '2026-05-08 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(642, 1, 27, 27, 'Prep notes: portal', 'Set up personal prep notes for the Customer Portal Redesign.', 'Not Started', '2026-04-04 09:00:00', '2026-04-14 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(643, 7, 27, 27, 'Organise files: knowledge search', 'Organise working files for the Knowledge Base Search.', 'Not Started', '2026-04-20 09:00:00', '2026-05-02 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(644, 1, 27, 27, 'Checklist: portal', 'Draft a personal checklist for the Customer Portal Redesign.', 'Not Started', '2026-04-06 09:00:00', '2026-04-20 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(645, 7, 27, 27, 'Clean test data: knowledge search', 'Prepare small sample data for the Knowledge Base Search.', 'Not Started', '2026-04-22 09:00:00', '2026-05-08 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(646, 1, 27, 27, 'Handoff notes: portal', 'Write handoff notes for the Customer Portal Redesign.', 'Not Started', '2026-04-08 09:00:00', '2026-04-26 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(647, 1, 28, 28, 'Prep notes: portal', 'Set up personal prep notes for the Customer Portal Redesign.', 'Not Started', '2026-04-03 09:00:00', '2026-04-13 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(648, 8, 28, 28, 'Organise files: timesheet app', 'Organise working files for the Internal Timesheet App.', 'Not Started', '2026-04-23 09:00:00', '2026-05-05 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(649, 1, 28, 28, 'Checklist: portal', 'Draft a personal checklist for the Customer Portal Redesign.', 'Not Started', '2026-04-05 09:00:00', '2026-04-19 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(650, 8, 28, 28, 'Clean test data: timesheet app', 'Prepare small sample data for the Internal Timesheet App.', 'Not Started', '2026-04-25 09:00:00', '2026-05-11 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(651, 1, 28, 28, 'Handoff notes: portal', 'Write handoff notes for the Customer Portal Redesign.', 'Not Started', '2026-04-07 09:00:00', '2026-04-25 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(652, 2, 29, 29, 'Prep notes: mobile UI', 'Set up personal prep notes for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-09 09:00:00', '2026-04-19 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(653, 7, 29, 29, 'Organise files: knowledge search', 'Organise working files for the Knowledge Base Search.', 'Not Started', '2026-04-20 09:00:00', '2026-05-02 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(654, 2, 29, 29, 'Checklist: mobile UI', 'Draft a personal checklist for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-11 09:00:00', '2026-04-25 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(655, 7, 29, 29, 'Clean test data: knowledge search', 'Prepare small sample data for the Knowledge Base Search.', 'Not Started', '2026-04-22 09:00:00', '2026-05-08 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(656, 2, 29, 29, 'Handoff notes: mobile UI', 'Write handoff notes for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-13 09:00:00', '2026-05-01 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(657, 2, 30, 30, 'Prep notes: mobile UI', 'Set up personal prep notes for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-08 09:00:00', '2026-04-18 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(658, 3, 30, 30, 'Organise files: gateway', 'Organise working files for the API Gateway Modernisation.', 'Not Started', '2026-04-11 09:00:00', '2026-04-23 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(659, 2, 30, 30, 'Checklist: mobile UI', 'Draft a personal checklist for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-10 09:00:00', '2026-04-24 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(660, 3, 30, 30, 'Clean test data: gateway', 'Prepare small sample data for the API Gateway Modernisation.', 'Not Started', '2026-04-13 09:00:00', '2026-04-29 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(661, 2, 30, 30, 'Handoff notes: mobile UI', 'Write handoff notes for the Field Sales Mobile UI Refresh.', 'Not Started', '2026-04-12 09:00:00', '2026-04-30 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(662, 5, 31, 31, 'Prep notes: sales automation', 'Set up personal prep notes for the Sales Pipeline Automation.', 'Not Started', '2026-04-13 09:00:00', '2026-04-23 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(663, 10, 31, 31, 'Organise files: notification service', 'Organise working files for the Notification Service Rollout.', 'Not Started', '2026-04-28 09:00:00', '2026-05-10 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(664, 5, 31, 31, 'Checklist: sales automation', 'Draft a personal checklist for the Sales Pipeline Automation.', 'Not Started', '2026-04-15 09:00:00', '2026-04-29 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(665, 10, 31, 31, 'Clean test data: notification service', 'Prepare small sample data for the Notification Service Rollout.', 'Not Started', '2026-04-30 09:00:00', '2026-05-16 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(666, 5, 31, 31, 'Handoff notes: sales automation', 'Write handoff notes for the Sales Pipeline Automation.', 'Not Started', '2026-04-17 09:00:00', '2026-05-05 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(667, 4, 32, 32, 'Prep notes: inventory dashboard', 'Set up personal prep notes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-05 09:00:00', '2026-04-15 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(668, 9, 32, 32, 'Organise files: DB tuning', 'Organise working files for the Database Performance Tuning.', 'Not Started', '2026-04-25 09:00:00', '2026-05-07 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(669, 4, 32, 32, 'Checklist: inventory dashboard', 'Draft a personal checklist for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-07 09:00:00', '2026-04-21 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(670, 9, 32, 32, 'Clean test data: DB tuning', 'Prepare small sample data for the Database Performance Tuning.', 'Not Started', '2026-04-27 09:00:00', '2026-05-13 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(671, 4, 32, 32, 'Handoff notes: inventory dashboard', 'Write handoff notes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-09 09:00:00', '2026-04-27 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(672, 4, 33, 33, 'Prep notes: inventory dashboard', 'Set up personal prep notes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-06 09:00:00', '2026-04-16 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(673, 9, 33, 33, 'Organise files: DB tuning', 'Organise working files for the Database Performance Tuning.', 'Not Started', '2026-04-26 09:00:00', '2026-05-08 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(674, 4, 33, 33, 'Checklist: inventory dashboard', 'Draft a personal checklist for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-08 09:00:00', '2026-04-22 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(675, 9, 33, 33, 'Clean test data: DB tuning', 'Prepare small sample data for the Database Performance Tuning.', 'Not Started', '2026-04-28 09:00:00', '2026-05-14 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(676, 4, 33, 33, 'Handoff notes: inventory dashboard', 'Write handoff notes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-10 09:00:00', '2026-04-28 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(677, 4, 34, 34, 'Prep notes: inventory dashboard', 'Set up personal prep notes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-05 09:00:00', '2026-04-15 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(678, 9, 34, 34, 'Organise files: DB tuning', 'Organise working files for the Database Performance Tuning.', 'Not Started', '2026-04-25 09:00:00', '2026-05-07 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(679, 4, 34, 34, 'Checklist: inventory dashboard', 'Draft a personal checklist for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-07 09:00:00', '2026-04-21 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(680, 9, 34, 34, 'Clean test data: DB tuning', 'Prepare small sample data for the Database Performance Tuning.', 'Not Started', '2026-04-27 09:00:00', '2026-05-13 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(681, 4, 34, 34, 'Handoff notes: inventory dashboard', 'Write handoff notes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-09 09:00:00', '2026-04-27 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(682, 5, 35, 35, 'Prep notes: sales automation', 'Set up personal prep notes for the Sales Pipeline Automation.', 'Not Started', '2026-04-13 09:00:00', '2026-04-23 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(683, 9, 35, 35, 'Organise files: DB tuning', 'Organise working files for the Database Performance Tuning.', 'Not Started', '2026-04-26 09:00:00', '2026-05-08 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(684, 5, 35, 35, 'Checklist: sales automation', 'Draft a personal checklist for the Sales Pipeline Automation.', 'Not Started', '2026-04-15 09:00:00', '2026-04-29 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(685, 9, 35, 35, 'Clean test data: DB tuning', 'Prepare small sample data for the Database Performance Tuning.', 'Not Started', '2026-04-28 09:00:00', '2026-05-14 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(686, 5, 35, 35, 'Handoff notes: sales automation', 'Write handoff notes for the Sales Pipeline Automation.', 'Not Started', '2026-04-17 09:00:00', '2026-05-05 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(687, 1, 36, 36, 'Prep notes: portal', 'Set up personal prep notes for the Customer Portal Redesign.', 'Not Started', '2026-04-03 09:00:00', '2026-04-13 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(688, 10, 36, 36, 'Organise files: notification service', 'Organise working files for the Notification Service Rollout.', 'Not Started', '2026-04-27 09:00:00', '2026-05-09 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(689, 1, 36, 36, 'Checklist: portal', 'Draft a personal checklist for the Customer Portal Redesign.', 'Not Started', '2026-04-05 09:00:00', '2026-04-19 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(690, 10, 36, 36, 'Clean test data: notification service', 'Prepare small sample data for the Notification Service Rollout.', 'Not Started', '2026-04-29 09:00:00', '2026-05-15 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(691, 1, 36, 36, 'Handoff notes: portal', 'Write handoff notes for the Customer Portal Redesign.', 'Not Started', '2026-04-07 09:00:00', '2026-04-25 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(692, 4, 37, 37, 'Prep notes: inventory dashboard', 'Set up personal prep notes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-06 09:00:00', '2026-04-16 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(693, 5, 37, 37, 'Organise files: sales automation', 'Organise working files for the Sales Pipeline Automation.', 'Not Started', '2026-04-14 09:00:00', '2026-04-26 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(694, 4, 37, 37, 'Checklist: inventory dashboard', 'Draft a personal checklist for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-08 09:00:00', '2026-04-22 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(695, 5, 37, 37, 'Clean test data: sales automation', 'Prepare small sample data for the Sales Pipeline Automation.', 'Not Started', '2026-04-16 09:00:00', '2026-05-02 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(696, 4, 37, 37, 'Handoff notes: inventory dashboard', 'Write handoff notes for the Inventory Reporting Dashboard.', 'Not Started', '2026-04-10 09:00:00', '2026-04-28 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(697, 5, 38, 38, 'Prep notes: sales automation', 'Set up personal prep notes for the Sales Pipeline Automation.', 'Not Started', '2026-04-12 09:00:00', '2026-04-22 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(698, 10, 38, 38, 'Organise files: notification service', 'Organise working files for the Notification Service Rollout.', 'Not Started', '2026-04-27 09:00:00', '2026-05-09 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(699, 5, 38, 38, 'Checklist: sales automation', 'Draft a personal checklist for the Sales Pipeline Automation.', 'Not Started', '2026-04-14 09:00:00', '2026-04-28 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(700, 10, 38, 38, 'Clean test data: notification service', 'Prepare small sample data for the Notification Service Rollout.', 'Not Started', '2026-04-29 09:00:00', '2026-05-15 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(701, 5, 38, 38, 'Handoff notes: sales automation', 'Write handoff notes for the Sales Pipeline Automation.', 'Not Started', '2026-04-16 09:00:00', '2026-05-04 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(702, 1, 39, 39, 'Prep notes: portal', 'Set up personal prep notes for the Customer Portal Redesign.', 'Not Started', '2026-04-04 09:00:00', '2026-04-14 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(703, 10, 39, 39, 'Organise files: notification service', 'Organise working files for the Notification Service Rollout.', 'Not Started', '2026-04-28 09:00:00', '2026-05-10 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(704, 1, 39, 39, 'Checklist: portal', 'Draft a personal checklist for the Customer Portal Redesign.', 'Not Started', '2026-04-06 09:00:00', '2026-04-20 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(705, 10, 39, 39, 'Clean test data: notification service', 'Prepare small sample data for the Notification Service Rollout.', 'Not Started', '2026-04-30 09:00:00', '2026-05-16 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(706, 1, 39, 39, 'Handoff notes: portal', 'Write handoff notes for the Customer Portal Redesign.', 'Not Started', '2026-04-08 09:00:00', '2026-04-26 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(707, 5, 40, 40, 'Prep notes: sales automation', 'Set up personal prep notes for the Sales Pipeline Automation.', 'Not Started', '2026-04-12 09:00:00', '2026-04-22 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(708, 10, 40, 40, 'Organise files: notification service', 'Organise working files for the Notification Service Rollout.', 'Not Started', '2026-04-27 09:00:00', '2026-05-09 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(709, 5, 40, 40, 'Checklist: sales automation', 'Draft a personal checklist for the Sales Pipeline Automation.', 'Not Started', '2026-04-14 09:00:00', '2026-04-28 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(710, 10, 40, 40, 'Clean test data: notification service', 'Prepare small sample data for the Notification Service Rollout.', 'Not Started', '2026-04-29 09:00:00', '2026-05-15 09:00:00', 'Medium', 'S', 'private', NULL, NULL, NULL, NULL, NULL, 1),
(711, 5, 40, 40, 'Handoff notes: sales automation', 'Write handoff notes for the Sales Pipeline Automation.', 'Not Started', '2026-04-16 09:00:00', '2026-05-04 09:00:00', 'Low', 'XS', 'private', NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Task_dependency`
--

CREATE TABLE `Task_dependency` (
  `task_id` int NOT NULL,
  `dependency_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Task_dependency`
--

INSERT INTO `Task_dependency` (`task_id`, `dependency_id`) VALUES
(2, 1),
(3, 2),
(4, 2),
(5, 4),
(7, 6),
(8, 7),
(9, 7),
(10, 9),
(12, 11),
(13, 12),
(14, 12),
(15, 14),
(17, 16),
(18, 17),
(19, 17),
(20, 19),
(22, 21),
(23, 22),
(24, 22),
(25, 24),
(27, 26),
(28, 27),
(29, 27),
(30, 29),
(32, 31),
(33, 32),
(34, 32),
(35, 34),
(37, 36),
(38, 37),
(39, 37),
(40, 39),
(42, 41),
(43, 42),
(44, 42),
(45, 44),
(47, 46),
(48, 47),
(49, 47),
(50, 49),
(52, 51),
(53, 52),
(54, 52),
(55, 54),
(57, 56),
(58, 57),
(59, 57),
(60, 59),
(62, 61),
(63, 62),
(64, 62),
(65, 64),
(67, 66),
(68, 67),
(69, 67),
(70, 69),
(72, 71),
(73, 72),
(74, 72),
(75, 74),
(77, 76),
(78, 77),
(79, 77),
(80, 79),
(82, 81),
(83, 82),
(84, 82),
(85, 84),
(87, 86),
(88, 87),
(89, 87),
(90, 89),
(92, 91),
(93, 92),
(94, 92),
(95, 94),
(97, 96),
(98, 97),
(99, 97),
(100, 99),
(102, 101),
(103, 102),
(104, 102),
(105, 104),
(107, 106),
(108, 107),
(109, 107),
(110, 109),
(112, 111),
(113, 112),
(114, 112),
(115, 114),
(117, 116),
(118, 117),
(119, 117),
(120, 119),
(122, 121),
(123, 122),
(124, 122),
(125, 124),
(127, 126),
(128, 127),
(129, 127),
(130, 129),
(132, 131),
(133, 132),
(134, 132),
(135, 134),
(137, 136),
(138, 137),
(139, 137),
(140, 139),
(142, 141),
(143, 142),
(144, 142),
(145, 144),
(147, 146),
(148, 147),
(149, 147),
(150, 149),
(152, 151),
(153, 152),
(154, 152),
(155, 154),
(157, 156),
(158, 157),
(159, 157),
(160, 159),
(162, 161),
(163, 162),
(164, 162),
(165, 164),
(167, 166),
(168, 167),
(169, 167),
(170, 169),
(172, 171),
(173, 172),
(174, 172),
(175, 174),
(177, 176),
(178, 177),
(179, 177),
(180, 179),
(182, 181),
(183, 182),
(184, 182),
(185, 184),
(187, 186),
(188, 187),
(189, 187),
(190, 189),
(192, 191),
(193, 192),
(194, 192),
(195, 194),
(197, 196),
(198, 197),
(199, 197),
(200, 199),
(202, 201),
(203, 202),
(204, 202),
(205, 204),
(207, 206),
(208, 207),
(209, 207),
(210, 209),
(212, 211),
(213, 212),
(214, 212),
(215, 214),
(217, 216),
(218, 217),
(219, 217),
(220, 219),
(222, 221),
(223, 222),
(224, 222),
(225, 224),
(227, 226),
(228, 227),
(229, 227),
(230, 229),
(232, 231),
(233, 232),
(234, 232),
(235, 234),
(237, 236),
(238, 237),
(239, 237),
(240, 239),
(242, 241),
(243, 242),
(244, 242),
(245, 244),
(247, 246),
(248, 247),
(249, 247),
(250, 249),
(252, 251),
(253, 252),
(254, 252),
(255, 254),
(257, 256),
(258, 257),
(259, 257),
(260, 259),
(262, 261),
(263, 262),
(264, 262),
(265, 264),
(267, 266),
(268, 267),
(269, 267),
(270, 269),
(272, 271),
(273, 272),
(274, 272),
(275, 274),
(277, 276),
(278, 277),
(279, 277),
(280, 279),
(282, 281),
(283, 282),
(284, 282),
(285, 284),
(287, 286),
(288, 287),
(289, 287),
(290, 289),
(292, 291),
(293, 292),
(294, 292),
(295, 294),
(297, 296),
(298, 297),
(299, 297),
(300, 299),
(302, 301),
(303, 302),
(304, 302),
(305, 304),
(307, 306),
(308, 307),
(309, 307),
(310, 309),
(312, 311),
(313, 312),
(314, 312),
(315, 314),
(317, 316),
(318, 317),
(319, 317),
(320, 319),
(322, 321),
(323, 322),
(324, 322),
(325, 324),
(327, 326),
(328, 327),
(329, 327),
(330, 329),
(332, 331),
(333, 332),
(334, 332),
(335, 334),
(337, 336),
(338, 337),
(339, 337),
(340, 339),
(342, 341),
(343, 342),
(344, 342),
(345, 344),
(347, 346),
(348, 347),
(349, 347),
(350, 349),
(352, 351),
(353, 352),
(354, 352),
(355, 354),
(357, 356),
(358, 357),
(359, 357),
(360, 359),
(362, 361),
(363, 362),
(364, 362),
(365, 364),
(367, 366),
(368, 367),
(369, 367),
(370, 369),
(372, 371),
(373, 372),
(374, 372),
(375, 374),
(377, 376),
(378, 377),
(379, 377),
(380, 379),
(382, 381),
(383, 382),
(384, 382),
(385, 384),
(387, 386),
(388, 387),
(389, 387),
(390, 389),
(392, 391),
(393, 392),
(394, 392),
(395, 394),
(397, 396),
(398, 397),
(399, 397),
(400, 399),
(402, 401),
(403, 402),
(404, 402),
(405, 404),
(407, 406),
(408, 407),
(409, 407),
(410, 409),
(412, 411),
(413, 412),
(414, 412),
(415, 414),
(417, 416),
(418, 417),
(419, 417),
(420, 419),
(422, 421),
(423, 422),
(424, 422),
(425, 424),
(427, 426),
(428, 427),
(429, 427),
(430, 429),
(432, 431),
(433, 432),
(434, 432),
(435, 434),
(437, 436),
(438, 437),
(439, 437),
(440, 439),
(442, 441),
(443, 442),
(444, 442),
(445, 444),
(447, 446),
(448, 447),
(449, 447),
(450, 449);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Attachments`
--
ALTER TABLE `Attachments`
  ADD PRIMARY KEY (`attachment_id`),
  ADD KEY `Attachments_ibfk_1` (`uploader_id`);

--
-- Indexes for table `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `Category_Assignment`
--
ALTER TABLE `Category_Assignment`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `Category_Assignment_ibfk_1` (`category_id`),
  ADD KEY `Category_Assignment_ibfk_2` (`project_id`),
  ADD KEY `Category_Assignment_ibfk_3` (`employee_id`);

--
-- Indexes for table `Chat_Project_Link`
--
ALTER TABLE `Chat_Project_Link`
  ADD PRIMARY KEY (`conversation_id`,`project_id`),
  ADD KEY `Chat_Project_Link_ibfk_2` (`project_id`);

--
-- Indexes for table `Conversations`
--
ALTER TABLE `Conversations`
  ADD PRIMARY KEY (`conversation_id`),
  ADD KEY `Conversations_ibfk_1` (`creator_id`),
  ADD KEY `Conversations_ibfk_2` (`last_message_id`);

--
-- Indexes for table `Conversation_User_Settings`
--
ALTER TABLE `Conversation_User_Settings`
  ADD PRIMARY KEY (`conversation_id`,`user_id`),
  ADD KEY `Conversation_User_Settings_ibfk_2` (`user_id`);

--
-- Indexes for table `Employees`
--
ALTER TABLE `Employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `Employees_ibfk_1` (`manager_id`);

--
-- Indexes for table `Favourites`
--
ALTER TABLE `Favourites`
  ADD PRIMARY KEY (`employee_id`,`favourited_employee_id`),
  ADD KEY `Favourites_ibfk_2` (`favourited_employee_id`);

--
-- Indexes for table `Mentions`
--
ALTER TABLE `Mentions`
  ADD PRIMARY KEY (`message_id`,`mentioned_user_id`),
  ADD KEY `Mentions_ibfk_2` (`mentioned_user_id`);

--
-- Indexes for table `Messages`
--
ALTER TABLE `Messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `Messages_ibfk_1` (`conversation_id`),
  ADD KEY `Messages_ibfk_2` (`sender_id`),
  ADD KEY `Messages_ibfk_3` (`parent_message_id`);

--
-- Indexes for table `Message_Attachments`
--
ALTER TABLE `Message_Attachments`
  ADD PRIMARY KEY (`message_id`,`attachment_id`),
  ADD KEY `Message_Attachments_ibfk_2` (`attachment_id`);

--
-- Indexes for table `Message_Interactions`
--
ALTER TABLE `Message_Interactions`
  ADD PRIMARY KEY (`message_id`,`user_id`),
  ADD KEY `Message_Interactions_ibfk_2` (`user_id`);

--
-- Indexes for table `Notifications`
--
ALTER TABLE `Notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `Notifications_ibfk_2` (`receiver_id`);

--
-- Indexes for table `Projects`
--
ALTER TABLE `Projects`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `Projects_ibfk_1` (`teamleader_id`),
  ADD KEY `Projects_ibfk_2` (`conversation_id`);

--
-- Indexes for table `Project_Assignment`
--
ALTER TABLE `Project_Assignment`
  ADD PRIMARY KEY (`project_id`,`employee_id`),
  ADD KEY `Project_Assignment_ibfk_2` (`employee_id`);

--
-- Indexes for table `Project_Budget_Transactions`
--
ALTER TABLE `Project_Budget_Transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `fk_project_budget_transactions_created_by` (`created_by`),
  ADD KEY `idx_pbt_project_id` (`project_id`),
  ADD KEY `idx_pbt_transaction_type` (`transaction_type`),
  ADD KEY `idx_pbt_transaction_date` (`transaction_date`),
  ADD KEY `idx_pbt_project_date` (`project_id`,`transaction_date`);

--
-- Indexes for table `Tasks`
--
ALTER TABLE `Tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `Tasks_ibfk_1` (`project_id`),
  ADD KEY `Tasks_ibfk_2` (`assigner_id`),
  ADD KEY `Tasks_ibfk_3` (`assignee_id`),
  ADD KEY `Tasks_ibfk_4` (`completed_by_id`);

--
-- Indexes for table `Task_dependency`
--
ALTER TABLE `Task_dependency`
  ADD PRIMARY KEY (`task_id`,`dependency_id`),
  ADD KEY `Task_dependency_ibfk_2` (`dependency_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Attachments`
--
ALTER TABLE `Attachments`
  MODIFY `attachment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Categories`
--
ALTER TABLE `Categories`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Category_Assignment`
--
ALTER TABLE `Category_Assignment`
  MODIFY `assignment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `Conversations`
--
ALTER TABLE `Conversations`
  MODIFY `conversation_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `Employees`
--
ALTER TABLE `Employees`
  MODIFY `employee_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `Messages`
--
ALTER TABLE `Messages`
  MODIFY `message_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `Notifications`
--
ALTER TABLE `Notifications`
  MODIFY `notification_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `Projects`
--
ALTER TABLE `Projects`
  MODIFY `project_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Project_Budget_Transactions`
--
ALTER TABLE `Project_Budget_Transactions`
  MODIFY `transaction_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Tasks`
--
ALTER TABLE `Tasks`
  MODIFY `task_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=767;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Attachments`
--
ALTER TABLE `Attachments`
  ADD CONSTRAINT `Attachments_ibfk_1` FOREIGN KEY (`uploader_id`) REFERENCES `Employees` (`employee_id`);

--
-- Constraints for table `Category_Assignment`
--
ALTER TABLE `Category_Assignment`
  ADD CONSTRAINT `Category_Assignment_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `Categories` (`category_id`),
  ADD CONSTRAINT `Category_Assignment_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `Projects` (`project_id`),
  ADD CONSTRAINT `Category_Assignment_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `Employees` (`employee_id`);

--
-- Constraints for table `Chat_Project_Link`
--
ALTER TABLE `Chat_Project_Link`
  ADD CONSTRAINT `Chat_Project_Link_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `Conversations` (`conversation_id`),
  ADD CONSTRAINT `Chat_Project_Link_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `Projects` (`project_id`);

--
-- Constraints for table `Conversations`
--
ALTER TABLE `Conversations`
  ADD CONSTRAINT `Conversations_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `Employees` (`employee_id`),
  ADD CONSTRAINT `Conversations_ibfk_2` FOREIGN KEY (`last_message_id`) REFERENCES `Messages` (`message_id`);

--
-- Constraints for table `Conversation_User_Settings`
--
ALTER TABLE `Conversation_User_Settings`
  ADD CONSTRAINT `Conversation_User_Settings_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `Conversations` (`conversation_id`),
  ADD CONSTRAINT `Conversation_User_Settings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Employees` (`employee_id`);

--
-- Constraints for table `Employees`
--
ALTER TABLE `Employees`
  ADD CONSTRAINT `Employees_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `Employees` (`employee_id`);

--
-- Constraints for table `Favourites`
--
ALTER TABLE `Favourites`
  ADD CONSTRAINT `Favourites_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `Employees` (`employee_id`),
  ADD CONSTRAINT `Favourites_ibfk_2` FOREIGN KEY (`favourited_employee_id`) REFERENCES `Employees` (`employee_id`);

--
-- Constraints for table `Mentions`
--
ALTER TABLE `Mentions`
  ADD CONSTRAINT `Mentions_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `Messages` (`message_id`),
  ADD CONSTRAINT `Mentions_ibfk_2` FOREIGN KEY (`mentioned_user_id`) REFERENCES `Employees` (`employee_id`);

--
-- Constraints for table `Messages`
--
ALTER TABLE `Messages`
  ADD CONSTRAINT `Messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `Conversations` (`conversation_id`),
  ADD CONSTRAINT `Messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `Employees` (`employee_id`),
  ADD CONSTRAINT `Messages_ibfk_3` FOREIGN KEY (`parent_message_id`) REFERENCES `Messages` (`message_id`);

--
-- Constraints for table `Message_Attachments`
--
ALTER TABLE `Message_Attachments`
  ADD CONSTRAINT `Message_Attachments_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `Messages` (`message_id`),
  ADD CONSTRAINT `Message_Attachments_ibfk_2` FOREIGN KEY (`attachment_id`) REFERENCES `Attachments` (`attachment_id`);

--
-- Constraints for table `Message_Interactions`
--
ALTER TABLE `Message_Interactions`
  ADD CONSTRAINT `Message_Interactions_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `Messages` (`message_id`),
  ADD CONSTRAINT `Message_Interactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Employees` (`employee_id`);

--
-- Constraints for table `Notifications`
--
ALTER TABLE `Notifications`
  ADD CONSTRAINT `Notifications_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `Employees` (`employee_id`);

--
-- Constraints for table `Projects`
--
ALTER TABLE `Projects`
  ADD CONSTRAINT `Projects_ibfk_1` FOREIGN KEY (`teamleader_id`) REFERENCES `Employees` (`employee_id`),
  ADD CONSTRAINT `Projects_ibfk_2` FOREIGN KEY (`conversation_id`) REFERENCES `Conversations` (`conversation_id`);

--
-- Constraints for table `Project_Assignment`
--
ALTER TABLE `Project_Assignment`
  ADD CONSTRAINT `Project_Assignment_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `Projects` (`project_id`),
  ADD CONSTRAINT `Project_Assignment_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `Employees` (`employee_id`);

--
-- Constraints for table `Project_Budget_Transactions`
--
ALTER TABLE `Project_Budget_Transactions`
  ADD CONSTRAINT `fk_project_budget_transactions_created_by` FOREIGN KEY (`created_by`) REFERENCES `Employees` (`employee_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_project_budget_transactions_project` FOREIGN KEY (`project_id`) REFERENCES `Projects` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Tasks`
--
ALTER TABLE `Tasks`
  ADD CONSTRAINT `Tasks_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `Projects` (`project_id`),
  ADD CONSTRAINT `Tasks_ibfk_2` FOREIGN KEY (`assigner_id`) REFERENCES `Employees` (`employee_id`),
  ADD CONSTRAINT `Tasks_ibfk_3` FOREIGN KEY (`assignee_id`) REFERENCES `Employees` (`employee_id`),
  ADD CONSTRAINT `Tasks_ibfk_4` FOREIGN KEY (`completed_by_id`) REFERENCES `Employees` (`employee_id`);

--
-- Constraints for table `Task_dependency`
--
ALTER TABLE `Task_dependency`
  ADD CONSTRAINT `Task_dependency_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `Tasks` (`task_id`),
  ADD CONSTRAINT `Task_dependency_ibfk_2` FOREIGN KEY (`dependency_id`) REFERENCES `Tasks` (`task_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
