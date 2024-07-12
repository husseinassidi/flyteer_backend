<?php
require_once '../../config/config.php';
require_once '../../models/user.php';

$data = json_decode(file_get_contents("php://input"));

$userModel = new User($pdo);

$response = $userModel->read();

// Optionally, add error handling if delete fails or no data found
if (!$response) {
    echo json_encode(['message' => 'Failed to fetch users']);
} else {
    echo json_encode($response);
}
