<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../../config/config.php'; // Adjusted path to config.php
include_once '../../../models/FlightBooking.php'; // Adjusted path to FlightBooking.php

// Use the function from the config file to get the connection
$db = getDBConnection();

if ($db === null) {
    http_response_code(500);
    echo json_encode(array("message" => "Database connection failed."));
    exit;
}

$flightBooking = new FlightBooking($db);

$data = json_decode(file_get_contents("php://input"));

if (isset($data->booking_id) && isset($data->flight_id) && isset($data->status)) {
    $flightBooking->booking_id = $data->booking_id;

    // Check if the booking exists
    $query = "SELECT COUNT(*) FROM " . $flightBooking->getTableName() . " WHERE booking_id = :booking_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':booking_id', $flightBooking->booking_id);
    $stmt->execute();

    if ($stmt->fetchColumn() == 0) {
        http_response_code(404);
        echo json_encode(array("message" => "Booking does not exist."));
        exit;
    }

    // Proceed with the update if the booking exists
    $flightBooking->flight_id = $data->flight_id;
    $flightBooking->status = $data->status;

    if ($flightBooking->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Flight booking was updated."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update flight booking."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid input structure"));
}
?>
