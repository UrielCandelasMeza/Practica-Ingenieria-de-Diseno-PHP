<?php
$title = "Inicio";

if (!isset($_SESSION['user_id'])) {
  header('Location: /login');
  exit;
}

require_once __DIR__ . '/../Models/Database.php';
require_once __DIR__ . '/../Models/TaskModel.php';

$pdo = Database::getConnection();
$taskModel = new TaskModel($pdo);
$tasks = $taskModel->getAllTasks((int) $_SESSION['user_id']) ?? [];

$isCompleted = static fn(array $task): bool =>
  in_array($task['completed'], [true, 1, '1', 't', 'true'], true);

$pendingTasks = array_filter($tasks, static fn(array $task): bool => !$isCompleted($task));
$completedTasks = array_filter($tasks, $isCompleted);

ob_start();
?>

<h1>Dashboard de tareas</h1>

<section class="task-section">
  <h2>Pendientes</h2>

  <?php if (empty($pendingTasks)): ?>
    <p class="empty">No tienes tareas pendientes.</p>
  <?php else: ?>
    <ul class="task-list">
      <?php foreach ($pendingTasks as $task): ?>
        <li class="task">
          <div>
            <strong><?= htmlspecialchars($task['title']) ?></strong>
            <small><?= date('d/m/Y', strtotime($task['date'])) ?></small>
            <?php if (!empty($task['description'])): ?>
              <p><?= nl2br(htmlspecialchars($task['description'])) ?></p>
            <?php endif; ?>
          </div>

          <div class="task-actions">
            <a class="task-link" href="/tasks/edit?id=<?= (int) $task['id'] ?>">Editar</a>

            <form method="POST" action="/tasks/toggle">
              <input type="hidden" name="task_id" value="<?= (int) $task['id'] ?>">
              <input type="submit" value="Completar">
            </form>

            <form method="POST" action="/tasks/delete"
              onsubmit="return confirm('¿Eliminar esta tarea?');">
              <input type="hidden" name="task_id" value="<?= (int) $task['id'] ?>">
              <input type="submit" value="Eliminar">
            </form>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</section>

<section class="task-section">
  <h2>Completadas</h2>

  <?php if (empty($completedTasks)): ?>
    <p class="empty">Aún no tienes tareas completadas.</p>
  <?php else: ?>
    <ul class="task-list">
      <?php foreach ($completedTasks as $task): ?>
        <li class="task done">
          <div>
            <strong><?= htmlspecialchars($task['title']) ?></strong>
            <small><?= date('d/m/Y', strtotime($task['date'])) ?></small>
            <?php if (!empty($task['description'])): ?>
              <p><?= nl2br(htmlspecialchars($task['description'])) ?></p>
            <?php endif; ?>
          </div>

          <div class="task-actions">
            <a class="task-link" href="/tasks/edit?id=<?= (int) $task['id'] ?>">Editar</a>

            <form method="POST" action="/tasks/toggle">
              <input type="hidden" name="task_id" value="<?= (int) $task['id'] ?>">
              <input type="submit" value="Reabrir">
            </form>

            <form method="POST" action="/tasks/delete"
              onsubmit="return confirm('¿Eliminar esta tarea?');">
              <input type="hidden" name="task_id" value="<?= (int) $task['id'] ?>">
              <input type="submit" value="Eliminar">
            </form>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</section>

<?php
$content = ob_get_clean();
require __DIR__ . "/Layouts/homeLayout.php";
?>
