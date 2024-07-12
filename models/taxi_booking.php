<?php
class TaxiBooking {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($user_id, $taxi_id, $pickup_location, $dropoff_location, $pickup_time) {
        $stmt = $this->pdo->prepare('INSERT INTO taxi_booking (user_id, taxi_id, pickup_location, dropoff_location, pickup_time) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$user_id, $taxi_id, $pickup_location, $dropoff_location, $pickup_time]);
        return ["success" => "Taxi booking created"];
    }

    public function read() {
        $stmt = $this->pdo->query('SELECT * FROM taxi_booking');
        return $stmt->fetchAll();
    }

    public function update($taxi_booking_id, $user_id, $taxi_id, $pickup_location, $dropoff_location, $pickup_time, $status) {
        $stmt = $this->pdo->prepare('UPDATE taxi_booking SET user_id = ?, taxi_id = ?, pickup_location = ?, dropoff_location = ?, pickup_time = ?, status = ? WHERE taxi_booking_id = ?');
        $stmt->execute([$user_id, $taxi_id, $pickup_location, $dropoff_location, $pickup_time, $status, $taxi_booking_id]);
        return ["success" => "Taxi booking updated"];
    }

    public function delete($taxi_booking_id) {
        $stmt = $this->pdo->prepare('DELETE FROM taxi_booking WHERE taxi_booking_id = ?');
        $stmt->execute([$taxi_booking_id]);
        return ["success" => "Taxi booking deleted"];
    }
}
?>
