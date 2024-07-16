<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../../config/config.php';
include_once '../../../models/taxi_booking.php';

$pdo = getDBConnection();

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id) && !empty($data->user_id) && !empty($data->taxi_id) && !empty($data->pickup_location) && !empty($data->dropoff_location) && !empty($data->pickup_time) && !empty($data->status)) {
    $taxiBooking = new TaxiBooking($pdo);

    $taxiBooking->id = $data->id;
    $taxiBooking->user_id = htmlspecialchars(strip_tags($data->user_id));
    $taxiBooking->taxi_id = htmlspecialchars(strip_tags($data->taxi_id));
    $taxiBooking->pickup_location = htmlspecialchars(strip_tags($data->pickup_location));
    $taxiBooking->dropoff_location = htmlspecialchars(strip_tags($data->dropoff_location));
    $taxiBooking->pickup_time = htmlspecialchars(strip_tags($data->pickup_time));
    $taxiBooking->status = htmlspecialchars(strip_tags($data->status));

    if ($taxiBooking->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Taxi booking was updated."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update taxi booking."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to update taxi booking. Data is incomplete."));
}
?>
