<?php session_start(); ?>
<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>যোগাযোগ</title>
<link rel="icon" type="image/x-icon" href="picture/badhon.jpeg">
<link rel="stylesheet" href="static/css/index.css">
<link rel="stylesheet" href="static/css/about.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<?php include 'component/navbar.php'; ?>

<div class="main-content">
    <section class="hero-section">
        <h1>নোটিশ বোর্ড</h1>
        

    </section>
   
 <div class="about-cards">
    <?php
    include 'db_connect.php';
    $notices = [];
    $res = $conn->query("SELECT * FROM notices WHERE is_published=1 ORDER BY created_at DESC");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $notices[] = $row;
        }
    }

    if (empty($notices)): ?>
        <div class="card">
            <p>কোন নোটিশ পাওয়া যায়নি। এখনও কোন নোটিশ প্রকাশ করা হয়নি। দয়া করে পরে আবার চেষ্টা করুন।</p>
        </div>
    <?php else:
        foreach ($notices as $n): ?>
            <div class="card">
                <h3><?php echo htmlspecialchars($n['title']); ?></h3>
                <small><?php echo htmlspecialchars($n['created_at']); ?></small>
                <p><?php echo nl2br(htmlspecialchars($n['content'])); ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    
    </div>
    </div>
    
<!-- ================= FOOTER ================= -->
<?php include 'component/footer.php';?>



</body>
</html>