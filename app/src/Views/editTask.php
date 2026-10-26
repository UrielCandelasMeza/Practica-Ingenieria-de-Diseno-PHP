<?php
$title = "Editar tarea";

if (!isset($_SESSION['user_id'])) {
  header('Location: /login');
  exit;
}

$userId = (int) $_SESSION['user_id'];

require_once __DIR__ . "/../Controllers/TaskController.php";
require_once __DIR__ . "/../Models/Database.php";
require_once __DIR__ . "/../Models/TaskModel.php";

$pdo = Database::getConnection();
$taskModel = new TaskModel($pdo);
$controller = new TaskController($taskModel, $userId);

$taskId = (int) ($_POST['id'] ?? $_GET['id'] ?? 0);
$task = $taskId > 0 ? $taskModel->getTaskById($taskId, $userId) : null;

if (!$task) {
  header('Location: /home');
  exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $resultado = $controller->updateTask($_POST);

  if ($resultado["ok"]) {
    header("Location: /home");
    exit;
  }

  $error = $resultado["error"];
  $task = $taskModel->getTaskById($taskId, $userId) ?? $task;
}

$isCompleted = in_array($task['completed'], [true, 1, '1', 't', 'true'], true);

ob_start();
?>

<h1>Editar tarea</h1>

<div class="form-container">
  <form class="form form-edit" method="POST" action="/tasks/edit">
    <?php if (!empty($error)): ?>
      <div class="error-container">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <input type="hidden" name="id" value="<?= (int) $task['id'] ?>">

    <div class="input-container">
      <label>
        <p>Título: </p>
        <input class="input" type="text" name="title" required maxlength="255"
          value="<?= htmlspecialchars($task['title']) ?>">
      </label>

      <label>
        <p>Descripción: </p>
        <textarea class="input" name="description" rows="3"><?= htmlspecialchars($task['description'] ?? '') ?></textarea>
      </label>

      <label>
        <p>Fecha: </p>
        <input class="input" type="date" name="date" required
          value="<?= htmlspecialchars($task['date']) ?>">
      </label>

      <label class="checkbox-container">
        <input type="checkbox" name="completed" value="1" <?= $isCompleted ? 'checked' : '' ?>>
        <span>Tarea completada</span>
      </label>

      <div class="form-actions">
        <a class="task-link" href="/home">Cancelar</a>
        <input class="input" type="submit" value="Guardar cambios">
      </div>
    </div>
  </form>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . "/Layouts/homeLayout.php";
?>
