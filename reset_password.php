<?php
// Database connection
include("connect.php");

// Get form data
$email = $_POST['email'];

// Check if the email exists in the database
$sql = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // Generate a unique token for password reset
    $token = bin2hex(random_bytes(32));
    $expiry = date("Y-m-d H:i:s", time() + 3600); // Token expires in 1 hour

    // Store the token in the database
    $sql = "UPDATE users SET reset_token = ?, reset_expiry = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $token, $expiry, $email);
    $stmt->execute();

    // Send an email with the reset link (this is a placeholder)
    $reset_link = "http://localhost/project-folder/reset_password_form.php?token=$token";
    echo "<script>alert('A password reset link has been sent to your email.'); window.location.href = 'login.html';</script>";
} else {
    echo "<script>alert('Email not found!'); window.location.href = 'forgot_password.html';</script>";
}

// Close connections
$stmt->close();
$conn->close();
?>
