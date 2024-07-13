<?php
require_once '../../config/config.php';
require_once '../../models/taxi_company.php';

$pdo = getDBConnection();
$taxiCompany = new TaxiCompany($pdo);

$response = $taxiCompany->read();
echo json_encode($response);
?>
