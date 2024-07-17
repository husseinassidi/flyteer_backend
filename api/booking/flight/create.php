<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(204); // No content for preflight response
    exit;
}

include_once '../../../config/config.php';
include_once '../../../models/FlightBooking.php';

$db = getDBConnection();

if ($db === null) {
    http_response_code(500);
    echo json_encode(array("message" => "Database connection failed."));
    exit;
}

$flightBooking = new FlightBooking($db);

$input = file_get_contents("php://input");
$data = json_decode($input);

if (is_null($data)) {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid JSON", "input" => $input));
    exit;
}

if (isset($data->user_id) && isset($data->flight_id)) {
    $flightBooking->user_id = $data->user_id;
    $flightBooking->flight_id = $data->flight_id;

    $response = $flightBooking->create();

    if (isset($response['success'])) {
        http_response_code(201);
        echo json_encode(array("message" => $response['success']));
    } else {
        http_response_code(400);
        echo json_encode(array("message" => $response['error']));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid input structure", "data" => $data));
}
?>
