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
    
    if (empty($email) || empty($password)) {
        sendResponse(false, "Email and password are required");
    }
    
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        sendResponse(false, "Database connection failed");
    }
    
    $query = "SELECT id, email, password, full_name FROM users WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (password_verify($password, $user['password'])) {
            sendResponse(true, "Login successful", [
                "user_id" => $user['id'],
                "email" => $user['email'],
                "full_name" => $user['full_name']
            ]);
        } else {
            sendResponse(false, "Invalid password");
        }
    } else {
        sendResponse(false, "User not found");
    }
    
} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    sendResponse(false, "Server error: " . $e->getMessage());
}
?>