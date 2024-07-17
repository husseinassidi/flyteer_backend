<?php
// Add CORS headers at the beginning of your script
header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Include configuration and model files
require_once '../../config/config.php';
require_once '../../models/hotel.php';

// Handle OPTIONS request for preflight
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(204); // No Content
    exit;
}

// Get POST data
$data = json_decode(file_get_contents("php://input"));

// Assuming $pdo is defined and passed from the config.php file
$hotelModel = new Hotel($pdo);

// Example of retrieving a single user
$response = $hotelModel->readOne($data->hotel_id);

// Output response as JSON
echo json_encode($response);
