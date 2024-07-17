<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../../config/config.php';
require_once '../../models/taxi_company.php';

$conn = getDBConnection();

if ($conn) {
    $taxiCompany = new TaxiCompany($conn);

    // Get posted data
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->taxi_company_id)) {
        // Delete the taxi company
        $response = $taxiCompany->delete($data->taxi_company_id);

        if ($response) {
            http_response_code(200); // OK
            echo json_encode(["success" => true, "message" => "Taxi company deleted."]);
        } else {
            http_response_code(503); // Service Unavailable
            echo json_encode(["success" => false, "message" => "Unable to delete taxi company."]);
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "Invalid input"]);
    }
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Database connection failed"]);
}
