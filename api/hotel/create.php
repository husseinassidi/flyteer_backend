<?php
// Include configuration file
require_once '../../config/config.php';

// Get the PDO object
$pdo = getDBConnection();

// Get POST data
$data = json_decode(file_get_contents("php://input"));

// Initialize User model with the PDO object
require_once '../../models/hotel.php';
$hotelModel = new Hotel($pdo);

// Example of registering a user
$response = $hotelModel->create($data->hotel_name, $data->hotel_location, $data->price_per_night, $data->available_rooms);

// Output response as JSON
echo json_encode($response);
