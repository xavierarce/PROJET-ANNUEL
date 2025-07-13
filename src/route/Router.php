<?php

require_once __DIR__ . '/../controller/UserController.php';
require_once __DIR__ . '/../controller/RoomController.php';
require_once __DIR__ . '/../controller/MessageController.php';

class Router
{
  private $routes = [];

  public function __construct()
  {
    // Public routes
    $this->routes['GET']['login'] = [UserController::class, 'login'];
    $this->routes['POST']['login'] = [UserController::class, 'handleLogin'];

    $this->routes['GET']['register'] = [UserController::class, 'register'];
    $this->routes['POST']['register'] = [UserController::class, 'handleRegister'];

    $this->routes['GET']['logout'] = [UserController::class, 'logout'];

    // Protected routes
    $this->routes['GET']['rooms'] = [RoomController::class, 'rooms'];
    $this->routes['GET']['chat'] = [RoomController::class, 'chat'];
    $this->routes['POST']['createRoom'] = [RoomController::class, 'createRoom'];
    $this->routes['POST']['sendMessage'] = [MessageController::class, 'sendMessage'];
  }

  public function handleRequest(string $method, string $action): void
  {
    $method = strtoupper($method);
    $action = $action ?: 'login';

    // Auth check
    $public = ['login', 'register', 'logout'];
    $isPublic = in_array($action, $public);

    if (!$isPublic && !isset($_SESSION['user'])) {
      header('Location: index.php?action=login');
      exit;
    }

    if ($isPublic && isset($_SESSION['user']) && in_array($action, ['login', 'register'])) {
      header('Location: index.php?action=rooms');
      exit;
    }

    if (isset($this->routes[$method][$action])) {
      [$controller, $methodName] = $this->routes[$method][$action];
      (new $controller())->$methodName();
    } else {
      http_response_code(404);
      echo "404 - Route [$method $action] not found";
    }
  }
}
