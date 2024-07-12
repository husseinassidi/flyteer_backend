<?php
require_once '../../config/config.php';
require_once '../../models/Booking.php';

// Instantiate Booking object
$booking = new Booking($db);

// Get booking data
$result = $booking->read();

$num = $result->rowCount();

if ($num > 0) {
    $bookings_arr = array();
    $bookings_arr["bookings"] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $booking_item = array(
            "id" => $id,
            "user_id" => $user_id,
            "booking_type" => $booking_type,
            "booking_details" => $booking_details,
            "booking_date" => $booking_date,
            "status" => $status
        );

        array_push($bookings_arr["bookings"], $booking_item);
    }

    echo json_encode($bookings_arr);
} else {
    echo json_encode(array("message" => "No bookings found."));
}
?>
