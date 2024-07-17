<?php
class Admin {
    private $conn;
    private $table_name = "admins";

    public $admin_id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $phone;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create admin
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET
                      first_name = :first_name,
                      last_name = :last_name,
                      email = :email,
                      password = :password,
                      phone = :phone";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->phone = htmlspecialchars(strip_tags($this->phone));

        // Bind values
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", password_hash($this->password, PASSWORD_BCRYPT));
        $stmt->bindParam(":phone", $this->phone);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Read admins
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE admin_id = :admin_id LIMIT 1";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));

        // Bind value
        $stmt->bindParam(":admin_id", $this->admin_id);

        $stmt->execute();

        // Fetch the single record
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set object properties
        if ($row) {
            $this->first_name = $row['first_name'];
            $this->last_name = $row['last_name'];
            $this->email = $row['email'];
            $this->password = $row['password'];
            $this->phone = $row['phone'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
        }

        return $row;
    }

    // Update admin
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                  SET
                      first_name = :first_name,
                      last_name = :last_name,
                      email = :email,
                      password = :password,
                      phone = :phone
                  WHERE
                      admin_id = :admin_id";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));

        // Bind values
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", password_hash($this->password, PASSWORD_BCRYPT));
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":admin_id", $this->admin_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Delete admin
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE admin_id = :admin_id";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));

        // Bind id
        $stmt->bindParam(":admin_id", $this->admin_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
