<?php
$servername = "localhost";
$username = "root";  // Default for XAMPP/WAMP
$password = "";      // Leave blank for XAMPP/WAMP
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    
}
?>
