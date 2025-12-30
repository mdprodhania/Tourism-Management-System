<?php
session_start();
require_once 'db_config.php';

// Get form data
$email = trim($_POST['email'] ?? '');

// Initialize error array
$errors = [];

// Validation
if (empty($email)) {
    $errors['email'] = 'Email is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Invalid email format';
}

// If validation fails, return to form with errors
if (!empty($errors)) {
    $error_msg = implode(', ', $errors);
    header("Location: ../forgot_password.php?error=" . urlencode($error_msg));
    exit();
}

// Check if user exists with this email
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Don't reveal if email exists for security
    header("Location: ../forgot_password.php?success=" . urlencode("If an account exists with this email, you will receive a password reset link shortly."));
    $stmt->close();
    $conn->close();
    exit();
}

$user = $result->fetch_assoc();
$user_id = $user['id'];
$stmt->close();

// Generate unique reset token (valid for 1 hour)
$token = bin2hex(random_bytes(50));
$expires_at = date('Y-m-d H:i:s', time() + 3600); // 1 hour

// Store token in database
$stmt = $conn->prepare("INSERT INTO password_reset_tokens (user_id, token, expires_at) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $token, $expires_at);

if ($stmt->execute()) {
    $stmt->close();
    
    // In production, send email here
    // For now, we'll simulate email by displaying the reset link
    $reset_link = "http://localhost/Tourism%20Management%20System/reset_password.php?token=" . $token;
    
    // Log to file (for testing purposes)
    $log_message = "Password reset link for " . $email . ": " . $reset_link . " (Expires: " . $expires_at . ")\n";
    file_put_contents(__DIR__ . '/../logs/password_resets.log', $log_message, FILE_APPEND);
    
    // Store token in session for display (for testing)
    $_SESSION['reset_token'] = $token;
    $_SESSION['reset_email'] = $email;
    
    header("Location: ../forgot_password.php?success=" . urlencode("Password reset link has been sent to your email. You can also use this link: " . $reset_link));
    exit();
} else {
    $error = $conn->error;
    header("Location: ../forgot_password.php?error=" . urlencode("Failed to generate reset link. Please try again."));
    $stmt->close();
    exit();
}

$conn->close();
?>
