<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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
