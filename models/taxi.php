<?php
class Taxi
{

    // ($data-> taxi_company_name,$data->location ,$data->price_per_km ,$data->license ,$data->driver_name)
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($taxi_company_name, $location, $price_per_km, $license, $driver_name, $color, $type)
    {
        // Get taxi_company_id from taxi_company table
        $stmt = $this->pdo->prepare('SELECT taxi_company_id FROM taxi_company WHERE taxi_company_name = ?');
        $stmt->execute([$taxi_company_name]);
        $company = $stmt->fetch();

        if (!$company) {
            return ["error" => "Taxi company does not exist."];
        }

        $taxi_company_id = $company['taxi_company_id'];

        // Insert into taxis using taxi_company_id, including license and driver_name
        $stmt = $this->pdo->prepare('INSERT INTO taxis (taxi_company, location, price_per_km, license, driver_name,color,type) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$taxi_company_id, $location, $price_per_km, $license, $driver_name, $color, $type]);
        return ["success" => "Taxi created"];
    }


    public function read()
    {
        $stmt = $this->pdo->query('SELECT * FROM taxis');
        return $stmt->fetchAll();
    }

    public function update(
        $taxi_id,
        $taxi_company,
        $location,
        $price_per_km,
        $license,
        $driver_name,
        $color,
        $type
    ) {
        $stmt = $this->pdo->prepare('UPDATE taxis SET taxi_company = ?, location = ?, price_per_km = ?, license = ?, driver_name = ?, color = ?, type = ? WHERE taxi_id = ?');
        $stmt->execute([$taxi_company, $location, $price_per_km, $license, $driver_name, $color, $type, $taxi_id]);
        return ["success" => "Taxi updated"];
    }


    public function delete($taxi_id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM taxis WHERE taxi_id = ?');
        $stmt->execute([$taxi_id]);
        return ["success" => "Taxi deleted"];
    }
}