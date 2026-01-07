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
    
    <!-- Mobile Menu Toggle Button -->
    <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-label="Toggle Menu">
        <i class="fas fa-bars"></i>
    </button>
</nav>

<!-- Mobile Navigation Overlay -->
<div class="mobile-nav-overlay" onclick="toggleMobileMenu()"></div>
    <!-- Mobile sliding nav panel -->
    <nav class="mobile-nav" aria-hidden="true">
        <div class="mobile-nav-header">
            <div class="logo">
                <img src="Picture/pstu.png" alt="Logo">
            </div>
            <div class="logo">
                <img src="Picture/badhon.jpeg" alt="Logo">
            </div>
        </div>
        <ul>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"><a href="index.php">হোম</a></li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>"><a href="about.php">আমাদের সম্পর্কে</a></li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'activities.php' ? 'active' : ''; ?>"><a href="activities.php">কার্যক্রমসমূহ</a></li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'gallery.php' ? 'active' : ''; ?>"><a href="gallery.php">গ্যালারি</a></li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'blog.php' ? 'active' : ''; ?>"><a href="blog.php">ব্লগ</a></li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'notice.php' ? 'active' : ''; ?>"><a href="notice.php">নোটিশ</a></li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>"><a href="contact.php">যোগাযোগ</a></li>
        </ul>
        <div class="mobile-nav-actions">
            <?php if(isset($_SESSION['username'])): ?>
                <a href="dashboard.php" class="btn-login">ড্যাশবোর্ড</a>
                <a href="logout.php" class="btn-donate">লগআউট</a>
            <?php else: ?>
                <a href="login.php" class="btn-login">লগইন</a>
            <?php endif; ?>
        </div>
    </nav>

<script>
// Mobile Menu Toggle Function
function toggleMobileMenu() {
    const mobileNav = document.querySelector('.mobile-nav');
    const overlay = document.querySelector('.mobile-nav-overlay');
    const toggleBtn = document.querySelector('.mobile-menu-toggle i');
    
    if (!mobileNav || !overlay || !toggleBtn) return;
    
    mobileNav.classList.toggle('active');
    overlay.classList.toggle('active');
    
    // Change icon
    if (mobileNav.classList.contains('active')) {
        toggleBtn.classList.remove('fa-bars');
        toggleBtn.classList.add('fa-times');
    } else {
        toggleBtn.classList.remove('fa-times');
        toggleBtn.classList.add('fa-bars');
    }
}

// Close mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const mobileNav = document.querySelector('.mobile-nav');
    const overlay = document.querySelector('.mobile-nav-overlay');
    const toggleBtn = document.querySelector('.mobile-menu-toggle');
    
    if (!mobileNav || !overlay || !toggleBtn) return;
    
    if (mobileNav.classList.contains('active') && 
        !mobileNav.contains(event.target) && 
        !toggleBtn.contains(event.target)) {
        toggleMobileMenu();
    }
});

// Close mobile menu on window resize if screen becomes larger
window.addEventListener('resize', function() {
    const mobileNav = document.querySelector('.mobile-nav');
    const overlay = document.querySelector('.mobile-nav-overlay');
    const toggleBtn = document.querySelector('.mobile-menu-toggle i');
    
    if (window.innerWidth > 992 && mobileNav && mobileNav.classList.contains('active')) {
        mobileNav.classList.remove('active');
        overlay.classList.remove('active');
        if (toggleBtn) {
            toggleBtn.classList.remove('fa-times');
            toggleBtn.classList.add('fa-bars');
        }
    }
});
</script>
