<?php
require_once '../../config/config.php';
require_once '../../models/taxi.php';

$data = json_decode(file_get_contents("php://input"));

$pdo = getDBConnection();

$taxiModel = new Taxi($pdo);

$response = $taxiModel->delete($data->taxi_id);

if (!$response) {
    echo json_encode(['message' => 'Failed to delete taxi or taxi not found']);
} else {
    echo json_encode($response);
}
?>
