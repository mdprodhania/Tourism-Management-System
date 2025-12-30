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

$query = "SELECT r.*, u.first_name, u.last_name, p.package_name 
          FROM reviews r
          JOIN users u ON r.user_id = u.id
          JOIN packages p ON r.package_id = p.id
          WHERE r.review_status = 'pending'
          ORDER BY r.created_at ASC";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

$reviews = [];
while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}

echo json_encode(['success' => true, 'reviews' => $reviews]);
?>
