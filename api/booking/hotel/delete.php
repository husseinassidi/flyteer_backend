<?php
header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../../../config/config.php';
include_once '../../../models/HotelBooking.php';

$pdo = getDBConnection();
$data = json_decode(file_get_contents("php://input"), true);

// Check if the unique_id is present
if (!empty($data['unique_id'])) {
    $hotelBooking = new HotelBooking($pdo);
    $hotelBooking->unique_id = htmlspecialchars(strip_tags($data['unique_id']));

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
