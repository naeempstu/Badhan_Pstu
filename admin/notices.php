<?php
require_once '../includes/admin_auth.php';
require_once '../db_connect.php';

// Handle create/update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $is_published = isset($_POST['is_published']) ? 1 : 0;
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($id) {
        $stmt = $conn->prepare("UPDATE notices SET title=?, content=?, is_published=? WHERE id=?");
        $stmt->bind_param('ssii', $title, $content, $is_published, $id);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO notices (title, content, is_published) VALUES (?, ?, ?)");
        $stmt->bind_param('ssi', $title, $content, $is_published);
        $stmt->execute();
    }
    header('Location: notices.php');
    exit();
}

// Handle delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM notices WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: notices.php');
    exit();
}

// Load edit
$editNotice = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM notices WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $editNotice = $res->num_rows ? $res->fetch_assoc() : null;
}

// Fetch all notices
$notices = [];
$res = $conn->query("SELECT * FROM notices ORDER BY created_at DESC");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $notices[] = $row;
    }
}

?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>নোটিশ ব্যবস্থাপনা - Admin</title>
    <link rel="stylesheet" href="../static/css/dashboard.css">
</head>
<body class="dashboard-body">
<div class="dash-wrapper">
    <aside class="dash-sidebar">
        <h3>অ্যাডমিন প্যানেল</h3>
        <ul>
            <li><a href="index.php">ড্যাশবোর্ড</a></li>
            <li><a href="notices.php" class="active">নোটিশ ব্যবস্থাপনা</a></li>
            <li><a href="news.php">নিউজ ব্যবস্থাপনা</a></li>
            <li><a href="gallery.php">গ্যালারি ব্যবস্থাপনা</a></li>
            <li><a href="../logout.php">লগআউট</a></li>
        </ul>
    </aside>

    <main class="dash-main">
        <h1>নতুন নোটিশ</h1>
        <form method="POST" style="margin-bottom:20px;">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($editNotice['id'] ?? ''); ?>">
            <div>
                <label>শিরোনাম</label><br>
                <input type="text" name="title" value="<?php echo htmlspecialchars($editNotice['title'] ?? ''); ?>" required style="width:100%; padding:8px;">
            </div>
            <div style="margin-top:8px;">
                <label>বিবরণ</label><br>
                <textarea name="content" rows="6" style="width:100%; padding:8px;" required><?php echo htmlspecialchars($editNotice['content'] ?? ''); ?></textarea>
            </div>
            <div style="margin-top:8px;">
                <label><input type="checkbox" name="is_published" <?php echo (!empty($editNotice) && $editNotice['is_published']) ? 'checked' : ''; ?>> প্রকাশিত</label>
            </div>
            <div style="margin-top:10px;">
                <button class="btn btn-primary" type="submit">সেভ করুন</button>
                <?php if ($editNotice): ?>
                    <a class="btn btn-secondary" href="notices.php">বাতিল</a>
                <?php endif; ?>
            </div>
        </form>

        <h2>মোট নোটিশ</h2>
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#fee2e2;">
                    <th style="padding:10px; text-align:left;">ID</th>
                    <th style="padding:10px; text-align:left;">শিরোনাম</th>
                    <th style="padding:10px; text-align:left;">প্রকাশিত</th>
                    <th style="padding:10px; text-align:left;">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($notices as $n): ?>
                <tr>
                    <td style="padding:10px; border-top:1px solid #f1f5f9;"><?php echo $n['id']; ?></td>
                    <td style="padding:10px; border-top:1px solid #f1f5f9;"><?php echo htmlspecialchars($n['title']); ?></td>
                    <td style="padding:10px; border-top:1px solid #f1f5f9;"><?php echo $n['is_published'] ? 'হ্যাঁ' : 'না'; ?></td>
                    <td style="padding:10px; border-top:1px solid #f1f5f9;">
                        <a class="btn-action btn-edit" href="notices.php?action=edit&id=<?php echo $n['id']; ?>">সম্পাদনা</a>
                        <a class="btn-action btn-delete" href="notices.php?action=delete&id=<?php echo $n['id']; ?>" onclick="return confirm('আপনি কি নিশ্চিতভাবে মুছে ফেলতে চান?');">মুছে ফেলুন</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</div>
</body>
</html>