<?php
class TaxiBooking {
    private $conn;
    private $table_name = "taxi_bookings";

    public $id;
    public $user_id;
    public $taxi_company_id;
    public $pickup_location;
    public $dropoff_location;
    public $pickup_time;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, taxi_company_id=:taxi_company_id, pickup_location=:pickup_location, dropoff_location=:dropoff_location, pickup_time=:pickup_time, status='confirmed'";

        $stmt = $this->conn->prepare($query);

        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
        $this->taxi_company_id=htmlspecialchars(strip_tags($this->taxi_company_id));
        $this->pickup_location=htmlspecialchars(strip_tags($this->pickup_location));
        $this->dropoff_location=htmlspecialchars(strip_tags($this->dropoff_location));
        $this->pickup_time=htmlspecialchars(strip_tags($this->pickup_time));

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":taxi_company_id", $this->taxi_company_id);
        $stmt->bindParam(":pickup_location", $this->pickup_location);
        $stmt->bindParam(":dropoff_location", $this->dropoff_location);
        $stmt->bindParam(":pickup_time", $this->pickup_time);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function read() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function update() {
        $query = "UPDATE " . $this->table_name . " SET taxi_company_id=:taxi_company_id, pickup_location=:pickup_location, dropoff_location=:dropoff_location, pickup_time=:pickup_time, status=:status WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->taxi_company_id=htmlspecialchars(strip_tags($this->taxi_company_id));
        $this->pickup_location=htmlspecialchars(strip_tags($this->pickup_location));
        $this->dropoff_location=htmlspecialchars(strip_tags($this->dropoff_location));
        $this->pickup_time=htmlspecialchars(strip_tags($this->pickup_time));
        $this->status=htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":taxi_company_id", $this->taxi_company_id);
        $stmt->bindParam(":pickup_location", $this->pickup_location);
        $stmt->bindParam(":dropoff_location", $this->dropoff_location);
        $stmt->bindParam(":pickup_time", $this->pickup_time);
        $stmt->bindParam(":status", $this->status);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
