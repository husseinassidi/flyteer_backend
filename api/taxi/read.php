<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/config.php';
include_once '../../models/taxi.php';

// Get the PDO object
$pdo = getDBConnection();

// Check if PDO connection was successful
if ($pdo === null) {
    http_response_code(500);
    echo json_encode(array("message" => "Database connection failed."));
    exit();
}

// Initialize Taxi model with the PDO object
$taxiModel = new Taxi($pdo);

// Retrieve all taxis
$response = $taxiModel->read();

// Output response as JSON
if ($response) {
    echo json_encode($response);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No taxis found."));
}
?>
