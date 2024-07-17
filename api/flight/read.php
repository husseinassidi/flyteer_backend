<?php
header('Access-Control-Allow-Origin: *'); // Replace with your frontend's origin
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); // Allow the necessary HTTP methods
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Allow the necessary headers
require_once '../../config/config.php';
require_once '../../models/Flight.php';

// Use the function from the config file to get the connection
$pdo = getDBConnection();

if ($pdo === null) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

$flight = new Flight($pdo);

$response = $flight->read();
echo json_encode($response);
?>
