<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'flyteer');
define('DB_USER', 'root');
define('DB_PASS', '');

/**
 * Function to establish a PDO database connection
 * @return PDO|null
 */
function getDBConnection() {
    $conn = null;
    try {
        // Create a new PDO instance
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        
        // Set error mode to exceptions to handle errors gracefully
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Output connection error message
        echo "Connection error: " . $e->getMessage();
        return null;
    }
    return $conn;
}

/**
 * Function to test the database connection
 */
function testDBConnection() {
    $conn = getDBConnection();
    if ($conn) {
        echo "Connection established";
    } else {
        echo "Connection failed";
    }
}

testDBConnection()
?>
