<?php
session_start();
include 'db_config.php';
include 'admin_check.php';

// Check if user is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$query = "SELECT b.*, u.first_name, u.last_name, p.package_name 
          FROM bookings b
          JOIN users u ON b.user_id = u.id
          JOIN packages p ON b.package_id = p.id
          ORDER BY b.created_at DESC";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

$bookings = [];
while ($row = $result->fetch_assoc()) {
    $row['user_name'] = $row['first_name'] . ' ' . $row['last_name'];
    $bookings[] = $row;
}

echo json_encode(['success' => true, 'bookings' => $bookings]);
?>
