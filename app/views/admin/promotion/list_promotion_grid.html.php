<?php
// Définition des variables pour le layout
$title = 'Connexion';
ob_start(); // Démarre la capture de sortie
?>

<!-- Section de contenu -->
<section class="content">
          <div class="content-container view-grid">
            <div class="content-header">
              <div class="">
                <h1>Promotion</h1>
                <p>Gérer les promotions de l'école.</p>
              </div>
             
              <label for="modal-toggle" class="add-promo-btn">
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
              </label>
            </div>

            <div class="stat-cards-container">
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
            </div>

            <div class="contents-cards-bar">
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
            </div>

            <div class="promotions-cards-container">
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
                        /></svg></span
                  ></a>
                </div>
              </div>
            </div>
          </div>
        </section>

<?php
// Fin de capture et passage au layout
$content = ob_get_clean();
require __DIR__ . '/../layout/base.layout.php';