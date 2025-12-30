<?php
// Header file - included on all pages
session_start();

// Database configuration
include_once 'includes/db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Tourism Management System'; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Navbar Styling */
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .navbar-left {
            display: flex;
            gap: 15px;
        }

        .navbar-right {
            display: flex;
            gap: 15px;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            transition: all 0.3s;
            font-weight: 600;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .nav-link.btn-logout {
            background: #f44336;
            color: white;
        }

        .nav-link.btn-logout:hover {
            background: #da190b;
        }

        .nav-link.btn-login,
        .nav-link.btn-register {
            background: white;
            color: #667eea;
        }

        .nav-link.btn-login:hover,
        .nav-link.btn-register:hover {
            background: #f0f0f0;
        }

        .navbar-brand {
            color: white;
            font-size: 18px;
            font-weight: 700;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar">
    <div class="navbar-left">
        <a href="index.php" class="navbar-brand">🌍 Tourism System</a>
    </div>
    <div class="navbar-right">
        <?php
        // Check if user is logged in
        if (isset($_SESSION['user_id'])) {
            // User is logged in
            echo '<a href="dashboard.php" class="nav-link">Dashboard</a>';
            echo '<a href="includes/logout.php" class="nav-link btn-logout">Logout</a>';
        } else {
            // User is not logged in
            echo '<a href="login.php" class="nav-link btn-login">Login</a>';
            echo '<a href="register.php" class="nav-link btn-register">Register</a>';
        }
        ?>
    </div>
</nav>
