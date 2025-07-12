<?php
require_once __DIR__ . '/../service/MessageService.php';

class MessageController
{

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
