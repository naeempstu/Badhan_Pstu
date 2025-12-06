<?php session_start(); ?>
<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>যোগাযোগ</title>
<link rel="icon" type="image/x-icon" href="picture/badhon.jpeg">
<link rel="stylesheet" href="static/css/index.css">
<link rel="stylesheet" href="static/css/about.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* Blood Request Form Style */
.form-container {
    width: 80%;
    margin: 40px auto;
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 0 10px #ccc;
}

.form-container h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #b30000;
}

form input, form select, form textarea {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #aaa;
    border-radius: 6px;
    font-size: 16px;
}

form button {
    width: 100%;
    padding: 12px;
    background: #e60000;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 18px;
    cursor: pointer;
}

form button:hover {
    background: #b30000;
}
</style>

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
        <h1>যোগাযোগ</h1>
    </section>

    <!-- Display Success/Error Messages -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success">
        <?php 
        echo $_SESSION['success_message'];
        unset($_SESSION['success_message']);
        ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-error">
        <?php 
        echo $_SESSION['error_message'];
        unset($_SESSION['error_message']);
        ?>
    </div>
<?php endif; ?>

    <div class="about-cards">
        <div class="card">
            <p>Email: badhan.pstuunit@gmail.com</p>
            <p>Mobile: 01624428661</p>
            <p>পটুয়াখালী বিজ্ঞান ও প্রযুক্তি বিশ্ববিদ্যালয়</p>
            <p>দুমকি, পটুয়াখালী-৮৬৬০, বাংলাদেশ</p>
        </div>
    </div>


    <!-- ⭐ BLOOD REQUEST FORM ADDED BELOW -->
    <div class="form-container">
        <h2>রক্তের আবেদন ফর্ম</h2>

        <form action="save_blood_request.php" method="POST">

            <input type="text" name="patient_name" placeholder="রোগীর নাম" required>

            <select name="blood_group" required>
                <option value="">রক্তের গ্রুপ নির্বাচন করুন</option>
                <option>A+</option><option>A-</option>
                <option>B+</option><option>B-</option>
                <option>AB+</option><option>AB-</option>
                <option>O+</option><option>O-</option>
            </select>

            <input type="date" name="needed_date" required>

            <input type="text" name="hospital" placeholder="হাসপাতাল / লোকেশন" required>

            <input type="text" name="phone" placeholder="যোগাযোগ নম্বর" required>

            <textarea name="details" rows="4" placeholder="প্রয়োজনের কারণ লিখুন"></textarea>

            <button type="submit">আবেদন জমা দিন</button>
        </form>
    </div>
    <!-- ⭐ END BLOOD REQUEST FORM -->

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
