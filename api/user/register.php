<?php

// Add CORS headers at the beginning of your script
header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle OPTIONS request for preflight
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200); // Send HTTP 200 OK for preflight requests
    exit;
}

// Include configuration and model files
require_once '../../config/config.php';

// Get the PDO object
$pdo = getDBConnection();

// Get POST data
$data = json_decode(file_get_contents("php://input"));

// Initialize User model with the PDO object
require_once '../../models/user.php';
$userModel = new User($pdo);

// Example of creating a user
$response = $userModel->create($data->first_name, $data->last_name, $data->email, $data->password, $data->phone);

// Output response as JSON
echo json_encode($response);
?>
