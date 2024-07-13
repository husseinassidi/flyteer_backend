<?php
require_once '../../../config/config.php';
require_once '../../../models/taxi_booking.php';

$pdo = getDBConnection();
$taxiBooking = new TaxiBooking($pdo);

$data = json_decode(file_get_contents("php://input"));

if (isset($data->taxi_booking_id)) {
    $response = $taxiBooking->delete($data->taxi_booking_id);
    echo json_encode($response);
} else {
    echo json_encode(["error" => "Invalid input"]);
}
?>
