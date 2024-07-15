<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/config.php';
include_once '../../models/Admin.php';

$pdo = getDBConnection();
$admin = new Admin($pdo);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->admin_id) &&
    !empty($data->first_name) &&
    !empty($data->last_name) &&
    !empty($data->email) &&
    !empty($data->password)
) {
    $admin->admin_id = $data->admin_id;
    $admin->first_name = $data->first_name;
    $admin->last_name = $data->last_name;
    $admin->email = $data->email;
    $admin->password = $data->password;
    $admin->phone = $data->phone;

    if ($admin->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Admin was updated."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update admin."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data."));
}
?>
