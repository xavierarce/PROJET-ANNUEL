<?php require __DIR__ . '/partials/header.php'; ?>

<?php if (!isset($room) || !is_object($room)): ?>
  <div class="error">Erreur : Salon introuvable.</div>
  <a href="index.php?action=rooms" class="button">Retour aux salons</a>
  <?php return; ?>
<?php endif; ?>

<div class="container">
  <div class="form-card">
    <h2>Salon privé : <?= htmlspecialchars($room->name) ?></h2>
    <p>Ce salon est protégé par un mot de passe.</p>

    <?php if (isset($error)): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="index.php?action=verifyRoomPassword">
      <input type="hidden" name="room_id" value="<?= $room->id ?>">

      <div class="form-group">
        <label for="password">Mot de passe du salon:</label>
        <input type="password" name="password" id="password" required autocomplete="off">
      </div>

      <div class="form-actions">
        <button type="submit" class="button">Accéder au salon</button>
        <a href="index.php?action=rooms" class="button secondary">Retour aux salons</a>
      </div>
    </form>
  </div>
</div>