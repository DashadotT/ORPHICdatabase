<?php
session_start();
require_once "connection.php";

if (!isset($_SESSION['user_id'])) {
    echo "Not logged in.";
    exit();
}

$userId = $_SESSION['user_id'];
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';

if ($name && $email) {
    $stmt = $pdo->prepare("UPDATE tbl_user SET user_fullname = ?, user_name = ? WHERE user_id = ?");
    if ($stmt->execute([$name, $email, $userId])) {
        echo "Account updated successfully.";
    } else {
        echo "Update failed.";
    }
} else {
    echo "Please fill in all fields.";
}
