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
$stmt = $conn->prepare("SELECT first_name, last_name, email, username, phone, created_at FROM users WHERE id = ?");
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
    <title>My Profile - Tourism Management System</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
        }

        .profile-header h1 {
            margin: 0 0 10px 0;
            font-size: 28px;
        }

        .profile-info {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .info-group {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .info-group:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .info-label {
            font-weight: 600;
            color: #333;
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .info-value {
            color: #666;
            font-size: 16px;
        }

        .button-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
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
            background: #f5f5f5;
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

        .nav-btn:hover {
            background: #f5f5f5;
            border-color: #667eea;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="nav-bar">
            <a href="index.php" class="nav-btn">← Home</a>
            <div>
                <a href="dashboard.php" class="nav-btn">Dashboard</a>
                <a href="includes/logout.php" class="nav-btn">Logout</a>
            </div>
        </div>

        <div class="profile-header">
            <h1>👤 My Profile</h1>
            <p>View and manage your account information</p>
        </div>

        <div class="profile-info">
            <div class="info-group">
                <div class="info-label">Full Name</div>
                <div class="info-value"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></div>
            </div>

            <div class="info-group">
                <div class="info-label">Username</div>
                <div class="info-value"><?php echo htmlspecialchars($user['username'] ?? 'Not set'); ?></div>
            </div>

            <div class="info-group">
                <div class="info-label">Email Address</div>
                <div class="info-value"><?php echo htmlspecialchars($user['email']); ?></div>
            </div>

            <div class="info-group">
                <div class="info-label">Phone Number</div>
                <div class="info-value"><?php echo htmlspecialchars($user['phone'] ?? 'Not provided'); ?></div>
            </div>

            <div class="info-group">
                <div class="info-label">Account Created</div>
                <div class="info-value"><?php echo date('F j, Y', strtotime($user['created_at'])); ?></div>
            </div>
        </div>

        <div class="button-group">
            <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
            <a href="change_password.php" class="btn btn-primary">Change Password</a>
            <a href="booking_history.php" class="btn btn-secondary">View Bookings</a>
        </div>
    </div>
</body>
</html>
