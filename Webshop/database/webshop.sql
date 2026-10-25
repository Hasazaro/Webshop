-- Webshop: complete installation (database, tables and one sample product).
-- Import in phpMyAdmin (Import tab) or run: mysql -u root < database/webshop.sql
-- Safe to run again: existing tables and data are not overwritten.

CREATE DATABASE IF NOT EXISTS `web-shop` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `web-shop`;

-- Customers and admins. Passwords are stored as bcrypt hashes (password_hash), never as plain text.
CREATE TABLE IF NOT EXISTS `users` (
  `id`         INT(11)      NOT NULL AUTO_INCREMENT,
  `full_name`  VARCHAR(128) NOT NULL,
  `email`      VARCHAR(255) NOT NULL,
  `password`   VARCHAR(255) NOT NULL,
  `role`       ENUM('customer', 'admin') NOT NULL DEFAULT 'customer',
  `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)          -- the same email address can't register twice
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- `category` matches the numbers in CATEGORIES (includes/config.php).
CREATE TABLE IF NOT EXISTS `products` (
  `id`          INT(11)      NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(100) NOT NULL,
  `description` VARCHAR(255) NOT NULL DEFAULT '',
  `price`       DECIMAL(8,2) NOT NULL,  -- DECIMAL, not FLOAT: no rounding errors with money
  `image`       VARCHAR(255) NOT NULL,  -- file name inside /images, e.g. 'products/a1b2c3.jpg'
  `category`    INT(11)      NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- One row per order...
CREATE TABLE IF NOT EXISTS `orders` (
  `id`         INT(11)       NOT NULL AUTO_INCREMENT,
  `user_id`    INT(11)       NOT NULL,
  `total`      DECIMAL(10,2) NOT NULL,
  `created_at` TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ...and one row per product in that order.
CREATE TABLE IF NOT EXISTS `order_items` (
  `id`           INT(11)      NOT NULL AUTO_INCREMENT,
  `order_id`     INT(11)      NOT NULL,
  `product_id`   INT(11)      NULL,      -- NULL when the product is deleted later
  `product_name` VARCHAR(100) NOT NULL,  -- copied at checkout: the order keeps the name...
  `price`        DECIMAL(8,2) NOT NULL,  -- ...and the price the customer actually paid
  `quantity`     INT(11)      NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`)   REFERENCES `orders` (`id`)   ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- One sample product (only added when the products table is still empty).
-- Add more products through the admin panel.
INSERT INTO `products` (`name`, `description`, `price`, `image`, `category`)
SELECT 'Sinaasappels', 'Sappige handsinaasappels', 2.49, 'orange.png', 1
WHERE NOT EXISTS (SELECT 1 FROM `products`);

-- Make yourself admin: register on the site first, then run this with your own email address:
-- UPDATE `users` SET `role` = 'admin' WHERE `email` = 'jouw@email.nl';
