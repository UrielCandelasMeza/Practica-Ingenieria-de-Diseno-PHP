<?php


require_once __DIR__ . "/../Models/TaskModel.php";

class TaskController
{
  private TaskModel $taskModel;
  private $userId;

  public function __construct(TaskModel $taskModel, $userId)
  {
    $this->taskModel = $taskModel;
    $this->userId = $userId;
  }

  public function getTasks(): array
  {
    $tasks = $this->taskModel->getAllTasks($this->userId);

    if (!$tasks) {
      return ["ok" => false, "tasks" => []];
    }

    return ["ok" => true, "tasks" => $tasks];
  }

  public function createTask($task)
  {
    $title = trim($task["title"] ?? "");
    $description = trim($task["description"] ?? "");
    $date = trim($task["date"] ?? "");

    if ($title === "" || $date === "") {
      return ["ok" => false, "error" => "Hay datos faltantes"];
    }

    $d = DateTime::createFromFormat("!Y-m-d", $date);
    $today = new DateTime('today');

    if (!$d) {
      return ["ok" => false, "error" => "La fecha no es valida"];
    }

    if ($d < $today) {
      return ["ok" => false, "error" => "La fecha no puede ser anterior al dia de hoy"];
    }

    $data = [
      "title" => $title,
      "description" => $description,
      "date" => $date,
      "userId" => $this->userId
    ];

    $id = $this->taskModel->createTask($data);
    return ['ok' => true, 'id' => $id];
  }

  public function updateTask($task)
  {
    $title = trim($task["title"] ?? "");
    $description = trim($task["description"] ?? "");
    $date = trim($task["date"] ?? "");
    $completed = isset($task['completed']) && $task['completed'] !== '0';
    $id = (int) ($task["id"] ?? 0);

    if ($id <= 0) {
      return ["ok" => false, "error" => "Falta el id de la tarea"];
    }

    if ($title === "" || $date === "") {
      return ["ok" => false, "error" => "Hay datos faltantes"];
    }

    $d = DateTime::createFromFormat("!Y-m-d", $date);
    $today = new DateTime('today');

    if (!$d) {
      return ["ok" => false, "error" => "La fecha no es valida"];
    }

    if ($d < $today) {
      return ["ok" => false, "error" => "La fecha no puede ser anterior al dia de hoy"];
    }

    $data = [
      "title" => $title,
      "description" => $description,
      "date" => $date,
      "completed" => $completed,
      "id" => $id,
      "userId" => $this->userId
    ];

    $updatedTask = $this->taskModel->updateTask($data);

    if (!$updatedTask) {
      return ["ok" => false, "error" => "Ocurrio un error al modificar la tarea"];
    }

    return ["ok" => true, "updatedTask" => $updatedTask, "message" => "Tarea modificada"];
  }

  public function deleteTask($taskId)
  {

    if (!$taskId) {
      return ["ok" => false, "error" => "Falta el id de la tarea"];
    }

    if (!$this->taskModel->deleteTask((int) $taskId, $this->userId)) {
      return ["ok" => false, "error" => "Ocurrio un error al eliminar la tarea"];
    }

    return ["ok" => true, "message" => "Tarea eliminada"];

  }

  public function toggleTask($taskId)
  {

    if (!$taskId) {
      return ["ok" => false, "error" => "Falta el id de la tarea"];
    }

    if (!$this->taskModel->toggleTask((int) $taskId, $this->userId)) {
      return ["ok" => false, "error" => "Ocurrio un error al hacer la modificacion."];
    }

    return ["ok" => true];

  }
}