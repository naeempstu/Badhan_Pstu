<?php
session_start();
include 'db_connect.php';

// Initialize variables
$error = "";
$success = "";
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $patient_name = trim($_POST['patient_name']);
    $blood_group = trim($_POST['blood_group']);
    $needed_date = trim($_POST['needed_date']);
    $hospital = trim($_POST['hospital']);
    $phone = trim($_POST['phone']);
    $details = trim($_POST['details']);

    // Basic validation
    $errors = [];

    if (empty($patient_name)) {
        $errors[] = "Patient name is required";
    }

    if (empty($blood_group)) {
        $errors[] = "Blood group is required";
    }

    if (empty($needed_date)) {
        $errors[] = "Needed date is required";
    }

    if (empty($hospital)) {
        $errors[] = "Hospital name is required";
    }

    if (empty($phone)) {
        $errors[] = "Phone number is required";
    }

    // If no errors, insert into database
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO blood_requests (patient_name, blood_group, needed_date, hospital, phone, details) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $patient_name, $blood_group, $needed_date, $hospital, $phone, $details);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "রক্তের আবেদন সফলভাবে জমা হয়েছে! আমরা শীঘ্রই আপনার সাথে যোগাযোগ করব।";
        } else {
            $_SESSION['error_message'] = "দুঃখিত, একটি ত্রুটি occurred. অনুগ্রহ করে পরে আবার চেষ্টা করুন।";
        }

        $stmt->close();
    } else {
        $_SESSION['error_message'] = implode("<br>", $errors);
    }

    $conn->close();

    // Redirect back to contact page
    header("Location: contact.php");
    exit();
} else {
    // If someone tries to access this page directly
    header("Location: contact.php");
    exit();
}
?>