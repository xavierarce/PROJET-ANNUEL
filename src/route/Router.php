<?php

require_once __DIR__ . '/../controller/UserController.php';
require_once __DIR__ . '/../controller/RoomController.php';
require_once __DIR__ . '/../controller/MessageController.php';

class Router
{
  private array $routes = [];
  private array $publicActions = ['login', 'register', 'logout', 'rooms'];

  public function __construct()
  {
    $this->mapRoutes();
  }

  private function mapRoutes(): void
  {
    $this->routes = [
      'GET' => [
        'login'       => [UserController::class, 'login'],
        'register'    => [UserController::class, 'register'],
        'logout'      => [UserController::class, 'logout'],
        'rooms'       => [RoomController::class, 'rooms'],
        'chat'        => [RoomController::class, 'chat'],
        'createRoom'  => [RoomController::class, 'showCreateRoomForm'],
      ],
      'POST' => [
        'login'       => [UserController::class, 'handleLogin'],
        'register'    => [UserController::class, 'handleRegister'],
        'createRoom'  => [RoomController::class, 'handleCreateRoom'],
        'archiveRoom' => [RoomController::class, 'archiveRoom'],
        'sendMessage' => [MessageController::class, 'sendMessage'],
        'updateRoom' => [RoomController::class, 'updateRoom'],
        'verifyRoomPassword' => [RoomController::class, 'verifyRoomPassword'],
      ],
    ];
  }

  public function handleRequest(string $method, ?string $action): void
  {
    $method = strtoupper($method);
    $action = $action ?: 'login';
    $isPublic = in_array($action, $this->publicActions);
    $isLogged = isset($_SESSION['user']);

    if (!$isPublic && !$isLogged) {
      $this->redirect('login');
      return;
    }

    if ($isPublic && $isLogged && in_array($action, ['login', 'register'])) {
      $this->redirect('rooms');
      return;
    }


    if (isset($this->routes[$method][$action])) {
      [$controller, $fn] = $this->routes[$method][$action];
      (new $controller())->$fn();
    } else {
      http_response_code(404);
      echo "404 - Route [$method $action] not found";
    }
  }

  private function redirect(string $to): void
  {
    header("Location: index.php?action=$to");
    exit;
  }
}
