<?php
/* namespace App\Services;

use App\Enums\Paths;
use App\Enums\Validators;
use App\translate\fr\FrErrorMessages;

require_once __DIR__ . './../enums/Validators.php';
require_once __DIR__ . './../translate/fr/error.fr.php';

$validationMessages = [
    'required' => FrErrorMessages::REQUIRED->value,
    'email' => FrErrorMessages::EMAIL->value,
    'min' => FrErrorMessages::MIN->value,
    'max' => FrErrorMessages::MAX->value,
    'numeric' => FrErrorMessages::NUMERIC->value,
    'integer' => FrErrorMessages::INTEGER->value,
    'date' => FrErrorMessages::DATE->value,
    'regex' => FrErrorMessages::REGEX->value,
    'in' => FrErrorMessages::IN->value,
    'same' => FrErrorMessages::SAME->value
];

$validators_services = [
    Validators::REQUIRED->value => fn($value) => !empty(trim($value ?? '')),
    Validators::EMAIL->value => fn($value) => filter_var($value, FILTER_VALIDATE_EMAIL),
    Validators::MIN->value => fn($value, $min) => strlen(trim($value ?? '')) >= (int)$min,
    Validators::MAX->value => fn($value, $max) => strlen(trim($value ?? '')) <= (int)$max,
    Validators::NUMERIC->value => fn($value) => is_numeric($value),
    Validators::INTEGER->value => fn($value) => filter_var($value, FILTER_VALIDATE_INT),
    Validators::DATE->value => fn($value) => (bool)strtotime($value),
    Validators::REGEX->value => fn($value, $pattern) => preg_match($pattern, $value),
    Validators::IN->value => fn($value, $options) => in_array($value, explode(',', $options)),
    Validators::SAME->value => fn($value, $field, $data) => $value === ($data[$field] ?? null),

    Validators::VALIDATE_FIELD->value => fn(string $field, $value, $rules, array $data) => array_values(array_filter(
        array_map(function ($rule) use ($field, $value, $data) {
            global $validators_services;

            [$ruleName, $ruleParam] = array_pad(explode(':', $rule, 2), 2, null);

            $validator = $validators_services[$ruleName] ?? null;

            if (!$validator) return null;

            // Appel dynamique selon le nombre d'arguments
            $args = [$value];
            if (in_array($ruleName, [Validators::MIN->value, Validators::MAX->value, Validators::REGEX->value, Validators::IN->value])) {
                $args[] = $ruleParam;
            } elseif ($ruleName === Validators::SAME->value) {
                $args[] = $ruleParam;
                $args[] = $data;
            }

            $isValid = call_user_func_array($validator, $args);

            return $isValid ? null : $validators_services[Validators::GET_VALIDATION_MESSAGE->value]($field, $ruleName, $ruleParam);
        }, is_array($rules) ? $rules : explode('|', $rules)),
        fn($err) => $err !== null
    )),

    Validators::GET_VALIDATION_MESSAGE->value => fn(string $field, string $rule, $param = null) => (
        str_contains($validationMessages[$rule] ?? '', '%s')
            ? sprintf($validationMessages[$rule], $field, $param)
            : str_replace('%s', $field, $validationMessages[$rule] ?? 'Validation failed for field ' . $field)
    ),

    Validators::ADD_VALIDATOR->value => function (string $name, callable $validator, ?string $message = null) use (&$validators_services, &$validationMessages) {
        $validators_services[$name] = $validator;
        if ($message) {
            $validationMessages[$name] = $message;
        }
    },

    Validators::VALIDATE->value => fn(array $data, array $rules) => array_reduce(
        array_keys($rules),
        function ($carry, $field) use ($data, $rules, &$validators_services) {
            $value = $data[$field] ?? null;
            $fieldErrors = $validators_services[Validators::VALIDATE_FIELD->value]($field, $value, $rules[$field], $data);
            if (!empty($fieldErrors)) {
                $carry['errors'][$field] = $fieldErrors[0]; // Première erreur
            }
            return $carry;
        },
        ['is_valid' => true, 'errors' => []]
    ) + ['is_valid' => empty(array_filter($rules, fn($field) => isset($data[$field]) && empty($validators_services[Validators::VALIDATE_FIELD->value]($field, $data[$field], $rules[$field], $data))))]
];
 */

 namespace App\Services;

 use App\Enums\Paths;
 use App\Enums\Promotions;
 use App\Enums\Referentiels;
