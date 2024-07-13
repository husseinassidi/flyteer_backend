<?php
// Include configuration file
require_once '../../config/config.php';

// Get the PDO object
$pdo = getDBConnection();

// Get POST data
$data = json_decode(file_get_contents("php://input"));

// Initialize airport model with the PDO object
require_once '../../models/airport.php';
$airportModel = new Airport($pdo);

// Example of creating an airport
$response = $airportModel->create($data->name, $data->location);

// Output response as JSON
echo json_encode($response);
