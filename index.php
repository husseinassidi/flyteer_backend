<?php
// index.php
header('Content-Type: application/json');

// Load configuration file
require_once 'config/config.php';

// Define base path
define('BASE_PATH', __DIR__);

// Autoload classes from the models directory
spl_autoload_register(function ($class_name) {
    include BASE_PATH . '/models/' . $class_name . '.php';
});

// Determine the request method and route accordingly
$method = $_SERVER['REQUEST_METHOD'];
$path = isset($_GET['path']) ? $_GET['path'] : '';

// Log the path for debugging
error_log('Requested path: ' . $path);

// Normalize path
$path = trim($path, '/');

// Route to appropriate API handler based on the URL path
$file_path = '';
switch (true) {
    case preg_match('/^api\/Admin\//', $path):
        $file_path = BASE_PATH . '/api/Admin/' . basename($path) . '.php';
        break;
    case preg_match('/^api\/airport\//', $path):
        $file_path = BASE_PATH . '/api/airport/' . basename($path) . '.php';
        break;
    case preg_match('/^api\/booking\/flight\//', $path):
        $file_path = BASE_PATH . '/api/booking/flight/' . basename($path) . '.php';
        break;
    case preg_match('/^api\/booking\/hotel\//', $path):
        $file_path = BASE_PATH . '/api/booking/hotel/' . basename($path) . '.php';
        break;
    case preg_match('/^api\/booking\/taxi\//', $path):
        $file_path = BASE_PATH . '/api/booking/taxi/' . basename($path) . '.php';
        break;
    case preg_match('/^api\/flight\//', $path):
        $file_path = BASE_PATH . '/api/flight/' . basename($path) . '.php';
        break;
    case preg_match('/^api\/hotel\//', $path):
        $file_path = BASE_PATH . '/api/hotel/' . basename($path) . '.php';
        break;
    case preg_match('/^api\/taxi\//', $path):
        $file_path = BASE_PATH . '/api/taxi/' . basename($path) . '.php';
        break;
    case preg_match('/^api\/taxi_company\//', $path):
        $file_path = BASE_PATH . '/api/taxi_company/' . basename($path) . '.php';
        break;
    case preg_match('/^api\/user\//', $path):
        $file_path = BASE_PATH . '/api/user/' . basename($path) . '.php';
        break;
    default:
        $file_path = '';
        break;
}

if (file_exists($file_path)) {
    require $file_path;
} else {
    header("HTTP/1.0 404 Not Found");
    echo json_encode(["message" => "Endpoint not found"]);
}