use App\Enums\Users;
use App\Enums\Validators;
 use App\translate\fr\FrErrorMessages;
 use DateTime;

 use function App\Models\promotion_service_exec;
 use function App\Models\referentiel_service_exec;
use function App\Models\user_service_exec;

 require_once __DIR__ . './../enums/Validators.php';
 require_once __DIR__ . './../translate/fr/error.fr.php';
 
 $validationMessages = [
     'required' => FrErrorMessages::REQUIRED->value,
     'email' => FrErrorMessages::EMAIL->value,
     'unique_email' => FrErrorMessages::UNIQUE_EMAIL->value,
     'min' => FrErrorMessages::MIN->value,
     'max' => FrErrorMessages::MAX->value,
     'numeric' => FrErrorMessages::NUMERIC->value,
     'integer' => FrErrorMessages::INTEGER->value,
     'date' => FrErrorMessages::DATE->value,
     'date_format' => FrErrorMessages::DATE_FORMAT->value,
     'regex' => FrErrorMessages::REGEX->value,
     'in' => FrErrorMessages::IN->value,
     'same' => FrErrorMessages::SAME->value,
     'after' => FrErrorMessages::DATE_AFTER->value,
     'file_mime' => FrErrorMessages::FILE_MIME->value,
     'file_size' => FrErrorMessages::FILE_SIZE->value,
     'unique_promotion' => FrErrorMessages::UNIQUE_PROMOTION->value,
     'valid_referentiels' => FrErrorMessages::VALID_REFERENTIELS->value,
     'current_promo_valid_ref' => FrErrorMessages::CURRENT_PROMO_VALID_REF->value
 ];
 
 $validators_services = [
     // Validateurs de base
     Validators::REQUIRED->value => fn($value) => !empty(trim($value ?? '')),
     Validators::EMAIL->value => fn($value) => filter_var($value, FILTER_VALIDATE_EMAIL),
     Validators::MIN->value => fn($value, $min) => strlen(trim($value ?? '')) >= (int)$min,
     Validators::MAX->value => fn($value, $max) => strlen(trim($value ?? '')) <= (int)$max,
     Validators::NUMERIC->value => fn($value) => is_numeric($value),
     Validators::INTEGER->value => fn($value) => filter_var($value, FILTER_VALIDATE_INT),
     Validators::DATE->value => fn($value) => (bool)strtotime($value),
     Validators::REGEX->value => fn($value, $pattern) => preg_match($pattern, $value),
     Validators::IN->value => fn($value, $options) => in_array($value, explode(',', $options)),
     Validators::SAME->value => fn($value, $field, $data) => $value === ($data[$field] ?? null),

     Validators::UNIQUE_EMAIL->value => function ($value) {
    // Supposons que vous avez une fonction user_service_exec similaire à promotion_service_exec
    // et un enum Users avec une constante FIND_ALL_USERS
    $users = user_service_exec(Users::GET_USERS);
    return !in_array(
        strtolower(trim($value)), 
        array_map(fn($u) => strtolower(trim($u['email'])), $users)
    );
},
     
     // Nouveaux validateurs pour les promotions
     'date_format' => function ($value, $format) {
         if (empty($value)) return false;
         $date = \DateTime::createFromFormat($format, $value);
         return $date && $date->format($format) === $value;
     },
     'after' => function ($value, $field, $data) {
         if (empty($value) || empty($data[$field])) return false;
         $date1 = \DateTime::createFromFormat('d/m/Y', $data[$field]);
         $date2 = \DateTime::createFromFormat('d/m/Y', $value);
         return $date2 > $date1;
     },
     'file_mime' => function ($file, $types) {
         if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) return false;
         $finfo = finfo_open(FILEINFO_MIME_TYPE);
         $mime = finfo_file($finfo, $file['tmp_name']);
         finfo_close($finfo);
         return in_array($mime, explode(',', $types));
     },
     'file_size' => fn($file, $maxSize) => isset($file['size']) && $file['size'] <= (int)$maxSize,
     'unique_promotion' => function ($value) {
        
         $promotions = promotion_service_exec(Promotions::FIND_ALL_PROMOTIONS);
         return !in_array(strtolower(trim($value)), 
                array_map(fn($p) => strtolower(trim($p['nom_promotion'])), $promotions));
     },
     'valid_referentiels' => function ($values) {
         if (!is_array($values)) return false;
         $referentiels = referentiel_service_exec(Referentiels::FIND_ALL_REFERENTIELS);
         $existingRefs = array_map('strtolower', array_column($referentiels, 'nom_referentiel'));
         return empty(array_diff(
             array_map('strtolower', array_map('trim', $values)),
             $existingRefs
         ));
     },

     Validators::CURRENT_PROMO_VALID_REF->value => function ($value) {
        if (!is_string($value)) return false;


     },
     
 
     // Fonctions principales inchangées
     Validators::VALIDATE_FIELD->value => fn(string $field, $value, $rules, array $data) => array_values(array_filter(
         array_map(function ($rule) use ($field, $value, $data) {
             global $validators_services;
 
             [$ruleName, $ruleParam] = array_pad(explode(':', $rule, 2), 2, null);
 
             $validator = $validators_services[$ruleName] ?? null;
             if (!$validator) return null;
 
             $args = [$value];
             if (in_array($ruleName, [
                 Validators::MIN->value, Validators::MAX->value, Validators::REGEX->value, 
                 Validators::IN->value, 'date_format', 'file_mime', 'file_size'
             ])) {
                 $args[] = $ruleParam;
             } elseif (in_array($ruleName, [Validators::SAME->value, 'after'])) {
                 $args[] = $ruleParam;
                 $args[] = $data;
             }
 
             $isValid = call_user_func_array($validator, $args);
             return $isValid ? null : $validators_services[Validators::GET_VALIDATION_MESSAGE->value]($field, $ruleName, $ruleParam);
         }, is_array($rules) ? $rules : explode('|', $rules)),
         fn($err) => $err !== null
     )),
 
     Validators::GET_VALIDATION_MESSAGE->value => fn(string $field, string $rule, $param = null) => (
         str_contains($validationMessages[$rule] ?? '', '%s')
             ? sprintf($validationMessages[$rule], $field, $param)
             : str_replace('%s', $field, $validationMessages[$rule] ?? 'Validation failed for field ' . $field)
     ),
 
     Validators::ADD_VALIDATOR->value => function (string $name, callable $validator, ?string $message = null) use (&$validators_services, &$validationMessages) {
         $validators_services[$name] = $validator;
         if ($message) {
             $validationMessages[$name] = $message;
         }
     },
 
     Validators::VALIDATE->value => function(array $data, array $rules, array $files = []) use (&$validators_services) {
         $result = array_reduce(
             array_keys($rules),
             function ($carry, $field) use ($data, $rules, $files, $validators_services) {
                 $value = $data[$field] ?? null;
                 $file = $files[$field] ?? null;
                 $input = $file ?? $value;
                 
                 $fieldErrors = $validators_services[Validators::VALIDATE_FIELD->value](
                     $field, 
                     $input, 
                     $rules[$field], 
                     $data
                 );
                 
                 if (!empty($fieldErrors)) {
                     $carry['errors'][$field] = $fieldErrors[0];
                 }
                 return $carry;
             },
             ['is_valid' => true, 'errors' => []]
         );
         
         $result['is_valid'] = empty($result['errors']);
         return $result;
     },
 
     // Nouvelle fonction pour valider les fichiers
     'validate_with_files' => function(array $data, array $rules, array $files = []) use (&$validators_services) {
         return $validators_services[Validators::VALIDATE->value]($data, $rules, $files);
     },

     Validators::VALIDATE_PROMOTION->value => function (array $data, array $rules) use (&$referentiel_services, &$promotion_services): array {
        $errors = [];

        foreach ($rules as $field => $field_rules) {
            $value = $data[$field] ?? null;

            foreach ($field_rules as $rule) {
                $params = null;

                if (strpos($rule, ':') !== false) {
                    [$rule, $params] = explode(':', $rule, 2);
                }

                switch ($rule) {
                    case 'required':
                        if (empty($value)) {
                            $errors[$field] = "Le champ $field est obligatoire.";
                        }
                        break;

                    case 'min':
                        if (strlen(trim($value)) < (int)$params) {
                            $errors[$field] = "Le champ $field doit contenir au moins $params caractères.";
                        }
                        break;

                    case 'unique_nom':
                        $promotions = $promotion_services[Promotions::FIND_ALL_PROMOTIONS->value]();
                        $exists = array_filter($promotions, fn($promo) => strcasecmp(trim($promo['nom_promotion']), trim($value)) === 0);
                        if (!empty($exists)) {
                            $errors[$field] = "Le nom de la promotion existe déjà.";
                        }
                        break;

                    case 'date':
                        if (!preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $value)) {
                            $errors[$field] = "Le champ $field doit être une date au format jj/mm/aaaa.";
                        }
                        break;

                    case 'after':
                        $other = $data[$params] ?? null;
                        if ($other && preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $value) && preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $other)) {
                            $date1 = DateTime::createFromFormat('d/m/Y', $value);
                            $date2 = DateTime::createFromFormat('d/m/Y', $other);
                            if ($date1 <= $date2) {
                                $errors[$field] = "La date de fin doit être postérieure à la date de début.";
                            }
                        }
                        break;

                    case 'file_mime':
                        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
                            $errors['photo'] = "Erreur lors de l'upload du fichier.";
                        } else {
                            $allowedMimes = explode(',', str_replace('image/', '', $params));
                            $mimeType = mime_content_type($_FILES['photo']['tmp_name']);
                            $mimeType = str_replace('image/', '', $mimeType);

                            if (!in_array($mimeType, $allowedMimes)) {
                                $errors['photo'] = "Le fichier doit être un jpg ou png.";
                            }
                        }
                        break;

                    case 'file_size':
                        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                            if ($_FILES['photo']['size'] > (int)$params) {
                                $errors['photo'] = "Le fichier ne doit pas dépasser 2 Mo.";
                            }
                        }
                        break;

                    case 'valid_referentiels':
                        $selected = $data['referentiels'] ?? [];
                        $referentiels = $referentiel_services[Referentiels::FIND_ALL_REFERENTIELS->value]();
                        $referentielNames = array_map(fn($r) => $r['nom_referentiel'], $referentiels);

                        if (!is_array($selected) || empty($selected)) {
                            $errors[$field] = "Veuillez choisir au moins un référentiel.";
                        } else {
                            foreach ($selected as $ref) {
                                if (!in_array($ref, $referentielNames)) {
                                    $errors[$field] = "Le référentiel '$ref' n'existe pas.";
                                    break;
                                }
                            }
                        }
                        break;
                }
            }
        }

        return [
            'is_valid' => empty($errors),
            'errors' => $errors
        ];
    },
 ];
 
 // Exemple d'ajout d'un validateur personnalisé
 $validators_services[Validators::ADD_VALIDATOR->value](
     'strong_password',
     fn($value) => preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $value),
     'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial'
 );