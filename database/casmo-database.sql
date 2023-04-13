-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2023 at 01:06 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `casmo-notif`
--

-- --------------------------------------------------------

--
-- Table structure for table `annual_evaluations`
--

CREATE TABLE `annual_evaluations` (
  `annual_evaluation_ID` bigint(20) UNSIGNED NOT NULL,
  `annual_target_ID` int(11) NOT NULL,
  `reason` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `division_ID` bigint(20) UNSIGNED NOT NULL,
  `division` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province_ID` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`division_ID`, `division`, `code`, `province_ID`) VALUES
(1, 'Business Development Division', 'BDD', 0),
(2, 'Consumer Protection Division', 'CPD', 0),
(3, 'Finance Administrative Division', 'FAD', 0);

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `driver_ID` bigint(20) UNSIGNED NOT NULL,
  `driver` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opcr_ID` bigint(20) UNSIGNED NOT NULL,
  `division_ID` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evaluations`
--

CREATE TABLE `evaluations` (
  `evaluation_ID` bigint(20) UNSIGNED NOT NULL,
  `user_ID` bigint(20) UNSIGNED NOT NULL,
  `strategic_measure` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monthly_target` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monthly_accomplishment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `month` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_uploads`
--

CREATE TABLE `file_uploads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `opcr_ID` bigint(20) UNSIGNED DEFAULT NULL,
  `division_ID` bigint(20) UNSIGNED DEFAULT NULL,
  `province_ID` bigint(20) UNSIGNED DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(36, '2023_04_09_103725_create_file_uploads_table', 16);

-- --------------------------------------------------------

--
-- Table structure for table `monthly_evaluations`
--

CREATE TABLE `monthly_evaluations` (
  `monthly_evaluation_ID` bigint(20) UNSIGNED NOT NULL,
  `monthly_target_ID` int(11) NOT NULL,
  `reason` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `month` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `monthly_target` int(11) DEFAULT NULL,
  `monthly_accomplishment` int(11) DEFAULT NULL,
  `validated` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Not Validated',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `opcr`
--

CREATE TABLE `opcr` (
  `opcr_ID` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` int(100) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_submitted` tinyint(1) DEFAULT NULL,
  `is_submitted_division` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--


-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `province_ID` bigint(20) UNSIGNED NOT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`province_ID`, `province`) VALUES
(1, 'Bukidnon'),
(2, 'Lanao Del Norte'),
(3, 'Misamis Oriental'),
(4, 'Misamis Occidental'),
(5, 'Camiguin');

-- --------------------------------------------------------

--
-- Table structure for table `registration_keys`
--

CREATE TABLE `registration_keys` (
  `registration_key_ID` bigint(20) UNSIGNED NOT NULL,
  `registration_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unused',
  `user_type_ID` int(11) NOT NULL,
  `province_ID` int(11) DEFAULT NULL,
  `division_ID` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registration_keys`
--



-- --------------------------------------------------------

--
-- Table structure for table `smc`
--

CREATE TABLE `smc` (
  `smc_ID` bigint(20) UNSIGNED NOT NULL,
  `strategic_measure_ID` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `strategic_measures`
--

CREATE TABLE `strategic_measures` (
  `strategic_measure_ID` int(20) UNSIGNED NOT NULL,
  `strategic_measure` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `strategic_objective_ID` int(20) NOT NULL,
  `driver_ID` int(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `division_ID` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_division` int(11) DEFAULT NULL,
  `opcr_ID` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- --------------------------------------------------------

--
-- Table structure for table `strategic_measures_sublabel`
--

CREATE TABLE `strategic_measures_sublabel` (
  `id` int(100) NOT NULL,
  `date_created` timestamp NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `label` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `strategic_measure_id` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `strategic_objectives`
--

CREATE TABLE `strategic_objectives` (
  `strategic_objective_ID` int(20) UNSIGNED NOT NULL,
  `strategic_objective` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `division_ID` int(11) DEFAULT NULL,
  `letter_division` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_ID` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_type_ID` int(11) DEFAULT NULL,
  `division_ID` int(11) DEFAULT NULL,
  `province_ID` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_ID`, `username`, `email`, `last_name`, `first_name`, `middle_name`, `extension_name`, `birthday`, `password`, `remember_token`, `user_type_ID`, `division_ID`, `province_ID`) VALUES
(1, 'rd@gmail.com', 'rd@gmail.com', 'Director', 'Regional', 'RD', NULL, '2003-04-19', '$2y$10$T7nD.lovNnVb3TOUM1K2EeXoOJ2zOnNnYlrzENM5p9Kb0/I0XfnXC', NULL, 1, NULL, NULL),
(2, 'rpo@gmail.com', 'rpo@gmail.com', 'Planning Officer', 'Regional', 'RPO', NULL, '2023-03-02', '$2y$10$E3OTDpBZuOopLLYgjQKP3.7FzWKfwukSBfnFWMzuEH9z3ve4n8d2S', NULL, 2, NULL, NULL);
-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `user_type_ID` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`user_type_ID`, `user_type`) VALUES
(1, 'Regional Director'),
(2, 'Regional Planning Officer'),
(3, 'Provincial Director'),
(4, 'Provincial Planning Officer'),
(5, 'Division Chief');

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
  MODIFY `annual_target_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3885;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `division_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `driver_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `evaluation_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `file_uploads`
--
ALTER TABLE `file_uploads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `monthly_evaluations`
--
ALTER TABLE `monthly_evaluations`
  MODIFY `monthly_evaluation_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `monthly_targets`
--
ALTER TABLE `monthly_targets`
  MODIFY `monthly_target_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=489;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=406;

--
-- AUTO_INCREMENT for table `opcr`
--
ALTER TABLE `opcr`
  MODIFY `opcr_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `strategic_measure_ID` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=280;

--
-- AUTO_INCREMENT for table `strategic_measures_sublabel`
--
ALTER TABLE `strategic_measures_sublabel`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `strategic_objectives`
--
ALTER TABLE `strategic_objectives`
  MODIFY `strategic_objective_ID` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

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
