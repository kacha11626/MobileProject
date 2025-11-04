<?php
// get_workouts.php
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
    
    // Get workouts for user
    $query = "SELECT id, user_id, type, distance, duration, calories, date, details, coordinates, created_at 
              FROM workouts 
              WHERE user_id = ? 
              ORDER BY created_at DESC";
    $stmt = $db->prepare($query);
    $stmt->execute([$userId]);
    
    $workouts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Format the response
    $formattedWorkouts = [];
    foreach ($workouts as $workout) {
        $formattedWorkouts[] = [
            'id' => (int)$workout['id'],
            'user_id' => (int)$workout['user_id'],
            'type' => $workout['type'],
            'distance' => $workout['distance'] !== null ? (float)$workout['distance'] : null,
            'duration' => (int)$workout['duration'],
            'calories' => (int)$workout['calories'],
            'date' => $workout['date'],
            'details' => $workout['details'],
            'coordinates' => $workout['coordinates']
        ];
    }
    
    sendResponse(true, "Workouts loaded successfully", $formattedWorkouts);
    
} catch (Exception $e) {
    error_log("Get workouts error: " . $e->getMessage());
    sendResponse(false, "Server error: " . $e->getMessage());
}
?>