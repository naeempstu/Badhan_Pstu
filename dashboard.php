<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ড্যাশবোর্ড - বাঁধন পবিপ্রবি</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f4f4f4;
        }
        .dashboard {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .welcome {
            text-align: center;
            margin-bottom: 30px;
        }
        .logout {
            text-align: center;
            margin-top: 30px;
        }
        .logout a {
            color: #dc3545;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="dashboard">
    <div class="welcome">
        <h1>স্বাগতম, <?php echo $_SESSION['username']; ?>!</h1>
        <p>আপনি সফলভাবে লগইন করেছেন।</p>
    </div>
    
    <div class="content">
        <h3>ড্যাশবোর্ড কন্টেন্ট</h3>
        <p>এখানে আপনার অ্যাপ্লিকেশনের মূল কন্টেন্ট থাকবে।</p>
    </div>

    <div class="logout">
        <a href="logout.php">লগআউট</a>
    </div>
</div>

</body>
</html>