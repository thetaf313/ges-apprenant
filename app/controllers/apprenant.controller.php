<?php
namespace App\Controllers;

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Enums\Apprenants;
use App\Enums\Auths;
use App\Enums\FileServices;
use App\Enums\Promotions;
use App\Enums\Routes;
use App\Enums\Users;
use App\Enums\Validators;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function handle_apprenant(): void {
        
    $action = $_REQUEST['action'] ?? 'list';
    
    match($action) {
        'list' => get_all_apprenants(),
        'stand-by-list' => get_stand_by_list_apprenants(),
        'export' => export_apprenants(),
        'export-template' => export_file_template(),
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


function export_file_template(): void {
    // 1. Créer un nouveau classeur
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // 2. Définir les entêtes de colonnes
    $headers = [
        'Prénom',
        'Nom',
        'Date de naissance',
        'Lieu de naissance',
        'Adresse',
        'Email',
        'Téléphone',
        'Prénom & Nom Tuteur',
        'Adresse Tuteur',
        'Téléphone Tuteur',
        'Lien de parenté'
    ];

    // 3. Écrire les entêtes dans la 1ère ligne
    foreach ($headers as $index => $header) {
        $col = chr(65 + $index); // A, B, C...
        $sheet->setCellValue("{$col}1", $header);
    }

    // 4. Définir le nom du fichier
    $filename = 'modele_inscription_apprenants.xlsx';

    // 5. Envoyer les headers HTTP pour téléchargement
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    // 6. Générer et envoyer le fichier
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}


function show_add_list_apprenants() {

    render_view('apprenant/add_apprenants.html.php', 'grid.layout.php');
    exit;
}

use PhpOffice\PhpSpreadsheet\IOFactory;

use function App\Services\send_user_credentials;

function import_apprenants_from_excel(array $file): void {
    global $file_services, $validators_services, $user_services, $auth_services, $promotion_services;

    $invalid = [];
    $valid = [];


    // Charger le fichier Excel
    $spreadsheet = IOFactory::load($file['tmp_name']);
    $rows = $spreadsheet->getActiveSheet()->toArray();

    $expectedHeaders = [
        'prenom', 'nom', 'date de naissance', 'lieu de naissance',
        'adresse', 'email', 'telephone',
        'prenom & nom tuteur', 'adresse tuteur', 'telephone tuteur', 'lien de parente'
    ];
    
    // 1. Lire la première ligne
    $headers = $spreadsheet->getActiveSheet()->rangeToArray('A1:K1')[0];
    
    // 2. Comparaison stricte (même ordre, même case)
    $normalized = array_map(fn($h) => strtolower(trim($h)), $headers);
    
    // if ($normalized !== $expectedHeaders) {
    //     $_SESSION['flash_message'] = [
    //         'type' => 'error',
    //         'message' => "La structure de l'entête du fichier est invalide !"
    //     ];
    //     redirect_to_route(Routes::APPRENANT->resolve() . '?action=add-list-apprenants');
    //     return;
    // }
    

    // Sauter l’en-tête
    array_shift($rows);

    foreach ($rows as $line) {
        [$prenom, $nom, $date_naiss, $lieu_naiss, $adresse, $email, $telephone,
         $nom_tuteur, $adresse_tuteur, $tel_tuteur, $lien_parente] = $line;

        $apprenant = compact(
            'prenom', 'nom', 'date_naiss', 'lieu_naiss', 'adresse',
            'email', 'telephone', 'nom_tuteur', 'adresse_tuteur',
            'tel_tuteur', 'lien_parente'
        );

        // Validation ligne par ligne
        $rules = [
            'prenom' => ['required'],
            'nom' => ['required'],
            'email' => ['required', 'email'],
            'telephone' => ['required'],
            'adresse' => ['required'],
            // + autres règles à adapter
        ];

        $result = $validators_services[Validators::VALIDATE->value]($apprenant, $rules);

        if ($result['is_valid']) {
            // Générer login + mot de passe
            $apprenant['matricule'] = $auth_services[Auths::GENERATE_MATRICULE->value]();
            $apprenant['password'] = $password =  $auth_services[Auths::GENERATE_PASSWORD->value]();
            $apprenant['role'] = 'Apprenant';
            $apprenant['role_description'] = 'Apprenant';

            $current_promotion = $promotion_services[Promotions::FIND_CURRENT_PROMOTION->value]() ?? [];

            if ($current_promotion) {
                $apprenant['promotion'] = $current_promotion['nom_promotion'];
            }

            // Ajouter à users
            $users = $user_services[Users::GET_USERS->value]();
            $users[] = $apprenant;
            $user_services[Users::SAVE_USER->value]($users);

            // Envoyer mail
            send_user_credentials($apprenant['email'], $apprenant['prenom'], $password);

            $valid[] = $apprenant;

        } else {
            $apprenant['erreurs'] = $result['errors'];
            $invalid[] = $apprenant;
        }
    }

    // Enregistrer les lignes invalides
    if (!empty($invalid)) {
        $file_services[FileServices::ARRAY_TO_JSON->value]([
            'liste_attente_apprenants' => $invalid
        ], 'data/liste_attente_apprenants.json');
    }

    $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => count($valid) . ' apprenants inscrits, ' . count($invalid) . ' en liste d\'attente.'
    ];

    redirect_to_route(Routes::APPRENANT->resolve());
}


function save_list_apprenants() {

    if (!isset($_FILES['apprenant_file'])) {
        $_SESSION['error'] = "Aucun fichier uploadé";
        redirect_to_route(Routes::APPRENANT->resolve(). '?action=add-list-apprenants');
        exit;
    }
    
    $file = $_FILES['apprenant_file'];
    $results = import_apprenants_from_excel($file);
    
    $_SESSION['import_results'] = $results;
    redirect_to_route(Routes::APPRENANT->resolve());
    exit;

}

function get_stand_by_list_apprenants() {
    
}