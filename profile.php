<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Get user id
$stmt = $conn->prepare("SELECT id, full_name, email FROM users WHERE username = ? LIMIT 1");
$stmt->bind_param('s', $username);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows == 0) {
    echo 'User not found.'; exit();
}
$user = $res->fetch_assoc();
$user_id = $user['id'];

// Fetch existing profile if any
$stmt = $conn->prepare("SELECT * FROM user_profiles WHERE user_id = ? LIMIT 1");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$profileRes = $stmt->get_result();
$profile = $profileRes->num_rows ? $profileRes->fetch_assoc() : null;

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize
    $full_name = trim($_POST['full_name']);
    $dob = $_POST['dob'] ?: null;
    $gender = $_POST['gender'] ?: null;
    $blood_group = trim($_POST['blood_group']) ?: null;
    $phone = trim($_POST['phone']) ?: null;
    $address = trim($_POST['address']) ?: null;
    $city = trim($_POST['city']) ?: null;
    $state = trim($_POST['state']) ?: null;
    $postal_code = trim($_POST['postal_code']) ?: null;
    $emergency_contact = trim($_POST['emergency_contact']) ?: null;
    $bio = trim($_POST['bio']) ?: null;

    // Handle photo upload (optional) with validation
    $photo_name = $profile['photo'] ?? null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['photo']['tmp_name'];
        $orig = basename($_FILES['photo']['name']);
        $filesize = filesize($tmp);
        $maxSize = 4 * 1024 * 1024; // 2MB

        if ($filesize > $maxSize) {
            $error = 'ছবির সাইজ 4MB এর বেশি হতে পারে না।';
        } else {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $tmp);
            finfo_close($finfo);
            $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];
            if (!array_key_exists($mime, $allowed)) {
                $error = 'অনুগ্রহ করে একটি বৈধ ইমেজ ফাইল (jpg, png, gif) আপলোড করুন।';
            } else {
                $ext = $allowed[$mime];
                $safe = 'profile_' . $user_id . '_' . time() . '.' . $ext;
                $destDir = __DIR__ . '/Picture/profiles';
                if (!is_dir($destDir)) mkdir($destDir, 0755, true);
                $dest = $destDir . '/' . $safe;
                if (move_uploaded_file($tmp, $dest)) {
                    // remove old photo if exists and is inside Picture/profiles
                    if (!empty($photo_name) && strpos($photo_name, 'Picture/profiles/') === 0) {
                        $oldPath = __DIR__ . '/' . $photo_name;
                        if (is_file($oldPath)) @unlink($oldPath);
                    }
                    $photo_name = 'Picture/profiles/' . $safe;
                } else {
                    $error = 'ছবি আপলোড করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেক করুন।';
                }
            }
        }
    }

    if (empty($error)) {
        if ($profile) {
            // Save current profile snapshot to versions table (if table exists)
            $saveVersionSql = "INSERT INTO user_profile_versions (user_profile_id, user_id, full_name, dob, gender, blood_group, phone, address, city, state, postal_code, emergency_contact, bio, photo, changed_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            if ($verStmt = $conn->prepare($saveVersionSql)) {
                $verStmt->bind_param('iissssssssssssi', $profile['id'], $user_id, $profile['full_name'], $profile['dob'], $profile['gender'], $profile['blood_group'], $profile['phone'], $profile['address'], $profile['city'], $profile['state'], $profile['postal_code'], $profile['emergency_contact'], $profile['bio'], $profile['photo'], $user_id);
                @$verStmt->execute();
                $verStmt->close();
            }

            // Update
            $sql = "UPDATE user_profiles SET full_name=?, dob=?, gender=?, blood_group=?, phone=?, address=?, city=?, state=?, postal_code=?, emergency_contact=?, bio=?, photo=? WHERE user_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssssssssssi', $full_name, $dob, $gender, $blood_group, $phone, $address, $city, $state, $postal_code, $emergency_contact, $bio, $photo_name, $user_id);
            if ($stmt->execute()) {
                $success = 'প্রোফাইল সফলভাবে আপডেট করা হয়েছে।';
            } else { $error = 'আপডেটে সমস্যা হয়েছে।'; }
        } else {
            // Insert
            $sql = "INSERT INTO user_profiles (user_id, full_name, dob, gender, blood_group, phone, address, city, state, postal_code, emergency_contact, bio, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('issssssssssss', $user_id, $full_name, $dob, $gender, $blood_group, $phone, $address, $city, $state, $postal_code, $emergency_contact, $bio, $photo_name);
            if ($stmt->execute()) {
                $success = 'প্রোফাইল সফলভাবে সংরক্ষণ করা হয়েছে।';
            } else { $error = 'সেভে সমস্যা হয়েছে।'; }
        }
    }

    // Refresh profile
    $stmt = $conn->prepare("SELECT * FROM user_profiles WHERE user_id = ? LIMIT 1");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $pr = $stmt->get_result();
    $profile = $pr->num_rows ? $pr->fetch_assoc() : null;
}

?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>প্রোফাইল - BADHAN PSTU UNIT</title>
    <link rel="stylesheet" href="static/css/dashboard.css">
</head>
<body class="dashboard-body">

