<?php
session_start();
include 'db_config.php';
include 'session_check.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT b.*, p.package_name, p.destination, p.price, p.discount_price 
          FROM bookings b
          JOIN packages p ON b.package_id = p.id
          WHERE b.user_id = ?
          ORDER BY b.created_at DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$bookings = [];
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

echo json_encode(['success' => true, 'bookings' => $bookings]);
?>
