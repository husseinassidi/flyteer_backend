<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

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

$stmt = $flightBooking->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $flightBookings_arr = array();
    $flightBookings_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $flightBooking_item = array(
            "booking_id" => $booking_id, // Ensure this matches your database schema
            "user_id" => $user_id,
            "flight_id" => $flight_id,
            "booking_date" => $booking_date,
            "status" => $status
        );
        array_push($flightBookings_arr["records"], $flightBooking_item);
    }

    http_response_code(200);
    echo json_encode($flightBookings_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No flight bookings found."));
}
?>
