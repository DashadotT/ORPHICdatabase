<?php
session_start();
require_once "connection.php";

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all products
$productStmt = $pdo->prepare("SELECT * FROM tbl_product");
$productStmt->execute();
$selProduct = $productStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Orphic - Your Online Store</title>
    <link rel="stylesheet" href="home.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
      /* Basic modal styles */
      #accountModal {
        display: none;
        position: fixed;
        z-index: 100;
        left: 0; top: 0; width: 100%; height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5);
      }
      #accountModalContent {
        background: #fff;
        margin: 10% auto;
        padding: 20px;
        width: 300px;
        border-radius: 8px;
        position: relative;
      }
      .close {
        position: absolute;
        right: 10px; top: 10px;
        cursor: pointer;
        font-size: 24px;
      }
    </style>
</head>
<body>
<nav>
    <div class="navbar">
        <img src="https://c.animaapp.com/maksq8u46pByZ6/img/logo.png" alt="Orphic Logo" />
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

<div class="searchandcart">
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search..." onkeyup="filterProducts()" />
    </div>
    <div class="slogan">
        <h2>
            Crafted for <br />
            Gamers. <span class="orange">Powered.</span><br />
            for <span class="orange">Victory.</span>
        </h2>
    </div>
</div>

<section class="deals">
    <h2>Today's deals</h2>
</section>

<!-- Account Modal -->
<div id="accountModal">
    <div id="accountModalContent" style="box-shadow: 0 8px 32px rgba(0,0,0,0.25); border: 1px solid #eee;">
        <span class="close" onclick="closeAccountModal()" style="color: #ff5a36;">&times;</span>
        <h2 style="text-align:center; color:#ff5a36; margin-bottom: 20px; font-weight:700;">Your Account</h2>
        <form id="updateAccountForm" style="display: flex; flex-direction: column; gap: 15px;">
            <label style="font-weight: 500; color: #333;">
                Name:
                <input type="text" id="accountName" name="name" required
                    style="width: 100%; padding: 8px 10px; border: 1px solid #ddd; border-radius: 5px; margin-top: 5px;"/>
            </label>
            <label style="font-weight: 500; color: #333;">
                Email:
                <input type="email" id="accountEmail" name="email" required
                    style="width: 100%; padding: 8px 10px; border: 1px solid #ddd; border-radius: 5px; margin-top: 5px;"/>
            </label>
            <div style="display: flex; gap: 10px; margin-top: 10px;">
                <button type="submit" style="flex:1; background: #ff5a36; color: #fff; border: none; border-radius: 5px; padding: 10px 0; font-weight: 600; cursor: pointer; transition: background 0.2s;">Update</button>
                <button type="button" onclick="logout()" style="flex:1; background: #222; color: #fff; border: none; border-radius: 5px; padding: 10px 0; font-weight: 600; cursor: pointer; transition: background 0.2s;">Log Out</button>
            </div>
        </form>
        <div id="updateMsg" style="margin-top: 15px; text-align: center; color: #28a745; font-weight: 500;"></div>
    </div>
</div>

<main id="product-list">
    <?php foreach ($selProduct as $row): ?>
        <div class="product-card">
            <img src="photos/<?php echo htmlspecialchars($row['product_image']); ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>" class="product-image" />
            <div class="product-title"><?php echo htmlspecialchars($row['product_name']); ?></div>
            <div class="product-price">₱<?php echo htmlspecialchars($row['product_price']); ?></div>
            <div class="product-rating"><?php echo htmlspecialchars($row['product_rating']); ?></div>
            <button class="add-to-cart-button" onclick="addToCart('<?php echo htmlspecialchars($row['product_id']); ?>')">Add to Cart</button>
        </div>
    <?php endforeach; ?>
</main>

<footer class="orphic-footer">
    <!-- Footer omitted for brevity -->
</footer>

<script>
function filterProducts() {
    var input = document.getElementById('searchInput').value.toLowerCase();
    var cards = document.querySelectorAll('.product-card');
    cards.forEach(function(card) {
        var title = card.querySelector('.product-title').textContent.toLowerCase();
        card.style.display = title.includes(input) ? '' : 'none';
    });
}

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

function addToCart(productId) {
    fetch('addToCart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'productId=' + encodeURIComponent(productId)
    })
    .then(response => response.text())
    .then(data => alert(data))
    .catch(error => console.error('Error:', error));
}
</script>
</body>
</html>
