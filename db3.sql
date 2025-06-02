-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for mohsencommerce
CREATE DATABASE IF NOT EXISTS `mohsencommerce` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `mohsencommerce`;

-- Dumping structure for table mohsencommerce.attributes
CREATE TABLE IF NOT EXISTS `attributes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `attribute_template_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `options` json DEFAULT NULL,
  `is_filterable` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order` int NOT NULL DEFAULT (0),
  PRIMARY KEY (`id`),
  KEY `attributes_attribute_template_id_foreign` (`attribute_template_id`),
  CONSTRAINT `attributes_attribute_template_id_foreign` FOREIGN KEY (`attribute_template_id`) REFERENCES `attribute_templates` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.attributes: ~18 rows (approximately)
INSERT INTO `attributes` (`id`, `attribute_template_id`, `name`, `slug`, `input_type`, `unit`, `options`, `is_filterable`, `created_at`, `updated_at`, `order`) VALUES
	(36, 3, 'sadasd', 'sadasd', 'text', NULL, '[]', 1, '2025-05-07 13:33:30', '2025-05-07 13:34:39', 1),
	(37, 3, 'asdsad', 'asdsad', 'text', NULL, '[]', 1, '2025-05-07 13:33:30', '2025-05-07 13:34:39', 2),
	(38, 3, 'fsd dsf dsf', 'fsd-dsf-dsf', 'text', NULL, '[]', 1, '2025-05-07 13:33:30', '2025-05-07 13:34:39', 3),
	(41, 3, 'asdsad', 'asdsad', 'text', NULL, '[]', 1, '2025-05-07 13:33:33', '2025-05-07 13:34:39', 4),
	(42, 3, 'sadasdsad sad sadsa d', 'sadasd', 'text', NULL, '[]', 1, '2025-05-07 13:34:32', '2025-05-07 13:34:46', 0),
	(43, 6, 'شسی', 'شسی', 'text', NULL, '[]', 1, '2025-05-07 13:35:00', '2025-05-07 13:45:31', 1),
	(45, 6, 'یبیسی', 'یبیسی', 'text', NULL, '[]', 1, '2025-05-07 13:35:15', '2025-05-07 13:45:31', 0),
	(46, 6, 'لبلبی', 'لبلبی', 'text', NULL, '[]', 1, '2025-05-07 13:35:40', '2025-05-07 13:45:31', 2),
	(95, 13, 'sadasd', 'sadasd', 'text', NULL, '[]', 1, '2025-05-07 14:10:18', '2025-05-07 14:10:55', 1),
	(96, 13, 'fghgfh', 'fghgfh', 'text', NULL, '[]', 1, '2025-05-07 14:10:34', '2025-05-07 14:10:55', 2),
	(97, 13, 'fdgfd', 'fdgfd', 'select', NULL, '{"name": "قرمز", "value": "سبز"}', 1, '2025-05-07 14:10:44', '2025-05-07 14:10:55', 0),
	(122, 18, 's', 's', 'text', NULL, '[]', 1, '2025-05-07 14:14:52', '2025-05-07 14:15:23', 1),
	(123, 18, 'fdf', 'fdf', 'text', NULL, '[]', 1, '2025-05-07 14:15:04', '2025-05-07 14:15:23', 2),
	(124, 18, 'ghgh', 'ghgh', 'text', NULL, '[]', 1, '2025-05-07 14:15:07', '2025-05-07 14:15:23', 0),
	(125, 19, 'رنگ', 'رنگ', 'select', NULL, '["سبز", "یشمی", "قرمز"]', 1, '2025-05-10 14:09:46', '2025-05-10 14:10:05', 0),
	(126, 19, 'اندازه', 'اندازه', 'text', 'سانتی متر', '[]', 1, '2025-05-10 14:10:14', '2025-05-10 14:25:43', 1),
	(127, 19, 'جنس', 'جنس', 'text', NULL, '[]', 1, '2025-05-10 14:10:24', '2025-05-10 14:10:24', 2),
	(128, 19, 'کیفیت', 'کیفیت', 'text', NULL, '[]', 1, '2025-05-10 14:10:30', '2025-05-10 14:10:30', 3);

-- Dumping structure for table mohsencommerce.attribute_templates
CREATE TABLE IF NOT EXISTS `attribute_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.attribute_templates: ~5 rows (approximately)
INSERT INTO `attribute_templates` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(3, 'تلوزیون', NULL, NULL),
	(6, 'شسیی', '2025-05-03 15:12:23', '2025-05-03 15:12:23'),
	(13, 'asdad', '2025-05-07 13:22:37', '2025-05-07 13:22:37'),
	(18, '1', '2025-05-07 14:13:56', '2025-05-07 14:13:56'),
	(19, 'شال', '2025-05-10 14:09:27', '2025-05-10 14:09:27');

-- Dumping structure for table mohsencommerce.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.cache: ~0 rows (approximately)

-- Dumping structure for table mohsencommerce.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.cache_locks: ~0 rows (approximately)

-- Dumping structure for table mohsencommerce.carts
CREATE TABLE IF NOT EXISTS `carts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_user_id_foreign` (`user_id`),
  KEY `carts_product_id_foreign` (`product_id`),
  CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.carts: ~0 rows (approximately)

-- Dumping structure for table mohsencommerce.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `attribute_template_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_attribute_template_id_foreign` (`attribute_template_id`),
  CONSTRAINT `categories_attribute_template_id_foreign` FOREIGN KEY (`attribute_template_id`) REFERENCES `attribute_templates` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.categories: ~21 rows (approximately)
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `parent_id`, `order`, `is_active`, `created_at`, `updated_at`, `attribute_template_id`) VALUES
	(1, 'asdasd', 'asdasd', 'Enim aut similique harum delectus consequatur reiciendis assumenda.', NULL, 0, 2, 1, '2025-03-14 14:57:49', '2025-04-27 15:02:51', 18),
	(2, '2', '2', 'توضیحات', NULL, 0, 4, 1, '2025-03-14 14:57:49', '2025-04-27 15:02:51', 13),
	(3, '3', '3', 'توضیحات', NULL, 0, 1, 1, '2025-03-14 14:57:49', '2025-04-27 15:02:51', 3),
	(4, '1', '1', 'توضیحات', NULL, 0, 3, 1, '2025-03-14 14:57:49', '2025-04-27 15:02:51', 3),
	(5, 'لباس', 'wqeqlbas', 'Autem ut vel consectetur maiores.', NULL, NULL, 1, 1, '2025-03-14 14:57:49', '2025-05-10 14:11:14', 19),
	(6, 'etfghfgh54354', 'sadasd-sad-asd-asd', 'Et nemo aut eligendi aspernatur occaecati et.', NULL, NULL, 11, 1, '2025-03-14 14:57:49', '2025-05-10 14:11:14', 6),
	(7, 'hgjghjghyj', 'hgjghjghyj', NULL, NULL, NULL, 9, 0, '2025-03-14 14:57:49', '2025-05-10 14:11:14', 18),
	(8, 'sdfsdf', 'sdfsdf', 'توضیحات', NULL, 25, 7, 1, '2025-03-14 14:57:49', '2025-05-10 14:11:14', 6),
	(9, 'fdgdfg', 'fdgdfg', 'توضیحات', NULL, 7, 10, 1, '2025-03-14 14:57:49', '2025-05-10 14:11:14', 13),
	(10, 'gfhgfhf', 'gfhgfhf', NULL, NULL, 6, 13, 0, '2025-03-14 14:57:49', '2025-05-10 14:11:14', 18),
	(12, 'asdsadfdgdfg', 'asdsad', NULL, NULL, 6, 12, 0, '2025-03-14 14:57:49', '2025-05-10 14:11:14', 18),
	(22, 'voluptas', 'voluptas', 'Quia molestiae ipsum similique ducimus rerum fugiat.', NULL, 5, 2, 0, '2025-04-24 17:15:33', '2025-04-27 15:39:16', NULL),
	(25, '2321', 'velit', 'Est saepe eum aut.', NULL, NULL, 6, 1, '2025-04-27 15:02:51', '2025-05-10 14:11:14', 18),
	(26, 'fghg', 'fghg', 'Fugit exercitationem occaecati reprehenderit atque sint consectetur modi.', NULL, NULL, 8, 1, '2025-04-24 12:30:15', '2025-05-10 14:11:14', NULL),
	(29, 'محسن علی محمدی', '546fh-gfhtrh', 'dsfdsf', NULL, 5, 4, 1, '2025-04-24 14:19:33', '2025-04-29 13:14:45', NULL),
	(30, 'pllsad', 'pllsad', 'توضیحات', NULL, NULL, 0, 1, '2025-04-27 15:26:14', '2025-04-28 13:17:50', 13),
	(31, 'شسشسی', 'shsshsy', 'توضیحات', NULL, 22, 3, 1, '2025-04-29 13:14:44', '2025-04-29 13:14:44', NULL),
	(32, 'شال', 'شال', 'توضیحات', NULL, 5, 5, 1, '2025-05-10 14:11:14', '2025-05-10 14:11:14', 19),
	(46, '1', '1', 'توضیحات', NULL, 1, 4, 1, '2025-04-27 14:59:22', '2025-04-27 14:59:30', NULL),
	(47, '2', '2', 'توضیحات', NULL, 1, 2, 1, '2025-04-27 14:59:23', '2025-04-27 14:59:30', NULL),
	(48, '3', '3', 'توضیحات', NULL, 1, 3, 1, '2025-04-27 14:59:23', '2025-04-27 14:59:30', NULL);

-- Dumping structure for table mohsencommerce.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table mohsencommerce.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.jobs: ~0 rows (approximately)

-- Dumping structure for table mohsencommerce.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.job_batches: ~0 rows (approximately)

-- Dumping structure for table mohsencommerce.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.migrations: ~33 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_01_24_131116_create_categories_table', 1),
	(5, '2025_01_24_155733_create_products_table', 1),
	(6, '2025_01_25_145108_create_orders_table', 1),
	(7, '2025_01_25_145122_create_order_items_table', 1),
	(8, '2025_01_27_181138_create_personal_access_tokens_table', 1),
	(9, '2025_03_12_135935_create_post_categories_table', 1),
	(10, '2025_03_12_155536_create_posts_table', 1),
	(11, '2025_03_12_155552_create_post_tags_table', 1),
	(12, '2025_03_12_155647_create_post_post_tags_table', 1),
	(13, '2025_03_12_155828_create_post_comments_table', 1),
	(14, '2025_03_14_100542_create_post_likes_table', 1),
	(15, '2025_03_14_100919_create_post_medias_table', 1),
	(16, '2025_03_14_103625_add_views_count_to_posts_table', 1),
	(17, '2025_03_14_103653_add_views_count_to_products_table', 1),
	(18, '2025_03_14_183246_create_post_bigbanners_table', 2),
	(19, '2025_03_15_200149_add_extension_to_post_medias_table', 3),
	(20, '2025_03_19_123008_add_alt_to_post_medias_table', 4),
	(23, '2025_03_19_132756_add_icon_to_post_categories_table', 5),
	(24, '2025_03_19_143905_add_comments_count_to_posts_table', 5),
	(25, '2025_03_24_163054_create_carts_table', 6),
	(26, '2025_03_25_101839_add_slug_to_post_categories_table', 7),
	(27, '2025_03_26_100617_add_foreign_keys_to_carts_table', 8),
	(28, '2025_04_11_133001_change_address_column_type_in_users_table', 9),
	(29, '2025_04_11_133622_change_address_column_type_to_json_in_users_table', 9),
	(30, '2025_05_03_175315_create_attribute_templates_table', 10),
	(31, '2025_05_03_175324_create_attributes_table', 10),
	(32, '2025_05_03_175342_add_attribute_template_id_to_categories_table', 10),
	(33, '2025_05_03_175347_add_attributes_to_products_table', 10),
	(34, '2025_05_03_175843_add_unit_to_attributes_table', 11),
	(35, '2025_05_03_185715_add_order_to_attributes_table', 12);

