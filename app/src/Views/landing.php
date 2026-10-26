<?php
$title = "Landing Page";

ob_start();
?>

<h1>Hola mundo desde php</h1>

<?php
$content = ob_get_clean();
require __DIR__ . "/Layouts/mainLayout.php";
?>