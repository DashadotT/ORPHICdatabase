<?php
session_start();
require_once 'connection.php'; // contains $pdo (use mysqli if different)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepared statement to avoid SQL injection
    $stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE user_name = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && $password == $user['user_password']) { // You can use password_verify() if password is hashed
        $_SESSION['username'] = $user['user_name']; // Create session
        $_SESSION['user_id'] = $user['user_id'];    // Optional: store ID
        header("Location: Home.php"); // Redirect to a logged-in page
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
?>
