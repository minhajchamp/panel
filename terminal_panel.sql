-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2022 at 02:57 PM
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
-- Database: `terminal_panel`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_address` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_picture` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`, `brand_website`, `brand_address`, `brand_contact`, `brand_email`, `brand_picture`, `brand_description`, `brand_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'bKG9kcnAWa', 'https://google.com', 'CzuZC4u4Cs@gmail.com', '+923032323232', 'tesla@gmail.com', 'google-stadia-logo-hd4.png', 'Lorem ipsum', 1, '2022-09-13 11:33:37', '2022-09-13 11:34:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `brands_services`
--

CREATE TABLE `brands_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands_services`
--

INSERT INTO `brands_services` (`id`, `service_id`, `brand_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `client_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_address` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_picture` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_gender` enum('M','F') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_dob` date DEFAULT NULL,
  `client_timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_organization` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_last_login_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_last_login` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_status` tinyint(1) NOT NULL DEFAULT 1,
  `client_verified` tinyint(1) NOT NULL DEFAULT 0,
  `client_misc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salt_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_picture` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_settings`
--

CREATE TABLE `email_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email_for` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_template` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_sent_cl` tinyint(1) NOT NULL DEFAULT 0,
  `invoice_sent_emp` tinyint(1) NOT NULL DEFAULT 0,
  `invoice_is_seen` tinyint(1) NOT NULL DEFAULT 0,
  `invoice_status` enum('paid','unpaid') COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_sent_at` date DEFAULT NULL,
  `invoice_details` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lead_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lead_source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lead_misc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lead_working_status` enum('converted','pending') COLLATE utf8mb4_unicode_ci NOT NULL,
  `lead_status` tinyint(1) NOT NULL DEFAULT 1,
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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_08_30_144941_create_clients_table', 1),
(6, '2022_08_30_144956_create_brands_table', 1),
(7, '2022_08_30_145010_create_leads_table', 1),
(8, '2022_08_30_145025_create_departments_table', 1),
(9, '2022_08_30_145039_create_sub__departments_table', 1),
(10, '2022_09_01_114006_create_permission_tables', 1),
(11, '2022_09_01_123345_clients_users', 1),
(12, '2022_09_01_123358_users_leads', 1),
(13, '2022_09_01_123411_users_brands', 1),
(14, '2022_09_06_154001_create_services_table', 1),
(15, '2022_09_06_155548_brands_services', 1),
(16, '2022_09_09_123616_create_payments_table', 1),
(17, '2022_09_09_140456_create_email_settings_table', 1),
(18, '2022_09_13_130919_smtp_settings', 1),
(19, '2022_09_13_141751_smtp_settings_alter', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
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

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `method_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_details` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `method_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `method_name`, `method_type`, `method_picture`, `method_details`, `method_status`, `created_at`, `updated_at`) VALUES
(1, 'Stripe', '1', 'stripe.png', '', 1, '2022-09-13 11:33:37', '2022-09-13 11:33:37'),
(2, 'Paypal', '1', 'paypal.png', '', 1, '2022-09-13 11:33:37', '2022-09-13 11:33:37'),
(3, 'Square Up', '1', 'square.png', '', 1, '2022-09-13 11:33:37', '2022-09-13 11:33:37'),
(4, 'Payment Cloud', '1', 'pcloud.png', '', 1, '2022-09-13 11:33:37', '2022-09-13 11:33:37');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'edit brands', 'web', '2022-09-13 23:33:37', '2022-09-13 23:33:37'),
(2, 'add brands', 'web', '2022-09-13 23:33:37', '2022-09-13 23:33:37'),
(3, 'remove brands', 'web', '2022-09-13 23:33:37', '2022-09-13 23:33:37'),
(4, 'list brands', 'web', '2022-09-13 23:33:37', '2022-09-13 23:33:37'),
(5, 'edit leads', 'web', '2022-09-13 23:33:37', '2022-09-13 23:33:37'),
(6, 'add leads', 'web', '2022-09-13 23:33:37', '2022-09-13 23:33:37'),
(7, 'remove leads', 'web', '2022-09-13 23:33:37', '2022-09-13 23:33:37'),
(8, 'list leads', 'web', '2022-09-13 23:33:37', '2022-09-13 23:33:37'),
(9, 'edit settings', 'web', '2022-09-13 23:33:37', '2022-09-13 23:33:37'),
(10, 'add settings', 'web', '2022-09-13 23:33:37', '2022-09-13 23:33:37'),
(11, 'remove settings', 'web', '2022-09-13 23:33:37', '2022-09-13 23:33:37'),
(12, 'list settings', 'web', '2022-09-13 23:33:37', '2022-09-13 23:33:37'),
(13, 'edit payments', 'web', '2022-09-13 23:33:37', '2022-09-13 23:33:37'),
(14, 'add payments', 'web', '2022-09-13 23:33:37', '2022-09-13 23:33:37'),
(15, 'remove payments', 'web', '2022-09-13 23:33:37', '2022-09-13 23:33:37'),
(16, 'list payments', 'web', '2022-09-13 23:33:37', '2022-09-13 23:33:37');

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
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2022-09-13 23:33:37', '2022-09-13 23:33:37'),
(2, 'client', 'web', '2022-09-13 23:33:37', '2022-09-13 23:33:37'),
(3, 'users', 'web', '2022-09-13 23:33:37', '2022-09-13 23:33:37');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(13, 3),
(14, 3),
(15, 3),
(16, 3);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_picture` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_name`, `service_type`, `service_picture`, `service_description`, `service_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '71MGLI5gYg', 'Serve', '', 'Lorem ipsum..', 1, '2022-09-13 11:33:37', '2022-09-13 11:33:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `smtp_settings`
--

CREATE TABLE `smtp_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `smtp_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_port` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_driver` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_host` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_encryption` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tls',
  `smtp_from_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `smtp_status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_departments`
