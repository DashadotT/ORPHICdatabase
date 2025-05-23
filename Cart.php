<?php
require_once 'connection.php';

// Get user info
$user = $pdo->prepare("SELECT * FROM tbl_user LIMIT 1");
$user->execute();
$selUser = $user->fetch(PDO::FETCH_ASSOC);

// Fetch cart items
$cart = $pdo->prepare("SELECT * FROM tbl_cart a JOIN tbl_product b ON a.product_id = b.product_id WHERE a.user_id = ?");
$cart->execute([$selUser['user_id']]);
$selcart = $cart->fetchAll(PDO::FETCH_ASSOC);

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['delete_cart_id'])) {
        $deleteStmt = $pdo->prepare("DELETE FROM tbl_cart WHERE cart_id = ?");
        $deleteStmt->execute([$_POST['delete_cart_id']]);
        echo "<script>window.location='Cart.php';</script>";
        exit;
    }

    if (isset($_POST['checkout_cart_id'])) {
        $cart_id = $_POST['checkout_cart_id'];

        $stmt = $pdo->prepare("SELECT user_id, product_id FROM tbl_cart WHERE cart_id = ?");
        $stmt->execute([$cart_id]);
        $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cartItem) {
            $insert = $pdo->prepare("INSERT INTO tbl_purchased_items (user_id, product_id, purchase_date) VALUES (?, ?, NOW())");
            $insert->execute([$cartItem['user_id'], $cartItem['product_id']]);

            $deleteStmt = $pdo->prepare("DELETE FROM tbl_cart WHERE cart_id = ?");
            $deleteStmt->execute([$cart_id]);

            echo "<script>alert('Item checked out successfully!');window.location='Cart.php';</script>";
            exit;
        }
    }

    if (isset($_POST['checkout'])) {
        $user_id = $selUser['user_id'];

        $stmt = $pdo->prepare("SELECT product_id FROM tbl_cart WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($cartItems) {
            $insert = $pdo->prepare("INSERT INTO tbl_purchased_items (user_id, product_id, purchase_date) VALUES (?, ?, NOW())");
            foreach ($cartItems as $item) {
                $insert->execute([$user_id, $item['product_id']]);
            }

            $checkoutStmt = $pdo->prepare("DELETE FROM tbl_cart WHERE user_id = ?");
            $checkoutStmt->execute([$user_id]);

            echo "<script>alert('Checkout successful!');window.location='Cart.php';</script>";
            exit;
        }
    }
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>My Cart - ORPHIC</title>
    <link rel="stylesheet" href="cart.css" />
</head>
<body>

<!-- Navbar -->
<nav>
    <div class="navbar">
        <img src="https://c.animaapp.com/maksq8u46pByZ6/img/logo.png" alt="Orphic Logo">
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

<!-- Search Bar -->
<div class="searchandcart">
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search...">
    </div>
</div>

<!-- Cart Items -->
<div><br>
    <h2>My Cart</h2>
    <div class="cart-container" id="cart-items">
        <form method="post" action="Cart.php">
            <table style="width:100%; background:white; border-radius:12px; box-shadow:2px 2px 5px rgba(0,0,0,0.08); border-collapse:separate; border-spacing:0 15px;">
                <thead>
                    <tr style="background:#f5f7fa;">
                        <th style="padding:12px; text-align:left;">Image</th>
                        <th style="padding:12px; text-align:left;">Product Name</th>
                        <th style="padding:12px; text-align:left;">Price</th>
                        <th style="padding:12px; text-align:left;">Rating</th>
                        <th style="padding:12px; text-align:left;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($selcart as $row): $total += $row['product_price']; ?>
                    <tr style="background:#fff;">
                        <td style="padding:12px;">
                            <img src="photos/<?php echo htmlspecialchars($row['product_image']); ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>" style="width:80px; height:80px; object-fit:contain; border-radius:8px;">
                        </td>
                        <td style="padding:12px; font-weight:600;"><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td style="padding:12px; color:#111; font-weight:bold;">₱<?php echo htmlspecialchars($row['product_price']); ?></td>
                        <td style="padding:12px; color:gold;"><?php echo htmlspecialchars($row['product_rating']); ?></td>
                        <td style="padding:12px;">
                            <button type="submit" name="delete_cart_id" value="<?php echo $row['cart_id']; ?>" class="checkout-button remove-button" onclick="return confirm('Remove this item?')">Delete</button>
                            <button type="submit" name="checkout_cart_id" value="<?php echo $row['cart_id']; ?>" class="checkout-button" style="background-color:#28a745; margin-left:8px;" onclick="return confirm('Check out this item only?')">Check Out</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div style="margin-top:20px; display:flex; justify-content:space-between; align-items:center;">
                <div style="font-size:18px; font-weight:bold;">Total: ₱<?php echo number_format($total, 2); ?></div>
                <?php if (count($selcart) > 0): ?>
                    <button type="submit" name="checkout" class="checkout-button" onclick="return confirm('Proceed to checkout?')">Checkout All</button>
                <?php endif; ?>
            </div>
        </form>
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
