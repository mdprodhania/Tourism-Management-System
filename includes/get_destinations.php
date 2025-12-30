<?php
include 'db_config.php';

$status = $_GET['status'] ?? 'active';

$query = "SELECT * FROM destinations WHERE status = ? ORDER BY destination_name";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $status);
$stmt->execute();
$result = $stmt->get_result();

$destinations = [];
while ($row = $result->fetch_assoc()) {
    $destinations[] = $row;
}

echo json_encode(['success' => true, 'destinations' => $destinations]);
?>
