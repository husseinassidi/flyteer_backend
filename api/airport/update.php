<?php
require_once '../../config/config.php';

require_once '../../models/airport.php';

$data = json_decode(file_get_contents("php://input"));
$airportModel = new Airport($pdo);

$response = $airportModel->update($data->airport_id, $data->name, $data->location);
echo json_encode($response);
