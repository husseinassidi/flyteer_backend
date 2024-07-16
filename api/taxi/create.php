<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include configuration file
require_once '../../config/config.php';

// Get the PDO object
$pdo = getDBConnection();

// Get POST data
$data = json_decode(file_get_contents("php://input"));

// Initialize Taxi model with the PDO object
require_once '../../models/taxi.php';
$taxiModel = new Taxi($pdo);

// Ensure taxi_company_id exists in taxi_company table
$stmt = $pdo->prepare('SELECT COUNT(*) FROM taxi_company WHERE taxi_company_id = ?');
$stmt->execute([$data->taxi_company]);
if ($stmt->fetchColumn() == 0) {
    echo json_encode(['message' => 'Invalid taxi_company_id.']);
    http_response_code(400);
    exit();
}

// Example of registering a taxi
$response = $taxiModel->create(
    $data->taxi_company, 
    $data->location, 
    $data->price_per_km, 
    $data->license, 
    $data->driver_name, 
    $data->color, 
    $data->type
);

// Output response as JSON
echo json_encode($response);
?>
