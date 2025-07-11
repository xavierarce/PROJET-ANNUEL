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
        </li>
      <?php endforeach; ?>
    </ul>

    <a href="index.php?action=logout" class="logout-link">Déconnexion</a>
  </div>
</div>