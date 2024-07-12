<?php
require_once '../../config/config.php';
require_once '../../models/Booking.php';

// Get DELETE data
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $booking = new Booking($db);
    $booking->id = $data->id;

    if ($booking->delete()) {
        http_response_code(200);
        echo json_encode(array("message" => "Booking was deleted."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to delete booking."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to delete booking. Data is incomplete."));
}
?>
