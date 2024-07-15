<?php
class FlightBooking {
    private $conn;
    private $table_name = "flight_booking";

    public $booking_id;
    public $user_id;
    public $flight_id;
    public $booking_date;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getTableName() {
        return $this->table_name;
    }

    // Create a new booking
    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET user_id = :user_id, flight_id = :flight_id, booking_date = NOW(), status = 'confirmed'";

        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->flight_id = htmlspecialchars(strip_tags($this->flight_id));

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":flight_id", $this->flight_id);

        if ($stmt->execute()) {
            return ["success" => "Flight booking created"];
        }

        return ["error" => "Unable to create flight booking"];
    }

    // Read all bookings
    function read() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Read one booking
    function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE booking_id = :booking_id LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":booking_id", $this->booking_id);

        $stmt->execute();

        return $stmt;
    }

    // Update an existing booking
    function update() {
        $query = "UPDATE " . $this->table_name . " SET flight_id = :flight_id, status = :status WHERE booking_id = :booking_id";

        $stmt = $this->conn->prepare($query);

        $this->booking_id = htmlspecialchars(strip_tags($this->booking_id));
        $this->flight_id = htmlspecialchars(strip_tags($this->flight_id));
        $this->status = htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(':booking_id', $this->booking_id);
        $stmt->bindParam(':flight_id', $this->flight_id);
        $stmt->bindParam(':status', $this->status);

        if ($stmt->execute()) {
            return ["success" => "Flight booking updated"];
        }

        return ["error" => "Unable to update flight booking"];
    }

    // Delete an existing booking
    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE booking_id = :booking_id";

        $stmt = $this->conn->prepare($query);

        $this->booking_id = htmlspecialchars(strip_tags($this->booking_id));

        $stmt->bindParam(':booking_id', $this->booking_id);

        if ($stmt->execute()) {
            return ["success" => "Flight booking deleted"];
        }

        return ["error" => "Unable to delete flight booking"];
    }
}
?>
