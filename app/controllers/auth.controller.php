<?php
namespace App\Controllers;

use App\Enums\Paths;
use App\Enums\Routes;
use App\Enums\Sessions;
use App\Enums\Users;
use App\Enums\Validators;
use App\translate\fr\FrErrorMessages;
use App\translate\fr\FrSuccessMessage;

use function App\Services\session_service_exec;

function handle_auth(): void {

    $action = $_REQUEST['action'] ?? 'login';

    // Tableau d’actions vers fonctions
    match($action) {
        'login' => $_SERVER['REQUEST_METHOD'] === 'POST'
        ? process_login()
        : (session_service_exec(Sessions::GET_USER) 
            ? redirect_to_route(Routes::PROMOTION->resolve())
            : show_login_form()),
        'forgot-password' => show_verify_email_form(),
        'verify-email' => send_reset_link(),
        'reset-password' => show_reset_password_form(),
        'change-password' => update_password(),
        'logout' => logout(),
        default => show_login_form()
    };
    return;
}

function show_login_form() {
    global $session_services;

$flash_success = $session_services[Sessions::GET_FLASH_SUCCESS->value]();
$errors = $session_services[Sessions::GET_ERRORS->value]();
$error_message = $session_services[Sessions::GET_ERROR_MESSAGE->value]();
    
    $data = [
        'title' => 'Connexion',
        'errors' => $errors,
        'error_message' => $error_message,
        'old_input' => $_POST ?? []
    ];
    render_view('auth/login.html.php', 'base.layout.php', $data);
    $session_services[Sessions::UNSET_SESSION->value]('error_message');
    $session_services[Sessions::UNSET_SESSION->value]('errors');
    $session_services[Sessions::UNSET_SESSION->value]('flash_success');
    // $session_services[Sessions::UNSET_SESSION->value]('old_input');
    exit;
}

function show_verify_email_form() {
    global $session_services;
    $errors = $session_services[Sessions::GET_ERRORS->value]();
    $error_message = $session_services[Sessions::GET_ERROR_MESSAGE->value]();

    $data = [
        'title' => 'Verifier Email',
        'error_message' => $error_message,
        'errors' => $errors,
        'old_input' => $_POST ?? []
    ];
    render_view('auth/verify-email.html.php', 'base.layout.php', $data);
    $session_services[Sessions::UNSET_SESSION->value]('errors');
    $session_services[Sessions::UNSET_SESSION->value]('error_message');
    exit;
}

function process_login(): void {
    global $validators_services, $session_services;
    global $user_services;

    $user = [
        'login' => $_POST['login'] ?? '',
        'password' => $_POST['password'] ?? ''
    ];

    $rules = [
        'login' => ['required', str_contains($user['login'], '@') ? 'email' : 'min:7'],
        'password' => ['required', 'min:8']
    ];

    $validation = $validators_services[Validators::VALIDATE->value]($user, $rules);

    if (!$validation['is_valid']) {
        $session_services[Sessions::SET_ERRORS->value]($validation['errors']);
        $session_services[Sessions::SET_OLD_INPUT->value]($user);
        $session_services[Sessions::SET_ERROR_MESSAGE->value](FrErrorMessages::LOGIN_ERROR->value);
        redirect_to_route(Routes::AUTH->resolve());
        exit;
    }

    $authenticated = authenticate_user($user, $user_services);

    if ($authenticated) {
        // $session_services[Sessions::SET_USER->value]($user);
        $session_services[Sessions::SET_FLASH_SUCCESS->value](FrSuccessMessage::LOGIN_SUCCESS->value);
        error_log('Utilisateur authentifié: ' . print_r($_SESSION, true));
        redirect_to_route(Routes::PROMOTION->resolve());
        // render_view('promotion/list_promotion_grid.html.php', 'grid.layout.php');
        exit;
    }
    $session_services[Sessions::SET_ERROR_MESSAGE->value](FrErrorMessages::LOGIN_ERROR->value);
    redirect_to_route(Routes::PROMOTION->resolve());
    exit;
}

function show_forget_password_form(): void {
    global $session_services;
    $errors = $session_services[Sessions::GET_ERRORS->value]();
    $error_message = $session_services[Sessions::GET_ERROR_MESSAGE->value]();

    $data = [
        'title' => 'Mot de passe oublié',
        'error_message' => $error_message,
        'errors' => $errors
    ];
    render_view('auth/forget-password.html.php', 'base.layout.php', $data);
    $session_services[Sessions::UNSET_SESSION->value]('errors');
    $session_services[Sessions::UNSET_SESSION->value]('error_message');
    exit;
}

