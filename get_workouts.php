<?php
include 'config.php';

try {
    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
        sendResponse(false, "Only GET method allowed");
    }

    $userId = $_GET['user_id'] ?? '';
    
    if (empty($userId)) {
        sendResponse(false, "User ID is required");
    }
    
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        sendResponse(false, "Database connection failed");
    }
    
    $query = "SELECT * FROM workouts WHERE user_id = ? ORDER BY created_at DESC";
    $stmt = $db->prepare($query);
    $stmt->execute([$userId]);
    
    $workouts = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $workouts[] = [
            "id" => $row['id'],
            "type" => $row['type'],
            "distance" => $row['distance'],
            "duration" => $row['duration'],
            "calories" => $row['calories'],
            "date" => $row['date'],
            "details" => $row['details'],
            "coordinates" => $row['coordinates']
        ];
    }
    
    sendResponse(true, "Workouts retrieved successfully", $workouts);
    
} catch (Exception $e) {
    error_log("Get workouts error: " . $e->getMessage());
    sendResponse(false, "Server error: " . $e->getMessage());
}
?>