<?php
require_once __DIR__ . '/../service/MessageService.php';
require_once __DIR__ . '/BaseController.php';

class MessageController extends BaseController
{

  public function sendMessage()
  {
    if (!isset($_SESSION['user'])) {
      $this->redirect('login');

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
    $this->redirect('chat&id=' . $_GET['id']);
    exit;
  }
}
