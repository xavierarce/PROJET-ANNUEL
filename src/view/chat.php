<?php require __DIR__ . '/partials/header.php'; ?>
<?php require __DIR__ . '/partials/edit-room-modal.php'; ?>

<?php if (!isset($room) || !is_object($room)): ?>
  <div class="error">Erreur : Aucune salle trouvée.</div>
  <?php return; ?>
<?php endif; ?>

<div class="container chat-container">
  <div class="room-header">
    <h2 class="room-title">
      Salon: <?= htmlspecialchars($room->name) ?>
    </h2>
    <div class="edit-room-wrapper">
      <button class="edit-room-icon" id="editRoomBtn" title="Modifier le salon">✏️</button>
    </div>
  </div>



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
    <button class="button" type="submit" data-loading-text="Envoi...">Envoyer</button>
  </form>

  <a href="index.php?action=rooms" class="link-back">← Retour aux salons</a>
</div>

<script>
  const roomId = <?= json_encode($room->id) ?>;
  const userPseudo = <?= json_encode($_SESSION['user']['pseudo']) ?>;

  // Enhanced chat form handling
  document.addEventListener('DOMContentLoaded', function() {
    const chatForm = document.querySelector('.chat-form');
    const messageInput = chatForm.querySelector('input[name="message"]');

    chatForm.addEventListener('submit', function(e) {
      // Clear the input immediately for better UX
      setTimeout(() => {
        messageInput.value = '';
      }, 100);
    });
  });
</script>
<script src="/js/script.js"></script>
<script src="/js/modal.js"></script>