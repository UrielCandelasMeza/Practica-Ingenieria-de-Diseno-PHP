<?php

class UserModel
{
  private $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function registerUser($user): int
  {
    $stmt = $this->pdo->prepare('INSERT INTO users (email, password, name) VALUES (?, ?, ?)');
    $stmt->execute([
      $user["email"],
      $user["password"],
      $user["name"]
    ]);

    return (int) $this->pdo->lastInsertId();
  }

  public function findByEmail($email): ?array
  {
    $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([
      $email,
    ]);
    $usuario = $stmt->fetch() ?: null;
    return $usuario;
  }
}