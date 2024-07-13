<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/config.php';
include_once '../../models/Admin.php';

$pdo = getDBConnection();
$admin = new Admin($pdo);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->first_name) &&
    !empty($data->last_name) &&
    !empty($data->email) &&
    !empty($data->password)
) {
    $admin->first_name = $data->first_name;
    $admin->last_name = $data->last_name;
    $admin->email = $data->email;
    $admin->password = $data->password;
    $admin->phone = $data->phone;

    if ($admin->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Admin was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create admin."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data."));
}
?>
