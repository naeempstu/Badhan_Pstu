<?php
// Use this include at the top of admin pages
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']) || empty($_SESSION['is_admin'])) {
    // Not logged in or not an admin
    header('Location: ../login.php');
    exit();
}
