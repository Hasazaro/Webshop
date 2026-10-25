-- Orders: one row per order, plus one row per product in that order.
-- Import after users.sql and products.sql (the foreign keys point to those tables).

CREATE TABLE IF NOT EXISTS `orders` (
  `id`         INT(11)      NOT NULL AUTO_INCREMENT,
  `user_id`    INT(11)      NOT NULL,
  `total`      DECIMAL(10,2) NOT NULL,
  `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `order_items` (
  `id`           INT(11)      NOT NULL AUTO_INCREMENT,
  `order_id`     INT(11)      NOT NULL,
  `product_id`   INT(11)      NULL,           -- NULL when the product is deleted later
  `product_name` VARCHAR(100) NOT NULL,       -- copied at checkout: the order keeps the name...
  `price`        DECIMAL(8,2) NOT NULL,       -- ...and the price the customer actually paid
  `quantity`     INT(11)      NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`)   REFERENCES `orders` (`id`)   ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
