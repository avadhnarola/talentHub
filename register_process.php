<?php
session_start();
include 'db.php';

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if ($password !== $confirm_password) {
    echo "<script>alert('Passwords do not match'); window.history.back();</script>";
    exit;
}

// Check if username exists
$stmt = $con->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo "<script>alert('Username already taken'); window.history.back();</script>";
    exit;
}
$stmt->close();

// Handle avatar
$avatar_path = "uploads/default.png";
if (!empty($_FILES['avatar']['name'])) {
    $filename = time() . "_" . basename($_FILES['avatar']['name']);
    $target = "uploads/" . $filename;
    move_uploaded_file($_FILES['avatar']['tmp_name'], $target);
    $avatar_path = $target;
}

// Save user (no hash password)
$stmt = $con->prepare("INSERT INTO users (username, email, password, confirm_password, profile_img) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $username, $email, $password, $confirm_password, $avatar_path);
$stmt->execute();

// Set session
$_SESSION['user_id'] = $stmt->insert_id;
$_SESSION['username'] = $username;
$_SESSION['profile_img'] = $avatar_path;

$stmt->close();
header("Location: index.php");
exit;
?>
