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

$validators_services = [];

// 1. Définir d'abord le message d'erreur
$validators_services[Validators::GET_VALIDATION_MESSAGE->value] = function (string $field, string $rule, $param = null) use (&$validationMessages) {
    $template = $validationMessages[$rule] ?? 'Validation failed for field %s';
    return str_contains($template, '%s')
        ? sprintf($template, $field, $param)
        : str_replace('%s', $field, $template);
};

// 2. Les validateurs de base
$validators_services[Validators::REQUIRED->value] = function ($value) {
    return !empty(trim($value ?? ''));
};
$validators_services[Validators::EMAIL->value] = function ($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
};
$validators_services[Validators::MIN->value] = function ($value, $min) {
    return strlen(trim($value ?? '')) >= (int)$min;
};
$validators_services[Validators::MAX->value] = function ($value, $max) {
    return strlen(trim($value ?? '')) <= (int)$max;
};
$validators_services[Validators::NUMERIC->value] = function ($value) {
    return is_numeric($value);
};
$validators_services[Validators::INTEGER->value] = function ($value) {
    return filter_var($value, FILTER_VALIDATE_INT);
};
$validators_services[Validators::DATE->value] = function ($value) {
    return (bool)strtotime($value);
};
$validators_services[Validators::REGEX->value] = function ($value, $pattern) {
    return preg_match($pattern, $value);
};
$validators_services[Validators::IN->value] = function ($value, $options) {
    return in_array($value, explode(',', $options));
};
$validators_services[Validators::SAME->value] = function ($value, $field, $data) {
    return $value === ($data[$field] ?? null);
};

// 3. Validation d’un seul champ
$validators_services[Validators::VALIDATE_FIELD->value] = function (string $field, $value, $rules, array $data) use (&$validators_services) {
    $rulesArray = is_array($rules) ? $rules : explode('|', $rules);
    $errors = [];

    foreach ($rulesArray as $rule) {
        [$ruleName, $param] = array_pad(explode(':', $rule, 2), 2, null);
        $validator = $validators_services[$ruleName] ?? null;

        if (!$validator) continue;

        $args = [$value];
        if (in_array($ruleName, [Validators::MIN->value, Validators::MAX->value, Validators::REGEX->value, Validators::IN->value])) {
            $args[] = $param;
        } elseif ($ruleName === Validators::SAME->value) {
            $args[] = $param;
            $args[] = $data;
        }

        if (!call_user_func_array($validator, $args)) {
            $errors[] = $validators_services[Validators::GET_VALIDATION_MESSAGE->value]($field, $ruleName, $param);
        }
    }

    return $errors;
};

// 4. Ajouter un validateur personnalisé
$validators_services[Validators::ADD_VALIDATOR->value] = function (string $name, callable $validator, ?string $message = null) use (&$validators_services, &$validationMessages) {
    $validators_services[$name] = $validator;
    if ($message) {
        $validationMessages[$name] = $message;
    }
};

// 5. Validation globale
$validators_services[Validators::VALIDATE->value] = function (array $data, array $rules) use (&$validators_services) {
    $result = ['is_valid' => true, 'errors' => []];

    foreach ($rules as $field => $fieldRules) {
        $value = $data[$field] ?? null;
        $fieldErrors = $validators_services[Validators::VALIDATE_FIELD->value]($field, $value, $fieldRules, $data);
        if (!empty($fieldErrors)) {
            $result['errors'][$field] = $fieldErrors[0]; // première erreur
            $result['is_valid'] = false;
        }
    }

    return $result;
};
