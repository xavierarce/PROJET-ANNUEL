<?php if (!isset($room) || !is_object($room)) return; ?>

<div id="editRoomModal" class="modal-overlay" style="display: none;">
  <div class="modal">
    <h3>Modifier le salon</h3>
    <form method="post" action="index.php?action=updateRoom&id=<?= $room->id ?>">
      <div class="form-group">
        <label for="new_name">Nom du salon :</label>
        <input type="text" id="new_name" name="new_name" value="<?= htmlspecialchars($room->name) ?>" required />
      </div>

      <div class="form-group">
        <label for="is_private">Salon privé :</label>
        <select id="is_private" name="is_private">
          <option value="0" <?= !$room->is_private ? 'selected' : '' ?>>Non</option>
          <option value="1" <?= $room->is_private ? 'selected' : '' ?>>Oui</option>
        </select>
      </div>

      <div class="modal-actions">
        <button type="submit" class="button">Enregistrer</button>
        <button type="button" class="button-cancel" id="closeModal">Annuler</button>
      </div>
    </form>
  </div>
</div>