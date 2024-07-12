<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/config.php'; // Include the correct config file
include_once '../../models/FlightBooking.php';

// Use the function from the config file to get the connection
$db = getDBConnection();

if ($db === null) {
    http_response_code(500);
    echo json_encode(array("message" => "Database connection failed."));
    exit;
}

$flightBooking = new FlightBooking($db);

$data = json_decode(file_get_contents("php://input"));

$flightBooking->user_id = $data->user_id;
$flightBooking->flight_id = $data->flight_id;

if ($flightBooking->create()) {
    http_response_code(201);
    echo json_encode(array("message" => "Flight booking was created."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to create flight booking."));
}
?>
