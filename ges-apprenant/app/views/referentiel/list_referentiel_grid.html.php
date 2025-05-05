<?php
// Définition des variables pour le layout

use App\Enums\Routes;

$title = 'Promotion';

?>

      <!-- Section de contenu -->
      <section class="content">
          <div class="content-container view-grid">
          <div class="fixed-section">
            <div class="content-header">
              <div class="">
                <h1>Tous les referentiels</h1>
                <p>Liste complete des referentiels de formation.</p>
              </div>
             
              <!-- <a href="<?= Routes::PROMOTION->resolve() ?>?action=add" class="add-promo-btn">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                >
                  <path
                    fill=""
                    d="M13 6a1 1 0 1 0-2 0v5H6a1 1 0 1 0 0 2h5v5a1 1 0 1 0 2 0v-5h5a1 1 0 1 0 0-2h-5z"
                  />
                </svg>
                Ajouter une promotion
              </a> -->
            </div>

            <div class="contents-cards-bar">
              <form action="" method="get">
              <div class="search-box">
                <span>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                    <g class="search-outline">
                      <g
                        fill=""
                        fill-rule="evenodd"
                        class="Vector"
                        clip-rule="evenodd"
                      >
                        <path
                          d="M11 17a6 6 0 1 0 0-12a6 6 0 0 0 0 12m0 2a8 8 0 1 0 0-16a8 8 0 0 0 0 16"
                        />
                        <path
                          d="M15.32 15.29a1 1 0 0 1 1.414.005l3.975 4a1 1 0 0 1-1.418 1.41l-3.975-4a1 1 0 0 1 .004-1.414Z"
                        />
                      </g>
                    </g>
                  </svg>
                </span>
                <input type="text" name="search" placeholder="Rechercher un referentiel" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
              </div>
              <!-- <div class="select-box">
                <select name="filter">
                  <option value="">Tous</option>
                  <option value="active" <?= (($_GET['filter'] ?? '') === 'active') ? 'selected' : '' ?>>Active</option>
                  <option value="inactive" <?= (($_GET['filter'] ?? '') === 'inactive') ? 'selected' : '' ?>>Inactive</option>
                </select> -->
              </div>
              <button type="submit" style="padding: 1rem; background-color: rgba(2,147,143,1);border-radius: 5px;"> Rechercher</button>
              </form>
              <a href="<?= Routes::REFERENTIEL->resolve() ?>?action=add-referentiel" class="add-ref">+ Créer un referentiel</a>
            </div>
            </div>
           
          
            <div class="scroll-section">
                <!-- Liste des référentiels -->
              <div class="referentiel-grid">
                <!-- Card 1 -->
                <?php foreach ($referentiels as $ref): ?>
                
                <div class="referentiel-card">
                  <img src="<?= $ref['photo'] ?? '../assets/images/img-ref-dev-web-mobile.jpg'?>" alt="Développement web/mobile" class="referentiel-img">
                  <div class="card-body">
                    <h3 class="referentiel-title"><?= $ref['nom_referentiel'] ?></h3>
                    <p class="referentiel-modules"><?= $ref['nb_modules'] ?>modules</p>
                    <p class="referentiel-desc"><?= $ref['description'] ?></p>
                    <div class="line-sep"></div>
                    <div class="referentiel-footer">
                      <div class="box-images">
                        <div class="circle"><img src="" alt=""></div>
                        <div class="circle"><img src="" alt=""></div>
                        <div class="circle"><img src="" alt=""></div>
                      </div>
                      <span class="apprenants-count"><?= $ref['nb_apprenants'] ?> apprenants</span>
                    </div>
                  </div>
                </div>
                <?php  endforeach; ?>
              </div>

               <!-- Pagination -->
           <!-- Pagination -->
              <div class="pagination">
                <div class="page-info">
                    Affichage de <?= ($page - 1) * $limit + 1 ?> à <?= min($page * $limit, $total) ?> sur <?= $total ?> référentiels
                </div>
                <div class="page-nav">
                    <?php if ($page > 1): ?>
                        <a href="<?= Routes::REFERENTIEL->resolve() ?>?action=list&page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>&limit=<?= $limit ?>&view=<?= $view ?>" class="page-btn">Précédent</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <a href="<?= Routes::REFERENTIEL->resolve() ?>?action=list&page=<?= $i ?>&search=<?= urlencode($search) ?>&limit=<?= $limit ?>&view=<?= $view ?>" class="page-btn <?= $i === $page ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $pages): ?>
                        <a href="<?= Routes::REFERENTIEL->resolve() ?>?action=list&page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>&limit=<?= $limit ?>&view=<?= $view ?>" class="page-btn">Suivant</a>
                    <?php endif; ?>
                </div>
              </div>


            </div>
            
            
      </section>

<?php
// Fin de capture et passage au layout
//$content = ob_get_clean();
//include __DIR__ . './../layout/grid.layout.php';
?>