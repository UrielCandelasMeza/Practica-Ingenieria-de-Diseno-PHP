<?php
if (!isset($_SESSION['user_id'])) {
  header('Location: /login');
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/layout.css">
  <title><?= $title ?? 'Mi app' ?></title>
</head>

<body>
  <header class="header">
    <h3><a href="/home">Inicio</a></h3>
    <ul class="option-container">
      <li class="option"><a href="/create">Crear nueva tarea</a></li>
      <li class="option"><a href="/logout">Cerrar sesion</a></li>

    </ul>
  </header>
  <main class="main-content">
    <?= $content ?>
  </main>
  <footer></footer>
</body>

</html>