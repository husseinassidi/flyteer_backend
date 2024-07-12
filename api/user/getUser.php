<?php
// Include configuration and model files
require_once '../../config/config.php';
require_once '../../models/user.php';

$data = json_decode(file_get_contents("php://input"));

$userModel = new User($pdo);

$response = $userModel->readOne($data->id);

echo json_encode($response);
