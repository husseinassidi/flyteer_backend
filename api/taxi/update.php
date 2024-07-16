<?php
require_once '../../config/config.php';
require_once '../../models/taxi.php';

// Decode the JSON payload from the request body
$data = json_decode(file_get_contents("php://input"));

// Debugging: Print the decoded JSON payload
error_log(print_r($data, true));

// Get the PDO object
$pdo = getDBConnection();

$taxiModel = new Taxi($pdo);

// Check if taxi_company exists in the taxi_company table
$stmt = $pdo->prepare('SELECT COUNT(*) FROM taxi_company WHERE taxi_company_id = ?');
$stmt->execute([$data->taxi_company]);
if ($stmt->fetchColumn() == 0) {
    echo json_encode(['message' => 'Invalid taxi_company_id.']);
    http_response_code(400);
    exit();
}

// Call the update method with the provided data
$response = $taxiModel->update($data->taxi_id, $data->taxi_company, $data->location, $data->price_per_km, $data->license, $data->driver_name, $data->color, $data->type);

// Debugging: Print the response including rowCount
error_log(print_r($response, true));

// Return the response as JSON
echo json_encode($response);
?>
