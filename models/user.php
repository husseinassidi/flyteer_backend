<?php
class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($first_name, $last_name, $email, $password, $phone)
    {
        if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($phone)) {
            return ["message" => "All fields are required."];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["message" => "Invalid email format"];
        }

        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            return ["message" => "Email already exists"];
        }

        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE phone = ?');
        $stmt->execute([$phone]);
        if ($stmt->rowCount() > 0) {
            return ["message" => "Phone number already exists"];
        }

        if (!preg_match('/^\+961\d{8}$/', $phone)) {
            return ["message" => "Invalid Lebanese phone number format. It should start with +961 and have 8 digits"];
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
        if (empty($email) || empty($password)) {
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
        if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($phone)) {
            return ["message" => "All fields are required."];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["message" => "Invalid email format"];
        }

        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ? AND id != ?');
        $stmt->execute([$email, $id]);
        if ($stmt->rowCount() > 0) {
            return ["message" => "Email already exists"];
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare('UPDATE users SET first_name = ?, last_name = ?, email = ?, password = ?, phone = ? WHERE id = ?');
        $stmt->execute([$first_name, $last_name, $email, $hashedPassword, $phone, $id]);

        $rowCount = $stmt->rowCount();
        return [
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
