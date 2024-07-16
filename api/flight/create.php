<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config/config.php';
require_once '../../models/Flight.php';

// Use the function from the config file to get the connection
$pdo = getDBConnection();

if ($pdo === null) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

$flight = new Flight($pdo);

$data = json_decode(file_get_contents("php://input"));

if (isset($data->airline) && isset($data->flight_number) && isset($data->departure_airport) && isset($data->arrival_airport) && isset($data->departure_time) && isset($data->arrival_time) && isset($data->price)) {
    $response = $flight->create($data->airline, $data->flight_number, $data->departure_airport, $data->arrival_airport, $data->departure_time, $data->arrival_time, $data->price);
    echo json_encode($response);
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
}
?>
