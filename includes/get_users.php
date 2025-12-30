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

$query = "SELECT u.id, u.first_name, u.last_name, u.email, u.phone, u.role, u.status 
          FROM users u 
          WHERE u.role = 'user'
          ORDER BY u.created_at DESC";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode(['success' => true, 'users' => $users]);
?>
