<?php
header("Content-Type: application/json");

$request_method = $_SERVER["REQUEST_METHOD"];
$path_info = explode('/', trim($_SERVER['PATH_INFO'], '/'));

$resource = $path_info[0];
$action = isset($path_info[1]) ? $path_info[1] : null;

switch ($resource) {
    case 'user':
        require_once 'api/user/' . $action . '.php';
        break;
    case 'flight':
        require_once 'api/flight/' . $action . '.php';
        break;
    case 'hotel':
        require_once 'api/hotel/' . $action . '.php';
        break;
    case 'taxi':
        require_once 'api/taxi/' . $action . '.php';
        break;
    case 'taxi_company':
        require_once 'api/taxi_company/' . $action . '.php';
        break;
    case 'booking':
        require_once 'api/booking/' . $action . '.php';
        break;
    default:
        echo json_encode(["error" => "Resource not found"]);
        break;
}
?>
