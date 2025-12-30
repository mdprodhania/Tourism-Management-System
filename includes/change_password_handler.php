<?php
session_start();
require_once 'db_config.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Get form data
$user_id = $_SESSION['user_id'];
$current_password = $_POST['current_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validation
$errors = [];

if (empty($current_password)) {
    $errors['current_password'] = 'Current password is required';
}

if (empty($new_password)) {
    $errors['new_password'] = 'New password is required';
} elseif (strlen($new_password) < 6) {
    $errors['new_password'] = 'New password must be at least 6 characters';
}

if (empty($confirm_password)) {
    $errors['confirm_password'] = 'Please confirm your password';
} elseif ($new_password !== $confirm_password) {
    $errors['confirm_password'] = 'Passwords do not match';
}

if (!empty($errors)) {
    $error_msg = implode(', ', $errors);
    header("Location: ../change_password.php?error=" . urlencode($error_msg));
    exit;
}

// Get user's current password hash
$stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    header("Location: ../change_password.php?error=" . urlencode("User not found"));
    exit;
}

// Verify current password
if (!password_verify($current_password, $user['password'])) {
    header("Location: ../change_password.php?error=" . urlencode("Current password is incorrect"));
    exit;
}

// Hash new password
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Update password in database
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$stmt->bind_param("si", $hashed_password, $user_id);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header("Location: ../change_password.php?success=" . urlencode("Password changed successfully"));
    exit;
} else {
    $stmt->close();
    $conn->close();
    header("Location: ../change_password.php?error=" . urlencode("Error changing password. Please try again"));
    exit;
}
