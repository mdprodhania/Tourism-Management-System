<?php
require_once 'admin_check.php';
require_once 'db_config.php';

// Get package ID from URL
$package_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($package_id === 0) {
    header("Location: ../admin/dashboard.php?error=" . urlencode("Invalid package ID"));
    exit();
}

// Get package name before deleting
$stmt = $conn->prepare("SELECT package_name FROM packages WHERE id = ?");
$stmt->bind_param("i", $package_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: ../admin/dashboard.php?error=" . urlencode("Package not found"));
    $stmt->close();
    $conn->close();
    exit();
}

$package = $result->fetch_assoc();
$package_name = $package['package_name'];
$stmt->close();

// Delete package from database
$stmt = $conn->prepare("DELETE FROM packages WHERE id = ?");
$stmt->bind_param("i", $package_id);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    
    $success_msg = "Package '" . htmlspecialchars($package_name) . "' deleted successfully!";
    header("Location: ../admin/dashboard.php?success=" . urlencode($success_msg));
    exit();
} else {
    $error = $conn->error;
    header("Location: ../admin/dashboard.php?error=" . urlencode("Failed to delete package"));
    $stmt->close();
    exit();
}

$conn->close();
?>
