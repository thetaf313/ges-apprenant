<?php
namespace App\Controllers;

use App\Enums\Apprenants;
use App\Enums\FileServices;
use App\Enums\Promotions;
use App\Enums\Routes;

function handle_apprenant(): void {
        
    $action = $_REQUEST['action'] ?? 'list';
    
    match($action) {
        'list' => get_all_apprenants(),
        'stand-by-list' => get_stand_by_list_apprenants(),
        'export' => export_apprenants(),
        'import' => save_list_apprenants(),
        'add-list-apprenants' => show_add_list_apprenants(),

        // 'search-list' => get_all_promotions_search(),
        // 'save' => add_promotion(),
        // 'show' => get_promotion_by_name(),
        // 'change-status' => handle_promotion_status_change(),
        // 'add-referentiel' => manage_promotion_referentiels(),
        // 'toggle-ref-promo' => toggle_referentiel_in_promotion(),
        // 'list-ref-promo' => get_all_referentiels_by_promotion(),
        default => redirect_to_route(Routes::ERROR->resolve())
    };
    return;
}


function get_all_apprenants() {

    global $apprenant_services;

    $filter_status = trim($_REQUEST['filter_status'] ?? '');
    $filter_ref = trim($_REQUEST['filter_ref'] ?? '');
    $search = trim($_REQUEST['search'] ?? '');
    $limit = isset($_REQUEST['limit']) ? (int) $_REQUEST['limit'] : 3; // 3 par défaut
    $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
    $view = trim($_REQUEST['view'] ?? '');

    // error_log(print_r($promotions));
    // die;
    $data = $apprenant_services[Apprenants::FIND_ALL_APPRENANTS_FILTER->value]($filter_ref, $filter_status, $search, $page, $limit);

    $data['page'] = $page;
    $data['limit'] = $limit;
    $data['search'] = $search;
    $data['view'] = $view;

    if ($view === 'list') {
        render_view('apprenant/list_apprenant.html.php', 'list.layout.php', $data);
        exit;
    }
    render_view('apprenant/list_apprenant.html.php', 'grid.layout.php', $data);
    exit;

}

function export_apprenants(): void {
    $type = $_GET['type'] ?? 'excel'; // par défaut EXCEL

    if ($type === 'pdf') {
        generate_pdf_apprenants();
    } elseif ($type === 'excel') {
        generate_excel_apprenants();
    } else {
        // Type inconnu => Retourner à la liste
        redirect_to_route(Routes::APPRENANT->resolve());
        exit;
    }
}


function generate_pdf_apprenants(): void {
    // TODO: Gérer l'export en PDF ici
}

function generate_excel_apprenants(): void {
    global $file_services;

    // 1. Récupérer les données
    $data = $file_services[FileServices::JSON_TO_ARRAY->value]();
    $apprenants = $data['apprenants'] ?? [];

    // 2. Préparer le nom du fichier
    $filename = "liste_apprenants_" . date('Ymd_His') . ".csv";

    // 3. Envoyer les headers pour téléchargement
    header('Content-Type: text/csv; charset=utf-8');
    header("Content-Disposition: attachment; filename=\"$filename\"");

    // 4. Ouvrir le flux de sortie
    $output = fopen('php://output', 'w');

    // 5. Écrire les entêtes
    fputcsv($output, ['Photo', 'Matricule', 'Nom', 'Prenom', 'Email', 'Téléphone', 'Adresse', 'Promotion', 'Référentiel', 'Statut']);

    // 6. Écrire chaque ligne d'apprenant
    foreach ($apprenants as $a) {
        fputcsv($output, [
            $a['photo'] ?? '',
            $a['matricule'] ?? '',
            $a['nom'] ?? '',
            $a['prenom'] ?? '',
            $a['email'] ?? '',
            $a['telephone'] ?? '',
            $a['adresse'] ?? '',
            $a['promotion'] ?? '',
            $a['referentiel'] ?? '',
            $a['statut'] ?? ''
        ]);
    }

    // 7. Fermer le flux
    fclose($output);
    exit;
}

function show_add_list_apprenants() {

    render_view('apprenant/add_apprenants.html.php', 'grid.layout.php');
    exit;
}

function save_list_apprenants() {

}

function get_stand_by_list_apprenants() {
    
}