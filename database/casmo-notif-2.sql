-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2023 at 12:25 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `casmo-notif-2`
--

-- --------------------------------------------------------

--
-- Table structure for table `annual_evaluations`
--

CREATE TABLE `annual_evaluations` (
  `annual_evaluation_ID` bigint(20) UNSIGNED NOT NULL,
  `annual_target_ID` int(11) NOT NULL,
  `reason` longtext NOT NULL,
  `remark` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `annual_targets`
--

CREATE TABLE `annual_targets` (
  `annual_target_ID` bigint(20) UNSIGNED NOT NULL,
  `strategic_measures_ID` int(20) NOT NULL,
  `strategic_objectives_ID` int(100) NOT NULL,
  `province_ID` int(100) NOT NULL,
  `division_ID` int(11) NOT NULL,
  `annual_target` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `opcr_id` int(100) NOT NULL,
  `driver_ID` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `annual_targets`
--

INSERT INTO `annual_targets` (`annual_target_ID`, `strategic_measures_ID`, `strategic_objectives_ID`, `province_ID`, `division_ID`, `annual_target`, `created_at`, `updated_at`, `opcr_id`, `driver_ID`) VALUES
(3885, 293, 168, 1, 1, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3886, 293, 168, 5, 1, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3887, 293, 168, 2, 1, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3888, 293, 168, 3, 1, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3889, 293, 168, 4, 1, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3890, 302, 168, 1, 2, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3891, 302, 168, 5, 2, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3892, 302, 168, 2, 2, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3893, 302, 168, 3, 2, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3894, 302, 168, 4, 2, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3895, 294, 169, 1, 2, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3896, 294, 169, 5, 2, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3897, 294, 169, 2, 2, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3898, 294, 169, 3, 2, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3899, 294, 169, 4, 2, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3900, 295, 170, 1, 3, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3901, 295, 170, 5, 3, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3902, 295, 170, 2, 3, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3903, 295, 170, 3, 3, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3904, 295, 170, 4, 3, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3905, 303, 172, 1, 3, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3906, 303, 172, 5, 3, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3907, 303, 172, 2, 3, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3908, 303, 172, 3, 3, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3909, 303, 172, 4, 3, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3910, 301, 171, 1, 2, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3911, 301, 171, 5, 2, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3912, 301, 171, 2, 2, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3913, 301, 171, 3, 2, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3914, 301, 171, 4, 2, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3915, 298, 171, 1, 1, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3916, 299, 171, 1, 2, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3917, 300, 171, 1, 3, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3918, 298, 171, 5, 1, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3919, 299, 171, 5, 2, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3920, 300, 171, 5, 3, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3921, 298, 171, 2, 1, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3922, 299, 171, 2, 2, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3923, 300, 171, 2, 3, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3924, 298, 171, 3, 1, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3925, 299, 171, 3, 2, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3926, 300, 171, 3, 3, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3927, 298, 171, 4, 1, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3928, 299, 171, 4, 2, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3929, 300, 171, 4, 3, 120, '2023-04-16 00:56:03', '2023-04-16 00:56:03', 84, NULL),
(3930, 293, 168, 1, 1, 120, '2023-04-16 01:21:12', '2023-04-16 01:24:18', 85, 72),
(3931, 293, 168, 5, 1, 100, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3932, 293, 168, 2, 1, 120, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3933, 293, 168, 3, 1, 150, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3934, 293, 168, 4, 1, 120, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3935, 302, 168, 1, 2, 120, '2023-04-16 01:21:12', '2023-04-16 01:24:07', 85, 71),
(3936, 302, 168, 5, 2, 100, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3937, 302, 168, 2, 2, 120, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3938, 302, 168, 3, 2, 150, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3939, 302, 168, 4, 2, 120, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3940, 294, 169, 1, 2, 120, '2023-04-16 01:21:12', '2023-04-16 01:23:52', 85, 69),
(3941, 294, 169, 5, 2, 100, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3942, 294, 169, 2, 2, 120, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3943, 294, 169, 3, 2, 150, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3944, 294, 169, 4, 2, 120, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3945, 295, 170, 1, 3, 120, '2023-04-16 01:21:12', '2023-04-16 01:24:27', 85, 73),
(3946, 295, 170, 5, 3, 100, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3947, 295, 170, 2, 3, 120, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3948, 295, 170, 3, 3, 150, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3949, 295, 170, 4, 3, 120, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3950, 303, 172, 1, 3, 120, '2023-04-16 01:21:12', '2023-04-16 01:24:34', 85, 74),
(3951, 303, 172, 5, 3, 100, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3952, 303, 172, 2, 3, 120, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3953, 303, 172, 3, 3, 150, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3954, 303, 172, 4, 3, 120, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3955, 301, 171, 1, 2, 120, '2023-04-16 01:21:12', '2023-04-16 01:24:00', 85, 70),
(3956, 301, 171, 5, 2, 100, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3957, 301, 171, 2, 2, 120, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3958, 301, 171, 3, 2, 150, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3959, 301, 171, 4, 2, 120, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3960, 298, 171, 1, 1, 120, '2023-04-16 01:21:12', '2023-04-16 01:24:18', 85, 72),
(3961, 299, 171, 1, 2, 120, '2023-04-16 01:21:12', '2023-04-16 01:23:52', 85, 69),
(3962, 300, 171, 1, 3, 120, '2023-04-16 01:21:12', '2023-04-16 01:24:27', 85, 73),
(3963, 298, 171, 5, 1, 100, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3964, 299, 171, 5, 2, 100, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3965, 300, 171, 5, 3, 100, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3966, 298, 171, 2, 1, 120, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3967, 299, 171, 2, 2, 120, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3968, 300, 171, 2, 3, 120, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3969, 298, 171, 3, 1, 150, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3970, 299, 171, 3, 2, 150, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3971, 300, 171, 3, 3, 150, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3972, 298, 171, 4, 1, 120, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3973, 299, 171, 4, 2, 120, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL),
(3974, 300, 171, 4, 3, 120, '2023-04-16 01:21:12', '2023-04-16 01:21:12', 85, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `division_ID` bigint(20) UNSIGNED NOT NULL,
  `division` varchar(255) NOT NULL,
  `code` varchar(1000) DEFAULT NULL,
  `province_ID` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`division_ID`, `division`, `code`, `province_ID`, `created_at`, `updated_at`) VALUES
(1, 'Business Development Division', 'BDD', 0, NULL, NULL),
(2, 'Consumer Protection Division', 'CPD', 0, NULL, NULL),
(3, 'Finance Administrative Division', 'FAD', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `driver_ID` bigint(20) UNSIGNED NOT NULL,
  `driver` varchar(255) NOT NULL,
  `opcr_ID` bigint(20) UNSIGNED NOT NULL,
  `division_ID` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `number_driver` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`driver_ID`, `driver`, `opcr_ID`, `division_ID`, `created_at`, `updated_at`, `number_driver`) VALUES
(69, 'Driver 1', 85, 2, '2023-04-16 01:23:52', '2023-04-16 01:23:52', 'A'),
(70, 'driver 2', 85, 2, '2023-04-16 01:24:00', '2023-04-16 01:24:00', 'B'),
(71, 'Driver 3', 85, 2, '2023-04-16 01:24:07', '2023-04-16 01:24:07', 'C'),
(72, 'Driver 1', 85, 1, '2023-04-16 01:24:18', '2023-04-16 01:24:18', 'A'),
(73, 'Driver 1', 85, 3, '2023-04-16 01:24:27', '2023-04-16 01:24:27', 'A'),
(74, 'Driver 2', 85, 3, '2023-04-16 01:24:34', '2023-04-16 01:24:34', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `evaluations`
--

CREATE TABLE `evaluations` (
  `evaluation_ID` bigint(20) UNSIGNED NOT NULL,
  `user_ID` bigint(20) UNSIGNED NOT NULL,
  `strategic_measure` varchar(255) NOT NULL,
  `monthly_target` varchar(255) NOT NULL,
  `monthly_accomplishment` varchar(255) NOT NULL,
  `month` varchar(255) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `evaluations`
--

INSERT INTO `evaluations` (`evaluation_ID`, `user_ID`, `strategic_measure`, `monthly_target`, `monthly_accomplishment`, `month`, `reason`, `remark`, `created_at`, `updated_at`) VALUES
(38, 118, 'measure 4', '10', '4', 'jun', 'reason', NULL, '2023-04-16 01:32:54', '2023-04-16 01:33:21'),
(39, 118, 'measure 4', '10', '4', 'jul', 'reason', NULL, '2023-04-16 01:32:56', '2023-04-16 01:33:25'),
(40, 118, 'measure 4', '10', '4', 'aug', 'reason', NULL, '2023-04-16 01:32:59', '2023-04-16 01:33:27'),
(41, 118, 'measure 4', '10', '4', 'sep', 'reason', NULL, '2023-04-16 01:33:02', '2023-04-16 01:33:30'),
(42, 118, 'measure 4', '10', '4', 'oct', 'reason', NULL, '2023-04-16 01:33:04', '2023-04-16 01:33:33'),
(43, 118, 'measure 4', '10', '4', 'nov', 'reason', NULL, '2023-04-16 01:33:09', '2023-04-16 01:33:36'),
(44, 118, 'measure 4', '10', '4', 'dec', 'reason', NULL, '2023-04-16 01:33:11', '2023-04-16 01:33:38'),
(45, 117, 'measure 6', '10', '4', 'jun', 'reason', NULL, '2023-04-16 01:38:29', '2023-04-16 01:38:56'),
(46, 117, 'measure 6', '10', '4', 'jul', 'reason', NULL, '2023-04-16 01:38:32', '2023-04-16 01:38:59'),
(47, 117, 'measure 6', '10', '4', 'aug', 'reason', NULL, '2023-04-16 01:38:35', '2023-04-16 01:39:02'),
(48, 117, 'measure 6', '10', '4', 'sep', 'reason', NULL, '2023-04-16 01:38:38', '2023-04-16 01:39:05'),
(49, 117, 'measure 6', '10', '4', 'oct', 'reason', NULL, '2023-04-16 01:38:41', '2023-04-16 01:39:08'),
(50, 117, 'measure 6', '10', '4', 'nov', 'reason', NULL, '2023-04-16 01:38:44', '2023-04-16 01:39:11'),
(51, 117, 'measure 6', '10', '4', 'dec', 'reason', NULL, '2023-04-16 01:38:47', '2023-04-16 01:39:13');

-- --------------------------------------------------------

--
-- Table structure for table `file_uploads`
--

CREATE TABLE `file_uploads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `opcr_ID` bigint(20) UNSIGNED DEFAULT NULL,
  `division_ID` bigint(20) UNSIGNED DEFAULT NULL,
  `province_ID` bigint(20) UNSIGNED DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file_uploads`
--

INSERT INTO `file_uploads` (`id`, `opcr_ID`, `division_ID`, `province_ID`, `file_name`, `type`, `created_at`, `updated_at`) VALUES
(3, 84, NULL, NULL, 'opcr-84_2023.pdf', 'REGIONAL OPCR', '2023-04-16 01:19:55', '2023-04-16 01:19:55');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2023_02_04_130011_create_users_table', 1),
(3, '2023_02_04_161956_create_user_types_table', 1),
(4, '2023_02_04_164606_create_provinces_table', 1),
(5, '2023_02_04_165441_create_divisions_table', 1),
(6, '2023_02_04_172543_create_strategic_objectives_table', 1),
(7, '2023_02_04_173426_create_strategic_measures_table', 1),
(8, '2023_02_04_175802_create_annual_targets_table', 1),
(9, '2023_02_04_183656_create_monthly_targets_table', 1),
(10, '2023_02_04_191044_create_annual_evaluations_table', 1),
(11, '2023_02_04_191107_create_monthly_evaluations_table', 1),
(12, '2023_02_08_053104_create_registration_keys_table', 1),
(13, '2023_02_08_084155_create_password_resets_table', 1),
(14, '2023_02_16_121201_create_opcr_table', 1),
(15, '2023_02_19_103931_smc_table', 2),
(16, '2023_02_19_121614_add_division__i_d_to_strategic_measures_table', 2),
(17, '2023_02_19_123545_add_division__i_d_to_strategic_objectives_table', 3),
(18, '2023_02_19_124727_add_type_to_strategic_measures_table', 4),
(19, '2023_02_19_124833_add_number_division_to_strategic_measures_table', 4),
(20, '2023_02_19_125038_add_letter_division_to_strategic_objectives_table', 4),
(21, '2023_02_20_075448_create_registration_keys_table', 5),
(22, '2023_03_05_090421_add_province__i_d_to_users_table', 6),
(23, '2023_03_13_052618_add_division__i_d_to_monthly_targets', 7),
(24, '2023_03_22_124550_create_notifications_table', 8),
(25, '2023_03_22_131733_create_notifications_table', 9),
(29, '2023_03_24_064239_create_evaluations_table', 10),
(30, '2023_03_26_092946_create_notifications_table', 11),
(31, '2023_03_28_104311_add_opcr_id_to_strategic_measures_table', 12),
(32, '2023_03_28_104629_add_driver_id_to_annual_targets_table', 12),
(33, '2023_03_29_134700_add_is_active_to_strategic_objectives_table', 13),
(34, '2023_03_29_135925_add_is_active_to_strategic_objectives_table', 14),
(35, '2023_04_09_103224_create_file_uploads_table', 15),
(36, '2023_04_09_103725_create_file_uploads_table', 16),
(38, '2023_04_13_115227_pgs_table', 17),
(39, '2023_04_13_134042_rename_column_in_strategic_measures', 18),
(40, '2023_04_13_140650_add_number_driver_to_drivers_table', 19);

-- --------------------------------------------------------

--
-- Table structure for table `monthly_evaluations`
--

CREATE TABLE `monthly_evaluations` (
  `monthly_evaluation_ID` bigint(20) UNSIGNED NOT NULL,
  `monthly_target_ID` int(11) NOT NULL,
  `reason` longtext NOT NULL,
  `remark` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `monthly_targets`
--

CREATE TABLE `monthly_targets` (
  `monthly_target_ID` bigint(20) UNSIGNED NOT NULL,
  `annual_target_ID` int(11) NOT NULL,
  `division_ID` int(11) DEFAULT NULL,
  `month` varchar(255) NOT NULL,
  `year` varchar(255) DEFAULT NULL,
  `monthly_target` int(11) DEFAULT NULL,
  `monthly_accomplishment` int(11) DEFAULT NULL,
  `validated` varchar(255) NOT NULL DEFAULT 'Not Validated',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `monthly_targets`
--

INSERT INTO `monthly_targets` (`monthly_target_ID`, `annual_target_ID`, `division_ID`, `month`, `year`, `monthly_target`, `monthly_accomplishment`, `validated`, `created_at`, `updated_at`) VALUES
(489, 3945, 3, 'jan', NULL, 10, 10, 'Not Validated', '2023-04-16 01:24:57', '2023-04-16 01:31:19'),
(490, 3945, 3, 'feb', NULL, 10, 10, 'Not Validated', '2023-04-16 01:25:02', '2023-04-16 01:31:22'),
(491, 3945, 3, 'mar', NULL, 10, 10, 'Not Validated', '2023-04-16 01:25:05', '2023-04-16 01:31:25'),
(492, 3945, 3, 'apr', NULL, 10, 10, 'Not Validated', '2023-04-16 01:25:10', '2023-04-16 01:31:28'),
(493, 3945, 3, 'may', NULL, 10, 10, 'Not Validated', '2023-04-16 01:25:13', '2023-04-16 01:31:30'),
(494, 3945, 3, 'jun', NULL, 10, 10, 'Not Validated', '2023-04-16 01:25:16', '2023-04-16 01:31:34'),
(495, 3945, 3, 'jul', NULL, 10, 10, 'Not Validated', '2023-04-16 01:25:18', '2023-04-16 01:31:37'),
(496, 3945, 3, 'aug', NULL, 10, 10, 'Not Validated', '2023-04-16 01:25:21', '2023-04-16 01:31:40'),
(497, 3945, 3, 'sep', NULL, 10, 10, 'Not Validated', '2023-04-16 01:25:24', '2023-04-16 01:31:43'),
(498, 3945, 3, 'oct', NULL, 10, 10, 'Not Validated', '2023-04-16 01:25:27', '2023-04-16 01:31:46'),
(499, 3945, 3, 'nov', NULL, 10, 10, 'Not Validated', '2023-04-16 01:25:29', '2023-04-16 01:31:49'),
(500, 3945, 3, 'dec', NULL, 10, 10, 'Not Validated', '2023-04-16 01:25:32', '2023-04-16 01:31:52'),
(501, 3962, 3, 'jan', NULL, 10, 10, 'Not Validated', '2023-04-16 01:25:36', '2023-04-16 01:31:55'),
(502, 3962, 3, 'feb', NULL, 10, 10, 'Not Validated', '2023-04-16 01:25:39', '2023-04-16 01:31:58'),
(503, 3962, 3, 'mar', NULL, 10, 10, 'Not Validated', '2023-04-16 01:25:42', '2023-04-16 01:32:02'),
(504, 3962, 3, 'apr', NULL, 10, 10, 'Not Validated', '2023-04-16 01:25:44', '2023-04-16 01:32:05'),
(505, 3962, 3, 'may', NULL, 10, 10, 'Not Validated', '2023-04-16 01:25:47', '2023-04-16 01:32:08'),
(506, 3962, 3, 'jun', NULL, 10, 10, 'Not Validated', '2023-04-16 01:25:50', '2023-04-16 01:32:11'),
(507, 3962, 3, 'jul', NULL, 10, 10, 'Not Validated', '2023-04-16 01:25:52', '2023-04-16 01:32:13'),
(508, 3962, 3, 'aug', NULL, 10, 10, 'Not Validated', '2023-04-16 01:25:55', '2023-04-16 01:32:17'),
(509, 3962, 3, 'sep', NULL, 10, 10, 'Not Validated', '2023-04-16 01:25:58', '2023-04-16 01:32:19'),
(510, 3962, 3, 'oct', NULL, 10, 10, 'Not Validated', '2023-04-16 01:26:01', '2023-04-16 01:32:22'),
(511, 3962, 3, 'nov', NULL, 10, 10, 'Not Validated', '2023-04-16 01:26:04', '2023-04-16 01:32:25'),
(512, 3962, 3, 'dec', NULL, 10, 10, 'Not Validated', '2023-04-16 01:26:07', '2023-04-16 01:32:28'),
(513, 3950, 3, 'jan', NULL, 10, 10, 'Not Validated', '2023-04-16 01:26:09', '2023-04-16 01:32:35'),
(514, 3950, 3, 'feb', NULL, 10, 10, 'Not Validated', '2023-04-16 01:26:12', '2023-04-16 01:32:38'),
(515, 3950, 3, 'mar', NULL, 10, 10, 'Not Validated', '2023-04-16 01:26:15', '2023-04-16 01:32:41'),
(516, 3950, 3, 'apr', NULL, 10, 10, 'Not Validated', '2023-04-16 01:26:18', '2023-04-16 01:32:44'),
(517, 3950, 3, 'may', NULL, 10, 10, 'Not Validated', '2023-04-16 01:26:20', '2023-04-16 01:32:47'),
(518, 3950, 3, 'jun', NULL, 10, 4, 'Not Validated', '2023-04-16 01:26:23', '2023-04-16 01:32:54'),
(519, 3950, 3, 'jul', NULL, 10, 4, 'Not Validated', '2023-04-16 01:26:26', '2023-04-16 01:32:56'),
(520, 3950, 3, 'aug', NULL, 10, 4, 'Not Validated', '2023-04-16 01:26:30', '2023-04-16 01:32:59'),
(521, 3950, 3, 'sep', NULL, 10, 4, 'Not Validated', '2023-04-16 01:26:33', '2023-04-16 01:33:02'),
(522, 3950, 3, 'oct', NULL, 10, 4, 'Not Validated', '2023-04-16 01:26:35', '2023-04-16 01:33:04'),
(523, 3950, 3, 'nov', NULL, 10, 4, 'Not Validated', '2023-04-16 01:26:38', '2023-04-16 01:33:09'),
(524, 3950, 3, 'dec', NULL, 10, 4, 'Not Validated', '2023-04-16 01:26:41', '2023-04-16 01:33:11'),
(525, 3930, 1, 'jan', NULL, 10, 10, 'Validated', '2023-04-16 01:26:51', '2023-04-16 01:42:03'),
(526, 3930, 1, 'feb', NULL, 10, 10, 'Validated', '2023-04-16 01:26:54', '2023-04-16 01:42:10'),
(527, 3930, 1, 'mar', NULL, 10, 10, 'Validated', '2023-04-16 01:26:56', '2023-04-16 01:42:14'),
(528, 3930, 1, 'apr', NULL, 10, 10, 'Validated', '2023-04-16 01:26:59', '2023-04-16 01:42:17'),
(529, 3930, 1, 'may', NULL, 10, 10, 'Validated', '2023-04-16 01:27:02', '2023-04-16 01:42:20'),
(530, 3930, 1, 'jun', NULL, 10, 10, 'Validated', '2023-04-16 01:27:05', '2023-04-16 01:42:25'),
(531, 3930, 1, 'jul', NULL, 10, 10, 'Validated', '2023-04-16 01:27:07', '2023-04-16 01:42:29'),
(532, 3930, 1, 'aug', NULL, 10, 10, 'Validated', '2023-04-16 01:27:10', '2023-04-16 01:42:33'),
(533, 3930, 1, 'sep', NULL, 10, 10, 'Validated', '2023-04-16 01:27:12', '2023-04-16 01:42:36'),
(534, 3930, 1, 'oct', NULL, 10, 10, 'Validated', '2023-04-16 01:27:16', '2023-04-16 01:42:39'),
(535, 3930, 1, 'nov', NULL, 10, 10, 'Validated', '2023-04-16 01:27:19', '2023-04-16 01:42:42'),
(536, 3930, 1, 'dec', NULL, 10, 10, 'Validated', '2023-04-16 01:27:21', '2023-04-16 01:42:46'),
(537, 3960, 1, 'jan', NULL, 10, 10, 'Validated', '2023-04-16 01:27:24', '2023-04-16 01:42:50'),
(538, 3960, 1, 'feb', NULL, 10, 10, 'Validated', '2023-04-16 01:27:27', '2023-04-16 01:42:54'),
(539, 3960, 1, 'mar', NULL, 10, 10, 'Validated', '2023-04-16 01:27:30', '2023-04-16 01:42:57'),
(540, 3960, 1, 'apr', NULL, 10, 10, 'Validated', '2023-04-16 01:27:33', '2023-04-16 01:43:00'),
(541, 3960, 1, 'may', NULL, 10, 10, 'Validated', '2023-04-16 01:27:36', '2023-04-16 01:43:05'),
(542, 3960, 1, 'jun', NULL, 10, 10, 'Validated', '2023-04-16 01:27:40', '2023-04-16 01:43:08'),
(543, 3960, 1, 'jul', NULL, 10, 10, 'Validated', '2023-04-16 01:27:45', '2023-04-16 01:43:11'),
(544, 3960, 1, 'aug', NULL, 10, 10, 'Validated', '2023-04-16 01:27:48', '2023-04-16 01:43:15'),
(545, 3960, 1, 'sep', NULL, 10, 10, 'Validated', '2023-04-16 01:27:51', '2023-04-16 01:43:18'),
(546, 3960, 1, 'oct', NULL, 10, 10, 'Validated', '2023-04-16 01:27:54', '2023-04-16 01:43:22'),
(547, 3960, 1, 'nov', NULL, 10, 10, 'Validated', '2023-04-16 01:27:56', '2023-04-16 01:43:25'),
(548, 3960, 1, 'dec', NULL, 10, 10, 'Validated', '2023-04-16 01:27:59', '2023-04-16 01:43:28'),
(549, 3940, 2, 'jan', NULL, 10, 10, 'Validated', '2023-04-16 01:28:15', '2023-04-16 01:44:28'),
(550, 3940, 2, 'feb', NULL, 10, 10, 'Validated', '2023-04-16 01:28:19', '2023-04-16 01:44:32'),
(551, 3940, 2, 'mar', NULL, 10, 10, 'Validated', '2023-04-16 01:28:23', '2023-04-16 01:44:35'),
(552, 3940, 2, 'apr', NULL, 10, 10, 'Validated', '2023-04-16 01:28:27', '2023-04-16 01:44:39'),
(553, 3940, 2, 'may', NULL, 10, 10, 'Validated', '2023-04-16 01:28:29', '2023-04-16 01:44:42'),
(554, 3940, 2, 'jun', NULL, 10, 10, 'Validated', '2023-04-16 01:28:32', '2023-04-16 01:44:45'),
(555, 3940, 2, 'jul', NULL, 10, 10, 'Validated', '2023-04-16 01:28:36', '2023-04-16 01:44:50'),
(556, 3940, 2, 'aug', NULL, 10, 10, 'Validated', '2023-04-16 01:28:39', '2023-04-16 01:44:53'),
(557, 3940, 2, 'sep', NULL, 10, 10, 'Validated', '2023-04-16 01:28:42', '2023-04-16 01:44:56'),
(558, 3940, 2, 'oct', NULL, 10, 10, 'Validated', '2023-04-16 01:28:45', '2023-04-16 01:44:59'),
(559, 3940, 2, 'nov', NULL, 10, 10, 'Validated', '2023-04-16 01:28:48', '2023-04-16 01:45:03'),
(560, 3940, 2, 'dec', NULL, 10, 10, 'Validated', '2023-04-16 01:28:58', '2023-04-16 01:45:06'),
(561, 3961, 2, 'jan', NULL, 10, 10, 'Validated', '2023-04-16 01:29:10', '2023-04-16 01:45:11'),
(562, 3961, 2, 'feb', NULL, 10, 10, 'Validated', '2023-04-16 01:29:13', '2023-04-16 01:45:15'),
(563, 3961, 2, 'mar', NULL, 10, 10, 'Validated', '2023-04-16 01:29:15', '2023-04-16 01:45:18'),
(564, 3961, 2, 'apr', NULL, 10, 10, 'Validated', '2023-04-16 01:29:18', '2023-04-16 01:45:21'),
(565, 3961, 2, 'may', NULL, 10, 10, 'Validated', '2023-04-16 01:29:21', '2023-04-16 01:45:25'),
(566, 3961, 2, 'jun', NULL, 10, 10, 'Validated', '2023-04-16 01:29:24', '2023-04-16 01:45:28'),
(567, 3961, 2, 'jul', NULL, 10, 10, 'Validated', '2023-04-16 01:29:26', '2023-04-16 01:45:32'),
(568, 3961, 2, 'aug', NULL, 10, 10, 'Validated', '2023-04-16 01:29:29', '2023-04-16 01:45:35'),
(569, 3961, 2, 'sep', NULL, 10, 10, 'Validated', '2023-04-16 01:29:32', '2023-04-16 01:45:39'),
(570, 3961, 2, 'oct', NULL, 10, 10, 'Validated', '2023-04-16 01:29:35', '2023-04-16 01:45:43'),
(571, 3961, 2, 'nov', NULL, 10, 10, 'Validated', '2023-04-16 01:29:38', '2023-04-16 01:45:47'),
(572, 3961, 2, 'dec', NULL, 10, 10, 'Validated', '2023-04-16 01:29:41', '2023-04-16 01:45:51'),
(573, 3955, 2, 'jan', NULL, 10, 10, 'Validated', '2023-04-16 01:29:44', '2023-04-16 01:45:56'),
(574, 3955, 2, 'feb', NULL, 10, 10, 'Validated', '2023-04-16 01:29:47', '2023-04-16 01:45:59'),
(575, 3955, 2, 'mar', NULL, 10, 10, 'Validated', '2023-04-16 01:29:49', '2023-04-16 01:46:02'),
(576, 3955, 2, 'apr', NULL, 10, 10, 'Validated', '2023-04-16 01:29:52', '2023-04-16 01:46:07'),
(577, 3955, 2, 'may', NULL, 10, 10, 'Validated', '2023-04-16 01:29:55', '2023-04-16 01:46:10'),
(578, 3955, 2, 'jun', NULL, 10, 10, 'Validated', '2023-04-16 01:29:58', '2023-04-16 01:46:14'),
(579, 3955, 2, 'jul', NULL, 10, 10, 'Validated', '2023-04-16 01:30:00', '2023-04-16 01:46:17'),
(580, 3955, 2, 'aug', NULL, 10, 10, 'Validated', '2023-04-16 01:30:03', '2023-04-16 01:46:21'),
(581, 3955, 2, 'sep', NULL, 10, 10, 'Validated', '2023-04-16 01:30:06', '2023-04-16 01:46:24'),
(582, 3955, 2, 'oct', NULL, 10, 10, 'Validated', '2023-04-16 01:30:08', '2023-04-16 01:46:31'),
(583, 3955, 2, 'nov', NULL, 10, 10, 'Validated', '2023-04-16 01:30:11', '2023-04-16 01:46:28'),
(584, 3955, 2, 'dec', NULL, 10, 10, 'Validated', '2023-04-16 01:30:14', '2023-04-16 01:46:34'),
(585, 3935, 2, 'jan', NULL, 10, 10, 'Validated', '2023-04-16 01:30:17', '2023-04-16 01:43:38'),
(586, 3935, 2, 'feb', NULL, 10, 10, 'Validated', '2023-04-16 01:30:20', '2023-04-16 01:43:42'),
(587, 3935, 2, 'mar', NULL, 10, 10, 'Validated', '2023-04-16 01:30:23', '2023-04-16 01:43:47'),
(588, 3935, 2, 'apr', NULL, 10, 10, 'Validated', '2023-04-16 01:30:26', '2023-04-16 01:43:52'),
(589, 3935, 2, 'may', NULL, 10, 10, 'Validated', '2023-04-16 01:30:29', '2023-04-16 01:43:58'),
(590, 3935, 2, 'jun', NULL, 10, 4, 'Validated', '2023-04-16 01:30:31', '2023-04-16 01:44:01'),
(591, 3935, 2, 'jul', NULL, 10, 4, 'Validated', '2023-04-16 01:30:33', '2023-04-16 01:44:06'),
(592, 3935, 2, 'aug', NULL, 10, 4, 'Validated', '2023-04-16 01:30:36', '2023-04-16 01:44:10'),
(593, 3935, 2, 'sep', NULL, 10, 4, 'Validated', '2023-04-16 01:30:38', '2023-04-16 01:44:13'),
(594, 3935, 2, 'oct', NULL, 10, 4, 'Validated', '2023-04-16 01:30:41', '2023-04-16 01:44:17'),
(595, 3935, 2, 'nov', NULL, 10, 4, 'Validated', '2023-04-16 01:30:44', '2023-04-16 01:44:20'),
(596, 3935, 2, 'dec', NULL, 10, 4, 'Validated', '2023-04-16 01:30:46', '2023-04-16 01:44:23');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_type_ID` bigint(20) UNSIGNED DEFAULT NULL,
  `user_ID` bigint(20) UNSIGNED DEFAULT NULL,
  `division_ID` bigint(20) UNSIGNED DEFAULT NULL,
  `province_ID` bigint(20) UNSIGNED DEFAULT NULL,
  `opcr_ID` bigint(20) UNSIGNED DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_type_ID`, `user_ID`, `division_ID`, `province_ID`, `opcr_ID`, `year`, `type`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
(406, 4, 2, NULL, 1, 84, 2023, 'lorem ipsum dolor', '\"rpo@gmail.com has submitted OPCR #84\"', NULL, '2023-04-16 00:56:07', '2023-04-16 00:56:07'),
(407, 4, 2, NULL, 2, 84, 2023, 'lorem ipsum dolor', '\"rpo@gmail.com has submitted OPCR #84\"', NULL, '2023-04-16 00:56:07', '2023-04-16 00:56:07'),
(408, 4, 2, NULL, 3, 84, 2023, 'lorem ipsum dolor', '\"rpo@gmail.com has submitted OPCR #84\"', NULL, '2023-04-16 00:56:07', '2023-04-16 00:56:07'),
(409, 4, 2, NULL, 4, 84, 2023, 'lorem ipsum dolor', '\"rpo@gmail.com has submitted OPCR #84\"', NULL, '2023-04-16 00:56:07', '2023-04-16 00:56:07'),
(410, 4, 2, NULL, 5, 84, 2023, 'lorem ipsum dolor', '\"rpo@gmail.com has submitted OPCR #84\"', NULL, '2023-04-16 00:56:07', '2023-04-16 00:56:07'),
(411, 4, 2, NULL, 1, 85, 2023, '2nd opcr', '\"rpo@gmail.com has submitted OPCR #85\"', NULL, '2023-04-16 01:21:15', '2023-04-16 01:21:15'),
(412, 4, 2, NULL, 2, 85, 2023, '2nd opcr', '\"rpo@gmail.com has submitted OPCR #85\"', NULL, '2023-04-16 01:21:15', '2023-04-16 01:21:15'),
(413, 4, 2, NULL, 3, 85, 2023, '2nd opcr', '\"rpo@gmail.com has submitted OPCR #85\"', NULL, '2023-04-16 01:21:15', '2023-04-16 01:21:15'),
(414, 4, 2, NULL, 4, 85, 2023, '2nd opcr', '\"rpo@gmail.com has submitted OPCR #85\"', NULL, '2023-04-16 01:21:15', '2023-04-16 01:21:15'),
(415, 4, 2, NULL, 5, 85, 2023, '2nd opcr', '\"rpo@gmail.com has submitted OPCR #85\"', NULL, '2023-04-16 01:21:15', '2023-04-16 01:21:15'),
(416, 5, 112, 1, 1, 85, 2023, 'OPCR Submitted', '\"ppobuk@gmail.com has submitted target for OPCR #85\"', '2023-04-16 01:41:09', '2023-04-16 01:21:50', '2023-04-16 01:41:09'),
(417, 5, 112, 2, 1, 85, 2023, 'OPCR Submitted', '\"ppobuk@gmail.com has submitted target for OPCR #85\"', NULL, '2023-04-16 01:21:50', '2023-04-16 01:21:50'),
(418, 5, 112, 3, 1, 85, 2023, 'OPCR Submitted', '\"ppobuk@gmail.com has submitted target for OPCR #85\"', NULL, '2023-04-16 01:21:50', '2023-04-16 01:21:50'),
(419, 5, 114, 1, 5, 85, 2023, 'OPCR Submitted', '\"ppocam@gmail.com has submitted target for OPCR #85\"', NULL, '2023-04-16 01:21:52', '2023-04-16 01:21:52'),
(420, 5, 114, 2, 5, 85, 2023, 'OPCR Submitted', '\"ppocam@gmail.com has submitted target for OPCR #85\"', NULL, '2023-04-16 01:21:52', '2023-04-16 01:21:52'),
(421, 5, 114, 3, 5, 85, 2023, 'OPCR Submitted', '\"ppocam@gmail.com has submitted target for OPCR #85\"', NULL, '2023-04-16 01:21:52', '2023-04-16 01:21:52'),
(422, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:31:19', '2023-04-16 01:31:19'),
(423, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:31:22', '2023-04-16 01:31:22'),
(424, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:31:25', '2023-04-16 01:31:25'),
(425, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:31:28', '2023-04-16 01:31:28'),
(426, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:31:30', '2023-04-16 01:31:30'),
(427, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:31:34', '2023-04-16 01:31:34'),
(428, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:31:37', '2023-04-16 01:31:37'),
(429, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:31:40', '2023-04-16 01:31:40'),
(430, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:31:43', '2023-04-16 01:31:43'),
(431, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:31:46', '2023-04-16 01:31:46'),
(432, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:31:49', '2023-04-16 01:31:49'),
(433, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:31:52', '2023-04-16 01:31:52'),
(434, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:31:55', '2023-04-16 01:31:55'),
(435, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:31:58', '2023-04-16 01:31:58'),
(436, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:32:02', '2023-04-16 01:32:02'),
(437, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:32:05', '2023-04-16 01:32:05'),
(438, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:32:08', '2023-04-16 01:32:08'),
(439, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:32:11', '2023-04-16 01:32:11'),
(440, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:32:13', '2023-04-16 01:32:13'),
(441, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:32:17', '2023-04-16 01:32:17'),
(442, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:32:19', '2023-04-16 01:32:19'),
(443, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:32:22', '2023-04-16 01:32:22'),
(444, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:32:25', '2023-04-16 01:32:25'),
(445, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:32:28', '2023-04-16 01:32:28'),
(446, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:32:35', '2023-04-16 01:32:35'),
(447, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:32:38', '2023-04-16 01:32:38'),
(448, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:32:41', '2023-04-16 01:32:41'),
(449, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:32:44', '2023-04-16 01:32:44'),
(450, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:32:47', '2023-04-16 01:32:47'),
(451, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has failed to achieved the target\"', NULL, '2023-04-16 01:32:54', '2023-04-16 01:32:54'),
(452, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has failed to achieved the target\"', NULL, '2023-04-16 01:32:56', '2023-04-16 01:32:56'),
(453, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has failed to achieved the target\"', NULL, '2023-04-16 01:32:59', '2023-04-16 01:32:59'),
(454, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has failed to achieved the target\"', NULL, '2023-04-16 01:33:02', '2023-04-16 01:33:02'),
(455, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has failed to achieved the target\"', NULL, '2023-04-16 01:33:04', '2023-04-16 01:33:04'),
(456, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has failed to achieved the target\"', NULL, '2023-04-16 01:33:09', '2023-04-16 01:33:09'),
(457, 4, 118, NULL, 1, NULL, NULL, 'FAD', '\"Provincial has failed to achieved the target\"', NULL, '2023-04-16 01:33:11', '2023-04-16 01:33:11'),
(458, 3, 118, NULL, 1, NULL, NULL, 'Division Chief Evaluation', '\"Provincial has added reason for not hitting the target\"', NULL, '2023-04-16 01:33:21', '2023-04-16 01:33:21'),
(459, 3, 118, NULL, 1, NULL, NULL, 'Division Chief Evaluation', '\"Provincial has added reason for not hitting the target\"', NULL, '2023-04-16 01:33:25', '2023-04-16 01:33:25'),
(460, 3, 118, NULL, 1, NULL, NULL, 'Division Chief Evaluation', '\"Provincial has added reason for not hitting the target\"', NULL, '2023-04-16 01:33:27', '2023-04-16 01:33:27'),
(461, 3, 118, NULL, 1, NULL, NULL, 'Division Chief Evaluation', '\"Provincial has added reason for not hitting the target\"', NULL, '2023-04-16 01:33:30', '2023-04-16 01:33:30'),
(462, 3, 118, NULL, 1, NULL, NULL, 'Division Chief Evaluation', '\"Provincial has added reason for not hitting the target\"', NULL, '2023-04-16 01:33:33', '2023-04-16 01:33:33'),
(463, 3, 118, NULL, 1, NULL, NULL, 'Division Chief Evaluation', '\"Provincial has added reason for not hitting the target\"', NULL, '2023-04-16 01:33:36', '2023-04-16 01:33:36'),
(464, 3, 118, NULL, 1, NULL, NULL, 'Division Chief Evaluation', '\"Provincial has added reason for not hitting the target\"', NULL, '2023-04-16 01:33:38', '2023-04-16 01:33:38'),
(465, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:34:51', '2023-04-16 01:34:51'),
(466, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:34:54', '2023-04-16 01:34:54'),
(467, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:34:57', '2023-04-16 01:34:57'),
(468, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:35:00', '2023-04-16 01:35:00'),
(469, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:35:03', '2023-04-16 01:35:03'),
(470, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:35:06', '2023-04-16 01:35:06'),
(471, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:35:10', '2023-04-16 01:35:10'),
(472, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:35:12', '2023-04-16 01:35:12'),
(473, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:35:15', '2023-04-16 01:35:15'),
(474, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:35:17', '2023-04-16 01:35:17'),
(475, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:35:20', '2023-04-16 01:35:20'),
(476, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:35:22', '2023-04-16 01:35:22'),
(477, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:35:33', '2023-04-16 01:35:33'),
(478, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:35:37', '2023-04-16 01:35:37'),
(479, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:35:41', '2023-04-16 01:35:41'),
(480, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:35:44', '2023-04-16 01:35:44'),
(481, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:35:47', '2023-04-16 01:35:47'),
(482, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:35:55', '2023-04-16 01:35:55'),
(483, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:35:58', '2023-04-16 01:35:58'),
(484, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:36:01', '2023-04-16 01:36:01'),
(485, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:36:04', '2023-04-16 01:36:04'),
(486, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:36:06', '2023-04-16 01:36:06'),
(487, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:36:09', '2023-04-16 01:36:09'),
(488, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:36:12', '2023-04-16 01:36:12'),
(489, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:36:16', '2023-04-16 01:36:16'),
(490, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:36:20', '2023-04-16 01:36:20'),
(491, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:36:24', '2023-04-16 01:36:24'),
(492, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:36:27', '2023-04-16 01:36:27'),
(493, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:36:31', '2023-04-16 01:36:31'),
(494, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:36:34', '2023-04-16 01:36:34'),
(495, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:36:37', '2023-04-16 01:36:37'),
(496, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:36:39', '2023-04-16 01:36:39'),
(497, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:36:42', '2023-04-16 01:36:42'),
(498, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:36:45', '2023-04-16 01:36:45'),
(499, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:36:48', '2023-04-16 01:36:48'),
(500, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:36:51', '2023-04-16 01:36:51'),
(501, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:37:37', '2023-04-16 01:37:37'),
(502, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:38:14', '2023-04-16 01:38:14'),
(503, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:38:17', '2023-04-16 01:38:17'),
(504, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:38:21', '2023-04-16 01:38:21'),
(505, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has updated monthly accomplishment\"', NULL, '2023-04-16 01:38:24', '2023-04-16 01:38:24'),
(506, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has failed to achieved the target\"', NULL, '2023-04-16 01:38:29', '2023-04-16 01:38:29'),
(507, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has failed to achieved the target\"', NULL, '2023-04-16 01:38:32', '2023-04-16 01:38:32'),
(508, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has failed to achieved the target\"', NULL, '2023-04-16 01:38:35', '2023-04-16 01:38:35'),
(509, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has failed to achieved the target\"', NULL, '2023-04-16 01:38:38', '2023-04-16 01:38:38'),
(510, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has failed to achieved the target\"', NULL, '2023-04-16 01:38:41', '2023-04-16 01:38:41'),
(511, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has failed to achieved the target\"', NULL, '2023-04-16 01:38:44', '2023-04-16 01:38:44'),
(512, 4, 117, NULL, 1, NULL, NULL, 'CPD', '\"Provincial has failed to achieved the target\"', NULL, '2023-04-16 01:38:47', '2023-04-16 01:38:47'),
(513, 3, 117, NULL, 1, NULL, NULL, 'Division Chief Evaluation', '\"Provincial has added reason for not hitting the target\"', NULL, '2023-04-16 01:38:56', '2023-04-16 01:38:56'),
(514, 3, 117, NULL, 1, NULL, NULL, 'Division Chief Evaluation', '\"Provincial has added reason for not hitting the target\"', NULL, '2023-04-16 01:38:59', '2023-04-16 01:38:59'),
(515, 3, 117, NULL, 1, NULL, NULL, 'Division Chief Evaluation', '\"Provincial has added reason for not hitting the target\"', NULL, '2023-04-16 01:39:02', '2023-04-16 01:39:02'),
(516, 3, 117, NULL, 1, NULL, NULL, 'Division Chief Evaluation', '\"Provincial has added reason for not hitting the target\"', NULL, '2023-04-16 01:39:05', '2023-04-16 01:39:05'),
(517, 3, 117, NULL, 1, NULL, NULL, 'Division Chief Evaluation', '\"Provincial has added reason for not hitting the target\"', NULL, '2023-04-16 01:39:08', '2023-04-16 01:39:08'),
(518, 3, 117, NULL, 1, NULL, NULL, 'Division Chief Evaluation', '\"Provincial has added reason for not hitting the target\"', NULL, '2023-04-16 01:39:11', '2023-04-16 01:39:11'),
(519, 3, 117, NULL, 1, NULL, NULL, 'Division Chief Evaluation', '\"Provincial has added reason for not hitting the target\"', NULL, '2023-04-16 01:39:13', '2023-04-16 01:39:13'),
(520, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:39:30', '2023-04-16 01:39:30'),
(521, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:39:34', '2023-04-16 01:39:34'),
(522, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:39:37', '2023-04-16 01:39:37'),
(523, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:39:39', '2023-04-16 01:39:39'),
(524, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:39:42', '2023-04-16 01:39:42'),
(525, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:39:45', '2023-04-16 01:39:45'),
(526, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:39:47', '2023-04-16 01:39:47'),
(527, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:39:50', '2023-04-16 01:39:50'),
(528, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:39:52', '2023-04-16 01:39:52'),
(529, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:39:55', '2023-04-16 01:39:55'),
(530, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:39:58', '2023-04-16 01:39:58'),
(531, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:40:01', '2023-04-16 01:40:01'),
(532, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:40:30', '2023-04-16 01:40:30'),
(533, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:40:34', '2023-04-16 01:40:34'),
(534, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:40:37', '2023-04-16 01:40:37'),
(535, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:40:39', '2023-04-16 01:40:39'),
(536, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:40:42', '2023-04-16 01:40:42'),
(537, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:40:45', '2023-04-16 01:40:45'),
(538, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:40:48', '2023-04-16 01:40:48'),
(539, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:40:51', '2023-04-16 01:40:51'),
(540, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:40:53', '2023-04-16 01:40:53'),
(541, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:40:56', '2023-04-16 01:40:56'),
(542, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:40:59', '2023-04-16 01:40:59'),
(543, 4, 116, NULL, 1, NULL, NULL, 'BDD', '\"Division has updated monthly accomplishment\"', NULL, '2023-04-16 01:41:02', '2023-04-16 01:41:02');

-- --------------------------------------------------------

--
-- Table structure for table `opcr`
--

CREATE TABLE `opcr` (
  `opcr_ID` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `year` int(100) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_submitted` tinyint(1) DEFAULT NULL,
  `is_submitted_division` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `opcr`
--

INSERT INTO `opcr` (`opcr_ID`, `description`, `year`, `status`, `is_submitted`, `is_submitted_division`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(83, 'lorem ipsum dolor', 2023, 'INCOMPLETE', NULL, 0, NULL, NULL, '2023-04-16 00:55:21', '2023-04-16 00:55:21'),
(84, 'lorem ipsum dolor', 2023, 'DONE', 1, 0, 0, NULL, '2023-04-16 00:56:03', '2023-04-16 00:56:03'),
(85, '2nd opcr', 2023, 'COMPLETE', 1, 1, 1, NULL, '2023-04-16 01:21:12', '2023-04-16 01:21:12');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pgs`
--

CREATE TABLE `pgs` (
  `pgs_ID` bigint(20) UNSIGNED NOT NULL,
  `total_num_of_targeted_measure` int(11) NOT NULL,
  `actual_num_of_accomplished_measure` int(11) NOT NULL,
  `numeric` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pgs`
--

INSERT INTO `pgs` (`pgs_ID`, `total_num_of_targeted_measure`, `actual_num_of_accomplished_measure`, `numeric`) VALUES
(1, 26, 1, '0.25'),
(2, 26, 2, '0.50'),
(3, 26, 3, '0.75'),
(4, 26, 4, '1.00'),
(5, 26, 5, '1.00'),
(6, 26, 6, '1.25'),
(7, 26, 7, '1.50'),
(8, 26, 8, '1.75'),
(9, 26, 9, '1.75'),
(10, 26, 10, '2.00'),
(11, 26, 11, '2.25'),
(12, 26, 12, '2.50'),
(13, 26, 13, '2.50'),
(14, 26, 14, '2.75'),
(15, 26, 15, '3.00'),
(16, 26, 16, '3.25'),
(17, 26, 17, '3.50'),
(18, 26, 18, '3.50'),
(19, 26, 19, '3.75'),
(20, 26, 20, '4.00'),
(21, 26, 21, '4.25'),
(22, 26, 22, '4.25'),
(23, 26, 23, '4.50'),
(24, 26, 24, '4.75'),
(25, 26, 25, '4.75'),
(26, 26, 26, '5.00'),
(27, 25, 1, '0.25'),
(28, 25, 2, '0.50'),
(29, 25, 3, '0.75'),
(30, 25, 4, '1.00'),
(31, 25, 5, '1.00'),
(32, 25, 6, '1.25'),
(33, 25, 7, '1.50'),
(34, 25, 8, '1.75'),
(35, 25, 9, '2.00'),
(36, 25, 10, '2.00'),
(37, 25, 11, '2.25'),
(38, 25, 12, '2.50'),
(39, 25, 13, '2.75'),
(40, 25, 14, '3.00'),
(41, 25, 15, '3.00'),
(42, 25, 16, '3.25'),
(43, 25, 17, '3.50'),
(44, 25, 18, '3.75'),
(45, 25, 19, '4.00'),
(46, 25, 20, '4.00'),
(47, 25, 21, '4.25'),
(48, 25, 22, '4.50'),
(49, 25, 23, '4.75'),
(50, 25, 24, '4.75'),
(51, 25, 25, '5.00'),
(52, 24, 1, '0.25'),
(53, 24, 2, '0.50'),
(54, 24, 3, '0.75'),
(55, 24, 4, '1.00'),
(56, 24, 5, '1.25'),
(57, 24, 6, '1.25'),
(58, 24, 7, '1.50'),
(59, 24, 8, '1.75'),
(60, 24, 9, '2.00'),
(61, 24, 10, '2.25'),
(62, 24, 11, '2.50'),
(63, 24, 12, '2.50'),
(64, 24, 13, '2.75'),
(65, 24, 14, '3.00'),
(66, 24, 15, '3.25'),
(67, 24, 16, '3.50'),
(68, 24, 17, '3.75'),
(69, 24, 18, '3.75'),
(70, 24, 19, '4.00'),
(71, 24, 20, '4.25'),
(72, 24, 21, '4.50'),
(73, 24, 22, '4.75'),
(74, 24, 23, '4.75'),
(75, 24, 24, '5.00'),
(76, 23, 1, '0.25'),
(77, 23, 2, '0.50'),
(78, 23, 3, '0.75'),
(79, 23, 4, '1.00'),
(80, 23, 5, '1.25'),
(81, 23, 6, '1.50'),
(82, 23, 7, '1.75'),
(83, 23, 8, '1.75'),
(84, 23, 9, '2.00'),
(85, 23, 10, '2.25'),
(86, 23, 11, '2.50'),
(87, 23, 12, '2.75'),
(88, 23, 13, '3.00'),
(89, 23, 14, '3.25'),
(90, 23, 15, '3.50'),
(91, 23, 16, '3.50'),
(92, 23, 17, '3.75'),
(93, 23, 18, '4.00'),
(94, 23, 19, '4.25'),
(95, 23, 20, '4.50'),
(96, 23, 21, '4.75'),
(97, 23, 22, '4.75'),
(98, 23, 23, '5.00'),
(99, 22, 1, '0.25'),
(100, 22, 2, '0.50'),
(101, 22, 3, '0.75'),
(102, 22, 4, '1.00'),
(103, 22, 5, '1.25'),
(104, 22, 6, '1.50'),
(105, 22, 7, '1.75'),
(106, 22, 8, '2.00'),
(107, 22, 9, '2.25'),
(108, 22, 10, '2.50'),
(109, 22, 11, '2.50'),
(110, 22, 12, '2.75'),
(111, 22, 13, '3.00'),
(112, 22, 14, '3.25'),
(113, 22, 15, '3.50'),
(114, 22, 16, '3.75'),
(115, 22, 17, '4.00'),
(116, 22, 18, '4.25'),
(117, 22, 19, '4.50'),
(118, 22, 20, '4.75'),
(119, 22, 21, '4.75'),
(120, 22, 22, '5.00'),
(121, 21, 1, '0.25'),
(122, 21, 2, '0.50'),
(123, 21, 3, '0.75'),
(124, 21, 4, '1.00'),
(125, 21, 5, '1.25'),
(126, 21, 6, '1.50'),
(127, 21, 7, '1.75'),
(128, 21, 8, '2.00'),
(129, 21, 9, '2.25'),
(130, 21, 10, '2.50'),
(131, 21, 11, '2.75'),
(132, 21, 12, '3.00'),
(133, 21, 13, '3.25'),
(134, 21, 14, '3.50'),
(135, 21, 15, '3.75'),
(136, 21, 16, '4.00'),
(137, 21, 17, '4.25'),
(138, 21, 18, '4.50'),
(139, 21, 19, '4.75'),
(140, 21, 20, '4.75'),
(141, 21, 21, '5.00'),
(142, 20, 1, '0.25'),
(143, 20, 2, '0.50'),
(144, 20, 3, '0.75'),
(145, 20, 4, '1.00'),
(146, 20, 5, '1.25'),
(147, 20, 6, '1.50'),
(148, 20, 7, '1.75'),
(149, 20, 8, '2.00'),
(150, 20, 9, '2.25'),
(151, 20, 10, '2.50'),
(152, 20, 11, '2.75'),
(153, 20, 12, '3.00'),
(154, 20, 13, '3.25'),
(155, 20, 14, '3.50'),
(156, 20, 15, '3.75'),
(157, 20, 16, '4.00'),
(158, 20, 17, '4.25'),
(159, 20, 18, '4.50'),
(160, 20, 19, '4.75'),
(161, 20, 20, '5.00'),
(162, 19, 1, '0.50'),
(163, 19, 2, '0.75'),
(164, 19, 3, '1.00'),
(165, 19, 4, '1.25'),
(166, 19, 5, '1.50'),
(167, 19, 6, '1.75'),
(168, 19, 7, '2.00'),
(169, 19, 8, '2.25'),
(170, 19, 9, '2.50'),
(171, 19, 10, '2.75'),
(172, 19, 11, '3.00'),
(173, 19, 12, '3.25'),
(174, 19, 13, '3.50'),
(175, 19, 14, '3.75'),
(176, 19, 15, '4.00'),
(177, 19, 16, '4.25'),
(178, 19, 17, '4.50'),
(179, 19, 18, '4.75'),
(180, 19, 19, '5.00'),
(181, 18, 1, '0.50'),
(182, 18, 2, '0.75'),
(183, 18, 3, '1.00'),
(184, 18, 4, '1.25'),
(185, 18, 5, '1.50'),
(186, 18, 6, '1.75'),
(187, 18, 7, '2.00'),
(188, 18, 8, '2.25'),
(189, 18, 9, '2.50'),
(190, 18, 10, '3.00'),
(191, 18, 11, '3.25'),
(192, 18, 12, '3.50'),
(193, 18, 13, '3.75'),
(194, 18, 14, '4.00'),
(195, 18, 15, '4.25'),
(196, 18, 16, '4.50'),
(197, 18, 17, '4.75'),
(198, 18, 18, '5.00'),
(199, 17, 1, '0.50'),
(200, 17, 2, '0.75'),
(201, 17, 3, '1.00'),
(202, 17, 4, '1.25'),
(203, 17, 5, '1.50'),
(204, 17, 6, '2.00'),
(205, 17, 7, '2.25'),
(206, 17, 8, '2.50'),
(207, 17, 9, '2.75'),
(208, 17, 10, '3.00'),
(209, 17, 11, '3.25'),
(210, 17, 12, '3.75'),
(211, 17, 13, '4.00'),
(212, 17, 14, '4.25'),
(213, 17, 15, '4.50'),
(214, 17, 16, '4.75'),
(215, 17, 17, '5.00'),
(216, 16, 1, '0.50'),
(217, 16, 2, '0.75'),
(218, 16, 3, '1.00'),
(219, 16, 4, '1.25'),
(220, 16, 5, '1.75'),
(221, 16, 6, '2.00'),
(222, 16, 7, '2.25'),
(223, 16, 8, '2.50'),
(224, 16, 9, '3.00'),
(225, 16, 10, '3.25'),
(226, 16, 11, '3.50'),
(227, 16, 12, '3.75'),
(228, 16, 13, '4.25'),
(229, 16, 14, '4.50'),
(230, 16, 15, '4.75'),
(231, 16, 16, '5.00'),
(232, 15, 1, '0.50'),
(233, 15, 2, '0.75'),
(234, 15, 3, '1.00'),
(235, 15, 4, '1.50'),
(236, 15, 5, '1.75'),
(237, 15, 6, '2.00'),
(238, 15, 7, '2.50'),
(239, 15, 8, '2.75'),
(240, 15, 9, '3.00'),
(241, 15, 10, '3.50'),
(242, 15, 11, '3.75'),
(243, 15, 12, '4.00'),
(244, 15, 13, '4.50'),
(245, 15, 14, '4.75'),
(246, 15, 15, '5.00'),
(247, 14, 1, '0.50'),
(248, 14, 2, '0.75'),
(249, 14, 3, '1.25'),
(250, 14, 4, '1.50'),
(251, 14, 5, '2.00'),
(252, 14, 6, '2.25'),
(253, 14, 7, '2.50'),
(254, 14, 8, '3.00'),
(255, 14, 9, '3.25'),
(256, 14, 10, '3.75'),
(257, 14, 11, '4.00'),
(258, 14, 12, '4.50'),
(259, 14, 13, '4.75'),
(260, 14, 14, '5.00'),
(261, 13, 1, '0.50'),
(262, 13, 2, '1.00'),
(263, 13, 3, '1.25'),
(264, 13, 4, '1.75'),
(265, 13, 5, '2.00'),
(266, 13, 6, '2.50'),
(267, 13, 7, '2.75'),
(268, 13, 8, '3.25'),
(269, 13, 9, '3.50'),
(270, 13, 10, '4.00'),
(271, 13, 11, '4.25'),
(272, 13, 12, '4.75'),
(273, 13, 13, '5.00'),
(274, 12, 1, '0.50'),
(275, 12, 2, '1.00'),
(276, 12, 3, '1.25'),
(277, 12, 4, '1.75'),
(278, 12, 5, '2.25'),
(279, 12, 6, '2.50'),
(280, 12, 7, '3.00'),
(281, 12, 8, '3.50'),
(282, 12, 9, '3.75'),
(283, 12, 10, '4.25'),
(284, 12, 11, '4.75'),
(285, 12, 12, '5.00'),
(286, 11, 1, '0.50'),
(287, 11, 2, '1.00'),
(288, 11, 3, '1.50'),
(289, 11, 4, '2.00'),
(290, 11, 5, '2.50'),
(291, 11, 6, '2.75'),
(292, 11, 7, '3.25'),
(293, 11, 8, '3.75'),
(294, 11, 9, '4.25'),
(295, 11, 10, '4.75'),
(296, 11, 11, '5.00'),
(297, 10, 1, '0.50'),
(298, 10, 2, '1.00'),
(299, 10, 3, '1.50'),
(300, 10, 4, '2.00'),
(301, 10, 5, '2.50'),
(302, 10, 6, '3.00'),
(303, 10, 7, '3.50'),
(304, 10, 8, '4.00'),
(305, 10, 9, '4.75'),
(306, 10, 10, '5.00'),
(307, 9, 1, '0.75'),
(308, 9, 2, '1.25'),
(309, 9, 3, '1.75'),
(310, 9, 4, '2.25'),
(311, 9, 5, '3.00'),
(312, 9, 6, '3.50'),
(313, 9, 7, '3.75'),
(314, 9, 8, '4.75'),
(315, 9, 9, '5.00'),
(316, 8, 1, '0.75'),
(317, 8, 2, '1.25'),
(318, 8, 3, '2.00'),
(319, 8, 4, '2.50'),
(320, 8, 5, '3.25'),
(321, 8, 6, '3.75'),
(322, 8, 7, '4.75'),
(323, 8, 8, '5.00'),
(324, 7, 1, '0.75'),
(325, 7, 2, '1.50'),
(326, 7, 3, '2.25'),
(327, 7, 4, '3.00'),
(328, 7, 5, '3.75'),
(329, 7, 6, '4.75'),
(330, 7, 7, '5.00');

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `province_ID` bigint(20) UNSIGNED NOT NULL,
  `province` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`province_ID`, `province`, `created_at`, `updated_at`) VALUES
(1, 'Bukidnon', NULL, NULL),
(2, 'Lanao Del Norte', NULL, NULL),
(3, 'Misamis Oriental', NULL, NULL),
(4, 'Misamis Occidental', NULL, NULL),
(5, 'Camiguin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `registration_keys`
--

CREATE TABLE `registration_keys` (
  `registration_key_ID` bigint(20) UNSIGNED NOT NULL,
  `registration_key` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL DEFAULT 'unused',
  `user_type_ID` int(11) NOT NULL,
  `province_ID` int(11) DEFAULT NULL,
  `division_ID` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `smc`
--

CREATE TABLE `smc` (
  `smc_ID` bigint(20) UNSIGNED NOT NULL,
  `strategic_measure_ID` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `strategic_measures`
--

CREATE TABLE `strategic_measures` (
  `strategic_measure_ID` int(20) UNSIGNED NOT NULL,
  `strategic_measure` varchar(255) NOT NULL,
  `strategic_objective_ID` int(20) NOT NULL,
  `driver_ID` int(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `division_ID` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `number_measure` varchar(255) DEFAULT NULL,
  `opcr_ID` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `strategic_measures`
--

INSERT INTO `strategic_measures` (`strategic_measure_ID`, `strategic_measure`, `strategic_objective_ID`, `driver_ID`, `created_at`, `updated_at`, `division_ID`, `type`, `number_measure`, `opcr_ID`) VALUES
(290, 'dfd', 167, NULL, '2023-04-13 20:25:13', '2023-04-14 16:22:43', 1, '', '1', NULL),
(291, '3', 167, NULL, '2023-04-14 16:22:03', '2023-04-14 16:22:45', 1, '', '7', NULL),
(292, 'dfdf', 167, NULL, '2023-04-14 16:22:53', '2023-04-16 00:49:39', 2, '', '11', NULL),
(293, 'measure 1', 168, NULL, '2023-04-16 00:51:10', '2023-04-16 00:51:10', 1, 'DIRECT', '1', NULL),
(294, 'measure 3', 169, NULL, '2023-04-16 00:51:30', '2023-04-16 00:51:30', 2, 'DIRECT', '3', NULL),
(295, 'measure 2', 170, NULL, '2023-04-16 00:51:46', '2023-04-16 00:51:46', 3, 'DIRECT', '2', NULL),
(296, 'measure 4', 172, NULL, '2023-04-16 00:51:59', '2023-04-16 00:54:54', 1, '', NULL, NULL),
(297, 'measure 5', 171, NULL, '2023-04-16 00:52:13', '2023-04-16 00:52:54', 1, '', NULL, NULL),
(298, 'measure 7', 171, NULL, '2023-04-16 00:52:45', '2023-04-16 00:52:45', 1, 'DIRECT COMMON', '7', NULL),
(299, 'measure 7', 171, NULL, '2023-04-16 00:52:45', '2023-04-16 00:52:45', 2, 'DIRECT COMMON', '7', NULL),
(300, 'measure 7', 171, NULL, '2023-04-16 00:52:45', '2023-04-16 00:52:45', 3, 'DIRECT MAIN', '7', NULL),
(301, 'measure 5', 171, NULL, '2023-04-16 00:53:20', '2023-04-16 00:53:20', 2, 'DIRECT', '5', NULL),
(302, 'measure 6', 168, NULL, '2023-04-16 00:53:36', '2023-04-16 00:53:36', 2, 'DIRECT', '6', NULL),
(303, 'measure 4', 172, NULL, '2023-04-16 00:54:49', '2023-04-16 00:54:49', 3, 'DIRECT', '4', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `strategic_measures_sublabel`
--

CREATE TABLE `strategic_measures_sublabel` (
  `id` int(100) NOT NULL,
  `date_created` timestamp NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `label` varchar(1000) DEFAULT NULL,
  `strategic_measure_id` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `strategic_objectives`
--

CREATE TABLE `strategic_objectives` (
  `strategic_objective_ID` int(20) UNSIGNED NOT NULL,
  `strategic_objective` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `division_ID` int(11) DEFAULT NULL,
  `objective_letter` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `strategic_objectives`
--

INSERT INTO `strategic_objectives` (`strategic_objective_ID`, `strategic_objective`, `created_at`, `updated_at`, `division_ID`, `objective_letter`, `is_active`) VALUES
(167, 'Stardf', '2023-04-13 20:25:03', '2023-04-16 01:20:09', NULL, 'D', 0),
(168, 'Objective 1', '2023-04-16 00:50:00', '2023-04-16 00:50:00', NULL, 'A', 1),
(169, 'Objective 2', '2023-04-16 00:50:09', '2023-04-16 00:50:09', NULL, 'B', 1),
(170, 'Objective 3', '2023-04-16 00:50:18', '2023-04-16 00:50:18', NULL, 'C', 1),
(171, 'Objective 5', '2023-04-16 00:50:25', '2023-04-16 00:50:25', NULL, 'E', 1),
(172, 'Objective 4', '2023-04-16 00:50:34', '2023-04-16 00:50:34', NULL, 'D', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ID` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `extension_name` varchar(255) DEFAULT NULL,
  `birthday` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_type_ID` int(11) DEFAULT NULL,
  `division_ID` int(11) DEFAULT NULL,
  `province_ID` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ID`, `username`, `email`, `last_name`, `first_name`, `middle_name`, `extension_name`, `birthday`, `password`, `remember_token`, `created_at`, `updated_at`, `user_type_ID`, `division_ID`, `province_ID`) VALUES
(1, 'rd@gmail.com', 'rd@gmail.com', 'Director', 'Regional', 'RD', NULL, '2003-04-19', '$2y$10$T7nD.lovNnVb3TOUM1K2EeXoOJ2zOnNnYlrzENM5p9Kb0/I0XfnXC', NULL, NULL, NULL, 1, NULL, NULL),
(2, 'rpo@gmail.com', 'rpo@gmail.com', 'Planning Officer', 'Regional', 'RPOs', NULL, '2023-03-02', '$2a$12$PvG8JON8miILtVVUhyqaQ.IhFtAC6Qg9jpFu6Un.f0PlgT/Sy9a56', NULL, NULL, '2023-04-13 19:36:47', 2, NULL, NULL),
(112, 'ppobuk@gmail.com', 'ppobuk@gmail.com', 'Bukidnun', 'Provincial', 'O', NULL, '2003-04-19', '$2y$10$6m0iAbOl195fIoibqQU8kOKa2WLtIj/VYCnfcTyRxWXP3kXERbetG', NULL, NULL, '2023-04-16 00:45:33', 4, NULL, 1),
(113, 'pdbuk@gmail.com', 'pdbuk@gmail.com', 'Bukidnun', 'Provincial', 'D', NULL, '2003-04-19', '$2y$10$hDUL4QXIFD3/x8.fBSjwVOa1hMptc7A.GBvbXRl9iDAXyc2Xq6Mee', NULL, NULL, '2023-04-16 00:44:40', 3, NULL, 1),
(114, 'ppocam@gmail.com', 'ppocam@gmail.com', 'Camiguin', 'Provincial', 'O', NULL, '2003-04-19', '$2y$10$THkQqxy3WFBqFPzMTQGvSuI3GC1ItJicUjhh6hkVdqpSp6L6ne6gC', NULL, NULL, '2023-04-16 00:48:06', 4, NULL, 5),
(115, 'pdcam@gmail.com', 'pdcam@gmail.com', 'Camiguin', 'Provincial', 'D', NULL, '2003-04-19', '$2y$10$hzmArbqu4Bxd09htQHnGkOScxrFdhke/zxINbdph5Nwy4BuWN7kVG', NULL, NULL, '2023-04-16 00:46:36', 3, NULL, 5),
(116, 'bddbuk@gmail.com', 'bddbuk@gmail.com', 'Bukidnun', 'Division', 'BDD', NULL, '2003-04-19', '$2y$10$GzEezEnbqlfIEhmH5JdfDOrQvXf2HC9plGoTzUa4Fn9vuGsCHGVTi', NULL, NULL, '2023-04-16 00:38:54', 5, 1, 1),
(117, 'cpdbuk@gmail.com', 'cpdbuk@gmail.com', 'Bukidnun', 'Provincial', 'CPD', NULL, '2003-04-19', '$2y$10$0a7TRB.vbDgnOzmjRWg8geQi7J99mDGpApXfeLbDr2ehGzUis2fTe', NULL, NULL, '2023-04-16 00:39:42', 5, 2, 1),
(118, 'fadbuk@gmail.com', 'fadbuk@gmail.com', 'Bukidnun', 'Provincial', 'FAD', NULL, '2003-04-19', '$2y$10$ulCalY8aVBEOudsNDY9C/u/LmTjRm5GD5mN9Ez33r3PdxpPzkT4pm', NULL, NULL, '2023-04-16 00:41:12', 5, 3, 1),
(119, 'bddcam@gmail.com', 'bddcam@gmail.com', 'Camiguin', 'Division', 'BDD', NULL, '2003-04-19', '$2y$10$0M8om53ILukW1CqNEj5Tju2bc3pdqB73kPNypcBDLrQ4xAWvpQQEK', NULL, NULL, '2023-04-16 00:42:00', 5, 1, 5),
(120, 'cpdcam@gmail.com', 'cpdcam@gmail.com', 'Camiguin', 'Provincial', 'CPD', NULL, '2003-04-19', '$2y$10$5l6yYXiJ8gul2UqCAwPHNeTWT1LKUN6N5ad7qlTQaUJcppFiDtrl6', NULL, NULL, '2023-04-16 00:43:08', 5, 2, 5),
(121, 'fadcam@gmail.com', 'fadcam@gmail.com', 'Camiguin', 'Provincial', 'FAD', NULL, '2003-04-19', '$2y$10$l34baHSKtKFWxjb0VBOLp.ARnR3T68ErmO3./P4j0YSZbvmrY4zBu', NULL, NULL, '2023-04-16 00:43:54', 5, 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `user_type_ID` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`user_type_ID`, `user_type`, `created_at`, `updated_at`) VALUES
(1, 'Regional Director', NULL, NULL),
(2, 'Regional Planning Officer', NULL, NULL),
(3, 'Provincial Director', NULL, NULL),
(4, 'Provincial Planning Officer', NULL, NULL),
(5, 'Division Chief', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `annual_evaluations`
--
ALTER TABLE `annual_evaluations`
  ADD PRIMARY KEY (`annual_evaluation_ID`);

--
-- Indexes for table `annual_targets`
--
ALTER TABLE `annual_targets`
  ADD PRIMARY KEY (`annual_target_ID`),
  ADD KEY `annual_targets_driver_id_foreign` (`driver_ID`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`division_ID`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`driver_ID`);

--
-- Indexes for table `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`evaluation_ID`),
  ADD KEY `evaluations_user_id_foreign` (`user_ID`);

--
-- Indexes for table `file_uploads`
--
ALTER TABLE `file_uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_uploads_division_id_foreign` (`division_ID`),
  ADD KEY `file_uploads_province_id_foreign` (`province_ID`),
  ADD KEY `file_uploads_opcr_id_foreign` (`opcr_ID`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthly_evaluations`
--
ALTER TABLE `monthly_evaluations`
  ADD PRIMARY KEY (`monthly_evaluation_ID`);

--
-- Indexes for table `monthly_targets`
--
ALTER TABLE `monthly_targets`
  ADD PRIMARY KEY (`monthly_target_ID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_type_id_foreign` (`user_type_ID`),
  ADD KEY `notifications_user_id_foreign` (`user_ID`),
  ADD KEY `notifications_division_id_foreign` (`division_ID`),
  ADD KEY `notifications_province_id_foreign` (`province_ID`),
  ADD KEY `notifications_opcr_id_foreign` (`opcr_ID`);

--
-- Indexes for table `opcr`
--
ALTER TABLE `opcr`
  ADD PRIMARY KEY (`opcr_ID`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pgs`
--
ALTER TABLE `pgs`
  ADD PRIMARY KEY (`pgs_ID`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`province_ID`);

--
-- Indexes for table `registration_keys`
--
ALTER TABLE `registration_keys`
  ADD PRIMARY KEY (`registration_key_ID`);

--
-- Indexes for table `smc`
--
ALTER TABLE `smc`
  ADD PRIMARY KEY (`smc_ID`);

--
-- Indexes for table `strategic_measures`
--
ALTER TABLE `strategic_measures`
  ADD PRIMARY KEY (`strategic_measure_ID`),
  ADD KEY `strategic_objective_ID` (`strategic_objective_ID`),
  ADD KEY `strategic_measures_opcr_id_foreign` (`opcr_ID`);

--
-- Indexes for table `strategic_measures_sublabel`
--
ALTER TABLE `strategic_measures_sublabel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `strategic_objectives`
--
ALTER TABLE `strategic_objectives`
  ADD PRIMARY KEY (`strategic_objective_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_province_id_foreign` (`province_ID`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`user_type_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `annual_evaluations`
--
ALTER TABLE `annual_evaluations`
  MODIFY `annual_evaluation_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `annual_targets`
--
ALTER TABLE `annual_targets`
  MODIFY `annual_target_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3975;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `division_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `driver_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `evaluation_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `file_uploads`
--
ALTER TABLE `file_uploads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `monthly_evaluations`
--
ALTER TABLE `monthly_evaluations`
  MODIFY `monthly_evaluation_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `monthly_targets`
--
ALTER TABLE `monthly_targets`
  MODIFY `monthly_target_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=597;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=544;

--
-- AUTO_INCREMENT for table `opcr`
--
ALTER TABLE `opcr`
  MODIFY `opcr_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pgs`
--
ALTER TABLE `pgs`
  MODIFY `pgs_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=331;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `province_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `registration_keys`
--
ALTER TABLE `registration_keys`
  MODIFY `registration_key_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `smc`
--
ALTER TABLE `smc`
  MODIFY `smc_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `strategic_measures`
--
ALTER TABLE `strategic_measures`
  MODIFY `strategic_measure_ID` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=304;

--
-- AUTO_INCREMENT for table `strategic_measures_sublabel`
--
ALTER TABLE `strategic_measures_sublabel`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `strategic_objectives`
--
ALTER TABLE `strategic_objectives`
  MODIFY `strategic_objective_ID` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `user_type_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `annual_targets`
--
ALTER TABLE `annual_targets`
  ADD CONSTRAINT `annual_targets_driver_id_foreign` FOREIGN KEY (`driver_ID`) REFERENCES `drivers` (`driver_ID`) ON DELETE CASCADE;

--
-- Constraints for table `evaluations`
--
ALTER TABLE `evaluations`
  ADD CONSTRAINT `evaluations_user_id_foreign` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`);

--
-- Constraints for table `file_uploads`
--
ALTER TABLE `file_uploads`
  ADD CONSTRAINT `file_uploads_division_id_foreign` FOREIGN KEY (`division_ID`) REFERENCES `divisions` (`division_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `file_uploads_opcr_id_foreign` FOREIGN KEY (`opcr_ID`) REFERENCES `opcr` (`opcr_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `file_uploads_province_id_foreign` FOREIGN KEY (`province_ID`) REFERENCES `provinces` (`province_ID`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_division_id_foreign` FOREIGN KEY (`division_ID`) REFERENCES `divisions` (`division_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_opcr_id_foreign` FOREIGN KEY (`opcr_ID`) REFERENCES `opcr` (`opcr_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_province_id_foreign` FOREIGN KEY (`province_ID`) REFERENCES `provinces` (`province_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_ID`) REFERENCES `users` (`user_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_user_type_id_foreign` FOREIGN KEY (`user_type_ID`) REFERENCES `user_types` (`user_type_ID`) ON DELETE CASCADE;

--
-- Constraints for table `strategic_measures`
--
ALTER TABLE `strategic_measures`
  ADD CONSTRAINT `strategic_measures_opcr_id_foreign` FOREIGN KEY (`opcr_ID`) REFERENCES `opcr` (`opcr_ID`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_province_id_foreign` FOREIGN KEY (`province_ID`) REFERENCES `provinces` (`province_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
