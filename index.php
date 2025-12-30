<?php
session_start();
require_once 'includes/db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Tourism Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .index-container {
            text-align: center;
        }
        
        .welcome-section {
            margin-bottom: 40px;
        }
        
        .welcome-section h2 {
            font-size: 32px;
            color: #667eea;
            margin-bottom: 20px;
        }
        
        .welcome-section p {
            font-size: 16px;
            color: #666;
            margin-bottom: 15px;
            line-height: 1.6;
        }
        
        .buttons-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 30px;
        }
        
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }
        
        .btn-secondary:hover {
            background: #667eea;
            color: white;
        }
        
        .features {
            text-align: left;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            margin-top: 30px;
        }
        
        .features h3 {
            color: #333;
            margin-bottom: 20px;
            font-size: 20px;
        }
        
        .features ul {
            list-style: none;
            padding: 0;
        }
        
        .features li {
            padding: 10px 0;
            color: #555;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
        }
        
        .features li:last-child {
            border-bottom: none;
        }
        
        .features li:before {
            content: "✓";
            color: #28a745;
            font-weight: bold;
            font-size: 18px;
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-wrapper index-container">
            <div class="welcome-section">
                <h1>🏖️ Tourism Management System</h1>
                <h2>Welcome!</h2>
                <p>Manage your tourism business efficiently with our comprehensive management system.</p>
            </div>

            <div class="buttons-group">
                <a href="packages.php" class="btn btn-primary">Browse Packages</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="booking_history.php" class="btn btn-primary">My Bookings</a>
                    <a href="dashboard.php" class="btn btn-secondary">Dashboard</a>
                    <a href="includes/logout.php" class="btn btn-secondary">Logout</a>
                <?php else: ?>
                    <a href="register.php" class="btn btn-primary">Create New Account</a>
                    <a href="login.php" class="btn btn-secondary">Login</a>
                <?php endif; ?>
            </div>

            <div class="features">
                <h3>Key Features</h3>
                <ul>
                    <li>Easy User Registration</li>
                    <li>Secure Account Management</li>
                    <li>Professional Dashboard</li>
                    <li>Data Protection & Privacy</li>
                    <li>24/7 System Availability</li>
                    <li>Mobile Responsive Design</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
