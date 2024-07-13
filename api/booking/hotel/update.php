<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../../config/config.php';
include_once '../../../models/HotelBooking.php';

$pdo = getDBConnection();

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id) && !empty($data->user_id) && !empty($data->hotel_id) && !empty($data->check_in_date) && !empty($data->check_out_date) && !empty($data->status)) {
    $hotelBooking = new HotelBooking($pdo);

    $hotelBooking->id = $data->id;
    $hotelBooking->user_id = htmlspecialchars(strip_tags($data->user_id));
    $hotelBooking->hotel_id = htmlspecialchars(strip_tags($data->hotel_id));
    $hotelBooking->check_in_date = htmlspecialchars(strip_tags($data->check_in_date));
    $hotelBooking->check_out_date = htmlspecialchars(strip_tags($data->check_out_date));
    $hotelBooking->status = htmlspecialchars(strip_tags($data->status));

    if ($hotelBooking->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Hotel booking was updated."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update hotel booking."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to update hotel booking. Data is incomplete."));
}
?>
