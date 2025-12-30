<?php
session_start();
require_once 'includes/db_config.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get user data
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT first_name, last_name, email, username, phone FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Tourism Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .edit-profile-container {
            max-width: 600px;
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

        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }

        textarea {
            resize: vertical;
            min-height: 80px;
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
    <div class="edit-profile-container">
        <div class="nav-bar">
            <a href="profile.php" class="nav-btn">← Back to Profile</a>
            <a href="includes/logout.php" class="nav-btn">Logout</a>
        </div>

        <div class="header">
            <h1>✏️ Edit Profile</h1>
            <p>Update your account information</p>
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
            <form id="editProfileForm" method="POST" action="includes/edit_profile_handler.php">
                <div class="form-group">
                    <label for="first_name">First Name *</label>
                    <input type="text" id="first_name" name="first_name" 
                           value="<?php echo htmlspecialchars($user['first_name']); ?>"
                           placeholder="Enter your first name" required maxlength="100">
                    <span class="error-message" id="first_name_error"></span>
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name *</label>
                    <input type="text" id="last_name" name="last_name" 
                           value="<?php echo htmlspecialchars($user['last_name']); ?>"
                           placeholder="Enter your last name" required maxlength="100">
                    <span class="error-message" id="last_name_error"></span>
                </div>

                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo htmlspecialchars($user['email']); ?>"
                           placeholder="Enter your email address" required maxlength="255">
                    <span class="error-message" id="email_error"></span>
                </div>

                <div class="form-group">
                    <label for="username">Username *</label>
                    <input type="text" id="username" name="username" 
                           value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>"
                           placeholder="Your username (3-50 characters)"
                           minlength="3" maxlength="50" pattern="[a-zA-Z0-9_-]+" required>
                    <span class="error-message" id="username_error"></span>
                    <small>Letters, numbers, underscores, and hyphens only</small>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" 
                           value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>"
                           placeholder="Enter your phone number" maxlength="20">
                    <span class="error-message" id="phone_error"></span>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="profile.php" class="btn btn-secondary" style="text-decoration: none;">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('editProfileForm').addEventListener('submit', function(e) {
            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(el => el.style.display = 'none');

            // Validation
            const firstName = document.getElementById('first_name').value.trim();
            const lastName = document.getElementById('last_name').value.trim();
            const email = document.getElementById('email').value.trim();
            const username = document.getElementById('username').value.trim();
            let isValid = true;

            if (!firstName || firstName.length < 2) {
                document.getElementById('first_name_error').textContent = 'First name must be at least 2 characters';
                document.getElementById('first_name_error').style.display = 'block';
                isValid = false;
            }

            if (!lastName || lastName.length < 2) {
                document.getElementById('last_name_error').textContent = 'Last name must be at least 2 characters';
                document.getElementById('last_name_error').style.display = 'block';
                isValid = false;
            }

            if (!email) {
                document.getElementById('email_error').textContent = 'Email is required';
                document.getElementById('email_error').style.display = 'block';
                isValid = false;
            }

            if (!username || username.length < 3) {
                document.getElementById('username_error').textContent = 'Username must be at least 3 characters';
                document.getElementById('username_error').style.display = 'block';
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
