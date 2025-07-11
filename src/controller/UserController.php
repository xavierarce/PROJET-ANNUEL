<?php
require_once __DIR__ . '/../service/UserService.php';

class UserController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = UserService::login($_POST['login'], $_POST['password']);
            if ($user) {
                $_SESSION['user'] = $user;
                header('Location: index.php?action=rooms');
                exit;
            } else {
                $error = 'Identifiants incorrects';
                require __DIR__ . '/../view/login.php';
            }
        } else {
            require __DIR__ . '/../view/login.php';
        }
    }
    public function logout()
    {

        session_destroy();
        header('Location: index.php?action=login');
        exit;
    }
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pseudo = $_POST['pseudo'] ?? '';
            $login = $_POST['login'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            if ($pseudo && $login && $email && $password) {
                $result = UserService::register($pseudo, $login, $password, $email);
                if ($result === true) {
                    $success = 'Inscription réussie, vous pouvez vous connecter.';
                } else {
                    $error = $result;
                }
            } else {
                $error = 'Tous les champs sont obligatoires';
            }
            require __DIR__ . '/../view/register.php';
        } else {
            require __DIR__ . '/../view/register.php';
        }
    }
}
