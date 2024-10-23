<?php
class Task {
    private $connection;

    public function __construct($db) {
        $this->connection = $db;
    }

    public function createTask($userId, $title, $description) {
        $query = "INSERT INTO tasks (user_id, title, description) VALUES (:user_id, :title, :description)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }

    public function getTasks($userId) {
        $query = "SELECT * FROM tasks WHERE user_id = :user_id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateTask($id, $title, $description) {
        $query = "UPDATE tasks SET title = :title, description = :description WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }

    public function updateTaskStatus($id, $status) {
        $query = "UPDATE tasks SET status = :status WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    public function deleteTask($id) {
        $query = "DELETE FROM tasks WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
