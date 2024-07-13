<?php
require_once '../../config/config.php';

$pdo = getDBConnection();

$data = json_decode(file_get_contents("php://input"));

require_once '../../models/user.php';
$userModel = new User($pdo);

$response = $userModel->login($data->email, $data->password);

echo json_encode($response);
