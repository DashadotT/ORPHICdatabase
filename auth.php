<?php
session_start();
require_once 'connection.php'; // assumes $pdo (PDO is used here)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user info from DB
    $stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE user_name = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && $password === $user['user_password']) { // use password_verify() for hashed passwords
        $_SESSION['username'] = $user['user_name'];
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['is_admin'] = $user['is_admin']; // Store admin status

        if ($user['is_admin'] == 1) {
            header("Location: admin_page.php"); // Redirect admin
        } else {
            header("Location: Home.php"); // Redirect normal user
        }
        exit();
    } else {
        echo "<script>alert('Invalid username or password'); window.location.href='login.php';</script>";
    }
}
?>
