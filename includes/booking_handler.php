<?php
session_start();
include 'db_config.php';
include 'session_check.php';

// Check if user is logged in and is a regular user
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create_booking') {
        $user_id = $_SESSION['user_id'];
        $package_id = $_POST['package_id'] ?? 0;
        $travel_date = $_POST['travel_date'] ?? '';
        $num_persons = $_POST['num_persons'] ?? 1;
        $special_requests = $_POST['special_requests'] ?? '';
        
        // Validate inputs
        if (!$package_id || !$travel_date || !$num_persons) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit();
        }
        
        // Validate date is in future
        if (strtotime($travel_date) < time()) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Travel date must be in the future']);
            exit();
        }
        
        // Get package details
        $package_query = "SELECT * FROM packages WHERE id = ? AND status = 'active'";
        $stmt = $conn->prepare($package_query);
        $stmt->bind_param("i", $package_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $package = $result->fetch_assoc();
        
        if (!$package) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Package not found']);
            exit();
        }
        
        // Check availability
        $available_persons = $package['max_persons'] - $package['persons_booked'];
        if ($num_persons > $available_persons) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => "Only $available_persons persons available"]);
            exit();
        }
        
        // Calculate total price
        $price_per_person = $package['discount_price'] ?? $package['price'];
        $total_price = $price_per_person * $num_persons;
        
        // Create booking
        $booking_query = "INSERT INTO bookings (user_id, package_id, travel_date, num_persons, total_price, special_requests, payment_status, booking_status) 
                         VALUES (?, ?, ?, ?, ?, ?, 'completed', 'active')";
        $stmt = $conn->prepare($booking_query);
        $stmt->bind_param("iisids", $user_id, $package_id, $travel_date, $num_persons, $total_price, $special_requests);
        
        if ($stmt->execute()) {
            // Update package persons_booked
            $update_query = "UPDATE packages SET persons_booked = persons_booked + ? WHERE id = ?";
            $stmt2 = $conn->prepare($update_query);
            $stmt2->bind_param("ii", $num_persons, $package_id);
            $stmt2->execute();
            
            echo json_encode(['success' => true, 'message' => 'Booking created successfully', 'booking_id' => $stmt->insert_id]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error creating booking']);
        }
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>
