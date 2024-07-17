<?php
class TaxiBooking {
    private $conn;
    private $table_name = "taxi_booking";

    public $id;
    public $user_id;
    public $taxi_id;
    public $pickup_location;
    public $dropoff_location;
    public $pickup_time;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create taxi booking
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET
                      user_id = :user_id,
                      taxi_id = :taxi_id,
                      pickup_location = :pickup_location,
                      dropoff_location = :dropoff_location,
                      pickup_time = :pickup_time,
                      status = :status";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->taxi_id = htmlspecialchars(strip_tags($this->taxi_id));
        $this->pickup_location = htmlspecialchars(strip_tags($this->pickup_location));
        $this->dropoff_location = htmlspecialchars(strip_tags($this->dropoff_location));
        $this->pickup_time = htmlspecialchars(strip_tags($this->pickup_time));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":taxi_id", $this->taxi_id);
        $stmt->bindParam(":pickup_location", $this->pickup_location);
        $stmt->bindParam(":dropoff_location", $this->dropoff_location);
        $stmt->bindParam(":pickup_time", $this->pickup_time);
        $stmt->bindParam(":status", $this->status);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Read taxi bookings
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Update taxi booking
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                  SET
                      user_id = :user_id,
                      taxi_id = :taxi_id,
                      pickup_location = :pickup_location,
                      dropoff_location = :dropoff_location,
                      pickup_time = :pickup_time,
                      status = :status
                  WHERE
                      taxi_booking_id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->taxi_id = htmlspecialchars(strip_tags($this->taxi_id));
        $this->pickup_location = htmlspecialchars(strip_tags($this->pickup_location));
        $this->dropoff_location = htmlspecialchars(strip_tags($this->dropoff_location));
        $this->pickup_time = htmlspecialchars(strip_tags($this->pickup_time));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":taxi_id", $this->taxi_id);
        $stmt->bindParam(":pickup_location", $this->pickup_location);
        $stmt->bindParam(":dropoff_location", $this->dropoff_location);
        $stmt->bindParam(":pickup_time", $this->pickup_time);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE taxi_booking_id = :id LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        // Bind id
        $stmt->bindParam(":id", $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->user_id = $row['user_id'];
            $this->taxi_id = $row['taxi_id'];
            $this->pickup_location = $row['pickup_location'];
            $this->dropoff_location = $row['dropoff_location'];
            $this->pickup_time = $row['pickup_time'];
            $this->status = $row['status'];
            return $row;
        }

        return false;
    }

    // Delete taxi booking
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE taxi_booking_id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind id
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}


?>
