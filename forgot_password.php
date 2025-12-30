<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Tourism Management System</title>
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
            transition: color 0.3s;
        }

        .back-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .form-info {
            background: #e7f3ff;
            padding: 15px;
            border-left: 4px solid #667eea;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #0066cc;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <h1>Tourism Management System</h1>
            <h2>Forgot Password</h2>

            <?php
            // Display messages if set
            if (isset($_GET['success'])) {
                echo '<div class="alert alert-success">' . htmlspecialchars($_GET['success']) . '</div>';
            }
            if (isset($_GET['error'])) {
                echo '<div class="alert alert-error">' . htmlspecialchars($_GET['error']) . '</div>';
            }
            ?>

            <div class="form-info">
                Enter your email address and we'll send you a link to reset your password.
            </div>

            <form id="forgotPasswordForm" method="POST" action="includes/forgot_password_handler.php">
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" required 
                           placeholder="Enter your registered email address" maxlength="255">
                    <span class="error-message" id="email_error"></span>
                </div>

                <button type="submit" class="btn-register">Send Reset Link</button>
            </form>

            <div class="back-link">
                <p><a href="login.php">← Back to Login</a></p>
                <p><a href="index.php">← Back to Home</a></p>
            </div>
        </div>
    </div>

    <script src="js/forgot_password_validation.js"></script>
</body>
</html>
