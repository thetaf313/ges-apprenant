<div class="modal">
    <div class="modal-content form-style">
      <div class="form-container">
        <h2>Créer une nouvelle promotion</h2>
        <p class="description">
          Remplissez les informations ci-dessous pour créer une nouvelle
          promotion.
        </p>

        <!-- Bouton de fermeture -->
        <label for="modal-toggle" class="close-btn">✕</label>

        <form action="/promotion?action=add" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="nom">Nom de la promotion</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($old['nom'] ?? '') ?>" placeholder="Ex: Promotion 2025" />
            <?php if (!empty($errors['nom'])): ?>
              <span class="error-input"><?= $errors['nom'] ?></span>
            <?php endif; ?>
          </div>

          <div class="date-group" style="display: flex; gap: 1rem">
            <div style="flex: 1">
              <label for="debut">Date de début</label>
              <div class="input-box">
                <input
                  type="text"
                  id="debut"
                  name="debut"
                  placeholder="jj/mm/aaaa"
                  value="<?= htmlspecialchars($old['debut'] ?? '') ?>"
                />
                <!-- icône -->
                <svg ...>...</svg>
              </div>
              <?php if (!empty($errors['debut'])): ?>
                <span class="error-input"><?= $errors['debut'] ?></span>
              <?php endif; ?>
            </div>
            <div style="flex: 1">
              <label for="fin">Date de fin</label>
              <div class="input-box">
                <input
                  type="text"
                  id="fin"
                  name="fin"
                  placeholder="jj/mm/aaaa"
                  value="<?= htmlspecialchars($old['fin'] ?? '') ?>"
                />
                <!-- icône -->
                <svg ...>...</svg>
              </div>
              <?php if (!empty($errors['fin'])): ?>
                <span class="error-input"><?= $errors['fin'] ?></span>
              <?php endif; ?>
            </div>
          </div>

          <div class="form-group">
            <label for="photo">Photo de la promotion</label>
            <div class="input-box">
              <div class="upload-box <?= !empty($old['photo']) ? 'uploaded' : '' ?>">
                <span><strong>Ajouter</strong> ou glisser</span>
                <input
                  type="file"
                  id="photo"
                  name="photo"
                  accept="image/png, image/jpeg"
                />
              </div>
              <span>Format JPG, PNG. Taille max 2MB</span>
            </div>
            <?php if (!empty($errors['photo'])): ?>
              <span class="error-input"><?= $errors['photo'] ?></span>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="referentiel">Référentiels</label>
            <div class="search-referentiel">
              <svg ...>...</svg>
              <input
                type="text"
                id="referentiel"
                name="referentiel"
                value="<?= htmlspecialchars($old['referentiel'] ?? '') ?>"
                placeholder="Rechercher un référentiel..."
              />
            </div>
            <?php if (!empty($errors['referentiel'])): ?>
              <span class="error-input"><?= $errors['referentiel'] ?></span>
            <?php endif; ?>
          </div>

          <div class="actions">
            <label for="modal-toggle" class="cancel">Annuler</label>
            <button type="submit" class="submit">Créer la promotion</button>
          </div>
        </form>
      </div>
    </div>
  </div>