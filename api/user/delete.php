<?php
require_once '../../config/config.php';
require_once '../../models/User.php';

$data = json_decode(file_get_contents("php://input"));

$userModel = new User($pdo);

$response = $userModel->delete($data->id);

if (!$response) {
    echo json_encode(['message' => 'Failed to delete user or user not found']);
} else {
    echo json_encode($response);
}
