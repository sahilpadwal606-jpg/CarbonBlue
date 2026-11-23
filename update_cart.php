<?php
session_start();
include 'connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "You must be logged in to update your cart."]);
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_id = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

if ($cart_id <= 0 || $quantity <= 0) {
    echo json_encode(["status" => "error", "message" => "Invalid cart ID or quantity."]);
    exit();
}

// Verify the cart item belongs to the current user
$verify_query = "SELECT product_id FROM cart WHERE id = ".$cart_id." AND user_id = ".$user_id;
$result = $conn->query($verify_query);

if ($result->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Cart item not found or unauthorized."]);
    exit();
}

$cart_item = $result->fetch_assoc();
$product_id = $cart_item['product_id'];

// Update the quantity
$update_query = "UPDATE cart SET quantity = ".$quantity." WHERE id = ".$cart_id." AND user_id = ".$user_id;

if (!$conn->query($update_query)) {
    echo json_encode(["status" => "error", "message" => "Failed to update cart."]);
    exit();
}

// Get product price - try products table first
$product_query = "SELECT price FROM products WHERE id = ".$product_id;
$product_result = $conn->query($product_query);

if ($product_result->num_rows > 0) {
    $product = $product_result->fetch_assoc();
    $price = $product['price'];
} else {
    // Try items table
    $item_query = "SELECT price FROM items WHERE product_id = ".$product_id;
    $item_result = $conn->query($item_query);
    
    if ($item_result->num_rows > 0) {
        $item = $item_result->fetch_assoc();
        $price = $item['price'];
    } else {
        echo json_encode(["status" => "error", "message" => "Product not found."]);
        exit();
    }
}

// Calculate item subtotal
$item_subtotal = $price * $quantity;

// Get updated cart total
$total_query = "
    SELECT 
        c.product_id, 
        c.quantity,
        COALESCE(
            (SELECT price FROM products WHERE id = c.product_id),
            (SELECT price FROM items WHERE product_id = c.product_id)
        ) as price
    FROM 
        cart c
    WHERE 
        c.user_id = ".$user_id."
";
$total_result = $conn->query($total_query);

$cart_subtotal = 0;
$cart_count = 0;

while ($row = $total_result->fetch_assoc()) {
    $cart_subtotal += $row['price'] * $row['quantity'];
    $cart_count += $row['quantity'];
}

echo json_encode([
    "status" => "success",
    "item_subtotal" => $item_subtotal,
    "cart_subtotal" => $cart_subtotal,
    "cart_count" => $cart_count
]);
?>