-- Add profile fields to users table
-- Run this script to enable profile functionality

USE retail_credit_system;

-- Add email column
ALTER TABLE users ADD COLUMN email VARCHAR(255) NULL AFTER phone;

-- Add profile_picture column
ALTER TABLE users ADD COLUMN profile_picture VARCHAR(500) NULL AFTER email;

-- Add address column
ALTER TABLE users ADD COLUMN address TEXT NULL AFTER profile_picture;

-- Add bio column
ALTER TABLE users ADD COLUMN bio TEXT NULL AFTER address;

-- Update existing records to have default values
UPDATE users SET email = CONCAT('user', user_id, '@mercy.shop') WHERE email IS NULL OR email = '';

SELECT 'User profile columns added successfully!' as status;
