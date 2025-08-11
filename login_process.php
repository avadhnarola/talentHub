<?php
session_start();
include 'db.php';

$email = trim($_POST['email']);
$password = $_POST['password'];

$stmt = $con->prepare("SELECT id, username, profile_img FROM users WHERE email = ? AND password = ?");
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $username, $profile_img);
    $stmt->fetch();
    $_SESSION['user_id'] = $id;
    $_SESSION['username'] = $username;
    $_SESSION['profile_img'] = $profile_img;
    header("Location: index.php");
} else {
    echo "<script>alert('Invalid credentials'); window.history.back();</script>";
}
$stmt->close();
?>
