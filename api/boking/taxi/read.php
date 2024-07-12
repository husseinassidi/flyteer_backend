<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/config.php';
include_once '../../models/TaxiBooking.php';

$database = new Database();
$db = $database->getConnection();

$taxiBooking = new TaxiBooking($db);

$stmt = $taxiBooking->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $taxiBookings_arr = array();
    $taxiBookings_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $taxiBooking_item = array(
            "id" => $id,
            "user_id" => $user_id,
            "taxi_company_id" => $taxi_company_id,
            "pickup_location" => $pickup_location,
            "dropoff_location" => $dropoff_location,
            "pickup_time" => $pickup_time,
            "status" => $status
        );
        array_push($taxiBookings_arr["records"], $taxiBooking_item);
    }

    http_response_code(200);
    echo json_encode($taxiBookings_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No taxi bookings found."));
}
?>
