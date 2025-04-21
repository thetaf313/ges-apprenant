<?php
namespace App\Services;

use App\Enums\Paths;
use App\Enums\Validators;

require_once __DIR__ . './../enums/Validators.php';

/**
 * Service de validation procédural
 */
$validators_services = [
    Validators::REQUIRED->value => fn($value) => !empty(trim($value ?? '')),
    Validators::EMAIL->value => fn($value) => filter_var($value, FILTER_VALIDATE_EMAIL),
    Validators::MIN->value => fn($value, $min) => strlen(trim($value ?? '')) >= (int)$min,
    Validators::MAX->value => fn($value, $max) => strlen(trim($value ?? '')) <= (int)$max,
    Validators::NUMERIC => fn($value) => is_numeric($value),
    Validators::INTEGER->value => fn($value) => filter_var($value, FILTER_VALIDATE_INT),
    Validators::DATE->value => fn($value) => (bool)strtotime($value),
    Validators::DATE->value => fn($value, $pattern) => preg_match($pattern, $value),
    Validators::IN->value => fn($value, $options) => in_array($value, explode(',', $options)),
    Validators::SAME->value => fn($value, $field, $data) => $value === ($data[$field] ?? null)
];

// Messages d'erreur par défaut
$validationMessages = [
    'required' => 'Le champ %s est obligatoire',
    'email' => 'Le champ %s doit être un email valide',
    'min' => 'Le champ %s doit avoir au moins %s caractères',
    'max' => 'Le champ %s ne doit pas dépasser %s caractères',
    'numeric' => 'Le champ %s doit être un nombre',
    'integer' => 'Le champ %s doit être un entier',
    'date' => 'Le champ %s doit être une date valide',
    'regex' => 'Le format du champ %s est invalide',
    'in' => 'Le champ %s doit être parmi: %s',
    'same' => 'Le champ %s doit correspondre au champ %s'
];

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
 * Ajoute un nouveau validateur
 */
function add_validator(string $name, callable $validator, ?string $message = null): void {
    global $validators, $validationMessages;
    
    $validators[$name] = $validator;
    
    if ($message) {
        $validationMessages[$name] = $message;
    }
}