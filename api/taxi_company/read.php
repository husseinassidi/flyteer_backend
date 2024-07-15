<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

require_once '../../config/config.php';
require_once '../../models/taxi_company.php';

$pdo = getDBConnection();
$taxiCompany = new TaxiCompany($pdo);

$response = $taxiCompany->read();
echo json_encode($response);
