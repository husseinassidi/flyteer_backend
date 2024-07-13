<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/config.php';
include_once '../../models/Admin.php';

$pdo = getDBConnection();
$admin = new Admin($pdo);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->admin_id)) {
    $admin->admin_id = $data->admin_id;

    if ($admin->delete()) {
        http_response_code(200);
        echo json_encode(array("message" => "Admin was deleted."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to delete admin."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data."));
}
?>
