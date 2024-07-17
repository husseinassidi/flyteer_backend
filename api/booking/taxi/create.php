<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../../config/config.php';
include_once '../../../models/taxi_booking.php';

$pdo = getDBConnection();

// Check if connection was successful
if ($pdo === null) {
    http_response_code(500);
    echo json_encode(array("message" => "Database connection failed."));
    exit();
}

// Get the posted data
$data = json_decode(file_get_contents("php://input"));

// Validate foreign keys
// Check if user_id exists in the users table
$stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE id = ?');
$stmt->execute([$data->user_id]);
if ($stmt->fetchColumn() == 0) {
    echo json_encode(['message' => 'Invalid user_id.']);
    http_response_code(400);
    exit();
}

// Check if taxi_id exists in the taxis table
$stmt = $pdo->prepare('SELECT COUNT(*) FROM taxis WHERE taxi_id = ?');
$stmt->execute([$data->taxi_id]);
if ($stmt->fetchColumn() == 0) {
    echo json_encode(['message' => 'Invalid taxi_id.']);
    http_response_code(400);
    exit();
}

// Make sure data is not empty
if (!empty($data->user_id) && !empty($data->taxi_id) && !empty($data->pickup_location) && !empty($data->dropoff_location) && !empty($data->pickup_time) && !empty($data->status)) {
    // Initialize the taxi booking object
    $taxiBooking = new TaxiBooking($pdo);

    // Set taxi booking property values
    $taxiBooking->user_id = htmlspecialchars(strip_tags($data->user_id));
    $taxiBooking->taxi_id = htmlspecialchars(strip_tags($data->taxi_id));
    $taxiBooking->pickup_location = htmlspecialchars(strip_tags($data->pickup_location));
    $taxiBooking->dropoff_location = htmlspecialchars(strip_tags($data->dropoff_location));
    $taxiBooking->pickup_time = htmlspecialchars(strip_tags($data->pickup_time));
    $taxiBooking->status = htmlspecialchars(strip_tags($data->status));

    // Create the taxi booking
    if ($taxiBooking->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Taxi booking was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create taxi booking."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create taxi booking. Data is incomplete."));
}
?>
