<?php
session_start();
include 'db_connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $conn->prepare("SELECT * FROM news WHERE id = ? AND is_published = 1 LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$news = $res->num_rows ? $res->fetch_assoc() : null;
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $news ? htmlspecialchars($news['title']) : 'নিউজ পাওয়া যায়নি'; ?></title>
   
    <link rel="stylesheet" href="static/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<?php include 'component/navbar.php'; ?>

<div class="main-content" style="padding:20px;">
    <?php if (!$news): ?>
        <div class="about-cards">
            <div class="card">
                <h2>নিউজ পাওয়া যায়নি</h2>
                <p>আপনি যে নিউজটি দেখার চেষ্টা করছেন তা পাওয়া যায়নি অথবা এটি প্রকাশ করা হয়নি।</p>
                <p><a href="activities.php">ব্যাক টু কার্যক্রমসমূহ</a></p>
            </div>
        </div>
    <?php else: ?>
        <section class="hero-section">
            <h1><?php echo htmlspecialchars($news['title']); ?></h1>
            <small><?php echo htmlspecialchars($news['created_at']); ?></small>
        </section>

        <div style="max-width:900px; margin:20px auto; background:#fff; padding:18px; border-radius:8px;">
            <?php if (!empty($news['image'])): ?>
                <div style="text-align:center; margin-bottom:12px;"><img src="Picture/news/<?php echo htmlspecialchars($news['image']); ?>" style="max-width:100%; height:auto;"></div>
            <?php endif; ?>
            <div style="color:#333; line-height:1.7;">
                <?php echo nl2br(htmlspecialchars($news['content'])); ?>
            </div>
            <p style="margin-top:12px;"><a href="activities.php" class="btn-back">ফিরে যান</a></p>
        </div>
    <?php endif; ?>
</div>

<!-- ================= FOOTER ================= -->
<?php include 'component/footer.php';?>
</body>
</html>