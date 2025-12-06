<?php
// Email Configuration for PHPMailer
// Update these settings with your email credentials

return [
    'smtp_host' => 'smtp.gmail.com',  // Gmail SMTP server (change if using different provider)
    'smtp_port' => 587,                // TLS port
    'smtp_secure' => 'tls',             // 'tls' or 'ssl'
    'smtp_username' => 'your-email@gmail.com',  // Your email address
    'smtp_password' => 'your-app-password',    // Your app password (not regular password)
    'from_email' => 'your-email@gmail.com',   // Sender email
    'from_name' => 'BADHAN PSTU UNIT',         // Sender name
    'reply_to' => 'badhan.pstuunit@gmail.com' // Reply-to email
];

/*
 * For Gmail:
 * 1. Enable 2-Step Verification on your Google account
 * 2. Generate an App Password: https://myaccount.google.com/apppasswords
 * 3. Use that App Password in smtp_password above
 * 
 * For other email providers, update smtp_host and smtp_port accordingly:
 * - Outlook: smtp-mail.outlook.com, port 587
 * - Yahoo: smtp.mail.yahoo.com, port 587
 * - Custom SMTP: Check with your hosting provider
 */
?>

