<?php
header("Access-Control-Allow-Origin: http://127.0.0.1:5500");  // Adjust the origin as needed
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database and object files
include_once '../../config/database.php';
include_once '../../models/hotelBooking.php';

// Instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// Initialize object
$hotelBooking = new HotelBooking($db);

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Set property values
$hotelBooking->user_id = $data->user_id;
$hotelBooking->hotel_id = $data->hotel_id;
$hotelBooking->check_in_date = $data->check_in_date;
$hotelBooking->check_out_date = $data->check_out_date;
$hotelBooking->status = $data->status;

// Create the hotel booking
if($unique_id = $hotelBooking->create()){
    echo json_encode(array("message" => "Hotel booking was created.", "unique_id" => $unique_id));
} else{
    echo json_encode(array("message" => "Unable to create hotel booking."));
}
?>
