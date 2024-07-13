<?php
// Include configuration and model files
require_once '../../config/config.php';
require_once '../../models/airport.php';

// Get POST data
$data = json_decode(file_get_contents("php://input"));

// Assuming $pdo is defined and passed from the config.php file
$airportModel = new Airport($pdo);

// Example of retrieving a single airport
$response = $airportModel->readOne($data->airport_id);

// Output response as JSON
echo json_encode($response);
