<?php
namespace App\Controllers;

use App\Enums\Paths;
use App\Enums\Promotions;
use App\Enums\Referentiels;
use App\Enums\Routes;
use App\Enums\Sessions;
use App\Enums\Validators;
use Exception;

use function App\Models\promotion_service_exec;
use function App\Services\session_service_exec;


function handle_referentiel() {
    
    $action = $_REQUEST['action'] ?? 'list';
    
    match($action) {
        'list' => get_all_referentiels(),
        'list-ref-promo' => get_all_referentiels_by_promotion(),
        'add-referentiel' => add_referentiel(),
        'save-referentiel' => save_referentiel(),
        default => redirect_to_route(Routes::ERROR->resolve())
    };
    return;
}

function get_all_referentiels() {
    global $referentiel_services;
    
    // $filter = trim($_REQUEST['filter'] ?? '');
    $search = trim($_REQUEST['search'] ?? '');
    $limit = isset($_REQUEST['limit']) ? (int) $_REQUEST['limit'] : 4; // 4 par défaut
    $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
    $view = trim($_REQUEST['view'] ?? '');

    // error_log(print_r($promotions));
    // die;
    $data = $referentiel_services[Referentiels::FIND_ALL_REFERENTIELS_FILTER->value]($search, $page, $limit) ?? [];

    $data['page'] = $page;
    $data['limit'] = $limit;
    $data['search'] = $search;
    $data['view'] = $view;


    render_view('referentiel/list_referentiel_grid.html.php', 'grid.layout.php', $data);
    exit;

}

function get_all_referentiels_by_promotion() : void {
    global $referentiel_services;

    // $filter = trim($_REQUEST['filter'] ?? '');
    $search = trim($_REQUEST['search'] ?? '');
    $limit = isset($_REQUEST['limit']) ? (int) $_REQUEST['limit'] : 4; // 4 par défaut
    $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
    $view = trim($_REQUEST['view'] ?? '');

    // error_log(print_r($promotions));
    // die;
    $data = $referentiel_services[Referentiels::FIND_ALL_REFERENTIELS_BY_PROMOTION->value]($search, $page, $limit);

    $data['page'] = $page;
    $data['limit'] = $limit;
    $data['search'] = $search;
    $data['view'] = $view;


    render_view('promotion/list_referentiel_promotion.html.php', 'grid.layout.php', $data);
    exit;
}

function add_referentiel(): void {
    render_view('referentiel/add_referentiel.html.php', 'grid.layout.php', [
        'title' => 'Ajouter un référentiel',
        'errors' => [],
        'old' => []
    ]);
}

function save_referentiel(): void {
    global $validators_services, $referentiel_services;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirect_to_route(Routes::REFERENTIEL->resolve());
        exit;
    }

    $data = [
        'nom' => trim($_POST['nom'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'capacite' => (int) ($_POST['capacite'] ?? 30),
        'nb_sessions' => (int) ($_POST['nb_sessions'] ?? 1),
    ];

    $rules = [
        'nom' => 'required|min:3|unique_referentiel',
        'capacite' => 'required|integer|min:1',
        'nb_sessions' => 'required|integer|min:1'
    ];

    $result = $validators_services[Validators::VALIDATE->value]($data, $rules);

    if (!$result['is_valid']) {
        render_view('referentiel/add_referentiel.html.php', 'grid.layout.php', [
            'title' => 'Ajouter un référentiel',
            'errors' => $result['errors'],
            'old' => $data
        ]);
        return;
    }

    $photoPath = save_photo($_FILES['photo']);

    $referentiel = [
        'nom_referentiel' => $data['nom'],
        'description' => $data['description'],
        'photo' => $photoPath ?? '',
        'nb_modules' => 8, // On peut demander ou laisser fixe
        'nb_apprenants' => 0,
        'capacite' => $data['capacite'],
        'nb_sessions' => $data['nb_sessions']
    ];

    $referentiel_services[Referentiels::SAVE_REFERENTIEL->value]($referentiel);

    $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => 'Référentiel créé avec succès!'
    ];
    redirect_to_route(Routes::REFERENTIEL->resolve());
}
