<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../includes/language.php';
?>
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
            <a href="index.php"><?php echo t('home'); ?></a>
        </li>
        <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">
            <a href="about.php"><?php echo t('about'); ?></a>
        </li>
        <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'activities.php' ? 'active' : ''; ?>">
            <a href="activities.php"><?php echo t('activities'); ?></a>
        </li>
        <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'gallery.php' ? 'active' : ''; ?>">
            <a href="gallery.php"><?php echo t('gallery'); ?></a>
        </li>
        <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'blog.php' ? 'active' : ''; ?>">
            <a href="blog.php"><?php echo t('blog'); ?></a>
        </li>
        <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'notice.php' ? 'active' : ''; ?>">
            <a href="notice.php"><?php echo t('notice'); ?></a>
        </li>
        <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">
            <a href="contact.php"><?php echo t('contact'); ?></a>
        </li>
    </ul>
    <div class="navbar-right">
        <div class="lang-toggle">
            <a href="?lang=bn" class="lang-btn <?php echo (isset($_SESSION['language']) && $_SESSION['language'] == 'bn') ? 'active' : ''; ?>" title="বাংলা" aria-label="বাংলা">বাং</a>
            <a href="?lang=en" class="lang-btn <?php echo (isset($_SESSION['language']) && $_SESSION['language'] == 'en') ? 'active' : ''; ?>" title="English" aria-label="English">EN</a>
        </div>

        <?php if(isset($_SESSION['username'])): ?>
            <a href="dashboard.php" class="btn-login"><?php echo t('dashboard'); ?></a>
            <a href="logout.php" class="btn-donate"><?php echo t('logout'); ?></a>
        <?php else: ?>
            <a href="login.php" class="btn-login"><?php echo t('login'); ?></a>
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
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"><a href="index.php"><?php echo t('home'); ?></a></li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>"><a href="about.php"><?php echo t('about'); ?></a></li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'activities.php' ? 'active' : ''; ?>"><a href="activities.php"><?php echo t('activities'); ?></a></li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'gallery.php' ? 'active' : ''; ?>"><a href="gallery.php"><?php echo t('gallery'); ?></a></li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'blog.php' ? 'active' : ''; ?>"><a href="blog.php"><?php echo t('blog'); ?></a></li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'notice.php' ? 'active' : ''; ?>"><a href="notice.php"><?php echo t('notice'); ?></a></li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>"><a href="contact.php"><?php echo t('contact'); ?></a></li>
        </ul>
        <div class="mobile-nav-actions">
            <div class="mobile-lang-actions" style="display:flex; gap:8px; margin-bottom:8px;">
                <a href="?lang=bn" class="lang-btn <?php echo (isset($_SESSION['language']) && $_SESSION['language'] == 'bn') ? 'active' : ''; ?>" style="text-decoration:none;" title="বাংলা" aria-label="বাংলা">BN</a>
                <a href="?lang=en" class="lang-btn <?php echo (isset($_SESSION['language']) && $_SESSION['language'] == 'en') ? 'active' : ''; ?>" style="text-decoration:none;" title="English" aria-label="English">EN</a>
            </div>
            <?php if(isset($_SESSION['username'])): ?>
                <a href="dashboard.php" class="btn-login"><?php echo t('dashboard'); ?></a>
                <a href="logout.php" class="btn-donate"><?php echo t('logout'); ?></a>
            <?php else: ?>
                <a href="login.php" class="btn-login"><?php echo t('login'); ?></a>
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
