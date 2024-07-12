<?php
require_once '../../config/config.php';
require_once '../../models/taxi_booking.php';

$pdo = getDBConnection();
$taxiBooking = new TaxiBooking($pdo);

$response = $taxiBooking->read();
echo json_encode($response);
?>
