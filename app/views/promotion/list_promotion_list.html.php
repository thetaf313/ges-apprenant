<?php

use App\Enums\Routes;
?>

    <!-- Section de contenu -->
    <section class="content view-list">
          <div class="content-container view-list">
            <div class="content-header">
              <div class="title">
                <h1>Promotion</h1>
                <p><?= $stats['num_apprenants'] ?> apprenants</p>
              </div>
            </div>
            <div class="promo-content-list-bar">
              <div class="search-filter-bar contents-cards-bar">
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
                <!-- <select name="" id="">
                  <option value="0">Filtre par classe</option>
                  <option value="">Dev Web/Mobile</option>
                </select> -->
                <!-- <select name="" id="">
                  <option value="">Filtre par status</option>
                  <option value="">Active</option>
                  <option value="">Inactive</option>
                </select> -->
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
                <input type="text" name="search" placeholder="Rechercher une promotion" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
              </div>
              <div class="select-box">
                <select name="filter">
                  <option value="">Tous</option>
                  <option value="active" <?= (($_GET['filter'] ?? '') === 'active') ? 'selected' : '' ?>>Active</option>
                  <option value="inactive" <?= (($_GET['filter'] ?? '') === 'inactive') ? 'selected' : '' ?>>Inactive</option>
                </select>
                <input type="hidden" name="view" value="list" />
              </div>
              <button type="submit">Rechercher</button>
              </form>

              </div>
              <!-- <div class="add-promo">
                <a href="#">
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
                  Ajouter promotion</a
                >
              </div> -->
              <a href="<?= Routes::PROMOTION->resolve() ?>?action=add" class="add-promo-btn">
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
                Ajouter une promotion
              </a>
            </div>

            <div class="stat-cards-container view-list">
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
            </div>

            <!-- <div class="contents-cards-bar">
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
                <input type="text" placeholder="Rechercher..." />
              </div>
              <div class="select-box">
                <select>
                  <option value="">Tous</option>
                  <option value="">Tous</option>
                  <option value="">Tous</option>
                </select>
              </div>
              <div class="option-view-box">
                <div class="view grill active">
                  <a href="#">Grille</a>
                </div>
                <div class="view list">
                  <a href="#">Liste</a>
                </div>
              </div>
            </div> -->

            <!-- <div class="promotions-cards-container">
              <div class="promo-card">
                <div class="promo-header">
                  <div class="status">
                    <span class="status-text">Inactive</span>
                    <a href="#" class="status-icon">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                      >
                        <path
                          fill=""
                          d="M8.205 4.843a1 1 0 0 1 .844 1.813A6.997 6.997 0 0 0 12 20a6.998 6.998 0 0 0 2.965-13.337a1 1 0 0 1 .848-1.811A9 9 0 0 1 21 13.003C21 17.972 16.97 22 12 22s-9-4.028-9-8.997a9 9 0 0 1 5.205-8.16M12 2a1 1 0 0 1 .993.883L13 3v7a1 1 0 0 1-1.993.117L11 10V3a1 1 0 0 1 1-1"
                        />
                      </svg>
                    </a>
                  </div>
                </div>
                <div class="promo-body">
                  <img
                    src="../assets/images/img-promo-2025.jpg"
                    alt="Promotion Logo"
                    class="promo-img"
                  />
                  <div class="promo-info">
                    <h3 class="promo-title">Promotion 2025</h3>
                    <p class="promo-dates">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="12"
                        height="12"
                        viewBox="0 0 16 16"
                      >
                        <path
                          fill=""
                          d="M14.5 16h-13C.67 16 0 15.33 0 14.5v-12C0 1.67.67 1 1.5 1h13c.83 0 1.5.67 1.5 1.5v12c0 .83-.67 1.5-1.5 1.5M1.5 2c-.28 0-.5.22-.5.5v12c0 .28.22.5.5.5h13c.28 0 .5-.22.5-.5v-12c0-.28-.22-.5-.5-.5z"
                        />
                        <path
                          fill=""
                          d="M4.5 4c-.28 0-.5-.22-.5-.5v-3c0-.28.22-.5.5-.5s.5.22.5.5v3c0 .28-.22.5-.5.5m7 0c-.28 0-.5-.22-.5-.5v-3c0-.28.22-.5.5-.5s.5.22.5.5v3c0 .28-.22.5-.5.5m4 2H.5C.22 6 0 5.78 0 5.5S.22 5 .5 5h15c.28 0 .5.22.5.5s-.22.5-.5.5"
                        />
                      </svg>
                      <span>04/02/2025 - 04/12/2025</span>
                    </p>
                  </div>
                  <div class="promo-stats">
                    <span
                      ><svg
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
                    </span>
                    <span>2 apprenants</span>
                  </div>
                </div>

                <div class="promo-footer">
                  <a href="#" class="promo-link"
                    >Voir détails
                    <span
                      ><svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                      >
                        <path
                          fill=""
                          d="M10 6L8.59 7.41L13.17 12l-4.58 4.59L10 18l6-6z"
                        /></svg></span
                  ></a>
                </div>
              </div>

              <div class="promo-card">
                <div class="promo-header">
                  <div class="status">
                    <span class="status-text">Inactive</span>
                    <a href="#" class="status-icon">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                      >
                        <path
                          fill=""
                          d="M8.205 4.843a1 1 0 0 1 .844 1.813A6.997 6.997 0 0 0 12 20a6.998 6.998 0 0 0 2.965-13.337a1 1 0 0 1 .848-1.811A9 9 0 0 1 21 13.003C21 17.972 16.97 22 12 22s-9-4.028-9-8.997a9 9 0 0 1 5.205-8.16M12 2a1 1 0 0 1 .993.883L13 3v7a1 1 0 0 1-1.993.117L11 10V3a1 1 0 0 1 1-1"
                        />
                      </svg>
                    </a>
                  </div>
                </div>
                <div class="promo-body">
                  <img
                    src="../assets/images/img-promo-2025.jpg"
                    alt="Promotion Logo"
                    class="promo-img"
                  />
                  <div class="promo-info">
                    <h3 class="promo-title">Promotion 2025</h3>
                    <p class="promo-dates">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="12"
                        height="12"
                        viewBox="0 0 16 16"
                      >
                        <path
                          fill=""
                          d="M14.5 16h-13C.67 16 0 15.33 0 14.5v-12C0 1.67.67 1 1.5 1h13c.83 0 1.5.67 1.5 1.5v12c0 .83-.67 1.5-1.5 1.5M1.5 2c-.28 0-.5.22-.5.5v12c0 .28.22.5.5.5h13c.28 0 .5-.22.5-.5v-12c0-.28-.22-.5-.5-.5z"
                        />
                        <path
                          fill=""
                          d="M4.5 4c-.28 0-.5-.22-.5-.5v-3c0-.28.22-.5.5-.5s.5.22.5.5v3c0 .28-.22.5-.5.5m7 0c-.28 0-.5-.22-.5-.5v-3c0-.28.22-.5.5-.5s.5.22.5.5v3c0 .28-.22.5-.5.5m4 2H.5C.22 6 0 5.78 0 5.5S.22 5 .5 5h15c.28 0 .5.22.5.5s-.22.5-.5.5"
                        />
                      </svg>
                      <span>04/02/2025 - 04/12/2025</span>
                    </p>
                  </div>
                  <div class="promo-stats">
                    <span
                      ><svg
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
                    </span>
                    <span>2 apprenants</span>
                  </div>
                </div>

                <div class="promo-footer">
                  <a href="#" class="promo-link"
                    >Voir détails
                    <span
                      ><svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                      >
                        <path
                          fill=""
                          d="M10 6L8.59 7.41L13.17 12l-4.58 4.59L10 18l6-6z"
                        /></svg></span
                  ></a>
                </div>
              </div>

              <div class="promo-card">
                <div class="promo-header">
                  <div class="status">
                    <span class="status-text">Inactive</span>
                    <a href="#" class="status-icon">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                      >
                        <path
                          fill=""
                          d="M8.205 4.843a1 1 0 0 1 .844 1.813A6.997 6.997 0 0 0 12 20a6.998 6.998 0 0 0 2.965-13.337a1 1 0 0 1 .848-1.811A9 9 0 0 1 21 13.003C21 17.972 16.97 22 12 22s-9-4.028-9-8.997a9 9 0 0 1 5.205-8.16M12 2a1 1 0 0 1 .993.883L13 3v7a1 1 0 0 1-1.993.117L11 10V3a1 1 0 0 1 1-1"
                        />
                      </svg>
                    </a>
                  </div>
                </div>
                <div class="promo-body">
                  <img
                    src="../assets/images/img-promo-2025.jpg"
                    alt="Promotion Logo"
                    class="promo-img"
                  />
                  <div class="promo-info">
                    <h3 class="promo-title">Promotion 2025</h3>
                    <p class="promo-dates">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="12"
                        height="12"
                        viewBox="0 0 16 16"
                      >
                        <path
                          fill=""
                          d="M14.5 16h-13C.67 16 0 15.33 0 14.5v-12C0 1.67.67 1 1.5 1h13c.83 0 1.5.67 1.5 1.5v12c0 .83-.67 1.5-1.5 1.5M1.5 2c-.28 0-.5.22-.5.5v12c0 .28.22.5.5.5h13c.28 0 .5-.22.5-.5v-12c0-.28-.22-.5-.5-.5z"
                        />
                        <path
                          fill=""
                          d="M4.5 4c-.28 0-.5-.22-.5-.5v-3c0-.28.22-.5.5-.5s.5.22.5.5v3c0 .28-.22.5-.5.5m7 0c-.28 0-.5-.22-.5-.5v-3c0-.28.22-.5.5-.5s.5.22.5.5v3c0 .28-.22.5-.5.5m4 2H.5C.22 6 0 5.78 0 5.5S.22 5 .5 5h15c.28 0 .5.22.5.5s-.22.5-.5.5"
                        />
                      </svg>
                      <span>04/02/2025 - 04/12/2025</span>
                    </p>
                  </div>
                  <div class="promo-stats">
                    <span
                      ><svg
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
                    </span>
                    <span>2 apprenants</span>
                  </div>
                </div>

                <div class="promo-footer">
                  <a href="#" class="promo-link"
                    >Voir détails
                    <span
                      ><svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                      >
                        <path
                          fill=""
                          d="M10 6L8.59 7.41L13.17 12l-4.58 4.59L10 18l6-6z"
                        />
                      </svg>
                    </span>
                  </a>
                </div>
              </div>
            </div> -->

            <div class="table-container">
              <table class="promo-table">
                <thead>
                  <tr>
                    <th>Photo</th>
                    <th>Promotion</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Référentiel</th>
                    <th>Statut</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($promotions as $promo): ?>
                  <!-- Ligne 1 -->
                  <tr>
                    <td>
                      <img
                        src="<?= $promo['photo'] ?>"
                        class="promo-img"
                        alt="Promo 2025"
                      />
                    </td>
                    <td><?= $promo['nom_promotion'] ?></td>
                    <td><?= $promo['date_debut'] ?></td>
                    <td><?= $promo['date_fin'] ?></td>
                    <td>
                      <?php foreach ($promo['referentiels'] as $referentiel): ?>
                        <?php if ($referentiel === 'developpement web/mobile') : ?>
                        <span class="badge green"><?= substr(explode(' ', $referentiel)[0], 0, 3) . ' ' . explode(' ', $referentiel)[1];?></span>
                        <?php elseif ($referentiel === 'referent digital'): ?>
                        <span class="badge blue"><?= $referentiel ?></span>
                        <?php elseif ($referentiel === 'developpement data'): ?>
                          <span class="badge purple"><?= $referentiel ?></span>
                        <?php elseif ($referentiel === 'aws & devops'): ?>
                          <span class="badge orange"><?= $referentiel ?></span>
                        <?php elseif ($referentiel === 'assistant digital'): ?>
                          <span class="badge pink"><?= 'hackeuse' ?></span>
                        <?php endif; ?>
                        <!-- <span class="badge green">DEV WEB/MOBILE</span>
                        <span class="badge blue">REF DIG</span>
                        <span class="badge purple">DEV DATA</span>
                        <span class="badge orange">AWS</span>
                        <span class="badge pink">HACKEUSE</span> -->
                      <?php endforeach; ?> 
                    </td>
                    <td><span class="status <?= $promo['status'] === 'active' ? 'active' : 'inactive'?>"><?= $promo['status'] ?></span></td>
                    <td><span class="action">⋯</span></td>
                  </tr>
                  <?php endforeach; ?> 
