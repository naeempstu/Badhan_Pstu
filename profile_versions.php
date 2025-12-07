<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username'])) { header('Location: login.php'); exit(); }

$up = intval($_GET['up'] ?? 0);
if ($up <= 0) { echo 'Invalid profile id'; exit(); }

// restore action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['restore_id'])) {
    $vid = intval($_POST['restore_id']);
    // fetch version
    $stmt = $conn->prepare("SELECT * FROM user_profile_versions WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $vid);
    $stmt->execute();
    $rv = $stmt->get_result()->fetch_assoc();
    if ($rv) {
        // fetch current profile id and save as version
        $stmt2 = $conn->prepare("SELECT * FROM user_profiles WHERE id = ? LIMIT 1");
        $stmt2->bind_param('i', $up);
        $stmt2->execute();
        $cur = $stmt2->get_result()->fetch_assoc();
        if ($cur) {
            $ins = $conn->prepare("INSERT INTO user_profile_versions (user_profile_id, user_id, full_name, dob, gender, blood_group, phone, address, city, state, postal_code, emergency_contact, bio, photo, changed_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $ins->bind_param('iissssssssssssi', $cur['id'], $cur['user_id'], $cur['full_name'], $cur['dob'], $cur['gender'], $cur['blood_group'], $cur['phone'], $cur['address'], $cur['city'], $cur['state'], $cur['postal_code'], $cur['emergency_contact'], $cur['bio'], $cur['photo'], $_SESSION['user_id'] ?? NULL);
            @$ins->execute();
        }
        // restore: update user_profiles from version
        $upd = $conn->prepare("UPDATE user_profiles SET full_name=?, dob=?, gender=?, blood_group=?, phone=?, address=?, city=?, state=?, postal_code=?, emergency_contact=?, bio=?, photo=? WHERE id=?");
        $upd->bind_param('ssssssssssssi', $rv['full_name'], $rv['dob'], $rv['gender'], $rv['blood_group'], $rv['phone'], $rv['address'], $rv['city'], $rv['state'], $rv['postal_code'], $rv['emergency_contact'], $rv['bio'], $rv['photo'], $up);
        if ($upd->execute()) {
            $msg = 'Version restored successfully.';
        } else { $msg = 'Restore failed.'; }
    }
}

$stmt = $conn->prepare("SELECT v.*, u.email FROM user_profile_versions v LEFT JOIN users u ON u.id = v.user_id WHERE v.user_profile_id = ? ORDER BY v.changed_at DESC LIMIT 200");
$stmt->bind_param('i', $up);
$stmt->execute();
$res = $stmt->get_result();

?>
<!doctype html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>প্রোফাইল সংস্করণ</title>
    <link rel="stylesheet" href="static/css/dashboard.css">
    <style> .version-item{border-bottom:1px solid #eef2f6;padding:12px 0} </style>
</head>
<body class="dashboard-body">
<div class="dash-wrapper">
    <aside class="dash-sidebar">
        <h3>ড্যাশবোর্ড</h3>
        <ul>
            <li><a href="dashboard.php">হোম</a></li>
            <li><a href="profiles_list.php">প্রোফাইল তালিকা</a></li>
            <li><a href="logout.php">লগআউট</a></li>
        </ul>
    </aside>
    <main class="dash-main">
        <h2>প্রোফাইল সংস্করণ</h2>
        <?php if (!empty($msg)): ?><div style="background:#e6ffed;padding:8px;border-radius:6px;margin-bottom:8px"><?php echo $msg; ?></div><?php endif; ?>

        <?php while ($v = $res->fetch_assoc()): ?>
            <div class="version-item">
                <div style="display:flex;justify-content:space-between;align-items:center">
                    <div>
                        <strong><?php echo htmlspecialchars($v['full_name']); ?></strong>
                        <div style="color:#6b7280;font-size:0.9rem"><?php echo htmlspecialchars($v['email']); ?> — <?php echo $v['changed_at']; ?></div>
                    </div>
                    <div>
                        <form method="post" style="display:inline">
                            <input type="hidden" name="restore_id" value="<?php echo $v['id']; ?>">
                            <button class="btn btn-primary" type="submit">Restore</button>
                        </form>
                        <a class="btn btn-secondary" href="export_profile.php?id=<?php echo $v['user_profile_id']; ?>&version=<?php echo $v['id']; ?>" target="_blank" style="margin-left: 5px;">View PDF</a>
                        <a class="btn btn-secondary" href="export_profile.php?id=<?php echo $v['user_profile_id']; ?>&version=<?php echo $v['id']; ?>&download=1" style="margin-left: 5px;">Download PDF</a>
                    </div>
                </div>
                <div style="margin-top:8px;color:#374151">
                    <strong>Phone:</strong> <?php echo htmlspecialchars($v['phone']); ?> &nbsp; <strong>Blood:</strong> <?php echo htmlspecialchars($v['blood_group']); ?>
                    <div style="margin-top:6px"><strong>Address:</strong><br><?php echo nl2br(htmlspecialchars($v['address'])); ?></div>
                </div>
            </div>
        <?php endwhile; ?>

    </main>
</div>
</body>
</html>
