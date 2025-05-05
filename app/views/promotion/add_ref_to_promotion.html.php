<?php

use App\Enums\Routes;

?>

<section class="content">
  <h2 style="padding: 1rem;">Gérer les référentiels pour <?= htmlspecialchars($promotion['nom_promotion']) ?></h2>

  <div class="dual-list">
    <!-- Zone GAUCHE -->
    <div class="list available">
      <h3>Référentiels disponibles</h3>
      <?php foreach ($available as $ref): ?>
        <form method="post" action="<?= Routes::PROMOTION->resolve() ?>?action=toggle-ref-promo">
          <input type="hidden" name="referentiel" value="<?= htmlspecialchars($ref['nom_referentiel']) ?>">
          <input type="hidden" name="operation" value="add">
          <label>
            <input type="checkbox" onchange="this.form.submit()" <?= $isFinished ? 'disabled' : '' ?>>
            <?= htmlspecialchars($ref['nom_referentiel']) ?>
          </label>
        </form>
      <?php endforeach; ?>
    </div>

    <!-- Zone DROITE -->
    <div class="list added">
      <h3>Référentiels dans la promotion</h3>
      <?php foreach ($added as $ref): ?>
        <?php
          $disabled = $isFinished ? 'disabled' : '';
          if (($ref['nb_apprenants'] ?? 0) > 0) {
              $disabled = 'disabled';
          }
        ?>
        <form method="post" action="<?= Routes::PROMOTION->resolve() ?>?action=toggle-ref-promo">
          <input type="hidden" name="referentiel" value="<?= htmlspecialchars($ref['nom_referentiel']) ?>">
          <input type="hidden" name="operation" value="remove">
          <label>
            <input type="checkbox" onchange="this.form.submit()" checked <?= $disabled ?>>
            <?= htmlspecialchars($ref['nom_referentiel']) ?>
          </label>
        </form>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="form-actions">
    <a href="<?= Routes::PROMOTION->resolve() ?>?action=list-ref-promo" class="btn btn-primary">Terminer</a>
  </div>

</section>
