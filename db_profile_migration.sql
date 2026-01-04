

CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `full_name` VARCHAR(150) DEFAULT NULL,
  `dob` DATE DEFAULT NULL,
  `gender` ENUM('Male','Female','Other') DEFAULT NULL,
  `blood_group` VARCHAR(10) DEFAULT NULL,
  `phone` VARCHAR(30) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `city` VARCHAR(100) DEFAULT NULL,
  `state` VARCHAR(100) DEFAULT NULL,
  `postal_code` VARCHAR(20) DEFAULT NULL,
  `emergency_contact` VARCHAR(50) DEFAULT NULL,
  `bio` TEXT DEFAULT NULL,
  `photo` VARCHAR(255) DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_unique` (`user_id`),
  KEY `fk_user_idx` (`user_id`),
  CONSTRAINT `fk_user_profiles_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
