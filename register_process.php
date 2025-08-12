<?php
session_start();
include 'db.php';

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Check password match
if ($password !== $confirm_password) {
    echo "<script>alert('Passwords do not match'); window.history.back();</script>";
    exit;
}

// Check if username already exists
$stmt = $con->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo "<script>alert('Username already taken'); window.history.back();</script>";
    $stmt->close();
    exit;
}
$stmt->close();

// Check if email already exists
$stmt = $con->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo "<script>alert('Email already registered'); window.history.back();</script>";
    $stmt->close();
    exit;
}
$stmt->close();

// Handle avatar upload
$avatar_path = "admin/image/default.png";
if (!empty($_FILES['avatar']['name'])) {
    $upload_dir = "admin/image/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    $filename = time() . "_" . basename($_FILES['avatar']['name']);
    $target = $upload_dir . $filename;
    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
        $avatar_path = $target;
    }
}

// Save user (NO password hashing)
$stmt = $con->prepare("INSERT INTO users (username, email, password, profile_img) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $email, $password, $avatar_path);
$stmt->execute();

// Set session
$_SESSION['user_id'] = $stmt->insert_id;
$_SESSION['username'] = $username;
$_SESSION['profile_img'] = $avatar_path;

$stmt->close();
header("Location: index.php");
exit;
?>
