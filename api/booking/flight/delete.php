<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../../config/config.php'; // Corrected path to config.php
require_once '../../../models/FlightBooking.php'; // Corrected path to FlightBooking.php

// Use the function from the config file to get the connection
$db = getDBConnection();

if ($db === null) {
    http_response_code(500);
    echo json_encode(array("message" => "Database connection failed."));
    exit;
}

$flightBooking = new FlightBooking($db);

$data = json_decode(file_get_contents("php://input"));

if (isset($data->booking_id)) { // Check if booking_id is set
    $flightBooking->booking_id = $data->booking_id; // Corrected property name to match the model and database

    if ($flightBooking->delete()) {
        http_response_code(200);
        echo json_encode(array("message" => "Flight booking was deleted."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to delete flight booking."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid input"));
}
?>
