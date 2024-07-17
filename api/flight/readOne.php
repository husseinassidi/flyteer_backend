<?php
// Include configuration and model files
require_once '../../config/config.php';
require_once '../../models/hotel.php';

// Get POST data
$data = json_decode(file_get_contents("php://input"));

// Assuming $pdo is defined and passed from the config.php file
$flightModel = new Flight($pdo);

// Example of retrieving a single flight
$response = $flightModel->readOne($data->flight_id);

// Output response as JSON
echo json_encode($response);
