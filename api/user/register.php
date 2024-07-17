<?php
require_once '../../config/config.php';

$pdo = getDBConnection();

$data = json_decode(file_get_contents("php://input"));

require_once '../../models/user.php';
$userModel = new User($pdo);

$response = $userModel->create($data->first_name, $data->last_name, $data->email, $data->password, $data->phone);

echo json_encode($response);
