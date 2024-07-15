<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
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

    // Initialize debug information
    $debug_info = [
        'received_data' => $data,
        'name' => isset($data->taxi_company_name) ? $data->taxi_company_name : 'NOT SET',
        'number' => isset($data->taxi_company_number) ? $data->taxi_company_number : 'NOT SET',
        'email' => isset($data->taxi_company_email) ? $data->taxi_company_email : 'NOT SET',
        'address' => isset($data->taxi_company_address) ? $data->taxi_company_address : 'NOT SET',
    ];

    // Ensure all required fields are present
    if (
        isset($data->taxi_company_name) &&
        isset($data->taxi_company_number) &&
        isset($data->taxi_company_email) &&
        isset($data->taxi_company_address)
    ) {
        // Sanitize and validate input
        $name = htmlspecialchars(strip_tags($data->taxi_company_name));
        $number = htmlspecialchars(strip_tags($data->taxi_company_number));
        $email = htmlspecialchars(strip_tags($data->taxi_company_email));
        $address = htmlspecialchars(strip_tags($data->taxi_company_address));

        // Create new taxi company
        $response = $taxiCompany->create($name, $number, $email, $address);

        if ($response) {
            http_response_code(201); // Created
            echo json_encode([
                "success" => true,
                "message" => "Taxi company was created.",
                "debug" => $debug_info
            ]);
        } else {
            http_response_code(503); // Service Unavailable
            echo json_encode([
                "success" => false,
                "message" => "Unable to create taxi company.",
                "debug" => $debug_info
            ]);
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode([
            "error" => "Invalid input",
            "debug" => $debug_info
        ]);
    }
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode([
        "error" => "Database connection failed"
    ]);
}
