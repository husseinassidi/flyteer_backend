<?php
class Booking {
    private $conn;
    private $table_name = "bookings";

    public $id;
    public $user_id;
    public $booking_type;
    public $booking_details; // JSON encoded details specific to flight, hotel, or taxi booking
    public $booking_date;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, booking_type=:booking_type, booking_details=:booking_details, booking_date=NOW(), status='confirmed'";

        $stmt = $this->conn->prepare($query);

        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
        $this->booking_type=htmlspecialchars(strip_tags($this->booking_type));
        $this->booking_details=htmlspecialchars(strip_tags($this->booking_details));

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":booking_type", $this->booking_type);
        $stmt->bindParam(":booking_details", $this->booking_details);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Other CRUD methods for read, update, delete
}
?>
