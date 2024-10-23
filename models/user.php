<?php
class User {
    private $connection;

    public function __construct($db) {
        $this->connection = $db;
    }

    public function register($username, $password) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $passwordHash);
        return $stmt->execute();
    }

    public function login($username, $password) {
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user['id'];
        }
        return false;
    }
}
?>
