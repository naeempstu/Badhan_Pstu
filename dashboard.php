<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Get user info
$stmt = $conn->prepare("SELECT id, full_name, email FROM users WHERE username = ? LIMIT 1");
$stmt->bind_param('s', $username);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->num_rows ? $res->fetch_assoc() : null;
$user_id = $user['id'] ?? null;

// Get user profile if exists
$profile = null;
if ($user_id) {
    $stmt = $conn->prepare("SELECT * FROM user_profiles WHERE user_id = ? LIMIT 1");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $pr = $stmt->get_result();
    $profile = $pr->num_rows ? $pr->fetch_assoc() : null;
}

// Get profile ID for versions link
$profile_id = $profile['id'] ?? null;

// Get blood requests
$stmt = $conn->prepare("SELECT * FROM blood_requests ORDER BY request_date DESC LIMIT 10");
$stmt->execute();
$br_result = $stmt->get_result();
$blood_requests = [];
while ($row = $br_result->fetch_assoc()) {
    $blood_requests[] = $row;
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ড্যাশবোর্ড - বাঁধন পবিপ্রবি</title>
    <link rel="stylesheet" href="static/css/dashboard.css">
    <style>
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .dashboard-card {
            background: #fff;
            border: 1px solid #f1f5f9;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .dashboard-card h3 {
            margin: 0 0 10px 0;
            color: #b91c1c;
            font-size: 1.1rem;
        }
        .dashboard-card p {
            margin: 0 0 15px 0;
            color: #6b7280;
            font-size: 0.9rem;
            line-height: 1.5;
        }
        .dashboard-card .btn {
            display: inline-block;
            padding: 8px 16px;
            background: #e63946;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: background 0.2s;
        }
        .dashboard-card .btn:hover {
            background: #d00000;
        }
        .welcome-section {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .welcome-section h1 {
            margin: 0 0 5px 0;
            color: #b91c1c;
        }
        .welcome-section p {
            margin: 0;
            color: #6b7280;
        }
        .blood-requests-section {
            margin-top: 30px;
            padding: 20px;
            background: #fff;
            border: 1px solid #f1f5f9;
            border-radius: 10px;
        }
        .blood-requests-section h2 {
            margin-top: 0;
            color: #b91c1c;
            margin-bottom: 20px;
        }
        .blood-requests-table {
            width: 100%;
            border-collapse: collapse;
        }
        .blood-requests-table thead {
            background: #fee2e2;
        }
        .blood-requests-table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #b91c1c;
            border-bottom: 2px solid #fecaca;
        }
        .blood-requests-table td {
            padding: 12px;
            border-bottom: 1px solid #f1f5f9;
        }
        .blood-requests-table tbody tr:hover {
            background: #fef2f2;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        .status-approved {
            background: #d1fae5;
            color: #065f46;
        }
        .status-completed {
            background: #dbeafe;
            color: #1e40af;
        }
        .blood-requests-empty {
            text-align: center;
            padding: 40px 20px;
            color: #6b7280;
        }
        @media (max-width: 900px) {
            .blood-requests-table {
                font-size: 0.9rem;
            }
            .blood-requests-table th,
            .blood-requests-table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body class="dashboard-body">

<div class="dash-wrapper">
    <aside class="dash-sidebar">
        <h3>ড্যাশবোর্ড</h3>
        <ul>
            <li><a href="dashboard.php" class="active">হোম</a></li>
            <li><a href="profile.php">আপনার প্রোফাইল</a></li>
            <li><a href="profiles_list.php">প্রোফাইল তালিকা</a></li>
            <li><a href="contact.php">রক্তের আবেদন</a></li>
            <?php if ($profile_id): ?>
            <li><a href="profile_versions.php?up=<?php echo $profile_id; ?>">প্রোফাইল সংস্করণ</a></li>
            <?php endif; ?>
            <?php if (!empty($_SESSION['is_admin'])): ?>
            <li><a href="admin/index.php">অ্যাডমিন প্যানেল</a></li>
            <?php endif; ?>
            <li><a href="logout.php">লগআউট</a></li>
        </ul>
    </aside>

    <main class="dash-main">
        <div class="welcome-section">
            <h1>স্বাগতম, <?php echo htmlspecialchars($user['full_name'] ?? $username); ?>!</h1>
            <p>ইমেইল: <?php echo htmlspecialchars($user['email'] ?? ''); ?></p>
        </div>

        <h2>দ্রুত অ্যাক্সেস</h2>
        
        <div class="dashboard-cards">
            <div class="dashboard-card">
                <h3>📋 আপনার প্রোফাইল</h3>
                <p>আপনার ব্যক্তিগত তথ্য দেখুন এবং সম্পাদনা করুন। প্রোফাইল আপডেট করুন, ছবি যোগ করুন এবং আপনার তথ্য সংরক্ষণ করুন।</p>
                <a href="profile.php" class="btn">প্রোফাইল দেখুন</a>
            </div>

            <div class="dashboard-card">
                <h3>👥 প্রোফাইল তালিকা</h3>
                <p>সকল সদস্যদের প্রোফাইল দেখুন, অনুসন্ধান করুন এবং পরিচালনা করুন। প্রোফাইল সম্পাদনা, সংস্করণ দেখুন এবং PDF এক্সপোর্ট করুন।</p>
                <a href="profiles_list.php" class="btn">তালিকা দেখুন</a>
            </div>

            <div class="dashboard-card">
                <h3>🩸 রক্তের আবেদন</h3>
                <p>রক্তের প্রয়োজন হলে আবেদন করুন। রোগীর তথ্য, রক্তের গ্রুপ এবং প্রয়োজনীয় তারিখ সহ আবেদন জমা দিন।</p>
                <a href="contact.php" class="btn">আবেদন করুন</a>
            </div>

            <?php if ($profile_id): ?>
            <div class="dashboard-card">
                <h3>📜 প্রোফাইল সংস্করণ</h3>
                <p>আপনার প্রোফাইলের পূর্ববর্তী সংস্করণগুলো দেখুন এবং প্রয়োজন হলে পূর্ববর্তী সংস্করণে ফিরে যান।</p>
                <a href="profile_versions.php?up=<?php echo $profile_id; ?>" class="btn">সংস্করণ দেখুন</a>
            </div>
            <?php else: ?>
            <div class="dashboard-card">
                <h3>📜 প্রোফাইল সংস্করণ</h3>
                <p>প্রোফাইল সংস্করণ দেখতে প্রথমে আপনার প্রোফাইল তৈরি করুন।</p>
                <a href="profile.php" class="btn">প্রোফাইল তৈরি করুন</a>
            </div>
            <?php endif; ?>
        </div>

        <?php if ($profile): ?>
        <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 10px;">
            <h3 style="margin-top: 0;">আপনার প্রোফাইল সারাংশ</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                <div>
                    <strong>নাম:</strong> <?php echo htmlspecialchars($profile['full_name'] ?? 'N/A'); ?>
                </div>
                <div>
                    <strong>রক্তের গ্রুপ:</strong> <?php echo htmlspecialchars($profile['blood_group'] ?? 'N/A'); ?>
                </div>
                <div>
                    <strong>ফোন:</strong> <?php echo htmlspecialchars($profile['phone'] ?? 'N/A'); ?>
                </div>
                <div>
                    <strong>শহর:</strong> <?php echo htmlspecialchars($profile['city'] ?? 'N/A'); ?>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div style="margin-top: 30px; padding: 20px; background: #fff3cd; border-radius: 10px; border-left: 4px solid #ffc107;">
            <h3 style="margin-top: 0; color: #856404;">প্রোফাইল তৈরি করুন</h3>
            <p style="color: #856404; margin-bottom: 15px;">আপনার প্রোফাইল এখনও তৈরি হয়নি। আপনার ব্যক্তিগত তথ্য যোগ করতে নিচের বাটনে ক্লিক করুন।</p>
            <a href="profile.php" class="btn" style="background: #ffc107; color: #000;">প্রোফাইল তৈরি করুন</a>
        </div>
        <?php endif; ?>
    </main>
</div>

</body>
</html>

<!-- Blood Requests Section -->
<div class="dash-wrapper">
    <div class="blood-requests-section" style="grid-column: 1 / -1;">
        <h2>🩸 রক্তের চাহিদা</h2>
        
        <?php if (count($blood_requests) > 0): ?>
            <table class="blood-requests-table">
                <thead>
                    <tr>
                        <th>রোগীর নাম</th>
                        <th>রক্তের গ্রুপ</th>
                        <th>প্রয়োজন তারিখ</th>
                        <th>হাসপাতাল</th>
                        <th>ফোন</th>
                        <th>স্ট্যাটাস</th>
                        <th>অনুরোধ তারিখ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($blood_requests as $req): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($req['patient_name']); ?></strong></td>
                        <td><?php echo htmlspecialchars($req['blood_group']); ?></td>
                        <td><?php echo htmlspecialchars($req['needed_date']); ?></td>
                        <td><?php echo htmlspecialchars($req['hospital']); ?></td>
                        <td><?php echo htmlspecialchars($req['phone']); ?></td>
                        <td>
                            <?php
                            $status = $req['status'];
                            $class = "status-pending";
                            $label = 'পেন্ডিং';
                            if ($status === 'approved') {
                                $class = "status-approved";
                                $label = 'অনুমোদিত';
                            } elseif ($status === 'completed') {
                                $class = "status-completed";
                                $label = 'সম্পন্ন';
                            }
                            ?>
                            <span class="status-badge <?php echo $class; ?>"><?php echo $label; ?></span>
                        </td>
                        <td><?php echo htmlspecialchars($req['request_date']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="blood-requests-empty">
                <p>এখনও কোনো রক্তের অনুরোধ নেই।</p>
                <a href="contact.php" class="btn" style="display: inline-block; margin-top: 10px;">রক্তের আবেদন করুন</a>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>