-- Dumping structure for table mohsencommerce.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `status` enum('معلق','در حال پردازش','ارسال شده','تحویل داده شده','کنسل') COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_method` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tracking_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `totalDiscount` decimal(15,2) DEFAULT NULL,
  `total` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.orders: ~1 rows (approximately)
INSERT INTO `orders` (`id`, `user_id`, `status`, `address`, `shipping_method`, `tracking_number`, `coupon_code`, `totalDiscount`, `total`, `created_at`, `updated_at`) VALUES
	(1, 1, 'در حال پردازش', '4979 Purdy Spurs Suite 474\nNorth Antonioborough, PA 49314-9773', 'Express', 'corrupti', 'aut', 34.00, 92.66, '2025-03-14 14:57:50', '2025-03-14 14:57:50');

-- Dumping structure for table mohsencommerce.order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` decimal(5,2) NOT NULL,
  `discount` decimal(5,2) DEFAULT '0.00',
  `price` decimal(8,2) NOT NULL,
  `totalPrice` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.order_items: ~1 rows (approximately)
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `discount`, `price`, `totalPrice`, `created_at`, `updated_at`) VALUES
	(1, 1, 36, 2.00, 0.00, 5147.00, 10000.00, NULL, NULL);

-- Dumping structure for table mohsencommerce.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table mohsencommerce.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table mohsencommerce.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `post_category_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `views_count` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `comments_count` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  KEY `posts_user_id_foreign` (`user_id`),
  KEY `posts_post_category_id_foreign` (`post_category_id`),
  CONSTRAINT `posts_post_category_id_foreign` FOREIGN KEY (`post_category_id`) REFERENCES `post_categories` (`id`),
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.posts: ~12 rows (approximately)
INSERT INTO `posts` (`id`, `user_id`, `post_category_id`, `title`, `content`, `slug`, `is_published`, `views_count`, `created_at`, `updated_at`, `comments_count`) VALUES
	(1, 9, 9, 'چه گوشتی برای دیابت خوب است و الویت با کدام گوشت ها است؟', '<div><p >ما با توجه به معیارهای بالا، ۹ ماسک مو \r\nرا که مثبت‌ترین نظرات را در سایت‌های فروش آنلاین از جمله دیجی‌کالا \r\nداشته‌اند، انتخاب کرده‌ایم.&nbsp; و در ادامه به ترتیب از بهترین که شماره یک \r\nاست را برایتان نقد و بررسی کردیم.&nbsp;</p><h2 class="wp-block-heading">۱- ماسک موی ترمیم‌کننده شون مدل Ginseng And Keratin</h2><figure class="wp-block-image"><img decoding="async" src="https://www.daraje.com/wp-content/uploads/2020/11/ماسک-مو-شون.jpg" alt="ماسک موی ترمیم کننده شون مدل Ginseng And Keratin حجم 300 میلی لیتر" class="wp-image-30753"></figure><p>ماسک موی جنسینگ و کراتین شون، ماسکی مناسب موهای خشک، رنگ‌شده و \r\nآسیب‌دیده است. این ماسک مو با داشتن عصاره ریشه جنسینگ، روغن جوجوبا و \r\nکراتین هیدرولیز شده علاوه بر تغذیه عمقی مو یک لایه پروتئینی محافظ هم \r\nبرای ترمیم ساختار سطح مو و جلوگیری از تخریب و شکنندگی مو ایجاد می‌کند و \r\nدر نهایت به از بین بردن گره‌های مو و تنظیم PH مو هم کمک می‌کند.</p><p>این ماسک مو باید بعد از شستشوی مو با شامپو، در حالی که موها هنوز خیس\r\n هستند، به مدت پنج دقیقه روی ساقه مو بماند و سپس آبکشی شود. از آنجایی که\r\n این ماسک حاوی جنسینگ است می‌تواند در مقابله با ریزش مو هم موثر باشد و \r\nپوست سر را از خشکی نجات دهد.</p><p>ماسک شون از ایجاد الکتریسیته ساکن هم جلوگیری می‌کند. این ماسک بنابر \r\nنظرات مصرف‌کنندگان در سایت‌ دیجی‌کالا و اینستاگرام برند شون، از آن دسته \r\nمحصولاتی است که بسیار مقبول بوده و نظرات مثبت نسبت به آن بیش از نظرات \r\nمنفی است بنابراین شاید اگر این ماسک را یکی از بهترین ماسک موهای ایرانی \r\nبنامیم، دور از ذهن نباشد.</p><p>حجم: ۳۰۰ میلی‌لیتر</p><p>ویتامین: ندارد</p><p>نوع عصاره: جنسینگ و کراتین</p><h3 class="wp-block-heading"><strong>مصرف‌کنندگان چه می‌گویند؟</strong></h3><p>تجربه اکثر مصرف‌کنندگان این محصول نشان می‌دهد که ماسک ایرانی، موهای \r\nخشک آنها را نرم کرده و شانه زدن موها بعد حمام را خیلی راحت می‌کند و \r\nگره‌های موها را به خوبی از هم باز می‌کند.&nbsp;</p><p>ماسک موی شون با حجم ۳۰۰ لیتری و در ظرفی کاسه‌ای عرضه می‌شود که اکثر خانم‌ها ارزش خرید آن را به نسبت قیمتش مناسب می‌دانند.لینک خرید این ماسک مو از دیجی‌کالا</p><p>یکی از نکات منفی که در خصوص این محصول گاهی بیان شده بوی آن است. \r\nعده‌ای از خانم‌ها بوی این محصول را مناسب نمی‌دانند هر چند می‌توان گفت \r\nبوی محصول تا حدودی به سلیقه شخصی بستگی دارد.</p><p>نکته منفی دیگری که برخی از خانم‌ها در \r\nخصوص این ماسک مو بیان کرده‌اند این است که این محصول تاثیری در رفع وزی \r\nموی آنها نداشته است. بنابراین اگر به دنبال رفع وزی موی خود هستید محصولات\r\n دیگر را امتحان کنید</p><h2 class="wp-block-heading">۲- ماسک مو کامان مدل Amino Min Biotin + zinc</h2><h3 class="wp-block-heading"></h3><p>ماسک و نرم‌کننده موی بیوتین و آبرسان داخل حمام کامان حاوی زینک و \r\nویتامین‌های دیگری است که از نازک و شکننده شدن موها پیشگیری می‌کند و \r\nمقاومت آنها را در برابر استفاده از سشوار، اتوی مو و موخوره بالا می‌برد.</p><p>این ماسک برای افرادی که به دنبال ماسک مویی با حجم بالا و قیمت مناسب \r\nهستند، خوب است. ماسک موی بیوتین کامان مناسب موهای خشک، رنگ شده و موی \r\nعادی است. از جمله ویژگی‌های اصلی آن طبق آنچه در مشخصات این محصول قید شده\r\n می‌توان به مغذی بودن، درخشان‌کنندگی و تقویت‌کنندگی آن اشاره کرد.</p>          </div>', 'چه-گوشتی-برای-دیابت-خوب-است', 1, 0, '2025-03-15 20:26:25', NULL, 0),
	(4, 3, 6, 'چه گوشتی برای دیابت خوب است و الویت با کدام گوشت ها است؟4', 'هر بیمار دیابتی این سوال برایش پیش می آید که چه گوشتی برای دیابت خوب است؟ گوشت کم چرب و جایگزین های گوشت بهترین گزینه برای افراد مبتلا به دیابت هستند. گوشت های پر چرب و فرآوری شده حاوی چربی های ناسالمی هستند که می توانند کلسترون خون و خطر ابتلا به بیماری دیابت را افزایش دهند. در این مقاله در این مورد با شما صحبت خواهیم کرد که از کدام نوع گوشت برای رژیم دیابتی استفاده کنید و از کدام نوع گوشت استفاده نکنید. همچنین شما را با جایگزین های مناسب برای گوشت آشنا خواهیم کرد.', 'تست-2', 1, 508, '2025-03-18 20:26:26', '2025-03-24 12:26:47', 0),
	(5, 6, 10, 'تستسشینم نشستی شنیتسمشسی', 'شسی شسنیتش متیشهسیت شتیخهشیتشهسی', 'تست_4', 0, 0, '2024-03-18 19:26:27', NULL, 0),
	(6, 6, 2, 'تستسشینم نشستی شنیتسمشسی', 'شسی شسنیتش متیشهسیت شتیخهشیتشهسی', '5', 1, 1, '2023-03-18 19:26:27', '2025-03-24 12:27:34', 0),
	(7, 6, 3, 'تستسشینم نشستی شنیتسمشسی', 'شسی شسنیتش متیشهسیت شتیخهشیتشهسی', '8', 1, 1, '2025-03-18 13:26:28', '2025-03-24 12:27:37', 0),
	(8, 7, 6, 'بهترین ماسک موهای ایرانی؛ مصرف‌کنندگان چه برندهایی را بیشتر پسندیده‌اند؟', '<p>lorem ipsum</p>', 'بهترین_ماسک_موهای_ایرانی', 0, 246, '2020-03-19 15:06:32', '2025-03-24 12:27:27', 0),
	(11, 9, 9, 'چه گوشتی برای دیابت خوب است و الویت با کدام گوشت ها است؟', '<div><p >ما با توجه به معیارهای بالا، ۹ ماسک مو \r\nرا که مثبت‌ترین نظرات را در سایت‌های فروش آنلاین از جمله دیجی‌کالا \r\nداشته‌اند، انتخاب کرده‌ایم.&nbsp; و در ادامه به ترتیب از بهترین که شماره یک \r\nاست را برایتان نقد و بررسی کردیم.&nbsp;</p><h2 class="wp-block-heading">۱- ماسک موی ترمیم‌کننده شون مدل Ginseng And Keratin</h2><figure class="wp-block-image"><img decoding="async" src="https://www.daraje.com/wp-content/uploads/2020/11/ماسک-مو-شون.jpg" alt="ماسک موی ترمیم کننده شون مدل Ginseng And Keratin حجم 300 میلی لیتر" class="wp-image-30753"></figure><p>ماسک موی جنسینگ و کراتین شون، ماسکی مناسب موهای خشک، رنگ‌شده و \r\nآسیب‌دیده است. این ماسک مو با داشتن عصاره ریشه جنسینگ، روغن جوجوبا و \r\nکراتین هیدرولیز شده علاوه بر تغذیه عمقی مو یک لایه پروتئینی محافظ هم \r\nبرای ترمیم ساختار سطح مو و جلوگیری از تخریب و شکنندگی مو ایجاد می‌کند و \r\nدر نهایت به از بین بردن گره‌های مو و تنظیم PH مو هم کمک می‌کند.</p><p>این ماسک مو باید بعد از شستشوی مو با شامپو، در حالی که موها هنوز خیس\r\n هستند، به مدت پنج دقیقه روی ساقه مو بماند و سپس آبکشی شود. از آنجایی که\r\n این ماسک حاوی جنسینگ است می‌تواند در مقابله با ریزش مو هم موثر باشد و \r\nپوست سر را از خشکی نجات دهد.</p><p>ماسک شون از ایجاد الکتریسیته ساکن هم جلوگیری می‌کند. این ماسک بنابر \r\nنظرات مصرف‌کنندگان در سایت‌ دیجی‌کالا و اینستاگرام برند شون، از آن دسته \r\nمحصولاتی است که بسیار مقبول بوده و نظرات مثبت نسبت به آن بیش از نظرات \r\nمنفی است بنابراین شاید اگر این ماسک را یکی از بهترین ماسک موهای ایرانی \r\nبنامیم، دور از ذهن نباشد.</p><p>حجم: ۳۰۰ میلی‌لیتر</p><p>ویتامین: ندارد</p><p>نوع عصاره: جنسینگ و کراتین</p><h3 class="wp-block-heading"><strong>مصرف‌کنندگان چه می‌گویند؟</strong></h3><p>تجربه اکثر مصرف‌کنندگان این محصول نشان می‌دهد که ماسک ایرانی، موهای \r\nخشک آنها را نرم کرده و شانه زدن موها بعد حمام را خیلی راحت می‌کند و \r\nگره‌های موها را به خوبی از هم باز می‌کند.&nbsp;</p><p>ماسک موی شون با حجم ۳۰۰ لیتری و در ظرفی کاسه‌ای عرضه می‌شود که اکثر خانم‌ها ارزش خرید آن را به نسبت قیمتش مناسب می‌دانند.لینک خرید این ماسک مو از دیجی‌کالا</p><p>یکی از نکات منفی که در خصوص این محصول گاهی بیان شده بوی آن است. \r\nعده‌ای از خانم‌ها بوی این محصول را مناسب نمی‌دانند هر چند می‌توان گفت \r\nبوی محصول تا حدودی به سلیقه شخصی بستگی دارد.</p><p>نکته منفی دیگری که برخی از خانم‌ها در \r\nخصوص این ماسک مو بیان کرده‌اند این است که این محصول تاثیری در رفع وزی \r\nموی آنها نداشته است. بنابراین اگر به دنبال رفع وزی موی خود هستید محصولات\r\n دیگر را امتحان کنید</p><h2 class="wp-block-heading">۲- ماسک مو کامان مدل Amino Min Biotin + zinc</h2><h3 class="wp-block-heading"></h3><p>ماسک و نرم‌کننده موی بیوتین و آبرسان داخل حمام کامان حاوی زینک و \r\nویتامین‌های دیگری است که از نازک و شکننده شدن موها پیشگیری می‌کند و \r\nمقاومت آنها را در برابر استفاده از سشوار، اتوی مو و موخوره بالا می‌برد.</p><p>این ماسک برای افرادی که به دنبال ماسک مویی با حجم بالا و قیمت مناسب \r\nهستند، خوب است. ماسک موی بیوتین کامان مناسب موهای خشک، رنگ شده و موی \r\nعادی است. از جمله ویژگی‌های اصلی آن طبق آنچه در مشخصات این محصول قید شده\r\n می‌توان به مغذی بودن، درخشان‌کنندگی و تقویت‌کنندگی آن اشاره کرد.</p>          </div>', 'چه-گوشتی-برای-دیابت-dsdخوب-است', 1, 0, '2025-03-15 20:26:25', NULL, 0),
	(12, 9, 9, 'چه گوشتی برای دیابت خوب است و الویت با کدام گوشت ها است؟', '<div><p >ما با توجه به معیارهای بالا، ۹ ماسک مو \r\nرا که مثبت‌ترین نظرات را در سایت‌های فروش آنلاین از جمله دیجی‌کالا \r\nداشته‌اند، انتخاب کرده‌ایم.&nbsp; و در ادامه به ترتیب از بهترین که شماره یک \r\nاست را برایتان نقد و بررسی کردیم.&nbsp;</p><h2 class="wp-block-heading">۱- ماسک موی ترمیم‌کننده شون مدل Ginseng And Keratin</h2><figure class="wp-block-image"><img decoding="async" src="https://www.daraje.com/wp-content/uploads/2020/11/ماسک-مو-شون.jpg" alt="ماسک موی ترمیم کننده شون مدل Ginseng And Keratin حجم 300 میلی لیتر" class="wp-image-30753"></figure><p>ماسک موی جنسینگ و کراتین شون، ماسکی مناسب موهای خشک، رنگ‌شده و \r\nآسیب‌دیده است. این ماسک مو با داشتن عصاره ریشه جنسینگ، روغن جوجوبا و \r\nکراتین هیدرولیز شده علاوه بر تغذیه عمقی مو یک لایه پروتئینی محافظ هم \r\nبرای ترمیم ساختار سطح مو و جلوگیری از تخریب و شکنندگی مو ایجاد می‌کند و \r\nدر نهایت به از بین بردن گره‌های مو و تنظیم PH مو هم کمک می‌کند.</p><p>این ماسک مو باید بعد از شستشوی مو با شامپو، در حالی که موها هنوز خیس\r\n هستند، به مدت پنج دقیقه روی ساقه مو بماند و سپس آبکشی شود. از آنجایی که\r\n این ماسک حاوی جنسینگ است می‌تواند در مقابله با ریزش مو هم موثر باشد و \r\nپوست سر را از خشکی نجات دهد.</p><p>ماسک شون از ایجاد الکتریسیته ساکن هم جلوگیری می‌کند. این ماسک بنابر \r\nنظرات مصرف‌کنندگان در سایت‌ دیجی‌کالا و اینستاگرام برند شون، از آن دسته \r\nمحصولاتی است که بسیار مقبول بوده و نظرات مثبت نسبت به آن بیش از نظرات \r\nمنفی است بنابراین شاید اگر این ماسک را یکی از بهترین ماسک موهای ایرانی \r\nبنامیم، دور از ذهن نباشد.</p><p>حجم: ۳۰۰ میلی‌لیتر</p><p>ویتامین: ندارد</p><p>نوع عصاره: جنسینگ و کراتین</p><h3 class="wp-block-heading"><strong>مصرف‌کنندگان چه می‌گویند؟</strong></h3><p>تجربه اکثر مصرف‌کنندگان این محصول نشان می‌دهد که ماسک ایرانی، موهای \r\nخشک آنها را نرم کرده و شانه زدن موها بعد حمام را خیلی راحت می‌کند و \r\nگره‌های موها را به خوبی از هم باز می‌کند.&nbsp;</p><p>ماسک موی شون با حجم ۳۰۰ لیتری و در ظرفی کاسه‌ای عرضه می‌شود که اکثر خانم‌ها ارزش خرید آن را به نسبت قیمتش مناسب می‌دانند.لینک خرید این ماسک مو از دیجی‌کالا</p><p>یکی از نکات منفی که در خصوص این محصول گاهی بیان شده بوی آن است. \r\nعده‌ای از خانم‌ها بوی این محصول را مناسب نمی‌دانند هر چند می‌توان گفت \r\nبوی محصول تا حدودی به سلیقه شخصی بستگی دارد.</p><p>نکته منفی دیگری که برخی از خانم‌ها در \r\nخصوص این ماسک مو بیان کرده‌اند این است که این محصول تاثیری در رفع وزی \r\nموی آنها نداشته است. بنابراین اگر به دنبال رفع وزی موی خود هستید محصولات\r\n دیگر را امتحان کنید</p><h2 class="wp-block-heading">۲- ماسک مو کامان مدل Amino Min Biotin + zinc</h2><h3 class="wp-block-heading"></h3><p>ماسک و نرم‌کننده موی بیوتین و آبرسان داخل حمام کامان حاوی زینک و \r\nویتامین‌های دیگری است که از نازک و شکننده شدن موها پیشگیری می‌کند و \r\nمقاومت آنها را در برابر استفاده از سشوار، اتوی مو و موخوره بالا می‌برد.</p><p>این ماسک برای افرادی که به دنبال ماسک مویی با حجم بالا و قیمت مناسب \r\nهستند، خوب است. ماسک موی بیوتین کامان مناسب موهای خشک، رنگ شده و موی \r\nعادی است. از جمله ویژگی‌های اصلی آن طبق آنچه در مشخصات این محصول قید شده\r\n می‌توان به مغذی بودن، درخشان‌کنندگی و تقویت‌کنندگی آن اشاره کرد.</p>          </div>', 'چه-گوشتیuytyu-برای-دیابت-dsdخوب-است', 1, 0, '2025-03-15 20:26:25', NULL, 0),
	(13, 9, 9, 'چه گوشتی برای دیابت خوب است و الویت با کدام گوشت ها است؟', '<div><p >ما با توجه به معیارهای بالا، ۹ ماسک مو \r\nرا که مثبت‌ترین نظرات را در سایت‌های فروش آنلاین از جمله دیجی‌کالا \r\nداشته‌اند، انتخاب کرده‌ایم.&nbsp; و در ادامه به ترتیب از بهترین که شماره یک \r\nاست را برایتان نقد و بررسی کردیم.&nbsp;</p><h2 class="wp-block-heading">۱- ماسک موی ترمیم‌کننده شون مدل Ginseng And Keratin</h2><figure class="wp-block-image"><img decoding="async" src="https://www.daraje.com/wp-content/uploads/2020/11/ماسک-مو-شون.jpg" alt="ماسک موی ترمیم کننده شون مدل Ginseng And Keratin حجم 300 میلی لیتر" class="wp-image-30753"></figure><p>ماسک موی جنسینگ و کراتین شون، ماسکی مناسب موهای خشک، رنگ‌شده و \r\nآسیب‌دیده است. این ماسک مو با داشتن عصاره ریشه جنسینگ، روغن جوجوبا و \r\nکراتین هیدرولیز شده علاوه بر تغذیه عمقی مو یک لایه پروتئینی محافظ هم \r\nبرای ترمیم ساختار سطح مو و جلوگیری از تخریب و شکنندگی مو ایجاد می‌کند و \r\nدر نهایت به از بین بردن گره‌های مو و تنظیم PH مو هم کمک می‌کند.</p><p>این ماسک مو باید بعد از شستشوی مو با شامپو، در حالی که موها هنوز خیس\r\n هستند، به مدت پنج دقیقه روی ساقه مو بماند و سپس آبکشی شود. از آنجایی که\r\n این ماسک حاوی جنسینگ است می‌تواند در مقابله با ریزش مو هم موثر باشد و \r\nپوست سر را از خشکی نجات دهد.</p><p>ماسک شون از ایجاد الکتریسیته ساکن هم جلوگیری می‌کند. این ماسک بنابر \r\nنظرات مصرف‌کنندگان در سایت‌ دیجی‌کالا و اینستاگرام برند شون، از آن دسته \r\nمحصولاتی است که بسیار مقبول بوده و نظرات مثبت نسبت به آن بیش از نظرات \r\nمنفی است بنابراین شاید اگر این ماسک را یکی از بهترین ماسک موهای ایرانی \r\nبنامیم، دور از ذهن نباشد.</p><p>حجم: ۳۰۰ میلی‌لیتر</p><p>ویتامین: ندارد</p><p>نوع عصاره: جنسینگ و کراتین</p><h3 class="wp-block-heading"><strong>مصرف‌کنندگان چه می‌گویند؟</strong></h3><p>تجربه اکثر مصرف‌کنندگان این محصول نشان می‌دهد که ماسک ایرانی، موهای \r\nخشک آنها را نرم کرده و شانه زدن موها بعد حمام را خیلی راحت می‌کند و \r\nگره‌های موها را به خوبی از هم باز می‌کند.&nbsp;</p><p>ماسک موی شون با حجم ۳۰۰ لیتری و در ظرفی کاسه‌ای عرضه می‌شود که اکثر خانم‌ها ارزش خرید آن را به نسبت قیمتش مناسب می‌دانند.لینک خرید این ماسک مو از دیجی‌کالا</p><p>یکی از نکات منفی که در خصوص این محصول گاهی بیان شده بوی آن است. \r\nعده‌ای از خانم‌ها بوی این محصول را مناسب نمی‌دانند هر چند می‌توان گفت \r\nبوی محصول تا حدودی به سلیقه شخصی بستگی دارد.</p><p>نکته منفی دیگری که برخی از خانم‌ها در \r\nخصوص این ماسک مو بیان کرده‌اند این است که این محصول تاثیری در رفع وزی \r\nموی آنها نداشته است. بنابراین اگر به دنبال رفع وزی موی خود هستید محصولات\r\n دیگر را امتحان کنید</p><h2 class="wp-block-heading">۲- ماسک مو کامان مدل Amino Min Biotin + zinc</h2><h3 class="wp-block-heading"></h3><p>ماسک و نرم‌کننده موی بیوتین و آبرسان داخل حمام کامان حاوی زینک و \r\nویتامین‌های دیگری است که از نازک و شکننده شدن موها پیشگیری می‌کند و \r\nمقاومت آنها را در برابر استفاده از سشوار، اتوی مو و موخوره بالا می‌برد.</p><p>این ماسک برای افرادی که به دنبال ماسک مویی با حجم بالا و قیمت مناسب \r\nهستند، خوب است. ماسک موی بیوتین کامان مناسب موهای خشک، رنگ شده و موی \r\nعادی است. از جمله ویژگی‌های اصلی آن طبق آنچه در مشخصات این محصول قید شده\r\n می‌توان به مغذی بودن، درخشان‌کنندگی و تقویت‌کنندگی آن اشاره کرد.</p>          </div>', 'hghfg-gfd-', 1, 0, '2025-03-15 20:26:25', NULL, 0),
	(14, 9, 9, 'چه گوشتی برای دیابت خوب است و الویت با کدام گوشت ها است؟', '<div><p >ما با توجه به معیارهای بالا، ۹ ماسک مو \r\nرا که مثبت‌ترین نظرات را در سایت‌های فروش آنلاین از جمله دیجی‌کالا \r\nداشته‌اند، انتخاب کرده‌ایم.&nbsp; و در ادامه به ترتیب از بهترین که شماره یک \r\nاست را برایتان نقد و بررسی کردیم.&nbsp;</p><h2 class="wp-block-heading">۱- ماسک موی ترمیم‌کننده شون مدل Ginseng And Keratin</h2><figure class="wp-block-image"><img decoding="async" src="https://www.daraje.com/wp-content/uploads/2020/11/ماسک-مو-شون.jpg" alt="ماسک موی ترمیم کننده شون مدل Ginseng And Keratin حجم 300 میلی لیتر" class="wp-image-30753"></figure><p>ماسک موی جنسینگ و کراتین شون، ماسکی مناسب موهای خشک، رنگ‌شده و \r\nآسیب‌دیده است. این ماسک مو با داشتن عصاره ریشه جنسینگ، روغن جوجوبا و \r\nکراتین هیدرولیز شده علاوه بر تغذیه عمقی مو یک لایه پروتئینی محافظ هم \r\nبرای ترمیم ساختار سطح مو و جلوگیری از تخریب و شکنندگی مو ایجاد می‌کند و \r\nدر نهایت به از بین بردن گره‌های مو و تنظیم PH مو هم کمک می‌کند.</p><p>این ماسک مو باید بعد از شستشوی مو با شامپو، در حالی که موها هنوز خیس\r\n هستند، به مدت پنج دقیقه روی ساقه مو بماند و سپس آبکشی شود. از آنجایی که\r\n این ماسک حاوی جنسینگ است می‌تواند در مقابله با ریزش مو هم موثر باشد و \r\nپوست سر را از خشکی نجات دهد.</p><p>ماسک شون از ایجاد الکتریسیته ساکن هم جلوگیری می‌کند. این ماسک بنابر \r\nنظرات مصرف‌کنندگان در سایت‌ دیجی‌کالا و اینستاگرام برند شون، از آن دسته \r\nمحصولاتی است که بسیار مقبول بوده و نظرات مثبت نسبت به آن بیش از نظرات \r\nمنفی است بنابراین شاید اگر این ماسک را یکی از بهترین ماسک موهای ایرانی \r\nبنامیم، دور از ذهن نباشد.</p><p>حجم: ۳۰۰ میلی‌لیتر</p><p>ویتامین: ندارد</p><p>نوع عصاره: جنسینگ و کراتین</p><h3 class="wp-block-heading"><strong>مصرف‌کنندگان چه می‌گویند؟</strong></h3><p>تجربه اکثر مصرف‌کنندگان این محصول نشان می‌دهد که ماسک ایرانی، موهای \r\nخشک آنها را نرم کرده و شانه زدن موها بعد حمام را خیلی راحت می‌کند و \r\nگره‌های موها را به خوبی از هم باز می‌کند.&nbsp;</p><p>ماسک موی شون با حجم ۳۰۰ لیتری و در ظرفی کاسه‌ای عرضه می‌شود که اکثر خانم‌ها ارزش خرید آن را به نسبت قیمتش مناسب می‌دانند.لینک خرید این ماسک مو از دیجی‌کالا</p><p>یکی از نکات منفی که در خصوص این محصول گاهی بیان شده بوی آن است. \r\nعده‌ای از خانم‌ها بوی این محصول را مناسب نمی‌دانند هر چند می‌توان گفت \r\nبوی محصول تا حدودی به سلیقه شخصی بستگی دارد.</p><p>نکته منفی دیگری که برخی از خانم‌ها در \r\nخصوص این ماسک مو بیان کرده‌اند این است که این محصول تاثیری در رفع وزی \r\nموی آنها نداشته است. بنابراین اگر به دنبال رفع وزی موی خود هستید محصولات\r\n دیگر را امتحان کنید</p><h2 class="wp-block-heading">۲- ماسک مو کامان مدل Amino Min Biotin + zinc</h2><h3 class="wp-block-heading"></h3><p>ماسک و نرم‌کننده موی بیوتین و آبرسان داخل حمام کامان حاوی زینک و \r\nویتامین‌های دیگری است که از نازک و شکننده شدن موها پیشگیری می‌کند و \r\nمقاومت آنها را در برابر استفاده از سشوار، اتوی مو و موخوره بالا می‌برد.</p><p>این ماسک برای افرادی که به دنبال ماسک مویی با حجم بالا و قیمت مناسب \r\nهستند، خوب است. ماسک موی بیوتین کامان مناسب موهای خشک، رنگ شده و موی \r\nعادی است. از جمله ویژگی‌های اصلی آن طبق آنچه در مشخصات این محصول قید شده\r\n می‌توان به مغذی بودن، درخشان‌کنندگی و تقویت‌کنندگی آن اشاره کرد.</p>          </div>', 'hghfg-gfd-ytr', 1, 0, '2025-03-15 20:26:25', NULL, 0),
	(15, 9, 9, 'چه گوشتی برای دیابت خوب است و الویت با کدام گوشت ها است؟', '<div><p >ما با توجه به معیارهای بالا، ۹ ماسک مو \r\nرا که مثبت‌ترین نظرات را در سایت‌های فروش آنلاین از جمله دیجی‌کالا \r\nداشته‌اند، انتخاب کرده‌ایم.&nbsp; و در ادامه به ترتیب از بهترین که شماره یک \r\nاست را برایتان نقد و بررسی کردیم.&nbsp;</p><h2 class="wp-block-heading">۱- ماسک موی ترمیم‌کننده شون مدل Ginseng And Keratin</h2><figure class="wp-block-image"><img decoding="async" src="https://www.daraje.com/wp-content/uploads/2020/11/ماسک-مو-شون.jpg" alt="ماسک موی ترمیم کننده شون مدل Ginseng And Keratin حجم 300 میلی لیتر" class="wp-image-30753"></figure><p>ماسک موی جنسینگ و کراتین شون، ماسکی مناسب موهای خشک، رنگ‌شده و \r\nآسیب‌دیده است. این ماسک مو با داشتن عصاره ریشه جنسینگ، روغن جوجوبا و \r\nکراتین هیدرولیز شده علاوه بر تغذیه عمقی مو یک لایه پروتئینی محافظ هم \r\nبرای ترمیم ساختار سطح مو و جلوگیری از تخریب و شکنندگی مو ایجاد می‌کند و \r\nدر نهایت به از بین بردن گره‌های مو و تنظیم PH مو هم کمک می‌کند.</p><p>این ماسک مو باید بعد از شستشوی مو با شامپو، در حالی که موها هنوز خیس\r\n هستند، به مدت پنج دقیقه روی ساقه مو بماند و سپس آبکشی شود. از آنجایی که\r\n این ماسک حاوی جنسینگ است می‌تواند در مقابله با ریزش مو هم موثر باشد و \r\nپوست سر را از خشکی نجات دهد.</p><p>ماسک شون از ایجاد الکتریسیته ساکن هم جلوگیری می‌کند. این ماسک بنابر \r\nنظرات مصرف‌کنندگان در سایت‌ دیجی‌کالا و اینستاگرام برند شون، از آن دسته \r\nمحصولاتی است که بسیار مقبول بوده و نظرات مثبت نسبت به آن بیش از نظرات \r\nمنفی است بنابراین شاید اگر این ماسک را یکی از بهترین ماسک موهای ایرانی \r\nبنامیم، دور از ذهن نباشد.</p><p>حجم: ۳۰۰ میلی‌لیتر</p><p>ویتامین: ندارد</p><p>نوع عصاره: جنسینگ و کراتین</p><h3 class="wp-block-heading"><strong>مصرف‌کنندگان چه می‌گویند؟</strong></h3><p>تجربه اکثر مصرف‌کنندگان این محصول نشان می‌دهد که ماسک ایرانی، موهای \r\nخشک آنها را نرم کرده و شانه زدن موها بعد حمام را خیلی راحت می‌کند و \r\nگره‌های موها را به خوبی از هم باز می‌کند.&nbsp;</p><p>ماسک موی شون با حجم ۳۰۰ لیتری و در ظرفی کاسه‌ای عرضه می‌شود که اکثر خانم‌ها ارزش خرید آن را به نسبت قیمتش مناسب می‌دانند.لینک خرید این ماسک مو از دیجی‌کالا</p><p>یکی از نکات منفی که در خصوص این محصول گاهی بیان شده بوی آن است. \r\nعده‌ای از خانم‌ها بوی این محصول را مناسب نمی‌دانند هر چند می‌توان گفت \r\nبوی محصول تا حدودی به سلیقه شخصی بستگی دارد.</p><p>نکته منفی دیگری که برخی از خانم‌ها در \r\nخصوص این ماسک مو بیان کرده‌اند این است که این محصول تاثیری در رفع وزی \r\nموی آنها نداشته است. بنابراین اگر به دنبال رفع وزی موی خود هستید محصولات\r\n دیگر را امتحان کنید</p><h2 class="wp-block-heading">۲- ماسک مو کامان مدل Amino Min Biotin + zinc</h2><h3 class="wp-block-heading"></h3><p>ماسک و نرم‌کننده موی بیوتین و آبرسان داخل حمام کامان حاوی زینک و \r\nویتامین‌های دیگری است که از نازک و شکننده شدن موها پیشگیری می‌کند و \r\nمقاومت آنها را در برابر استفاده از سشوار، اتوی مو و موخوره بالا می‌برد.</p><p>این ماسک برای افرادی که به دنبال ماسک مویی با حجم بالا و قیمت مناسب \r\nهستند، خوب است. ماسک موی بیوتین کامان مناسب موهای خشک، رنگ شده و موی \r\nعادی است. از جمله ویژگی‌های اصلی آن طبق آنچه در مشخصات این محصول قید شده\r\n می‌توان به مغذی بودن، درخشان‌کنندگی و تقویت‌کنندگی آن اشاره کرد.</p>          </div>', 'hghfg-gfd-ytr657657', 1, 0, '2025-03-15 20:26:25', NULL, 0),
	(16, 7, 6, 'اولی', '<p>asdasd</p>', 'اولی-اولی', 0, 246, '2017-03-19 15:06:32', '2025-03-24 12:27:27', 0);

-- Dumping structure for table mohsencommerce.post_bigbanners
CREATE TABLE IF NOT EXISTS `post_bigbanners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Post_id` bigint unsigned NOT NULL,
  `Position` tinyint NOT NULL,
  `Width` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_bigbanners_post_id_foreign` (`Post_id`),
  CONSTRAINT `post_bigbanners_post_id_foreign` FOREIGN KEY (`Post_id`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.post_bigbanners: ~4 rows (approximately)
INSERT INTO `post_bigbanners` (`id`, `Post_id`, `Position`, `Width`, `created_at`, `updated_at`) VALUES
	(1, 4, 1, 1, NULL, NULL),
	(2, 8, 2, 2, NULL, NULL),
	(3, 6, 3, 1, NULL, NULL),
	(4, 7, 4, 1, NULL, NULL);

-- Dumping structure for table mohsencommerce.post_categories
CREATE TABLE IF NOT EXISTS `post_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_categories_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.post_categories: ~14 rows (approximately)
INSERT INTO `post_categories` (`id`, `name`, `icon`, `created_at`, `updated_at`, `slug`) VALUES
	(1, 'آشپزی', 'fa fa-utensils', NULL, NULL, 'آشپزی'),
	(2, 'بهداشت', 'fa fa-heartbeat', NULL, NULL, 'بهداشت'),
	(3, 'gdf dfg dfgdf', 'fa fa-laptop', NULL, '2025-05-11 16:04:38', 'gdf-dfg-dfgdf'),
	(4, 'سبک زندگی', 'fa fa-leaf', NULL, NULL, 'g'),
	(5, 'سرگرمی', 'fa fa-film', NULL, NULL, 'h'),
	(6, 'سلامتی', 'fa fa-heartbeat', NULL, NULL, 'j'),
	(7, 'مسافرت', 'fa fa-plane', NULL, NULL, 'h'),
	(8, 'غذا', 'fa fa-utensils', NULL, NULL, 'h'),
	(9, 'فشن', 'fa fa-tshirt', NULL, NULL, 'h'),
	(10, 'تجارت', 'fa fa-landmark', NULL, NULL, 's'),
	(22, 'sdf sdf sd', NULL, '2025-05-11 16:05:45', '2025-05-11 16:05:45', 'sdf-sdf-sd'),
	(25, 'ytuwer wer we', NULL, '2025-05-11 16:06:26', '2025-05-11 16:06:26', 'ytuwer-wer-we'),
	(26, 'بیلبیل بیل', NULL, '2025-05-11 16:08:12', '2025-05-11 16:08:12', 'بیلبیل-بیل'),
	(27, 'jgfh fghfgh', NULL, '2025-05-11 16:34:53', '2025-05-11 16:34:53', 'jgfh-fghfgh');

-- Dumping structure for table mohsencommerce.post_comments
CREATE TABLE IF NOT EXISTS `post_comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `post_id` bigint unsigned NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_comments_user_id_foreign` (`user_id`),
  KEY `post_comments_post_id_foreign` (`post_id`),
  CONSTRAINT `post_comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  CONSTRAINT `post_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.post_comments: ~6 rows (approximately)
INSERT INTO `post_comments` (`id`, `user_id`, `post_id`, `content`, `created_at`, `updated_at`) VALUES
	(1, 3, 4, 'fdgsdfsdfsd', NULL, NULL),
	(2, 3, 4, 'fdgsdfsdfsd', NULL, NULL),
	(3, 3, 4, 'fdgsdfsdfsd', NULL, NULL),
	(4, 3, 7, 'fdgsdfsdfsd', NULL, NULL),
	(5, 3, 6, 'fdgsdfsdfsd', NULL, NULL),
	(6, 3, 7, 'fdgsdfsdfsd', NULL, NULL);

-- Dumping structure for table mohsencommerce.post_likes
CREATE TABLE IF NOT EXISTS `post_likes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `likeable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `likeable_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_likes_user_id_foreign` (`user_id`),
  KEY `post_likes_likeable_type_likeable_id_index` (`likeable_type`,`likeable_id`),
  CONSTRAINT `post_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.post_likes: ~0 rows (approximately)

-- Dumping structure for table mohsencommerce.post_medias
CREATE TABLE IF NOT EXISTS `post_medias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint unsigned DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_medias_post_id_foreign` (`post_id`),
  CONSTRAINT `post_medias_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.post_medias: ~5 rows (approximately)
INSERT INTO `post_medias` (`id`, `post_id`, `file_path`, `extension`, `type`, `alt`, `created_at`, `updated_at`) VALUES
	(2, 4, 'post1', '.jpg', 'banner', 'dfgdfgd', NULL, NULL),
	(3, 8, 'bl2', '.jpg', 'banner', 'ماسک مو', NULL, NULL),
	(4, 4, 'thumb/home-slippers۱۲-300x194', '.jpg', 'thumb', NULL, NULL, NULL),
	(8, 4, 'post1', '.jpg', '2', NULL, NULL, NULL),
	(9, 1, 'bl2', '.jpg', 'banner', NULL, NULL, NULL);

-- Dumping structure for table mohsencommerce.post_post_tags
CREATE TABLE IF NOT EXISTS `post_post_tags` (
  `post_id` bigint unsigned NOT NULL,
  `tag_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`tag_id`),
  KEY `post_post_tags_tag_id_foreign` (`tag_id`),
  CONSTRAINT `post_post_tags_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  CONSTRAINT `post_post_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `post_tags` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.post_post_tags: ~7 rows (approximately)
