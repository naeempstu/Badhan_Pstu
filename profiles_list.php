<?php
// profiles_list.php
session_start();
include 'db_connect.php';

// Simple access control: require login
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); exit();
}

$q = trim($_GET['q'] ?? '');
$params = [];
$where = '';
if ($q !== '') {
    $where = "WHERE (up.full_name LIKE ? OR u.email LIKE ? OR up.phone LIKE ? OR up.blood_group LIKE ? OR up.city LIKE ?)";
    $like = "%{$q}%";
    $params = [$like, $like, $like, $like, $like];
}

$sql = "SELECT up.*, u.email, u.phone as user_phone FROM user_profiles up JOIN users u ON u.id = up.user_id " . $where . " ORDER BY up.updated_at DESC LIMIT 200";
$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$res = $stmt->get_result();

?>
<!doctype html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>প্রোফাইল তালিকা</title>
    <link rel="stylesheet" href="static/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="dashboard-body">
<div class="dash-wrapper">
    <aside class="dash-sidebar">
        <h3>ড্যাশবোর্ড</h3>
        <ul>
            <li><a href="dashboard.php">হোম</a></li>
            <li><a href="profile.php">আপনার প্রোফাইল</a></li>
            <li><a class="active" href="profiles_list.php">প্রোফাইল তালিকা</a></li>
            <li><a href="logout.php">লগআউট</a></li>
        </ul>
    </aside>

    <main class="dash-main">
        <div class="page-header">
            <h2>প্রোফাইল তালিকা</h2>
            <p class="page-subtitle">সকল সদস্যদের প্রোফাইল দেখুন এবং পরিচালনা করুন</p>
        </div>

        <div class="search-container">
            <form method="get" class="search-form">
                <div class="search-input-wrapper">
                    <i class="fas fa-search"></i>
                    <input type="text" name="q" value="<?php echo htmlspecialchars($q); ?>" placeholder="নাম, মোবাইল, রক্ত গ্রুপ বা শহর অনুসন্ধান করুন" class="search-input">
                </div>
                <button type="submit" class="btn btn-primary search-btn">
                    <i class="fas fa-search"></i> অনুসন্ধান
                </button>
            </form>
        </div>

        <div class="table-container">
            <table class="profiles-table">
                <thead>
                    <tr>
                        <th>ছবি</th>
                        <th>নাম</th>
                        <th>মোবাইল</th>
                        <th>রক্তের গ্রুপ</th>
                        <th>শহর</th>
                        <th>কার্যক্রম</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($res->num_rows > 0): ?>
                        <?php while ($row = $res->fetch_assoc()): ?>
                        <tr>
                            <td class="photo-cell">
                                <div class="profile-photo-wrapper">
                                    <img src="<?php echo htmlspecialchars($row['photo'] ?: 'Picture/pstu.png'); ?>" alt="Profile" class="profile-thumb">
                                </div>
                            </td>
                            <td class="name-cell">
                                <strong><?php echo htmlspecialchars($row['full_name']); ?></strong>
                            </td>
                            <td class="phone-cell">
                                <a href="tel:<?php echo htmlspecialchars($row['phone'] ?: $row['user_phone'] ?: ''); ?>" class="phone-link">
                                    <i class="fas fa-phone"></i> <?php echo htmlspecialchars($row['phone'] ?: $row['user_phone'] ?: 'N/A'); ?>
                                </a>
                            </td>
                            <td class="blood-cell">
                                <span class="blood-badge"><?php echo htmlspecialchars($row['blood_group'] ?: 'N/A'); ?></span>
                            </td>
                            <td class="city-cell"><?php echo htmlspecialchars($row['city'] ?: 'N/A'); ?></td>
                            <td class="actions-cell">
                                <div class="action-buttons">
                                    <a class="btn-action btn-edit" href="profile.php?user_id=<?php echo $row['user_id']; ?>" title="সম্পাদনা">
                                        <i class="fas fa-edit"></i> <span>সম্পাদনা</span>
                                    </a>
                                    <a class="btn-action btn-versions" href="profile_versions.php?up=<?php echo $row['id']; ?>" title="সংস্করণ">
                                        <i class="fas fa-history"></i> <span>সংস্করণ</span>
                                    </a>
                                    <a class="btn-action btn-view-pdf" href="export_profile.php?id=<?php echo $row['id']; ?>" target="_blank" title="PDF দেখুন">
                                        <i class="fas fa-eye"></i> <span>PDF</span>
                                    </a>
                                    <a class="btn-action btn-download-pdf" href="export_profile.php?id=<?php echo $row['id']; ?>&download=1" title="PDF ডাউনলোড">
                                        <i class="fas fa-download"></i> <span>ডাউনলোড</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="no-data">
                                <div class="no-data-content">
                                    <i class="fas fa-inbox"></i>
                                    <p>কোন প্রোফাইল পাওয়া যায়নি</p>
                                    <?php if ($q): ?>
                                        <p class="no-data-subtitle">"<?php echo htmlspecialchars($q); ?>" এর জন্য কোন ফলাফল নেই</p>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </main>
</div>
</body>
</html>
