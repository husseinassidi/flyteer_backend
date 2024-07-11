<?php
require_once '../../config/config.php';
require_once '../../models/Flight.php';

$pdo = new PDO($dsn, $user, $pass, $options);
$flight = new Flight($pdo);

$data = json_decode(file_get_contents("php://input"));

if(isset($data->flight_id)) {
    $response = $flight->delete($data->flight_id);
    echo json_encode($response);
} else {
    echo json_encode(["error" => "Invalid input"]);
}
?>
