<?php
session_start();
include 'db_connect.php';

// Initialize error variable
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT * FROM users WHERE username=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        //print($user);
        // Check if email is verified
        if ($user['email_verified'] == 1) {
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            //print("success");
            exit();
        } else {
            $error = "⚠️ আপনার ইমেইল এখনও যাচাই করা হয়নি। অনুগ্রহ করে আপনার ইমেইলে পাঠানো যাচাইকরণ লিংকে ক্লিক করুন।";
            //print($error);
        }
    } else {
        $error = "⚠️ ইউজারনেম বা পাসওয়ার্ড ভুল!";
        //print($error);
    }
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>লগইন - বাঁধন পবিপ্রবি</title>
    <link rel="stylesheet" href="static/css/login.css">
   
</head>
<body>

<div class="login-container">
    <h2>লগইন করুন</h2>
    
    <?php if (!empty($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form action="" method="POST">
        <input type="text" name="username" placeholder="ইউজারনেম" required>
        <input type="password" name="password" placeholder="পাসওয়ার্ড" required>
        <button type="submit" name="login">লগইন</button>
    </form>

    <div class="signup-link">
        <p>একাউন্ট নেই? <a href="signup.php">একাউন্ট তৈরি করুন</a></p>
    </div>
</div>

</body>
</html>