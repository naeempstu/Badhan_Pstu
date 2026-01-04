<?php
require_once '../includes/admin_auth.php';
require_once '../db_connect.php';

$uploadDir = __DIR__ . '/../Picture/gallery/';
if (!is_dir($uploadDir)) { mkdir($uploadDir, 0755, true); }

// Handle upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $caption = $_POST['caption'] ?? '';
    if (!empty($_FILES['image']['name'])) {
        $tmp = $_FILES['image']['tmp_name'];
        $orig = basename($_FILES['image']['name']);
        $ext = pathinfo($orig, PATHINFO_EXTENSION);
        $imageName = uniqid('gallery_') . '.' . $ext;
        move_uploaded_file($tmp, $uploadDir . $imageName);
        $stmt = $conn->prepare("INSERT INTO gallery (filename, caption) VALUES (?, ?)");
        $stmt->bind_param('ss', $imageName, $caption);
        $stmt->execute();
    }
    header('Location: gallery.php');
    exit();
}

// Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT filename FROM gallery WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $r = $stmt->get_result()->fetch_assoc();
    if ($r && $r['filename']) { @unlink($uploadDir . $r['filename']); }
    $stmt = $conn->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: gallery.php');
    exit();
}

// Fetch
$items = [];
$res = $conn->query("SELECT * FROM gallery ORDER BY uploaded_at DESC");
if ($res) { while ($row = $res->fetch_assoc()) { $items[] = $row; } }

?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>গ্যালারি ব্যবস্থাপনা - Admin</title>
    <link rel="stylesheet" href="../static/css/dashboard.css">
</head>
<body class="dashboard-body">
<div class="dash-wrapper">
    <aside class="dash-sidebar">
        <h3>অ্যাডমিন প্যানেল</h3>
        <ul>
            <li><a href="index.php">ড্যাশবোর্ড</a></li>
            <li><a href="notices.php">নোটিশ ব্যবস্থাপনা</a></li>
            <li><a href="news.php">নিউজ ব্যবস্থাপনা</a></li>
            <li><a href="gallery.php" class="active">গ্যালারি ব্যবস্থাপনা</a></li>
            <li><a href="../logout.php">লগআউট</a></li>
        </ul>
    </aside>

    <main class="dash-main">
        <h1>গ্যালারি - ছবি আপলোড</h1>
        <form method="POST" enctype="multipart/form-data" style="margin-bottom:20px;">
            <div>
                <label>ক্যাপশন (ঐচ্ছিক)</label><br>
                <input type="text" name="caption" style="width:100%; padding:8px;">
            </div>
            <div style="margin-top:8px;">
                <label>ছবি</label><br>
                <input type="file" name="image" accept="image/*" required>
            </div>
            <div style="margin-top:10px;">
                <button class="btn" type="submit">আপলোড</button>
            </div>
        </form>

        <h2>গ্যালারি আইটেম</h2>
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(160px,1fr)); gap:12px;">
            <?php foreach($items as $it): ?>
                <div style="border:1px solid #f1f5f9; padding:8px; background:#fff; border-radius:6px; text-align:center;"> 
                    <img src="../Picture/gallery/<?php echo htmlspecialchars($it['filename']); ?>" style="max-width:100%; height:140px; object-fit:cover; margin-bottom:8px;">
                    <div style="font-size:0.9rem; color:#6b7280; margin-bottom:8px;"><?php echo htmlspecialchars($it['caption']); ?></div>
                    <a class="btn" href="gallery.php?action=delete&id=<?php echo $it['id']; ?>" style="background:#6b7280;">মুছে ফেলুন</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</div>
</body>
</html>