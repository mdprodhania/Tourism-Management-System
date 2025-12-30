<?php
require_once '../includes/admin_check.php';
require_once '../includes/db_config.php';

// Get form data
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

if (empty($package_name) || strlen($package_name) < 2) {
    $errors['package_name'] = 'Package name is required (min 2 characters)';
}

if (empty($destination) || strlen($destination) < 2) {
    $errors['destination'] = 'Destination is required (min 2 characters)';
}

if ($duration_days < 1) {
    $errors['duration_days'] = 'Duration in days must be at least 1';
}

if ($duration_nights < 0) {
    $errors['duration_nights'] = 'Duration in nights cannot be negative';
}

if ($price <= 0) {
    $errors['price'] = 'Price must be greater than 0';
}

if ($discount_price !== null && $discount_price >= $price) {
    $errors['discount_price'] = 'Discount price must be less than original price';
}

if (empty($description) || strlen($description) < 10) {
    $errors['description'] = 'Description is required (min 10 characters)';
}

if (empty($itinerary) || strlen($itinerary) < 10) {
    $errors['itinerary'] = 'Itinerary is required (min 10 characters)';
}

if ($max_persons < 1) {
    $errors['max_persons'] = 'Max persons must be at least 1';
}

if (!in_array($status, ['active', 'inactive'])) {
    $errors['status'] = 'Invalid status';
}

// If validation fails, redirect back
if (!empty($errors)) {
    $error_msg = implode(', ', array_values($errors));
    header("Location: ../admin/add_package.php?error=" . urlencode($error_msg));
    exit();
}

// Insert package into database
$stmt = $conn->prepare("
    INSERT INTO packages 
    (package_name, destination, duration_days, duration_nights, price, discount_price, description, itinerary, max_persons, status) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "ssiiiddsss",
    $package_name,
    $destination,
    $duration_days,
    $duration_nights,
    $price,
    $discount_price,
    $description,
    $itinerary,
    $max_persons,
    $status
);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    
    $success_msg = "Package '" . htmlspecialchars($package_name) . "' created successfully!";
    header("Location: ../admin/dashboard.php?success=" . urlencode($success_msg));
    exit();
} else {
    $error = $conn->error;
    header("Location: ../admin/add_package.php?error=" . urlencode("Failed to create package. Error: " . $error));
    $stmt->close();
    exit();
}

$conn->close();
?>
