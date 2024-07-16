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

if (isset($data->flight_id) && isset($data->airline) && isset($data->flight_number) && isset($data->departure_airport) && isset($data->arrival_airport) && isset($data->departure_time) && isset($data->arrival_time) && isset($data->price)) {
    // Check if flight_id exists
    $checkStmt = $pdo->prepare('SELECT COUNT(*) FROM flights WHERE flight_id = ?');
    $checkStmt->execute([$data->flight_id]);
    if ($checkStmt->fetchColumn() == 0) {
        http_response_code(400);
        echo json_encode(["error" => "Flight ID does not exist"]);
        exit;
    }
    
    // Perform the update
    $response = $flight->update($data->flight_id, $data->airline, $data->flight_number, $data->departure_airport, $data->arrival_airport, $data->departure_time, $data->arrival_time, $data->price);
    
    if (isset($response['success'])) {
        http_response_code(200);
        echo json_encode(["message" => $response['success']]);
    } else {
        http_response_code(400);
        echo json_encode(["error" => $response['error']]);
    }
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
}
?>
