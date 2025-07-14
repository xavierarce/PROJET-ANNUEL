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
  public function createRoom(
    string $name,
    int $owner_id,
    bool $is_private,
    bool $is_visible,
    ?string $password = null,
    string $topic = ''
  ): int {
    $name = trim($name);
    if ($name === '') {
      throw new Exception('Le nom de la room est obligatoire.');
    }

    $id = RoomDAO::insert($name, $owner_id, $topic, $is_private, $is_visible, $password);
    if ($id === null) {
      throw new Exception('Erreur lors de la création de la room.');
    }
    return $id;
  }

  public function archiveRoom(int $roomId): void
  {
    RoomDAO::archive($roomId);
  }

  public static function updateRoom(int $roomId, int $userId, string $newName, bool $isPrivate, bool $isVisible, ?string $password): void
  {
    if (!$roomId || $newName === '') {
      throw new Exception("Nom invalide.");
    }

    $room = RoomDAO::fetchById($roomId);

    if (!$room) {
      throw new Exception("Salon introuvable.");
    }

    if ($room->owner_id !== $userId) {
      throw new Exception("Action non autorisée.");
    }

    $updated = RoomDAO::updateRoom($roomId, $newName, $isPrivate, $isVisible, $password);
    if (!$updated) {
      throw new Exception("Erreur lors de la mise à jour du salon.");
    }
  }
}
