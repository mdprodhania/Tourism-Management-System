<?php
require_once '../includes/admin_check.php';
require_once '../includes/db_config.php';

// Get form data
$package_id = intval($_POST['package_id'] ?? 0);
$package_name = trim($_POST['package_name'] ?? '');
$destination = trim($_POST['destination'] ?? '');
$duration_days = intval($_POST['duration_days'] ?? 0);
$duration_nights = intval($_POST['duration_nights'] ?? 0);
$price = floatval($_POST['price'] ?? 0);
$discount_price = !empty($_POST['discount_price']) ? floatval($_POST['discount_price']) : null;
$description = trim($_POST['description'] ?? '');
$itinerary = trim($_POST['itinerary'] ?? '');
$max_persons = intval($_POST['max_persons'] ?? 0);
$status = $_POST['status'] ?? 'active';

// Validation
$errors = [];

if ($package_id === 0) {
    $errors['package_id'] = 'Invalid package ID';
}

if (empty($package_name) || strlen($package_name) < 2) {
    $errors['package_name'] = 'Package name is required';
}

if (empty($destination) || strlen($destination) < 2) {
    $errors['destination'] = 'Destination is required';
}

if ($duration_days < 1) {
    $errors['duration_days'] = 'Duration in days must be at least 1';
}

if ($price <= 0) {
    $errors['price'] = 'Price must be greater than 0';
}

if ($discount_price !== null && $discount_price >= $price) {
    $errors['discount_price'] = 'Discount price must be less than original price';
}

// If validation fails, redirect back
if (!empty($errors)) {
    $error_msg = implode(', ', array_values($errors));
    header("Location: ../admin/edit_package.php?id=" . $package_id . "&error=" . urlencode($error_msg));
    exit();
}

// Update package in database
$stmt = $conn->prepare("
    UPDATE packages 
    SET package_name = ?, destination = ?, duration_days = ?, duration_nights = ?, 
        price = ?, discount_price = ?, description = ?, itinerary = ?, max_persons = ?, status = ?
    WHERE id = ?
");

$stmt->bind_param(
    "ssiiiddssi",
    $package_name,
    $destination,
    $duration_days,
    $duration_nights,
    $price,
    $discount_price,
    $description,
    $itinerary,
    $max_persons,
    $status,
    $package_id
);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    
    $success_msg = "Package '" . htmlspecialchars($package_name) . "' updated successfully!";
    header("Location: ../admin/dashboard.php?success=" . urlencode($success_msg));
    exit();
} else {
    $error = $conn->error;
    header("Location: ../admin/edit_package.php?id=" . $package_id . "&error=" . urlencode("Failed to update package"));
    $stmt->close();
    exit();
}

$conn->close();
?>
