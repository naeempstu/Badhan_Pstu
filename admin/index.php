<?php
require_once '../includes/admin_auth.php';
require_once '../db_connect.php';

// Get counts
$counts = [
    'notices' => 0,
    'news' => 0,
    'gallery' => 0,
];

$res = $conn->query("SELECT COUNT(*) as c FROM notices");
if ($res) { $counts['notices'] = $res->fetch_assoc()['c']; }
$res = $conn->query("SELECT COUNT(*) as c FROM news");
if ($res) { $counts['news'] = $res->fetch_assoc()['c']; }
$res = $conn->query("SELECT COUNT(*) as c FROM gallery");
if ($res) { $counts['gallery'] = $res->fetch_assoc()['c']; }

?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - বাঁধন পবিপ্রবি</title>
    <link rel="stylesheet" href="../static/css/dashboard.css">
    <style>
        .admin-actions { display: grid; grid-template-columns: repeat(auto-fit,minmax(240px,1fr)); gap:16px; margin-top:20px; }
        .admin-card { background:#fff; border:1px solid #f1f5f9; padding:16px; border-radius:8px; }
        .admin-card h3 { margin:0 0 8px 0; color:#b91c1c; }
        .admin-card p { margin:0 0 12px 0; color:#6b7280; }
        .admin-card a.btn { display:inline-block; padding:8px 14px; background:#e63946; color:#fff; border-radius:6px; text-decoration:none; }
    </style>
</head>
<body class="dashboard-body">
<div class="dash-wrapper">
    <aside class="dash-sidebar">
        <h3>অ্যাডমিন প্যানেল</h3>
        <ul>
            <li><a href="index.php" class="active">ড্যাশবোর্ড</a></li>
            <li><a href="notices.php">নোটিশ ব্যবস্থাপনা</a></li>
            <li><a href="news.php">নিউজ ব্যবস্থাপনা</a></li>
            <li><a href="gallery.php">গ্যালারি ব্যবস্থাপনা</a></li>
            <li><a href="../dashboard.php">ব্যবহারকারী ড্যাশবোর্ড</a></li>
            <li><a href="../logout.php">লগআউট</a></li>
        </ul>
    </aside>

    <main class="dash-main">
        <div class="welcome-section">
            <h1>অ্যাডমিন, স্বাগতম!</h1>
            <p>আপনি এখানে সাইট কন্টেন্ট (নোটিশ, নিউজ, গ্যালারি) পরিচালনা করতে পারবেন।</p>
        </div>

        <h2>দ্রুত অ্যাক্সেস</h2>
        <div class="admin-actions">
            <div class="admin-card">
                <h3>নোটিশ</h3>
                <p>মোট নোটিশ: <?php echo $counts['notices']; ?></p>
                <a class="btn" href="notices.php">পরিচালনা করুন</a>
            </div>

            <div class="admin-card">
                <h3>নিউজ</h3>
                <p>মোট নিউজ: <?php echo $counts['news']; ?></p>
                <a class="btn" href="news.php">পরিচালনা করুন</a>
            </div>

            <div class="admin-card">
                <h3>গ্যালারি</h3>
                <p>মোট ছবি: <?php echo $counts['gallery']; ?></p>
                <a class="btn" href="gallery.php">পরিচালনা করুন</a>
            </div>
        </div>

    </main>
</div>
</body>
</html>