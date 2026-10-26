<?php
class Database
{
  private static ?PDO $instance = null;

  public static function getConnection(): PDO
  {
    if (self::$instance === null) {
      $host = "db";
      $db = "app_db";
      $user = "root";
      $password = "password";

      $dsn = "pgsql:host=$host;dbname=$db";
      self::$instance = new PDO($dsn, $user, $password);
    }

    return self::$instance;
  }
}