<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['userId'])) {
    // User is logged in, you can access session variables
    $username = $_SESSION['userId'];
} else {
    // User is not logged in
    $username = null;
}


$host = 'localhost';
$db   = 'orphic';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options); // <-- this defines $pdo
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>