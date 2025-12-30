<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Tourism Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <h1>Tourism Management System</h1>
            <h2>User Registration</h2>

            <?php
            // Display messages if set
            if (isset($_GET['success'])) {
                echo '<div class="alert alert-success">' . htmlspecialchars($_GET['success']) . '</div>';
            }
            if (isset($_GET['error'])) {
                echo '<div class="alert alert-error">' . htmlspecialchars($_GET['error']) . '</div>';
            }
            ?>

            <form id="registrationForm" method="POST" action="includes/register_handler.php">
                <div class="form-group">
                    <label for="first_name">First Name *</label>
                    <input type="text" id="first_name" name="first_name" required 
                           placeholder="Enter your first name" maxlength="100">
                    <span class="error-message" id="first_name_error"></span>
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name *</label>
                    <input type="text" id="last_name" name="last_name" required 
                           placeholder="Enter your last name" maxlength="100">
                    <span class="error-message" id="last_name_error"></span>
                </div>

                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" required 
                           placeholder="Enter your email address" maxlength="255">
                    <span class="error-message" id="email_error"></span>
                </div>

                <div class="form-group">
                    <label for="username">Username *</label>
                    <input type="text" id="username" name="username" required 
                           placeholder="Choose a username (3-50 characters)" 
                           minlength="3" maxlength="50" pattern="[a-zA-Z0-9_-]+">
                    <span class="error-message" id="username_error"></span>
                    <small>Letters, numbers, underscores, and hyphens only</small>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" 
                           placeholder="Enter your phone number" maxlength="20">
                    <span class="error-message" id="phone_error"></span>
                </div>

                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" required 
                           placeholder="Enter a strong password" minlength="6">
                    <span class="error-message" id="password_error"></span>
                    <small>Password must be at least 6 characters</small>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password *</label>
                    <input type="password" id="confirm_password" name="confirm_password" required 
                           placeholder="Confirm your password" minlength="6">
                    <span class="error-message" id="confirm_password_error"></span>
                </div>

                <button type="submit" class="btn-register">Register Account</button>
            </form>

            <div class="login-link">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>

    <script src="js/validation.js"></script>
</body>
</html>
