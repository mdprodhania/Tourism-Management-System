<?php
session_start();
require_once 'db_config.php';

// Get form data
$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$username = trim($_POST['username'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Initialize error array
$errors = [];

// Validation
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

// If validation fails, return to form with errors
if (!empty($errors)) {
    $error_msg = implode(', ', $errors);
    header("Location: ../register.php?error=" . urlencode($error_msg));
    exit();
}

// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: ../register.php?error=" . urlencode("Email address already registered"));
    $stmt->close();
    exit();
}

$stmt->close();

// Check if username already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: ../register.php?error=" . urlencode("Username already taken"));
    $stmt->close();
    exit();
}

$stmt->close();

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user into database
$stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, username, phone, password) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $first_name, $last_name, $email, $username, $phone, $hashed_password);

if ($stmt->execute()) {
    $user_id = $stmt->insert_id;
    $stmt->close();
    $conn->close();
    
    // Redirect to success page with confirmation message
    $success_msg = "Account registered successfully! Welcome " . htmlspecialchars($first_name) . " " . htmlspecialchars($last_name) . "!";
    header("Location: ../register.php?success=" . urlencode($success_msg));
    exit();
} else {
    $error = $conn->error;
    header("Location: ../register.php?error=" . urlencode("Registration failed. Please try again. Error: " . $error));
    $stmt->close();
    exit();
}

$conn->close();
?>
