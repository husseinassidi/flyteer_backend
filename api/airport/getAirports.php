<?php
require_once '../../config/config.php';
require_once '../../models/airport.php';

$data = json_decode(file_get_contents("php://input"));

$airportModel = new Airport($pdo);

$response = $airportModel->read();

// Optionally, add error handling if delete fails or no data found
if (!$response) {
    echo json_encode(['message' => 'Failed to fetch airports']);
} else {
    echo json_encode($response);
}
