<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'flight_management');
define('DB_USER', 'root');
define('DB_PASS', 'password');

function getDBConnection() {
    $conn = null;
    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection error: " . $e->getMessage();
    }
    return $conn;
}

function testDBConnection() {
    $conn = getDBConnection();
    if ($conn) {
        echo "Connection successful!";
    } else {
        echo "Connection failed!";
    }
}
?>
