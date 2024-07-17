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

if (isset($data->flight_id)) {
    $response = $flight->delete($data->flight_id);
    echo json_encode($response);
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
}
?>
