<?php require __DIR__ . '/partials/header.php'; ?>

<div class="container">
  <h2>Créer un nouveau Room</h2>
  <form method="post">
    <div class="form-group">
      <input type="text" name="name" placeholder="Nom du Room" required>
    </div>
    <div class="form-group">
      <input type="text" name="topic" placeholder="Topic (optionnel)">
    </div>
    <div class="form-group checkbox-group">
      <label class="checkbox-label">
        <input type="checkbox" name="is_private" value="1" id="is_private_checkbox"> Privé
      </label>
    </div>

    <div class="form-group" id="password_group" style="display: none;">
      <input type="password" name="password" placeholder="Mot de passe du salon">
    </div>

    <div class="form-group checkbox-group">
      <label class="checkbox-label">
        <!-- Hidden input sends visible=1 by default -->
        <input type="hidden" name="is_visible" value="1" />
        <!-- Checkbox sends visible=0 (hidden) when checked -->
        <input type="checkbox" name="is_visible" value="0"> Caché
      </label>
    </div>
    <button class="button" type="submit" data-loading-text="Création...">Créer</button>

    <?php if (!empty($error)) echo '<div class="error">' . htmlspecialchars($error) . '</div>'; ?>
    <?php if (!empty($success)) echo '<div class="success">' . htmlspecialchars($success) . '</div>'; ?>
  </form>

  <a href="index.php?action=rooms" class="link-back">← Retour aux rooms</a>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const privateCheckbox = document.getElementById('is_private_checkbox');
    const passwordGroup = document.getElementById('password_group');

    function togglePasswordField() {
      passwordGroup.style.display = privateCheckbox.checked ? 'block' : 'none';
    }

    privateCheckbox.addEventListener('change', togglePasswordField);
    togglePasswordField();
  });
</script>