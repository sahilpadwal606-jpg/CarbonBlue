<?php
session_start();
include 'connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "You must be logged in to remove items from your cart."]);
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_id = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;

if ($cart_id <= 0) {
    echo json_encode(["status" => "error", "message" => "Invalid cart item ID."]);
    exit();
}

// Verify the cart item belongs to the current user
$verify_query = "SELECT id FROM cart WHERE id = ".$cart_id." AND user_id = ".$user_id;
$result = $conn->query($verify_query);

if ($result->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Cart item not found or unauthorized."]);
    exit();
}

// Delete the cart item
$delete_query = "DELETE FROM cart WHERE id = ".$cart_id." AND user_id = ".$user_id;

if (!$conn->query($delete_query)) {
    echo json_encode(["status" => "error", "message" => "Failed to remove item from cart."]);
    exit();
}

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
    "cart_subtotal" => $cart_subtotal,
    "cart_count" => $cart_count
]);
?>