function find_user_by_email(string $email) : ?array {
    global $user_services;

    $users = $user_services[Users::GET_USERS->value]();

    $filtered = array_filter($users, function($user) use ($email) {
        return $user['email'] === $email;
    });

    return !empty($filtered) ? $filtered[0] : null;
}

function send_reset_link(): void {
    global $validators_services, $session_services;

    $validation = $validators_services[Validators::VALIDATE->value]($_POST, [
        'login' => ['required', 'email']
    ]);

    if (!$validation['is_valid']) {
        $session_services[Sessions::SET_ERRORS->value]($validation['errors']);
        redirect_to_route(Routes::AUTH->resolve() . '?action=forgot-password');
        exit;
    }

    if (find_user_by_email($_POST['login'])) {
        $session_services[Sessions::SET_EMAIL_PASSWORD_TO_UPDATE->value]($_POST['login']);
        redirect_to_route(Routes::AUTH->resolve() . '?action=reset-password');
        exit;
    }
    $session_services[Sessions::SET_ERROR_MESSAGE->value](FrErrorMessages::VERIFY_EMAIL_ERROR->value);
    redirect_to_route(Routes::AUTH->resolve() . '?action=forgot-password');
    exit;
}

function show_reset_password_form(): void {
    global $session_services;
    $errors = $session_services[Sessions::GET_ERRORS->value]();
    $error_message = $session_services[Sessions::GET_ERROR_MESSAGE->value]();
    $data = [
        'title' => 'Réinitialisation du mot de passe',
        'errors' => $errors,
        'error_message' => $error_message
    ];
    render_view('auth/reset-password.html.php', 'base.layout.php', $data);
    $session_services[Sessions::UNSET_SESSION->value]('errors');
    $session_services[Sessions::UNSET_SESSION->value]('error_message');
    exit;
}

// var_dump($_POST);
// exit;

function update_password(): void {
    global $validators_services, $session_services, $user_services;

    $rules = [
        'password' => ['required', 'min:8'],
        'password_confirmation' => ['required', 'min:8', 'same:password'],
    ];

    $validation = $validators_services[Validators::VALIDATE->value]($_POST, $rules);

    if (!$validation['is_valid']) {
        $session_services[Sessions::SET_ERRORS->value]($validation['errors']);
        redirect_to_route(Routes::AUTH->resolve() . '?action=reset-password');
        exit;
    }

    $email = $session_services[Sessions::GET_EMAIL_PASSWORD_TO_UPDATE->value]();
    if (!$email) {
        $session_services[Sessions::SET_ERROR_MESSAGE->value]("Une erreur est survenue.");
        redirect_to_route(Routes::AUTH->resolve() . '?action=login');
        exit;
    }

    $users = $user_services[Users::GET_USERS->value]();

    array_walk($users, function(&$user) use ($email) {
        if ($user['email'] === $email) {
            $user['password'] = $_POST['password'];
        }
    });

    $user_services[Users::SAVE_USER->value]($users);

    $session_services[Sessions::SET_FLASH_SUCCESS->value](FrSuccessMessage::UPDATE_PASSWORD_SUCCESS->value);
    redirect_to_route(Routes::AUTH->resolve());
    exit;
}


function logout(): void {
    global $session_services;

    $session_services[Sessions::DESTROY_SESSION->value]();
    redirect_to_route(Routes::AUTH->resolve());
    exit;
}


// function authenticate_user(array $user, $user_services): bool {
//     global $session_services;

//     $users = $user_services[Users::GET_USERS->value]();
//     $user_found = $user_services[Users::FIND_USER->value]($users, $user);

//     if ($user_found) {
        
//         $session_services[Sessions::SET_USER->value]([
//             'email' => $user_found['email'],
//             'nom' => $user_found['nom'],
//             'prenom' => $user_found['prenom'],
//             'role' => $user_found['role'],
//             'login' => $user['login']
//         ]);
//         return true;
//     }
//     return false;
// }

function authenticate_user(array $user, $user_services): bool {
    global $session_services;

    $users = $user_services[Users::GET_USERS->value]();
    $user_found = $user_services[Users::FIND_USER->value]($users, $user);

    if ($user_found) {
        // Stockage complet de l'utilisateur
        $session_services[Sessions::SET_USER->value]([
            'email' => $user_found['email'],
            'nom' => $user_found['nom'],
            'prenom' => $user_found['prenom'],
            'role' => $user_found['role'],
            'authenticated' => true
        ]);
        return true;
    }
    return false;
}

function get_all_users() : array {
    global $user_services;

    return $user_services[Users::GET_USERS->value]();
}
