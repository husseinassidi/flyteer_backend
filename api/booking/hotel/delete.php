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

if (!empty($data->id)) {
    $hotelBooking = new HotelBooking($pdo);

    $hotelBooking->id = htmlspecialchars(strip_tags($data->id));

    if ($hotelBooking->delete()) {
        http_response_code(200);
        echo json_encode(array("message" => "Hotel booking was deleted."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to delete hotel booking."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to delete hotel booking. Data is incomplete."));
}
?>
