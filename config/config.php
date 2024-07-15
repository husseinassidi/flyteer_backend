<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'flyteer');
define('DB_USER', 'root');
define('DB_PASS', '');

function getDBConnection()
{
    $conn = null;
    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection error: " . $e->getMessage();
        return null;
    }
    return $conn;
}

$pdo = getDBConnection();  // Initialize $pdo here and make sure it's accessible globally
