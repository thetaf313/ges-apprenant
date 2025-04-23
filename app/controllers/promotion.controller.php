<?php
namespace App\Controllers;

use App\Enums\Paths;
use App\Enums\Promotions;
use App\Enums\Routes;
use App\Enums\Sessions;
use App\Enums\Validators;
use Exception;

use function App\Models\promotion_service_exec;
use function App\Services\session_service_exec;

// use App\Models\promotion_model.php;

// Au début de promotion.controller.php
// var_dump('Tentative accès promotion. Session: ' . print_r($_SESSION, true));
// die;

// function handle_promotion(): void {
//     auth_middleware();

//     $action = $_REQUEST['action'] ?? 'list';

//     match($action) {
//         'list' => get_all_promotions(),
//         'find' => get_promotion_by_name(),
//         default => get_all_promotions(),
//     };
//     exit;
// }






function get_all_promotions(): void {
    global $promotion_services;

    $promotions = $promotion_services[Promotions::FIND_ALL_PROMOTIONS->value]();

    render_view('promotion/list_promotion_grid.html.php', 'grid.layout.php', [
        'title' => 'Liste des promotions',
        'promotions' => $promotions
    ]);
}

function get_promotion_by_name(): void {
    global $promotion_services;

    $name = $_GET['name'] ?? '';
    $promotion = $promotion_services[Promotions::FIND_PROMOTION_BY_NAME->value]($name);

    render_view('promotion/show.html.php', 'grid.layout.php', [
        'promotion' => $promotion,
        'title' => "Détails de la promotion : $name"
    ]);
}

function show_add_promotion_form() {
    
    render_view('promotion/add_promotion.html.php', 'grid.layout.php', [
        'title' => "Ajouter une promotion"
    ]);
    exit;
}

function add_promotion(): void {
    global $promotion_services;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $_POST;
        $promotion_services[Promotions::SAVE_PROMOTION->value]($data);
        header('Location: ?action=list');
        exit;
    }

    render_view('promotion/add_promotion.html.php', 'grid.layout.php', [
        'title' => 'Ajouter une promotion'
    ]);
    exit;
}

function add_referentiel_to_promotion(): void {
    global $promotion_services;

    $promotion = $_POST['promotion'] ?? '';
    $referentiel = $_POST['referentiel'] ?? '';

    if ($promotion && $referentiel) {
        $promotion_services[Promotions::ADD_REFERENTIEL_TO_PROMOTION->value]($promotion, $referentiel);
    }

    header('Location: ?action=list');
    exit;
}

function get_all_referentiels_by_promotion() : void {

    $referentiels = promotion_service_exec(Promotions::FIND_ALL_REFERENTIELS_BY_PROMOTION) ?? [];

    render_view('promotion/list_promotion_grid.html.php', 'grid.layout.php', [
        'title' => 'Liste des promotions',
        'referentiels' => $referentiels
    ]);
    exit;

}


function validate_promotion(array $data, array $allPromotions): array {
    global $validators_services;

    // Ajouter une règle personnalisée pour vérifier l'unicité du nom
    $validators_services['unique_nom'] = function ($value) use ($allPromotions) {
        return !in_array($value, array_column($allPromotions, 'nom'));
    };

    $validators_services[Validators::ADD_VALIDATOR->value](
        'unique_nom',
        $validators_services['unique_nom'],
        'Le nom de la promotion existe déjà'
    );

    // Ajouter une règle personnalisée pour comparer les dates
    $validators_services['date_order'] = function ($value, $field, $data) {
        return strtotime($value) >= strtotime($data[$field] ?? '');
    };

    $validators_services[Validators::ADD_VALIDATOR->value](
        'date_order',
        $validators_services['date_order'],
        'La date de fin doit être postérieure à la date de début'
    );

    $rules = [
        'nom' => 'required|min:3|unique_nom',
        'dateDebut' => 'required|date',
        'dateFin' => 'required|date|date_order:dateDebut',
        'description' => '',
    ];

    return $validators_services[Validators::VALIDATE->value]($data, $rules);
}

/**
 * Récupère toutes les promotions avec pagination
 */
function handle_promotion_list(): array {
    $page = $_GET['page'] ?? 1;
    $perPage = $_GET['per_page'] ?? 3; // Valeur par défaut
    
    // Récupère toutes les promotions
    $allPromotions = promotion_service_exec(Promotions::FIND_ALL_PROMOTIONS);
    
    // Pagination
    $total = count($allPromotions);
    $totalPages = ceil($total / $perPage);
    $offset = ($page - 1) * $perPage;
    $promotions = array_slice($allPromotions, $offset, $perPage);
    
    return [
        'promotions' => $promotions,
        'pagination' => [
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages
        ]
    ];
}

