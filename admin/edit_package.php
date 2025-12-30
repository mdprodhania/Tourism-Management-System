<?php
require_once '../includes/admin_check.php';
require_once '../includes/db_config.php';

// Get package ID
$package_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($package_id === 0) {
    header("Location: dashboard.php?error=" . urlencode("Invalid package ID"));
    exit();
}

// Get package details
$stmt = $conn->prepare("SELECT * FROM packages WHERE id = ?");
$stmt->bind_param("i", $package_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: dashboard.php?error=" . urlencode("Package not found"));
    $stmt->close();
    $conn->close();
    exit();
}

$package = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Package - Tourism Management System</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background-color: #f5f5f5;
        }

        .form-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
        }

        .form-card {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }

        .form-header h1 {
            color: #333;
            margin: 0;
            font-size: 28px;
        }

        .btn-back {
            padding: 10px 20px;
            background: #999;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-back:hover {
            background: #777;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-row.full {
            grid-template-columns: 1fr;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #eee;
        }

        .btn-submit {
            flex: 1;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-cancel {
            flex: 1;
            padding: 15px;
            background: #999;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-cancel:hover {
            background: #777;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            border-left: 4px solid;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border-left-color: #dc3545;
        }

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .form-header {
                flex-direction: column;
                gap: 15px;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <h1>✏️ Edit Package</h1>
                <a href="dashboard.php" class="btn-back">← Back</a>
            </div>

            <?php
            if (isset($_GET['error'])) {
                echo '<div class="alert alert-error">' . htmlspecialchars($_GET['error']) . '</div>';
            }
            ?>

            <form id="editPackageForm" method="POST" action="../includes/edit_package.php">
                <input type="hidden" name="package_id" value="<?php echo $package['id']; ?>">

                <div class="form-row">
                    <div class="form-group">
                        <label for="package_name">Package Name *</label>
                        <input type="text" id="package_name" name="package_name" required maxlength="150"
                               value="<?php echo htmlspecialchars($package['package_name']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="destination">Destination *</label>
                        <input type="text" id="destination" name="destination" required maxlength="100"
                               value="<?php echo htmlspecialchars($package['destination']); ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="duration_days">Duration (Days) *</label>
                        <input type="number" id="duration_days" name="duration_days" required min="1" max="365"
                               value="<?php echo $package['duration_days']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="duration_nights">Duration (Nights) *</label>
                        <input type="number" id="duration_nights" name="duration_nights" required min="0" max="365"
                               value="<?php echo $package['duration_nights']; ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="price">Price ($) *</label>
                        <input type="number" id="price" name="price" required min="0" step="0.01"
                               value="<?php echo $package['price']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="discount_price">Discount Price ($)</label>
                        <input type="number" id="discount_price" name="discount_price" min="0" step="0.01"
                               value="<?php echo $package['discount_price'] ?? ''; ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="max_persons">Max Persons *</label>
                        <input type="number" id="max_persons" name="max_persons" required min="1" max="1000"
                               value="<?php echo $package['max_persons']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select id="status" name="status" required>
                            <option value="active" <?php echo $package['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo $package['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-group">
                        <label for="description">Description *</label>
                        <textarea id="description" name="description" required maxlength="1000"><?php echo htmlspecialchars($package['description']); ?></textarea>
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-group">
                        <label for="itinerary">Itinerary *</label>
                        <textarea id="itinerary" name="itinerary" required maxlength="2000"><?php echo htmlspecialchars($package['itinerary']); ?></textarea>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn-submit">Update Package</button>
                    <a href="dashboard.php" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script src="../js/edit_package_validation.js"></script>
</body>
</html>

<?php
$conn->close();
?>
