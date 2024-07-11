<?php
require_once '../../config/config.php';
require_once '../../models/Flight.php';

$pdo = new PDO($dsn, $user, $pass, $options);
$flight = new Flight($pdo);

$response = $flight->read();
echo json_encode($response);
?>
