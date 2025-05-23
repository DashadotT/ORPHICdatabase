<?php
session_start();
require_once 'connection.php';

// Check if user is admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    // Not admin, redirect to login or error page
    header("Location: login.php");
    exit();
}

// Fetch user info from DB to display
$query = "SELECT user_id, user_name, user_fullname FROM tbl_user";
$result = $conn->query($query);

?>
<!DOCTYPE html>
<html lang="en">
<head><title>Admin Dashboard</title></head>
<body>
<h1>Admin Dashboard - Users</h1>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>Full Name</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) : ?>
    <tr>
        <td><?= htmlspecialchars($row['user_id']) ?></td>
        <td><?= htmlspecialchars($row['user_name']) ?></td>
        <td><?= htmlspecialchars($row['user_fullname']) ?></td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
