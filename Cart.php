<?php
require_once 'connection.php';

// Get user info (you might want to replace this with your actual logged-in user logic)
$user = $pdo->prepare("SELECT * FROM tbl_user LIMIT 1");
$user->execute();
$selUser = $user->fetch(PDO::FETCH_ASSOC);

// Fetch cart items for the user
$cart = $pdo->prepare("SELECT * FROM tbl_cart a
JOIN tbl_product b ON a.product_id = b.product_id
WHERE a.user_id = ?");
$cart->execute([$selUser['user_id']]);
$selcart = $cart->fetchAll(PDO::FETCH_ASSOC);

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Delete single cart item
    if (isset($_POST['delete_cart_id'])) {
        $deleteStmt = $pdo->prepare("DELETE FROM tbl_cart WHERE cart_id = ?");
        $deleteStmt->execute([$_POST['delete_cart_id']]);
        echo "<script>window.location='Cart.php';</script>";
        exit;
    }

    // Checkout single item
    if (isset($_POST['checkout_cart_id'])) {
        $cart_id = $_POST['checkout_cart_id'];

        // Get cart item details
        $stmt = $pdo->prepare("SELECT user_id, product_id FROM tbl_cart WHERE cart_id = ?");
        $stmt->execute([$cart_id]);
        $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cartItem) {
            // Insert into purchased items
            $insert = $pdo->prepare("INSERT INTO tbl_purchased_items (user_id, product_id, purchase_date) VALUES (?, ?, NOW())");
            $insert->execute([$cartItem['user_id'], $cartItem['product_id']]);

            // Delete from cart
            $deleteStmt = $pdo->prepare("DELETE FROM tbl_cart WHERE cart_id = ?");
            $deleteStmt->execute([$cart_id]);

            echo "<script>alert('Item checked out successfully!');window.location='Cart.php';</script>";
            exit;
        }
    }

    // Checkout all items
    if (isset($_POST['checkout'])) {
        $user_id = $selUser['user_id'];

        // Get all cart items for user
        $stmt = $pdo->prepare("SELECT product_id FROM tbl_cart WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($cartItems) {
            $insert = $pdo->prepare("INSERT INTO tbl_purchased_items (user_id, product_id, purchase_date) VALUES (?, ?, NOW())");

            // Insert each product into purchased items
            foreach ($cartItems as $item) {
                $insert->execute([$user_id, $item['product_id']]);
            }

            // Delete all from cart
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

    <!-- Search Bar -->
    <div class="searchandcart">
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search...">
        </div>
    </div>
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
                        <?php
                        foreach ($selcart as $row):
                            $total += $row['product_price'];
                        ?>
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

    <script>
        // Account modal open/close scripts
        document.getElementById('openAccountModal').addEventListener('click', function() {
            document.getElementById('accountModal').style.display = 'block';
        });
        function closeAccountModal() {
            document.getElementById('accountModal').style.display = 'none';
        }
        function logout() {
            alert('Logging out...');
            // Add your logout logic here
        }
    </script>

</body>

</html>
