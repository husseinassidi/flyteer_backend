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

$pdo = getDBConnection();
$taxi = new Taxi($pdo);

$data = json_decode(file_get_contents("php://input"));

if (isset($data->taxi_id) && isset($data->taxi_company) && isset($data->location) && isset($data->price_per_km) && isset($data->license) && isset($data->driver_name) && isset($data->color) && isset($data->type)) {
    $response = $taxi->update($data->taxi_id, $data->taxi_company, $data->location, $data->price_per_km, $data->license, $data->driver_name, $data->color, $data->type);
    echo json_encode($response);
} else {
    echo json_encode(["error" => "Invalid input"]);
}