<?php
// config/mail_config.php - PHPMailer Configuration

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

function sendVerificationEmail($to_email, $to_name, $verification_link) {
    try {
        $mail = new PHPMailer(true);
        
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'badhanpstu6@gmail.com';
        $mail->Password = 'wrcv gclh mqhu qrsd'; // App-specific password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email headers
        $mail->setFrom('badhanpstu6@gmail.com', 'BADHAN PSTU UNIT');
        $mail->addAddress($to_email, $to_name);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        // Email subject and body
        $mail->Subject = 'BADHAN PSTU UNIT - ইমেইল যাচাইকরণ / Email Verification';
        
        $mail->Body = '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; background-color: #f5f5f5; padding: 20px; border-radius: 10px;">
            <div style="background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <h2 style="color: #e63946; text-align: center; margin-bottom: 20px;">BADHAN PSTU UNIT</h2>
                
                <h3 style="color: #333; margin-bottom: 15px;">স্বাগতম ' . htmlspecialchars($to_name) . '!</h3>
                
                <p style="color: #666; line-height: 1.6; margin-bottom: 15px;">
                    আপনার অ্যাকাউন্ট যাচাই করতে নীচের লিংকে ক্লিক করুন:
                </p>
                
                <p style="color: #666; line-height: 1.6; margin-bottom: 20px;">
                    Please click the link below to verify your email address:
                </p>
                
                <div style="text-align: center; margin: 30px 0;">
                    <a href="' . $verification_link . '" style="
                        background-color: #e63946;
                        color: white;
                        padding: 12px 30px;
                        text-decoration: none;
                        border-radius: 5px;
                        display: inline-block;
                        font-weight: bold;
                        font-size: 16px;
                    ">ইমেইল যাচাই করুন / Verify Email</a>
                </div>
                
                <p style="color: #999; font-size: 12px; text-align: center; margin-top: 20px; border-top: 1px solid #eee; padding-top: 15px;">
                    এই লিংকটি ২৪ ঘণ্টার জন্য বৈধ।<br>
                    This link is valid for 24 hours.
                </p>
                
                <p style="color: #999; font-size: 12px; text-align: center; margin-top: 10px;">
                    © 2025 BADHAN PSTU UNIT। All Rights Reserved
                </p>
            </div>
        </div>
        ';

        // Alternative plain text version
        $mail->AltBody = "
        স্বাগতম $to_name!
        
        আপনার অ্যাকাউন্ট যাচাই করতে এই লিংকটি ভিজিট করুন:
        $verification_link
        
        এই লিংকটি ২৪ ঘণ্টার জন্য বৈধ।
        © 2025 BADHAN PSTU UNIT
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Email sending failed: " . $mail->ErrorInfo);
        return false;
    }
}

function generateVerificationToken() {
    return bin2hex(random_bytes(32));
}

function getVerificationLink($token) {
    // Get the base URL
    if (isset($_SERVER['HTTP_HOST'])) {
        $base_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    } else {
        // Fallback for CLI or non-web context
        $base_url = "http://localhost/badhon_pstu";
    }
    return $base_url . "/verify_email.php?token=" . urlencode($token);
}
?>
