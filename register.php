<?php
include 'config.php';

try {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        sendResponse(false, "Only POST method allowed");
    }

    $input = file_get_contents("php://input");
    if (empty($input)) {
        sendResponse(false, "No data received");
    }

    $data = json_decode($input);
    if ($data === null) {
        sendResponse(false, "Invalid JSON data");
    }

    $email = $data->email ?? '';
    $password = $data->password ?? '';
    $fullName = $data->full_name ?? '';
    
    if (empty($email) || empty($password) || empty($fullName)) {
        sendResponse(false, "All fields are required");
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        sendResponse(false, "Invalid email format");
    }
    
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        sendResponse(false, "Database connection failed");
    }
    
    // Check if email exists
    $checkQuery = "SELECT id FROM users WHERE email = ?";
    $checkStmt = $db->prepare($checkQuery);
    $checkStmt->execute([$email]);
    
    if ($checkStmt->rowCount() > 0) {
        sendResponse(false, "Email already registered");
    }
    
    // Insert user
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (email, password, full_name) VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);
    
    if ($stmt->execute([$email, $hashedPassword, $fullName])) {
        sendResponse(true, "Registration successful", [
            "user_id" => $db->lastInsertId(),
            "email" => $email,
            "full_name" => $fullName
        ]);
    } else {
        sendResponse(false, "Registration failed");
    }
    
} catch (Exception $e) {
    error_log("Registration error: " . $e->getMessage());
    sendResponse(false, "Server error: " . $e->getMessage());
}
?>