INSERT INTO `post_post_tags` (`post_id`, `tag_id`) VALUES
	(1, 5),
	(4, 5),
	(5, 5),
	(6, 10),
	(4, 29),
	(1, 34),
	(4, 51);

-- Dumping structure for table mohsencommerce.post_tags
CREATE TABLE IF NOT EXISTS `post_tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_tags_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.post_tags: ~51 rows (approximately)
INSERT INTO `post_tags` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'خودرو', NULL, NULL),
	(2, 'فناوری', NULL, NULL),
	(3, 'هوش مصنوعی', NULL, NULL),
	(4, 'برنامه‌نویسی', NULL, NULL),
	(5, 'توسعه وب', NULL, NULL),
	(6, 'امنیت سایبری', NULL, NULL),
	(7, 'بازی‌های ویدیویی', NULL, NULL),
	(8, 'دیجیتال مارکتینگ', NULL, NULL),
	(9, 'سرمایه‌گذاری', NULL, NULL),
	(10, 'بازاریابی محتوا', NULL, NULL),
	(11, 'کسب‌وکار آنلاین', NULL, NULL),
	(12, 'سئو', NULL, NULL),
	(13, 'وردپرس', NULL, NULL),
	(14, 'پادکست', NULL, NULL),
	(15, 'مطالعات علمی', NULL, NULL),
	(16, 'فضا و نجوم', NULL, NULL),
	(17, 'روباتیک', NULL, NULL),
	(18, 'سینما و فیلم', NULL, NULL),
	(19, 'موسیقی', NULL, NULL),
	(20, 'نقد و بررسی', NULL, NULL),
	(21, 'روانشناسی', NULL, NULL),
	(22, 'موفقیت', NULL, NULL),
	(23, 'کتاب و مطالعه', NULL, NULL),
	(24, 'طراحی گرافیک', NULL, NULL),
	(25, 'عکاسی', NULL, NULL),
	(26, 'هوش هیجانی', NULL, NULL),
	(27, 'یادگیری ماشین', NULL, NULL),
	(28, 'بلاکچین', NULL, NULL),
	(29, 'ارز دیجیتال', NULL, NULL),
	(30, 'تاریخ و فرهنگ', NULL, NULL),
	(31, 'اقتصاد', NULL, NULL),
	(32, 'ورزش و تناسب اندام', NULL, NULL),
	(33, 'سلامتی و تغذیه', NULL, NULL),
	(34, 'تکنولوژی موبایل', NULL, NULL),
	(35, 'واقعیت افزوده', NULL, NULL),
	(36, 'واقعیت مجازی', NULL, NULL),
	(37, 'تحلیل داده', NULL, NULL),
	(38, 'معماری نرم‌افزار', NULL, NULL),
	(39, 'کسب و کارهای نوپا', NULL, NULL),
	(40, 'فریلنسینگ', NULL, NULL),
	(41, 'کارآفرینی', NULL, NULL),
	(42, 'مدیریت زمان', NULL, NULL),
	(43, 'نویسندگی', NULL, NULL),
	(44, 'تولید محتوا', NULL, NULL),
	(45, 'آموزش الکترونیک', NULL, NULL),
	(46, 'سفر و گردشگری', NULL, NULL),
	(47, 'محیط زیست', NULL, NULL),
	(48, 'علم و تکنولوژی', NULL, NULL),
	(49, 'هنرهای دیجیتال', NULL, NULL),
	(50, 'داستان‌نویسی', NULL, NULL),
	(51, 'تحلیل بازار', NULL, NULL);

-- Dumping structure for table mohsencommerce.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `discount_price` decimal(12,2) DEFAULT NULL,
  `stock` int unsigned NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint unsigned NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `images` json DEFAULT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `dimension` decimal(8,2) DEFAULT NULL,
  `attributes` json DEFAULT NULL,
  `views_count` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `attribute_template_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_attribute_template_id_foreign` (`attribute_template_id`),
  CONSTRAINT `products_attribute_template_id_foreign` FOREIGN KEY (`attribute_template_id`) REFERENCES `attribute_templates` (`id`) ON DELETE SET NULL,
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.products: ~9 rows (approximately)
INSERT INTO `products` (`id`, `name`, `slug`, `description`, `price`, `discount_price`, `stock`, `sku`, `category_id`, `is_active`, `images`, `brand`, `weight`, `dimension`, `attributes`, `views_count`, `created_at`, `updated_at`, `attribute_template_id`) VALUES
	(1, 'کارت گرافیک 5090', 'کارت-گرافیک-5090', 'شسیشسیشسیشس س شیشسی شسی شسیشس یشسی شسی', 666383.00, NULL, 27, NULL, 10, 1, '{"main": "Asus-Dual-RTX-4060-OC-8GB-1-300x300", "thumb": "rtx.jpg", "gallery": ["Asus-Dual-RTX-4060-OC-8GB-1-300x300"]}', 'شسی', 50, 10.00, '[{"name": "شسی", "value": "324"}, {"name": "یبیسی", "value": "324"}, {"name": "456", "value": "546"}]', 3, '2025-03-14 14:57:49', '2025-05-11 13:22:24', NULL),
	(36, 'amet', 'necessitatibus-vel-voluptates-quasi-laboriosam-voluptatum-veniam-sint', 'Quia illo est harum libero sed et itaque.', 103652.00, NULL, 58, NULL, 4, 1, NULL, NULL, NULL, NULL, NULL, 0, '2025-03-14 14:57:49', '2025-03-14 14:57:49', NULL),
	(145, 'ddfd fdf', 'ddfd-fdf', '<p>fdgdg</p>', 435.00, 678.00, 2, '876', 30, 0, '{"main": "main_ddfd-fdf-681f5785da7ee.jpg", "thumb": "thumb_ddfd-fdf-681f5785dd35c.jpg", "gallery": ["ddfd-fdf-681f5785dd6d6.jpg", "ddfd-fdf-681f5785ddab8.jpg", "ddfd-fdf-681f5785dde23.jpg"]}', 'fdg', 678, NULL, '[{"name": "رنگ", "value": "سبز"}, {"name": "قیمه", "value": "خورشت"}]', 0, '2025-05-10 13:41:25', '2025-05-10 13:41:25', NULL),
	(146, 'شال کنفی طرحدار دور ریش وارداتی', 'شال-کنفی-طرحدار-دور-ریش-وارداتی', '<p><span style="background-color: rgb(255, 255, 255); color: rgb(34, 34, 34);">شال کنفی طرحدار دور ریش وارداتی کیفیتA+++ایستایی روی سر عالی جنس نخ کنفی بسیار نرم و لطیف</span></p>', 399000.00, 12.00, 50, '2240', 32, 0, '{"main": "main_شال-کنفی-طرحدار-دور-ریش-وارداتی-681f60a96e2ff.jpg", "thumb": "thumb_شال-کنفی-طرحدار-دور-ریش-وارداتی-681f60a9717ab.jpg", "gallery": ["شال-کنفی-طرحدار-دور-ریش-وارداتی-681f60a971c39.jpg", "شال-کنفی-طرحدار-دور-ریش-وارداتی-681f60a972083.jpg", "شال-کنفی-طرحدار-دور-ریش-وارداتی-681f60a9724a7.jpg"]}', 'پرند', 0.1, NULL, '[{"name": "رنگ", "value": "سبز"}, {"name": "اندازه", "value": "100cm"}, {"name": "جنس", "value": "پبنه"}, {"name": "کیفیت", "value": "عالی"}]', 55, '2025-05-10 14:20:25', '2025-05-11 13:50:28', NULL),
	(147, 'شال کنفی طرحدار دور ریش وارداتی', 'شال-کنفیی-طرحدار-دور-ریش-وارداتی', '<p><span style="background-color: rgb(255, 255, 255); color: rgb(34, 34, 34);">شال کنفی طرحدار دور ریش وارداتی کیفیتA+++ایستایی روی سر عالی جنس نخ کنفی بسیار نرم و لطیف</span></p>', 399000.00, 12.00, 50, '22401', 32, 0, '{"main": "main_شال-کنفیی-طرحدار-دور-ریش-وارداتی-681f611e87f9b.jpg", "thumb": "thumb_شال-کنفیی-طرحدار-دور-ریش-وارداتی-681f611e8afbf.jpg", "gallery": ["شال-کنفیی-طرحدار-دور-ریش-وارداتی-681f611e8b38f.jpg", "شال-کنفیی-طرحدار-دور-ریش-وارداتی-681f611e9548d.jpg", "شال-کنفیی-طرحدار-دور-ریش-وارداتی-681f611e95a13.jpg"]}', 'پرند', 0.1, NULL, '[{"name": "رنگ", "value": "سبز"}, {"name": "اندازه", "value": "100cm"}, {"name": "جنس", "value": "پبنه"}, {"name": "کیفیت", "value": "عالی"}]', 0, '2025-05-10 14:22:22', '2025-05-10 14:22:22', NULL),
	(148, 'کارت گرافیک ASUS TUF GAMING RTX 5060 Ti OC 16GB', 'کارت-گرافیک-asus-tuf-gaming-rtx-5060-ti-oc-16gb', 'undefined', 8250000.00, 0.00, 50, '98741365', 8, 0, '{"main": "main_کارت-گرافیک-asus-tuf-gaming-rtx-5060-ti-oc-16gb-6820ac3ad9025.webp", "thumb": "thumb_کارت-گرافیک-asus-tuf-gaming-rtx-5060-ti-oc-16gb-6820ac3adca4e.webp", "gallery": ["کارت-گرافیک-asus-tuf-gaming-rtx-5060-ti-oc-16gb-6820ac3adcf05.webp", "کارت-گرافیک-asus-tuf-gaming-rtx-5060-ti-oc-16gb-6820ac3add4b7.webp", "کارت-گرافیک-asus-tuf-gaming-rtx-5060-ti-oc-16gb-6820ac3adda67.webp", "کارت-گرافیک-asus-tuf-gaming-rtx-5060-ti-oc-16gb-6820ac3ade0aa.webp", "کارت-گرافیک-asus-tuf-gaming-rtx-5060-ti-oc-16gb-6820ac3ade774.webp", "کارت-گرافیک-asus-tuf-gaming-rtx-5060-ti-oc-16gb-6820ac3adecc6.webp"]}', 'nvidia', 5, NULL, '[{"name": "سازنده ", "value": "nvidia"}, {"name": "نام پردازنده گرافیکی", "value": "\\tRTX 5060 Ti"}]', 2, '2025-05-11 13:55:06', '2025-05-11 13:58:20', NULL),
	(149, 'ds', 'ds', '<p>fdgfdg</p>', 65.00, NULL, 32, '343443', 26, 0, '{"main": null, "thumb": "thumb_ds-6820ae195f621.webp", "gallery": []}', 'fdg', 54, NULL, '[{"name": "5", "value": "54"}]', 0, '2025-05-11 14:03:05', '2025-05-11 14:03:05', NULL),
	(150, 'gfh', 'gfh', '<p>fdg</p>', 5465.00, NULL, 4, '768', 30, 0, '{"main": null, "thumb": null, "gallery": []}', 'gfh', 5, NULL, '[{"name": "sadasd", "value": "546"}]', 0, '2025-05-11 14:04:01', '2025-05-11 14:04:01', NULL),
	(151, 'dfg', 'dfg', '<p>234</p>', 324.00, NULL, 3, '234', 30, 0, '{"main": null, "thumb": null, "gallery": []}', '324', 234, NULL, '[{"name": "sadasd", "value": "324"}, {"name": "asd", "value": "asd"}]', 0, '2025-05-11 14:08:22', '2025-05-11 14:08:22', NULL);

-- Dumping structure for table mohsencommerce.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.sessions: ~1 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('3emW7fMC3ZT4RcpZJQRR6gidf0RGBQgbRkFlMDQG', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU05FVFRrVk91WGVTaXNkMHY0azhobkxYbURQYTlPZ040MUdVMEl2USI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9ibG9nL3Bvc3RzL2VkaXQvJUQ4JUE3JUQ5JTg4JUQ5JTg0JURCJThDLSVEOCVBNyVEOSU4OCVEOSU4NCVEQiU4QyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747339409);

-- Dumping structure for table mohsencommerce.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` json NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mohsencommerce.users: ~51 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `address`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Miss Brianne Trantow', 'armstrong.lucy@example.net', '{"address": "352 Hintz Track\\nErnestofurt, NE 73404"}', '2025-03-14 14:57:50', '$2y$2y$12$sKrfCKY2ola05H25xCyeduqb1u2yhVrs027Z/sPQbY8ZZCBhWVLS6', 'dZ7gwitwGL', '2025-03-14 14:57:50', '2025-03-14 14:57:50'),
	(2, 'Miss Kathleen Mante Sr.', 'walker.jerry@example.net', '{"address": "738 Breitenberg Vista\\nSchambergermouth, AL 75469-3886"}', '2025-03-14 14:57:50', '$2y$12$bnSv4KFH4.9kxpsQX9l.5.Rsl/ylX0REpWYHFoeBrdD0q41Hotxhe', 'IM2OlsrR2y', '2025-03-14 14:57:50', '2025-03-14 14:57:50'),
	(3, 'Llewellyn Considine', 'ismael.dubuque@example.net', '{"address": "88115 Fletcher Spur Apt. 379\\nSouth Bettye, DC 64967-4648"}', '2025-03-14 14:57:50', '$2y$12$bnSv4KFH4.9kxpsQX9l.5.Rsl/ylX0REpWYHFoeBrdD0q41Hotxhe', 'evpnljhFmB', '2025-03-14 14:57:50', '2025-03-14 14:57:50'),
	(4, 'Mr. Ike McDermott', 'dario.pacocha@example.net', '{"address": "701 Elenora Springs Suite 375\\nWest Corrine, LA 15863"}', '2025-03-14 14:57:50', '$2y$12$bnSv4KFH4.9kxpsQX9l.5.Rsl/ylX0REpWYHFoeBrdD0q41Hotxhe', 'ReteNvITM4', '2025-03-14 14:57:50', '2025-03-14 14:57:50'),
	(5, 'Miss Laurine Parker MD', 'abdul.farrell@example.com', '{"address": "2125 Paige Pines\\nAlvaburgh, IL 20262-2807"}', '2025-03-14 14:57:50', '$2y$12$bnSv4KFH4.9kxpsQX9l.5.Rsl/ylX0REpWYHFoeBrdD0q41Hotxhe', 'YjwXJHi3gs', '2025-03-14 14:57:50', '2025-03-14 14:57:50'),
	(6, 'Mose Jerde', 'omarquardt@example.net', '{"address": "151 Birdie Cape Suite 237\\nGonzalomouth, MO 11560"}', '2025-03-14 14:57:50', '$2y$12$bnSv4KFH4.9kxpsQX9l.5.Rsl/ylX0REpWYHFoeBrdD0q41Hotxhe', 'j150DDCS0r', '2025-03-14 14:57:50', '2025-03-14 14:57:50'),
	(7, 'Jedediah Towne', 'ndaniel@example.org', '{"address": "44489 Janie Isle Apt. 245\\nEffertzside, DC 62821-1485"}', '2025-03-14 14:57:50', '$2y$12$bnSv4KFH4.9kxpsQX9l.5.Rsl/ylX0REpWYHFoeBrdD0q41Hotxhe', 'gEy9xCiKTd', '2025-03-14 14:57:50', '2025-03-14 14:57:50'),
	(8, 'Virginia Kerluke', 'gleannon@example.org', '{"address": "776 O\'Hara Pine\\nChristatown, OK 14841-7662"}', '2025-03-14 14:57:50', '$2y$12$bnSv4KFH4.9kxpsQX9l.5.Rsl/ylX0REpWYHFoeBrdD0q41Hotxhe', 'us1PEcAZIh', '2025-03-14 14:57:50', '2025-03-14 14:57:50'),
	(9, 'Cathryn Ward', 'zromaguera@example.com', '{"address": "78174 Wolf Brooks Apt. 564\\nCruzfurt, NY 70390"}', '2025-03-14 14:57:50', '$2y$12$bnSv4KFH4.9kxpsQX9l.5.Rsl/ylX0REpWYHFoeBrdD0q41Hotxhe', 'UUe5iqFyGY', '2025-03-14 14:57:50', '2025-03-14 14:57:50'),
	(10, 'Valerie McCullough', 'deckow.garth@example.com', '{"address": "64567 Burley Tunnel Suite 511\\nLueilwitzland, KS 54232-9594"}', '2025-03-14 14:57:50', '$2y$12$bnSv4KFH4.9kxpsQX9l.5.Rsl/ylX0REpWYHFoeBrdD0q41Hotxhe', 'hcICAkWdxx', '2025-03-14 14:57:50', '2025-03-14 14:57:50'),
	(11, 'Miss Mikayla Strosin', 'ysenger@example.net', '{"address": "1080 Mollie Center\\nPort Aliceland, KS 15823-0671"}', '2025-03-24 18:31:21', '$2y$12$eMR13PGAiPeJrNkAaD.1WOV8zmWPt/Cri/39hygqAbynNBhM8XzeK', 'UyHl2tSzz6', '2025-03-24 18:31:21', '2025-03-24 18:31:21'),
	(12, 'Anibal Weber III', 'roberto49@example.org', '{"address": "7910 Paolo Lake Apt. 382\\nNew Janaeland, KS 18262-7067"}', '2025-03-24 18:31:21', '$2y$12$eMR13PGAiPeJrNkAaD.1WOV8zmWPt/Cri/39hygqAbynNBhM8XzeK', 'ZMPuNqkSvk', '2025-03-24 18:31:21', '2025-03-24 18:31:21'),
	(13, 'Ms. Aniyah Ondricka', 'cleora31@example.com', '{"address": "6758 August Mountain Suite 165\\nColumbusfort, AZ 57668"}', '2025-03-24 18:31:21', '$2y$12$eMR13PGAiPeJrNkAaD.1WOV8zmWPt/Cri/39hygqAbynNBhM8XzeK', 'hMOBSZx8kF', '2025-03-24 18:31:21', '2025-03-24 18:31:21'),
	(14, 'Angus Quigley', 'lewis.jakubowski@example.com', '{"address": "797 Gay Corner Apt. 457\\nHettieborough, HI 23104-8737"}', '2025-03-24 18:31:21', '$2y$12$eMR13PGAiPeJrNkAaD.1WOV8zmWPt/Cri/39hygqAbynNBhM8XzeK', 'd0Wl1du0ZA', '2025-03-24 18:31:21', '2025-03-24 18:31:21'),
	(15, 'Treva Rolfson', 'mcclure.gladyce@example.net', '{"address": "873 Frami Locks\\nWest Kassandra, SC 26441-1030"}', '2025-03-24 18:31:21', '$2y$12$eMR13PGAiPeJrNkAaD.1WOV8zmWPt/Cri/39hygqAbynNBhM8XzeK', 'yTt3oo1HLk', '2025-03-24 18:31:21', '2025-03-24 18:31:21'),
	(16, 'Johnpaul Pagac III', 'mackenzie.bogisich@example.net', '{"address": "2429 Abigail Row\\nWest Americoland, VT 68988"}', '2025-03-24 18:31:21', '$2y$12$eMR13PGAiPeJrNkAaD.1WOV8zmWPt/Cri/39hygqAbynNBhM8XzeK', '6ig0DtmwFh', '2025-03-24 18:31:21', '2025-03-24 18:31:21'),
	(17, 'Prof. Dewitt Doyle Sr.', 'jones.celestino@example.org', '{"address": "923 Dibbert Stravenue\\nNorth Garett, SC 80200-3019"}', '2025-03-24 18:31:21', '$2y$12$eMR13PGAiPeJrNkAaD.1WOV8zmWPt/Cri/39hygqAbynNBhM8XzeK', 'o1VoWeWS2y', '2025-03-24 18:31:21', '2025-03-24 18:31:21'),
	(18, 'Camryn Will', 'ypouros@example.com', '{"address": "8493 Dawson Groves Suite 532\\nPort Eloy, HI 73486-9868"}', '2025-03-24 18:31:21', '$2y$12$eMR13PGAiPeJrNkAaD.1WOV8zmWPt/Cri/39hygqAbynNBhM8XzeK', '5qKqWMv8lZ', '2025-03-24 18:31:21', '2025-03-24 18:31:21'),
	(19, 'Ms. Letha Lakin', 'rogelio69@example.org', '{"address": "437 Olson Common Apt. 856\\nHanemouth, ME 74310-7194"}', '2025-03-24 18:31:21', '$2y$12$eMR13PGAiPeJrNkAaD.1WOV8zmWPt/Cri/39hygqAbynNBhM8XzeK', 'UVLCTiR0x3', '2025-03-24 18:31:21', '2025-03-24 18:31:21'),
	(20, 'Irma Prohaska', 'maryam19@example.net', '{"address": "7495 Okuneva Via\\nPierreshire, PA 75950-0670"}', '2025-03-24 18:31:21', '$2y$12$eMR13PGAiPeJrNkAaD.1WOV8zmWPt/Cri/39hygqAbynNBhM8XzeK', 'eWL0aX0G3o', '2025-03-24 18:31:21', '2025-03-24 18:31:21'),
	(21, 'Krista Schuppe MD', 'nshanahan@example.org', '{"address": "36016 Marks Court\\nNorth Saige, AL 61866"}', '2025-03-24 18:31:21', '$2y$12$eMR13PGAiPeJrNkAaD.1WOV8zmWPt/Cri/39hygqAbynNBhM8XzeK', 'eTHws6MyEt', '2025-03-24 18:31:21', '2025-03-24 18:31:21'),
	(22, 'Lelah Prosacco', 'garfield46@example.org', '{"address": "786 Justus Street\\nSouth Reta, SD 54754-7378"}', '2025-03-24 18:31:21', '$2y$12$eMR13PGAiPeJrNkAaD.1WOV8zmWPt/Cri/39hygqAbynNBhM8XzeK', 'NHUNwT5BiV', '2025-03-24 18:31:21', '2025-03-24 18:31:21'),
	(23, 'Alexandra Hahn', 'rframi@example.org', '{"address": "68891 Monahan Vista Suite 774\\nPort Kassandratown, CT 94676-8702"}', '2025-03-24 18:31:21', '$2y$12$eMR13PGAiPeJrNkAaD.1WOV8zmWPt/Cri/39hygqAbynNBhM8XzeK', 'MDjtFC0Zyg', '2025-03-24 18:31:21', '2025-03-24 18:31:21'),
	(24, 'Kale Fritsch DDS', 'morton.pouros@example.org', '{"address": "73399 Avis Skyway\\nEast Isom, MN 19708-2982"}', '2025-03-24 18:31:21', '$2y$12$eMR13PGAiPeJrNkAaD.1WOV8zmWPt/Cri/39hygqAbynNBhM8XzeK', '4F3a0pGY3M', '2025-03-24 18:31:21', '2025-03-24 18:31:21'),
	(25, 'Hunter Torphy', 'hackett.donnie@example.com', '{"address": "433 Torphy Lake Suite 552\\nNew Bretthaven, KY 28184"}', '2025-03-24 18:31:21', '$2y$12$eMR13PGAiPeJrNkAaD.1WOV8zmWPt/Cri/39hygqAbynNBhM8XzeK', 'fCylSVFSXv', '2025-03-24 18:31:21', '2025-03-24 18:31:21'),
	(26, 'Paris Connelly', 'hammes.domenica@example.com', '{"address": "9925 Scarlett Trail\\nEast Luisa, WV 54979"}', '2025-03-24 18:31:21', '$2y$12$eMR13PGAiPeJrNkAaD.1WOV8zmWPt/Cri/39hygqAbynNBhM8XzeK', 'N7dUHv9bij', '2025-03-24 18:31:21', '2025-03-24 18:31:21'),
	(27, 'Felicita Kutch', 'alverta55@example.net', '{"address": "668 Tromp Shoal\\nSouth Krystaltown, VT 50198"}', '2025-03-24 18:31:21', '$2y$12$eMR13PGAiPeJrNkAaD.1WOV8zmWPt/Cri/39hygqAbynNBhM8XzeK', 'QuYZb8n5LL', '2025-03-24 18:31:21', '2025-03-24 18:31:21'),
	(28, 'Keshawn Hickle', 'abbott.cordia@example.org', '{"address": "49200 Rosalyn Hills\\nEast Lonie, DE 63941-2937"}', '2025-03-24 18:31:21', '$2y$12$eMR13PGAiPeJrNkAaD.1WOV8zmWPt/Cri/39hygqAbynNBhM8XzeK', '0pi3PDuQKa', '2025-03-24 18:31:21', '2025-03-24 18:31:21'),
	(29, 'Margret Hessel', 'hdaniel@example.net', '{"address": "71123 Minerva Village\\nNew Lutherbury, SD 84934-0540"}', '2025-03-24 18:31:21', '$2y$12$eMR13PGAiPeJrNkAaD.1WOV8zmWPt/Cri/39hygqAbynNBhM8XzeK', 'uvExqnqwj3', '2025-03-24 18:31:21', '2025-03-24 18:31:21'),
	(30, 'Cindy Koelpin', 'vritchie@example.com', '{"address": "42577 Treutel Valleys Apt. 580\\nKunzetown, WA 99641"}', '2025-03-24 18:31:21', '$2y$12$eMR13PGAiPeJrNkAaD.1WOV8zmWPt/Cri/39hygqAbynNBhM8XzeK', 'XyKBbaeJr9', '2025-03-24 18:31:21', '2025-03-24 18:31:21'),
	(31, 'Carole Pollich', 'lourdes.brakus@example.org', '{"address": "6936 Alessandra Via\\nLake Luluburgh, AK 96259"}', '2025-03-24 18:31:41', '$2y$12$7z.phSFEWFaP140zwHDPie.x1SCqtumhO6OcmZ919HtSPWGiP2aqi', 'nOXiCsXP0M', '2025-03-24 18:31:42', '2025-03-24 18:31:42'),
	(32, 'Dr. Jessy Vandervort', 'rziemann@example.org', '{"address": "647 Senger Road Apt. 258\\nNorth Lera, PA 82130"}', '2025-03-24 18:31:42', '$2y$12$7z.phSFEWFaP140zwHDPie.x1SCqtumhO6OcmZ919HtSPWGiP2aqi', 'QAfIw78Dkf', '2025-03-24 18:31:42', '2025-03-24 18:31:42'),
	(33, 'Susana Rolfson', 'lowe.lizzie@example.com', '{"address": "51832 Koelpin Squares Apt. 132\\nSouth Johnathanbury, AZ 95535-8597"}', '2025-03-24 18:31:42', '$2y$12$7z.phSFEWFaP140zwHDPie.x1SCqtumhO6OcmZ919HtSPWGiP2aqi', 'LhSDXyYCGg', '2025-03-24 18:31:42', '2025-03-24 18:31:42'),
	(34, 'Isabell Weissnat', 'nquigley@example.com', '{"address": "360 Yasmine Lane Suite 492\\nLake Malikaside, ID 81568"}', '2025-03-24 18:31:42', '$2y$12$7z.phSFEWFaP140zwHDPie.x1SCqtumhO6OcmZ919HtSPWGiP2aqi', 'mI5dGL0Ba9', '2025-03-24 18:31:42', '2025-03-24 18:31:42'),
	(35, 'Bartholome Murazik', 'glover.dallin@example.org', '{"address": "1317 Reilly Mill Apt. 459\\nHalvorsonfurt, AR 11055-1444"}', '2025-03-24 18:31:42', '$2y$12$7z.phSFEWFaP140zwHDPie.x1SCqtumhO6OcmZ919HtSPWGiP2aqi', 'LX7xESOKKt', '2025-03-24 18:31:42', '2025-03-24 18:31:42'),
	(36, 'Mckenzie Conroy DDS', 'qdeckow@example.net', '{"address": "47635 Michale Light Suite 983\\nNew Ole, NY 72829"}', '2025-03-24 18:31:42', '$2y$12$7z.phSFEWFaP140zwHDPie.x1SCqtumhO6OcmZ919HtSPWGiP2aqi', 'MdZ2wPgzjn', '2025-03-24 18:31:42', '2025-03-24 18:31:42'),
	(37, 'Dahlia Abbott', 'rreichel@example.com', '{"address": "92165 Jaylen Rest\\nWest Rutheborough, NH 36801"}', '2025-03-24 18:31:42', '$2y$12$7z.phSFEWFaP140zwHDPie.x1SCqtumhO6OcmZ919HtSPWGiP2aqi', 'MZ4cZYn4qa', '2025-03-24 18:31:42', '2025-03-24 18:31:42'),
	(38, 'Miss Zola D\'Amore Jr.', 'logan.kilback@example.net', '{"address": "9033 Tressie Terrace\\nLake Federicofurt, NJ 48245-5109"}', '2025-03-24 18:31:42', '$2y$12$7z.phSFEWFaP140zwHDPie.x1SCqtumhO6OcmZ919HtSPWGiP2aqi', 'h8rPEA068k', '2025-03-24 18:31:42', '2025-03-24 18:31:42'),
	(39, 'Stacy Rolfson', 'mcglynn.anna@example.org', '{"address": "2731 Idell Parkway Apt. 898\\nFarrellborough, VT 68881-4501"}', '2025-03-24 18:31:42', '$2y$12$7z.phSFEWFaP140zwHDPie.x1SCqtumhO6OcmZ919HtSPWGiP2aqi', 'SFV3nv95Vh', '2025-03-24 18:31:42', '2025-03-24 18:31:42'),
	(40, 'Myra Borer', 'considine.elisa@example.net', '{"address": "91352 Hirthe Extension Suite 573\\nAbbieside, IN 63984"}', '2025-03-24 18:31:42', '$2y$12$7z.phSFEWFaP140zwHDPie.x1SCqtumhO6OcmZ919HtSPWGiP2aqi', 'OQ0kehugKG', '2025-03-24 18:31:42', '2025-03-24 18:31:42'),
	(41, 'Evie Reichel', 'qlubowitz@example.com', '{"address": "638 Branson Track\\nSouth Tobybury, AZ 49851-4520"}', '2025-03-24 18:31:42', '$2y$12$7z.phSFEWFaP140zwHDPie.x1SCqtumhO6OcmZ919HtSPWGiP2aqi', 'a01vEU2mMj', '2025-03-24 18:31:42', '2025-03-24 18:31:42'),
	(42, 'Mr. Torrey Kshlerin III', 'jovan37@example.org', '{"address": "813 Adams Summit Suite 488\\nBashirianside, WY 24035"}', '2025-03-24 18:31:42', '$2y$12$7z.phSFEWFaP140zwHDPie.x1SCqtumhO6OcmZ919HtSPWGiP2aqi', 'n8fmQVxQka', '2025-03-24 18:31:42', '2025-03-24 18:31:42'),
	(43, 'Ms. Helene Collier PhD', 'joan70@example.com', '{"address": "690 Tromp Circles\\nEast Elizabeth, ID 57047-9676"}', '2025-03-24 18:31:42', '$2y$12$7z.phSFEWFaP140zwHDPie.x1SCqtumhO6OcmZ919HtSPWGiP2aqi', 'AQLx0UGYp4', '2025-03-24 18:31:42', '2025-03-24 18:31:42'),
	(44, 'Mr. Demetrius Turcotte', 'bernier.emile@example.net', '{"address": "8849 Kiehn Creek\\nSchmelerport, CT 15607-2513"}', '2025-03-24 18:31:42', '$2y$12$7z.phSFEWFaP140zwHDPie.x1SCqtumhO6OcmZ919HtSPWGiP2aqi', 'IKJqsaIxaA', '2025-03-24 18:31:42', '2025-03-24 18:31:42'),
	(45, 'Dr. Mabelle Bode', 'iwunsch@example.org', '{"address": "88131 Dagmar Pass Apt. 083\\nPort Courtney, KY 94227"}', '2025-03-24 18:31:42', '$2y$12$7z.phSFEWFaP140zwHDPie.x1SCqtumhO6OcmZ919HtSPWGiP2aqi', '3eV1Rwmndw', '2025-03-24 18:31:42', '2025-03-24 18:31:42'),
	(46, 'Prof. Eleanora Spinka IV', 'senger.michaela@example.org', '{"address": "550 Hagenes Common Apt. 272\\nLuisview, KS 82291-1395"}', '2025-03-24 18:31:42', '$2y$12$7z.phSFEWFaP140zwHDPie.x1SCqtumhO6OcmZ919HtSPWGiP2aqi', 'hHa7eMwRdq', '2025-03-24 18:31:42', '2025-03-24 18:31:42'),
	(47, 'Edmond Mante IV', 'soledad.glover@example.com', '{"address": "528 Keeling Crescent\\nWest Devonberg, NY 31810"}', '2025-03-24 18:31:42', '$2y$12$7z.phSFEWFaP140zwHDPie.x1SCqtumhO6OcmZ919HtSPWGiP2aqi', 'IWHCkAzepX', '2025-03-24 18:31:42', '2025-03-24 18:31:42'),
	(48, 'Lyric Murphy', 'bradtke.maxine@example.com', '{"address": "34957 Susan Hollow\\nLindstad, LA 10629-9700"}', '2025-03-24 18:31:42', '$2y$12$7z.phSFEWFaP140zwHDPie.x1SCqtumhO6OcmZ919HtSPWGiP2aqi', 'eB1l0p6lKX', '2025-03-24 18:31:42', '2025-03-24 18:31:42'),
	(49, 'Timmy Goodwin', 'sporer.kathleen@example.com', '{"address": "7456 Derek Corner Apt. 895\\nSouth Bonnie, RI 78636"}', '2025-03-24 18:31:42', '$2y$12$7z.phSFEWFaP140zwHDPie.x1SCqtumhO6OcmZ919HtSPWGiP2aqi', 'DWejyyPDGl', '2025-03-24 18:31:42', '2025-03-24 18:31:42'),
	(50, 'Talia Bergstrom', 'geovany.padberg@example.org', '{"address": "9310 Kutch Key\\nLake Ollie, RI 97125"}', '2025-03-24 18:31:42', '$2y$12$7z.phSFEWFaP140zwHDPie.x1SCqtumhO6OcmZ919HtSPWGiP2aqi', 'KGICGFCuA9', '2025-03-24 18:31:42', '2025-03-24 18:31:42'),
	(51, 'admin', 'admin@1.com', '{"address": "asdasd"}', '2025-03-24 18:31:42', '$2y$12$JMLpt59W6VLBYi3jDmVXZuzNarg0Zan.B2PP1RWrR3QXhVACF2sYW', 'xr2SXodl7Nw3j87l356d9JPBI42vfd0PgFUiu3FtYSzWXDgBqi20dpr1ZcmF', '2025-03-24 18:31:42', '2025-03-24 18:31:42');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
