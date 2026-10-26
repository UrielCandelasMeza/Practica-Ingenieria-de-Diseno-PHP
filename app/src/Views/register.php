<?php

$title = "Registro";

require_once __DIR__ . '/../Models/Database.php';
require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Controllers/AuthController.php';


$pdo = Database::getConnection();
$controller = new AuthController(new UserModel($pdo));

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $resultado = $controller->register($_POST);

  if ($resultado["ok"]) {
    header("Location: /login");
    exit;
  }

  $error = $resultado["error"];
}



ob_start();
?>

<div class="form-container">
  <form class="form-register" method="POST">
    <h1>Registro de Usuario</h1>
    <div class="input-container">
      <label>
        <p>Nombre: </p>
        <input type="text" name="name" class="input">
      </label>
      <label>
        <p>Email: </p>
        <input type="email" name="email" class="input">
      </label>
      <label>
        <p>Contraseña: </p>
        <input type="password" name="password" class="input">
      </label>
      <?php if (!empty($error)): ?>
        <span class="error-container">
          <?= htmlspecialchars($error) ?>
        </span>
      <?php endif; ?>
      <label>
        <input type="submit" value="Enviar" class="input">
      </label>

    </div>
  </form>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . "/Layouts/mainLayout.php";
?>