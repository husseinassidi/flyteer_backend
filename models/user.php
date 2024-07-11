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
        $stmt = $this->pdo->prepare('INSERT INTO users (first_name, last_name, email, password,phone) VALUES (?, ?, ?, ?,?)');
        $stmt->execute([$first_name, $last_name, $email, $password, $phone]);
        return ["message" => "user company created successfully"];
    }
    public function read()
    {
        $stmt = $this->pdo->query('SELECT * FROM users');
        return $stmt->fetchAll();
    }

    public function update($id, $first_name, $last_name, $email, $password, $phone)
    {
        $stmt = $this->pdo->prepare('UPDATE users SET id = ?, first_name = ?, last_name = ?, email = ? WHERE password = ?, phone = ?');

        $stmt->execute([$id, $first_name, $last_name, $email, $password, $phone]);
        return ["message" => "user updated successfully"];
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return ["message" => "user deleted successfully"];
    }
}
