<?php

use App\Enums\Routes;
?>

<section class="content">
  <div class="content-container view-grid" id="add-apprenants">

    <h2 class="main-title">Ajouter des apprenants</h2>

    <div class="two-columns">

      <!-- 🔹 Partie 1 — Import CSV -->
      <div class="import-section">
        <h3>Inscrire une liste d'apprenants</h3>
        <form action="<?= Routes::APPRENANT->resolve() ?>?action=import" method="POST" enctype="multipart/form-data">
          <input type="file" name="csv_file" accept=".csv" />
          <button type="submit" class="btn-submit">Importer la liste</button>
        </form>
      </div>

      <!-- 🔹 Partie 2 — Ajouter manuellement -->
      <div class="manual-section">
        <h3>Ajouter apprenant</h3>
        <form action="<?= Routes::APPRENANT->resolve() ?>?action=register" method="POST" enctype="multipart/form-data">
          <fieldset>
            <legend>Informations de l’apprenant</legend>
            <input type="text" name="prenom" placeholder="Prénom" />
            <input type="text" name="nom" placeholder="Nom" />
            <input type="text" name="lieu_naissance" placeholder="Lieu de naissance" />
            <input type="date" name="date_naissance" placeholder="jj/mm/aaaa" />
            <input type="text" name="adresse" placeholder="Adresse" />
            <input type="email" name="email" placeholder="Email" />
            <input type="text" name="telephone" placeholder="Téléphone" />
            <label>Ajouter des documents :</label>
            <input type="file" name="documents[]" multiple />
          </fieldset>

          <fieldset>
            <legend>Informations du tuteur</legend>
            <input type="text" name="tuteur_nom" placeholder="Prénom(s) & nom" />
            <input type="text" name="lien_parente" placeholder="Lien de parenté" />
            <input type="text" name="tuteur_adresse" placeholder="Adresse" />
            <input type="text" name="tuteur_telephone" placeholder="Téléphone" />
          </fieldset>

          <div class="form-buttons">
            <a href="<?= Routes::APPRENANT->resolve() ?>" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-submit">Enregistrer</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</section>


<!-- <section class="content">
  <div class="content-container view-grid">
    <div class="import-form-container">
      <h2>Inscrire des apprenants</h2>
      <p>Veuillez sélectionner un fichier CSV au bon format.</p>

      <form method="POST" action="<?= Routes::APPRENANT->resolve() ?>?action=import" enctype="multipart/form-data">
        <input type="file" name="csv_file" accept=".csv">
        <div class="form-buttons">
          <a href="<?= Routes::APPRENANT->resolve() ?>" class="btn-cancel">Annuler</a>
          <button type="submit" class="btn-submit">Importer</button>
        </div>
      </form>
    </div>
  </div>
</section> -->
