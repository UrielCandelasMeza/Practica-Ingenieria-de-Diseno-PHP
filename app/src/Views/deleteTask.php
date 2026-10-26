<?php
if (!isset($_SESSION['user_id'])) {
  header('Location: /login');
  exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  header('Location: /home');
  exit;
}

require_once __DIR__ . "/../Controllers/TaskController.php";
require_once __DIR__ . "/../Models/Database.php";
require_once __DIR__ . "/../Models/TaskModel.php";

$pdo = Database::getConnection();
$controller = new TaskController(new TaskModel($pdo), (int) $_SESSION['user_id']);

$controller->deleteTask((int) ($_POST['task_id'] ?? 0));

header('Location: /home');
exit;
