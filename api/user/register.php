<?php
// Include configuration file
require_once '../../config/config.php';

// Get the PDO object
$pdo = getDBConnection();

// Get POST data
$data = json_decode(file_get_contents("php://input"));

// Initialize User model with the PDO object
require_once '../../models/user.php';
$userModel = new User($pdo);

// Example of registering a user
$response = $userModel->create($data->first_name, $data->last_name, $data->email, $data->password, $data->phone);

// Output response as JSON
echo json_encode($response);
