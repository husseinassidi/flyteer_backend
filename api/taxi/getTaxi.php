<?php
// Include configuration and model files
require_once '../../config/config.php';
require_once '../../models/taxi.php';

// Get POST data
$data = json_decode(file_get_contents("php://input"));

// Assuming $pdo is defined and passed from the config.php file
$taxiModel = new Taxi($pdo);

// Example of retrieving a single user
$response = $taxiModel->readOne($data->taxi_id);

// Output response as JSON
echo json_encode($response);
