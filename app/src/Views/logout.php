<?php
require_once __DIR__ . "/../Controllers/AuthController.php";
require_once __DIR__ . "/../Models/Database.php";
require_once __DIR__ . "/../Models/UserModel.php";

$pdo = Database::getConnection();
$controller = new AuthController(new UserModel($pdo));

$controller->logout();
exit;
