<?php session_start(); ?>
<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Latest News</title>
<link rel="icon" type="image/x-icon" href="picture/badhon.jpeg">
<link rel="stylesheet" href="static/css/index.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- ================= NAVBAR ================= -->
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

<section class="latest-news">
    <h2><span>Latest</span> News</h2>

    <div class="news-container">

    <!-- Card 1 -->
        <div class="news-card">
            <img src="Picture/news5.jpg" alt="News 5">
            <h3>বাঁধন, পটুয়াখালী বিজ্ঞান প্রযুক্তি বিশ্ববিদ্যালয় ইউনিট (বরিশাল জোন) এর আয়োজনে ইনডোর গেমস ও বাঁধন প্রিমিয়ার লীগ ২০২৫</h3>
            <p>উৎসবমুখর পরিবেশে অনুষ্ঠিত হলো বাঁধন পবিপ্রবি ইউনিটের ইনডোর গেমস, যেখানে শিক্ষার্থীদের অংশগ্রহণে মুখর হয়ে উঠেছিল পুরো আয়োজন। ছেলেদের ক্রিকেট টুর্নামেন্টে দারুণ নৈপুণ্য প্রদর্শন করে শহীদ জিয়াউর রহমান হল জয়ী হয়।

অভিনন্দন সকল অংশগ্রহণকারী এবং বিজয়ী দলকে!</p>

            <a href="#" class="read-more">Read More</a>
        </div>

       <!-- Card 1 -->
        <div class="news-card">
            <img src="Picture/news6.jpg" alt="News 6">
            <h3>বাঁধন, পটুয়াখালী বিজ্ঞান প্রযুক্তি বিশ্ববিদ্যালয় ইউনিট (বরিশাল জোন) কার্যকরী পরিষদ-২৫ এর পক্ষ থেকে  ২০২৪-২৫ সেশনের কৃষি গুচ্ছ ভর্তি পরীক্ষায় ভর্তিচ্ছু শিক্ষার্থীদের সহযোগিতার জন্য হেল্পডেস্ক দেওয়া হয় </h3>
            <p>বাঁধন, পবিপ্রবি ইউনিট (বরিশাল জোন) এর কার্যকরী পরিষদ ২০২৫ এর পক্ষ থেকে শুভেচ্ছা গ্রহণ করবেন। ২০২৪-২৫ সেশনের কৃষি গুচ্ছ ভর্তি পরীক্ষায় ভর্তিচ্ছু শিক্ষার্থীদের সহযোগিতার জন্য বাঁধন, পবিপ্রবি ইউনিট (বরিশাল জোন) এর পক্ষ থেকে  হেল্পডেস্ক দেওয়া হয়। যেখানে শিক্ষার্থীদের ব্যাগ ও প্রয়োজনীয় জিনিসপত্র রাখার ব্যবস্থা করা হয়।  একই সাথে বিনামূল্যে রক্তের গ্রুপ নির্ণয়ের আয়োজন করা হয়।</p>

            <a href="#" class="read-more">Read More</a>
        </div>
        
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