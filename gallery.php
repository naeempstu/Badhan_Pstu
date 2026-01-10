<?php session_start(); ?>
<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>গ্যালারি</title>
<link rel="icon" type="image/x-icon" href="picture/badhon.jpeg">
<link rel="stylesheet" href="static/css/index.css">
<link rel="stylesheet" href="static/css/about.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<?php include 'component/navbar.php'; ?>



<div class="main-content">
    <section class="hero-section">
        <h1>গ্যালারি</h1>
    </section>

    <?php
    include 'db_connect.php';
    $imgs = [];
    $res = $conn->query("SELECT * FROM gallery ORDER BY uploaded_at DESC");
    if ($res) {
        while ($row = $res->fetch_assoc()) { $imgs[] = $row; }
    }
    ?>

    <div class="about-cards" style="display:grid; grid-template-columns: repeat(auto-fit,minmax(220px,1fr)); gap:12px; margin:20px;">
        <?php if (empty($imgs)): ?>
            <div class="card"><p>কোন ছবি পাওয়া যায়নি। পরবর্তীতে আবার চেক করুন।</p></div>
        <?php else: foreach ($imgs as $it): ?>
            <div class="card" style="padding:0; text-align:center;">
                <img src="Picture/gallery/<?php echo htmlspecialchars($it['filename']); ?>" style="width:100%; height:220px; object-fit:cover; display:block;">
                <div style="padding:10px;"><?php echo htmlspecialchars($it['caption']); ?></div>
            </div>
        <?php endforeach; endif; ?>
    </div>


   

      </div>
<!-- ================= FOOTER ================= -->
<?php include 'component/footer.php';?>


</body>
</html>