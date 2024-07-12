<?php
class TaxiCompany {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($name, $number, $email, $address) {
        $stmt = $this->pdo->prepare('INSERT INTO taxi_companies (taxi_company_name, taxi_company_number, taxi_company_email, taxi_company_address) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $number, $email, $address]);
        return ["message" => "Taxi company created successfully"];
    }

    public function read() {
        $stmt = $this->pdo->query('SELECT * FROM taxi_companies');
        return $stmt->fetchAll();
    }

    public function update($id, $name, $number, $email, $address) {
        $stmt = $this->pdo->prepare('UPDATE taxi_companies SET taxi_company_name = ?, taxi_company_number = ?, taxi_company_email = ?, taxi_company_address = ? WHERE taxi_company_id = ?');
        $stmt->execute([$name, $number, $email, $address, $id]);
        return ["message" => "Taxi company updated successfully"];
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM taxi_companies WHERE taxi_company_id = ?');
        $stmt->execute([$id]);
        return ["message" => "Taxi company deleted successfully"];
    }
}
?>
