<?php
namespace App\Controllers;

use App\Enums\Paths;

require_once Paths::CONTROLLERS->resolve('error.controller.php');
require_once Paths::CONTROLLERS->resolve('auth.controller.php');
require_once Paths::CONTROLLERS->resolve('promotion.controller.php');


/**
 * Fonctions utilitaires pour les contrôleurs
 */

 function render_view(string $viewPath, string $layoutPath, array $data = []) : void {
    extract($data); // Rend chaque clé de $data accessible comme variable

    ob_start(); // Démarre la capture de sortie
    include Paths::VIEWS->resolve($viewPath); // Charge la vue
    $content = ob_get_clean(); // Récupère le contenu capturé

    require Paths::LAYOUTS->resolve($layoutPath); // Charge le layout avec $content
}

/**
 * Redirige vers une route
 * 
 * @param string $route Route vers laquelle rediriger
 * @param int $status_code Code HTTP de redirection (par défaut 302)
 */
function redirect_to_route(string $route, int $status_code = 302): void
{
    // Construction de l'URL complète
    $base_url = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $base_url .= $_SERVER['HTTP_HOST'];
    
    // Nettoyage de la route (suppression des slashs initiaux multiples)
    $clean_route = '/' . ltrim($route, '/');
    
    header("Location: $base_url$clean_route", true, $status_code);
    exit;
}

/**
 * Valide des données selon des règles
 * 
 * @param array $data Données à valider
 * @param array $rules Règles de validation
 * @return array ['is_valid' => bool, 'errors' => array]
 */
function validate(array $data, array $rules): array {
    global $validators, $validationMessages;
    
    $errors = [];
    
    foreach ($rules as $field => $fieldRules) {
        $value = $data[$field] ?? null;
        $fieldErrors = validate_field($field, $value, $fieldRules, $data);
        
        if (!empty($fieldErrors)) {
            $errors[$field] = $fieldErrors[0]; // On ne garde que la première erreur
        }
    }
    
    return [
        'is_valid' => empty($errors),
        'errors' => $errors
    ];
}


/**
 * Valide un champ spécifique
 */
function validate_field(string $field, $value, $rules, array $data): array {
    global $validators;
    
    $errors = [];
    $rulesArray = is_array($rules) ? $rules : explode('|', $rules);
    
    foreach ($rulesArray as $rule) {
        $parts = explode(':', $rule, 2);
        $ruleName = $parts[0];
        $ruleParam = $parts[1] ?? null;
        
        $isValid = $validators[$ruleName]($value, $ruleParam, $data);
        
        if (!$isValid) {
            $errors[] = get_validation_message($field, $ruleName, $ruleParam);
            break; // On s'arrête à la première erreur
        }
    }
    
    return $errors;
}

/**
 * Retourne le message d'erreur approprié
 */
function get_validation_message(string $field, string $rule, $param = null): string {
    global $validationMessages;
    
    $message = $validationMessages[$rule] ?? 'Validation failed for field %s';
    
    if (str_contains($message, '%s')) {
        return sprintf($message, $field, $param);
    }
    
    return str_replace('%s', $field, $message);
}


/**
 * Sauvegarde un fichier uploadé
 * 
 * @param array $file Fichier uploadé ($_FILES['nom_du_champ'])
 * @param string $target_dir Répertoire de destination
 * @param array $allowed_types Types MIME autorisés
 * @param int $max_size Taille maximale en octets
 * @return string Chemin du fichier sauvegardé
 * @throws \RuntimeException En cas d'erreur
 */
function save_picture(array $file, string $target_dir, array $allowed_types = ['image/jpeg', 'image/png', 'image/gif'], int $max_size = 2097152): string
{
    // Vérification des erreurs d'upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new \RuntimeException(get_upload_error_message($file['error']));
    }
    
    // Vérification du type MIME
    $finfo = new \finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    
    if (!in_array($mime, $allowed_types)) {
        throw new \RuntimeException("Type de fichier non autorisé. Types acceptés: " . implode(', ', $allowed_types));
    }
    
    // Vérification de la taille
    if ($file['size'] > $max_size) {
        throw new \RuntimeException("Le fichier est trop volumineux. Taille maximale: " . format_bytes($max_size));
    }
    
    // Création du répertoire cible si inexistant
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    
    // Génération d'un nom de fichier unique
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid('img_') . '.' . $extension;
    $target_path = rtrim($target_dir, '/') . '/' . $filename;
    
    // Déplacement du fichier temporaire
    if (!move_uploaded_file($file['tmp_name'], $target_path)) {
        throw new \RuntimeException("Impossible de sauvegarder le fichier");
    }
    
    return $target_path;
}

/**
 * Fonction utilitaire: Message d'erreur pour les uploads
 */
function get_upload_error_message(int $error_code): string
{
    $errors = [
        UPLOAD_ERR_INI_SIZE => 'Le fichier dépasse la taille maximale autorisée par le serveur',
        UPLOAD_ERR_FORM_SIZE => 'Le fichier dépasse la taille maximale spécifiée dans le formulaire',
        UPLOAD_ERR_PARTIAL => 'Le fichier n\'a été que partiellement uploadé',
        UPLOAD_ERR_NO_FILE => 'Aucun fichier n\'a été uploadé',
        UPLOAD_ERR_NO_TMP_DIR => 'Dossier temporaire manquant',
        UPLOAD_ERR_CANT_WRITE => 'Échec de l\'écriture du fichier sur le disque',
        UPLOAD_ERR_EXTENSION => 'Une extension PHP a arrêté l\'upload du fichier',
    ];
    
    return $errors[$error_code] ?? 'Erreur inconnue lors de l\'upload';
}

/**
 * Fonction utilitaire: Formatage des octets en taille lisible
 */
function format_bytes(int $bytes, int $precision = 2): string
{
    $units = ['o', 'Ko', 'Mo', 'Go', 'To'];
    
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    
    $bytes /= (1 << (10 * $pow));
    
    return round($bytes, $precision) . ' ' . $units[$pow];
}