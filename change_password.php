<?php
session_start();
require_once 'includes/db_config.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - Tourism Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .change-password-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0 0 5px 0;
            font-size: 24px;
        }

        .header p {
            margin: 0;
            opacity: 0.9;
        }

        .form-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }

        small {
            display: block;
            margin-top: 5px;
            color: #999;
            font-size: 12px;
        }

        .error-message {
            color: #d32f2f;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .button-group {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
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
            background: #f5f5f5;
            color: #333;
            border: 1px solid #ddd;
        }

        .btn-secondary:hover {
            background: white;
        }

        .nav-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            justify-content: space-between;
        }

        .nav-btn {
            padding: 10px 20px;
            background: white;
            color: #667eea;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }

        .alert.success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #4caf50;
            display: block;
        }

        .alert.error {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #f44336;
            display: block;
        }
    </style>
</head>
<body>
    <div class="change-password-container">
        <div class="nav-bar">
            <a href="profile.php" class="nav-btn">← Back to Profile</a>
            <a href="includes/logout.php" class="nav-btn">Logout</a>
        </div>

        <div class="header">
            <h1>🔐 Change Password</h1>
            <p>Update your account password</p>
        </div>

        <?php
        if (isset($_GET['success'])) {
            echo '<div class="alert success">' . htmlspecialchars($_GET['success']) . '</div>';
        }
        if (isset($_GET['error'])) {
            echo '<div class="alert error">' . htmlspecialchars($_GET['error']) . '</div>';
        }
        ?>

        <div class="form-card">
            <form id="changePasswordForm" method="POST" action="includes/change_password_handler.php">
                <div class="form-group">
                    <label for="current_password">Current Password *</label>
                    <input type="password" id="current_password" name="current_password" 
                           placeholder="Enter your current password" required minlength="6">
                    <span class="error-message" id="current_password_error"></span>
                </div>

                <div class="form-group">
                    <label for="new_password">New Password *</label>
                    <input type="password" id="new_password" name="new_password" 
                           placeholder="Enter your new password" required minlength="6">
                    <span class="error-message" id="new_password_error"></span>
                    <small>Password must be at least 6 characters</small>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm New Password *</label>
                    <input type="password" id="confirm_password" name="confirm_password" 
                           placeholder="Confirm your new password" required minlength="6">
                    <span class="error-message" id="confirm_password_error"></span>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                    <a href="profile.php" class="btn btn-secondary" style="text-decoration: none;">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(el => el.style.display = 'none');

            // Validation
            const currentPassword = document.getElementById('current_password').value;
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            let isValid = true;

            if (!currentPassword) {
                document.getElementById('current_password_error').textContent = 'Current password is required';
                document.getElementById('current_password_error').style.display = 'block';
                isValid = false;
            }

            if (!newPassword) {
                document.getElementById('new_password_error').textContent = 'New password is required';
                document.getElementById('new_password_error').style.display = 'block';
                isValid = false;
            } else if (newPassword.length < 6) {
                document.getElementById('new_password_error').textContent = 'Password must be at least 6 characters';
                document.getElementById('new_password_error').style.display = 'block';
                isValid = false;
            }

            if (!confirmPassword) {
                document.getElementById('confirm_password_error').textContent = 'Please confirm your password';
                document.getElementById('confirm_password_error').style.display = 'block';
                isValid = false;
            } else if (newPassword !== confirmPassword) {
                document.getElementById('confirm_password_error').textContent = 'Passwords do not match';
                document.getElementById('confirm_password_error').style.display = 'block';
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
