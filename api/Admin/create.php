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
    isset($data->first_name) &&
    isset($data->last_name) &&
    isset($data->email) &&
    isset($data->password) &&
    isset($data->phone)
) {
    $admin->first_name = $data->first_name;
    $admin->last_name = $data->last_name;
    $admin->email = $data->email;
    $admin->password = $data->password;
    $admin->phone = $data->phone;

    $result = $admin->create();

    switch ($result) {
        case "success":
            http_response_code(201);
            echo json_encode(array("message" => "Admin was created."));
            break;
        case "email_exists":
            http_response_code(400);
            echo json_encode(array("message" => "Email already exists."));
            break;
        case "phone_exists":
            http_response_code(400);
            echo json_encode(array("message" => "Phone number already exists."));
            break;
        case "invalid_email":
            http_response_code(400);
            echo json_encode(array("message" => "Provide a valid email."));
            break;
        case "invalid_phone":
            http_response_code(400);
            echo json_encode(array("message" => "Provide a valid phone number."));
            break;
        default:
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create admin."));
            break;
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data."));
}