/**
 * Change le statut d'une promotion
 */
function handle_promotion_status_change(): void {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirect_to_route(Routes::PROMOTION->value);
        return;
    }
    
    $name = $_POST['promotion_name'];
    $status = $_POST['status'];
    
    promotion_service_exec(Promotions::CHANGE_PROMOTION_STATUS, $name, $status);
    
    // Message flash et redirection
    session_service_exec(Sessions::SET_FLASH_SUCCESS, 'success', 'Statut mis à jour');
    redirect_to_route(Routes::PROMOTION->value);
}

/**
 * Ajoute un référentiel à une promotion
 */
function handle_add_referentiel(): void {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirect_to_route(Routes::PROMOTION->value);
        return;
    }
    
    $promotionName = $_POST['promotion_name'];
    $referentielName = $_POST['referentiel_name'];
    
    promotion_service_exec(Promotions::ADD_REFERENTIEL_TO_PROMOTION, $promotionName, $referentielName);
    
    session_service_exec(Sessions::SET_FLASH_SUCCESS, 'success', 'Référentiel ajouté');
    redirect_to_route(Routes::PROMOTION->value);
}


/**
 * Affiche la vue avec pagination
 */
// function render_promotion_list(): void {
//     $data = handle_promotion_list();
    
//     // Pré-calcul du nombre d'apprenants pour chaque promotion
//     $promotionsWithLearners = array_map(function($promo) {
//         $promo['nb_learners'] = promotion_service_exec(
//             Promotions::NB_OF_LEARNERS_BY_PROMOTION, 
//             $promo['nom_promotion']
//         );
//         return $promo;
//     }, $data['promotions']);
    
//     $data['promotions'] = $promotionsWithLearners;
    
//     // Stats globales
//     $data['stats'] = [
//         'total_learners' => array_reduce($data['promotions'], 
//             fn($carry, $promo) => $carry + $promo['nb_learners'], 0),
//         'total_referentiels' => array_reduce($data['promotions'],
//             fn($carry, $promo) => $carry + count($promo['referentiels'] ?? []), 0),
//         'active_promotions' => count(array_filter($data['promotions'],
//             fn($p) => strtolower($p['etat']) === 'active')),
//         'total_promotions' => count($data['promotions'])
//     ];
    
//     render_view('promotion/list_promotion_grid.html.php', 'grid.layout.php', $data);
// }
function render_promotion_list(): void {
    // 1. Récupération des données de base
    $data = handle_promotion_list();
    
    // 2. Vérification des données
    if (!isset($data['promotions']) || !is_array($data['promotions'])) {
        $data['promotions'] = [];
        error_log("Aucune donnée de promotion trouvée ou format invalide");
    }

    // 3. Calcul des métriques
    foreach ($data['promotions'] as &$promo) {
        try {
            $promo['nb_learners'] = promotion_service_exec(
                Promotions::NB_OF_LEARNERS_BY_PROMOTION, 
                $promo['nom_promotion']
            );
        } catch (Exception $e) {
            $promo['nb_learners'] = 0;
            error_log("Erreur calcul apprenants: " . $e->getMessage());
        }
    }
    unset($promo); // Important après une référence avec &

    // 4. Préparation des stats
    $data['stats'] = [
        'total_learners' => array_sum(array_column($data['promotions'], 'nb_learners')),
        'total_referentiels' => array_sum(array_map(fn($p) => count($p['referentiels'] ?? []), $data['promotions'])),
        'active_promotions' => count(array_filter($data['promotions'], fn($p) => strtolower($p['etat'] ?? '') === 'active')),
        'total_promotions' => count($data['promotions'])
    ];

    // 5. Debug (à commenter en production)
    error_log(print_r($data, true));
    // file_put_contents('debug_promo.json', json_encode($data, JSON_PRETTY_PRINT));

    // 6. Appel correct de la vue
    render_view(
        'promotion/list_promotion_grid.php',
        'grid.layout.php',                          
        $data
    );
}


/**
 * Point d'entrée principal
 */
function handle_promotion(): void {
    auth_middleware();

    $action = $_REQUEST['action'] ?? 'list';
    
    match($action) {
        'list' => render_promotion_list(),
        'add' => show_add_promotion_form(),
        'show' => get_promotion_by_name(),
        'change-status' => handle_promotion_status_change(),
        'add-referentiel' => handle_add_referentiel(),
        'list-referentiel' => get_all_referentiels_by_promotion(),
        default => redirect_to_route(Routes::ERROR->resolve())
    };
}