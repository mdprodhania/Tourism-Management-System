<?php
require_once 'includes/session_check.php';
require_once 'includes/db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Tourism Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .dashboard-container {
            max-width: 900px;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
        }

        .dashboard-header h2 {
            font-size: 28px;
            margin-bottom: 10px;
            color: white;
        }

        .dashboard-header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .dashboard-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .user-info {
            margin-bottom: 30px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #333;
        }

        .info-value {
            color: #666;
        }

        .dashboard-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn-action {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
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

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        .activity-section {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #eee;
        }

        .activity-section h3 {
            color: #333;
            margin-bottom: 20px;
            font-size: 20px;
        }

        .activity-item {
            padding: 15px;
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .activity-time {
            color: #999;
            font-size: 12px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 14px;
            border-left: 4px solid;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left-color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="dashboard-container">
            <?php
            if (isset($_GET['success'])) {
                echo '<div class="alert alert-success">' . htmlspecialchars($_GET['success']) . '</div>';
            }
            ?>

            <div class="dashboard-header">
                <h2>Welcome, <?php echo htmlspecialchars($_SESSION['first_name']) . ' ' . htmlspecialchars($_SESSION['last_name']); ?>! 👋</h2>
                <p>You are successfully logged into Tourism Management System</p>
            </div>

            <div class="dashboard-content">
                <div class="user-info">
                    <h3 style="color: #333; margin-bottom: 20px; font-size: 18px;">Your Account Information</h3>
                    
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="info-value"><?php echo htmlspecialchars($_SESSION['email']); ?></span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Full Name:</span>
                        <span class="info-value"><?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?></span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Login Time:</span>
                        <span class="info-value"><?php echo date('Y-m-d H:i:s', $_SESSION['login_time']); ?></span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Session Status:</span>
                        <span class="info-value"><strong style="color: #28a745;">✓ Active</strong></span>
                    </div>
                </div>

                <div class="dashboard-actions">
                    <button class="btn-action btn-primary" onclick="editProfile()">Edit Profile</button>
                    <button class="btn-action btn-primary" onclick="changePassword()">Change Password</button>
                    <a href="includes/logout.php" class="btn-action btn-danger">Logout</a>
                </div>

                <div class="activity-section">
                    <h3>Quick Links</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
                        <a href="index.php" style="padding: 15px; background: #f0f0f0; border-radius: 5px; text-align: center; text-decoration: none; color: #667eea; font-weight: 600; transition: 0.3s;" onmouseover="this.style.background='#e0e0e0'" onmouseout="this.style.background='#f0f0f0'">
                            ← Back to Home
                        </a>
                        <a href="register.php" style="padding: 15px; background: #f0f0f0; border-radius: 5px; text-align: center; text-decoration: none; color: #667eea; font-weight: 600; transition: 0.3s;" onmouseover="this.style.background='#e0e0e0'" onmouseout="this.style.background='#f0f0f0'">
                            New Registration
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editProfile() {
            alert('Profile editing feature coming soon!');
        }

        function changePassword() {
            alert('Password change feature coming soon!');
        }
    </script>
</body>
</html>
