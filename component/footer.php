<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../includes/language.php';
?>

<!-- ================= FOOTER ================= -->
<footer>
    <div class="container">
        <div class="footer-content">

            <!-- Quick Links -->
            <div class="footer-column">
                <h3>Quick Links</h3> <ul>
                <ul>
                    <li><a href="index.php"><?php echo t('home'); ?></a></li>
                    <li><a href="about.php"><?php echo t('about'); ?></a></li>
                    <li><a href="activities.php"><?php echo t('activities'); ?></a></li>
                    <li><a href="gallery.php"><?php echo t('gallery'); ?></a></li>
                    <li><a href="blog.php"><?php echo t('blog'); ?></a></li>
                    <li><a href="notice.php"><?php echo t('notice'); ?></a></li>
                    <li><a href="contact.php"><?php echo t('contact'); ?></a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="footer-column">
                <h3><?php echo t('footer_contact'); ?></h3>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> <?php echo t('footer_address'); ?></li>
                    <li><i class="fas fa-phone"></i> 01624428661</li>
                    <li><i class="fas fa-envelope"></i> badhanpstu6@gmail.com</li>
                </ul>

                <div class="social-links">
                       <a href="https://www.facebook.com/share/g/16ovjUkt5j/" target="_blank" aria-label="Facebook">
        <i class="fab fa-facebook-f"></i>
    </a>
                    

                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

        </div>

        <!-- Copyright -->
       <div class="copyright">
    <p>
        &copy; 2025 BADHAN PSTU UNIT. All Rights Reserved.
        Design, Development and Maintenance by OMAR SAEED NAEEM.
    </p>
</div>

    </div>
</footer>
