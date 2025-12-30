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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'approve_review') {
        $review_id = $_POST['review_id'] ?? 0;
        
        if (!$review_id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Review ID is required']);
            exit();
        }
        
        $query = "UPDATE reviews SET review_status = 'approved' WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $review_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Review approved']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error approving review']);
        }
    }
    elseif ($action === 'reject_review') {
        $review_id = $_POST['review_id'] ?? 0;
        $admin_notes = $_POST['admin_notes'] ?? '';
        
        if (!$review_id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Review ID is required']);
            exit();
        }
        
        $query = "UPDATE reviews SET review_status = 'rejected', admin_notes = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $admin_notes, $review_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Review rejected']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error rejecting review']);
        }
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>
