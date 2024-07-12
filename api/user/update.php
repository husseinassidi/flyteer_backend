<?php
require_once '../../config/config.php';

require_once '../../models/user.php';

$data = json_decode(file_get_contents("php://input"));
$userModel = new User($pdo);

$response = $userModel->update($data->id, $data->first_name, $data->last_name, $data->email, $data->password, $data->phone);
echo json_encode($response);
