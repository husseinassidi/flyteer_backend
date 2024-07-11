<?php
require_once '../../config/config.php';
require_once '../../models/Flight.php';

$pdo = new PDO($dsn, $user, $pass, $options);
$flight = new Flight($pdo);

$data = json_decode(file_get_contents("php://input"));

if(isset($data->airline) && isset($data->flight_number) && isset($data->departure_airport) && isset($data->arrival_airport) && isset($data->departure_time) && isset($data->arrival_time) && isset($data->price)) {
    $response = $flight->create($data->airline, $data->flight_number, $data->departure_airport, $data->arrival_airport, $data->departure_time, $data->arrival_time, $data->price);
    echo json_encode($response);
} else {
    echo json_encode(["error" => "Invalid input"]);
}
?>
