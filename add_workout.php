<?php
// save_workout.php
include 'config.php';

try {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        sendResponse(false, "Only POST method allowed");
    }

    $data = getJsonInput();

    $userId = $data['user_id'] ?? '';
    $type = $data['type'] ?? '';
    $duration = $data['duration'] ?? '';
    $calories = $data['calories'] ?? '';
    $date = $data['date'] ?? '';
    $distance = isset($data['distance']) && $data['distance'] !== null ? $data['distance'] : null;
    $details = $data['details'] ?? '';
    $coordinates = $data['coordinates'] ?? '';
    
    // Validate required fields
    if (empty($userId) || empty($type) || empty($duration) || empty($calories) || empty($date)) {
        sendResponse(false, "Required fields missing: user_id, type, duration, calories, date");
    }
    
    // Validate workout type
    $validTypes = ['Running', 'Cycling', 'Swimming', 'Yoga', 'Weightlifting'];
    if (!in_array($type, $validTypes)) {
        sendResponse(false, "Invalid workout type. Allowed: " . implode(', ', $validTypes));
    }
    
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        sendResponse(false, "Database connection failed");
    }
    
    // Insert workout
    $query = "INSERT INTO workouts (user_id, type, distance, duration, calories, date, details, coordinates, created_at) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $db->prepare($query);
    
    if ($stmt->execute([$userId, $type, $distance, $duration, $calories, $date, $details, $coordinates])) {
        sendResponse(true, "Workout saved successfully", [
            "workout_id" => $db->lastInsertId(),
            "user_id" => $userId,
            "type" => $type,
            "distance" => $distance,
            "duration" => $duration,
            "calories" => $calories,
            "date" => $date,
            "details" => $details,
            "coordinates" => $coordinates
        ]);
    } else {
        sendResponse(false, "Failed to save workout");
    }
    
} catch (Exception $e) {
    error_log("Save workout error: " . $e->getMessage());
    sendResponse(false, "Server error: " . $e->getMessage());
}
?>