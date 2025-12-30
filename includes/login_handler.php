<?php
session_start();
require_once 'db_config.php';

// Get form data
$login = trim($_POST['login'] ?? '');  // Can be username or email
$password = $_POST['password'] ?? '';
$remember_me = isset($_POST['remember_me']) ? true : false;

// Initialize error array
$errors = [];

// Validation
if (empty($login)) {
    $errors['login'] = 'Username or email is required';
}

if (empty($password)) {
    $errors['password'] = 'Password is required';
}

// If validation fails, return to login with errors
if (!empty($errors)) {
    $error_msg = implode(', ', $errors);
    header("Location: ../login.php?error=" . urlencode($error_msg));
    exit();
}

// Query user by email or username
// First, try to determine if input is email or username
$query = "SELECT id, first_name, last_name, email, password, role, status FROM users WHERE email = ? OR username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $login, $login);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // User not found
    header("Location: ../login.php?error=" . urlencode("Invalid username/email or password"));
    $stmt->close();
    $conn->close();
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();

// Check if account is active
if ($user['status'] !== 'active') {
    header("Location: ../login.php?error=" . urlencode("Your account is inactive. Please contact support."));
    $conn->close();
    exit();
}

// Verify password
if (!password_verify($password, $user['password'])) {
    // Password is incorrect
    header("Location: ../login.php?error=" . urlencode("Invalid username/email or password"));
    $conn->close();
    exit();
}

// Password is correct - Create session
$_SESSION['user_id'] = $user['id'];
$_SESSION['first_name'] = $user['first_name'];
$_SESSION['last_name'] = $user['last_name'];
$_SESSION['email'] = $user['email'];
$_SESSION['role'] = $user['role'];
$_SESSION['login_time'] = time();

// Set session cookie duration (24 hours)
if ($remember_me) {
    ini_set('session.gc_maxlifetime', 86400); // 24 hours
    session_set_cookie_params(86400);
}

$conn->close();

// Redirect based on user role
if ($user['role'] === 'admin') {
    $success_msg = "Welcome back, " . htmlspecialchars($user['first_name']) . "!";
    header("Location: ../admin/dashboard.php?success=" . urlencode($success_msg));
} else {
    $success_msg = "Login successful! Welcome " . htmlspecialchars($user['first_name']) . "!";
    header("Location: ../dashboard.php?success=" . urlencode($success_msg));
}
exit();
?>
