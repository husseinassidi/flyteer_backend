<?php
// Include configuration and model files
require_once '../../config/config.php';
require_once '../../models/User.php';

// Get POST data
$data = json_decode(file_get_contents("php://input"));

// Initialize User model
$userModel = new User($pdo);

// Example of registering a user
$response = $userModel->create($data->first_name, $data->last_name, $data->email, $data->password, $data->phone);

// Output response as JSON
echo json_encode($response);
