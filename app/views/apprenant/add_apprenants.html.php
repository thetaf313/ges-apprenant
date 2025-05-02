<?php

use App\Enums\Routes;
?>

<section class="content">

  <div class="content-container view-grid" id="add-apprenant-container">
    <div class="import-form-container">

      <div class="import-section">
        <h3>Inscrire une liste d'apprenants</h3>
        <div>
          <form action="<?= Routes::APPRENANT->resolve() ?>?action=import" method="POST" enctype="multipart/form-data">
              <div class="file-upload-container">
                <input type="file" name="apprenant_file" id="docs-upload" />
                <div class="upload-content">
                  <div class="upload-icon">📁</div>
                  <div class="upload-text">Importer un fichier excel</div>
                </div>
              </div>
              <p>Veuillez sélectionner un fichier Excel au bon format.</p>
            <button type="submit" class="btn-submit">Importer la liste</button>
            <a href="<?= Routes::APPRENANT->value ?>?action=export-template">Exporter un modele</a>
          </form>
        </div>
      </div>

      <div class="manual-section">
        <h3>Inscrire un apprenant</h3>
        <form action="<?= Routes::APPRENANT->resolve() ?>?action=register" method="POST" enctype="multipart/form-data">
          <fieldset>
            <legend>Informations de l’apprenant</legend>
            <div class="col">
              <div class="form-group">
                <label for="prenom">Prenom</label>
                <div class="field">
                  <input type="text" id="prenom" name="prenom" placeholder="Prénom" />
                  <div class="input-error">ce champ est requis</div>
                </div>
                
              </div>
              <div class="form-group">
                <label for="date_naissance">Date de naissance</label>
                <div class="field">
                  <input type="text" id="date_naissance" name="date_naissance" placeholder="jj/mm/aaaa" />
                  <div class="input-error">ce champ est requis</div>
                </div>
              </div>
              <div class="form-group">
                <label for="adresse">Adresse</label>
                <div class="field">
                  <input type="text" name="adresse" placeholder="Adresse" />
                  <div class="input-error">ce champ est requis</div>
                </div>
              </div>
              <div class="form-group">
                <label for="telephone">Telephone</label>
                <div class="field">
                  <input type="text" id="telephone" name="telephone" placeholder="Téléphone" />
                  <div class="input-error">ce champ est requis</div>
                </div>
              </div>
            </div>

            <div class="col">
            <div class="form-group">
                <label for="nom">Nom</label>
                <div class="field">
                  <input type="text" id="nom" name="nom" placeholder="Nom" />
                  <div class="input-error">ce champ est requis</div>
                </div>
              </div>
              <div class="form-group">
                <label for="lieu_naissance">Lieu de naissance</label>
                <div class="field">
                  <input type="text" name="lieu_naissance" placeholder="Lieu de naissance" />
                  <div class="input-error">ce champ est requis</div>
                </div>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <div class="field">
                  <input type="text" id="email" name="email" placeholder="Email" />
                  <div class="input-error">ce champ est requis</div>
                </div>
              </div>
              <div class="form-group">
                <label for="email">Referentiel</label>
                <div class="field">
                  <select name="referentiel" id="referentiel">
                    <option value="">developpement web/mobile</option>
                  </select>
                  <div class="input-error">ce champ est requis</div>
                </div>
              </div>
            </div>
            
            <div class="">
              <!-- <label>Ajouter des documents :</label> -->
              <div class="file-upload-container">
                <input type="file" name="documents[]" multiple id="docs-upload" />
                <div class="upload-content">
                  <div class="upload-icon">📁</div>
                  <div class="upload-text">Ajouter des documents</div>
                </div>
              </div>
            </div>
            
          </fieldset>

          <fieldset>
            <legend>Informations du tuteur</legend>
            <div class="col">
              <div class="form-group">
                <label for="tuteut_nom_complet">Prenom & Nom</label>
                <div class="field">
                  <input type="text" name="tuteur_nom" placeholder="Prénom(s) & nom" />
                  <div class="input-error">ce champ est requis</div>
                </div>
              </div>

              <div class="form-group">
                <label for="lien_parente">Lien de parente</label>
                <div class="field">
                  <input type="text" name="lien_parente" placeholder="Lien de parenté" />
                  <div class="input-error">ce champ est requis</div>
                </div>
              </div>

            </div>
            
            <div class="col">
              <div class="form-group">
                <label for="tuteur_adresse">Adresse</label>
                <div class="field">
                  <input type="text" name="tuteur_adresse" placeholder="Adresse" />
                  <div class="input-error">ce champ est requis</div>
                </div>
              </div>

              <div class="form-group">
                <label for="tuteur_telephone">Telephone</label>
                <div class="field">
                  <input type="text" name="tuteur_telephone" placeholder="Téléphone" />
                  <div class="input-error">ce champ est requis</div>
                </div>
              </div>
            </div>
            
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
