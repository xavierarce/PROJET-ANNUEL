<?php
require_once __DIR__ . '/../model/DB.php';
require_once __DIR__ . '/../model/Room.php';

class RoomDAO
{
  public static function fetchAll(): array
  {
    $db = DB::connect();
    $stmt = $db->query('SELECT * FROM rooms');
    $roomsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $rooms = [];
    foreach ($roomsData as $row) {
      $rooms[] = new Room(
        (int)$row['id'],
        $row['name'],
        (int)$row['owner_id'],
        $row['topic'],
        (bool)$row['is_private']
      );
    }
    return $rooms;
  }

  public static function fetchById(int $id): ?Room
  {
    $db = DB::connect();
    $stmt = $db->prepare('SELECT * FROM rooms WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      return null;
    }

    return new Room(
      (int)$row['id'],
      $row['name'],
      (int)$row['owner_id'],
      $row['topic'],
      (bool)$row['is_private']
    );
  }

  public static function insert(string $name, int $ownerId, string $topic, bool $isPrivate): ?int
  {
    $db = DB::connect();
    $stmt = $db->prepare('INSERT INTO rooms (name, owner_id, topic, is_private) VALUES (?, ?, ?, ?)');
    $result = $stmt->execute([$name, $ownerId, $topic, $isPrivate ? 1 : 0]);

    if ($result) {
      return (int)$db->lastInsertId();
    }
    return null;
  }
}
