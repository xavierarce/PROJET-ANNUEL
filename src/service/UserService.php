<?php
require_once __DIR__ . '/../model/User.php';

class UserService
{
    public static function login($login, $password)
    {
        $user = User::findByLogin($login);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }
    public static function register($pseudo, $login, $password, $email)
    {
        if (User::findByLogin($login)) {
            return 'Login déjà utilisé';
        }
        User::create($pseudo, $login, password_hash($password, PASSWORD_DEFAULT), $email);
        return true;
    }
}
