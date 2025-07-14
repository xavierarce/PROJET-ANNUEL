<?php if (!isset($room) || !is_object($room)) return; ?>

<div id="editRoomModal" class="modal-overlay" style="display: none;">
  <div class="modal">
    <h3>Modifier le salon</h3>
    <form method="post" action="index.php?action=updateRoom&id=<?= $room->id ?>">
      <div class="form-group">
        <label for="new_name">Nom du salon :</label>
        <input type="text" id="new_name" name="new_name" value="<?= htmlspecialchars($room->name) ?>" required />
      </div>

      <div class="form-group checkbox-group">
        <label class="checkbox-label">
          <input type="checkbox" name="is_private" value="1" <?= $room->is_private ? 'checked' : '' ?>> Privé
        </label>
      </div>
      <div class="form-group checkbox-group">
        <label class="checkbox-label">
          <!-- Hidden input to send default visible = 1 -->
          <input type="hidden" name="is_visible" value="1" />
          <!-- Checkbox sends hidden = 0 if checked -->
          <input type="checkbox" name="is_visible" value="0" <?= !$room->is_visible ? 'checked' : '' ?>> Caché
        </label>
      </div>

      <div class="modal-actions">
        <button type="submit" class="button">Enregistrer</button>
        <button type="button" class="button-cancel" id="closeModal">Annuler</button>
      </div>
    </form>
  </div>
</div>