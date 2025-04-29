<?php
namespace App\Controllers;

use App\Enums\FileServices;
use App\Enums\Paths;
use App\Enums\Promotions;
use App\Enums\Referentiels;
use App\Enums\Routes;
use App\Enums\Sessions;
use App\Enums\Validators;
use DateTime;
use Exception;

use function App\Models\promotion_service_exec;
use function App\Services\session_service_exec;

/**
 * Point d'entrée principal
 */
function handle_promotion(): void {
    
    // auth_middleware();
    
    $action = $_REQUEST['action'] ?? 'list';
    
    match($action) {
        'list' => get_all_promotions(),
        'search-list' => get_all_promotions_search(),
        'add' => show_add_promotion_form(),
        'save' => add_promotion(),
        'show' => get_promotion_by_name(),
        'change-status' => handle_promotion_status_change(),
        'add-referentiel' => manage_promotion_referentiels(),
        'toggle-ref-promo' => toggle_referentiel_in_promotion(),
        'list-ref-promo' => get_all_referentiels_by_promotion(),
        default => redirect_to_route(Routes::ERROR->resolve())
    };
    return;
}


function get_all_promotions(): void {
    global $promotion_services;

    $filter = trim($_REQUEST['filter'] ?? '');
    $search = trim($_REQUEST['search'] ?? '');
    $limit = isset($_REQUEST['limit']) ? (int) $_REQUEST['limit'] : 3; // 3 par défaut
    $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
    $view = trim($_REQUEST['view'] ?? '');

    // error_log(print_r($promotions));
    // die;
    $data = $promotion_services[Promotions::FIND_ALL_PROMOTIONS_FILTER->value]($filter, $search, $page, $limit);

    $data['page'] = $page;
    $data['limit'] = $limit;
    $data['search'] = $search;
    $data['view'] = $view;

    if ($view === 'list') {
        render_view('promotion/list_promotion_list.html.php', 'list.layout.php', $data);
        exit;
    }
    render_view('promotion/list_promotion_grid.html.php', 'grid.layout.php', $data);
    exit;
}

function get_promotion_by_name(): void {
    global $promotion_services;

    $name = trim($_GET['name'] ?? '');
    $promotion = $promotion_services[Promotions::FIND_PROMOTION_BY_NAME->value]($name);

    render_view('promotion/show_promotion.html.php', 'grid.layout.php', [
        'promotion' => $promotion,
        'title' => "Détails de la promotion : $name"
    ]);
    exit;
}

function show_add_promotion_form() {
    global $referentiel_services;
    
    $referentiels = $referentiel_services[Referentiels::FIND_ALL_REFERENTIELS->value]();
    render_view('promotion/add_promotion.html.php', 'grid.layout.php', [
        'title' => "Ajouter une promotion",
        'referentiels' => $referentiels
    ]);
    exit;
}

/**
 * Sauvegarde une promotion après validation
 * @param array $data Données du formulaire
 * @param array $file Fichier uploadé (photo)
 */
function save_promotion(array $data, array $file): void {
    global $validators_services, $promotion_services, $referentiel_services;

    // 1. Validation des données
    $rules = [
        'nom' => 'required|min:3|unique_promotion',
        'date_debut' => 'required|date_format:d/m/Y',
        'date_fin' => 'required|date_format:d/m/Y|after:date_debut',
        'referentiels' => 'valid_referentiels',
        // 'photo' => 'required|file_mime:image/jpeg,image/jpg,image/png|file_size:2*1024*1024'
    ];

    // $validationResult = $validators_services['validate_with_files'](
    //     $data, 
    //     $rules, 
    //     ['photo' => $file]
    // );
    $validationResult = $validators_services[Validators::VALIDATE->value]($data, $rules);


    if (!$validationResult['is_valid']) {
        render_view('promotion/add_promotion.html.php', 'grid.layout.php', [
            'title' => "Ajouter une promotion",
            'referentiels' => $referentiel_services[Referentiels::FIND_ALL_REFERENTIELS->value](),
            'errors' => $validationResult['errors'],
            'old' => $data
        ]);
        return;
    }

    // 2. Traitement de la photo
    $photoPath = save_photo($file);
    if (!$photoPath) {
        render_view('promotion/add_promotion.html.php', 'grid.layout.php', [
            'title' => "Ajouter une promotion",
            'referentiels' => $referentiel_services[Referentiels::FIND_ALL_REFERENTIELS->value](),
            'errors' => ['photo' => 'Erreur lors de l\'enregistrement de la photo'],
            'old' => $data
        ]);
        return;
    }

    // 3. Formatage des données pour la sauvegarde
    $promotionData = [
        'nom_promotion' => htmlspecialchars(trim($data['nom'])),
        'date_debut' => $data['date_debut'],
        'date_fin' => $data['date_fin'],
        'photo' => $photoPath,
        'referentiels' => array_map('htmlspecialchars', $data['referentiels'] ?? []),
        'status' => 'inactive',
        'etat' => 'en cours',
        // 'date_creation' => date('d/m/Y H:i:s')
    ];

    // 4. Sauvegarde en base
    try {
        $promotion_services[Promotions::SAVE_PROMOTION->value]($promotionData);
        
        // Redirection avec message de succès
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => 'Promotion créée avec succès!'
        ];
        redirect_to_route(Routes::PROMOTION->resolve());
    } catch (Exception $e) {
        // Gestion des erreurs de sauvegarde
        render_view('promotion/add_promotion.html.php', 'grid.layout.php', [
            'title' => "Ajouter une promotion",
            'referentiels' => $referentiel_services[Referentiels::FIND_ALL_REFERENTIELS->value](),
            'errors' => ['save_error' => 'Erreur lors de la sauvegarde: ' . $e->getMessage()],
            'old' => $data
        ]);
    }
}

