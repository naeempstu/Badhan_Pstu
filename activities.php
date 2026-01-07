<?php session_start(); ?>
<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>কার্যক্রমসমূহ</title>
<link rel="icon" type="image/x-icon" href="picture/badhon.jpeg">
<link rel="stylesheet" href="static/css/index.css">
<link rel="stylesheet" href="static/css/activities.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<?php include 'component/navbar.php'; ?>


<div class="main-content">
    <section class="hero-section">
        <h1>আমাদের কার্যক্রমসমূহ</h1>
        
        
    </section>

    <?php
    include 'db_connect.php';
    $news_items = [];
    $res = $conn->query("SELECT * FROM news WHERE is_published=1 ORDER BY created_at DESC");
    if ($res) {
        while ($row = $res->fetch_assoc()) { $news_items[] = $row; }
    }
    ?>

    <div class="news-container">
    <?php if (empty($news_items)): ?>
        <div class="card"><p>কোন খবর পাওয়া যায়নি। পরে আবার চেক করুন।</p></div>
    <?php else: foreach ($news_items as $n): ?>
        <div class="news-card">
            <img src="<?php echo !empty($n['image']) ? 'Picture/news/'.htmlspecialchars($n['image']) : 'Picture/news1.jpg'; ?>" alt="<?php echo htmlspecialchars($n['title']); ?>">
            <h3><?php echo htmlspecialchars($n['title']); ?></h3>
            <p><?php echo nl2br(htmlspecialchars(strlen($n['content']) > 240 ? substr($n['content'],0,240) . '...' : $n['content'])); ?></p>
            <a href="news_view.php?id=<?php echo $n['id']; ?>" class="read-more">Read More</a>
        </div>
    <?php endforeach; endif; ?>
    </div>

<!-- ================= FOOTER ================= -->
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
                
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        
        <div class="copyright">
            <p>&copy; 2025 BADHAN PSTU UNIT। All Rights Reserved । Design, Development and Maintenance by OMAR SAEED NAEEM.</p>
        </div>
    </div>
</footer>


</body>
</html>