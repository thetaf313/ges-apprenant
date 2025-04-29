<!-- Section de contenu -->
<section class="content">
  <div id="add-promo-content-container" class="content-container view-grid">

    <div class="add-promo-form-container">
      <h2>Créer une nouvelle promotion</h2>
      <p class="description">
        Remplissez les informations ci-dessous pour créer une nouvelle promotion.
      </p>

      <form class="promotion-form" action="/promotion?action=save" method="post" enctype="multipart/form-data">
        <!-- Nom de la promotion -->
        <label for="nom">Nom de la promotion</label>
        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($old['nom'] ?? '') ?>" placeholder="Ex: Promotion 2025" />
        <?php if (!empty($errors['nom'])): ?>
          <div class="input-error"><?= $errors['nom'] ?></div>
        <?php endif; ?>

        <!-- Dates -->
        <div class="date-group">
          <div>
            <label for="date_debut">Date de début</label>
            <input type="text" name="date_debut" placeholder="jj/mm/aaaa" value="<?= htmlspecialchars($old['date_debut'] ?? '') ?>">
            <?php if (!empty($errors['date_debut'])): ?>
              <div class="input-error"><?= $errors['date_debut'] ?></div>
            <?php endif; ?>
          </div>
          <div>
            <label for="date_fin">Date de fin</label>
            <input type="text" name="date_fin" placeholder="jj/mm/aaaa" value="<?= htmlspecialchars($old['date_fin'] ?? '') ?>">
            <?php if (!empty($errors['date_fin'])): ?>
              <div class="input-error"><?= $errors['date_fin'] ?></div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Image -->
        <div class="upload-section">
          <label for="photo">Photo de la promotion</label>
          <div class="box">
            <div class="upload-box">
              <span><strong>Ajouter</strong><br>ou glisser</span>
              <input type="file" name="photo" accept=".jpg,.jpeg,.png">
            </div>
            <p class="file-info">Format JPG, PNG. Taille max 2MB</p>
          </div>
         
          <?php if (!empty($errors['photo'])): ?>
            <div class="input-error"><?= $errors['photo'] ?></div>
          <?php endif; ?>
        </div>

        <!-- Référentiels -->
        <label for="referentiels">Référentiels :</label>
        <select name="referentiels[]" id="referentiels" multiple>
            <option value="" disabled>-- Choisir les référentiels --</option>
            <?php foreach ($referentiels as $ref): ?>
                <?php
                    $refNom = $ref['nom_referentiel'];
                    $selected = isset($_POST['referentiels']) && in_array($refNom, $_POST['referentiels']) ? 'selected' : '';
                ?>
                <option value="<?= htmlspecialchars($refNom) ?>" <?= $selected ?>>
                    <?= htmlspecialchars(ucfirst($refNom)) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['referentiels'])): ?>
            <div class="input-error"><?= $errors['referentiels'] ?></div>
        <?php endif; ?>

        <!-- Boutons -->
        <div class="form-buttons">
          <button type="button" class="btn-cancel">Annuler</button>
          <button type="submit" class="btn-submit">Créer la promotion</button>
        </div>
      </form>
    </div>

  </div>
</section>
