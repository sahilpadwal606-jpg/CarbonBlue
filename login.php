<?php
session_start(); // Start session
include 'connect.php'; // Include database connection

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    if (empty($email) || empty($password)) {
        echo "<script>
            alert('Error: Email and password are required.');
            window.location.href = 'index.php';
        </script>";
        exit;
    }

    // Secure SQL query using prepared statements
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row["password"])) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_name"] = $row["name"] ?? $row["email"];
            $_SESSION["role"] = $row["role"];
            $_SESSION["user_email"] = $email; // Store email in session

            $redirect_url = ($row["role"] == "admin") ? "./admin/pages/sign-in.php" : "profile.php";

            echo "<script>
                alert('Login successful!');
                setTimeout(function() {
                    window.location.href = '$redirect_url';
                }, 1000);
            </script>";

            header("Refresh: 1; URL=$redirect_url");
            exit;
        } else {
            echo "<script>
                alert('Invalid password.');
                window.location.href = 'index.php';
            </script>";
            exit;
        }
    } else {
        echo "<script>
            alert('User not found.');
            window.location.href = 'index.php';
        </script>";
        exit;
    }
}
?>