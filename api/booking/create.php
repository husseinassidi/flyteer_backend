<?php
require_once '../../config/config.php';
require_once '../../models/Booking.php';

// Get POST data
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->user_id) &&
    !empty($data->booking_type) &&
    !empty($data->booking_details)
) {
    $booking = new Booking($db);

    $booking->user_id = $data->user_id;
    $booking->booking_type = $data->booking_type;
    $booking->booking_details = $data->booking_details;

    if ($booking->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Booking was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create booking."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create booking. Data is incomplete."));
}
?>
