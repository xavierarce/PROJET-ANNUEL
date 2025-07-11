<?php
require_once __DIR__ . '/../model/DB.php';
require_once __DIR__ . '/../model/User.php';

class UserDAO
{
  public static function findByLogin(string $login): ?User
  {
    $db = DB::connect();
    $stmt = $db->prepare('SELECT * FROM users WHERE login = ?');
    $stmt->execute([$login]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($data) {
      return new User(
        (int)$data['id'],
        $data['pseudo'],
        $data['login'],
        $data['password'],
        $data['email'],
        (int)$data['role_id']
      );
    }
    return null;
  }

  public static function create(string $pseudo, string $login, string $password, string $email, int $roleId = 1): bool
  {
    $db = DB::connect();
    $stmt = $db->prepare('INSERT INTO users (pseudo, login, password, email, role_id) VALUES (?, ?, ?, ?, ?)');
    return $stmt->execute([$pseudo, $login, $password, $email, $roleId]);
  }
}