/**
 * Gère l'ajout d'une promotion (affichage du formulaire et traitement)
 */
function add_promotion(): void {
    global $promotion_services, $referentiel_services;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            // Nettoyage des données POST
            $data = [
                'nom' => trim($_POST['nom'] ?? ''),
                'date_debut' => trim($_POST['date_debut'] ?? ''),
                'date_fin' => trim($_POST['date_fin'] ?? ''),
                'referentiels' => $_POST['referentiels'] ?? []
            ];

            // Vérification de la présence du fichier
            if (!isset($_FILES['photo'])) {
                throw new Exception('Aucun fichier uploadé');
            }

            // Appel à save_promotion qui gère la validation et la sauvegarde
            save_promotion($data, $_FILES['photo']);
            
            // Si tout s'est bien passé, redirection avec message de succès
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'La promotion a été créée avec succès!'
            ];
            redirect_to_route(Routes::PROMOTION->resolve());
            return;
        } catch (Exception $e) {
            // En cas d'erreur, on réaffiche le formulaire avec les erreurs
            render_view('promotion/add_promotion.html.php', 'grid.layout.php', [
                'title' => 'Ajouter une promotion',
                'referentiels' => $referentiel_services[Referentiels::FIND_ALL_REFERENTIELS->value](),
                'errors' => ['global' => $e->getMessage()],
                'old' => $_POST
            ]);
            return;
        }
    }

    // Affichage du formulaire (GET)
    render_view('promotion/add_promotion.html.php', 'grid.layout.php', [
        'title' => 'Ajouter une promotion',
        'referentiels' => $referentiel_services[Referentiels::FIND_ALL_REFERENTIELS->value](),
        'errors' => [],
        'old' => []
    ]);
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



function validate_promotion() {

}


// function validate_promotion(array $data, array $allPromotions): array {
//     global $validators_services;

//     // Ajouter une règle personnalisée pour vérifier l'unicité du nom
//     $validators_services['unique_nom'] = function ($value) use ($allPromotions) {
//         return !in_array($value, array_column($allPromotions, 'nom'));
//     };

//     $validators_services[Validators::ADD_VALIDATOR->value](
//         'unique_nom',
//         $validators_services['unique_nom'],
//         'Le nom de la promotion existe déjà'
//     );

//     // Ajouter une règle personnalisée pour comparer les dates
//     $validators_services['date_order'] = function ($value, $field, $data) {
//         return strtotime($value) >= strtotime($data[$field] ?? '');
//     };

//     $validators_services[Validators::ADD_VALIDATOR->value](
//         'date_order',
//         $validators_services['date_order'],
//         'La date de fin doit être postérieure à la date de début'
//     );

//     $rules = [
//         'nom' => 'required|min:3|unique_nom',
//         'dateDebut' => 'required|date',
//         'dateFin' => 'required|date|date_order:dateDebut',
//         'description' => 'required',
//     ];

//     return $validators_services[Validators::VALIDATE->value]($data, $rules);
// }

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


function handle_promotion_status_change(): void {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || trim($_POST['promotion_name']) === '') {
        redirect_to_route(Routes::PROMOTION->value);
        exit;
    }

    $name = trim($_POST['promotion_name']);

    promotion_service_exec(Promotions::CHANGE_PROMOTION_STATUS, $name);

    session_service_exec(Sessions::SET_FLASH_SUCCESS, 'success', 'Statut mis à jour avec succès.');

    redirect_to_route(Routes::PROMOTION->value);
    exit;
}


/**
 * Ajoute un référentiel à une promotion
 */
