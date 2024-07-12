<?php
require_once '../../config/config.php';
require_once '../../models/hotel.php';

$data = json_decode(file_get_contents("php://input"));

$hotelModel = new Hotel($pdo);

$response = $hotelModel->delete($data->hotel_id);

if (!$response) {
    echo json_encode(['message' => 'Failed to delete hotel or hotel not found']);
} else {
    echo json_encode($response);
}
