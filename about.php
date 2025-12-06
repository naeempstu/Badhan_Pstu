<?php session_start(); ?>
<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>আমাদের সম্পর্কে</title>
<link rel="icon" type="image/x-icon" href="picture/badhon.jpeg">
<link rel="stylesheet" href="static/css/index.css">
<link rel="stylesheet" href="static/css/about.css">
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

<div class="main-content">
    <section class="hero-section">
        <h1>আমাদের সম্পর্কে</h1>
        <p>বাঁধন প্রবিপ্রবি ইউনিট একটি সামাজিক ও অরাজনৈতিক সংগঠন যা পটুয়াখালী বিজ্ঞান ও প্রযুক্তি বিশ্ববিদ্যালয়ে সক্রিয়ভাবে কাজ করে যাচ্ছে ।</p>
    </section>

    <div class="about-cards">
        <div class="card">
            <h3>বাঁধনের যাত্রা </h3>
            <p>বাঁধনের যাত্রা শুরু হয় ১৯৯৭ সালে ঢাকা বিশ্ববিদ্যালয় থেকে, স্বেচ্ছায় বিনামূল্যের রক্তদানকে একটি সামাজিক আন্দোলনে রূপ দেওয়ার উদ্দেশ্যে।</p>
            <br>
            <h3>(প্রবিপ্রবি ইউনিট)</h3>
            <p>বাধন প্রবিপ্রবি ইউনিটের যাত্রা শুরু হয় ২০০৮ সাল থেকে।</p>
        </div>
        
        <div class="card">
        <h3>আমাদের মিশন</h3>
            <p>
                <li>সমাজের মানুষের মধ্যে স্বেচ্ছায় রক্তদানের গুরুত্ব ছড়িয়ে দেওয়া।</li>

                <li>নিয়মিত ও স্বতঃস্ফূর্ত রক্তদানে মানুষকে উৎসাহিত করে একটি সক্রিয় রক্তদাতা নেটওয়ার্ক গড়ে তোলা।</li>


                <li>জরুরি মুহূর্তে দ্রুত রক্তের ব্যবস্থা নিশ্চিত করতে সংগঠিত ও প্রশিক্ষিত স্বেচ্ছাসেবক দল তৈরি করা।</li>


                <li>রক্তদান সম্পর্কিত ভয়, ভুল ধারণা দূর করতে স্বাস্থ্যসচেতনতা কর্মসূচি পরিচালনা করা।</li>


                <li>স্বাস্থ্য, পুষ্টি ও রোগ প্রতিরোধ বিষয়ে জনসচেতনতা বৃদ্ধি করা।</li>


<li>দুর্যোগ, দুর্ঘটনা সময় সেবা প্রদান করা।</li></p>
</div>
           
        <div class="card">
        <h3>আমাদের ভিশন</h3>
            <p>স্বেচ্ছায় রক্তদানকে সামাজিক আন্দোলনে পরিণত করে একটি মানবিক, সুস্থ, সচেতন ও স্বাস্থ্যসম্মত সমাজ গঠন করা।</p>
        
        </div>
    </div>

    <section class="team-section">
        <h2>আমাদের টিম</h2>
        <div class="team-grid">
            <div class="team-member">
                <h4>সভাপতি</h4>
                <p>মোহাইমিন আজিম তাসিন</p>
            </div>
            <div class="team-member">
                <h4>সাধারণ সম্পাদক</h4>
                <p>মারুফ হাসান</p>
            </div>
            <div class="team-member">
                <h4>জোনাল প্রতিনিধি</h4>
                <p>মেহেদী হাসান ইমন</p>
            </div>
            <div class="team-member">
                <h4>ডিজাইনার ও ডেভেলপার</h4>
                <p>ওমর সাঈদ নাঈম</p>
            </div>
            

            
        </div>
    </section>
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