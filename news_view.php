<?php
session_start();
include 'db_connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $conn->prepare("SELECT * FROM news WHERE id = ? AND is_published = 1 LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$news = $res->num_rows ? $res->fetch_assoc() : null;
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $news ? htmlspecialchars($news['title']) : 'নিউজ পাওয়া যায়নি'; ?></title>
   
    <link rel="stylesheet" href="static/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- NAVBAR (same as other pages) -->
<nav class="navbar">
    <div class="logo">
        <img src="Picture/pstu.png" alt="Logo">
    </div>

    <div class="logo">
        <img src="Picture/badhon.jpeg" alt="Logo">
    </div>

    <ul>
        <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
            <a href="index.php">হোম</a>
        </li>
        <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">
            <a href="about.php">আমাদের সম্পর্কে</a>
        </li>
        <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'activities.php' ? 'active' : ''; ?>">
            <a href="activities.php">কার্যক্রমসমূহ</a>
        </li>
        <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'gallery.php' ? 'active' : ''; ?>">
            <a href="gallery.php">গ্যালারি</a>
        </li>
        <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'blog.php' ? 'active' : ''; ?>">
            <a href="blog.php">ব্লগ</a>
        </li>
        <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'notice.php' ? 'active' : ''; ?>">
            <a href="notice.php">নোটিশ</a>
        </li>
        <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">
            <a href="contact.php">যোগাযোগ</a>
        </li>
    </ul>
    <div class="navbar-right">
        <?php if(isset($_SESSION['username'])): ?>
            <a href="dashboard.php" class="btn-login">ড্যাশবোর্ড</a>
            <a href="logout.php" class="btn-donate">লগআউট</a>
        <?php else: ?>
            <a href="login.php" class="btn-login">লগইন</a>
        <?php endif; ?>
    </div>
</nav>

<div class="main-content" style="padding:20px;">
    <?php if (!$news): ?>
        <div class="about-cards">
            <div class="card">
                <h2>নিউজ পাওয়া যায়নি</h2>
                <p>আপনি যে নিউজটি দেখার চেষ্টা করছেন তা পাওয়া যায়নি অথবা এটি প্রকাশ করা হয়নি।</p>
                <p><a href="activities.php">ব্যাক টু কার্যক্রমসমূহ</a></p>
            </div>
        </div>
    <?php else: ?>
        <section class="hero-section">
            <h1><?php echo htmlspecialchars($news['title']); ?></h1>
            <small><?php echo htmlspecialchars($news['created_at']); ?></small>
        </section>

        <div style="max-width:900px; margin:20px auto; background:#fff; padding:18px; border-radius:8px;">
            <?php if (!empty($news['image'])): ?>
                <div style="text-align:center; margin-bottom:12px;"><img src="Picture/news/<?php echo htmlspecialchars($news['image']); ?>" style="max-width:100%; height:auto;"></div>
            <?php endif; ?>
            <div style="color:#333; line-height:1.7;">
                <?php echo nl2br(htmlspecialchars($news['content'])); ?>
            </div>
            <p style="margin-top:12px;"><a href="activities.php" class="btn-back">ফিরে যান</a></p>
        </div>
    <?php endif; ?>
</div>

<!-- Footer (copied from other pages) -->
<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php">হোম</a></li>
                    <li><a href="about.php">আমাদের সম্পর্কে</a></li>
                    <li><a href="activities.php">কার্যক্রমসমূহ</a></li>
                    <li><a href="gallery.php">গ্যালারি</a></li>
                    <li><a href="blog.php">ব্লগ</a></li>
                    <li><a href="notice.php">নোটিশ</a></li>
                    <li><a href="contact.php">যোগাযোগ</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>যোগাযোগ</h3>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> পটুয়াখালী বিজ্ঞান ও প্রযুক্তি বিশ্ববিদ্যালয়, দুমকি, পটুয়াখালী-৮৬৬০</li>
                    <li><i class="fas fa-phone"></i> 01624428661</li>
                    <li><i class="fas fa-envelope"></i> badhan.pstuunit@gmail.com</li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 BADHAN PSTU UNIT। All Rights Reserved । Design, Development and Maintenance by OMAR SAEED NAEEM.</p>
        </div>
    </div>
</footer>


</body>
</html>