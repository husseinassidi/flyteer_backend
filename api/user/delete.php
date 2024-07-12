<?php
require_once '../../config/config.php';
require_once '../../models/User.php';

$data = json_decode(file_get_contents("php://input"));

$userModel = new User($pdo);

$response = null;

if (isset($data->id)) {
    $response = $userModel->delete($data->id);
} elseif (isset($data->email)) {
    $response = $userModel->delete(null, $data->email);
} else {
    $response = ['message' => 'ID or Email is required for deletion'];
}

echo json_encode($response);
