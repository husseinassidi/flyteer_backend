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
}
