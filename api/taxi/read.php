<?php
require_once '../../config/config.php';
require_once '../../models/Taxi.php';

$pdo = new PDO($dsn, $user, $pass, $options);
$taxi = new Taxi($pdo);

$response = $taxi->read();
echo json_encode($response);
?>
