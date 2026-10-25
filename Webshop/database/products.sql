-- Products table, as used by the shop and the admin panel.
-- `category` matches the numbers in CATEGORIES (includes/config.php).

CREATE TABLE IF NOT EXISTS `products` (
  `id`          INT(11)       NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(100)  NOT NULL,
  `description` VARCHAR(255)  NOT NULL DEFAULT '',
  `price`       DECIMAL(8,2)  NOT NULL,   -- DECIMAL, not FLOAT: no rounding errors with money
  `image`       VARCHAR(255)  NOT NULL,   -- file name inside /images, e.g. 'products/a1b2c3.jpg'
  `category`    INT(11)       NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
