<?php
// Email Functions using PHPMailer

require_once __DIR__ . '/../vendor/autoload.php'; // Composer autoload
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Send verification email to user
 */
function sendVerificationEmail($email, $username, $verification_token) {
    $config = require __DIR__ . '/../config/email_config.php';
    
    // Get the base URL (adjust if your site is in a subdirectory)
    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . 
                "://" . $_SERVER['HTTP_HOST'] . 
                dirname($_SERVER['PHP_SELF']);
    $base_url = rtrim($base_url, '/');
    
    $verification_link = $base_url . "/verify_email.php?token=" . $verification_token;
    
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = $config['smtp_host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['smtp_username'];
        $mail->Password = $config['smtp_password'];
        $mail->SMTPSecure = $config['smtp_secure'];
        $mail->Port = $config['smtp_port'];
        $mail->CharSet = 'UTF-8';
        
        // Recipients
        $mail->setFrom($config['from_email'], $config['from_name']);
        $mail->addAddress($email, $username);
        $mail->addReplyTo($config['reply_to'], $config['from_name']);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'ইমেইল যাচাইকরণ - BADHAN PSTU UNIT';
        
        $mail->Body = '
        <!DOCTYPE html>
        <html lang="bn">
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #e63946, #d00000); color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px; }
                .button { display: inline-block; padding: 12px 30px; background: #e63946; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
                .footer { text-align: center; margin-top: 20px; color: #666; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2>বাঁধন প্রবিপ্রবি ইউনিট</h2>
                </div>
                <div class="content">
                    <h3>স্বাগতম ' . htmlspecialchars($username) . '!</h3>
                    <p>আপনার একাউন্ট সফলভাবে তৈরি হয়েছে। আপনার ইমেইল যাচাই করতে নিচের বাটনে ক্লিক করুন:</p>
                    <p style="text-align: center;">
                        <a href="' . $verification_link . '" class="button">ইমেইল যাচাই করুন</a>
                    </p>
                    <p>অথবা নিচের লিঙ্কটি কপি করে ব্রাউজারে খুলুন:</p>
                    <p style="word-break: break-all; color: #666; font-size: 12px;">' . $verification_link . '</p>
                    <p><strong>দ্রষ্টব্য:</strong> এই লিঙ্ক ২৪ ঘণ্টা বৈধ থাকবে।</p>
                </div>
                <div class="footer">
                    <p>© 2025 BADHAN PSTU UNIT। All Rights Reserved</p>
                </div>
            </div>
        </body>
        </html>
        ';
        
        $mail->AltBody = "স্বাগতম $username!\n\nআপনার ইমেইল যাচাই করতে নিচের লিঙ্কে ক্লিক করুন:\n$verification_link\n\nএই লিঙ্ক ২৪ ঘণ্টা বৈধ থাকবে।";
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email sending failed: " . $mail->ErrorInfo);
        return false;
    }
}

/**
 * Generate a secure verification token
 */
function generateVerificationToken() {
    return bin2hex(random_bytes(32)); // 64 character hex string
}

?>

