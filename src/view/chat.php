<?php require __DIR__ . '/partials/header.php'; ?>

<?php if (!isset($room) || !is_object($room)): ?>
<div class="error">Erreur : Aucune salle trouvée.</div>
<?php return; ?>
<?php endif; ?>

<div class="container chat-container">
  <h2>Salon: <?= htmlspecialchars($room->name) ?></h2>

  <div class="messages">
    <?php foreach ($messages as $msg): ?>
    <div class="message">
      <b><?= htmlspecialchars($msg['pseudo']) ?>:</b>
      <span class="msg-text"><?= htmlspecialchars($msg['message']) ?></span>
      <i class="msg-time">(<?= $msg['timestamp'] ?>)</i>
    </div>
    <?php endforeach; ?>
  </div>

  <form method="post" action="index.php?action=sendMessage&id=<?= $room->id ?>" class="chat-form">
    <input name="message" placeholder="Votre message..." required autocomplete="off" />
    <button class="button" type="submit">Envoyer</button>
  </form>

  <a href="index.php?action=rooms" class="link-back">← Retour aux salons</a>
</div>

<script>
const roomId = <?= json_encode($room->id) ?>;
const userPseudo = <?= json_encode($_SESSION['user']['pseudo']) ?>;
</script>
<script src="/public/script.js"></script>