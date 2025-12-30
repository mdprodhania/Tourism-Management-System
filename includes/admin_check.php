<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php?error=" . urlencode("Please login first"));
    exit();
}

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../dashboard.php?error=" . urlencode("You do not have admin access"));
    exit();
}

// Check session timeout (24 hours)
$timeout = 86400;
if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > $timeout) {
    session_destroy();
    header("Location: ../login.php?error=" . urlencode("Session expired. Please login again."));
    exit();
}

// Update login time
$_SESSION['login_time'] = time();
?>
