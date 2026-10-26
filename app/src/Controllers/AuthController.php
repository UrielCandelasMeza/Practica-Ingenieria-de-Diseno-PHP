<?php

require_once __DIR__ . '/../Models/UserModel.php';

class AuthController
{
  private UserModel $userModel;

  public function __construct(UserModel $userModel)
  {
    $this->userModel = $userModel;
  }

  public function register(array $data): array
  {
    $email = trim($data['email'] ?? '');
    $password = $data['password'] ?? '';
    $name = trim($data['name'] ?? '');

    if ($email === '' || $password === '' || $name === '') {
      return ['ok' => false, 'error' => 'Todos los campos son obligatorios'];
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return ['ok' => false, 'error' => 'El email no es valido'];
    }

    if (strlen($password) < 8) {
      return ['ok' => false, 'error' => 'La contraseña debe de tener mas de 8 caracteres'];
    }

    $userFound = $this->userModel->findByEmail($email);

    if ($userFound) {
      return ['ok' => false, 'error' => 'El email ya ha sido registrado'];
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $user = [
      "email" => $email,
      "password" => $hash,
      "name" => $name
    ];

    $id = $this->userModel->registerUser($user);
    return ['ok' => true, 'id' => $id];

  }

  public function login(array $data): array
  {
    $email = trim($data['email'] ?? '');
    $password = $data['password'] ?? '';

    if ($email === '' || $password === '') {
      return ['ok' => false, 'error' => 'Todos los campos son obligatorios'];
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return ['ok' => false, 'error' => 'El email no es valido'];
    }

    if (strlen($password) < 8) {
      return ['ok' => false, 'error' => 'La contraseña debe de tener mas 8 caracteres'];
    }

    $userFound = $this->userModel->findByEmail($email);

    if (!$userFound) {
      return ['ok' => false, 'error' => 'No se ha registrado ese email'];
    }

    if (!password_verify($password, $userFound["password"])) {
      return ['ok' => false, 'error' => 'La contraseña es incorrecta'];
    }

    session_regenerate_id(true);
    $_SESSION['user_id'] = $userFound['id'];

    return ['ok' => true];
  }

  public function logout()
  {
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
      $p = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }

    session_destroy();
    header('Location: /login');
    exit;
  }
}