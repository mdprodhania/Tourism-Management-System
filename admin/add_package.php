<?php
require_once '../includes/admin_check.php';
require_once '../includes/db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Package - Tourism Management System</title>
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
        input[type="email"],
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

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
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
            transition: all 0.3s;
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

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left-color: #28a745;
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
                <h1>📦 Add New Package</h1>
                <a href="dashboard.php" class="btn-back">← Back</a>
            </div>

            <?php
            if (isset($_GET['error'])) {
                echo '<div class="alert alert-error">' . htmlspecialchars($_GET['error']) . '</div>';
            }
            ?>

            <form id="addPackageForm" method="POST" action="../includes/add_package.php">
                <div class="form-row">
                    <div class="form-group">
                        <label for="package_name">Package Name *</label>
                        <input type="text" id="package_name" name="package_name" required maxlength="150"
                               placeholder="e.g., Beach Paradise">
                        <span class="error-message" id="package_name_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="destination">Destination *</label>
                        <input type="text" id="destination" name="destination" required maxlength="100"
                               placeholder="e.g., Maldives">
                        <span class="error-message" id="destination_error"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="duration_days">Duration (Days) *</label>
                        <input type="number" id="duration_days" name="duration_days" required min="1" max="365"
                               placeholder="e.g., 5">
                        <span class="error-message" id="duration_days_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="duration_nights">Duration (Nights) *</label>
                        <input type="number" id="duration_nights" name="duration_nights" required min="0" max="365"
                               placeholder="e.g., 4">
                        <span class="error-message" id="duration_nights_error"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="price">Price ($) *</label>
                        <input type="number" id="price" name="price" required min="0" step="0.01"
                               placeholder="e.g., 1200.00">
                        <span class="error-message" id="price_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="discount_price">Discount Price ($)</label>
                        <input type="number" id="discount_price" name="discount_price" min="0" step="0.01"
                               placeholder="e.g., 999.00">
                        <span class="error-message" id="discount_price_error"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="max_persons">Max Persons *</label>
                        <input type="number" id="max_persons" name="max_persons" required min="1" max="1000"
                               placeholder="e.g., 15">
                        <span class="error-message" id="max_persons_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select id="status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-group">
                        <label for="description">Description *</label>
                        <textarea id="description" name="description" required maxlength="1000"
                                  placeholder="Enter package description..."></textarea>
                        <span class="error-message" id="description_error"></span>
                    </div>
                </div>

                <div class="form-row full">
                    <div class="form-group">
                        <label for="itinerary">Itinerary *</label>
                        <textarea id="itinerary" name="itinerary" required maxlength="2000"
                                  placeholder="Enter day-by-day itinerary..."></textarea>
                        <span class="error-message" id="itinerary_error"></span>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn-submit">Create Package</button>
                    <a href="dashboard.php" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script src="../js/add_package_validation.js"></script>
</body>
</html>
