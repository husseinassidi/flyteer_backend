<?php
require_once '../../config/config.php';
require_once '../../models/TaxiCompany.php';

$pdo = new PDO($dsn, $user, $pass, $options);
$taxiCompany = new TaxiCompany($pdo);

$response = $taxiCompany->read();
echo json_encode($response);
?>
