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
$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$username = trim($_POST['username'] ?? '');
$phone = trim($_POST['phone'] ?? '');

// Validation
$errors = [];

if (empty($first_name)) {
    $errors['first_name'] = 'First name is required';
} elseif (strlen($first_name) < 2) {
    $errors['first_name'] = 'First name must be at least 2 characters';
}

if (empty($last_name)) {
    $errors['last_name'] = 'Last name is required';
} elseif (strlen($last_name) < 2) {
    $errors['last_name'] = 'Last name must be at least 2 characters';
}

if (empty($email)) {
    $errors['email'] = 'Email is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Invalid email format';
}

if (empty($username)) {
    $errors['username'] = 'Username is required';
} elseif (strlen($username) < 3) {
    $errors['username'] = 'Username must be at least 3 characters';
} elseif (strlen($username) > 50) {
    $errors['username'] = 'Username must not exceed 50 characters';
} elseif (!preg_match('/^[a-zA-Z0-9_-]+$/', $username)) {
    $errors['username'] = 'Username can only contain letters, numbers, underscores, and hyphens';
}

if (!empty($phone) && !preg_match('/^[0-9\-\+\s\(\)]+$/', $phone)) {
    $errors['phone'] = 'Invalid phone number format';
}

if (!empty($errors)) {
    $error_msg = implode(', ', $errors);
    header("Location: ../edit_profile.php?error=" . urlencode($error_msg));
    exit;
}

// Check if email is already used by another user
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
$stmt->bind_param("si", $email, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $stmt->close();
    header("Location: ../edit_profile.php?error=" . urlencode("Email is already in use"));
    exit;
}

$stmt->close();

// Check if username is already used by another user
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
$stmt->bind_param("si", $username, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $stmt->close();
    header("Location: ../edit_profile.php?error=" . urlencode("Username is already taken"));
    exit;
}

$stmt->close();

// Update user profile
$stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, username = ?, phone = ? WHERE id = ?");
$stmt->bind_param("sssssi", $first_name, $last_name, $email, $username, $phone, $user_id);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header("Location: ../profile.php?success=" . urlencode("Profile updated successfully"));
    exit;
} else {
    $stmt->close();
    $conn->close();
    header("Location: ../edit_profile.php?error=" . urlencode("Error updating profile. Please try again"));
    exit;
}
