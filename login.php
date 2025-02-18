<?php
// Database connection
include("connect.php");

// Get form data
$username = $_POST['username'];
$password = $_POST['password'];

// Fetch user from the database
$sql = "SELECT id, username, password FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    // Verify password
    if (password_verify($password, $user['password'])) {
        echo "<script>alert('Login Successful!'); window.location.href = 'welcome.html';</script>";
    } else {
        echo "<script>alert('Invalid Password!'); window.location.href = 'login.html';</script>";
    }
} else {
    echo "<script>alert('User not found!'); window.location.href = 'login.html';</script>";
}

// Close connections
$stmt->close();
$conn->close();
?>
