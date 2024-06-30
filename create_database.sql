CREATE DATABASE IF NOT EXISTS `freepost`;
USE `freepost`;

DROP TABLE IF EXISTS `files`;
DROP TABLE IF EXISTS `modules`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('user', 'admin') NOT NULL
);

CREATE TABLE IF NOT EXISTS modules (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `brief_description` TEXT,
    `description` TEXT,
    `downloads_count` INT UNSIGNED DEFAULT 0,
    `status` ENUM('unchecked', 'depends', 'not depends') NOT NULL,
    `user_id` INT,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS files (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `module_id` INT,
    `file_name` VARCHAR(255) NOT NULL,
    `file_path` VARCHAR(255) NOT NULL,
    FOREIGN KEY (`module_id`) REFERENCES `modules`(`id`) ON DELETE CASCADE
);
