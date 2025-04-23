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
 
 $validators_services[Validators::GET_VALIDATION_MESSAGE->value] = function (string $field, string $rule, $param = null) use (&$validationMessages) {
     $template = $validationMessages[$rule] ?? 'Validation failed for field %s';
     return str_contains($template, '%s')
         ? sprintf($template, $field, $param)
         : str_replace('%s', $field, $template);
 };
 
 $validators_services[Validators::REQUIRED->value] = fn($value) => !empty(trim($value ?? ''));
 $validators_services[Validators::EMAIL->value] = fn($value) => filter_var($value, FILTER_VALIDATE_EMAIL);
 $validators_services[Validators::MIN->value] = fn($value, $min) => strlen(trim($value ?? '')) >= (int)$min;
 $validators_services[Validators::MAX->value] = fn($value, $max) => strlen(trim($value ?? '')) <= (int)$max;
 $validators_services[Validators::NUMERIC->value] = fn($value) => is_numeric($value);
 $validators_services[Validators::INTEGER->value] = fn($value) => filter_var($value, FILTER_VALIDATE_INT);
 $validators_services[Validators::DATE->value] = fn($value) => (bool)strtotime($value);
 $validators_services[Validators::REGEX->value] = fn($value, $pattern) => preg_match($pattern, $value);
 $validators_services[Validators::IN->value] = fn($value, $options) => in_array($value, explode(',', $options));
 $validators_services[Validators::SAME->value] = fn($value, $field, $data) => $value === ($data[$field] ?? null);
 
 // Validation d’un seul champ
 $validators_services[Validators::VALIDATE_FIELD->value] = function (string $field, $value, $rules, array $data) use (&$validators_services) {
     $rulesArray = is_array($rules) ? $rules : explode('|', $rules);
 
     return array_reduce($rulesArray, function ($errors, $rule) use ($field, $value, $data, &$validators_services) {
         [$ruleName, $param] = array_pad(explode(':', $rule, 2), 2, null);
         $validator = $validators_services[$ruleName] ?? null;
         if (!$validator) return $errors;
 
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
 
         return $errors;
     }, []);
 };
 
 $validators_services[Validators::ADD_VALIDATOR->value] = function (string $name, callable $validator, ?string $message = null) use (&$validators_services, &$validationMessages) {
     $validators_services[$name] = $validator;
     if ($message) {
         $validationMessages[$name] = $message;
     }
 };
 
 // Validation globale sans foreach
 $validators_services[Validators::VALIDATE->value] = function (array $data, array $rules) use (&$validators_services) {
     return array_reduce(array_keys($rules), function ($result, $field) use (&$validators_services, $data, $rules) {
         $value = $data[$field] ?? null;
         $fieldErrors = $validators_services[Validators::VALIDATE_FIELD->value]($field, $value, $rules[$field], $data);
 
         if (!empty($fieldErrors)) {
             $result['errors'][$field] = $fieldErrors[0]; // première erreur
             $result['is_valid'] = false;
         }
 
         return $result;
     }, ['is_valid' => true, 'errors' => []]);
 };
 