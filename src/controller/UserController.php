<?php
require_once __DIR__ . '/../service/UserService.php';
require_once __DIR__ . '/BaseController.php';

class UserController extends BaseController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function login()
    {
        require __DIR__ . '/../view/login.php';
    }

    public function handleLogin()
    {
        $user = $this->userService->login($_POST['login'], $_POST['password']);
        if ($user) {
            $_SESSION['user'] = $user->toArray();
            $this->redirect('rooms');
            exit;
        } else {
            $error = 'Identifiants incorrects';
            require __DIR__ . '/../view/login.php';
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('login');
        exit;
    }

    // GET /register
    public function register()
    {
        require __DIR__ . '/../view/register.php';
    }

    // POST /register
    public function handleRegister()
    {
        $pseudo = $_POST['pseudo'] ?? '';
        $login = $_POST['login'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($pseudo && $login && $email && $password) {
            try {
                $this->userService->register($pseudo, $login, $password, $email);
                $success = 'Inscription réussie, vous pouvez vous connecter.';
                $this->redirect('login');
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        } else {
            $error = 'Tous les champs sont obligatoires';
        }

        require __DIR__ . '/../view/register.php';
    }
}
