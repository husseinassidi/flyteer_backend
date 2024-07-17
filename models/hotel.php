<?php
class Hotel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($hotel_name, $hotel_location, $price_per_night, $available_rooms)
    {
        $stmt = $this->pdo->prepare('INSERT INTO hotels (hotel_name, hotel_location, price_per_night, available_rooms) VALUES (?, ?, ?, ?)');
        $stmt->execute([$hotel_name, $hotel_location, $price_per_night, $available_rooms]);
        return ["message" => "hotel company created successfully"];
    }

    public function read()
    {
        $stmt = $this->pdo->query('SELECT * FROM hotels');
        return $stmt->fetchAll();
    }

    public function readOne($id)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM hotels WHERE hotel_id = ?');
            $stmt->execute([$id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Only get associative array results
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function update($id, $hotel_name, $hotel_location, $price_per_night, $available_rooms)
    {
        $stmt = $this->pdo->prepare('UPDATE hotels SET hotel_name = ?, hotel_location = ?, price_per_night = ?, available_rooms = ? WHERE hotel_id = ?');
        $stmt->execute([$hotel_name, $hotel_location, $price_per_night, $available_rooms, $id]);

        // Debugging: Get rowCount
        $rowCount = $stmt->rowCount();
        return [
            "message" => "hotel details updated successfully",
            "rowCount" => $rowCount
        ];
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM hotels WHERE hotel_id = ?');
        $stmt->execute([$id]);
        return ["message" => "hotel deleted successfully"];
    }
}
