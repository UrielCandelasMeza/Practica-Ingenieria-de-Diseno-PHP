<?php

class TaskModel
{

  private PDO $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function getAllTasks($userId): ?array
  {
    $stmt = $this->pdo->prepare(
      "SELECT id, title, description, date, completed
      FROM tasks
      WHERE user_id = ?
      ORDER BY date ASC, id ASC"
    );
    $stmt->execute([
      $userId
    ]);

    return $stmt->fetchAll() ?: null;
  }

  public function getTaskById(int $taskId, int $userId): ?array
  {
    $stmt = $this->pdo->prepare(
      "SELECT id, title, description, date, completed
      FROM tasks
      WHERE id = ? AND user_id = ?"
    );
    $stmt->execute([$taskId, $userId]);

    return $stmt->fetch() ?: null;
  }

  public function createTask($data): int
  {
    $stmt = $this->pdo->prepare("INSERT INTO tasks (title, description, date, user_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([
      $data["title"],
      $data["description"],
      $data["date"],
      $data["userId"]
    ]);

    return (int) $this->pdo->lastInsertId();
  }

  public function updateTask($data): ?array
  {
    $stmt = $this->pdo->prepare(
      "UPDATE tasks 
      SET title = ?, description = ?, date = ?, completed = ? 
      WHERE id = ? AND user_id = ?
      RETURNING *"
    );
    $stmt->execute([
      $data["title"],
      $data["description"],
      $data["date"],
      $data["completed"] ? 1 : 0,
      $data["id"],
      $data["userId"]
    ]);

    return $stmt->fetch() ?: null;
  }

  public function toggleTask(int $taskId, int $userId): ?array
  {
    $stmt = $this->pdo->prepare(
      'UPDATE tasks
     SET completed = NOT completed
     WHERE id = ? AND user_id = ?
     RETURNING *'
    );
    $stmt->execute([$taskId, $userId]);

    return $stmt->fetch() ?: null;
  }

  public function deleteTask(int $taskId, int $userId): bool
  {
    $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->execute([
      $taskId,
      $userId
    ]);

    return $stmt->rowCount() > 0;
  }
}