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

$airportModel = new Airport($pdo);

$response = $airportModel->delete($data->airport_id);

if (!$response) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Failed to delete airport or airport not found']);
} else {
    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'Airport deleted successfully']);
}
