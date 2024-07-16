<?php
class Taxi
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($taxi_company, $location, $price_per_km, $license, $driver_name, $color, $type)
    {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO taxis (taxi_company, location, price_per_km, license, driver_name, color, type) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$taxi_company, $location, $price_per_km, $license, $driver_name, $color, $type]);
            return ["message" => "Taxi created successfully"];
        } catch (PDOException $e) {
            return ["message" => "Error: " . $e->getMessage()];
        }
    }

    public function read()
    {
        try {
            $stmt = $this->pdo->query('SELECT * FROM taxis');
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ["message" => "Error: " . $e->getMessage()];
        }
    }

    public function readOne($id)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM taxis WHERE taxi_id = ?');
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);  // Only get associative array results for single record
        } catch (PDOException $e) {
            return ["message" => "Error: " . $e->getMessage()];
        }
    }

    public function update($id, $taxi_company, $location, $price_per_km, $license, $driver_name, $color, $type)
    {
        try {
            $stmt = $this->pdo->prepare('UPDATE taxis SET taxi_company = ?, location = ?, price_per_km = ?, license = ?, driver_name = ?, color = ?, type = ? WHERE taxi_id = ?');
            $stmt->execute([$taxi_company, $location, $price_per_km, $license, $driver_name, $color, $type, $id]);

            // Debugging: Get rowCount
            $rowCount = $stmt->rowCount();
            return [
                "message" => "Taxi details updated successfully",
                "rowCount" => $rowCount
            ];
        } catch (PDOException $e) {
            return ["message" => "Error: " . $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM taxis WHERE taxi_id = ?');
            $stmt->execute([$id]);
            return ["message" => "Taxi deleted successfully"];
        } catch (PDOException $e) {
            return ["message" => "Error: " . $e->getMessage()];
        }
    }
}
?>
