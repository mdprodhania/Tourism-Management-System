<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tourism Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .register-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        .register-link p {
            color: #666;
            font-size: 14px;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .register-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .remember-forgot a {
            color: #667eea;
            text-decoration: none;
        }

        .remember-forgot a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <h1>Tourism Management System</h1>
            <h2>User Login</h2>

            <?php
            // Display messages if set
            if (isset($_GET['success'])) {
                echo '<div class="alert alert-success">' . htmlspecialchars($_GET['success']) . '</div>';
            }
            if (isset($_GET['error'])) {
                echo '<div class="alert alert-error">' . htmlspecialchars($_GET['error']) . '</div>';
            }
            ?>

            <form id="loginForm" method="POST" action="includes/login_handler.php">
                <div class="form-group">
                    <label for="login">Username or Email *</label>
                    <input type="text" id="login" name="login" required 
                           placeholder="Enter your username or email address" maxlength="255">
                    <span class="error-message" id="login_error"></span>
                </div>

                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" required 
                           placeholder="Enter your password" minlength="6">
                    <span class="error-message" id="password_error"></span>
                </div>

                <div class="remember-forgot">
                    <label style="display: flex; align-items: center; cursor: pointer;">
                        <input type="checkbox" name="remember_me" style="margin-right: 8px; cursor: pointer;">
                        Remember me
                    </label>
                    <a href="forgot_password.php" style="font-size: 13px;">Forgot Password?</a>
                </div>

                <button type="submit" class="btn-register">Login</button>
            </form>

            <div class="register-link">
                <p>Don't have an account? <a href="register.php">Register here</a></p>
                <p><a href="index.php">← Back to Home</a></p>
            </div>
        </div>
    </div>

    <script src="js/login_validation.js"></script>
</body>
</html>
