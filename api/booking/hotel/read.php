<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../../config/config.php';
include_once '../../../models/HotelBooking.php';

$pdo = getDBConnection();

$hotelBooking = new HotelBooking($pdo);

$stmt = $hotelBooking->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $hotelBookings_arr = array();
    $hotelBookings_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $hotelBooking_item = array(
            "hotel_booking_id" => $hotel_booking_id,
            "user_id" => $user_id,
            "hotel_id" => $hotel_id,
            "check_in_date" => $check_in_date,
            "check_out_date" => $check_out_date,
            "status" => $status
        );

        array_push($hotelBookings_arr["records"], $hotelBooking_item);
    }

    // http_response_code(200);
    echo json_encode($hotelBookings_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No hotel bookings found."));
}
?>
