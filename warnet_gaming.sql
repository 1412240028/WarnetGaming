-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 15, 2026 at 02:36 AM
-- Server version: 8.4.3
-- PHP Version: 8.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `warnet_gaming`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food_beverages`
--

CREATE TABLE `food_beverages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('food','drink','snack') COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `food_beverages`
--

INSERT INTO `food_beverages` (`id`, `name`, `category`, `price`, `stock`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 'Indomie Telur', 'food', 10000.00, 48, 1, '2026-07-07 20:45:00', '2026-07-07 20:51:03'),
(2, 'Nasi Goreng', 'food', 15000.00, 30, 1, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(3, 'Es Teh Manis', 'drink', 5000.00, 100, 1, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(4, 'Kopi Hitam', 'drink', 6000.00, 100, 1, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(5, 'Chitato', 'snack', 8000.00, 40, 1, '2026-07-07 20:45:00', '2026-07-07 20:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `food_orders`
--

CREATE TABLE `food_orders` (
  `id` bigint UNSIGNED NOT NULL,
  `gaming_session_id` bigint UNSIGNED NOT NULL,
  `pelanggan_id` bigint UNSIGNED NOT NULL,
  `operator_id` bigint UNSIGNED DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','delivered','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `food_orders`
--

INSERT INTO `food_orders` (`id`, `gaming_session_id`, `pelanggan_id`, `operator_id`, `total_amount`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 20, 2, 2, 74000.00, 'paid', '2026-07-07 20:45:00', '2026-07-07 20:45:00', NULL),
(2, 42, 3, 3, 20000.00, 'delivered', '2026-07-07 20:45:00', '2026-07-07 20:45:00', NULL),
(3, 44, 2, 2, 6000.00, 'pending', '2026-07-07 20:45:00', '2026-07-07 20:45:00', NULL),
(4, 28, 1, 1, 8000.00, 'delivered', '2026-07-07 20:45:00', '2026-07-07 20:45:00', NULL),
(5, 18, 3, 3, 31000.00, 'paid', '2026-07-07 20:45:00', '2026-07-07 20:45:00', NULL),
(6, 30, 3, 3, 24000.00, 'delivered', '2026-07-07 20:45:00', '2026-07-07 20:45:00', NULL),
(7, 32, 2, 2, 18000.00, 'pending', '2026-07-07 20:45:00', '2026-07-07 20:45:00', NULL),
(8, 25, 1, 1, 39000.00, 'paid', '2026-07-07 20:45:00', '2026-07-07 20:45:00', NULL),
(9, 39, 3, 3, 26000.00, 'pending', '2026-07-07 20:45:00', '2026-07-07 20:45:00', NULL),
(10, 33, 3, 3, 69000.00, 'pending', '2026-07-07 20:45:00', '2026-07-07 20:45:00', NULL),
(11, 1, 1, NULL, 20000.00, 'pending', '2026-07-07 20:51:03', '2026-07-07 20:51:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `food_order_items`
--

CREATE TABLE `food_order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `food_order_id` bigint UNSIGNED NOT NULL,
  `food_beverage_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `food_order_items`
--

INSERT INTO `food_order_items` (`id`, `food_order_id`, `food_beverage_id`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3, 30000.00, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(2, 1, 1, 2, 20000.00, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(3, 1, 5, 3, 24000.00, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(4, 2, 1, 2, 20000.00, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(5, 3, 4, 1, 6000.00, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(6, 4, 5, 1, 8000.00, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(7, 5, 5, 2, 16000.00, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(8, 5, 2, 1, 15000.00, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(9, 6, 5, 3, 24000.00, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(10, 7, 4, 2, 12000.00, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(11, 7, 4, 1, 6000.00, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(12, 8, 5, 3, 24000.00, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(13, 8, 3, 3, 15000.00, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(14, 9, 5, 1, 8000.00, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(15, 9, 1, 1, 10000.00, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(16, 9, 5, 1, 8000.00, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(17, 10, 3, 3, 15000.00, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(18, 10, 2, 2, 30000.00, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(19, 10, 5, 3, 24000.00, '2026-07-07 20:45:00', '2026-07-07 20:45:00'),
(20, 11, 1, 2, 20000.00, '2026-07-07 20:51:03', '2026-07-07 20:51:03');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Valorant', '2026-07-07 20:44:59', '2026-07-07 20:44:59'),
(2, 'DOTA 2', '2026-07-07 20:44:59', '2026-07-07 20:44:59'),
(3, 'CS2', '2026-07-07 20:44:59', '2026-07-07 20:44:59'),
(4, 'PUBG', '2026-07-07 20:44:59', '2026-07-07 20:44:59'),
(5, 'EA FC 26', '2026-07-07 20:44:59', '2026-07-07 20:44:59'),
(6, 'League of Legends', '2026-07-07 20:44:59', '2026-07-07 20:44:59'),
(7, 'Minecraft', '2026-07-07 20:44:59', '2026-07-07 20:44:59'),
(8, 'GTA V', '2026-07-07 20:44:59', '2026-07-07 20:44:59'),
(9, 'Apex Legends', '2026-07-07 20:44:59', '2026-07-07 20:44:59'),
(10, 'Roblox', '2026-07-07 20:44:59', '2026-07-07 20:44:59'),
(11, 'Point Blank', '2026-07-07 20:44:59', '2026-07-07 20:44:59'),
(12, 'Left 4 Dead 2', '2026-07-07 20:44:59', '2026-07-07 20:44:59'),
(13, 'Overwatch 2', '2026-07-07 20:44:59', '2026-07-07 20:44:59'),
(14, 'Rocket League', '2026-07-07 20:44:59', '2026-07-07 20:44:59'),
(15, 'Fortnite', '2026-07-07 20:44:59', '2026-07-07 20:44:59');

-- --------------------------------------------------------

--
-- Table structure for table `gaming_sessions`
--

CREATE TABLE `gaming_sessions` (
  `id` bigint UNSIGNED NOT NULL,
  `pelanggan_id` bigint UNSIGNED NOT NULL,
  `operator_id` bigint UNSIGNED NOT NULL,
  `pc_id` bigint UNSIGNED NOT NULL,
  `room_id` bigint UNSIGNED NOT NULL,
  `started_at` timestamp NOT NULL,
  `ended_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gaming_sessions`
--

INSERT INTO `gaming_sessions` (`id`, `pelanggan_id`, `operator_id`, `pc_id`, `room_id`, `started_at`, `ended_at`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, 1, '2026-07-04 08:44:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(2, 2, 2, 2, 2, '2026-07-07 12:41:59', '2026-07-07 13:18:59', 'finished', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(3, 3, 3, 3, 3, '2026-07-01 08:59:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(4, 1, 1, 4, 1, '2026-07-05 21:40:59', '2026-07-05 23:27:59', 'finished', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(5, 2, 2, 5, 2, '2026-07-01 01:35:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(6, 3, 3, 6, 3, '2026-07-01 11:15:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(7, 1, 1, 7, 1, '2026-07-02 05:37:59', '2026-07-02 06:19:59', 'finished', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(8, 2, 2, 8, 2, '2026-07-01 21:33:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(9, 3, 3, 9, 3, '2026-07-03 01:19:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(10, 1, 1, 10, 1, '2026-07-06 21:07:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(11, 2, 2, 11, 2, '2026-07-01 02:20:59', '2026-07-01 04:30:59', 'finished', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(12, 3, 3, 12, 3, '2026-07-04 12:41:59', '2026-07-04 14:53:59', 'finished', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(13, 1, 1, 13, 1, '2026-07-03 06:53:59', '2026-07-03 07:32:59', 'finished', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(14, 2, 2, 14, 2, '2026-07-07 01:56:59', '2026-07-07 03:02:59', 'finished', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(15, 3, 3, 15, 3, '2026-07-05 06:48:59', '2026-07-05 07:35:59', 'finished', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(16, 1, 1, 16, 1, '2026-07-01 00:16:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(17, 2, 2, 17, 2, '2026-07-04 04:33:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(18, 3, 3, 18, 3, '2026-07-06 18:27:59', '2026-07-06 19:17:59', 'finished', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(19, 1, 1, 19, 1, '2026-07-03 09:10:59', '2026-07-03 10:56:59', 'finished', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(20, 2, 2, 20, 2, '2026-07-06 17:46:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(21, 3, 3, 1, 1, '2026-07-01 01:30:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(22, 1, 1, 2, 2, '2026-07-05 19:23:59', '2026-07-05 20:06:59', 'finished', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(23, 2, 2, 3, 3, '2026-07-02 11:01:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(24, 3, 3, 4, 1, '2026-07-03 01:43:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(25, 1, 1, 5, 2, '2026-07-02 01:42:59', '2026-07-02 04:20:59', 'finished', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(26, 2, 2, 6, 3, '2026-07-06 04:34:59', '2026-07-06 05:38:59', 'finished', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(27, 3, 3, 7, 1, '2026-07-02 01:56:59', '2026-07-02 03:29:59', 'finished', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(28, 1, 1, 8, 2, '2026-07-07 07:17:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(29, 2, 2, 9, 3, '2026-07-01 10:18:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(30, 3, 3, 10, 1, '2026-07-02 12:57:59', '2026-07-02 14:43:59', 'finished', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(31, 1, 1, 11, 2, '2026-07-03 17:52:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(32, 2, 2, 12, 3, '2026-07-02 14:16:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(33, 3, 3, 13, 1, '2026-07-05 16:19:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(34, 1, 1, 14, 2, '2026-07-04 17:49:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(35, 2, 2, 15, 3, '2026-07-01 17:00:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(36, 3, 3, 16, 1, '2026-07-04 08:27:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(37, 1, 1, 17, 2, '2026-07-04 04:45:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(38, 2, 2, 18, 3, '2026-07-04 11:52:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(39, 3, 3, 19, 1, '2026-07-05 16:27:59', '2026-07-05 18:15:59', 'finished', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(40, 1, 1, 20, 2, '2026-07-01 19:17:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(41, 2, 2, 1, 1, '2026-07-01 18:04:59', '2026-07-01 21:04:59', 'finished', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(42, 3, 3, 2, 2, '2026-07-06 17:52:59', '2026-07-06 19:27:59', 'finished', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(43, 1, 1, 3, 3, '2026-07-02 11:38:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(44, 2, 2, 4, 1, '2026-07-05 20:25:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(45, 3, 3, 5, 2, '2026-07-03 14:58:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(46, 1, 1, 6, 3, '2026-07-06 20:14:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(47, 2, 2, 7, 1, '2026-07-06 13:22:59', '2026-07-06 15:35:59', 'finished', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(48, 3, 3, 8, 2, '2026-07-02 17:17:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(49, 1, 1, 9, 3, '2026-07-03 18:35:59', NULL, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(50, 2, 2, 10, 1, '2026-07-02 20:53:59', '2026-07-02 23:25:59', 'finished', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `id` bigint UNSIGNED NOT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_percent` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `level`, `discount_percent`, `tag`, `created_at`, `updated_at`) VALUES
(1, 'Bronze', 0, NULL, '2026-07-07 20:44:59', '2026-07-07 20:44:59'),
(2, 'Silver', 5, NULL, '2026-07-07 20:44:59', '2026-07-07 20:44:59'),
(3, 'Gold', 10, NULL, '2026-07-07 20:44:59', '2026-07-07 20:44:59'),
(4, 'Platinum', 15, NULL, '2026-07-07 20:44:59', '2026-07-07 20:44:59');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_07_02_142211_create_memberships_table', 1),
(5, '2026_07_02_142225_create_pelanggans_table', 1),
(6, '2026_07_02_142240_create_rooms_table', 1),
(7, '2026_07_02_142250_create_operators_table', 1),
(8, '2026_07_02_142259_create_pcs_table', 1),
(9, '2026_07_02_142301_create_games_table', 1),
(10, '2026_07_02_142303_create_gaming_sessions_table', 1),
(11, '2026_07_02_142315_create_payments_table', 1),
(12, '2026_07_02_142317_create_session_games_table', 1),
(13, '2026_07_02_142318_create_pc_games_table', 1),
(14, '2026_07_02_142319_create_user_games_table', 1),
(15, '2026_07_02_145952_create_personal_access_tokens_table', 1),
(16, '2026_07_05_144310_create_food_beverages_table', 1),
(17, '2026_07_05_144430_create_food_orders_table', 1),
(18, '2026_07_05_144502_create_food_order_items_table', 1),
(19, '2026_07_05_145213_add_role_to_users_table', 1),
(20, '2026_07_06_000000_add_unique_session_games_constraint', 1),
(21, '2026_07_07_085417_add_soft_deletes_to_multiple_tables', 1),
(22, '2026_07_07_090551_add_indexes_for_performance', 1);

-- --------------------------------------------------------

--
-- Table structure for table `operators`
--

CREATE TABLE `operators` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `room_id` bigint UNSIGNED NOT NULL,
  `shift` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pagi',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `operators`
--

INSERT INTO `operators` (`id`, `user_id`, `room_id`, `shift`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Pagi', '2026-07-07 20:44:59', '2026-07-07 20:44:59'),
(2, 2, 2, 'Siang', '2026-07-07 20:44:59', '2026-07-07 20:44:59'),
(3, 3, 3, 'Malam', '2026-07-07 20:44:59', '2026-07-07 20:44:59');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `gaming_session_id` bigint UNSIGNED NOT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` int UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'paid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `gaming_session_id`, `method`, `nominal`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 36, 'transfer', 75000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:52:10', '2026-07-07 20:52:10'),
(2, 27, 'transfer', 75000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(3, 2, 'qris', 15000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(4, 20, 'qris', 35000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(5, 13, 'transfer', 15000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(6, 21, 'qris', 75000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(7, 35, 'transfer', 35000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(8, 34, 'qris', 50000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(9, 10, 'cash', 75000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(10, 33, 'cash', 50000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(11, 18, 'transfer', 15000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(12, 22, 'qris', 75000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(13, 32, 'transfer', 15000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(14, 16, 'transfer', 35000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(15, 47, 'cash', 50000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(16, 5, 'qris', 15000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(17, 38, 'qris', 25000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(18, 3, 'qris', 75000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(19, 17, 'transfer', 25000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(20, 25, 'qris', 25000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(21, 26, 'cash', 75000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(22, 43, 'cash', 15000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(23, 12, 'transfer', 15000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(24, 41, 'qris', 75000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(25, 45, 'qris', 75000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(26, 6, 'transfer', 15000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(27, 46, 'cash', 25000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(28, 8, 'cash', 75000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(29, 29, 'transfer', 75000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(30, 7, 'cash', 50000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(31, 31, 'cash', 15000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(32, 4, 'qris', 35000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(33, 30, 'qris', 75000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(34, 23, 'cash', 35000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(35, 19, 'qris', 35000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(36, 28, 'qris', 50000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(37, 48, 'qris', 50000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(38, 11, 'transfer', 50000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(39, 42, 'transfer', 25000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(40, 14, 'cash', 35000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(41, 49, 'transfer', 35000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(42, 37, 'transfer', 25000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(43, 40, 'cash', 75000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(44, 24, 'transfer', 75000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(45, 1, 'transfer', 25000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(46, 15, 'qris', 15000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(47, 9, 'transfer', 15000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(48, 39, 'qris', 25000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(49, 50, 'qris', 50000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(50, 44, 'cash', 75000, 'paid', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pcs`
--

CREATE TABLE `pcs` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_id` bigint UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pcs`
--

INSERT INTO `pcs` (`id`, `code`, `room_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'PC01', 1, 'in_use', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(2, 'PC02', 2, 'maintenance', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(3, 'PC03', 3, 'available', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(4, 'PC04', 1, 'in_use', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(5, 'PC05', 2, 'maintenance', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(6, 'PC06', 3, 'available', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(7, 'PC07', 1, 'in_use', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(8, 'PC08', 2, 'maintenance', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(9, 'PC09', 3, 'available', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(10, 'PC10', 1, 'in_use', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(11, 'PC11', 2, 'maintenance', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(12, 'PC12', 3, 'available', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(13, 'PC13', 1, 'in_use', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(14, 'PC14', 2, 'maintenance', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(15, 'PC15', 3, 'available', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(16, 'PC16', 1, 'in_use', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(17, 'PC17', 2, 'maintenance', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(18, 'PC18', 3, 'available', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(19, 'PC19', 1, 'in_use', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(20, 'PC20', 2, 'maintenance', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pc_games`
--

CREATE TABLE `pc_games` (
  `id` bigint UNSIGNED NOT NULL,
  `pc_id` bigint UNSIGNED NOT NULL,
  `game_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pc_games`
--

INSERT INTO `pc_games` (`id`, `pc_id`, `game_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 3, NULL, NULL),
(3, 1, 7, NULL, NULL),
(4, 1, 9, NULL, NULL),
(5, 1, 13, NULL, NULL),
(6, 2, 1, NULL, NULL),
(7, 2, 2, NULL, NULL),
(8, 2, 4, NULL, NULL),
(9, 2, 7, NULL, NULL),
(10, 2, 9, NULL, NULL),
(11, 2, 10, NULL, NULL),
(12, 2, 14, NULL, NULL),
(13, 3, 4, NULL, NULL),
(14, 3, 9, NULL, NULL),
(15, 3, 10, NULL, NULL),
(16, 4, 1, NULL, NULL),
(17, 4, 9, NULL, NULL),
(18, 4, 11, NULL, NULL),
(19, 4, 15, NULL, NULL),
(20, 5, 1, NULL, NULL),
(21, 5, 8, NULL, NULL),
(22, 5, 14, NULL, NULL),
(23, 5, 15, NULL, NULL),
(24, 6, 1, NULL, NULL),
(25, 6, 3, NULL, NULL),
(26, 6, 9, NULL, NULL),
(27, 6, 13, NULL, NULL),
(28, 7, 2, NULL, NULL),
(29, 7, 3, NULL, NULL),
(30, 7, 4, NULL, NULL),
(31, 7, 5, NULL, NULL),
(32, 7, 6, NULL, NULL),
(33, 7, 7, NULL, NULL),
(34, 7, 12, NULL, NULL),
(35, 8, 5, NULL, NULL),
(36, 8, 6, NULL, NULL),
(37, 8, 10, NULL, NULL),
(38, 9, 1, NULL, NULL),
(39, 9, 3, NULL, NULL),
(40, 9, 9, NULL, NULL),
(41, 9, 10, NULL, NULL),
(42, 9, 11, NULL, NULL),
(43, 9, 12, NULL, NULL),
(44, 10, 1, NULL, NULL),
(45, 10, 7, NULL, NULL),
(46, 10, 8, NULL, NULL),
(47, 10, 9, NULL, NULL),
(48, 10, 11, NULL, NULL),
(49, 10, 12, NULL, NULL),
(50, 10, 13, NULL, NULL),
(51, 11, 7, NULL, NULL),
(52, 11, 11, NULL, NULL),
(53, 11, 13, NULL, NULL),
(54, 12, 1, NULL, NULL),
(55, 12, 4, NULL, NULL),
(56, 12, 5, NULL, NULL),
(57, 12, 7, NULL, NULL),
(58, 12, 9, NULL, NULL),
(59, 12, 11, NULL, NULL),
(60, 13, 2, NULL, NULL),
(61, 13, 3, NULL, NULL),
(62, 13, 4, NULL, NULL),
(63, 13, 5, NULL, NULL),
(64, 13, 8, NULL, NULL),
(65, 13, 15, NULL, NULL),
(66, 14, 6, NULL, NULL),
(67, 14, 14, NULL, NULL),
(68, 14, 15, NULL, NULL),
(69, 15, 1, NULL, NULL),
(70, 15, 5, NULL, NULL),
(71, 15, 7, NULL, NULL),
(72, 15, 8, NULL, NULL),
(73, 15, 10, NULL, NULL),
(74, 15, 14, NULL, NULL),
(75, 16, 1, NULL, NULL),
(76, 16, 4, NULL, NULL),
(77, 16, 10, NULL, NULL),
(78, 16, 11, NULL, NULL),
(79, 17, 2, NULL, NULL),
(80, 17, 3, NULL, NULL),
(81, 17, 4, NULL, NULL),
(82, 17, 7, NULL, NULL),
(83, 18, 8, NULL, NULL),
(84, 18, 12, NULL, NULL),
(85, 18, 13, NULL, NULL),
(86, 19, 3, NULL, NULL),
(87, 19, 5, NULL, NULL),
(88, 19, 6, NULL, NULL),
(89, 19, 10, NULL, NULL),
(90, 19, 11, NULL, NULL),
(91, 19, 12, NULL, NULL),
(92, 19, 14, NULL, NULL),
(93, 20, 2, NULL, NULL),
(94, 20, 5, NULL, NULL),
(95, 20, 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggans`
--

CREATE TABLE `pelanggans` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `membership_id` bigint UNSIGNED DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelanggans`
--

INSERT INTO `pelanggans` (`id`, `user_id`, `membership_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'active', '2026-07-07 20:44:59', '2026-07-07 20:51:57', '2026-07-07 20:51:57'),
(2, 2, 2, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(3, 3, 3, 'active', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(4, 3, 1, 'active', '2026-07-07 20:51:38', '2026-07-07 20:51:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'auth_token', '49216e1cc085e50cdf6dc38c57fe2a466c943b74c60360bb855cd4cdc250273b', '[\"*\"]', '2026-07-07 21:22:46', NULL, '2026-07-07 20:50:22', '2026-07-07 21:22:46'),
(2, 'App\\Models\\User', 1, 'auth_token', '354ee2200ca23412c65741d85267ac124e20c282f16a6347040471906c69b4c3', '[\"*\"]', NULL, NULL, '2026-07-11 01:36:03', '2026-07-11 01:36:03'),
(3, 'App\\Models\\User', 4, 'auth_token', 'b1ca4a0155b7c2cafa2c984e84bc2eaaea98c081765d578805581fda79fd2bfe', '[\"*\"]', '2026-07-11 01:36:52', NULL, '2026-07-11 01:36:41', '2026-07-11 01:36:52'),
(4, 'App\\Models\\User', 1, 'auth_token', '04439e3d4e9009055d6106dcc71dc7706240b2f7014fe21890bed7884740f737', '[\"*\"]', NULL, NULL, '2026-07-11 01:51:13', '2026-07-11 01:51:13');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Regular',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Room Regular 1', 'Regular', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(2, 'Room Regular 2', 'Regular', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL),
(3, 'Room VIP 1', 'VIP', '2026-07-07 20:44:59', '2026-07-07 20:44:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `session_games`
--

CREATE TABLE `session_games` (
  `id` bigint UNSIGNED NOT NULL,
  `gaming_session_id` bigint UNSIGNED NOT NULL,
  `game_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `session_games`
--

INSERT INTO `session_games` (`id`, `gaming_session_id`, `game_id`, `created_at`, `updated_at`) VALUES
(1, 1, 5, NULL, NULL),
(2, 1, 11, NULL, NULL),
(3, 2, 2, NULL, NULL),
(4, 2, 14, NULL, NULL),
(5, 2, 15, NULL, NULL),
(6, 3, 4, NULL, NULL),
(7, 3, 12, NULL, NULL),
(8, 3, 13, NULL, NULL),
(9, 4, 10, NULL, NULL),
(10, 4, 14, NULL, NULL),
(11, 5, 4, NULL, NULL),
(12, 5, 6, NULL, NULL),
(13, 5, 10, NULL, NULL),
(14, 6, 11, NULL, NULL),
(15, 7, 3, NULL, NULL),
(16, 7, 4, NULL, NULL),
(17, 8, 1, NULL, NULL),
(18, 8, 9, NULL, NULL),
(19, 8, 10, NULL, NULL),
(20, 9, 3, NULL, NULL),
(21, 9, 6, NULL, NULL),
(22, 10, 1, NULL, NULL),
(23, 10, 12, NULL, NULL),
(24, 10, 14, NULL, NULL),
(25, 11, 2, NULL, NULL),
(26, 11, 3, NULL, NULL),
(27, 11, 6, NULL, NULL),
(28, 12, 4, NULL, NULL),
(29, 12, 8, NULL, NULL),
(30, 13, 14, NULL, NULL),
(31, 13, 15, NULL, NULL),
(32, 14, 2, NULL, NULL),
(33, 14, 4, NULL, NULL),
(34, 14, 6, NULL, NULL),
(35, 15, 10, NULL, NULL),
(36, 16, 1, NULL, NULL),
(37, 17, 8, NULL, NULL),
(38, 17, 12, NULL, NULL),
(39, 17, 13, NULL, NULL),
(40, 18, 3, NULL, NULL),
(41, 18, 13, NULL, NULL),
(42, 19, 1, NULL, NULL),
(43, 20, 5, NULL, NULL),
(44, 20, 8, NULL, NULL),
(45, 20, 10, NULL, NULL),
(46, 21, 2, NULL, NULL),
(47, 21, 6, NULL, NULL),
(48, 21, 14, NULL, NULL),
(49, 22, 2, NULL, NULL),
(50, 22, 14, NULL, NULL),
(51, 23, 2, NULL, NULL),
(52, 23, 6, NULL, NULL),
(53, 23, 15, NULL, NULL),
(54, 24, 10, NULL, NULL),
(55, 25, 4, NULL, NULL),
(56, 25, 10, NULL, NULL),
(57, 26, 2, NULL, NULL),
(58, 26, 6, NULL, NULL),
(59, 26, 9, NULL, NULL),
(60, 27, 5, NULL, NULL),
(61, 28, 15, NULL, NULL),
(62, 29, 6, NULL, NULL),
(63, 29, 11, NULL, NULL),
(64, 30, 3, NULL, NULL),
(65, 30, 8, NULL, NULL),
(66, 30, 12, NULL, NULL),
(67, 31, 12, NULL, NULL),
(68, 31, 14, NULL, NULL),
(69, 32, 5, NULL, NULL),
(70, 32, 15, NULL, NULL),
(71, 33, 1, NULL, NULL),
(72, 33, 7, NULL, NULL),
(73, 34, 1, NULL, NULL),
(74, 34, 4, NULL, NULL),
(75, 34, 9, NULL, NULL),
(76, 35, 5, NULL, NULL),
(77, 35, 6, NULL, NULL),
(78, 35, 8, NULL, NULL),
(79, 36, 13, NULL, NULL),
(80, 36, 14, NULL, NULL),
(81, 37, 3, NULL, NULL),
(82, 37, 5, NULL, NULL),
(83, 38, 1, NULL, NULL),
(84, 38, 2, NULL, NULL),
(85, 38, 3, NULL, NULL),
(86, 39, 12, NULL, NULL),
(87, 40, 2, NULL, NULL),
(88, 40, 13, NULL, NULL),
(89, 41, 4, NULL, NULL),
(90, 41, 6, NULL, NULL),
(91, 42, 7, NULL, NULL),
(92, 43, 5, NULL, NULL),
(93, 44, 3, NULL, NULL),
(94, 44, 14, NULL, NULL),
(95, 45, 11, NULL, NULL),
(96, 45, 14, NULL, NULL),
(97, 46, 14, NULL, NULL),
(98, 47, 2, NULL, NULL),
(99, 47, 4, NULL, NULL),
(100, 47, 6, NULL, NULL),
(101, 48, 15, NULL, NULL),
(102, 49, 1, NULL, NULL),
(103, 49, 11, NULL, NULL),
(104, 50, 5, NULL, NULL),
(105, 50, 12, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','operator','pelanggan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pelanggan',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@warnet.com', 'admin', NULL, '$2y$12$fQ/5Tu785gt1e8guWIUMI.0sE.hvTgbrD0Y/TJw7W0lF.a1R4v/Xy', NULL, '2026-07-07 20:44:58', '2026-07-07 20:44:58'),
(2, 'Operator Penjaga', 'operator@warnet.com', 'operator', NULL, '$2y$12$0eZkeCyy8A1ihdELUk.cK.m.EEayLsO4uXhPsIeo5xggVHPwlOaw.', NULL, '2026-07-07 20:44:58', '2026-07-07 20:44:58'),
(3, 'Pelanggan Setia', 'pelanggan@warnet.com', 'pelanggan', NULL, '$2y$12$JepQkEf5RMUvy3AAhUbLtOqL3qgOnfFijpBN7jVguj/mZ5jUS8ITq', NULL, '2026-07-07 20:44:59', '2026-07-07 20:44:59'),
(4, 'Budi Santoso', 'budi@warnet.com', 'pelanggan', NULL, '$2y$12$cTgDhnCyI5taQyjz.DfTQeT6HjmzgGbvlvPGcGWpz8gqGB5eJ.FaS', NULL, '2026-07-11 01:36:41', '2026-07-11 01:36:41');

-- --------------------------------------------------------

--
-- Table structure for table `user_games`
--

CREATE TABLE `user_games` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `game_id` bigint UNSIGNED NOT NULL,
  `play_time_minutes` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_games`
--

INSERT INTO `user_games` (`id`, `user_id`, `game_id`, `play_time_minutes`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 14280, NULL, NULL),
(2, 1, 6, 10080, NULL, NULL),
(3, 1, 7, 12720, NULL, NULL),
(4, 1, 8, 13920, NULL, NULL),
(5, 1, 10, 11580, NULL, NULL),
(6, 1, 11, 12060, NULL, NULL),
(7, 1, 12, 14340, NULL, NULL),
(8, 1, 13, 13380, NULL, NULL),
(9, 1, 15, 6300, NULL, NULL),
(10, 2, 7, 7740, NULL, NULL),
(11, 2, 10, 7200, NULL, NULL),
(12, 2, 11, 10440, NULL, NULL),
(13, 2, 15, 7800, NULL, NULL),
(14, 3, 2, 10080, NULL, NULL),
(15, 3, 3, 10260, NULL, NULL),
(16, 3, 4, 14640, NULL, NULL),
(17, 3, 6, 7080, NULL, NULL),
(18, 3, 8, 6900, NULL, NULL),
(19, 3, 10, 7080, NULL, NULL),
(20, 3, 11, 7740, NULL, NULL),
(21, 3, 12, 5400, NULL, NULL),
(22, 3, 13, 11520, NULL, NULL),
(23, 3, 14, 3180, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `food_beverages`
--
ALTER TABLE `food_beverages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `food_beverages_name_index` (`name`);

--
-- Indexes for table `food_orders`
--
ALTER TABLE `food_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `food_orders_gaming_session_id_foreign` (`gaming_session_id`),
  ADD KEY `food_orders_pelanggan_id_foreign` (`pelanggan_id`),
  ADD KEY `food_orders_operator_id_foreign` (`operator_id`),
  ADD KEY `food_orders_status_index` (`status`);

--
-- Indexes for table `food_order_items`
--
ALTER TABLE `food_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `food_order_items_food_order_id_foreign` (`food_order_id`),
  ADD KEY `food_order_items_food_beverage_id_foreign` (`food_beverage_id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `games_name_unique` (`name`);

--
-- Indexes for table `gaming_sessions`
--
ALTER TABLE `gaming_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gaming_sessions_pelanggan_id_foreign` (`pelanggan_id`),
  ADD KEY `gaming_sessions_operator_id_foreign` (`operator_id`),
  ADD KEY `gaming_sessions_pc_id_foreign` (`pc_id`),
  ADD KEY `gaming_sessions_room_id_foreign` (`room_id`),
  ADD KEY `idx_gaming_sessions_status` (`status`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `memberships_level_unique` (`level`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operators`
--
ALTER TABLE `operators`
  ADD PRIMARY KEY (`id`),
  ADD KEY `operators_user_id_foreign` (`user_id`),
  ADD KEY `operators_room_id_foreign` (`room_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_gaming_session_id_foreign` (`gaming_session_id`);

--
-- Indexes for table `pcs`
--
ALTER TABLE `pcs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pcs_code_unique` (`code`),
  ADD KEY `pcs_room_id_foreign` (`room_id`),
  ADD KEY `idx_pcs_status` (`status`);

--
-- Indexes for table `pc_games`
--
ALTER TABLE `pc_games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pc_games_pc_id_foreign` (`pc_id`),
  ADD KEY `pc_games_game_id_foreign` (`game_id`);

--
-- Indexes for table `pelanggans`
--
ALTER TABLE `pelanggans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggans_user_id_foreign` (`user_id`),
  ADD KEY `pelanggans_membership_id_foreign` (`membership_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `session_games`
--
ALTER TABLE `session_games`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session_games_unique_session_game` (`gaming_session_id`,`game_id`),
  ADD KEY `session_games_game_id_foreign` (`game_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_games`
--
ALTER TABLE `user_games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_games_user_id_foreign` (`user_id`),
  ADD KEY `user_games_game_id_foreign` (`game_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `food_beverages`
--
ALTER TABLE `food_beverages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `food_orders`
--
ALTER TABLE `food_orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `food_order_items`
--
ALTER TABLE `food_order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `gaming_sessions`
--
ALTER TABLE `gaming_sessions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `operators`
--
ALTER TABLE `operators`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `pcs`
--
ALTER TABLE `pcs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pc_games`
--
ALTER TABLE `pc_games`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `pelanggans`
--
ALTER TABLE `pelanggans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `session_games`
--
ALTER TABLE `session_games`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_games`
--
ALTER TABLE `user_games`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `food_orders`
--
ALTER TABLE `food_orders`
  ADD CONSTRAINT `food_orders_gaming_session_id_foreign` FOREIGN KEY (`gaming_session_id`) REFERENCES `gaming_sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `food_orders_operator_id_foreign` FOREIGN KEY (`operator_id`) REFERENCES `operators` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `food_orders_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `food_order_items`
--
ALTER TABLE `food_order_items`
  ADD CONSTRAINT `food_order_items_food_beverage_id_foreign` FOREIGN KEY (`food_beverage_id`) REFERENCES `food_beverages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `food_order_items_food_order_id_foreign` FOREIGN KEY (`food_order_id`) REFERENCES `food_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gaming_sessions`
--
ALTER TABLE `gaming_sessions`
  ADD CONSTRAINT `gaming_sessions_operator_id_foreign` FOREIGN KEY (`operator_id`) REFERENCES `operators` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gaming_sessions_pc_id_foreign` FOREIGN KEY (`pc_id`) REFERENCES `pcs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gaming_sessions_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gaming_sessions_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `operators`
--
ALTER TABLE `operators`
  ADD CONSTRAINT `operators_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `operators_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_gaming_session_id_foreign` FOREIGN KEY (`gaming_session_id`) REFERENCES `gaming_sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pcs`
--
ALTER TABLE `pcs`
  ADD CONSTRAINT `pcs_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pc_games`
--
ALTER TABLE `pc_games`
  ADD CONSTRAINT `pc_games_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pc_games_pc_id_foreign` FOREIGN KEY (`pc_id`) REFERENCES `pcs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pelanggans`
--
ALTER TABLE `pelanggans`
  ADD CONSTRAINT `pelanggans_membership_id_foreign` FOREIGN KEY (`membership_id`) REFERENCES `memberships` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pelanggans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `session_games`
--
ALTER TABLE `session_games`
  ADD CONSTRAINT `session_games_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `session_games_gaming_session_id_foreign` FOREIGN KEY (`gaming_session_id`) REFERENCES `gaming_sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_games`
--
ALTER TABLE `user_games`
  ADD CONSTRAINT `user_games_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_games_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
