<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
require_once '../../config/config.php';

$pdo = getDBConnection();

$data = json_decode(file_get_contents("php://input"));

require_once '../../models/user.php';
$userModel = new User($pdo);

$response = $userModel->create($data->first_name, $data->last_name, $data->email, $data->password, $data->phone);

echo json_encode($response);
