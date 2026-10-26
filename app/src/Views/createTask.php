<?php
$title = "Nueva tarea";

if (!isset($_SESSION['user_id'])) {
  header('Location: /login');
  exit;
}

$userId = (int) $_SESSION['user_id'];


require_once __DIR__ . "/../Controllers/TaskController.php";
require_once __DIR__ . "/../Models/Database.php";
require_once __DIR__ . "/../Models/TaskModel.php";

$pdo = Database::getConnection();

$controller = new TaskController(new TaskModel($pdo), $userId);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $resultado = $controller->createTask($_POST);

  if ($resultado["ok"]) {
    header("Location: /home");
    exit;
  }

  $error = $resultado["error"];
}

ob_start();
?>

<h1>Crear nueva tarea</h1>

<div class="form-container">
  <form class="form" method="POST">
    <?php if (!empty($error)): ?>
      <div class="error-container">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <div class="input-container">
      <input class="input" type="text" name="title" placeholder="Título" required maxlength="255">
      <textarea class="input" name="description" placeholder="Descripción (opcional)" rows="3"></textarea>
      <input class="input" type="date" name="date" required>
      <input class="input" type="submit" value="Crear tarea">
    </div>
  </form>
</div>


<?php
$content = ob_get_clean();
require __DIR__ . "/Layouts/homeLayout.php";
?>