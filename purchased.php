<?php
require_once 'connection.php';

// Fetch the user - adjust this if you have login/session management
$user = $pdo->prepare("SELECT * FROM tbl_user LIMIT 1");
$user->execute();
$selUser = $user->fetch(PDO::FETCH_ASSOC);

if (!$selUser) {
    die("User not found.");
}

// Fetch purchased items joined with product info for this user
$purchased = $pdo->prepare("
    SELECT p.product_name, p.product_price, p.product_rating, p.product_image, pi.purchase_date
    FROM tbl_purchased_items pi
    JOIN tbl_product p ON pi.product_id = p.product_id
    WHERE pi.user_id = ?
    ORDER BY pi.purchase_date DESC
");
$purchased->execute([$selUser['user_id']]);
$items = $purchased->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Purchased Items - ORPHIC</title>
    <link rel="stylesheet" href="cart.css" />
</head>
<body>

<!-- Navbar -->
<nav>
    <div class="navbar">
        <img src="https://c.animaapp.com/maksq8u46pByZ6/img/logo.png" alt="Orphic Logo" />
        <div class="navbar-links">
            <div>
                <a href="Home.php">Home</a>
                <a href="Home.html#product-list">Today's Deals</a>
                <a href="cart.php">Cart</a>
                <a href="purchased.php">Purchased</a>
            </div>
            <div>
                <a href="#" id="openAccountModal">You</a>
            </div>
        </div>
    </div>
</nav>

<div><br>
    <h2>Purchased Items</h2>
    <div class="cart-container" id="purchased-items">
        <?php if (count($items) === 0): ?>
            <p>You haven't purchased any items yet.</p>
        <?php else: ?>
            <table style="width:100%; background:white; border-radius:12px; box-shadow:2px 2px 5px rgba(0,0,0,0.08); border-collapse:separate; border-spacing:0 15px;">
                <thead>
                    <tr style="background:#f5f7fa;">
                        <th style="padding:12px; text-align:left;">Image</th>
                        <th style="padding:12px; text-align:left;">Product Name</th>
                        <th style="padding:12px; text-align:left;">Price</th>
                        <th style="padding:12px; text-align:left;">Rating</th>
                        <th style="padding:12px; text-align:left;">Purchase Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr style="background:#fff;">
                            <td style="padding:12px;">
                                <img src="photos/<?php echo htmlspecialchars($item['product_image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" style="width:80px; height:80px; object-fit:contain; border-radius:8px;" />
                            </td>
                            <td style="padding:12px; font-weight:600;"><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td style="padding:12px; color:#111; font-weight:bold;">₱<?php echo number_format($item['product_price'], 2); ?></td>
                            <td style="padding:12px; color:gold;"><?php echo htmlspecialchars($item['product_rating']); ?></td>
                            <td style="padding:12px;"><?php echo date("F j, Y, g:i a", strtotime($item['purchase_date'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<!-- Account Modal (same as your cart.php or home.php) -->
<div id="accountModal">
  <div id="accountModalContent">
    <span class="close" onclick="closeAccountModal()">&times;</span>
    <h2>Your Account</h2>
    <p><strong>Name:</strong> Joeroz</p>
    <p><strong>Email:</strong> joerozvicariato@gmail.com</p>
    <p><strong>Member Since:</strong> 2023-10-26</p>
    <p><strong>Address:</strong> Lingion, Manolo Fortich Bukidnon</p>
    <p><strong>Phone:</strong> 09123456789</p>
    <button onclick="logout()">Log Out</button>
  </div>
</div>

<!-- JS to open/close account modal -->
<script>
const accountModal = document.getElementById('accountModal');
document.getElementById('openAccountModal').onclick = function() {
    accountModal.style.display = 'block';
};
function closeAccountModal() {
    accountModal.style.display = 'none';
}
window.onclick = function(event) {
    if (event.target == accountModal) {
        accountModal.style.display = 'none';
    }
}
function logout() {
    alert("Logout functionality not implemented yet.");
}
</script>

</body>
</html>
