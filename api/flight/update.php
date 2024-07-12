<?php
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

if (isset($data->flight_id) && isset($data->airline) && isset($data->flight_number) && isset($data->departure_airport) && isset($data->arrival_airport) && isset($data->departure_time) && isset($data->arrival_time) && isset($data->price)) {
    $response = $flight->update($data->flight_id, $data->airline, $data->flight_number, $data->departure_airport, $data->arrival_airport, $data->departure_time, $data->arrival_time, $data->price);
    echo json_encode($response);
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
}
?>
