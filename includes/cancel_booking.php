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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'] ?? 0;
    $user_id = $_SESSION['user_id'];
    
    if (!$booking_id) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Booking ID is required']);
        exit();
    }
    
    // Get booking details
    $query = "SELECT * FROM bookings WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $booking_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();
    
    if (!$booking) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Booking not found']);
        exit();
    }
    
    // Check if booking can be cancelled (not already cancelled)
    if ($booking['booking_status'] !== 'active') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Booking cannot be cancelled']);
        exit();
    }
    
    // Check if travel date hasn't passed (cancellation allowed 7 days before)
    $travel_date = strtotime($booking['travel_date']);
    $current_date = time();
    $days_until_travel = ($travel_date - $current_date) / (60 * 60 * 24);
    
    if ($days_until_travel < 7) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Cannot cancel within 7 days of travel date']);
        exit();
    }
    
    // Calculate refund (100% refund if cancelled 7+ days before)
    $refund_amount = $booking['total_price'];
    
    // Cancel booking
    $cancel_query = "UPDATE bookings SET booking_status = 'cancelled', cancellation_date = NOW(), refund_amount = ? WHERE id = ?";
    $stmt = $conn->prepare($cancel_query);
    $stmt->bind_param("di", $refund_amount, $booking_id);
    
    if ($stmt->execute()) {
        // Update package persons_booked
        $update_query = "UPDATE packages SET persons_booked = persons_booked - ? WHERE id = ?";
        $stmt2 = $conn->prepare($update_query);
        $stmt2->bind_param("ii", $booking['num_persons'], $booking['package_id']);
        $stmt2->execute();
        
        echo json_encode(['success' => true, 'message' => 'Booking cancelled successfully', 'refund_amount' => $refund_amount]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error cancelling booking']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>
