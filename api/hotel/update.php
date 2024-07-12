<?php
require_once '../../config/config.php';
require_once '../../models/hotel.php';

// Decode the JSON payload from the request body
$data = json_decode(file_get_contents("php://input"));

// Debugging: Print the decoded JSON payload
error_log(print_r($data, true));

$hotelModel = new Hotel($pdo);

// Call the update method with the provided data
$response = $hotelModel->update($data->hotel_id, $data->hotel_name, $data->hotel_location, $data->price_per_night, $data->available_rooms);

// Debugging: Print the response including rowCount
error_log(print_r($response, true));

// Return the response as JSON
echo json_encode($response);
