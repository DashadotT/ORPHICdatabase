<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'connection.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    echo "Access denied. Admins only.";
    exit();
}

try {
    $stmt = $pdo->query("SELECT user_id, user_name, user_fullname, is_admin FROM tbl_user");
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f6fb;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #2d3a4b;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #fff;
        }

        .navbar h2 {
            margin: 0;
            font-size: 20px;
        }

        .logout-btn {
            background-color: #ff4c4c;
            color: #fff;
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 6px;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #e04343;
        }

        .admin-container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 32px 40px;
        }

        h1 {
            text-align: center;
            color: #2d3a4b;
            margin-bottom: 32px;
            letter-spacing: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fafbfc;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        th {
            background: #2d3a4b;
            color: #fff;
            font-weight: 600;
            padding: 14px 10px;
            text-align: left;
        }

        td {
            padding: 12px 10px;
            border-bottom: 1px solid #e5e9f2;
            color: #333;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:nth-child(even) td {
            background: #f4f6fb;
        }

        @media (max-width: 700px) {
            .admin-container {
                padding: 16px 4px;
            }
            table, th, td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="navbar">
    <h2>ORPHIC Admin Panel</h2>
    <form action="logout.php" method="post" style="margin: 0;">
        <button class="logout-btn" type="submit">Logout</button>
    </form>
</div>

<div class="admin-container">
    <h1>Admin Dashboard</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Admin?</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['user_id']) ?></td>
                    <td><?= htmlspecialchars($user['user_name']) ?></td>
                    <td><?= htmlspecialchars($user['user_fullname']) ?></td>
                    <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
