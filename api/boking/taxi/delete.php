<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/config.php';
include_once '../../models/TaxiBooking.php';

$database = new Database();
$db = $database->getConnection();

$taxiBooking = new TaxiBooking($db);

$data = json_decode(file_get_contents("php://input"));

$taxiBooking->id = $data->
