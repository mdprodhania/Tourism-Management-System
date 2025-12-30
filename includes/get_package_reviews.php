<?php
session_start();
include 'db_config.php';

$package_id = $_GET['package_id'] ?? 0;

if (!$package_id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Package ID is required']);
    exit();
}

$query = "SELECT r.*, u.first_name, u.last_name 
          FROM reviews r
          JOIN users u ON r.user_id = u.id
          WHERE r.package_id = ? AND r.review_status = 'approved'
          ORDER BY r.created_at DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $package_id);
$stmt->execute();
$result = $stmt->get_result();

$reviews = [];
$average_rating = 0;
$total_reviews = 0;

while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
    $average_rating += $row['rating'];
    $total_reviews++;
}

if ($total_reviews > 0) {
    $average_rating = $average_rating / $total_reviews;
}

echo json_encode([
    'success' => true,
    'reviews' => $reviews,
    'average_rating' => round($average_rating, 1),
    'total_reviews' => $total_reviews
]);
?>
