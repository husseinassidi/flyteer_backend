<?php
require_once '../../config/config.php';
require_once '../../models/taxi_booking.php';

$pdo = getDBConnection();
$taxiBooking = new TaxiBooking($pdo);

$data = json_decode(file_get_contents("php://input"));

if (isset($data->taxi_booking_id) && isset($data->user_id) && isset($data->taxi_id) && isset($data->pickup_location) && isset($data->dropoff_location) && isset($data->pickup_time) && isset($data->status)) {
    $response = $taxiBooking->update($data->taxi_booking_id, $data->user_id, $data->taxi_id, $data->pickup_location, $data->dropoff_location, $data->pickup_time, $data->status);
    echo json_encode($response);
} else {
    echo json_encode(["error" => "Invalid input"]);
}
?>
