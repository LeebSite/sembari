-- =====================================================
-- UPDATE LIBRARY DATABASE STRUCTURE
-- Mengubah struktur untuk kontributor manual dan data baru
-- =====================================================

-- 1. DROP tables lama yang tidak dipakai
DROP TABLE IF EXISTS `book_contributors`;
DROP TABLE IF EXISTS `authors`;
DROP TABLE IF EXISTS `licenses`;
DROP TABLE IF EXISTS `reading_levels`;

-- 2. UPDATE table books - tambah kolom baru
ALTER TABLE `books` 
DROP FOREIGN KEY IF EXISTS `books_reading_level_id_foreign`,
DROP FOREIGN KEY IF EXISTS `books_license_id_foreign`;

ALTER TABLE `books`
DROP COLUMN IF EXISTS `reading_level_id`,
DROP COLUMN IF EXISTS `license_id`,
ADD COLUMN `contributors` TEXT NULL AFTER `description`,
ADD COLUMN `license` ENUM('Buku Edisi Terbatas', 'Buku Edisi Umum') NULL AFTER `contributors`;

-- 3. DROP dan BUAT ULANG table categories dengan data baru
DROP TABLE IF EXISTS `book_categories`;
DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. INSERT data categories baru
INSERT INTO `categories` (`name`, `slug`, `created_at`, `updated_at`) VALUES
('Alam', 'alam', NOW(), NOW()),
('Cerita Rakyat', 'cerita-rakyat', NOW(), NOW()),
('Edisi Terbatas', 'edisi-terbatas', NOW(), NOW()),
('Ekonomi Kreatif', 'ekonomi-kreatif', NOW(), NOW()),
('Matematika', 'matematika', NOW(), NOW()),
('Pengembangan Diri', 'pengembangan-diri', NOW(), NOW()),
('Sains', 'sains', NOW(), NOW()),
('Seni Budaya', 'seni-budaya', NOW(), NOW()),
('Tokoh', 'tokoh', NOW(), NOW());

-- 5. BUAT table book_categories (pivot untuk kategori)
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

-- 6. BUAT table book_types (untuk jenis buku)
CREATE TABLE `book_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `book_types_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. INSERT data jenis buku
INSERT INTO `book_types` (`name`, `slug`, `created_at`, `updated_at`) VALUES
('Anak - Anak', 'anak-anak', NOW(), NOW()),
('Fiksi', 'fiksi', NOW(), NOW()),
('Nonfiksi', 'nonfiksi', NOW(), NOW()),
('Pendidikan', 'pendidikan', NOW(), NOW());

-- 8. BUAT table book_book_type (pivot untuk jenis buku)
CREATE TABLE `book_book_type` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `book_type_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `book_book_type_book_id_foreign` (`book_id`),
  KEY `book_book_type_book_type_id_foreign` (`book_type_id`),
  CONSTRAINT `book_book_type_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `book_book_type_book_type_id_foreign` FOREIGN KEY (`book_type_id`) REFERENCES `book_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- SELESAI!
-- Struktur database sudah diupdate
-- =====================================================
