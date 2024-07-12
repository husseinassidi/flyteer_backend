<?php
require_once '../../config/config.php';
require_once '../../models/taxi_company.php';

$pdo = getDBConnection();
$taxiCompany = new TaxiCompany($pdo);

$data = json_decode(file_get_contents("php://input"));

if (isset($data->taxi_company_id)) {
    $response = $taxiCompany->delete($data->taxi_company_id);
    echo json_encode($response);
} else {
    echo json_encode(["error" => "Invalid input"]);
}
?>
