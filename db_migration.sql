-- Add email verification columns to users table
-- Run this SQL in your database to add the required fields

ALTER TABLE users ADD COLUMN email_verified TINYINT(1) DEFAULT 0 AFTER email;
ALTER TABLE users ADD COLUMN verification_token VARCHAR(255) NULL AFTER email_verified;
ALTER TABLE users ADD COLUMN token_expiry DATETIME NULL AFTER verification_token;

-- Create an index for faster token lookups
CREATE INDEX idx_verification_token ON users(verification_token);
