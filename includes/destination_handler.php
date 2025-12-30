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
    
    if ($action === 'add_destination') {
        $destination_name = $_POST['destination_name'] ?? '';
        $description = $_POST['description'] ?? '';
        $location = $_POST['location'] ?? '';
        $country = $_POST['country'] ?? '';
        $best_season = $_POST['best_season'] ?? '';
        $attractions = $_POST['attractions'] ?? '';
        $image_url = $_POST['image_url'] ?? '';
        
        if (!$destination_name || !$country) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Name and country are required']);
            exit();
        }
        
        $query = "INSERT INTO destinations (destination_name, description, location, country, best_season, attractions, image_url, status) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, 'active')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssss", $destination_name, $description, $location, $country, $best_season, $attractions, $image_url);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Destination added successfully', 'destination_id' => $stmt->insert_id]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error adding destination']);
        }
    }
    elseif ($action === 'update_destination') {
        $id = $_POST['id'] ?? 0;
        $destination_name = $_POST['destination_name'] ?? '';
        $description = $_POST['description'] ?? '';
        $location = $_POST['location'] ?? '';
        $country = $_POST['country'] ?? '';
        $best_season = $_POST['best_season'] ?? '';
        $attractions = $_POST['attractions'] ?? '';
        $image_url = $_POST['image_url'] ?? '';
        
        if (!$id || !$destination_name || !$country) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit();
        }
        
        $query = "UPDATE destinations SET destination_name = ?, description = ?, location = ?, country = ?, best_season = ?, attractions = ?, image_url = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssi", $destination_name, $description, $location, $country, $best_season, $attractions, $image_url, $id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Destination updated successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error updating destination']);
        }
    }
    elseif ($action === 'delete_destination') {
        $id = $_POST['id'] ?? 0;
        
        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Destination ID is required']);
            exit();
        }
        
        $query = "DELETE FROM destinations WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Destination deleted successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error deleting destination']);
        }
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>
