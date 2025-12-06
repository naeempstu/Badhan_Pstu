<?php session_start(); ?>
<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ব্লগ</title>
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
        <h1>ব্লগ</h1>
    </section>


        <!-- রক্তদান নির্দেশিকা কার্ড শুরু -->
        <div class="about-cards">
        <div class="card">
            <h1>রক্তদান নির্দেশিকা</h1>
<br>
            <h3>১. সম্পূর্ণ রক্ত দান</h3>
            <ul>
                <li>প্রতি ৫৬ দিন অন্তর (বছরে সর্বোচ্চ ৩ বার)</li>
                <li>স্বাস্থ্য ভালো থাকতে হবে এবং অসুস্থ অনুভব করা যাবে না</li>
                <li>বয়স: কমপক্ষে ১৮ বছর</li>
                <li>ওজন: কমপক্ষে ১১০ পাউন্ড (৫০ কেজি)</li>
            </ul>
<br>
            <h3>২. প্লেটলেট দান</h3>
            <ul>
                <li>প্রতি ১৫ দিন অন্তর (বছরে সর্বোচ্চ ২৪ বার)</li>
                <li>স্বাস্থ্য ভালো থাকতে হবে এবং অসুস্থ অনুভব করা যাবে না</li>
                <li>বয়স: কমপক্ষে ১৮ বছর</li>
                <li>ওজন: কমপক্ষে ১১০ পাউন্ড (৫০ কেজি)</li>
                <li>অ্যাসপিরিন খেলে প্লেটলেট দান করার আগে ২ দিন বন্ধ রাখতে হবে</li>
            </ul>
            <br>
            <h1>কে রক্ত দিতে পারবেন না</h1>
            <ul>
           
<br>
<h3>আপনি রক্ত দিতে পারবেন না যদি:</h3>
<br>
<h3> ১. সর্দি, জ্বর</h3>

<li>জ্বর থাকে</li>

<li>কফসহ কাশি থাকে</li>

<li>শরীর খারাপ থাকে</li>

<li>সাইনাস, গলা বা ফুসফুসের সংক্রমণের জন্য অ্যান্টিবায়োটিক চলমান থাকে (চিকিৎসা শেষ না হওয়া পর্যন্ত অপেক্ষা করতে হবে)</li>
<br>
<h3>২. ওজন ও উচ্চতা</h3>

<li>রক্তদানের জন্য ওজন কমপক্ষে ১১০ পাউন্ড (৫০ কেজি) হতে হবে</li>

<li>নিরাপত্তার জন্য এটি বাধ্যতামূলক</li>
<br>
<h3>৩. অ্যালার্জি, নাক বন্ধ, চোখ চুলকানো</h3>

<li>জ্বর না থাকলে এবং শ্বাস নিতে সমস্যা না হলে রক্ত দেওয়া যাবে</li>
<br>
<h3>৪. দানের বিরতি</h3>

<li>সম্পূর্ণ রক্ত দান: কমপক্ষে ১৬ সপ্তাহ বিরতি</li>

<li>প্লেটলেট দান: কমপক্ষে ১৫ দিন বিরতি</li>
<br>
<h3>৫. দমবাঁধা বা হাঁপানি (Asthma)</h3>

<li>শ্বাসকষ্ট থাকলে রক্ত দেওয়া যাবে না</li>
<br>
<h3>৬. রক্তক্ষরণজনিত সমস্যা (Bleeding Disorders)</h3>

<li>যদি রক্ত স্বাভাবিকভাবে জমাট বাঁধে না, তাহলে রক্ত দেওয়া যাবে না।</li>
<br>
<h3>নিচের রক্ত পাতলা করার ওষুধ খেলে দান করা যাবে না:</h3>

<li>Atrixa (fondaparinux)</li>

<li>Coumadin / Jantoven / Warfilone (warfarin)</li>

<li>Eliquis (apixaban)</li>

<li>Fragmin (dalteparin)</li>

<li>Heparin</li>

<li>Lovenox (enoxaparin)</li>

<li>Pradaxa (dabigatran)</li>

<li>Savaysa (edoxaban)</li>

<li>Xarelto (rivaroxaban)</li>

<li>অ্যাসপিরিন খেলে সম্পূর্ণ রক্ত দেওয়া যাবে, কিন্তু প্লেটলেট দান করতে হলে ২ দিন বন্ধ রাখতে হবে।</li>
<br>
<h3>৭. রক্তচাপ (উচ্চ বা নিম্ন)</h3>
<li>উচ্চ রক্তচাপ</li>

<li>সিস্টোলিক < ১৮০</li>

<li>ডায়াস্টোলিক < ১০০</li>

<li>উচ্চ রক্তচাপের ওষুধ সমস্যা নয়</li>

<li>নিম্ন রক্তচাপ</li>

<li>অন্তত ৯০/৫০ এবং শরীর ভালো থাকতে হবে</li>
<br>
<h3>৮. হার্টবিট (Pulse)</h3>

<li>৫০–১০০ বিট প্রতি মিনিট হলে গ্রহণযোগ্য</li>

<li>৫০-এর নিচে হলে চিকিৎসকের অনুমতি লাগবে</li>
<br>
<h3>৯. ক্যান্সার</h3>

<li>লিউকেমিয়া বা লিম্ফোমা হলে রক্ত দেওয়া যাবে না</li>

