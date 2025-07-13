<?php
require_once __DIR__ . '/../dao/RoomDAO.php';

class RoomService
{
  public function getAllRooms(): array
  {
    return RoomDAO::fetchAll();
  }


  public function getAllVisibleRooms(): array
  {
    return RoomDAO::fetchAllVisible();
  }

  public function getRoomById(int $id): ?Room
  {
    return RoomDAO::fetchById($id);
  }

  /**
   * @throws Exception if validation fails
   */
  public function createRoom(string $name, int $ownerId, string $topic = '', bool $is_private = false): int
  {
    $name = trim($name);
    if ($name === '') {
      throw new Exception('Le nom de la room est obligatoire.');
    }

    $id = RoomDAO::insert($name, $ownerId, $topic, $is_private);
    if ($id === null) {
      throw new Exception('Erreur lors de la création de la room.');
    }
    return $id;
  }

  public function archiveRoom(int $roomId): void
  {
    RoomDAO::archive($roomId);
  }
}