function manage_promotion_referentiels(): void {
    global $promotion_services;

    $data = $promotion_services[Promotions::GET_REFERENTIELS_SELECTION->value]();

    if (!$data) {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'message' => "Aucune promotion active trouvée."
        ];
        redirect_to_route(Routes::PROMOTION->resolve());
        exit;
    }

    $promotion = $data['promotion'];
    $available = $data['available'];
    $added = $data['added'];
    
    // Vérifier si la promotion est terminée
    $dateFin = DateTime::createFromFormat('d/m/Y', $promotion['date_fin']);
    $isFinished = (new DateTime()) > $dateFin;

    render_view('promotion/add_ref_to_promotion.html.php', 'list.layout.php', [
        'promotion' => $promotion,
        'available' => $available,
        'added' => $added,
        'isFinished' => $isFinished
    ]);
}


function toggle_referentiel_in_promotion(): void {
    global $file_services, $promotion_services;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['referentiel']) || empty($_POST['operation'])) {
        redirect_to_route(Routes::PROMOTION->resolve() . '?action=manage-ref-promo');
        exit;
    }

    $referentielName = $_POST['referentiel'];
    $operation = $_POST['operation']; // 'add' ou 'remove'

    $db = $file_services[FileServices::JSON_TO_ARRAY->value]();

    foreach ($db['promotions'] as &$promo) {
        if ($promo['status'] === 'active') {
            $referentiels = $promo['referentiels'] ?? [];

            if ($operation === 'add') {
                if (!in_array($referentielName, $referentiels)) {
                    $referentiels[] = $referentielName;
                }
            }

            if ($operation === 'remove') {
                // Avant de retirer, vérifier si le référentiel a des apprenants
                $apprenants = $db['apprenants'] ?? [];
                $hasApprenants = array_filter($apprenants, fn($app) => $app['referentiel'] === $referentielName);

                $dateFin = DateTime::createFromFormat('d/m/Y', $promo['date_fin']);
                $isFinished = (new DateTime()) > $dateFin;

                if (empty($hasApprenants) && !$isFinished) {
                    $referentiels = array_filter($referentiels, fn($ref) => $ref !== $referentielName);
                }
            }

            $promo['referentiels'] = array_values($referentiels);
            break;
        }
    }

    $file_services[FileServices::ARRAY_TO_JSON->value]($db);

    redirect_to_route(Routes::PROMOTION->resolve() . '?action=add-referentiel');
    exit;
}




function render_promotion_list(): void {
    global $promotion_services;

    // 1. Récupération des données de base
    $data = handle_promotion_list();
    
    // error_log(print_r($data));
    // 2. Vérification des données
    if (!isset($data['promotions']) || !is_array($data['promotions'])) {
        $data['promotions'] = [];
        error_log("Aucune donnée de promotion trouvée ou format invalide");
    }

    // 3. Calcul des métriques
    foreach ($data['promotions'] as &$promo) {
        try {
            $promo['nb_apprenants'] = $promotion_services[Promotions::NB_OF_LEARNERS_BY_PROMOTION->value]();
        } catch (Exception $e) {
            $promo['nb_apprenants'] = 0;
            error_log("Erreur calcul apprenants: " . $e->getMessage());
        }
    }
    unset($promo); // Important après une référence avec &

    // 4. Préparation des stats
    $data['stats'] = [
        'total_learners' => array_sum(array_column($data['promotions'], 'nb_apprenants')),
        'total_referentiels' => array_sum(array_map(fn($p) => count($p['referentiels'] ?? []), $data['promotions'])),
        'active_promotions' => count(array_filter($data['promotions'], fn($p) => strtolower($p['etat'] ?? '') === 'active')),
        'total_promotions' => count($data['promotions'])
    ];

    // 5. Debug (à commenter en production)
    // error_log(print_r($data, true));
    // file_put_contents('debug_promo.json', json_encode($data, JSON_PRETTY_PRINT));

    // 6. Appel correct de la vue
    render_view(
        'promotion/list_promotion_grid.html.php',
        'grid.layout.php',                          
        $data
    );
}

function get_all_promotions_search() {

    $data = $_POST;

    $name = $data['name'] ?? '';
    $status = $data['status'] ?? '';

    $promotions = promotion_service_exec(Promotions::FIND_ALL_PROMOTIONS);
    if ($name) {
        $filtered = array_filter($promotions, function($promo) use ($name) {
            return $promo['nom_promotion'] === $name;
        });
        $filtered = promotion_service_exec(Promotions::FIND_PROMOTION_BY_NAME, $name) ?? [];
        render_view('promotion/list_promotion_grid.html.php', 'grid.layout.php', [
            'promotions' => $filtered
        ]);
        exit;
    }
    if ($status !== 'all') {
        $promotions = promotion_service_exec(Promotions::FIND_PROMOTIONS_BY_STATUS, $status) ?? [];
        render_view('promotion/list_promotion_grid.html.php', 'grid.layout.php', [
            'promotions' => $promotions
        ]);
    } else {
        $promotions = promotion_service_exec(Promotions::FIND_ALL_PROMOTIONS) ?? [];
        render_view('promotion/list_promotion_grid.html.php', 'grid.layout.php', [
            'promotions' => $promotions
        ]);
    }
}


