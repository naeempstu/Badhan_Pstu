# Email Verification Setup Guide - Updated

## ✅ Configuration: BADHAN PSTU UNIT

Your email verification system is now fully configured with:
- **Email:** badhanpstu6@gmail.com
- **App Name:** BADHAN PSTU UNIT
- **App Password:** wrcv gclh mqhu qrsd

---

## Step 1: Database Migration (IMPORTANT!)

Execute these SQL queries in phpMyAdmin to add email verification columns:

```sql
ALTER TABLE users ADD COLUMN email_verified TINYINT(1) DEFAULT 0 AFTER email;
ALTER TABLE users ADD COLUMN verification_token VARCHAR(255) NULL AFTER email_verified;
ALTER TABLE users ADD COLUMN token_expiry DATETIME NULL AFTER verification_token;

CREATE INDEX idx_verification_token ON users(verification_token);
```

### How to Run:
1. Go to http://localhost/phpmyadmin
2. Select database: `badhon_pstu`
3. Click **SQL** tab
4. Paste the SQL above
5. Click **Go**

## Step 2: Verify Configuration

Run this command in terminal:

```bash
cd C:\xampp\htdocs\badhon_pstu
C:\xampp\php\php.exe test_email_config.php
```

Expected output:
```
✓ PHPMailer autoloader loaded successfully
✓ Generated test token: 70c99218bacb661672c7...
✓ Generated verification link: http://localhost/badhon_pstu/verify_email.php?token=...
✓ PHPMailer instance created successfully
✓ SMTP Configuration: Host=smtp.gmail.com, Port=587

=== All tests completed ===
Status: Ready for email verification
```

## Step 3: Test Email Verification

### Register a test user:
1. Go to http://localhost/badhon_pstu/signup.php
2. Fill the form and submit
3. Check email inbox for verification link
4. Click the verification link to complete

## Step 4: File Structure

```
badhon_pstu/
├── config/
│   └── mail_config.php ........... PHPMailer config (updated) ✓
├── vendor/
│   └── phpmailer/ ............... PHPMailer library ✓
├── signup.php ................... Registration form ✓
├── login.php .................... Login (checks email_verified) ✓
├── verify_email.php ............. Email verification page ✓
├── test_email_config.php ........ Configuration tester ✓
├── db_migration.sql ............. Database changes ✓
├── composer.json ................ Composer manifest ✓
└── README.md .................... This file
```

## Features Implemented

✅ Email verification token generation (256-bit secure random)
✅ 24-hour token expiry
✅ Beautiful bilingual email template (Bengali/English)
✅ Verification status check in login
✅ Responsive verification page
✅ User-friendly error messages
✅ Automatic user deletion if email sending fails
✅ Index on verification_token for faster lookups
✅ Prepared statements for SQL injection protection

## Updated Database Structure

```
Column              | Type        | Purpose
--------------------|-------------|---------------------
id                 | int(11)     | Primary Key
username           | varchar(100)| Username
email              | varchar(150)| User Email
email_verified     | tinyint(1)  | Verification Status (0/1) ← NEW
verification_token | varchar(255)| Unique token ← NEW
token_expiry       | datetime    | Token expiry time ← NEW
password           | varchar(255)| Password hash
full_name          | varchar(150)| Full name
phone              | varchar(30) | Phone number
created_at         | timestamp   | Account creation time
```

## Email Configuration

- **Sender Email:** badhanpstu6@gmail.com
- **Sender Name:** BADHAN PSTU UNIT
- **SMTP Server:** smtp.gmail.com
- **Port:** 587
- **Encryption:** STARTTLS
- **Email Subject:** BADHAN PSTU UNIT - ইমেইল যাচাইকরণ / Email Verification

## Troubleshooting

If emails are not sending:

1. **Verify database columns added:**
   ```sql
   DESCRIBE users;
   ```
   Look for: `email_verified`, `verification_token`, `token_expiry`

2. **Test configuration:**
   ```bash
   C:\xampp\php\php.exe test_email_config.php
   ```

3. **Check Gmail credentials:**
   - Email: badhanpstu6@gmail.com
   - Password: wrcv gclh mqhu qrsd (exact copy)
   - Ensure 2FA is enabled on the account

4. **Check error logs:**
   - XAMPP: `C:/xampp/apache/logs/error.log`
   - PHP: Check php.ini error_log path

5. **Test SMTP connection:**
   - Ensure server allows port 587 outgoing

## Security Notes

- Tokens are generated using cryptographically secure random bytes
- Tokens expire after 24 hours
- Old tokens are cleared after verification
- Email verification required before login
- All SQL queries use prepared statements (protection against SQL injection)

## Support

For issues or questions, contact: omarsaeed3988@gmail.com
