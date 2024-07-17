<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../../config/config.php';
require_once '../../models/taxi.php';

// Get the PDO object
$pdo = getDBConnection();
$taxiModel = new Taxi($pdo);

// Retrieve taxi data
$response = $taxiModel->read();

// Output response as JSON
echo json_encode($response);