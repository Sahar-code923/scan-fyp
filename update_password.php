<?php
// Database connection
include("connect.php");

// Get form data
$token = $_POST['token'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Validate password match
if ($new_password !== $confirm_password) {
    die("Passwords do not match.");
}

// Check if the token is valid and not expired
$sql = "SELECT id FROM users WHERE reset_token = ? AND reset_expiry > NOW()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password and clear the reset token
    $sql = "UPDATE users SET password = ?, reset_token = NULL, reset_expiry = NULL WHERE reset_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $hashed_password, $token);
    $stmt->execute();

    echo "<script>alert('Password updated successfully!'); window.location.href = 'login.html';</script>";
} else {
    echo "<script>alert('Invalid or expired token!'); window.location.href = 'login.html';</script>";
}

// Close connections
$stmt->close();
$conn->close();
?>
