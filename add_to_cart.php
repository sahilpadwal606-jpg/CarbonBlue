<?php
session_start();
include 'connect.php';

header('Content-Type: application/json'); // Ensure JSON response

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "You must be logged in to add items to the cart."]);
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0; 
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
$table_source = isset($_POST['source']) ? $_POST['source'] : ''; // Optional parameter to specify source table

if ($product_id <= 0 || $quantity <= 0) {
    echo json_encode(["status" => "error", "message" => "Invalid product ID or quantity."]);
    exit();
}

// Initialize product found flag
$product_exists = false;

// If source is specified, check only that table
if ($table_source == 'products') {
    $checkProduct = $conn->prepare("SELECT id FROM products WHERE id = ?");
    $checkProduct->bind_param("i", $product_id);
    $checkProduct->execute();
    $productResult = $checkProduct->get_result();
    $product_exists = ($productResult->num_rows > 0);
} 
elseif ($table_source == 'items') {
    $checkItem = $conn->prepare("SELECT product_id FROM items WHERE product_id = ?");
    $checkItem->bind_param("i", $product_id);
    $checkItem->execute();
    $itemResult = $checkItem->get_result();
    $product_exists = ($itemResult->num_rows > 0);
}
// If no source specified, check both tables
else {
    // First check products table
    $checkProduct = $conn->prepare("SELECT id FROM products WHERE id = ?");
    $checkProduct->bind_param("i", $product_id);
    $checkProduct->execute();
    $productResult = $checkProduct->get_result();
    
    if ($productResult->num_rows > 0) {
        $product_exists = true;
    } else {
        // Then check items table
        $checkItem = $conn->prepare("SELECT product_id FROM items WHERE product_id = ?");
        $checkItem->bind_param("i", $product_id);
        $checkItem->execute();
        $itemResult = $checkItem->get_result();
        $product_exists = ($itemResult->num_rows > 0);
    }
}

// If product doesn't exist in either table
if (!$product_exists) {
    echo json_encode(["status" => "error", "message" => "Product does not exist."]);
    exit();
}

// Check if item is already in the cart
$checkQuery = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
$checkQuery->bind_param("ii", $user_id, $product_id);
$checkQuery->execute();
$result = $checkQuery->get_result();

if ($result->num_rows > 0) {
    // Update quantity if item already exists
    $row = $result->fetch_assoc();
    $new_quantity = $row['quantity'] + $quantity;

    $updateQuery = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
    $updateQuery->bind_param("iii", $new_quantity, $user_id, $product_id);

    if (!$updateQuery->execute()) {
        echo json_encode(["status" => "error", "message" => "Failed to update cart."]);
        exit();
    }
} else {
    // Insert new item into cart
    $insertQuery = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
    $insertQuery->bind_param("iii", $user_id, $product_id, $quantity);

    if (!$insertQuery->execute()) {
        echo json_encode(["status" => "error", "message" => "Failed to add item to cart."]);
        exit();
    }
}

// Get updated cart count
$countQuery = $conn->prepare("SELECT SUM(quantity) FROM cart WHERE user_id = ?");
$countQuery->bind_param("i", $user_id);
$countQuery->execute();
$countResult = $countQuery->get_result();
$row = $countResult->fetch_row();

$cart_count = $row[0] ?? 0;

echo json_encode(["status" => "success", "cart_count" => $cart_count]);
?>