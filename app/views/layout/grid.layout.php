<?php

use App\Enums\Routes;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Liste des promotions</title>
    <link rel="stylesheet" href="<?='http://'. $_SERVER['HTTP_HOST'];?>/assets/css/styles.css" />
    <link rel="stylesheet" href="<?='http://'. $_SERVER['HTTP_HOST'];?>/assets/css/add-promo.styles.css" />
    <link rel="stylesheet" href="<?='http://'. $_SERVER['HTTP_HOST'];?>/assets/css/add_referentiel.styles.css" />
    <link rel="stylesheet" href="<?='http://'. $_SERVER['HTTP_HOST'];?>/assets/css/list_apprenants.styles.css" />


  </head>
  <body>
    <div class="dashboard-container">
      <!-- Sidebar -->
      <aside class="sidebar">
        <div class="top-sidebar">
          <div class="logo">
            <img src="<?='http://'. $_SERVER['HTTP_HOST'];?>/assets/images/logo-odc-sonatel.png" alt="Logo" />
          </div>
          <h3><?= str_replace(' ', ' - ', $stats['active_promotion']['nom_promotion'])  ?></h3>
          <div class="separator"></div>
        </div>

        <nav class="menu">
          <ul>
            <li>
              <a href="<?= Routes::HOME->resolve() ?>">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                >
                  <path
                    fill=""
                    d="m20 8l-6-5.26a3 3 0 0 0-4 0L4 8a3 3 0 0 0-1 2.26V19a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-8.75A3 3 0 0 0 20 8m-6 12h-4v-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1Zm5-1a1 1 0 0 1-1 1h-2v-5a3 3 0 0 0-3-3h-2a3 3 0 0 0-3 3v5H6a1 1 0 0 1-1-1v-8.75a1 1 0 0 1 .34-.75l6-5.25a1 1 0 0 1 1.32 0l6 5.25a1 1 0 0 1 .34.75Z"
                  />
                </svg>
                <span>Tableau de bord</span>
              </a>
            </li>
            <li class="active">
              <a href="<?= Routes::PROMOTION->resolve() ?>">
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
                <span>Promotions</span>
              </a>
            </li>
            <li>
              <a href="<?= Routes::REFERENTIEL->resolve() ?>?action=list-ref-promo">
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
                <span>Référentiels</span>
              </a>
            </li>
            <li>
              <a href="<?= Routes::APPRENANT->resolve() ?>">
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
                <span>Apprenants</span>
              </a>
            </li>
            <li>
              <a href="#">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                >
                  <path
                    fill=""
                    d="M19.903 8.586a1 1 0 0 0-.196-.293l-6-6a1 1 0 0 0-.293-.196c-.03-.014-.062-.022-.094-.033a1 1 0 0 0-.259-.051C13.04 2.011 13.021 2 13 2H6c-1.103 0-2 .897-2 2v16c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2V9c0-.021-.011-.04-.013-.062a1 1 0 0 0-.051-.259q-.014-.048-.033-.093M16.586 8H14V5.414zM6 20V4h6v5a1 1 0 0 0 1 1h5l.002 10z"
                  />
                  <path fill="" d="M8 12h8v2H8zm0 4h8v2H8zm0-8h2v2H8z" />
                </svg>
                <span>Gestion des présences</span>
              </a>
            </li>
            <li>
              <a href="#">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                >
                  <path
                    fill=""
                    d="M21 14h-1V7a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v7H3a1 1 0 0 0-1 1v2a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-2a1 1 0 0 0-1-1M6 7a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v7H6Zm14 10a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-1h16Z"
                  />
                </svg>
                <span>Kits & Laptops</span>
              </a>
            </li>
            <li>
              <a href="#">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 32 32"
                >
                  <path fill="" d="M21 4v24h6V4zm-8 7v17h6V11zm-8 7v10h6V18z" />
                </svg>
                <span>Rapports & stats</span>
              </a>
            </li>
          </ul>
        </nav>
        <div class="bottom-sidebar">
          <a href="<?= Routes::AUTH->resolve() ?>?action=logout">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
            >
              <path
                fill=""
                d="m17 8l-1.41 1.41L17.17 11H9v2h8.17l-1.58 1.58L17 16l4-4zM5 5h7V3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h7v-2H5z"
              />
            </svg>
            <span>Déconnexion</span>
          </a>
        </div>
      </aside>

      <!-- Contenu principal -->
      <main class="main-content">
        <!-- Header -->
        <header class="header view-grid">
          <div class="header-left">
            <button class="menu-toggle">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 20 20"
              >
                <path
                  fill=""
                  d="M3.497 15.602a.7.7 0 1 1 0 1.398H.7a.7.7 0 1 1 0-1.398zm15.803 0a.7.7 0 1 1 0 1.398H5.529a.7.7 0 1 1 0-1.398zM3.497 9.334a.7.7 0 1 1 0 1.399H.7a.7.7 0 1 1 0-1.399zm15.803 0a.7.7 0 1 1 0 1.399H5.528a.7.7 0 1 1 0-1.399zM3.497 3a.7.7 0 1 1 0 1.398H.7A.7.7 0 1 1 .7 3zM19.3 3a.7.7 0 1 1 0 1.398H5.528a.7.7 0 1 1 0-1.398z"
                />
              </svg>
            </button>
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
          </div>
          <div class="header-right">
            <div class="notifications">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
              >
                <path
                  fill=""
                  d="M12 1c3.681 0 7 2.565 7 6v4.539c0 .642.189 1.269.545 1.803l2.2 3.298A1.517 1.517 0 0 1 20.482 19H15.5a3.5 3.5 0 1 1-7 0H3.519a1.518 1.518 0 0 1-1.265-2.359l2.2-3.299A3.25 3.25 0 0 0 5 11.539V7c0-3.435 3.318-6 7-6M6.5 7v4.539a4.75 4.75 0 0 1-.797 2.635l-2.2 3.298l-.003.01l.001.007l.004.006l.006.004l.007.001h16.964l.007-.001l.006-.004l.004-.006l.001-.006l-.003-.01l-2.199-3.299a4.75 4.75 0 0 1-.798-2.635V7c0-2.364-2.383-4.5-5.5-4.5S6.5 4.636 6.5 7M14 19h-4a2 2 0 1 0 4 0"
                />
              </svg>
            </div>
            <div class="user-profile">
              <div class="picture">
                <img src="<?='http://'. $_SERVER['HTTP_HOST'];?>/assets/images/img-promo-2025.jpg" alt="" />
              </div>
              <a href="#">
                <h4><?= htmlspecialchars($_SESSION['user']['email']) ?><span><?= htmlspecialchars($_SESSION['user']['role']) ?></span></h4>
              </a>
            </div>
          </div>
        </header>

        

        <!-- Contenu principal qui sera remplacé par les vues -->
        <?= $content ?? '' ?>


      </main>
    </div>
    <!-- Checkbox pour ouvrir/fermer -->
    <!-- <input type="checkbox" id="modal-toggle" /> -->

    <!-- Modal overlay -->
    <?php
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);
?>

  </body>
</html>