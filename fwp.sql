-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 16, 2018 at 09:13 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fwp`
--

-- --------------------------------------------------------

--
-- Table structure for table `calendars`
--

CREATE TABLE `calendars` (
  `id` int(10) UNSIGNED NOT NULL,
  `work_schedule_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `design_diagram`
--

CREATE TABLE `design_diagram` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diagram` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workspace_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `image`, `workspace_id`, `created_at`, `updated_at`, `color`) VALUES
(1, 'Team Learder', NULL, 1, '2018-11-15 16:19:09', '2018-11-15 16:19:09', '#ed0808'),
(2, 'OpenPHP', NULL, 1, '2018-11-15 16:19:56', '2018-11-15 16:19:56', '#0da5ec'),
(3, 'DEV PHP', NULL, 1, '2018-11-15 16:20:22', '2018-11-15 16:20:22', '#42d8f0'),
(4, 'Team Learder', NULL, 2, '2018-11-16 01:45:18', '2018-11-16 01:45:18', '#ed0202'),
(5, 'OPEN JAVA', NULL, 2, '2018-11-16 01:46:24', '2018-11-16 01:46:24', '#d27c7c'),
(6, 'DEV JAVA', NULL, 2, '2018-11-16 01:48:16', '2018-11-16 01:48:16', '#7c3333'),
(7, 'Team Learder', NULL, 3, '2018-11-16 01:50:17', '2018-11-16 01:50:17', '#f31010'),
(8, 'Dev Design', NULL, 3, '2018-11-16 01:53:47', '2018-11-16 01:53:47', '#13e777'),
(9, 'Team Learder', NULL, 4, '2018-11-16 07:44:34', '2018-11-16 07:44:34', '#f11010');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_10_02_061045_create_programs_table', 1),
(4, '2018_10_02_061239_create_workspaces_table', 1),
(5, '2018_10_02_061403_create_positions_table', 1),
(6, '2018_10_02_061427_create_locations_table', 1),
(7, '2018_10_02_061453_create_calendars_table', 1),
(8, '2018_10_02_061533_create_work_schedules_table', 1),
(9, '2018_10_04_082157_add_column_avatar_users_table', 1),
(10, '2018_10_04_085603_change_image_to_null_locations_table', 1),
(11, '2018_10_04_142228_edit_column_users_table', 1),
(12, '2018_10_07_164603_change_shift_column_work_schedules_table', 1),
(28, '2018_10_12_083247_edit_workschedules_table', 2),
(29, '2018_10_15_133530_add_role_column_users_table', 2),
(30, '2018_10_24_081555_add_column_trainer_id_users_table', 2),
(31, '2018_10_24_140306_add_allow_register_column_in_positions_table', 2),
(32, '2018_10_25_143119_create_seats_table', 2),
(33, '2018_10_25_143244_add_color_to_locations_table', 2),
(34, '2018_10_25_144341_add_columns_to_workspace_table', 2),
(35, '2018_10_25_150653_drop_total_seat_column_in_table', 2),
(36, '2018_10_30_154010_entrust_setup_tables', 2),
(37, '2018_10_30_164928_add_soft_delete_to_users_table', 2),
(38, '2018_11_01_153513_create_info_locations_table', 2),
(39, '2018_11_05_180952_add_colum_seat_id_to_users_table', 2),
(40, '2018_11_06_123718_add_colum_images_to_user_table', 3),
(41, '2018_11_09_100200_creat_design_diagram_table', 4),
(42, '2018_11_15_162124_add_column_user_id_to_seats_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'view-positions', 'Position list', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(2, 'add-positions', 'Add position', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(3, 'detail-positions', 'Position detail', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(4, 'edit-positions', 'Edit position', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(5, 'delete-positions', 'Delete position', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(6, 'view-programs', 'Tech language list', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(7, 'add-programs', 'Add tech language', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(8, 'detail-programs', 'Tech language detail', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(9, 'edit-programs', 'Edit tech language', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(10, 'delete-programs', 'Delete tech language', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(11, 'view-users', 'Employee list', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(12, 'add-users', 'Add employee', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(13, 'detail-users', 'Employee detail', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(14, 'edit-users', 'Edit employee', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(15, 'delete-users', 'Delete employee', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(16, 'role-users', 'Employee role', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(17, 'seat-statistical', 'Seat map statistic', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(18, 'work-schedules', 'Working calendar', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(19, 'register-work-schedules', 'Working time register', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(20, 'design-diagrams', 'Design diagram', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(21, 'view-workspaces', 'Workspace list', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(22, 'add-workspaces', 'Add workspace', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(23, 'detail-workspaces', 'Workspace detail', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(24, 'edit-workspaces', 'Edit workspace', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(25, 'delete-workspaces', 'Delete workspace', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(26, 'add-location', 'Add location', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(27, 'view-roles', 'Role list', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(28, 'add-roles', 'Add role', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(29, 'permission-roles', 'Role permission', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(30, 'edit-roles', 'Edit role', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(31, 'delete-roles', 'Delete role', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(32, 'view-permissions', 'Permission list', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(33, 'php-manager', 'PHP manager', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(34, 'ruby-manager', 'Ruby manager', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(35, 'ios-manager', 'IOS manager', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(36, 'android-manager', 'Android manager', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(37, 'qa-manager', 'QA manager', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(38, 'design-manager', 'Design manager', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, NULL, NULL, NULL),
(1, 3, '2018-11-15 16:11:21', NULL, NULL),
(2, 1, NULL, NULL, NULL),
(2, 3, '2018-11-15 16:11:54', NULL, NULL),
(3, 1, NULL, NULL, NULL),
(3, 3, '2018-11-15 16:11:27', NULL, NULL),
(4, 1, NULL, NULL, NULL),
(4, 3, '2018-11-15 16:11:55', NULL, NULL),
(5, 1, NULL, NULL, NULL),
(6, 1, NULL, NULL, NULL),
(6, 3, '2018-11-15 16:11:56', NULL, NULL),
(7, 1, NULL, NULL, NULL),
(8, 1, NULL, NULL, NULL),
(9, 1, NULL, NULL, NULL),
(10, 1, NULL, NULL, NULL),
(11, 1, NULL, NULL, NULL),
(11, 3, '2018-11-15 16:11:45', NULL, NULL),
(12, 1, NULL, NULL, NULL),
(12, 3, '2018-11-15 16:11:49', NULL, NULL),
(13, 1, NULL, NULL, NULL),
(13, 3, '2018-11-15 16:11:50', NULL, NULL),
(14, 1, NULL, NULL, NULL),
(14, 3, '2018-11-15 16:11:52', NULL, NULL),
(15, 1, NULL, NULL, NULL),
(16, 1, NULL, NULL, NULL),
(17, 1, NULL, NULL, NULL),
(17, 3, '2018-11-15 16:11:48', NULL, NULL),
(18, 1, NULL, NULL, NULL),
(18, 3, '2018-11-15 16:11:01', NULL, NULL),
(19, 1, NULL, NULL, NULL),
(19, 3, '2018-11-15 17:11:32', NULL, NULL),
(19, 8, '2018-11-15 17:11:43', NULL, NULL),
(20, 1, NULL, NULL, NULL),
(21, 1, NULL, NULL, NULL),
(21, 3, '2018-11-15 17:11:28', NULL, NULL),
(22, 1, NULL, NULL, NULL),
(22, 3, '2018-11-15 16:11:12', NULL, NULL),
(23, 1, NULL, NULL, NULL),
(23, 3, '2018-11-15 16:11:14', NULL, NULL),
(24, 1, NULL, NULL, NULL),
(24, 3, '2018-11-15 16:11:16', NULL, NULL),
(25, 1, NULL, NULL, NULL),
(26, 1, NULL, NULL, NULL),
(26, 3, '2018-11-15 16:11:23', NULL, NULL),
(27, 1, NULL, NULL, NULL),
(28, 1, NULL, NULL, NULL),
(29, 1, NULL, NULL, NULL),
(30, 1, NULL, NULL, NULL),
(31, 1, NULL, NULL, NULL),
(32, 1, NULL, NULL, NULL),
(33, 1, NULL, NULL, NULL),
(34, 1, NULL, NULL, NULL),
(34, 3, '2018-11-15 16:11:35', NULL, NULL),
(35, 1, NULL, NULL, NULL),
(36, 1, NULL, NULL, NULL),
(37, 1, NULL, NULL, NULL),
(38, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_fulltime` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `allow_register` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `name`, `is_fulltime`, `created_at`, `updated_at`, `allow_register`) VALUES
(1, 'Trainer', 1, NULL, NULL, 1),
(2, 'Open', 0, NULL, NULL, 1),
(3, 'Intern', 0, NULL, NULL, 1),
(4, 'Team Learder', 1, '2018-11-01 06:44:19', '2018-11-01 06:44:19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'PHP', '2018-11-15 15:49:08', '2018-11-15 15:49:08'),
(2, 'Ruby', '2018-11-15 15:49:08', '2018-11-15 15:49:08'),
(3, 'IOS', '2018-11-15 15:49:08', '2018-11-15 15:49:08'),
(4, 'Android', '2018-11-15 15:49:08', '2018-11-15 15:49:08'),
(5, 'QA', '2018-11-15 15:49:08', '2018-11-15 15:49:08'),
(6, 'Design', '2018-11-15 15:49:08', '2018-11-15 15:49:08');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', 'Admin', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(2, 'php-trainer', 'PHP trainer', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(3, 'ruby-trainer', 'Ruby trainer', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(4, 'ios-trainer', 'IOS trainer', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(5, 'android-trainer', 'Android trainer', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(6, 'qa-trainer', 'QA trainer', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(7, 'design-trainer', 'Design trainer', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL),
(8, 'trainee', 'Trainee', NULL, '2018-11-15 15:49:08', '2018-11-15 15:49:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, NULL, NULL, NULL),
(2, 3, '2018-11-15 17:11:57', '2018-11-15 17:11:57', NULL),
(3, 3, '2018-11-15 16:11:00', '2018-11-15 16:11:00', NULL),
(4, 8, '2018-11-15 17:11:10', '2018-11-15 17:11:10', NULL),
(6, 8, '2018-11-16 06:11:41', '2018-11-16 06:11:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_id` int(11) NOT NULL,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `name`, `location_id`, `user_id`) VALUES
(1, 'D3', 2, NULL),
(2, 'E3', 2, NULL),
(3, 'F3', 2, NULL),
(4, 'A1', 1, 'a:1:{i:0;s:1:\"1\";}'),
(5, 'B1', 1, NULL),
(6, 'C1', 1, 'a:1:{i:0;s:1:\"2\";}'),
(7, 'D1', 2, NULL),
(8, 'E1', 2, NULL),
(9, 'F1', 2, NULL),
(10, 'A2', 2, NULL),
(11, 'B2', 2, NULL),
(12, 'C2', 2, NULL),
(13, 'D2', 2, NULL),
(14, 'E2', 2, NULL),
(15, 'F2', 2, NULL),
(16, 'A3', 3, NULL),
(17, 'B3', 3, NULL),
(18, 'C3', 3, NULL),
(19, 'A4', 3, NULL),
(20, 'B4', 3, NULL),
(21, 'C4', 3, NULL),
(22, 'D4', 3, NULL),
(23, 'E4', 3, NULL),
(24, 'F4', 3, NULL),
(25, 'A5', 3, NULL),
(26, 'B5', 3, NULL),
(27, 'C5', 3, NULL),
(28, 'D5', 3, NULL),
(29, 'E5', 3, NULL),
(30, 'F5', 3, NULL),
(31, 'D3', 4, NULL),
(32, 'E3', 4, NULL),
(33, 'F3', 4, NULL),
(34, 'A2', 5, NULL),
(35, 'B2', 5, NULL),
(36, 'C2', 5, NULL),
(37, 'D2', 5, NULL),
(38, 'E2', 5, NULL),
(39, 'F2', 5, NULL),
(40, 'A3', 5, NULL),
(41, 'B3', 5, NULL),
(42, 'C3', 5, NULL),
(43, 'A1', 6, NULL),
(44, 'B1', 6, NULL),
(45, 'C1', 6, NULL),
(46, 'D1', 6, NULL),
(47, 'E1', 6, NULL),
(48, 'F1', 6, NULL),
(49, 'A4', 6, NULL),
(50, 'B4', 6, NULL),
(51, 'C4', 6, NULL),
(52, 'D4', 6, NULL),
(53, 'E4', 6, NULL),
(54, 'F4', 6, NULL),
(55, 'A5', 6, NULL),
(56, 'B5', 6, NULL),
(57, 'C5', 6, NULL),
(58, 'D5', 6, NULL),
(59, 'E5', 6, NULL),
(60, 'F5', 6, NULL),
(61, 'C2', 7, NULL),
(62, 'D2', 7, NULL),
(63, 'E2', 7, NULL),
(64, 'A1', 8, NULL),
(65, 'B1', 8, NULL),
(66, 'C1', 8, NULL),
(67, 'D1', 8, NULL),
(68, 'E1', 8, NULL),
(69, 'A2', 8, NULL),
(70, 'B2', 8, NULL),
(71, 'A3', 8, NULL),
(72, 'B3', 8, NULL),
(73, 'C3', 8, NULL),
(74, 'D3', 8, NULL),
(75, 'E3', 8, NULL),
(76, 'D3', 9, NULL),
(77, 'E3', 9, NULL),
(78, 'F3', 9, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `program_id` int(11) NOT NULL,
  `trainer_id` int(11) DEFAULT NULL,
  `position_id` int(11) NOT NULL,
  `workspace_id` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  `lang` smallint(6) NOT NULL DEFAULT '1',
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` smallint(6) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `program_id`, `trainer_id`, `position_id`, `workspace_id`, `status`, `lang`, `avatar`, `role`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin@framgia.com', NULL, '$2y$10$h/WjUtXvL.sOolpZXGdH1uQ0grcrK.HArGVSvYFqVZsGUKxmC/aLO', 1, NULL, 4, 1, 1, 1, 'DzvkrcIn64ZdcTcRoMjHzhXnSwmbSgMvYJbEyFBU.png', 2, 'CyDK73u4rt177PsAKi2EmXuFDgkJgPKdaKp8zwoHqCriYyX1jabxTHPLPS0a', '2018-11-15 15:49:08', '2018-11-15 15:51:25', NULL),
(2, 'Trainer PHP', 'trainer.php@framgia.com', NULL, '$2y$10$gqC6QUJctW8id8ANiepUEuCv6.RdkOOMXU8oy6zdbUGBSsSOXuKYC', 1, NULL, 1, 1, 1, 1, 'ymsiG5gSwYw95weTtNl3QDVBaPdZLtOn4KpA4L0F.jpeg', 1, NULL, '2018-11-15 15:49:08', '2018-11-15 15:52:06', NULL),
(3, 'Trainer Ruby', 'trainer.ruby@framgia.com', NULL, '$2y$10$OlzjfR4Obne..A82YZRyyeT7DMiMQh74TZkc7Ls1jMSyMd5zydwHq', 2, NULL, 1, 2, 1, 1, 'PWLQYdTtDMUc60dBjDAWLQm7hUNtAPqaaUvb0lQZ.jpeg', 1, 'AvvDW0Hg51xeAqeICgxETeKVWhoNzaLAjS2J4BjborfBfNvCbIaPi8SLbG46', '2018-11-15 15:49:08', '2018-11-15 15:52:22', NULL),
(4, 'Trainee PHP', 'trainee.php@framgia.com', NULL, '$2y$10$hIGyMRGWCIXQw9TeQVz0XOR5mzolsyTpfcVFqTYmRApPKfXq47fO.', 1, NULL, 1, 1, 1, 1, 'nJeAmcVtOQaDiCeTzL8oe9Mp4GcYxL6ifm2ESEzO.jpeg', 0, 'rwrHx9C5ut3Zd5bZYJo0ixXlRV2x4FnupaGXDUAaEHQBujrMWcPG7Y8UPVnZ', '2018-11-15 15:49:08', '2018-11-15 15:52:38', NULL),
(5, 'Trainee Ruby', 'trainee.ruby@framgia.com', NULL, '$2y$10$XsI34X6MLpok59UHDn/xUelgfai1Ioh3v8/zd2z4GChp2uhc.pY2.', 2, NULL, 1, 2, 1, 1, '1lZhhhCi5FONSso6wxAVscGVXTmAZxE8L7fowP8V.jpeg', 0, '30CumWlHS8AGRMkrLqv1kJZ2cB1otVMxtiseBZ9x0AYFi3UzZyY9M6Y5LT2e', '2018-11-15 15:49:08', '2018-11-15 15:53:09', NULL),
(6, 'Dương đình Mạnh', 'dinhmanh.php@gmail.com', NULL, '$2y$10$NPQJx2Q8Iktxae/YIRwRBuPThSHmD/BBbU/ZVGRfDmVdJE8437sBG', 1, NULL, 3, 1, 1, 1, 'HXEdqEgIRvsBVRayO1nSSCNwsU079pukqHTmnecK.jpeg', 0, NULL, '2018-11-16 02:32:52', '2018-11-16 02:32:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `workspaces`
--

CREATE TABLE `workspaces` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_seat` int(11) NOT NULL,
  `seat_per_row` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workspaces`
--

INSERT INTO `workspaces` (`id`, `name`, `image`, `created_at`, `updated_at`, `total_seat`, `seat_per_row`) VALUES
(1, 'Handico - PHP', 'asMPoxt4uhJmuw6mCXIk30YfMm9PaPsWxp8Vdeqw.jpeg', '2018-11-15 16:14:37', '2018-11-15 16:14:37', 30, 6),
(2, 'Handico - JAVA', 'TfNGLwxjEgGxqRJk7TxRShTjnv7OtP2xv8TgMw3B.png', '2018-11-16 01:44:54', '2018-11-16 01:44:54', 30, 6),
(3, 'Hnidico - Design', 'Ffdj08KV0J7VQW8Twe2r1pYTO6telPp6b5QC32l0.jpeg', '2018-11-16 01:49:56', '2018-11-16 01:49:56', 15, 5),
(4, 'Handico - Ruby', 'jvEIteK9cz5rhlzBrrDHpytimskW73cHYVzQ4azU.jpeg', '2018-11-16 01:56:46', '2018-11-16 01:56:46', 30, 6);

-- --------------------------------------------------------

--
-- Table structure for table `work_schedules`
--

CREATE TABLE `work_schedules` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `shift` smallint(6) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `location_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_schedules`
--

INSERT INTO `work_schedules` (`id`, `user_id`, `date`, `shift`, `created_at`, `updated_at`, `location_id`) VALUES
(1, 4, '2018-11-01', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(2, 4, '2018-11-02', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(3, 4, '2018-11-05', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(4, 4, '2018-11-06', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(5, 4, '2018-11-07', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(6, 4, '2018-11-08', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(7, 4, '2018-11-09', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(8, 4, '2018-11-12', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(9, 4, '2018-11-13', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(10, 4, '2018-11-14', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(11, 4, '2018-11-15', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(12, 4, '2018-11-16', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(13, 4, '2018-11-19', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(14, 4, '2018-11-20', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(15, 4, '2018-11-21', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(16, 4, '2018-11-22', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(17, 4, '2018-11-23', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(18, 4, '2018-11-26', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(19, 4, '2018-11-27', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(20, 4, '2018-11-28', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(21, 4, '2018-11-29', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(22, 4, '2018-11-30', 1, '2018-11-12 05:30:18', '2018-11-12 05:30:18', 4),
(23, 1, '2018-11-01', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(24, 1, '2018-11-02', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(25, 1, '2018-11-05', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(26, 1, '2018-11-06', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(27, 1, '2018-11-07', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(28, 1, '2018-11-08', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(29, 1, '2018-11-09', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(30, 1, '2018-11-12', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(31, 1, '2018-11-13', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(32, 1, '2018-11-14', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(33, 1, '2018-11-15', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(34, 1, '2018-11-16', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(35, 1, '2018-11-19', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(36, 1, '2018-11-20', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(37, 1, '2018-11-21', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(38, 1, '2018-11-22', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(39, 1, '2018-11-23', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(40, 1, '2018-11-26', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(41, 1, '2018-11-27', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(42, 1, '2018-11-28', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(43, 1, '2018-11-29', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(44, 1, '2018-11-30', 1, '2018-11-15 17:02:47', '2018-11-15 17:02:47', 1),
(45, 2, '2018-11-01', 2, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(46, 2, '2018-11-02', 2, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(47, 2, '2018-11-05', 1, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(48, 2, '2018-11-06', 1, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(49, 2, '2018-11-07', 1, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(50, 2, '2018-11-08', 1, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(51, 2, '2018-11-09', 1, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(52, 2, '2018-11-12', 1, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(53, 2, '2018-11-13', 1, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(54, 2, '2018-11-14', 1, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(55, 2, '2018-11-15', 1, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(56, 2, '2018-11-16', 1, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(57, 2, '2018-11-19', 1, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(58, 2, '2018-11-20', 1, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(59, 2, '2018-11-21', 1, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(60, 2, '2018-11-22', 1, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(61, 2, '2018-11-23', 1, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(62, 2, '2018-11-26', 1, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(63, 2, '2018-11-27', 1, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(64, 2, '2018-11-28', 1, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(65, 2, '2018-11-29', 1, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1),
(66, 2, '2018-11-30', 1, '2018-11-15 17:16:00', '2018-11-15 17:16:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calendars`
--
ALTER TABLE `calendars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `design_diagram`
--
ALTER TABLE `design_diagram`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `workspaces`
--
ALTER TABLE `workspaces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_schedules`
--
ALTER TABLE `work_schedules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calendars`
--
ALTER TABLE `calendars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `design_diagram`
--
ALTER TABLE `design_diagram`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `workspaces`
--
ALTER TABLE `workspaces`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `work_schedules`
--
ALTER TABLE `work_schedules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