<div class="dash-wrapper">
    <aside class="dash-sidebar">
        <h3>ড্যাশবোর্ড</h3>
        <ul>
            <li><a href="dashboard.php">হোম</a></li>
            <li><a class="active" href="profile.php">প্রোফাইল তথ্য</a></li>
            <li><a href="logout.php">লগআউট</a></li>
        </ul>
    </aside>

    <main class="dash-main">
        <h2>আপনার ব্যক্তিগত তথ্য</h2>

        <?php if ($error): ?>
            <div style="background:#ffecec;padding:10px;border-radius:6px;margin-bottom:12px;color:#b91c1c"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div style="background:#e6ffed;padding:10px;border-radius:6px;margin-bottom:12px;color:#166534"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="profile-form">
            <form method="post" enctype="multipart/form-data">
                <div class="profile-top">
                    <div class="profile-card">
                        <?php if (!empty($profile['photo'])): ?>
                            <img class="photo" src="<?php echo htmlspecialchars($profile['photo']); ?>" alt="profile">
                        <?php else: ?>
                            <img class="photo" src="Picture/pstu.png" alt="placeholder">
                        <?php endif; ?>
                        <div style="margin-top:8px;font-weight:700"><?php echo htmlspecialchars($profile['full_name'] ?? $user['full_name']); ?></div>
                        <div style="color:#6b7280;font-size:0.95rem;margin-bottom:12px"><?php echo htmlspecialchars($user['email']); ?></div>
                        <div>
                            <label class="btn btn-secondary" style="cursor:pointer;display:inline-block;padding:8px 12px;border-radius:8px">ছবি পরিবর্তন
                                <input class="photo-upload-input" type="file" name="photo" accept="image/*" style="display:none;">
                            </label>
                        </div>
                        <div style="margin-top:10px;color:#9ca3af;font-size:0.85rem">ছবি সর্বোচ্চ 2MB — jpg/png/gif</div>
                    </div>

                    <div class="profile-fields">
                        <div class="profile-grid">
                            <div class="form-group">
                                <label>পূর্ণ নাম (English)</label>
                                <input type="text" name="full_name" value="<?php echo htmlspecialchars($profile['full_name'] ?? $user['full_name']); ?>">
                            </div>

                            <div class="form-group">
                                <label>জন্ম তারিখ</label>
                                <input type="date" name="dob" value="<?php echo htmlspecialchars($profile['dob'] ?? ''); ?>">
                            </div>

                            <div class="form-group">
                                <label>লিঙ্গ</label>
                                <select name="gender">
                                    <option value="">-- নির্বাচন করুন --</option>
                                    <option value="Male" <?php echo (isset($profile['gender']) && $profile['gender']=='Male')? 'selected':'';?>>Male</option>
                                    <option value="Female" <?php echo (isset($profile['gender']) && $profile['gender']=='Female')? 'selected':'';?>>Female</option>
                                    <option value="Other" <?php echo (isset($profile['gender']) && $profile['gender']=='Other')? 'selected':'';?>>Other</option>
                                </select>
                            </div>
                        
                            <div class="form-group">
                                <label>রক্তের গ্রুপ</label>
                                 <select name="blood_group">
                                 <option value="">-- নির্বাচন করুন --</option>
                                    <option value="A+" <?php echo (isset($profile['blood_group']) && $profile['blood_group']=='A+')? 'selected':'';?>>A+</option>
                                    <option value="A-" <?php echo (isset($profile['blood_group']) && $profile['blood_group']=='A-')? 'selected':'';?>>A-</option>
                                    <option value="B+" <?php echo (isset($profile['blood_group']) && $profile['blood_group']=='B+')? 'selected':'';?>>B+</option>
                                    <option value="B-" <?php echo (isset($profile['blood_group']) && $profile['blood_group']=='B-')? 'selected':'';?>>B-</option>
                                    <option value="AB+" <?php echo (isset($profile['blood_group']) && $profile['blood_group']=='AB+')? 'selected':'';?>>AB+</option>
                                    <option value="AB-" <?php echo (isset($profile['blood_group']) && $profile['blood_group']=='AB-')? 'selected':'';?>>AB-</option>
                                    <option value="O+" <?php echo (isset($profile['blood_group']) && $profile['blood_group']=='O+')? 'selected':'';?>>O+</option>
                                    <option value="O-" <?php echo (isset($profile['blood_group']) && $profile['blood_group']=='O-')? 'selected':'';?>>O-</option>
                                    </select>
                            </div>
                        
                            <div class="form-group">
                                <label>ফোন</label>
                                 <input type="text" name="phone" value="<?php echo htmlspecialchars($profile['phone'] ?? ''); ?>">
                            </div>

                            <div class="form-group">
                                <label>ইমার্জেন্সি কন্টাক্ট</label>
                                <input type="text" name="emergency_contact" value="<?php echo htmlspecialchars($profile['emergency_contact'] ?? ''); ?>">
                            </div>

                            <div class="form-group">
                                <label>শহর</label>
                                <input type="text" name="city" value="<?php echo htmlspecialchars($profile['city'] ?? ''); ?>">
                            </div>

                            <div class="form-group">
                                <label>অঞ্চল / জেলা</label>
                                <input type="text" name="state" value="<?php echo htmlspecialchars($profile['state'] ?? ''); ?>">
                            </div>

                            <div class="form-group">
                                <label>পোস্টকোড</label>
                                <input type="text" name="postal_code" value="<?php echo htmlspecialchars($profile['postal_code'] ?? ''); ?>">
                            </div>

                            <div class="form-group" style="grid-column:1 / -1;">
                                <label>ঠিকানা</label>
                                <textarea name="address" rows="3"><?php echo htmlspecialchars($profile['address'] ?? ''); ?></textarea>
                            </div>

                            <div class="form-group" style="grid-column:1 / -1;">
                                <label>বায়ো / সংক্ষিপ্ত পরিচিতি</label>
                                <textarea name="bio" rows="3"><?php echo htmlspecialchars($profile['bio'] ?? ''); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
                    <a href="dashboard.php" class="btn btn-secondary" style="text-decoration:none;display:inline-flex;align-items:center;">বিবরণ দেখুন</a>
                </div>
            </form>
        </div>
    </main>
</div>

</body>
</html>
