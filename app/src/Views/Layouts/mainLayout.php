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
    <h3><a href="/">CRUD de tareas</a></h3>
    <ul class="option-container">
      <li class="option"><a href="/health">Estado de la bd</a></li>
      <li class="option"><a href="/login">Iniciar sesion</a></li>
      <li class="option"><a href="/register">Registrarse</a></li>
    </ul>
  </header>
  <main class="main-content">
    <?= $content ?>
  </main>
  <footer></footer>
</body>

</html>