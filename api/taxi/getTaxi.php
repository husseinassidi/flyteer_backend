<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include configuration and model files
require_once '../../config/config.php';
require_once '../../models/taxi.php';

// Get POST data
$data = json_decode(file_get_contents("php://input"));

// Get the PDO object
$pdo = getDBConnection();

// Check if PDO connection was successful
if ($pdo === null) {
    http_response_code(500);
    echo json_encode(array("message" => "Database connection failed."));
    exit();
}

// Check if taxi_id is provided in the request
if (!isset($data->taxi_id)) {
    http_response_code(400);
    echo json_encode(array("message" => "No taxi_id provided."));
    exit();
}

// Initialize Taxi model with the PDO object
$taxiModel = new Taxi($pdo);

// Retrieve a single taxi
$response = $taxiModel->readOne($data->taxi_id);

// Check if a valid response is returned
if ($response) {
    echo json_encode($response);
} else {
    error_log("Taxi not found for taxi_id: " . $data->taxi_id);  // Log taxi_id for debugging
    http_response_code(404);
    echo json_encode(array("message" => "Taxi not found."));
}
?>
