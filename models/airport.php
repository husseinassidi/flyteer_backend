<?php
class Airport
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($name, $location)
    {
        $stmt = $this->pdo->prepare('INSERT INTO airports (name, location) VALUES (?, ?)');
        $stmt->execute([$name, $location]);
        return ["message" => "airport created successfully"];
    }
    public function read()
    {
        $stmt = $this->pdo->query('SELECT * FROM aiports');
        return $stmt->fetchAll();
    }
    public function readOne($airport_id)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM airports WHERE id = ?');
            $stmt->execute([$airport_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Only get associative array results
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }


    public function update($airport_id, $name, $location)
    {
        $stmt = $this->pdo->prepare('UPDATE airports SET name = ?, location = ? WHERE airport_id = ?');
        $stmt->execute([$name, $location]);

        return ["message" => "airport updated successfully"];
    }

    public function delete($airport_id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM airports WHERE id = ?');
        $stmt->execute([$airport_id]);
        return ["message" => "airport deleted successfully"];
    }
}
