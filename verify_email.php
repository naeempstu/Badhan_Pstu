<?php
session_start();
include 'db_connect.php';

$error = "";
$success = "";
$verified = false;

if (isset($_GET['token'])) {
    $token = trim($_GET['token']);
    
    // Check if token exists and is not expired
    $sql = "SELECT id, email, full_name, token_expiry FROM users WHERE verification_token=? AND email_verified=0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Check if token has expired
        $current_time = new DateTime();
        $expiry_time = new DateTime($user['token_expiry']);
        
        if ($current_time <= $expiry_time) {
            // Token is valid, update user to verified
            $update_sql = "UPDATE users SET email_verified=1, verification_token=NULL, token_expiry=NULL WHERE id=?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("i", $user['id']);
            
            if ($stmt->execute()) {
                $success = "✅ ইমেইল যাচাইকরণ সফল! এখন আপনি লগইন করতে পারবেন।";
                $verified = true;
            } else {
                $error = "যাচাইকরণ প্রক্রিয়ায় ত্রুটি হয়েছে। আবার চেষ্টা করুন।";
            }
        } else {
            $error = "⏰ আপনার যাচাইকরণ লিংকের সময় শেষ হয়ে গেছে। অনুগ্রহ করে পুনরায় রেজিস্ট্রেশন করুন।";
        }
    } else {
        $error = "❌ অবৈধ যাচাইকরণ লিংক বা ইমেইল ইতিমধ্যে যাচাই করা হয়েছে।";
    }
} else {
    $error = "যাচাইকরণ লিংক পাওয়া যায়নি।";
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ইমেইল যাচাইকরণ - বাঁধন প্রবিপ্রবি</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 50px 40px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .container h2 {
            color: #333;
            margin-bottom: 30px;
            font-size: 1.8rem;
        }

        .icon {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .success {
            background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
            color: #155724;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #28a745;
        }

        .error {
            background: linear-gradient(135deg, #fa8072 0%, #ff6b6b 100%);
            color: #721c24;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #e63946;
        }

        .message-text {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .button-group {
            margin-top: 30px;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        a.btn {
            display: inline-block;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #e63946, #d00000);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(230, 57, 70, 0.4);
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #333;
            border: 2px solid #e63946;
        }

        .btn-secondary:hover {
            background: #e63946;
            color: white;
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #e63946;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .footer-text {
            color: #999;
            font-size: 0.85rem;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>

<div class="container">
    <?php if (!empty($success)): ?>
        <div class="icon">✅</div>
        <h2>যাচাইকরণ সফল!</h2>
        <div class="success">
            <p class="message-text"><?php echo htmlspecialchars($success); ?></p>
        </div>
        <div class="button-group">
            <a href="login.php" class="btn btn-primary">লগইন করুন</a>
            <a href="index.php" class="btn btn-secondary">হোমে ফিরুন</a>
        </div>

    <?php elseif (!empty($error)): ?>
        <div class="icon">❌</div>
        <h2>যাচাইকরণ ব্যর্থ</h2>
        <div class="error">
            <p class="message-text"><?php echo htmlspecialchars($error); ?></p>
        </div>
        <div class="button-group">
            <a href="signup.php" class="btn btn-primary">পুনরায় রেজিস্ট্রেশন করুন</a>
            <a href="index.php" class="btn btn-secondary">হোমে ফিরুন</a>
        </div>
    <?php else: ?>
        <div class="loader"></div>
        <h2>প্রক্রিয়াধীন...</h2>
        <p>আপনার ইমেইল যাচাই করা হচ্ছে...</p>
    <?php endif; ?>

    <div class="footer-text">
        <p>© 2025 BADHAN PSTU। সকল অধিকার সংরক্ষিত।</p>
    </div>
</div>

</body>
</html>
