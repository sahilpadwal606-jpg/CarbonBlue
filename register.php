<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"] ?? "";
    $phone = $_POST["phone"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";

    if (empty($name) || empty($phone) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "<script>
            alert('Error: All fields are required.');
            window.location.href = 'index.php';
        </script>";
        exit;
    }

    if ($password !== $confirm_password) {
        echo "<script>
            alert('Error: Passwords do not match.');
            window.location.href = 'index.php';
        </script>";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $role = 'user'; // Define role explicitly

    $sql = "INSERT INTO users (name, phone, email, password, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "<script>
            alert('Error: " . $conn->error . "');
            window.location.href = 'index.php';
        </script>";
        exit;
    }

    $stmt->bind_param("sssss", $name, $phone, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        echo "<script>
            alert('Registration successful!');
            window.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Error: " . $stmt->error . "');
            window.location.href = 'index.php';
        </script>";
    }

    $stmt->close();
}
?>
