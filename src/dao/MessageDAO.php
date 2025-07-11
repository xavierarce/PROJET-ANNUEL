<?php
require_once __DIR__ . '/../model/DB.php';

class MessageDAO
{
  public static function getByRoom(int $room_id): array
  {
    $db = DB::connect();
    $stmt = $db->prepare('
            SELECT m.*, u.pseudo 
            FROM messages m 
            JOIN users u ON m.user_id = u.id 
            WHERE room_id = ? 
            ORDER BY timestamp ASC
        ');
    $stmt->execute([$room_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function add(int $user_id, int $room_id, string $message): bool
  {
    $db = DB::connect();
    $stmt = $db->prepare('INSERT INTO messages (user_id, room_id, message) VALUES (?, ?, ?)');
    return $stmt->execute([$user_id, $room_id, $message]);
  }
}
