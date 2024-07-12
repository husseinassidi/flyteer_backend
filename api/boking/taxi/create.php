<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/config.php';
include_once '../../models/TaxiBooking.php';

$database = new Database();
$db = $database->getConnection();

$taxiBooking = new TaxiBooking($db);

$data = json_decode(file_get_contents("php://input"));

$taxiBooking->user_id = $data->user_id;
$taxiBooking->taxi_company_id = $data->taxi_company_id;
$taxiBooking->pickup_location = $data->pickup_location;
$taxiBooking->dropoff_location = $data->dropoff_location;
$taxiBooking->pickup_time = $data->pickup_time;

if ($taxiBooking->create()) {
    http_response_code(201);
    echo json_encode(array("message" => "Taxi booking was created."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to create taxi booking."));
}
?>