<li>অন্যান্য ক্যান্সার হলে চিকিৎসা শেষের ১ বছর পর রক্ত দেওয়া যাবে</li>
<br>
<h3>১০. ডায়াবেটিস</h3>

<li>ইনসুলিন বা ওষুধ নিয়ন্ত্রণে থাকলে রক্ত দেওয়া যাবে</li>
<br>
<h3>১১. হৃদরোগ (Heart Disease)</h3>
<br>
<h3>রক্ত দেওয়া যাবে যদি:</h3>

<li>চিকিৎসা সম্পন্ন হয়</li>

<li>গত ৬ মাসে কোনো বুকে ব্যথা বা সমস্যা না থাকে</li>

<li>দৈনন্দিন কাজে কোনো বাধা না থাকে</li>

<h3>অপেক্ষা করতে হবে:</h3>

<li>এনজাইনা: ৬ মাস</li>

<li>হার্ট অ্যাটাক: ৬ মাস</li>

<li>বাইপাস বা এঞ্জিওপ্লাস্টি: ৬ মাস</li>
<br>
<h3>১২. হিমোগ্লোবিন</h3>

<li>মহিলা: কমপক্ষে ১২.৫ g/dL</li>

<li>পুরুষ: কমপক্ষে ১৩.০ g/dL</li>

<li>সর্বোচ্চ: ২০ g/dL</li>
<br>
<h3>১৩. হেপাটাইটিস / জন্ডিস</h3>

<li>হেপাটাইটিস B বা C পজিটিভ হলে আজীবন রক্ত দেওয়া যাবে না</li>

<li>আক্রান্ত ব্যক্তির সঙ্গে যৌনসম্পর্ক থাকলে ১২ মাস অপেক্ষা</li>
<br>
<h3>১৪. HIV / AIDS</h3>

<li>HIV পজিটিভ বা AIDS থাকলে রক্ত দেওয়া যাবে না</li>
<br>
<h3>১৫. সংক্রমণ (Infections)</h3>

<li>জ্বর বা সক্রিয় সংক্রমণ থাকলে সম্পূর্ণ সেরে না ওঠা পর্যন্ত অপেক্ষা</li>
<br>
<h3>১৬. মাংকিপক্স (Monkeypox)</h3>

<li>আক্রান্ত বা সংস্পর্শে এলে ২১ দিন অপেক্ষা</li>
<br>
<h3>১৭. ম্যালেরিয়া</h3>

<li>ম্যালেরিয়া চিকিৎসা শেষের ৩ বছর পরে</li>

<li>ঝুঁকিপূর্ণ এলাকায় ভ্রমণ করলে ৩ মাস পরে</li>

<li>৫ বছরের বেশি সময় সেখানে বসবাস করলে ৩ বছর অপেক্ষা</li>
<br>
<h3>১৮. ত্বকের সমস্যা</h3>

<li>যে হাতে রক্ত নেওয়া হবে সেই স্থান পরিষ্কার থাকলে সমস্যা নেই</li>

<li>সংক্রমণ থাকলে ঠিক হওয়া পর্যন্ত অপেক্ষা</li>
<br>
<h3>১৯. টিবি (Tuberculosis)</h3>

<li>সক্রিয় TB থাকলে রক্ত দেওয়া যাবে না</li>

<li>চিকিৎসা শেষ হলে দান করা যাবে</li>
<br>
<h3>২০. হাম (Measles) সংস্পর্শ</h3>

<li>টিকা নিলে বা ১৯৫৬ সালের আগে জন্ম হলে গ্রহণযোগ্য না হলে ৪ সপ্তাহ অপেক্ষা</li>
<br>
<h3>২১. রক্ত গ্রহণ (Blood Transfusion)</h3>

<li>রক্ত পাওয়ার ৩ মাস পর দান করা যাবে</li>
<br>
<h3>২২. দাঁতের চিকিৎসা</h3>

<li>সাধারণ চিকিৎসার পর রক্ত দেওয়া যাবে</li>

<li>সংক্রমণ থাকলে অ্যান্টিবায়োটিক শেষ হওয়া পর্যন্ত অপেক্ষা</li>

<li>বড় সার্জারি হলে ৩ দিন অপেক্ষা</li>
<br>
<h3>২৩. অঙ্গ প্রতিস্থাপন (Transplant)</h3>

<li>অঙ্গ বা টিস্যু প্রতিস্থাপনের ৩ মাস পরে দান করা যাবে</li>

<li>Dura mater ট্রান্সপ্লান্ট (মস্তিষ্কের আবরণ) পেলে কখনো দান করা যাবে না</li>
<br>
<h3>২৪. অস্ত্রোপচার</h3>

<li>রোগের ধরন অনুযায়ী সিদ্ধান্ত নেওয়া হবে</li>
<br>
<h3>২৫. গর্ভাবস্থা ও প্রসব</h3>

<li>গর্ভবতী হলে রক্ত দেওয়া যাবে না</li>

<li>সন্তান জন্মের ৬ সপ্তাহ পরে রক্ত দেওয়া যাবে</li>
<br>
<h3>২৬. সিফিলিস / গনোরিয়া</h3>

<li>চিকিৎসা শেষের ৩ মাস পরে রক্ত দেওয়া যাবে</li>
            </ul>
        </div>
        <!-- রক্তদান নির্দেশিকা কার্ড শেষ -->

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
</html>
