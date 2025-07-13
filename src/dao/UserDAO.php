<?php
require_once __DIR__ . '/../model/DB.php';
require_once __DIR__ . '/../model/User.php';

class UserDAO
{
  /**
   * Find a user by their login.
   * 
   * @param string $login
   * @return User|null
   */
  public static function findByLogin(string $login): ?User
  {
    $db = DB::connect();
    $stmt = $db->prepare('SELECT * FROM users WHERE login = :login LIMIT 1');
    $stmt->bindParam(':login', $login, PDO::PARAM_STR);
    $stmt->execute();
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

  /**
   * Create a new user in the database.
   * 
   * @param string $pseudo
   * @param string $login
   * @param string $password Hashed password
   * @param string $email
   * @param int $role_id
   * @return bool Success or failure
   */
  public static function create(string $pseudo, string $login, string $password, string $email, int $role_id = 1): bool
  {
    $db = DB::connect();
    $stmt = $db->prepare('
            INSERT INTO users (pseudo, login, password, email, role_id) 
            VALUES (:pseudo, :login, :password, :email, :role_id)
        ');

    $stmt->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
    $stmt->bindParam(':login', $login, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);

    return $stmt->execute();
  }
}
