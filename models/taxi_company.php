<?php
class TaxiCompany {
    private $conn;
    private $table_name = "taxi_company";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($name, $number, $email, $address) {
        $query = "INSERT INTO " . $this->table_name . " (taxi_company_name, taxi_company_number, taxi_company_email, taxi_company_address) VALUES (:name, :number, :email, :address)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", htmlspecialchars(strip_tags($name)));
        $stmt->bindParam(":number", htmlspecialchars(strip_tags($number)));
        $stmt->bindParam(":email", htmlspecialchars(strip_tags($email)));
        $stmt->bindParam(":address", htmlspecialchars(strip_tags($address)));

        if ($stmt->execute()) {
            return ["message" => "Taxi company created successfully."];
        } else {
            return ["error" => "Unable to create taxi company."];
        }
    }
}
?>
