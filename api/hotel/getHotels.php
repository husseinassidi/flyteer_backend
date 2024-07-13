<?php
// Include configuration and model files
require_once '../../config/config.php';
require_once '../../models/hotel.php';

// Get POST data
$data = json_decode(file_get_contents("php://input"));

// Assuming $pdo is defined and passed from the config.php file
$hotelModel = new Hotel($pdo);

// Example of retrieving a single user
$response = $hotelModel->read();

// Output response as JSON
echo json_encode($response);
