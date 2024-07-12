<?php
require_once '../../config/config.php';
require_once '../../models/User.php';

$data = json_decode(file_get_contents("php://input"));

$userModel = new User($pdo);

$response = $userModel->update($data->id, $data->first_name, $data->last_name, $data->email, $data->password, $data->phone);
if (!$response) {
    echo json_encode(['message' => 'Failed to update user or user not found']);
} else {
    echo json_encode($response);
}
