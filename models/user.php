<?php
class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function checkUserExists($email, $phone, $exclude_id = null)
    {
        $query = 'SELECT 1 FROM users WHERE (email = ? OR phone = ?)';
        $params = [$email, $phone];

        if ($exclude_id !== null) {
            $query .= ' AND id != ?';
            $params[] = $exclude_id;
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    public function create($first_name, $last_name, $email, $password, $phone)
    {
        if (!isset($first_name) || !isset($last_name) || !isset($email) || !isset($password) || !isset($phone)) {
            return ["message" => "All fields are required."];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["message" => "Invalid email format"];
        }

        if ($this->checkUserExists($email, $phone)) {
            return ["message" => "Email or phone number already exists"];
        }

        if (!preg_match('/^\+?\d{10,15}$/', $phone)) {
            return ["message" => "Invalid phone number format. It should be 10 to 15 digits long and may start with a +"];
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare('INSERT INTO users (first_name, last_name, email, password, phone) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$first_name, $last_name, $email, $hashedPassword, $phone]);

        return ["message" => "User created successfully"];
    }

    public function read()
    {
        $stmt = $this->pdo->query('SELECT * FROM users');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readOne($id)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
            $stmt->execute([$id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Only get associative array results
        } catch (PDOException $e) {
            return ["message" => "Error: " . $e->getMessage()];
        }
    }

    public function login($email, $password)
    {
        if (!isset($email) || !isset($password)) {
            return ["message" => "All fields are required."];
        }

        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                return ["message" => "Login successful"];
            } else {
                return ["message" => "Invalid password"];
            }
        } else {
            return ["message" => "User not found"];
        }
    }

    public function update($id, $first_name, $last_name, $email, $password, $phone)
    {
        if (!isset($first_name) || !isset($last_name) || !isset($email) || !isset($password) || !isset($phone)) {
            return ["message" => "All fields are required."];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["message" => "Invalid email format"];
        }

        if ($this->checkUserExists($email, $phone, $id)) {
            return ["message" => "Email or phone number already exists"];
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare('UPDATE users SET first_name = ?, last_name = ?, email = ?, password = ?, phone = ? WHERE id = ?');
        $stmt->execute([$first_name, $last_name, $email, $hashedPassword, $phone, $id]);

        $rowCount = $stmt->rowCount();
        return [
            "status" => "success",
            "message" => "User updated successfully",
            "rowCount" => $rowCount
        ];
    }

    public function delete($id = null, $email = null)
    {
        if ($id) {
            $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
            $stmt->execute([$id]);
            $rowCount = $stmt->rowCount();
            if ($rowCount > 0) {
                return ["message" => "User deleted successfully by ID", "rowCount" => $rowCount];
            } else {
                return ["message" => "User not found with provided ID"];
            }
        } elseif ($email) {
            $stmt = $this->pdo->prepare('DELETE FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $rowCount = $stmt->rowCount();
            if ($rowCount > 0) {
                return ["message" => "User deleted successfully by email", "rowCount" => $rowCount];
            } else {
                return ["message" => "User not found with provided email"];
            }
        } else {
            return ["message" => "ID or Email is required for deletion"];
        }
    }
}