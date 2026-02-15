-- =====================================================
-- SCHEMA DATABASE: LIBRARY SEMBARI
-- =====================================================

-- Table: reading_levels
CREATE TABLE `reading_levels` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `label` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reading_levels_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: licenses
CREATE TABLE `licenses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: categories
CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: authors
CREATE TABLE `authors` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: books
CREATE TABLE `books` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `reading_level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `license_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `books_slug_unique` (`slug`),
  KEY `books_reading_level_id_foreign` (`reading_level_id`),
  KEY `books_license_id_foreign` (`license_id`),
  CONSTRAINT `books_reading_level_id_foreign` FOREIGN KEY (`reading_level_id`) REFERENCES `reading_levels` (`id`) ON DELETE SET NULL,
  CONSTRAINT `books_license_id_foreign` FOREIGN KEY (`license_id`) REFERENCES `licenses` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: book_contributors
CREATE TABLE `book_contributors` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('penulis','penerjemah','ilustrator') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `book_contributors_book_id_foreign` (`book_id`),
  KEY `book_contributors_author_id_foreign` (`author_id`),
  CONSTRAINT `book_contributors_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `book_contributors_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: book_categories
CREATE TABLE `book_categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `book_categories_book_id_foreign` (`book_id`),
  KEY `book_categories_category_id_foreign` (`category_id`),
  CONSTRAINT `book_categories_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `book_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: book_stats
CREATE TABLE `book_stats` (
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `views_count` int(11) NOT NULL DEFAULT 0,
  `likes_count` int(11) NOT NULL DEFAULT 0,
  `reads_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`book_id`),
  CONSTRAINT `book_stats_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- SAMPLE DATA
-- =====================================================

-- Reading Levels
INSERT INTO `reading_levels` (`code`, `label`, `created_at`, `updated_at`) VALUES
('B1', 'Pembaca Awal', NOW(), NOW()),
('B2', 'Pembaca Menengah', NOW(), NOW()),
('B3', 'Pembaca Mahir', NOW(), NOW());

-- Licenses
INSERT INTO `licenses` (`name`, `description`, `created_at`, `updated_at`) VALUES
('CC-BY-NC-SA', 'Creative Commons Attribution-NonCommercial-ShareAlike', NOW(), NOW()),
('CC-BY-SA', 'Creative Commons Attribution-ShareAlike', NOW(), NOW()),
('Public Domain', 'Domain Publik', NOW(), NOW());

-- Categories
INSERT INTO `categories` (`name`, `slug`, `created_at`, `updated_at`) VALUES
('Fiksi', 'fiksi', NOW(), NOW()),
('Non-Fiksi', 'non-fiksi', NOW(), NOW()),
('Dongeng', 'dongeng', NOW(), NOW()),
('Sains', 'sains', NOW(), NOW()),
('Sejarah', 'sejarah', NOW(), NOW());
