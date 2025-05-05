<?php
use App\Enums\Routes;

?>
<section class="content">
  <div id="add-ref-content-container" class="content-container">

    <div class="add-ref-form-container">
      <h2>Créer un nouveau référentiel</h2>

      <form class="referentiel-form" action="<?= Routes::REFERENTIEL->resolve() ?>?action=save-referentiel" method="post" enctype="multipart/form-data">
        
        <!-- Image Upload -->
        <div class="upload-section">
          <label for="photo" class="upload-box">
            <span>Cliquez pour ajouter une photo</span>
            <input type="file" name="photo" accept=".jpg,.jpeg,.png">
          </label>
        </div>

        <!-- Nom -->
        <label for="nom">Nom*</label>
        <input type="text" id="nom" name="nom" placeholder="Nom du référentiel" value="<?= htmlspecialchars($old['nom'] ?? '') ?>">
        <?php

 if (!empty($errors['nom'])): ?>
          <div class="input-error"><?= $errors['nom'] ?></div>
        <?php endif; ?>

        <!-- Description -->
        <label for="description">Description</label>
        <textarea id="description" name="description" placeholder="Description du référentiel"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>

        <!-- Capacité -->
        <div class="inline-fields">
          <div>
            <label for="capacite">Capacité*</label>
            <input type="number" id="capacite" name="capacite" value="<?= htmlspecialchars($old['capacite'] ?? '30') ?>">
            <?php if (!empty($errors['capacite'])): ?>
              <div class="input-error"><?= $errors['capacite'] ?></div>
            <?php endif; ?>
          </div>

          <!-- Nombre de sessions -->
          <div>
            <label for="nb_sessions">Nombre de sessions*</label>
            <select name="nb_sessions" id="nb_sessions">
              <?php foreach (range(1, 5) as $n): ?>
                <option value="<?= $n ?>" <?= (isset($old['nb_sessions']) && $old['nb_sessions'] == $n) ? 'selected' : '' ?>>
                  <?= $n ?> session<?= $n > 1 ? 's' : '' ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <!-- Boutons -->
        <div class="form-buttons">
          <a href="<?= Routes::REFERENTIEL->resolve() ?>" class="btn-cancel">Annuler</a>
          <button type="submit" class="btn-submit">Créer</button>
        </div>

      </form>
    </div>

  </div>
</section>
