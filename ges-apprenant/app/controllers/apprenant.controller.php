<?php
namespace App\Controllers;

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Enums\Apprenants;
use App\Enums\Auths;
use App\Enums\FileServices;
use App\Enums\Promotions;
use App\Enums\Routes;
use App\Enums\Sessions;
use App\Enums\Users;
use App\Enums\Validators;
use App\translate\fr\FrErrorMessages;
use DateTime;

use PhpOffice\PhpSpreadsheet\IOFactory;
use function App\Services\send_user_credentials;
use function App\Services\session_service_exec;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Ramsey\Uuid\Uuid;

function handle_apprenant(): void {
        
    $action = $_REQUEST['action'] ?? 'list';
    
    match($action) {
        'list' => get_all_apprenants(),
        'stand-by-list' => get_stand_by_list_apprenants(),
        'export' => export_apprenants(),
        'export-template' => export_file_template(),
        'import' => save_list_apprenants(),
        'add-list-apprenants' => show_add_list_apprenants(),
        'edit' => show_add_apprenant_form(),
        'manual-register' => manual_register_apprenant(),

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
        'Prenom',
        'Nom',
        'Date de naissance',
        'Lieu de naissance',
        'Adresse',
        'Email',
        'Telephone',
        'Referentiel',
        'Prenom et Nom Tuteur',
        'Adresse Tuteur',
        'Telephone Tuteur',
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


function import_apprenants_from_excel(array $file): void {
    global $file_services, $validators_services, $user_services, $auth_services, $promotion_services, $apprenant_services;

    $invalid = [];
    $valid = [];

    // Charger le fichier Excel
    $spreadsheet = IOFactory::load($file['tmp_name']);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = $worksheet->toArray();

    // Les en-têtes attendus dans le bon ordre
    $expectedHeaders = [
        'prenom', 'nom', 'date de naissance', 'lieu de naissance',
        'adresse', 'email', 'telephone', 'referentiel',
        'prenom et nom tuteur', 'adresse tuteur', 'telephone tuteur', 'lien de parente'
    ];
    
    // En-têtes réels du fichier (première ligne)
    $actualHeaders = [];
    if (!empty($rows)) {
        $actualHeaders = array_map(fn($h) => strtolower(trim($h)), $rows[0]);
    }
    
    // Créer un mapping des index pour s'assurer que les données sont assignées aux bons champs
    $mapping = [];
    foreach ($expectedHeaders as $index => $expectedHeader) {
        // Rechercher l'index de l'en-tête attendu dans les en-têtes réels
        $actualIndex = array_search($expectedHeader, $actualHeaders);
        if ($actualIndex !== false) {
            $mapping[$index] = $actualIndex;
        } else {
            // Si l'en-tête n'est pas trouvé, utiliser null pour indiquer qu'il manque
            $mapping[$index] = null;
        }
    }
    
    // Sauter l'en-tête
    array_shift($rows);

    foreach ($rows as $rowIndex => $row) {
        // Initialiser un tableau pour stocker les valeurs correctement mappées
        $mappedData = array_fill(0, count($expectedHeaders), '');
        
        // Appliquer le mapping pour extraire les valeurs correctes
        foreach ($mapping as $expectedIndex => $actualIndex) {
            if ($actualIndex !== null && isset($row[$actualIndex])) {
                $mappedData[$expectedIndex] = trim($row[$actualIndex]);
            }
        }
        
        // Maintenant, destructurer les données correctement mappées
        [$prenom, $nom, $date_naiss, $lieu_naiss, $adresse, $email, $telephone, $referentiel,
         $nom_tuteur, $adresse_tuteur, $tel_tuteur, $lien_parente] = $mappedData;

         // Nettoyer les valeurs (supprimer les espaces en début/fin)
        $prenom = trim($prenom ?? '');
        $nom = trim($nom ?? '');
        $date_naiss = trim($date_naiss ?? '');
        $lieu_naiss = trim($lieu_naiss ?? '');
        $adresse = trim($adresse ?? '');
        $email = trim($email ?? '');
        $telephone = trim($telephone ?? '');
        $referentiel = trim($referentiel ?? '');
        $nom_tuteur = trim($nom_tuteur ?? '');
        $adresse_tuteur = trim($adresse_tuteur ?? '');
        $tel_tuteur = trim($tel_tuteur ?? '');
        $lien_parente = trim($lien_parente ?? '');

        // Standardiser le format de date pour garantir le format jj/mm/aaaa
        // if (!empty($date_naiss)) {
        //     // Vérifier si la date est dans un format valide
        //     $datetime = DateTime::createFromFormat('d/m/Y', $date_naiss);
        //     if ($datetime) {
        //         // Reformater explicitement la date au format jj/mm/aaaa
        //         $date_naiss = $datetime->format('d/m/Y');
        //     }
        // }

        $apprenant = compact(
            'prenom', 'nom', 'date_naiss', 'lieu_naiss', 'adresse',
            'email', 'telephone', 'referentiel', 'nom_tuteur', 'adresse_tuteur',
            'tel_tuteur', 'lien_parente'
        );

        // Validation ligne par ligne
        $rules = [
            'prenom' => ['required'],
            'nom' => ['required'],
            'date_naiss' => ['required', 'date_format:d/m/Y'],
            'lieu_naiss' => ['required'],
            'adresse' => ['required'],
            'email' => ['required', 'email', 'unique_email'],
            'telephone' => ['required'],
            'referentiel' => ['required'],
            'nom_tuteur' => ['required'],
            'adresse_tuteur' => ['required'],
            'tel_tuteur' => ['required'],
            'lien_parente' => ['required']
        ];

        $result = $validators_services[Validators::VALIDATE->value]($apprenant, $rules);

        $current_promotion = $promotion_services[Promotions::FIND_CURRENT_PROMOTION->value]() ?? [];
        $apprenant['promotion'] = $current_promotion['nom_promotion'] ?? '';

        if ($result['is_valid']) {
            // Générer login + mot de passe
            $apprenant['matricule'] = $auth_services[Auths::GENERATE_MATRICULE->value]();
            $apprenant['password'] = $password = $auth_services[Auths::GENERATE_PASSWORD->value]();
            $apprenant['role'] = 'Apprenant';
            $apprenant['role_description'] = 'Apprenant';
            $apprenant['status'] = 'actif';
            $apprenant['must_change_password'] = true;


            if (!$current_promotion) {
                session_service_exec(Sessions::SET_ERROR_MESSAGE)('Aucune promo en cours trouvee !');
            }


            // Ajouter à users
            $users = $user_services[Users::GET_USERS->value]();
            $users[] = $apprenant;
            $user_services[Users::SAVE_USER->value]($users);

            // Envoyer mail
            send_user_credentials($apprenant['email'], $apprenant['prenom'], $password);

            $valid[] = $apprenant;
        } else {
            // Garantir que le format de date est préservé pour les apprenants invalides
            $apprenant['erreurs'] = $result['errors'];
            $apprenant['id'] =  Uuid::uuid4()->toString(); // Génère un UUID v4            
            $invalid[] = $apprenant;
        }

    }

    // Enregistrer les lignes invalides
    if (!empty($invalid)) {
        $stand_by_apprenants = $apprenant_services[Apprenants::GET_STAND_BY_APPRENANTS->value]();
        
        // Parcourir chaque apprenant invalide
        foreach ($invalid as $apprenant_invalide) {
            // Vérifier si l'email existe déjà dans la liste d'attente pour éviter les doublons
            if (!empty($apprenant_invalide['email']) && 
                !in_array($apprenant_invalide['email'], array_column($stand_by_apprenants, 'email'))) {
                $stand_by_apprenants[] = $apprenant_invalide;
            }
        }
        
        // Enregistrer la liste mise à jour
        $apprenant_services[Apprenants::SET_STAND_BY_APPRENANTS->value]($stand_by_apprenants);
    }

    $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => count($valid) . ' apprenants inscrits, ' . count($invalid) . ' en liste d\'attente.'
    ];

    redirect_to_route(Routes::APPRENANT->resolve());
}
// function import_apprenants_from_excel(array $file): void {
//     global $file_services, $validators_services, $user_services, $auth_services, $promotion_services, $apprenant_services;

//     $invalid = [];
//     $valid = [];

//     // Charger le fichier Excel
//     $spreadsheet = IOFactory::load($file['tmp_name']);
//     $rows = $spreadsheet->getActiveSheet()->toArray();

//     $expectedHeaders = [
//         'prenom', 'nom', 'date de naissance', 'lieu de naissance',
//         'adresse', 'email', 'telephone', 'referentiel',
//         'prenom et nom tuteur', 'adresse tuteur', 'telephone tuteur', 'lien de parente'
//     ];
    
//     // 1. Lire la première ligne
//     $headers = $spreadsheet->getActiveSheet()->rangeToArray('A1:L1')[0] ?? [];
    
//     // 2. Normalisation des en-têtes pour comparaison
//     $normalized = array_map(fn($h) => strtolower(trim($h)), $headers);
    
//     // Vérification des en-têtes si nécessaire
//     // if (array_diff($expectedHeaders, $normalized) || array_diff($normalized, $expectedHeaders)) {
//     //     $_SESSION['flash_message'] = [
//     //         'type' => 'error',
//     //         'message' => "La structure de l'entête du fichier est invalide !"
//     //     ];
//     //     redirect_to_route(Routes::APPRENANT->resolve() . '?action=add-list-apprenants');
//     //     return;
//     // }

//     // Sauter l'en-tête
//     array_shift($rows);

//     foreach ($rows as $line) {
//         // S'assurer que chaque ligne a 12 éléments, en ajoutant des chaînes vides si nécessaire
//         $line = array_pad($line, 12, '');
        
//         // Destructuration avec des valeurs garanties
//         [$prenom, $nom, $date_naiss, $lieu_naiss, $adresse, $email, $telephone, $referentiel,
//          $nom_tuteur, $adresse_tuteur, $tel_tuteur, $lien_parente] = $line;

//         // Nettoyer les valeurs (supprimer les espaces en début/fin)
//         $prenom = trim($prenom ?? '');
//         $nom = trim($nom ?? '');
//         $date_naiss = trim($date_naiss ?? '');
//         $lieu_naiss = trim($lieu_naiss ?? '');
//         $adresse = trim($adresse ?? '');
//         $email = trim($email ?? '');
//         $telephone = trim($telephone ?? '');
//         $referentiel = trim($referentiel ?? '');
//         $nom_tuteur = trim($nom_tuteur ?? '');
//         $adresse_tuteur = trim($adresse_tuteur ?? '');
//         $tel_tuteur = trim($tel_tuteur ?? '');
//         $lien_parente = trim($lien_parente ?? '');

//         $apprenant = compact(
//             'prenom', 'nom', 'date_naiss', 'lieu_naiss', 'adresse',
//             'email', 'telephone', 'referentiel', 'nom_tuteur', 'adresse_tuteur',
//             'tel_tuteur', 'lien_parente'
//         );

//         // Validation ligne par ligne
//         $rules = [
//             'prenom' => ['required'],
//             'nom' => ['required'],
//             'date_naiss' => ['required', 'date_format:d/m/Y'], // Spécification du format attendu
//             'lieu_naiss' => ['required'],
//             'adresse' => ['required'],
//             'email' => ['required', 'email', 'unique_email'],
//             'telephone' => ['required'],
//             'referentiel' => ['required'],
//             'nom_tuteur' => ['required'],
//             'adresse_tuteur' => ['required'],
//             'tel_tuteur' => ['required'],
//             'lien_parente' => ['required']
//         ];

//         $result = $validators_services[Validators::VALIDATE->value]($apprenant, $rules);

//         if ($result['is_valid']) {
//             // Générer login + mot de passe
//             $apprenant['matricule'] = $auth_services[Auths::GENERATE_MATRICULE->value]();
//             $apprenant['password'] = $password = $auth_services[Auths::GENERATE_PASSWORD->value]();
//             $apprenant['role'] = 'Apprenant';
//             $apprenant['role_description'] = 'Apprenant';
//             $apprenant['must_change_password'] = true;

//             $current_promotion = $promotion_services[Promotions::FIND_CURRENT_PROMOTION->value]() ?? [];

//             if (!$current_promotion) {
//                 session_service_exec(Sessions::SET_ERROR_MESSAGE)('Aucune promo en cours trouvee !');
//             }

//             $apprenant['promotion'] = $current_promotion['nom_promotion'] ?? '';

//             // Ajouter à users
//             $users = $user_services[Users::GET_USERS->value]();
//             $users[] = $apprenant;
//             $user_services[Users::SAVE_USER->value]($users);

//             // Envoyer mail
//             send_user_credentials($apprenant['email'], $apprenant['prenom'], $password);

//             $valid[] = $apprenant;
//         } else {
//             $apprenant['erreurs'] = $result['errors'];
//             $invalid[] = $apprenant;
//         }
//     }

//     // Enregistrer les lignes invalides
//     if (!empty($invalid)) {
//         $stand_by_apprenants = $apprenant_services[Apprenants::GET_STAND_BY_APPRENANTS->value]();
        
//         // Parcourir chaque apprenant invalide
//         foreach ($invalid as $apprenant_invalide) {
//             // Vérifier si l'email existe déjà dans la liste d'attente pour éviter les doublons
//             if (!empty($apprenant_invalide['email']) && 
//                 !in_array($apprenant_invalide['email'], array_column($stand_by_apprenants, 'email'))) {
//                 $stand_by_apprenants[] = $apprenant_invalide;
//             }
//         }
        
//         // Enregistrer la liste mise à jour
//         $apprenant_services[Apprenants::SET_STAND_BY_APPRENANTS->value]($stand_by_apprenants);
//     }

//     $_SESSION['flash_message'] = [
//         'type' => 'success',
//         'message' => count($valid) . ' apprenants inscrits, ' . count($invalid) . ' en liste d\'attente.'
//     ];

//     redirect_to_route(Routes::APPRENANT->resolve());
// }


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

    global $apprenant_services;

    $filter_status = trim($_REQUEST['filter_status'] ?? '');
    $filter_ref = trim($_REQUEST['filter_ref'] ?? '');
    $search = trim($_REQUEST['search'] ?? '');
    $limit = isset($_REQUEST['limit']) ? (int) $_REQUEST['limit'] : 3; // 3 par défaut
    $page = isset($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
    $view = trim($_REQUEST['view'] ?? '');

    // error_log(print_r($promotions));
    // die;
    $data = $apprenant_services[Apprenants::FIND_ALL_STAND_BY_APPRENANTS_FILTER->value]($filter_ref, $filter_status, $search, $page, $limit);

    $data['page'] = $page;
    $data['limit'] = $limit;
    $data['search'] = $search;
    $data['view'] = $view;

    if ($view === 'list') {
        render_view('apprenant/list_stand_by_apprenant.html.php', 'list.layout.php', $data);
        exit;
    }
    render_view('apprenant/list_stand_by_apprenant.html.php', 'grid.layout.php', $data);
    exit;

    
}

function show_add_apprenant_form() {
    global $promotion_services, $apprenant_services;

    $id = $_REQUEST['appr'] ?? '';

    $active_promotion = $promotion_services[Promotions::FIND_ACTIVE_PROMOTION->value]();

    $referentiels = $active_promotion['referentiels'];

    $all_stand_by_apprenants = $apprenant_services[Apprenants::FIND_ALL_STAND_BY_APPRENANTS->value]() ?? [];

    $filtered = array_filter($all_stand_by_apprenants, fn($apprenant) => $apprenant['promotion'] === $active_promotion['nom_promotion'] && $apprenant['id'] === $id);

    $apprenant = !empty($filtered) ? array_values($filtered)[0] : [];

    if (!$apprenant) {
        redirect_to_route(Routes::APPRENANT->resolve() . '?action=stand-by-list');
    }
    // session_service_exec(Sessions::SET_ERRORS)($apprenant['erreurs']);

    $data = [
        'apprenant' => $apprenant,
        'errors' => $apprenant['erreurs'],
        'referentiels' => $referentiels,
    ];

    render_view('apprenant/add_apprenants.html.php', 'list.layout.php', $data);
    
}

function manual_register_apprenant() {
    global $validators_services, $promotion_services, $auth_services, $user_services;

    $apprenant = [];

    $apprenant['prenom'] = trim($_REQUEST['prenom'] ?? '');
    $apprenant['nom'] = trim($_REQUEST['nom'] ?? '');
    $apprenant['date_naiss'] = trim($_REQUEST['date_naiss'] ?? '');
    $apprenant['lieu_naiss'] = trim($_REQUEST['lieu_naiss'] ?? '');
    $apprenant['adresse'] = trim($_REQUEST['adresse'] ?? '');
    $apprenant['email'] = trim($_REQUEST['email'] ?? '');
    $apprenant['telephone'] = trim($_REQUEST['telephone'] ?? '');
    $apprenant['referentiel'] = trim($_REQUEST['referentiel'] ?? '');
    $apprenant['nom_tuteur'] = trim($_REQUEST['nom_tuteur'] ?? '');
    $apprenant['adresse_tuteur'] = trim($_REQUEST['adresse_tuteur'] ?? '');
    $apprenant['tel_tuteur'] = trim($_REQUEST['tel_tuteur'] ?? '');
    $apprenant['lien_parente'] = trim($_REQUEST['lien_parente'] ?? '');

    $rules = [
        'prenom' => ['required'],
        'nom' => ['required'],
        'date_naiss' => ['required', 'date_format:d/m/Y'],
        'lieu_naiss' => ['required'],
        'adresse' => ['required'],
        'email' => ['required', 'email', 'unique_email'],
        'telephone' => ['required'],
        'referentiel' => ['required'],
        'nom_tuteur' => ['required'],
        'adresse_tuteur' => ['required'],
        'tel_tuteur' => ['required'],
        'lien_parente' => ['required']
    ];

    $result = $validators_services[Validators::VALIDATE->value]($apprenant, $rules);

        $current_promotion = $promotion_services[Promotions::FIND_CURRENT_PROMOTION->value]() ?? [];

        if (!$current_promotion) {
            session_service_exec(Sessions::SET_ERROR_MESSAGE)('Aucune promo en cours trouvee !');
        }

        $apprenant['promotion'] = $current_promotion['nom_promotion'] ?? '';

        if ($result['is_valid']) {
            // Générer login + mot de passe
            $apprenant['matricule'] = $auth_services[Auths::GENERATE_MATRICULE->value]();
            $apprenant['password'] = $password = $auth_services[Auths::GENERATE_PASSWORD->value]();
            $apprenant['role'] = 'Apprenant';
            $apprenant['role_description'] = 'Apprenant';
            $apprenant['status'] = 'actif';
            $apprenant['must_change_password'] = true;

            // Ajouter à users
            $users = $user_services[Users::GET_USERS->value]();
            $users[] = $apprenant;
            $user_services[Users::SAVE_USER->value]($users);

            // Envoyer mail
            send_user_credentials($apprenant['email'], $apprenant['prenom'], $password);

            $valid[] = $apprenant;

        } else {
            session_service_exec(Sessions::SET_ERROR_MESSAGE)(FrErrorMessages::FORM_INVALID->value);
            // session_service_exec(Sessions::SET_ERRORS)($result['errors']);
            $data = [ 'errors' => $result['errors']];
            render_view('apprenants/add_apprenants.html.php', 'list.layout.php', $data);
            exit;
        }

        redirect_to_route(Routes::APPRENANT->resolve());

}