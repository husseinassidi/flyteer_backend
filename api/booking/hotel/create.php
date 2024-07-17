<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../../config/config.php';
include_once '../../../models/hotelBooking.php';

$pdo = getDBConnection();

// Check if connection was successful
if ($pdo === null) {
    http_response_code(500);
    echo json_encode(array("message" => "Database connection failed."));
    exit();
}

// Get the posted data
$data = json_decode(file_get_contents("php://input"));

// Make sure data is not empty
if (!empty($data->user_id) && !empty($data->hotel_id) && !empty($data->check_in_date) && !empty($data->check_out_date) && !empty($data->status) && isset($data->unique_id)) {
    // Initialize the hotel booking object
    $hotelBooking = new HotelBooking($pdo);

    // Set hotel booking property values
    $hotelBooking->user_id = htmlspecialchars(strip_tags($data->user_id));
    $hotelBooking->hotel_id = htmlspecialchars(strip_tags($data->hotel_id));
    $hotelBooking->check_in_date = htmlspecialchars(strip_tags($data->check_in_date));
    $hotelBooking->check_out_date = htmlspecialchars(strip_tags($data->check_out_date));
    $hotelBooking->status = htmlspecialchars(strip_tags($data->status));
    $hotelBooking->unique_id = htmlspecialchars(strip_tags($data->unique_id)); // Set unique_id

    // Create the hotel booking
    if ($hotelBooking->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Hotel booking was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create hotel booking."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create hotel booking. Data is incomplete."));
}
?>
