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

if (!empty($data->id)) {
    $taxiBooking = new TaxiBooking($pdo);

    $taxiBooking->id = htmlspecialchars(strip_tags($data->id));

    if ($taxiBooking->delete()) {
        http_response_code(200);
        echo json_encode(array("message" => "Taxi booking was deleted."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to delete taxi booking."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to delete taxi booking. Data is incomplete."));
}
?>
