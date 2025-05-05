<?php
  use App\Enums\Routes;
?>

<!-- Section de contenu -->
<section class="content">
          <div class="content-container view-list">
            <div class="fixed-section">
            <div class="content-header">
              <div class="">
                <h1>Référentiel</h1>
                <p>Gérer les référentiels de la promotion.</p>
              </div>
            </div>


            <div class="contents-cards-bar referentiel">
              <!-- <div class="search-box">
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
                <input type="text" placeholder="Rechercher..." />
              </div> -->
              <form action="<?= Routes::REFERENTIEL->resolve() ?>?action=list-ref-promo&search=<?= $_GET['search'] ?? '' ?>" method="get">
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
              <button type="submit">Rechercher</button>
              </form>
              <div class="all-ref-btn">
                <a href="<?= Routes::REFERENTIEL->resolve() ?>">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                    <path
                      fill=""
                      d="M3 18.5V5a3 3 0 0 1 3-3h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5A3.5 3.5 0 0 1 3 18.5M19 20v-3H6.5a1.5 1.5 0 0 0 0 3zM5 15.337A3.5 3.5 0 0 1 6.5 15H19V4H6a1 1 0 0 0-1 1z"
                    />
                  </svg>
                  Tous les referentiels</a
                >
              </div>
              <a href="<?= Routes::PROMOTION->resolve() ?>?action=add-referentiel" for="modal-toggle" class="add-promo-btn">
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
                Ajouter à la promotion
              </a>
            </div>

            </div>
            

            <!-- <div class="stat-cards-container">
              <div class="stat-card">
                <div class="stat-info">
                  <h1>0</h1>
                  <p>Apprenants</p>
                </div>
                <div class="stat-icon">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                    <path
                      fill=""
                      d="M10 4a4 4 0 1 0 0 8a4 4 0 0 0 0-8M4 8a6 6 0 1 1 12 0A6 6 0 0 1 4 8m12.828-4.243a1 1 0 0 1 1.415 0a6 6 0 0 1 0 8.486a1 1 0 1 1-1.415-1.415a4 4 0 0 0 0-5.656a1 1 0 0 1 0-1.415m.702 13a1 1 0 0 1 1.212-.727c1.328.332 2.169 1.18 2.652 2.148c.468.935.606 1.98.606 2.822a1 1 0 1 1-2 0c0-.657-.112-1.363-.394-1.928c-.267-.533-.677-.934-1.349-1.102a1 1 0 0 1-.727-1.212zM6.5 18C5.24 18 4 19.213 4 21a1 1 0 1 1-2 0c0-2.632 1.893-5 4.5-5h7c2.607 0 4.5 2.368 4.5 5a1 1 0 1 1-2 0c0-1.787-1.24-3-2.5-3z"
                    />
                  </svg>
                </div>
              </div>

              <div class="stat-card">
                <div class="stat-info">
                  <h1>5</h1>
                  <p>Référentiels</p>
                </div>
                <div class="stat-icon">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                    <path
                      fill=""
                      d="M3 18.5V5a3 3 0 0 1 3-3h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5A3.5 3.5 0 0 1 3 18.5M19 20v-3H6.5a1.5 1.5 0 0 0 0 3zM5 15.337A3.5 3.5 0 0 1 6.5 15H19V4H6a1 1 0 0 0-1 1z"
                    />
                  </svg>
                </div>
              </div>

              <div class="stat-card">
                <div class="stat-info">
                  <h1>1</h1>
                  <p>Promotions actives</p>
                </div>
                <div class="stat-icon">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                  >
                    <path
                      fill=""
                      d="M9 16.2L4.8 12l-1.4 1.4L9 19L21 7l-1.4-1.4z"
                    />
                  </svg>
                </div>
              </div>

              <div class="stat-card">
                <div class="stat-info">
                  <h1>5</h1>
                  <p>Total promotions</p>
                </div>
                <div class="stat-icon">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 16 16"
                  >
                    <path
                      fill=""
                      d="M0 2.75C0 1.784.784 1 1.75 1H5c.55 0 1.07.26 1.4.7l.9 1.2a.25.25 0 0 0 .2.1h6.75c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 14.25 15H1.75A1.75 1.75 0 0 1 0 13.25Zm1.75-.25a.25.25 0 0 0-.25.25v10.5c0 .138.112.25.25.25h12.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25H7.5c-.55 0-1.07-.26-1.4-.7l-.9-1.2a.25.25 0 0 0-.2-.1Z"
                    />
                  </svg>
                </div>
              </div>
            </div> -->


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
                        <a href="<?= Routes::REFERENTIEL->resolve() ?>?action=list-ref-promo&page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>&limit=<?= $limit ?>&view=<?= $view ?>" class="page-btn">Précédent</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <a href="<?= Routes::REFERENTIEL->resolve() ?>?action=list-ref-promo&page=<?= $i ?>&search=<?= urlencode($search) ?>&limit=<?= $limit ?>&view=<?= $view ?>" class="page-btn <?= $i === $page ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $pages): ?>
                        <a href="<?= Routes::REFERENTIEL->resolve() ?>?action=list-ref-promo&page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>&limit=<?= $limit ?>&view=<?= $view ?>" class="page-btn">Suivant</a>
                    <?php endif; ?>
                </div>
              </div>


            </div>
            
          </div>
        </section>