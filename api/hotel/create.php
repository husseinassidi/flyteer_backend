<?php
// Add CORS headers at the beginning of your script
header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle OPTIONS request for preflight
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200); // OK
    exit;
}

// Include configuration and model files
require_once '../../config/config.php';
require_once '../../models/hotel.php';

// Get the PDO object
$pdo = getDBConnection();

// Get POST data
$data = json_decode(file_get_contents("php://input"));

// Initialize Hotel model with the PDO object
$hotelModel = new Hotel($pdo);

// Example of creating a hotel entry
$response = $hotelModel->create($data->hotel_name, $data->hotel_location, $data->price_per_night, $data->available_rooms);

// Output response as JSON
echo json_encode($response);
?>
