<?php
require_once __DIR__ . '/DB.php';

class User
{
    public static function findByLogin($login)
    {
        $db = DB::connect();
        $stmt = $db->prepare('SELECT * FROM users WHERE login = ?');
        $stmt->execute([$login]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($pseudo, $login, $password, $email, $role_id = 1)
    {
        $db = DB::connect();
        $stmt = $db->prepare('INSERT INTO users (pseudo, login, password, email, role_id) VALUES (?, ?, ?, ?, ?)');
        return $stmt->execute([$pseudo, $login, $password, $email, $role_id]);
    }
}
