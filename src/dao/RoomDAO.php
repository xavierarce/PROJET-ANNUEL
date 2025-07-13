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
        (bool)$row['is_private'],
        (bool)$row['is_archived']
      );
    }
    return $rooms;
  }

  public static function fetchAllVisible(): array
  {
    $db = DB::connect();
    $stmt = $db->query("SELECT * FROM rooms WHERE is_archived = 0 ORDER BY id DESC");
    $rooms = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $rooms[] = new Room(
        (int)$row['id'],
        $row['name'],
        (int)$row['owner_id'],
        $row['topic'],
        (bool)$row['is_private'],
        (bool)$row['is_archived']
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
      (bool)$row['is_private'],
      (bool)$row['is_archived']
    );
  }

  public static function insert(string $name, int $ownerId, string $topic, bool $is_private): ?int
  {
    $db = DB::connect();
    $stmt = $db->prepare('INSERT INTO rooms (name, owner_id, topic, is_private) VALUES (?, ?, ?, ?)');
    $result = $stmt->execute([$name, $ownerId, $topic, $is_private ? 1 : 0]);

    return $result ? (int)$db->lastInsertId() : null;
  }

  public static function archive(int $roomId): void
  {
    $db = DB::connect();
    $stmt = $db->prepare("UPDATE rooms SET is_archived = 1 WHERE id = ?");
    $stmt->execute([$roomId]);
  }
}
