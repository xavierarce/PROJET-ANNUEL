<?php
// src/socket/server.php

// This resolves to /var/www/html/vendor/autoload.php
require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/ChatServer.php';


use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(
  new HttpServer(
    new WsServer(
      new ChatServer()
    )
  ),
  8080
);

echo "WebSocket server started on port 8080\n";
$server->run();
