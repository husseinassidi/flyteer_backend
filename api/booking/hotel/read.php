<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../../config/config.php';
include_once '../../../models/HotelBooking.php';

// Create a new database connection
$pdo = getDBConnection();

// Check if connection was successful
if ($pdo === null) {
    http_response_code(500);
    echo json_encode(array("message" => "Database connection failed."));
    exit();
}

// Create a new HotelBooking object
$hotelBooking = new HotelBooking($pdo);

// Get the booking ID from query parameters
$booking_id = isset($_GET['id']) ? htmlspecialchars(strip_tags($_GET['id'])) : null;

if ($booking_id) {
    // Prepare and execute the statement
    $stmt = $hotelBooking->readOne($booking_id);
    $num = $stmt->rowCount();

    if ($num > 0) {
        // Initialize response array
        $hotelBooking_arr = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            // Create hotel booking item array
            $hotelBooking_item = array(
                "hotel_booking_id" => $hotel_booking_id,
                "user_id" => $user_id,
                "hotel_id" => $hotel_id,
                "check_in_date" => $check_in_date,
                "check_out_date" => $check_out_date,
                "status" => $status
            );

            // Add hotel booking item to response array
            $hotelBooking_arr = $hotelBooking_item;
        }

        http_response_code(200);
        echo json_encode($hotelBooking_arr);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "Hotel booking not found."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid booking ID."));
}
?>
