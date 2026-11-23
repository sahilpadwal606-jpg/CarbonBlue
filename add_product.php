<?php
include 'connect.php';
session_start();

// Ensure only admins can access
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ./admin/pages/sign-in.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    
    // Handle image upload
    $image = $_FILES["image"]["name"];
    $target = "images/" . basename($image);
    
    move_uploaded_file($_FILES["image"]["tmp_name"], $target);

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, stock) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsi", $name, $description, $price, $image, $stock);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Product added successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error adding product.</p>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
</head>
<body>
    <h2>Add New Product</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <label>Product Name:</label>
        <input type="text" name="name" required><br>

        <label>Description:</label>
        <textarea name="description"></textarea><br>

        <label>Price:</label>
        <input type="number" step="0.01" name="price" required><br>

        <label>Stock:</label>
        <input type="number" name="stock" required><br>

        <label>Image:</label>
        <input type="file" name="image" required><br>

        <button type="submit">Add Product</button>
    </form>
</body>
</html>
