-- Run this once if your `users` table already exists (it adds the role column).

ALTER TABLE `users`
  ADD COLUMN `role` ENUM('customer', 'admin') NOT NULL DEFAULT 'customer' AFTER `password`;

-- Make yourself admin: register on the site first, then change the email below and run this.
UPDATE `users` SET `role` = 'admin' WHERE `email` = 'jouw@email.nl';
