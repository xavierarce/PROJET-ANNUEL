<?php
require_once __DIR__ . '/../service/MessageService.php';

class MessageController
{
  public function chat()
  {
    if (!isset($_SESSION['user'])) {
      header('Location: index.php?action=login');
      exit;
    }
    $roomId = $_GET['id'] ?? 1;
    $messages = MessageService::getMessagesByRoom($roomId);
    require __DIR__ . '/../view/chat.php';
  }

  public function sendMessage()
  {
    if (!isset($_SESSION['user'])) {
      header('Location: index.php?action=login');
      exit;
    }
    if (isset($_POST['message'], $_GET['id'])) {
      try {
        MessageService::sendMessage($_SESSION['user']['id'], (int)$_GET['id'], $_POST['message']);
      } catch (Exception $e) {
        $error = $e->getMessage();
        // handle error (show on view or log)
      }
    }
    header('Location: index.php?action=chat&id=' . $_GET['id']);
    exit;
  }
}
