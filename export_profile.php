<?php
// export_profile.php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['username'])) { 
    header('Location: login.php'); 
    exit(); 
}

$id = intval($_GET['id'] ?? 0);
$version_id = intval($_GET['version'] ?? 0);

if ($id <= 0) { 
    echo 'Invalid profile id'; 
    exit(); 
}

// If version is specified, get data from version table, otherwise from profile table
if ($version_id > 0) {
    $stmt = $conn->prepare("SELECT v.*, u.username, u.email FROM user_profile_versions v JOIN users u ON u.id = v.user_id WHERE v.id = ? AND v.user_profile_id = ? LIMIT 1");
    $stmt->bind_param('ii', $version_id, $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows == 0) { 
        echo 'Version not found'; 
        exit(); 
    }
    $p = $res->fetch_assoc();
    $is_version = true;
} else {
    $stmt = $conn->prepare("SELECT up.*, u.username, u.email FROM user_profiles up JOIN users u ON u.id = up.user_id WHERE up.id = ? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows == 0) { 
        echo 'Profile not found'; 
        exit(); 
    }
    $p = $res->fetch_assoc();
    $is_version = false;
}

// Build HTML content
$html = '<!DOCTYPE html>
<html lang="bn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; color: #333; }
        .header { border-bottom: 3px solid #e63946; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { color: #e63946; margin: 0; }
        .info-section { margin-bottom: 20px; }
        .info-row { margin: 10px 0; }
        .info-label { font-weight: bold; color: #666; display: inline-block; width: 150px; }
        .info-value { color: #333; }
        .photo-section { text-align: center; margin: 20px 0; }
        .photo-section img { max-width: 200px; border-radius: 10px; border: 3px solid #e63946; }
    </style>
</head>
<body>
    <div class="header">
        <h1>BADHAN PSTU UNIT - Profile Information</h1>
        ' . ($is_version ? '<p style="color: #666; font-size: 0.9em;">Version Export</p>' : '') . '
    </div>
    
    <div class="photo-section">';
    
if (!empty($p['photo'])) {
    $photo_path = __DIR__ . '/' . $p['photo'];
    if (file_exists($photo_path)) {
        $image_data = file_get_contents($photo_path);
        $image_base64 = base64_encode($image_data);
        $image_info = getimagesize($photo_path);
        $mime_type = $image_info['mime'];
        $html .= '<img src="data:' . $mime_type . ';base64,' . $image_base64 . '" alt="Profile Photo">';
    }
}

$html .= '</div>
    
    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Full Name:</span>
            <span class="info-value">' . htmlspecialchars($p['full_name'] ?? 'N/A') . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email:</span>
            <span class="info-value">' . htmlspecialchars($p['email'] ?? 'N/A') . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">Username:</span>
            <span class="info-value">' . htmlspecialchars($p['username'] ?? 'N/A') . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">Phone:</span>
            <span class="info-value">' . htmlspecialchars($p['phone'] ?? 'N/A') . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">Date of Birth:</span>
            <span class="info-value">' . htmlspecialchars($p['dob'] ?? 'N/A') . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">Gender:</span>
            <span class="info-value">' . htmlspecialchars($p['gender'] ?? 'N/A') . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">Blood Group:</span>
            <span class="info-value">' . htmlspecialchars($p['blood_group'] ?? 'N/A') . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">Emergency Contact:</span>
            <span class="info-value">' . htmlspecialchars($p['emergency_contact'] ?? 'N/A') . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">City:</span>
            <span class="info-value">' . htmlspecialchars($p['city'] ?? 'N/A') . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">State/District:</span>
            <span class="info-value">' . htmlspecialchars($p['state'] ?? 'N/A') . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">Postal Code:</span>
            <span class="info-value">' . htmlspecialchars($p['postal_code'] ?? 'N/A') . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">Address:</span>
            <span class="info-value">' . nl2br(htmlspecialchars($p['address'] ?? 'N/A')) . '</span>
        </div>
        <div class="info-row">
            <span class="info-label">Bio:</span>
            <span class="info-value">' . nl2br(htmlspecialchars($p['bio'] ?? 'N/A')) . '</span>
        </div>
    </div>
    
    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; text-align: center; color: #666; font-size: 0.9em;">
        <p>Generated on: ' . date('Y-m-d H:i:s') . '</p>
        <p>© 2025 BADHAN PSTU UNIT. All Rights Reserved.</p>
    </div>
</body>
</html>';

// Try to use Dompdf if installed
$autoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoload)) {
    require_once $autoload;
}

if (class_exists('Dompdf\Dompdf')) {
    try {
        $dompdf = new Dompdf\Dompdf([
            'enable_remote' => true,
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true
        ]);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->set_option('defaultFont', 'DejaVu Sans');
        $dompdf->render();
        
        $filename = 'profile_' . ($p['user_id'] ?? $p['id']) . ($is_version ? '_v' . $version_id : '') . '_' . date('YmdHis') . '.pdf';
        
        // Check if user wants to download (attachment=1) or view in browser (attachment=0)
        // Default: view in browser (allows save option via browser's save button)
        $download = isset($_GET['download']) && $_GET['download'] == '1';
        
        if ($download) {
            // Force download - output PDF directly with proper headers
            $pdf_output = $dompdf->output();
            
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . strlen($pdf_output));
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
            header('Expires: 0');
            
            echo $pdf_output;
            exit();
        } else {
            // View in browser - use stream method
            $dompdf->stream($filename, [
                'Attachment' => 0  // 0 = view in browser (with save option)
            ]);
            exit();
        }
    } catch (Exception $e) {
        error_log("PDF Generation Error: " . $e->getMessage());
        echo '<p style="color: red;">Error generating PDF: ' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '<hr>';
        echo $html;
        exit();
    }
} else {
    // Fallback: output as printable HTML (no installation instructions)
    header('Content-Type: text/html; charset=utf-8');
    echo $html;
    exit();
}