<!--                   
                  <tr>
                    <td>
                      <img
                        src="../assets/images/img-promo-2025.jpg"
                        class="promo-img"
                        alt="Promo 2024"
                      />
                    </td>
                    <td>Promotion 2024</td>
                    <td>01/02/2024</td>
                    <td>01/12/2024</td>
                    <td>
                      <span class="badge green">DEV WEB/MOBILE</span>
                      <span class="badge blue">REF DIG</span>
                      <span class="badge purple">DEV DATA</span>
                      <span class="badge orange">AWS</span>
                      <span class="badge pink">HACKEUSE</span>
                    </td>
                    <td><span class="status inactive">Inactive</span></td>
                    <td><span class="action">⋯</span></td>
                  </tr>
                  
                  <tr>
                    <td>
                      <img
                        src="../assets/images/img-promo-2025.jpg"
                        class="promo-img"
                        alt="Promo 2024"
                      />
                    </td>
                    <td>Promotion 2023</td>
                    <td>01/02/2023</td>
                    <td>01/12/2023</td>
                    <td>
                      <span class="badge green">DEV WEB/MOBILE</span>
                      <span class="badge blue">REF DIG</span>
                      <span class="badge purple">DEV DATA</span>
                      <span class="badge orange">AWS</span>
                      <span class="badge pink">HACKEUSE</span>
                    </td>
                    <td><span class="status inactive">Inactive</span></td>
                    <td><span class="action">⋯</span></td>
                  </tr>
                  
                  <tr>
                    <td>
                      <img
                        src="../assets/images/img-promo-2025.jpg"
                        class="promo-img"
                        alt="Promo 2024"
                      />
                    </td>
                    <td>Promotion 2024</td>
                    <td>01/02/2022</td>
                    <td>01/12/2022</td>
                    <td>
                      <span class="badge green">DEV WEB/MOBILE</span>
                      <span class="badge blue">REF DIG</span>
                      <span class="badge purple">DEV DATA</span>
                      <span class="badge orange">AWS</span>
                      <span class="badge pink">HACKEUSE</span>
                    </td>
                    <td><span class="status inactive">Inactive</span></td>
                    <td><span class="action">⋯</span></td>
                  </tr>
                  
                  <tr>
                    <td>
                      <img
                        src="../assets/images/img-promo-2025.jpg"
                        class="promo-img"
                        alt="Promo 2024"
                      />
                    </td>
                    <td>Promotion 2021</td>
                    <td>01/02/2021</td>
                    <td>01/12/2021</td>
                    <td>
                      <span class="badge green">DEV WEB/MOBILE</span>
                      <span class="badge blue">REF DIG</span>
                      <span class="badge purple">DEV DATA</span>
                      <span class="badge orange">AWS</span>
                      <span class="badge pink">HACKEUSE</span>
                    </td>
                    <td><span class="status inactive">Inactive</span></td>
                    <td><span class="action">⋯</span></td>
                  </tr> -->
                </tbody>
              </table>

              <!-- Pagination -->
              <div class="pagination">
                <div class="page-info">
                    Affichage de <?= ($page - 1) * $limit + 1 ?> à <?= min($page * $limit, $total) ?> sur <?= $total ?> promotions
                </div>
                <div class="page-nav">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?>&filter=<?= urlencode($_GET['filter']?? '') ?>&search=<?= urlencode($search) ?>&limit=<?= $limit ?>&view=<?= $view ?>" class="page-btn">Précédent</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <a href="?page=<?= $i ?>&filter=<?= urlencode($_GET['filter']?? '') ?>&search=<?= urlencode($search) ?>&limit=<?= $limit ?>&view=<?= $view ?>" class="page-btn <?= $i === $page ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $pages): ?>
                        <a href="?page=<?= $page + 1 ?>&filter=<?= urlencode($_GET['filter'] ?? '') ?>&search=<?= urlencode($search) ?>&limit=<?= $limit ?>&view=<?= $view ?>" class="page-btn">Suivant</a>
                    <?php endif; ?>
                </div>
            </div>
            </div>
          </div>
        </section>