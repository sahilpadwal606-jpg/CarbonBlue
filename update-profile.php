<?php
include '../../connect.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: sign-in.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    if (!empty($name) && !empty($email)) {
        // Update user details in the database
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $email, $user_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Profile updated successfully.";
        } else {
            $_SESSION['error'] = "Failed to update profile. Please try again.";
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "All fields are required.";
    }

    header("Location: profile.php");
    exit();
}
?>