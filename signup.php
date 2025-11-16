<?php
session_start();
include 'db_connect.php';

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
            // Hash password
            $hashed_password = md5($password);

            // Insert new user
            $insert_sql = "INSERT INTO users (username, email, password, full_name, phone) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("sssss", $username, $email, $hashed_password, $full_name, $phone);

            if ($stmt->execute()) {
                $success = "✅ রেজিস্ট্রেশন সফল! এখন লগইন করুন।";
                // Clear form fields
                $_POST = array();
            } else {
                $error = "রেজিস্ট্রেশন失敗! আবার চেষ্টা করুন।";
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
    <title>রেজিস্ট্রেশন - বাঁধন প্রবিপ্রবি</title>
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