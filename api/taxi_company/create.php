<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../../config/config.php';
require_once '../../models/taxi_company.php';

$conn = getDBConnection();

if ($conn) {
    $taxiCompany = new TaxiCompany($conn);

    $data = json_decode(file_get_contents("php://input"));

    if (
        isset($data->taxi_company_name) &&
        isset($data->taxi_company_number) &&
        isset($data->taxi_company_email) &&
        isset($data->taxi_company_address)
    ) {
        $response = $taxiCompany->create(
            $data->taxi_company_name,
            $data->taxi_company_number,
            $data->taxi_company_email,
            $data->taxi_company_address
        );
        echo json_encode($response);
    } else {
        echo json_encode(["error" => "Invalid input"]);
    }
} else {
    echo json_encode(["error" => "Database connection failed"]);
}
?>
