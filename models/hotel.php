<?php
class Hotel
{
    private $pdo;
// iam passing the data base connection by the hotel class constructor
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
//  creating a function called create to create a new record in the pdo nad passing the attributes from apis
    public function create($hotel_name, $hotel_location, $price_per_night, $available_rooms)
    {
        $stmt = $this->pdo->prepare('INSERT INTO hotels (hotel_name, hotel_location, price_per_night, available_rooms) VALUES (?, ?, ?, ?)');
        $stmt->execute([$hotel_name, $hotel_location, $price_per_night, $available_rooms]);
        return ["message" => "hotel company created successfully"];
    }
//  creating read function where i dont pass any parameters because iam just reading all my records
    public function read()
    {
        $stmt = $this->pdo->query('SELECT * FROM hotels');

        // fetch is formating my $stmt to asociative array
        return $stmt->fetchAll();


        
    }

// creating the function that read a scpecifc id
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


    //  update 
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
