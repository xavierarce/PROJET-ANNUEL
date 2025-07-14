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
        (bool)$row['is_visible'],
        (bool)$row['is_archived']
      );
    }
    return $rooms;
  }

  public static function fetchAllVisible(): array
  {
    $db = DB::connect();
    $stmt = $db->prepare("SELECT * FROM rooms WHERE is_archived = :archived AND is_visible = :visible ORDER BY id DESC");
    $stmt->execute([
      'archived' => 0,
      'visible' => 1,
    ]);

    $roomsData = $stmt->fetchAll();
    $rooms = [];

    foreach ($roomsData as $row) {
      $rooms[] = new Room(
        (int)$row['id'],
        $row['name'],
        (int)$row['owner_id'],
        $row['topic'],
        (bool)$row['is_private'],
        (bool)$row['is_visible'],
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
      (bool)$row['is_visible'],
      (bool)$row['is_archived']
    );
  }

  public static function insert(string $name, int $owner_id, string $topic, bool $is_private, bool $is_visible): ?int
  {
    $db = DB::connect();
    $stmt = $db->prepare('INSERT INTO rooms (name, owner_id, topic, is_private, is_visible) VALUES (?, ?, ?, ?, ?)');
    $result = $stmt->execute([
      $name,
      $owner_id,
      $topic,
      $is_private ? 1 : 0,
      $is_visible ? 1 : 0
    ]);

    return $result ? (int)$db->lastInsertId() : null;
  }

  public static function archive(int $roomId): void
  {
    $db = DB::connect();
    $stmt = $db->prepare("UPDATE rooms SET is_archived = 1 WHERE id = ?");
    $stmt->execute([$roomId]);
  }

  public static function updateRoom(int $roomId, string $newName, bool $isPrivate, bool $isVisible): bool
  {
    $db = DB::connect();
    $stmt = $db->prepare('UPDATE rooms SET name = :name, is_private = :is_private, is_visible = :is_visible WHERE id = :id');
    return $stmt->execute([
      ':name' => $newName,
      ':is_private' => $isPrivate ? 1 : 0,
      ':is_visible' => $isVisible ? 1 : 0,
      ':id' => $roomId
    ]);
  }
}
