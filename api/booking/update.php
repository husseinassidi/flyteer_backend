<?php
require_once '../../config/config.php';
require_once '../../models/Booking.php';

// Get PUT data
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->id) &&
    (!empty($data->user_id) || !empty($data->booking_type) || !empty($data->booking_details) || !empty($data->status))
) {
    $booking = new Booking($db);

    $booking->id = $data->id;

    if (!empty($data->user_id)) {
        $booking->user_id = $data->user_id;
    }
    if (!empty($data->booking_type)) {
        $booking->booking_type = $data->booking_type;
    }
    if (!empty($data->booking_details)) {
        $booking->booking_details = $data->booking_details;
    }
    if (!empty($data->status)) {
        $booking->status = $data->status;
    }

    if ($booking->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Booking was updated."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update booking."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to update booking. Data is incomplete."));
}
?>
