<?php
// Language Configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Prevent redeclaration of functions
if (!function_exists('t')) {

// Get language from localStorage via session or default to Bengali
$GLOBALS['lang'] = isset($_SESSION['language']) ? $_SESSION['language'] : 'bn';

// Check if language is being set via GET parameter (for the language switcher)
if (isset($_GET['lang']) && in_array($_GET['lang'], ['bn', 'en'])) {
    $GLOBALS['lang'] = $_GET['lang'];
    $_SESSION['language'] = $_GET['lang'];
}

// Translation arrays
$GLOBALS['translations'] = [
    'bn' => [
        'home' => 'হোম',
        'about' => 'আমাদের সম্পর্কে',
        'activities' => 'কার্যক্রমসমূহ',
        'gallery' => 'গ্যালারি',
        'blog' => 'ব্লগ',
        'notice' => 'নোটিশ',
        'contact' => 'যোগাযোগ',
        'dashboard' => 'ড্যাশবোর্ড',
        'logout' => 'লগআউট',
        'login' => 'লগইন',
        'welcome' => 'স্বাগতম',
        'about_title' => 'আমাদের সম্পর্কে',
        'contact_title' => 'যোগাযোগ করুন',
        'gallery_title' => 'গ্যালারি',
        'notice_title' => 'নোটিশ',
        'blog_title' => 'ব্লগ',
        'activities_title' => 'কার্যক্রম',

        

'footer_contact' => 'যোগাযোগ',
'footer_address' => 'পটুয়াখালী বিজ্ঞান ও প্রযুক্তি বিশ্ববিদ্যালয়, দুমকি, পটুয়াখালী-৮৬৬০',
'footer_rights' => 'সমস্ত অধিকার সংরক্ষিত',
'footer_designed' => 'ডিজাইন, ডেভেলপমেন্ট ও রক্ষণাবেক্ষণ',


    ],
    'en' => [
        'home' => 'Home',
        'about' => 'About Us',
        'activities' => 'Activities',
        'gallery' => 'Gallery',
        'blog' => 'Blog',
        'notice' => 'Notice',
        'contact' => 'Contact',
        'dashboard' => 'Dashboard',
        'logout' => 'Logout',
        'login' => 'Login',
        'welcome' => 'Welcome',
        'about_title' => 'About Us',
        'contact_title' => 'Contact Us',
        'gallery_title' => 'Gallery',
        'notice_title' => 'Notice',
        'blog_title' => 'Blog',
        'activities_title' => 'Activities',

        
'footer_contact' => 'Contact',
'footer_address' => 'Patuakhali Science and Technology University, Dumki, Patuakhali-8660',
'footer_rights' => 'All Rights Reserved',
'footer_designed' => 'Design, Development and Maintenance',

    ]
];

// Function to get translation
function t($key) {
    $lang = isset($GLOBALS['lang']) ? $GLOBALS['lang'] : 'bn';
    $translations = $GLOBALS['translations'] ?? [];
    return isset($translations[$lang][$key]) ? $translations[$lang][$key] : $key;
}

// Function to get current language
function getCurrentLang() {
    return isset($GLOBALS['lang']) ? $GLOBALS['lang'] : 'bn';
}

} // End of if (!function_exists('t'))
?>
