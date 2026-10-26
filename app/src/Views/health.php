<?php
$title = "Estatus";

ob_start();
?>
<h1>
  Estatus de la conexion a la base de datos PostgreSQL
</h1>
<?php
try {
  $pdo = new PDO("pgsql:host=db;dbname=app_db", "root", "password");
  ?>
  <p>Conexion exitosa a la bd</p>
  <?php
} catch (PDOException $e) {
  ?>
  <p>Error de conexion con la bd<?= $e ?></p>
  <?php
}
?>

<?php
$content = ob_get_clean();
require __DIR__ . "/Layouts/mainLayout.php";


?>