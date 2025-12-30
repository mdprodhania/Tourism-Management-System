<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Tourism Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .back-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .error-box {
            background: #f8d7da;
            color: #721c24;
            padding: 20px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <h1>Tourism Management System</h1>
            <h2>Reset Password</h2>

            <?php
            require_once 'includes/db_config.php';

            // Get token from URL
            $token = isset($_GET['token']) ? trim($_GET['token']) : '';

            if (empty($token)) {
                echo '<div class="error-box">
                    <p><strong>Error:</strong> No reset token provided.</p>
                    <p><a href="forgot_password.php">← Request a new reset link</a></p>
                </div>';
                exit();
            }

            // Verify token and check if not expired
            $stmt = $conn->prepare("SELECT user_id FROM password_reset_tokens WHERE token = ? AND expires_at > NOW()");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                echo '<div class="error-box">
                    <p><strong>Error:</strong> Invalid or expired reset link.</p>
                    <p><a href="forgot_password.php">← Request a new reset link</a></p>
                </div>';
                $stmt->close();
                $conn->close();
                exit();
            }

            $row = $result->fetch_assoc();
            $user_id = $row['user_id'];
            $stmt->close();

            // Display messages if set
            if (isset($_GET['success'])) {
                echo '<div class="alert alert-success">' . htmlspecialchars($_GET['success']) . '</div>';
            }
            if (isset($_GET['error'])) {
                echo '<div class="alert alert-error">' . htmlspecialchars($_GET['error']) . '</div>';
            }
            ?>

            <form id="resetPasswordForm" method="POST" action="includes/reset_password_handler.php">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

                <div class="form-group">
                    <label for="password">New Password *</label>
                    <input type="password" id="password" name="password" required 
                           placeholder="Enter your new password" minlength="6">
                    <span class="error-message" id="password_error"></span>
                    <small>Password must be at least 6 characters</small>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password *</label>
                    <input type="password" id="confirm_password" name="confirm_password" required 
                           placeholder="Confirm your new password" minlength="6">
                    <span class="error-message" id="confirm_password_error"></span>
                </div>

                <button type="submit" class="btn-register">Reset Password</button>
            </form>

            <div class="back-link">
                <p><a href="login.php">← Back to Login</a></p>
            </div>
        </div>
    </div>

    <script src="js/reset_password_validation.js"></script>
</body>
</html>
