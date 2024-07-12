<?php
require_once '../../config/config.php';
require_once '../../models/Taxi.php';

$pdo = new PDO($dsn, $user, $pass, $options);
$taxi = new Taxi($pdo);

$data = json_decode(file_get_contents("php://input"));

if(isset($data->taxi_id)) {
    $response = $taxi->delete($data->taxi_id);
    echo json_encode($response);
} else { echo json_encode(["error" => "Invalid input"]);
}
?>