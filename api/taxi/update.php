<?php
require_once '../../config/config.php';
require_once '../../models/taxi.php';

$pdo = getDBConnection();
$taxi = new Taxi($pdo);

$data = json_decode(file_get_contents("php://input"));

if (isset($data->taxi_id) && isset($data->taxi_company_name) && isset($data->location) && isset($data->price_per_km) && isset($data->color) && isset($data->type)) {
    $response = $taxi->update($data->taxi_id, $data->taxi_company_name, $data->location, $data->price_per_km);
    echo json_encode($response);
} else {
    echo json_encode(["error" => "Invalid input"]);
}
?>
