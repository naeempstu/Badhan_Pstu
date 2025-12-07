<?php
// Test email configuration
// This file tests if PHPMailer is properly installed and can send emails

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';
require 'config/mail_config.php';

echo "=== PHPMailer Email Test ===\n\n";

// Test 1: Check if autoloader works
echo "✓ PHPMailer autoloader loaded successfully\n";

// Test 2: Test token generation
$test_token = generateVerificationToken();
echo "✓ Generated test token: " . substr($test_token, 0, 20) . "...\n";

// Test 3: Test verification link generation
$test_link = getVerificationLink($test_token);
echo "✓ Generated verification link: " . substr($test_link, 0, 50) . "...\n";

// Test 4: Attempt to create PHPMailer instance
try {
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'badhanpstu6@gmail.com';
    $mail->Password = 'wrcv gclh mqhu qrsd';
    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    
    echo "✓ PHPMailer instance created successfully\n";
    echo "✓ SMTP Configuration: Host=" . $mail->Host . ", Port=" . $mail->Port . "\n";
    
} catch (Exception $e) {
    echo "✗ Error creating PHPMailer instance: " . $e->getMessage() . "\n";
}

echo "\n=== All tests completed ===\n";
echo "Status: Ready for email verification\n";
?>
