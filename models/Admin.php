<?php
class Admin
{
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

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        if ($this->emailExists($this->email)) {
            return "email_exists";
        }
        if ($this->phoneExists($this->phone)) {
            return "phone_exists";
        }

        if (!$this->validateEmail($this->email)) {
            return "invalid_email";
        }
        if (!$this->validatePhone($this->phone)) {
            return "invalid_phone";
        }

        $query = "INSERT INTO " . $this->table_name . "
                  SET
                      first_name = :first_name,
                      last_name = :last_name,
                      email = :email,
                      password = :password,
                      phone = :phone";

        $stmt = $this->conn->prepare($query);

        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->phone = htmlspecialchars(strip_tags($this->phone));

        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", password_hash($this->password, PASSWORD_BCRYPT));
        $stmt->bindParam(":phone", $this->phone);

        if ($stmt->execute()) {
            return "success";
        }

        return "failed";
    }




    public function read()
    {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function readOne()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE admin_id = :admin_id LIMIT 1";

        $stmt = $this->conn->prepare($query);

        $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));

        $stmt->bindParam(":admin_id", $this->admin_id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

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

    public function update()
    {
        // Check if email or phone already exists for another admin
        if ($this->emailExists($this->email, $this->admin_id)) {
            return "Email already exists";
        }
        if ($this->phoneExists($this->phone, $this->admin_id)) {
            return "Phone number already exists";
        }

        // Validate email and phone formats
        if (!$this->validateEmail($this->email)) {
            return "Provide a valid email";
        }
        if (!$this->validatePhone($this->phone)) {
            return "Provide a valid phone number";
        }

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

        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));

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

    public function delete()
    {
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

    private function emailExists($email, $admin_id = null)
    {
        $query = "SELECT admin_id FROM " . $this->table_name . " WHERE email = :email";

        if ($admin_id) {
            $query .= " AND admin_id != :admin_id";
        }

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $email = htmlspecialchars(strip_tags($email));

        // Bind value
        $stmt->bindParam(":email", $email);

        if ($admin_id) {
            $stmt->bindParam(":admin_id", $admin_id);
        }

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }

    private function phoneExists($phone, $admin_id = null)
    {
        $query = "SELECT admin_id FROM " . $this->table_name . " WHERE phone = :phone";

        if ($admin_id) {
            $query .= " AND admin_id != :admin_id";
        }

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $phone = htmlspecialchars(strip_tags($phone));

        // Bind value
        $stmt->bindParam(":phone", $phone);

        if ($admin_id) {
            $stmt->bindParam(":admin_id", $admin_id);
        }

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }

    private function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function validatePhone($phone)
    {
        return preg_match('/^\+[1-9]\d{1,14}$/', $phone);
    }
}
