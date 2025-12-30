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
    $action = $_POST['action'] ?? '';
    $user_id = $_SESSION['user_id'];
    
    if ($action === 'submit_review') {
        $booking_id = $_POST['booking_id'] ?? 0;
        $package_id = $_POST['package_id'] ?? 0;
        $rating = $_POST['rating'] ?? 0;
        $title = $_POST['title'] ?? '';
        $review_text = $_POST['review_text'] ?? '';
        
        // Validate inputs
        if (!$booking_id || !$package_id || !$rating || !$title || !$review_text) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit();
        }
        
        if ($rating < 1 || $rating > 5) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Rating must be between 1 and 5']);
            exit();
        }
        
        // Verify booking belongs to user
        $booking_query = "SELECT * FROM bookings WHERE id = ? AND user_id = ? AND booking_status = 'completed'";
        $stmt = $conn->prepare($booking_query);
        $stmt->bind_param("ii", $booking_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'You can only review completed bookings']);
            exit();
        }
        
        // Check if review already exists
        $check_query = "SELECT id FROM reviews WHERE booking_id = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'You have already reviewed this booking']);
            exit();
        }
        
        // Insert review
        $review_query = "INSERT INTO reviews (booking_id, user_id, package_id, rating, title, review_text, review_status) 
                        VALUES (?, ?, ?, ?, ?, ?, 'pending')";
        $stmt = $conn->prepare($review_query);
        $stmt->bind_param("iiiiss", $booking_id, $user_id, $package_id, $rating, $title, $review_text);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Review submitted successfully for moderation']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error submitting review']);
        }
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>
