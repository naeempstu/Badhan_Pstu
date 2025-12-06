# Email Verification Setup Guide

## Step 1: Install PHPMailer via Composer

Run this command in your project root directory:

```bash
composer require phpmailer/phpmailer
```

If you don't have Composer installed, download it from: https://getcomposer.org/

## Step 2: Run Database Migration

Execute the SQL queries in your database to add the new columns:

```sql
ALTER TABLE users ADD COLUMN email_verified TINYINT(1) DEFAULT 0 AFTER email;
ALTER TABLE users ADD COLUMN verification_token VARCHAR(255) NULL AFTER email_verified;
ALTER TABLE users ADD COLUMN token_expiry DATETIME NULL AFTER verification_token;

CREATE INDEX idx_verification_token ON users(verification_token);
```

Or import the `db_migration.sql` file through phpMyAdmin.

## Step 3: File Structure

Your updated file structure should look like:

```
badhon_pstu/
├── config/
│   ├── email_config.php (existing)
│   └── mail_config.php (NEW - for PHPMailer)
├── vendor/ (NEW - created by Composer)
│   └── autoload.php
├── signup.php (UPDATED)
├── login.php (UPDATED)
├── verify_email.php (NEW)
├── db_migration.sql (NEW)
├── db_connect.php (existing)
└── ... other files
```

## Step 4: Gmail App Password

The credentials are already configured in `config/mail_config.php`:
- Email: omarsaeed3988@gmail.com
- App Password: emqy yubv ucbj gqvg

**Important**: Make sure to enable "Less secure apps" or use Gmail App Passwords feature.

## Step 5: Test the Flow

1. Go to signup page
2. Fill in the registration form
3. Check the email (omarsaeed3988@gmail.com will receive it)
4. Click the verification link in the email
5. User will be verified and can now login

## Features Implemented

✅ Email verification token generation
✅ 24-hour token expiry
✅ Beautiful email template (Bilingual - Bengali/English)
✅ Verification status check in login
✅ Responsive verification page
✅ User-friendly error messages
✅ Automatic user deletion if email sending fails
✅ Index on verification_token for faster lookups

## Database Changes

### Updated `users` table structure:

```
Column              | Type        | Purpose
--------------------|-------------|---------------------
id                 | int(11)     | Primary Key
username           | varchar(100)| Username
email              | varchar(150)| User Email
email_verified     | tinyint(1)  | Verification Status (0/1)
verification_token | varchar(255)| Unique verification token
token_expiry       | datetime    | Token expiration time
password           | varchar(255)| Password hash
full_name          | varchar(150)| Full name
phone              | varchar(30) | Phone number
created_at         | timestamp   | Account creation time
```

## Troubleshooting

If emails are not sending:

1. Check if Composer installed PHPMailer correctly:
   ```bash
   composer install
   ```

2. Verify Gmail credentials in `config/mail_config.php`

3. Check server error logs for detailed error messages

4. Ensure your server allows outgoing SMTP connections (port 587)

5. Check phpMyAdmin to confirm new columns were added to users table

## Security Notes

- Tokens are generated using cryptographically secure random bytes
- Tokens expire after 24 hours
- Old tokens are cleared after verification
- Email verification required before login
- All SQL queries use prepared statements (protection against SQL injection)

## Support

For issues or questions, contact: omarsaeed3988@gmail.com
