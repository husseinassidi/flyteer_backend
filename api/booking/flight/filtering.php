<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../../config/config.php';
require_once '../../../models/Flight.php';

// Use the function from the config file to get the connection
$pdo = getDBConnection();

if ($pdo === null) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

$flight = new Flight($pdo);

$data = json_decode(file_get_contents("php://input"), true);

// Initialize the base query
$query = "SELECT * FROM flights WHERE 1=1";
$params = [];

// Append filters to the query
if (!empty($data['airline'])) {
    $query .= " AND airline LIKE :airline";
    $params[':airline'] = '%' . $data['airline'] . '%';
}
if (!empty($data['departure_airport'])) {
    $query .= " AND departure_airport = :departure_airport";
    $params[':departure_airport'] = $data['departure_airport'];
}
if (!empty($data['arrival_airport'])) {
    $query .= " AND arrival_airport = :arrival_airport";
    $params[':arrival_airport'] = $data['arrival_airport'];
}
if (!empty($data['departure_time'])) {
    $query .= " AND departure_time >= :departure_time";
    $params[':departure_time'] = $data['departure_time'];
}
if (!empty($data['arrival_time'])) {
    $query .= " AND arrival_time <= :arrival_time";
    $params[':arrival_time'] = $data['arrival_time'];
}
if (!empty($data['price'])) {
    $query .= " AND price <= :price";
    $params[':price'] = $data['price'];
}

$stmt = $pdo->prepare($query);

// Execute the query with the parameters
if ($stmt->execute($params)) {
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($results)) {
        echo json_encode($results);
    } else {
        http_response_code(404);
        echo json_encode(["message" => "No flights found matching the criteria"]);
    }
} else {
    http_response_code(500);
    echo json_encode(["message" => "Failed to retrieve flights"]);
}
?>
