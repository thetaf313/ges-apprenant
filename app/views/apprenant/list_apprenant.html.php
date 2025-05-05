<?php

use App\Enums\Routes;
?>

    <!-- Section de contenu -->
    <section id="list-apprenants" class="content view-list">
          <div class="content-container view-list">
            <div class="content-header">
              <div class="title">
                <h1>Promotion</h1>
                <p><?= $stats['num_apprenants'] ?> apprenants</p>
              </div>
            </div>
            <div class="promo-content-list-bar">
              <div class="search-filter-bar contents-cards-bar">
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
                    <input type="text" name="search" placeholder="Rechercher un apprenant" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                  </div>
                  <!-- Recuperer les referentiels de la promotion en cours et les lister avec un foraech -->
                  <select name="filter_ref" id="">
                      <option value="">Filtre par classe</option>
                      <option value="developpement web/mobile">Dev Web/Mobile</option>
                      <option value="developpement data">Dev Data</option>
                      <option value="referent digital">Ref Dig</option>
                      <option value="assistant digital">Hackeuse</option>
                      <option value="aws & devops">AWS & DevOps</option>
                    </select>
                  <div class="select-box">
                    <select name="filter_status">
                      <option value="">Tous</option>
                      <option value="actif" <?= (($_GET['filter_status'] ?? '') === 'actif') ? 'selected' : '' ?>>Actif</option>
                      <option value="remplace" <?= (($_GET['filter_status'] ?? '') === 'remplace') ? 'selected' : '' ?>>Remplace</option>
                    </select>
                    <input type="hidden" name="view" value="list" />
                  </div>
                  <button type="submit">Rechercher</button>
                </form>
        
              </div>
              
            </div>
            <div class="promo-content-list-bar">
              <div class="search-filter-bar contents-cards-bar">
                <a href="<?= Routes::APPRENANT->resolve() ?>?action=add-list-apprenants">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 1024 1024"
                    >
                      <path
                        fill=""
                        d="M678.3 642.4c24.2-13 51.9-20.4 81.4-20.4h.1c3 0 4.4-3.6 2.2-5.6a371.7 371.7 0 0 0-103.7-65.8c-.4-.2-.8-.3-1.2-.5C719.2 505 759.6 431.7 759.6 349c0-137-110.8-248-247.5-248S264.7 212 264.7 349c0 82.7 40.4 156 102.6 201.1c-.4.2-.8.3-1.2.5c-44.7 18.9-84.8 46-119.3 80.6a373.4 373.4 0 0 0-80.4 119.5A373.6 373.6 0 0 0 137 888.8a8 8 0 0 0 8 8.2h59.9c4.3 0 7.9-3.5 8-7.8c2-77.2 32.9-149.5 87.6-204.3C357 628.2 432.2 597 512.2 597c56.7 0 111.1 15.7 158 45.1a8.1 8.1 0 0 0 8.1.3M512.2 521c-45.8 0-88.9-17.9-121.4-50.4A171.2 171.2 0 0 1 340.5 349c0-45.9 17.9-89.1 50.3-121.6S466.3 177 512.2 177s88.9 17.9 121.4 50.4A171.2 171.2 0 0 1 683.9 349c0 45.9-17.9 89.1-50.3 121.6C601.1 503.1 558 521 512.2 521M880 759h-84v-84c0-4.4-3.6-8-8-8h-56c-4.4 0-8 3.6-8 8v84h-84c-4.4 0-8 3.6-8 8v56c0 4.4 3.6 8 8 8h84v84c0 4.4 3.6 8 8 8h56c4.4 0 8-3.6 8-8v-84h84c4.4 0 8-3.6 8-8v-56c0-4.4-3.6-8-8-8"
                      />
                    </svg>
                    Ajouter un apprenant</a
                  >
                
                  <div class="export-section">
                      <form method="get" action="<?= Routes::APPRENANT->resolve() ?>">
                        <!-- Input caché pour l'action d'export -->
                        <input type="hidden" name="action" value="export">
                        
                        <!-- Select avec les options d'export et soumission automatique -->
                        <select name="type" id="export-type" onchange="if(this.value !== '') this.form.submit();">
                          <option value="" disabled selected>Telecharger</option>
                          <option value="pdf">PDF</option>
                          <option value="excel">Excel</option>
                        </select>
                      </form>
                  </div>
                </div>
            </div>
            <div class="tab-bar">
              <div class="tab active">
                <a href="<?= Routes::APPRENANT->resolve() ?>">Liste des retenues</a>
              </div>
              <div class="tab">
                <a href="<?= Routes::APPRENANT->resolve() ?>?action=stand-by-list">Liste d'attente</a>
              </div>
            </div>

            <!-- <div class="stat-cards-container view-list">
              <div class="stat-card">
                <div class="stat-info">
                  <h1><?= $stats['num_apprenants'] ?? 0 ?></h1>
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
                      d="m12 18.692l-6-3.261v-4.846L3.077 9L12 4.154L20.923 9v6.385h-1V9.562L18 10.585v4.846zm0-5.992L18.83 9L12 5.3L5.17 9zm0 4.852l5-2.7v-3.717l-5 2.708l-5-2.708v3.717zm0-3.487"
                    />
                  </svg>
                </div>
              </div>

              <div class="stat-card">
                <div class="stat-info">
                  <h1><?= $stats['num_referentiels'] ?? 0 ?></h1>
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
                      d="M2 4.75C2 3.784 2.784 3 3.75 3h4.971c.58 0 1.12.286 1.447.765l1.404 2.063a.25.25 0 0 0 .207.11h6.224c.966 0 1.75.783 1.75 1.75v.117H5.408a.848.848 0 0 0 0 1.695h15.484a1 1 0 0 1 .995 1.102L21 19.25c-.106 1.05-.784 1.75-1.75 1.75H3.75A1.75 1.75 0 0 1 2 19.25z"
                    />
                  </svg>
                </div>
              </div>

              <div class="stat-card">
                <div class="stat-info">
                  <h1>5</h1>
                  <p>Stagiaires</p>
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
                      d="M7.752.066a.5.5 0 0 1 .496 0l3.75 2.143a.5.5 0 0 1 .252.434v3.995l3.498 2A.5.5 0 0 1 16 9.07v4.286a.5.5 0 0 1-.252.434l-3.75 2.143a.5.5 0 0 1-.496 0l-3.502-2l-3.502 2.001a.5.5 0 0 1-.496 0l-3.75-2.143A.5.5 0 0 1 0 13.357V9.071a.5.5 0 0 1 .252-.434L3.75 6.638V2.643a.5.5 0 0 1 .252-.434zM4.25 7.504L1.508 9.071l2.742 1.567l2.742-1.567zM7.5 9.933l-2.75 1.571v3.134l2.75-1.571zm1 3.134l2.75 1.571v-3.134L8.5 9.933zm.508-3.996l2.742 1.567l2.742-1.567l-2.742-1.567zm2.242-2.433V3.504L8.5 5.076V8.21zM7.5 8.21V5.076L4.75 3.504v3.134zM5.258 2.643L8 4.21l2.742-1.567L8 1.076zM15 9.933l-2.75 1.571v3.134L15 13.067zM3.75 14.638v-3.134L1 9.933v3.134z"
                    />
                  </svg>
                </div>
              </div>

              <div class="stat-card">
                <div class="stat-info">
                  <h1>13</h1>
                  <p>Permanents</p>
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
                      d="M2 3v-.75a.75.75 0 0 0-.75.75zm11 0h.75a.75.75 0 0 0-.75-.75zm0 6v-.75a.75.75 0 0 0-.75.75zM2 3.75h11v-1.5H2zM12.25 3v16h1.5V3zm-9.5 14V3h-1.5v14zM13 9.75h5v-1.5h-5zM21.25 13v4h1.5v-4zm-7.5 6V9h-1.5v10zm5.134.884a1.25 1.25 0 0 1-1.768 0l-1.06 1.06a2.75 2.75 0 0 0 3.889 0zm-1.768-1.768a1.25 1.25 0 0 1 1.768 0l1.06-1.06a2.75 2.75 0 0 0-3.889 0zM6.884 19.884a1.25 1.25 0 0 1-1.768 0l-1.06 1.06a2.75 2.75 0 0 0 3.889 0zm-1.768-1.768a1.25 1.25 0 0 1 1.768 0l1.06-1.06a2.75 2.75 0 0 0-3.889 0zm13.768 0c.244.244.366.563.366.884h1.5c0-.703-.269-1.408-.805-1.945zm.366.884c0 .321-.122.64-.366.884l1.06 1.06A2.74 2.74 0 0 0 20.75 19zM16 18.25h-3v1.5h3zm1.116 1.634A1.24 1.24 0 0 1 16.75 19h-1.5c0 .703.269 1.408.805 1.945zM16.75 19c0-.321.122-.64.366-.884l-1.06-1.06A2.74 2.74 0 0 0 15.25 19zm-11.634.884A1.24 1.24 0 0 1 4.75 19h-1.5c0 .703.269 1.408.805 1.945zM4.75 19c0-.321.122-.64.366-.884l-1.06-1.06A2.74 2.74 0 0 0 3.25 19zm8.25-.75H8v1.5h5zm-6.116-.134c.244.244.366.563.366.884h1.5c0-.703-.269-1.408-.805-1.945zM7.25 19c0 .321-.122.64-.366.884l1.06 1.06A2.74 2.74 0 0 0 8.75 19zm14-2c0 .69-.56 1.25-1.25 1.25v1.5A2.75 2.75 0 0 0 22.75 17zM18 9.75A3.25 3.25 0 0 1 21.25 13h1.5A4.75 4.75 0 0 0 18 8.25zM1.25 17A2.75 2.75 0 0 0 4 19.75v-1.5c-.69 0-1.25-.56-1.25-1.25z"
                    />
                  </svg>
                </div>
              </div>
            </div> -->

            <div class="table-container">
              <table class="promo-table">
                <thead>
                  <tr>
                    <th>Photo</th>
                    <th>Matricule</th>
                    <th>Nom Complet</th>
                    <th>Adresse</th>
                    <th>Telephone</th>
                    <th>Referentiel</th>
                    <th>Statut</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                <?php if (isset($apprenants) && is_array($apprenants)): ?>
                  <?php foreach ($apprenants as $apprenant): ?>
                    <!-- Ligne pour chaque apprenant -->
                    <tr>
                      <td>
                        <img
                          src="<?= isset($apprenant['photo']) ? htmlspecialchars($apprenant['photo']) : '' ?>"
                          class="promo-img"
                          alt="Photo de l'apprenant"
                        />
                      </td>
                      <td><?= isset($apprenant['matricule']) ? htmlspecialchars($apprenant['matricule']) : '' ?></td>
                      <td><?= (isset($apprenant['prenom']) ? htmlspecialchars($apprenant['prenom']) : '') . ' ' . (isset($apprenant['nom']) ? htmlspecialchars($apprenant['nom']) : '') ?></td>
                      <td><?= isset($apprenant['adresse']) ? htmlspecialchars($apprenant['adresse']) : '' ?></td>
                      <td><?= isset($apprenant['telephone']) ? htmlspecialchars($apprenant['telephone']) : '' ?></td>
                      <td>
                        <?php if (isset($apprenant['referentiel'])): ?>
                          <?php 
                            $referentiel = htmlspecialchars($apprenant['referentiel']);
                            if ($referentiel === 'developpement web/mobile'): 
                              $parts = explode(' ', $referentiel);
                              $badge_text = isset($parts[0]) ? substr($parts[0], 0, 3) : 'DEV';
                              $badge_text .= isset($parts[1]) ? ' ' . $parts[1] : '';
                          ?>
                            <span class="badge green"><?= $badge_text ?></span>
                          <?php elseif ($referentiel === 'referent digital'): ?>
                            <span class="badge blue"><?= $referentiel ?></span>
                          <?php elseif ($referentiel === 'developpement data'): ?>
                            <span class="badge purple"><?= $referentiel ?></span>
                          <?php elseif ($referentiel === 'aws & devops'): ?>
                            <span class="badge orange"><?= $referentiel ?></span>
                          <?php elseif ($referentiel === 'assistant digital'): ?>
                            <span class="badge pink"><?= 'hackeuse' ?></span>
                          <?php else: ?>
                            <span class="badge gray"><?= $referentiel ?></span>
                          <?php endif; ?>
                        <?php else: ?>
                          <span class="badge gray">Non défini</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php 
                          $status = isset($apprenant['status']) ? htmlspecialchars($apprenant['status']) : 'inconnu';
                          $is_active = $status === 'active';
                        ?>
                        <span class="status <?= $is_active ? 'active' : 'inactive' ?>"><?= $status ?></span>
                      </td>
                      <td><span class="action">⋯</span></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="8" class="no-data">Aucun apprenant trouvé</td>
                  </tr>
                <?php endif; ?>
                </tbody>
              </table>

            <!-- Pagination -->
            <div class="pagination">
              <div class="page-info">
                <?php
                  $page = isset($page) ? (int)$page : 1;
                  $limit = isset($limit) ? (int)$limit : 10;
                  $total = isset($total) ? (int)$total : 0;
                  $first_item = ($page - 1) * $limit + 1;
                  $last_item = min($page * $limit, $total);
                ?>
                Affichage de <?= $first_item ?> à <?= $last_item ?> sur <?= $total ?> apprenants
              </div>
              <div class="page-nav">
                <?php 
                  $pages = isset($pages) ? (int)$pages : 1;
                  $search = isset($search) ? $search : '';
                  $view = isset($view) ? $view : 'list';
                  $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
                ?>
                <?php if ($page > 1): ?>
                  <a href="?page=<?= $page - 1 ?>&filter=<?= urlencode($filter) ?>&search=<?= urlencode($search) ?>&limit=<?= $limit ?>&view=<?= $view ?>" class="page-btn">Précédent</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $pages; $i++): ?>
                  <a href="?page=<?= $i ?>&filter=<?= urlencode($filter) ?>&search=<?= urlencode($search) ?>&limit=<?= $limit ?>&view=<?= $view ?>" class="page-btn <?= $i === $page ? 'active' : '' ?>">
                    <?= $i ?>
                  </a>
                <?php endfor; ?>

                <?php if ($page < $pages): ?>
                  <a href="?page=<?= $page + 1 ?>&filter=<?= urlencode($filter) ?>&search=<?= urlencode($search) ?>&limit=<?= $limit ?>&view=<?= $view ?>" class="page-btn">Suivant</a>
                <?php endif; ?>
              </div>
            </div>
            </div>
          </div>
        </div>
    </section>