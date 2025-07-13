<?php
session_start();

require_once __DIR__ . '/../route/Router.php';

$router = new Router();
$router->handleRequest($_SERVER['REQUEST_METHOD'], $_GET['action'] ?? null);
