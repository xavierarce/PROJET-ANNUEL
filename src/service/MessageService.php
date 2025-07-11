<?php
require_once __DIR__ . '/../dao/MessageDAO.php';

class MessageService
{
  public static function getMessagesByRoom(int $room_id): array
  {
    // You could add filtering, authorization checks here
    return MessageDAO::getByRoom($room_id);
  }

  public static function sendMessage(int $user_id, int $room_id, string $message): bool
  {
    if (empty(trim($message))) {
      throw new Exception("Message cannot be empty");
    }
    // maybe sanitize or limit length here
    return MessageDAO::add($user_id, $room_id, $message);
  }
}
