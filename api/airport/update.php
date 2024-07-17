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

$response = $airportModel->update($data->airport_id, $data->name, $data->location);
echo json_encode($response);
