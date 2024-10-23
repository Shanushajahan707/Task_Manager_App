<?php
require_once '../config/db.php';
require_once '../models/task.php';

// controllers/TaskController.php
class TaskController
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getTasks($userId)
    {
        $stmt = $this->connection->prepare("SELECT id, title, description, status, created_at FROM tasks WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTask($userId, $title, $description)
    {
        $stmt = $this->connection->prepare("INSERT INTO tasks (user_id, title, description, created_at) VALUES (:user_id, :title, :description, NOW())");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->execute();
    }

    public function updateTask($taskId, $title, $description)
    {
        $stmt = $this->connection->prepare("UPDATE tasks SET title = :title, description = :description WHERE id = :id");
        $stmt->bindParam(':id', $taskId);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->execute();
    }

    public function updateTaskStatus($taskId, $status)
    {
        $task = new Task($this->connection);
        return $task->updateTaskStatus($taskId, $status);
    }

    public function deleteTask($taskId)
    {
        $stmt = $this->connection->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->bindParam(':id', $taskId);
        $stmt->execute();
    }
}
?>
