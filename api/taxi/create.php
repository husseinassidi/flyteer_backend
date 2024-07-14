<?php
require_once '../../config/config.php';
require_once '../../models/taxi.php';

$pdo = getDBConnection();
$taxi = new Taxi($pdo);

$data = json_decode(file_get_contents("php://input"));
// add license and driver



if (isset($data->taxi_company_name) && isset($data->location) && isset($data->price_per_km)&& isset($data->license) && isset($data->driver_name)) {
    // $response = $taxi->create($data->taxi_company_name, $data->location, $data->price_per_km);

    $response= $taxi->create($data-> taxi_company_name,$data->location ,$data->price_per_km ,$data->license ,$data->driver_name);


    echo json_encode($response);
} else {
    echo json_encode(["error" => "Invalid input"]);
}
?>
