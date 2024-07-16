<?php
// Include configuration and model files
require_once '../../config/config.php';
require_once '../../models/taxi.php';

// Get the PDO object
$pdo = getDBConnection();

// Initialize Taxi model with the PDO object
$taxiModel = new Taxi($pdo);

// Retrieve all taxis
$response = $taxiModel->read();

// Output response as JSON
echo json_encode($response);
?>
