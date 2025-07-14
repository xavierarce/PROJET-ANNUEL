<?php require __DIR__ . '/partials/header.php'; ?>

<div class="rooms-page">
  <div class="rooms-card">
    <h2>Salons</h2>

    <a href="index.php?action=createRoom" class="button">+ Créer un nouveau salon</a>

    <ul class="Room-list">
      <?php foreach ($rooms as $room): ?>
        <li class="Room-item">
          <a href="index.php?action=chat&id=<?= $room->id ?>">
            <?= htmlspecialchars($room->name) ?>
            <?php if ($room->is_private): ?>
              <span class="private-indicator">🔒</span>
            <?php endif; ?>
          </a>

          <?php if (isset($_SESSION['user']) && isset($_SESSION['user']['role_id']) && $_SESSION['user']['role_id'] === 1): ?>
            <form method="post" action="index.php?action=archiveRoom" style="display: inline;">
              <input type="hidden" name="room_id" value="<?= $room->id ?>">
              <button type="submit" class="button danger" data-loading-text="Suppression..." data-confirm="Supprimer ce salon ?">🗑️</button>
            </form>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>

    <?php if (isset($_SESSION['user'])): ?>
      <a href="index.php?action=logout" class="logout-link">Déconnexion</a>
    <?php endif; ?>

  </div>