<?php
session_start();
require_once 'connection.php'; // Your PDO connection setup

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required inputs
    if (empty($_POST['fullname'])  || empty($_POST['username']) || empty($_POST['password'])) {
        die("Please fill in all required fields.");
    }

    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Check if username or email already exists
    $stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE user_name = ?");
    $stmt->execute([$username,]);
    if ($stmt->fetch()) {
        die("Username or email already taken. Please choose another.");
    }

    // Hash the password securely
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $insert = $pdo->prepare("INSERT INTO tbl_user (user_fullname, user_name, user_password) VALUES (?, ?, ?)");
    $result = $insert->execute([$fullname, $username, $password]);

    if ($result) {
        // Optional: log the user in immediately
        $_SESSION['username'] = $username;
        echo "Registration successful! Welcome, " . htmlspecialchars($username) . ".";
        header("Location: Home.php"); // Redirect to home or login page
        exit();
    } else {
        echo "Error during registration. Please try again.";
    }
} else {
    echo "Invalid request method.";
}
?>
