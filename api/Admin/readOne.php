<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/config.php';
include_once '../../models/Admin.php';

$pdo = getDBConnection();
$admin = new Admin($pdo);

$admin->admin_id = isset($_GET['admin_id']) ? $_GET['admin_id'] : null;

if ($admin->admin_id) {
    $stmt = $admin->readOne();

    if ($stmt) {
        http_response_code(200);
        echo json_encode($stmt);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "Admin not found."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid admin ID."));
}
?>


