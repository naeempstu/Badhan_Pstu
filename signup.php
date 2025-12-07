<?php
session_start();
include 'db_connect.php';
include 'config/mail_config.php';

// Initialize variables
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);

    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($full_name)) {
        $error = "সব প্রয়োজনীয় তথ্য প্রদান করুন!";
    } elseif ($password !== $confirm_password) {
        $error = "পাসওয়ার্ড মিলেনি!";
    } elseif (strlen($password) < 6) {
        $error = "পাসওয়ার্ড অন্তত ৬ অক্ষরের হতে হবে!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "সঠিক ইমেইল প্রদান করুন!";
    } else {
        // Check if username or email already exists
        $check_sql = "SELECT id FROM users WHERE username=? OR email=?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "ইউজারনেম বা ইমেইল ইতিমধ্যে ব্যবহৃত!";
        } else {
            // Generate verification token and expiry
            $verification_token = generateVerificationToken();
            $token_expiry = date('Y-m-d H:i:s', strtotime('+24 hours'));
            
            // Hash password
            $hashed_password = md5($password);

            // Insert new user with unverified email
            $insert_sql = "INSERT INTO users (username, email, email_verified, verification_token, token_expiry, password, full_name, phone) VALUES (?, ?, 0, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("sssssss", $username, $email, $verification_token, $token_expiry, $hashed_password, $full_name, $phone);

            if ($stmt->execute()) {
                // Generate verification link
                $verification_link = getVerificationLink($verification_token);

                // Send verification email
                if (sendVerificationEmail($email, $full_name, $verification_link)) {
                    $success = "✅ রেজিস্ট্রেশন সফল! আপনার ইমেইলে একটি যাচাইকরণ লিংক পাঠানো হয়েছে। অনুগ্রহ করে আপনার ইনবক্স চেক করুন।";
                    // Clear form fields
                    $_POST = array();
                } else {
                    // Delete user if email sending fails
                    $delete_sql = "DELETE FROM users WHERE username=?";
                    $stmt = $conn->prepare($delete_sql);
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    
                    $error = "ইমেইল পাঠাতে সমস্যা হয়েছে। আবার চেষ্টা করুন।";
                }
            } else {
                $error = "রেজিস্ট্রেশন ব্যর্থ! আবার চেষ্টা করুন।";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>রেজিস্ট্রেশন - বাঁধন পবিপ্রবি</title>
    <link rel="stylesheet" href="static/css/signup.css">
  
</head>
<body>

<div class="container">
    <h2 style="text-align: center; color: #333;">একাউন্ট তৈরি করুন</h2>
    
    <?php if (!empty($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if (!empty($success)): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="full_name">পূর্ণ নাম (English)*</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo isset($_POST['full_name']) ? $_POST['full_name'] : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="username">ইউজারনেম *</label>
            <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="email">ইমেইল *</label>
            <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="phone">ফোন নম্বর</label>
            <input type="tel" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>">
        </div>

        <div class="form-group">
            <label for="password">পাসওয়ার্ড *</label>
            <input type="password" id="password" name="password" required>
            <small>পাসওয়ার্ড অন্তত ৬ অক্ষরের হতে হবে</small>
        </div>

        <div class="form-group">
            <label for="confirm_password">পাসওয়ার্ড নিশ্চিত করুন *</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>

        <button type="submit" name="signup">রেজিস্ট্রেশন</button>
    </form>

    <div class="login-link">
        <p>ইতিমধ্যে একাউন্ট আছে? <a href="login.php">লগইন করুন</a></p>
    </div>
</div>

</body>
</html>