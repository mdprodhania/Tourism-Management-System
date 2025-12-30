<?php
header('Content-Type: application/json');
require_once 'db_config.php';

// Get only active packages
$stmt = $conn->prepare("
    SELECT 
        id, 
        package_name, 
        destination, 
        duration_days, 
        duration_nights, 
        price, 
        discount_price, 
        description, 
        itinerary, 
        image_url, 
        max_persons, 
        persons_booked, 
        status 
    FROM packages 
    WHERE status = 'active' 
    ORDER BY created_at DESC
");

$stmt->execute();
$result = $stmt->get_result();

$packages = [];
while ($row = $result->fetch_assoc()) {
    $packages[] = $row;
}

$stmt->close();
$conn->close();

// Return JSON response
echo json_encode([
    'success' => true,
    'packages' => $packages,
    'count' => count($packages)
]);
?>
