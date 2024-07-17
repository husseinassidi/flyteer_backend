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

        // Clean and bind parameters
        $name = htmlspecialchars(strip_tags($name));
        $number = htmlspecialchars(strip_tags($number));
        $email = htmlspecialchars(strip_tags($email));
        $address = htmlspecialchars(strip_tags($address));

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":number", $number);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":address", $address);

        if ($stmt->execute()) {
            return ["message" => "Taxi company created successfully."];
        } else {
            return ["error" => "Unable to create taxi company."];
        }
    }

    public function delete($taxi_company_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE taxi_company_id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind parameter
        $stmt->bindParam(":id", $taxi_company_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return ["message" => "Taxi company deleted successfully."];
        } else {
            return ["error" => "Unable to delete taxi company."];
        }
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function update($id, $name, $number, $email, $address) {
        $query = "UPDATE " . $this->table_name . " 
                  SET taxi_company_name = :name, 
                      taxi_company_number = :number, 
                      taxi_company_email = :email, 
                      taxi_company_address = :address 
                  WHERE taxi_company_id = :id";

        $stmt = $this->conn->prepare($query);

        // Clean and bind parameters
        $id = htmlspecialchars(strip_tags($id));
        $name = htmlspecialchars(strip_tags($name));
        $number = htmlspecialchars(strip_tags($number));
        $email = htmlspecialchars(strip_tags($email));
        $address = htmlspecialchars(strip_tags($address));

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":number", $number);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":address", $address);

        if ($stmt->execute()) {
            return ["message" => "Taxi company updated successfully."];
        } else {
            return ["error" => "Unable to update taxi company."];
        }
    }
}
?>
