<?php
class FlightBooking {
    private $conn;
    private $table_name = "flight_booking";  // Corrected table name

    public $booking_id;  // Corrected property name
    public $user_id;
    public $flight_id;
    public $booking_date;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, flight_id=:flight_id, booking_date=NOW(), status='confirmed'";

        $stmt = $this->conn->prepare($query);

        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
        $this->flight_id=htmlspecialchars(strip_tags($this->flight_id));

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":flight_id", $this->flight_id);

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
        $query = "UPDATE " . $this->table_name . " SET flight_id=:flight_id, status=:status WHERE booking_id=:booking_id";  // Corrected query

        $stmt = $this->conn->prepare($query);

        $this->booking_id=htmlspecialchars(strip_tags($this->booking_id));  // Corrected property name
        $this->flight_id=htmlspecialchars(strip_tags($this->flight_id));
        $this->status=htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(":booking_id", $this->booking_id);  // Corrected binding parameter
        $stmt->bindParam(":flight_id", $this->flight_id);
        $stmt->bindParam(":status", $this->status);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE booking_id = ?";  // Corrected query

        $stmt = $this->conn->prepare($query);

        $this->booking_id=htmlspecialchars(strip_tags($this->booking_id));  // Corrected property name

        $stmt->bindParam(1, $this->booking_id);  // Corrected binding parameter

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
