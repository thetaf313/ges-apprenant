<?php

namespace App\Models;

use App\Enums\Auths;
use App\Enums\FileServices;
use App\Enums\Paths;
use App\Enums\Users;
use App\translate\fr\FrErrorMessages;

use function App\Services\send_user_credentials;

$auth_services = [

    'validation_rules' => [
        'last_name' => [
            'required' => true,
            'min_length' => 2,
            'max_length' => 50,
            'pattern' => '/^[a-zA-ZÀ-ÿ\s\-]+$/'
        ],
        'first_name' => [
            'required' => true,
            'min_length' => 2,
            'max_length' => 50,
            'pattern' => '/^[a-zA-ZÀ-ÿ\s\-]+$/'
        ],
        'email' => [
            'required' => true,
            'filter' => FILTER_VALIDATE_EMAIL
        ],
        'password' => [
            'required' => true,
            'min_length' => 8,
            'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
        ],
        'telephone' => [
            'required' => true,
            'pattern' => '/^(77|78|76|70|75)[0-9]{7}$/'
        ],
        'address' => [
            'required' => true,
        ],
        'date_of_birth' => [
            'required' => true,
            'format' => 'jj/mm/aaaa',
        ],
        'place_of_birth' => [
            'required' => true,
        ],
        'tutor_full_name' => [
            'required' => true,
            'min_length' => 2,
            'max_length' => 50,
            'pattern' => '/^[a-zA-ZÀ-ÿ\s\-]+$/'
        ],
        'parent_link' => [
            'required' => true,
            'min_length' => 2,
            'max_length' => 50,
            'pattern' => '/^[a-zA-ZÀ-ÿ\s\-]+$/'
        ],
        'tutor_address' => [
            'required' => true,
        ],
        'tutor_telephone' => [
            'required' => true,
            'pattern' => '/^(77|78|76|70|75)[0-9]{7}$/'
        ],
        
    ],

    Auths::VALIDATE_FIELD->value => function($field, $value, $rules) {
        if ($rules['required'] && empty(trim($value))) {
            return FrErrorMessages::FIELD_REQUIRED->value;
        }

        if (isset($rules['min_length']) && strlen($value) < $rules['min_length']) {
            return FrErrorMessages::MIN->value;
        }

        if (isset($rules['max_length']) && strlen($value) > $rules['max_length']) {
            return FrErrorMessages::MAX->value;
        }

        if (isset($rules['pattern']) && !preg_match($rules['pattern'], $value)) {
            return FrErrorMessages::REGEX->value;
        }

        if (isset($rules['filter']) && !filter_var($value, $rules['filter'])) {
            return FrErrorMessages::INVALID_EMAIL->value;
        }

        return null;
    },

    Auths::VALIDATE_USER->value => function($user_data) {
        global $auth_services;
        $errors = [];

        array_walk($auth_services['validation_rules'], function($rules, $field) use ($user_data, &$errors, $auth_services) {
            if ($error = $auth_services['validate_field']($field, $user_data[$field] ?? '', $rules)) {
                $errors[$field] = $error;
            }
        });

        return empty($errors) ? null : $errors;
    },

    Auths::GENERATE_MATRICULE->value => function() {
        $random = bin2hex(random_bytes(Users::MATRICULE_LENGTH->value / 2));
        return Users::MATRICULE_PREFIX->value . strtoupper(substr($random, 0, Users::MATRICULE_LENGTH->value));
    },

    Auths::GENERATE_PASSWORD->value => function() {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
        $password = '';
        $chars_length = strlen($chars);

        for ($i = 0; $i < Users::DEFAULT_PASSWORD_LENGTH->value; $i++) {
            $password .= $chars[random_int(0, $chars_length - 1)];
        }

        return $password;
    },

    Auths::SEND_WELCOME_EMAIL->value => function($email, $matricule, $password) {
        $subject = "Création de votre compte";
        $message = "Bonjour,\n\nVotre compte a été créé avec succès.\n"
                 . "Matricule: $matricule\n"
                 . "Mot de passe temporaire: $password\n\n"
                 . "Vous devez changer ce mot de passe lors de votre première connexion.\n\n"
                 . "Cordialement,\nL'équipe technique";

        return mail($email, $subject, $message);
    },

    Auths::HASH_PASSWORD->value => function($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    },

    'load_users' => function() {
        if (!file_exists(USER_DATA_FILE)) {
            file_put_contents(USER_DATA_FILE, json_encode([]));
            return [];
        }
        return json_decode(file_get_contents(USER_DATA_FILE), true) ?: [];
    },

    'save_user' => function($user) use (&$auth_services) {
        $users = $auth_services['load_users']();
        $users[$user['matricule']] = $user;
        file_put_contents(USER_DATA_FILE, json_encode($users, JSON_PRETTY_PRINT));
    },

    'find_user' => function($matricule) use (&$auth_services) {
        $users = $auth_services['load_users']();
        return $users[$matricule] ?? null;
    },

    'find_user_by_email' => function($email) use(&$auth_services) {
        $users = $auth_services['load_users']();
        $result = array_filter($users, function($user) use ($email) {
            return $user['email'] === $email;
        });
        return reset($result) ?: null;
    },

    'find_user_by_login' => function($login) use (&$auth_services) {
        $users = $auth_services['load_users']();
        $result = array_filter($users, function($user) use ($login) {
            return $user['login'] === $login;
        });
        return reset($result) ?: null;
    },

    Auths::LOG_AUDIT->value => function($action, $details) {
        $log_entry = sprintf(
            "[%s] %s: %s\n",
            date('Y-m-d H:i:s'),
            $action,
            json_encode($details)
        );
        file_put_contents(Paths::AUDIT_LOG_FILE->value, $log_entry, FILE_APPEND);
    },

    Auths::REGISTER_USER->value => function (array $apprenant): bool {
        global $file_services;
    
        // 1. Charger la base de données
        $db = $file_services[FileServices::JSON_TO_ARRAY->value]();
    
        // 2. Générer un matricule unique
        $matricule = uniqid('P2025');
    
        // 3. Générer un mot de passe aléatoire (8 caractères)
        $password = bin2hex(random_bytes(4)); // 8 caractères hexadécimaux
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // 4. Créer le nouvel apprenant
        $newUser = [
            'matricule' => $matricule,
            'nom' => $apprenant['nom'],
            'prenom' => $apprenant['prenom'],
            'email' => $apprenant['email'],
            'adresse' => $apprenant['adresse'] ?? '',
            'telephone' => $apprenant['telephone'] ?? '',
            'lieu_naissance' => $apprenant['lieu_naissance'] ?? '',
            'date_naissance' => $apprenant['date_naissance'] ?? '',
            'role' => 'Apprenant',
            'role_description' => 'Apprenant',
            'picture' => $apprenant['picture'] ?? '',
            'password' => $hashedPassword,
            'must_change_password' => true
        ];
    
        // 5. Ajouter l'utilisateur
        $db['users'][] = $newUser;
    
        // 6. Sauvegarder
        $file_services[FileServices::ARRAY_TO_JSON->value]($db);
    
        // 7. Envoyer l'email
        return send_user_credentials($newUser['email'], $newUser['prenom'], $password);
    }
    
    
];

