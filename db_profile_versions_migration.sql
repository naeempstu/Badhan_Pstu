-- Migration: create user_profile_versions table
-- Run this in phpMyAdmin or via MySQL client

CREATE TABLE IF NOT EXISTS `user_profile_versions` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_profile_id` INT(11) NOT NULL,
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
  `changed_by` INT(11) DEFAULT NULL,
  `changed_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_upid` (`user_profile_id`),
  KEY `idx_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


