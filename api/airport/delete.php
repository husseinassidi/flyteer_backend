<?php
require_once '../../config/config.php';
require_once '../../models/airport.php';

$data = json_decode(file_get_contents("php://input"));

$airportModel = new Airport($pdo);

$response = $airportModel->delete($data->airport_id);

if (!$response) {
    echo json_encode(['message' => 'Failed to delete airport or airport not found']);
} else {
    echo json_encode($response);
}
