<?php
class HotelBooking {
    private $conn;
    private $table_name = "hotel_booking";

    public $id;
    public $user_id;
    public $hotel_id;
    public $check_in_date;
    public $check_out_date;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create hotel booking
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET
                      user_id = :user_id,
                      hotel_id = :hotel_id,
                      check_in_date = :check_in_date,
                      check_out_date = :check_out_date,
                      status = :status";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->hotel_id = htmlspecialchars(strip_tags($this->hotel_id));
        $this->check_in_date = htmlspecialchars(strip_tags($this->check_in_date));
        $this->check_out_date = htmlspecialchars(strip_tags($this->check_out_date));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":hotel_id", $this->hotel_id);
        $stmt->bindParam(":check_in_date", $this->check_in_date);
        $stmt->bindParam(":check_out_date", $this->check_out_date);
        $stmt->bindParam(":status", $this->status);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Read hotel bookings
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Update hotel booking
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                  SET
                      user_id = :user_id,
                      hotel_id = :hotel_id,
                      check_in_date = :check_in_date,
                      check_out_date = :check_out_date,
                      status = :status
                  WHERE
                      hotel_booking_id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->hotel_id = htmlspecialchars(strip_tags($this->hotel_id));
        $this->check_in_date = htmlspecialchars(strip_tags($this->check_in_date));
        $this->check_out_date = htmlspecialchars(strip_tags($this->check_out_date));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":hotel_id", $this->hotel_id);
        $stmt->bindParam(":check_in_date", $this->check_in_date);
        $stmt->bindParam(":check_out_date", $this->check_out_date);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Delete hotel booking
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE hotel_booking_id = :id";

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
