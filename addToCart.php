<?php
require_once 'connection.php'; // Include your database connection file

// Check if user is logged in and product ID is provided
$productId = $_POST['productId'] ?? null;
$userId = $_SESSION['user_id'] ?? null; // Make sure you are storing it as 'user_id'

if (empty($productId) || empty($userId)) {
    echo "Invalid request. User not logged in or product ID missing. Product ID: " . var_export($productId, true) . ", User ID: " . var_export($userId, true);
    exit;
}

try {
    // Check if the product is already in the cart
    $stmt = $pdo->prepare("SELECT * FROM tbl_cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$userId, $productId]);
    $existingProduct = $stmt->fetch();

    if ($existingProduct) {
        echo "Product is already in your cart.";
    } else {
        // Insert the product into the cart
        $stmt = $pdo->prepare("INSERT INTO tbl_cart (user_id, product_id) VALUES (?, ?)");
        $stmt->execute([$userId, $productId]);
        echo "Product added to cart successfully!";
    }
} catch (Throwable $th) {
    echo "An error occurred: " . $th->getMessage();
}
?>
