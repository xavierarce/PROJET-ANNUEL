<?php
require_once __DIR__ . '/../dao/RoomDAO.php';

class RoomService
{
  public function getAllRooms(): array
  {
    return RoomDAO::fetchAll();
  }

  public function getRoomById(int $id): ?Room
  {
    return RoomDAO::fetchById($id);
  }

  /**
   * @throws Exception if validation fails
   */
  public function createRoom(string $name, int $ownerId, string $topic = '', bool $isPrivate = false): int
  {
    $name = trim($name);
    if ($name === '') {
      throw new Exception('Le nom de la room est obligatoire.');
    }

    // You can add additional business rules here

    $id = RoomDAO::insert($name, $ownerId, $topic, $isPrivate);
    if ($id === null) {
      throw new Exception('Erreur lors de la création de la room.');
    }
    return $id;
  }
}