--

CREATE TABLE `sub_departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_department_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `sub_department_picture` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_department_description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_department_status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_address` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_picture` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_gender` enum('M','F') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_dob` date DEFAULT NULL,
  `user_timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_organization` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_last_login_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_last_login` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_status` tinyint(1) NOT NULL DEFAULT 1,
  `user_verified` tinyint(1) NOT NULL DEFAULT 0,
  `user_misc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salt_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `brand_id`, `name`, `user_country`, `user_city`, `user_state`, `user_address`, `user_contact`, `email`, `user_picture`, `user_gender`, `user_dob`, `user_timezone`, `user_currency`, `user_language`, `user_organization`, `user_last_login_ip`, `user_last_login`, `user_status`, `user_verified`, `user_misc`, `password`, `salt_password`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, NULL, 'yIJA1Wp2qx', 'Pakistan', 'Karachi', NULL, NULL, '+923032323232', 'oQlqlQYnX6@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '$2y$10$gsebULxKaCUThrQ25DmvXOLuiA/vAxyGogT2dicaAL6Mr1sd3BuZW', 'Helloworld', NULL, NULL, '2022-09-13 11:33:37', '2022-09-13 11:33:37', NULL),
(2, 2, 1, 'Dolan Arnold', 'Benin', 'Praesentium molestia', 'Consectetur non dolo', 'Incidunt non sint', '+1 (495) 347-1611', 'jawyvafe@mailinator.com', '123 - Copy.png', 'F', '1978-05-04', '-8', 'usd', 'de', NULL, NULL, NULL, 1, 0, NULL, '$2y$10$htTITzL0MeHrahoOwCqFxeO/4ehV2NYWKjDptZAKePpmnXUkqpW/C', 'helloworld', NULL, NULL, '2022-09-13 11:34:18', '2022-09-13 23:34:18', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands_services`
--
ALTER TABLE `brands_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_services_service_id_brand_id_unique` (`service_id`,`brand_id`),
  ADD KEY `brands_services_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clients_client_name_client_country_client_city_index` (`client_name`,`client_country`,`client_city`),
  ADD KEY `clients_role_id_foreign` (`role_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_settings`
--
ALTER TABLE `email_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_payment_id_unique` (`payment_id`),
  ADD UNIQUE KEY `invoice_invoice_token_unique` (`invoice_token`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_method_id_foreign` (`method_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smtp_settings`
--
ALTER TABLE `smtp_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `smtp_settings_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `sub_departments`
--
ALTER TABLE `sub_departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_departments_department_id_foreign` (`department_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_name_user_country_user_city_index` (`name`,`user_country`,`user_city`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_brand_id_foreign` (`brand_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands_services`
--
ALTER TABLE `brands_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_settings`
--
ALTER TABLE `email_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `smtp_settings`
--
ALTER TABLE `smtp_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_departments`
--
ALTER TABLE `sub_departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `brands_services`
--
ALTER TABLE `brands_services`
  ADD CONSTRAINT `brands_services_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `brands_services_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_method_id_foreign` FOREIGN KEY (`method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `smtp_settings`
--
ALTER TABLE `smtp_settings`
  ADD CONSTRAINT `smtp_settings_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`);

--
-- Constraints for table `sub_departments`
--
ALTER TABLE `sub_departments`
  ADD CONSTRAINT `sub_departments_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
