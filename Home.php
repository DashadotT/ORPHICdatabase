<?php
session_start();
require_once "connection.php";

// Redirect if not logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch user details to display in modal
$userStmt = $pdo->prepare("SELECT * FROM tbl_user WHERE user_id = ?");
$userStmt->execute([$userId]);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    // User not found, log out forcibly
    session_destroy();
    header("Location: login.php");
    exit();
}

// Fetch all products
$productStmt = $pdo->prepare("SELECT * FROM tbl_product");
$productStmt->execute();
$selProduct = $productStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Orphic - Your Online Store</title>
    <link rel="stylesheet" href="home.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
<nav>
    <div class="navbar">
        <img src="https://c.animaapp.com/maksq8u46pByZ6/img/logo.png" alt="Orphic Logo">
        <div class="navbar-links">
            <div>
                <a href="Home.php">Home</a>
                <a href="#product-list">Today's Deals</a>
                <a href="Cart.php">Cart</a>
                <a href="purchased.php">Purchased</a>
            </div>
            <div>
                <a href="#" id="openAccountModal">You</a>
            </div>
        </div>
    </div>
</nav>

<script>
    document.getElementById('openAccountModal').onclick = function(e) {
        e.preventDefault();
        document.getElementById('accountModal').style.display = 'block';
    };
</script>

<div class="searchandcart">
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search..." onkeyup="filterProducts()">
    </div>
    <script>
        function filterProducts() {
            var input = document.getElementById('searchInput').value.toLowerCase();
            var cards = document.querySelectorAll('.product-card');
            cards.forEach(function(card) {
                var title = card.querySelector('.product-title').textContent.toLowerCase();
                card.style.display = title.includes(input) ? '' : 'none';
            });
        }
    </script>
    <div class="slogan">
        <h2>
            Crafted for <br>
            Gamers. <span class="orange">Powered.</span><br>
            for <span class="orange">Victory.</span>
        </h2>
    </div>
</div>

<section class="deals">
    <h2>Today's deals</h2>
</section>

<!-- Account Modal -->
<div id="accountModal" style="display:none;">
    <div id="accountModalContent">
        <span class="close" onclick="closeAccountModal()">&times;</span>
        <h2>Your Account</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name'] ?? 'N/A'); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email'] ?? 'N/A'); ?></p>
        <p><strong>Member Since:</strong> <?php echo htmlspecialchars($user['created_at'] ?? 'N/A'); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address'] ?? 'N/A'); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></p>
        <button onclick="logout()">Log Out</button>
    </div>
</div>

<script>
    function closeAccountModal() {
        document.getElementById("accountModal").style.display = "none";
    }

    function logout() {
        // Optionally do AJAX logout here or just redirect
        window.location.href = "login.php";
    }
</script>

<main id="product-list">
    <?php foreach ($selProduct as $row): ?>
        <div class="product-card">
            <img src="photos/<?php echo htmlspecialchars($row['product_image']); ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>" class="product-image">
            <div class="product-title"><?php echo htmlspecialchars($row['product_name']); ?></div>
            <div class="product-price">₱<?php echo htmlspecialchars($row['product_price']); ?></div>
            <div class="product-rating"><?php echo htmlspecialchars($row['product_rating']); ?></div>
            <button class="add-to-cart-button" onclick="addToCart('<?php echo htmlspecialchars($row['product_id']); ?>')">Add to Cart</button>
        </div>
    <?php endforeach; ?>
</main>

<footer class="orphic-footer">
    <div class="footer-container">
        <div class="footer-section about">
            <h3>ABOUT US</h3>
            <p>ORPHIC is an eCommerce platform based in the Philippines, designed to serve the growing community of
                PC builders, gamers, and tech enthusiasts. It empowers users to build their own custom PCs with
                confidence by offering essential tools. ORPHIC aims to become the go-to destination for reliable,
                beginner-friendly PC building solutions that combine both function and convenience.</p>
        </div>

        <div class="footer-section payments">
            <h3>PAYMENT METHODS</h3>
            <div class="footer-icons">
                <img src="https://c.animaapp.com/maixeniyECsT9y/img/gcash-logo-500x281-1.png" alt="GCash">
                <img src="https://c.animaapp.com/maixeniyECsT9y/img/image-5.png" alt="PayMaya">
                <img src="https://c.animaapp.com/maixeniyECsT9y/img/image-6.png" alt="BPI">
                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal">
            </div>
        </div>

        <div class="footer-section logistics">
            <h3>LOGISTICS</h3>
            <div class="footer-icons">
                <img src="https://c.animaapp.com/maixeniyECsT9y/img/flash-express-malaysia-1634103999-removebg-preview-1.png" alt="Flash Express">
                <img src="https://c.animaapp.com/maixeniyECsT9y/img/648px-j-t-express-logo-svg-removebg-preview-1.png" alt="J&T Express">
                <img src="https://c.animaapp.com/maixeniyECsT9y/img/ninjavan-svg-1.png" alt="Ninja Van">
                <img src="https://c.animaapp.com/maixeniyECsT9y/img/2go-travel-logo--2018--svg-1.png" alt="2GO Express">
            </div>
        </div>

        <div class="footer-section service">
            <h3>CUSTOMER SERVICE</h3>
            <ul>
                <li><a href="#">Help Centre</a></li>
                <li><a href="#">Payment Methods</a></li>
                <li><a href="#">Order Tracking</a></li>
                <li><a href="#">Free Shipping</a></li>
                <li><a href="#">Return & Refund</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="social">
            <span>FOLLOW US</span>
            <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram"></a>
            <a href="#"><img src="https://c.animaapp.com/maixeniyECsT9y/img/image-9.png" alt="Twitter"></a>
            <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/c/ca/LinkedIn_logo_initials.png" alt="LinkedIn"></a>
            <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/1/1b/Facebook_icon.svg" alt="Facebook"></a>
        </div>
        <p>&copy; Orphic2025. All rights reserved.</p>
    </div>
</footer>

<script>
    function addToCart(productId) {
        fetch('addToCart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'productId=' + encodeURIComponent(productId)
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>

</body>
</html>
