<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../../config/config.php';
require_once '../../../models/FlightBooking.php';

// Use the function from the config file to get the connection
$db = getDBConnection();

if ($db === null) {
    http_response_code(500);
    echo json_encode(array("message" => "Database connection failed."));
    exit;
}

$flightBooking = new FlightBooking($db);

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->booking_id)) {
    http_response_code(400);
    echo json_encode(array("message" => "Missing booking_id."));
    exit;
}

$flightBooking->booking_id = $data->booking_id;

$stmt = $flightBooking->readOne();

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);

    $flightBooking_item = array(
        "booking_id" => $booking_id,
        "user_id" => $user_id,
        "flight_id" => $flight_id,
        "booking_date" => $booking_date,
        "status" => $status
    );

    http_response_code(200);
    echo json_encode($flightBooking_item);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Flight booking not found."));
}
?>
