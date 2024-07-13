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

$stmt = $admin->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $admins_arr = array();
    $admins_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $admin_item = array(
            "admin_id" => $admin_id,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "email" => $email,
            "phone" => $phone,
            "created_at" => $created_at,
            "updated_at" => $updated_at
        );
        array_push($admins_arr["records"], $admin_item);
    }

    http_response_code(200);
    echo json_encode($admins_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No admins found."));
}
?>
