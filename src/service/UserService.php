<?php
require_once __DIR__ . '/../dao/UserDAO.php';

class UserService
{
    public function login(string $login, string $password): ?User
    {
        $user = UserDAO::findByLogin($login);
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return null;
    }

    /**
     * @throws Exception if login already exists
     */
    public function register(string $pseudo, string $login, string $password, string $email): bool
    {
        if (UserDAO::findByLogin($login) !== null) {
            throw new Exception('Login déjà utilisé');
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return UserDAO::create($pseudo, $login, $hashedPassword, $email);
    }
}
