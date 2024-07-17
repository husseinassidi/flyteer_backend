<?php
class Flight {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($airline, $flight_number, $departure_airport, $arrival_airport, $departure_time, $arrival_time, $price) {
        $stmt = $this->pdo->prepare('INSERT INTO flights (airline, flight_number, departure_airport, arrival_airport, departure_time, arrival_time, price) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$airline, $flight_number, $departure_airport, $arrival_airport, $departure_time, $arrival_time, $price]);
        return ["success" => "Flight created"];
    }

    public function read() {
        $stmt = $this->pdo->query('SELECT * FROM flights');
        return $stmt->fetchAll();
    }

    public function readOne($flight_id)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM flights WHERE flight_id = ?');
            $stmt->execute([$flight_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Only get associative array results
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function update($flight_id, $airline, $flight_number, $departure_airport, $arrival_airport, $departure_time, $arrival_time, $price) {
        $stmt = $this->pdo->prepare('UPDATE flights SET airline = ?, flight_number = ?, departure_airport = ?, arrival_airport = ?, departure_time = ?, arrival_time = ?, price = ? WHERE flight_id = ?');
        $stmt->execute([$airline, $flight_number, $departure_airport, $arrival_airport, $departure_time, $arrival_time, $price, $flight_id]);
        return ["success" => "Flight updated"];
    }

    public function delete($flight_id) {
        $stmt = $this->pdo->prepare('DELETE FROM flights WHERE flight_id = ?');
        $stmt->execute([$flight_id]);
        return ["success" => "Flight deleted"];
    }
}
?>
