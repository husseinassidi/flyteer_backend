<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
require_once '../../config/config.php';
require_once '../../models/airport.php';

$data = json_decode(file_get_contents("php://input"));

// Assuming $pdo is defined and passed from the config.php file
$airportModel = new Airport($pdo);

// Example of retrieving a single airport
$response = $airportModel->readOne($data->airport_id);

// Output response as JSON
echo json_encode($response);
