<?php
session_start();
require_once 'db_config.php';

// Get form data
$token = trim($_POST['token'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Initialize error array
$errors = [];

// Validation
if (empty($password)) {
    $errors['password'] = 'Password is required';
} elseif (strlen($password) < 6) {
    $errors['password'] = 'Password must be at least 6 characters';
}

if (empty($confirm_password)) {
    $errors['confirm_password'] = 'Please confirm your password';
} elseif ($password !== $confirm_password) {
    $errors['confirm_password'] = 'Passwords do not match';
}

// If validation fails, redirect back
if (!empty($errors)) {
    $error_msg = implode(', ', $errors);
    header("Location: ../reset_password.php?token=" . urlencode($token) . "&error=" . urlencode($error_msg));
    exit();
}

// Verify token and get user_id
$stmt = $conn->prepare("SELECT user_id FROM password_reset_tokens WHERE token = ? AND expires_at > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: ../reset_password.php?token=" . urlencode($token) . "&error=" . urlencode("Invalid or expired reset link"));
    $stmt->close();
    $conn->close();
    exit();
}

$row = $result->fetch_assoc();
$user_id = $row['user_id'];
$stmt->close();

// Hash new password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Update user password
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$stmt->bind_param("si", $hashed_password, $user_id);

if ($stmt->execute()) {
    $stmt->close();
    
    // Delete used reset token
    $stmt = $conn->prepare("DELETE FROM password_reset_tokens WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->close();
    
    $conn->close();
    
    // Redirect to login with success message
    header("Location: ../login.php?success=" . urlencode("Password reset successful! You can now login with your new password."));
    exit();
} else {
    $error = $conn->error;
    header("Location: ../reset_password.php?token=" . urlencode($token) . "&error=" . urlencode("Failed to reset password. Please try again."));
    $stmt->close();
    exit();
}

$conn->close();
?>
