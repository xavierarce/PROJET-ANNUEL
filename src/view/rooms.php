<?php require __DIR__ . '/partials/header.php'; ?>

<div class="rooms-page">
  <div class="rooms-card">
    <h2>Rooms</h2>

    <a href="index.php?action=createRoom" class="button">+ Créer un nouveau Room</a>

    <ul class="Room-list">
      <?php foreach ($rooms as $room): ?>
        <li class="Room-item">
          <a href="index.php?action=chat&id=<?= $room->id ?>">
            <?= htmlspecialchars($room->name) ?>
          </a>

          <?php if ($_SESSION['user']['role_id'] === 1): ?>
            <form action="index.php?action=archiveRoom" method="post" style="display:inline;">
              <input type="hidden" name="room_id" value="<?= $room->id ?>">
              <button type="submit" class="button danger" onclick="return confirm('Supprimer ce salon ?')">🗑️</button>
            </form>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>

    <a href="index.php?action=logout" class="logout-link">Déconnexion</a>
  </div>
</div>