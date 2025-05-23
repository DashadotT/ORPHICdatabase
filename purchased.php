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
                <a href="Home.php#product-list">Today's Deals</a>
                <a href="cart.php">Cart</a>
                <a href="purchased.php">Purchased</a>
            </div>
            <div>
                <a href="#" id="openAccountModal">You</a>
            </div>
        </div>
    </div>
</nav>

<!-- Purchased Items -->
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

<!-- Account Modal -->
<div id="accountModal" style="display:none;">
  <div id="accountModalContent" style="box-shadow: 0 8px 32px rgba(0,0,0,0.25); border: 1px solid #eee; background: #fff; margin: 10% auto; padding: 20px; width: 300px; border-radius: 8px; position: relative;">
    <span class="close" onclick="closeAccountModal()" style="position: absolute; right: 10px; top: 10px; cursor: pointer; font-size: 24px; color: #ff5a36;">&times;</span>
    <h2 style="text-align:center; color:#ff5a36; margin-bottom: 20px; font-weight:700;">Your Account</h2>
    <form id="updateAccountForm" style="display: flex; flex-direction: column; gap: 15px;">
      <label style="font-weight: 500; color: #333;">
        Name:
        <input type="text" id="accountName" name="name" required
               style="width: 100%; padding: 8px 10px; border: 1px solid #ddd; border-radius: 5px; margin-top: 5px;" />
      </label>
      <label style="font-weight: 500; color: #333;">
        Email:
        <input type="email" id="accountEmail" name="email" required
               style="width: 100%; padding: 8px 10px; border: 1px solid #ddd; border-radius: 5px; margin-top: 5px;" />
      </label>
      <div style="display: flex; gap: 10px; margin-top: 10px;">
        <button type="submit" style="flex:1; background: #ff5a36; color: #fff; border: none; border-radius: 5px; padding: 10px 0; font-weight: 600; cursor: pointer; transition: background 0.2s;">Update</button>
        <button type="button" onclick="logout()" style="flex:1; background: #222; color: #fff; border: none; border-radius: 5px; padding: 10px 0; font-weight: 600; cursor: pointer; transition: background 0.2s;">Log Out</button>
      </div>
    </form>
    <div id="updateMsg" style="margin-top: 15px; text-align: center; color: #28a745; font-weight: 500;"></div>
  </div>
</div>

<!-- JavaScript -->
<script>
document.getElementById('openAccountModal').onclick = function(e) {
    e.preventDefault();
    fetch('getUserInfo.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                document.getElementById('accountName').value = data.name || '';
                document.getElementById('accountEmail').value = data.email || '';
                document.getElementById('accountModal').style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error fetching account info:', error);
        });
};

document.getElementById('updateAccountForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const name = document.getElementById('accountName').value;
    const email = document.getElementById('accountEmail').value;

    fetch('updateAccount.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'name=' + encodeURIComponent(name) + '&email=' + encodeURIComponent(email)
    })
    .then(response => response.text())
    .then(data => {
    const msg = document.getElementById('updateMsg');
    msg.textContent = data;

    // Automatically hide message after 3 seconds
    setTimeout(() => {
        msg.textContent = '';
    }, 3000);
})

    .catch(error => console.error('Update error:', error));
});

function closeAccountModal() {
    document.getElementById('accountModal').style.display = 'none';
}

function logout() {
    window.location.href = 'logout.php';
}
</script>

</body>
</html>
