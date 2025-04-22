<?php
namespace App\Controllers;

// require_once __DIR__ . './../enums/Paths.php';
// require_once __DIR__ . './../enums/Users.php';
// require_once __DIR__ . './../enums/Sessions.php';
// require_once __DIR__ . './../enums/Validators.php';
// require_once __DIR__ . './../translate/fr/error.fr.php';
// require_once __DIR__ . './../translate/fr/message.fr.php';


use App\Enums\Paths;
use App\Enums\Sessions;
use App\Enums\Users;
use App\Enums\Validators;
use App\translate\fr\FrErrorMessages;
use App\translate\fr\FrSuccessMessage;


function handle_auth(): void {
    $action = $_REQUEST['action'] ?? 'login';

    match($action) {
        'login' => $_SERVER['REQUEST_METHOD'] === 'POST' ? process_login() : show_login_form(),
        // 'process_login' => process_login(),
        'forgot-password' => show_verify_email_form(),
        'verify-email' => send_reset_link(),
        'send-reset-link' => send_reset_link(),
        'reset-password' => show_reset_password_form(),
        'update-password' => update_password(),
        'logout' => logout(),
        default => show_login_form()
    };
    return;
}

function show_login_form(): void {
    global $session_services;
    // Repetition (mettre dans une fonction)
    $errors = $session_services[Sessions::GET_ERRORS->value]();
    $error_message = $session_services[Sessions::GET_ERROR_MESSAGE->value]();
    $flash_success = $session_services[Sessions::GET_FLASH_SUCCESS->value]();
    $session_services[Sessions::UNSET_SESSION->value]('error_message');
    $session_services[Sessions::UNSET_SESSION->value]('errors');
    $session_services[Sessions::UNSET_SESSION->value]('flash_success');
    // $session_services[Sessions::UNSET_SESSION->value]('old_input');
    $data = [
        'title' => 'Connexion',
        'errors' => $errors,
        'error_message' => $error_message,
        'old_input' => $_POST ?? []
    ];
    render_view('auth/login.html.php', 'base.layout.php', $data);
   
    var_dump($_SESSION);
    die;
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
        redirect_to_route('/?page=auth&action=login');
        return;
    }

    $authUser = authenticate_user($user, $user_services);

    if ($authUser) {
        $session_services[Sessions::SET_USER->value]($user);
        $session_services[Sessions::SET_FLASH_SUCCESS->value](FrSuccessMessage::LOGIN_SUCCESS->value);
        redirect_to_route('/?page=promotion');
        exit;
    }
    $session_services[Sessions::SET_ERROR_MESSAGE->value](FrErrorMessages::LOGIN_ERROR->value);
    redirect_to_route('/?page=auth&action=login');
    exit;
}

function show_forget_password_form(array $errors = []): void {
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
        redirect_to_route('?page=auth&action=forgot-password');
        exit;
    }

    if (find_user_by_email($_POST['login'])) {
        $session_services[Sessions::SET_EMAIL_PASSWORD_TO_UPDATE->value]($_POST['login']);
        show_reset_password_form();
        exit;
    }
    $session_services[Sessions::SET_ERROR_MESSAGE->value](FrErrorMessages::VERIFY_EMAIL_ERROR->value);
    redirect_to_route('?page=auth&action=forgot-password');
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
        redirect_to_route('/?page=auth&action=reset-password');
        exit;
    }

    $email = $session_services[Sessions::GET_EMAIL_PASSWORD_TO_UPDATE->value]();
    if (!$email) {
        $session_services[Sessions::SET_ERROR_MESSAGE->value]("Une erreur est survenue.");
        redirect_to_route('/?page=auth&action=login');
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
    redirect_to_route('/?page=auth&action=login');
    exit;
}


function logout(): void {
    global $session_services;

    $session_services[Sessions::DESTROY_SESSION->value]();
    redirect_to_route('/?page=auth&action=login');
    exit;
}

// Simulé - à remplacer par votre vraie logique métier
function authenticate_user(array $user, $user_services): bool {

    global $session_services;

    if (!isset($user_services[Users::GET_USERS->value])) {
        var_dump($user_services);
        die("GET_USERS function not found in user_services");
    }

    $users = $user_services[Users::GET_USERS->value]();

    $user_found = $user_services[Users::FIND_USER->value]($users, $user);

    if ($user_found) {
        $session_services[Sessions::SET_USER->value](
            [
                $user_found['email'], 
                $user_found['nom'],
                $user_found['prenom'],
                $user_found['role']
            ]
            );
        return true;
    }

    return false;
}

function get_all_users() : array {
    global $user_services;

    return $user_services[Users::GET_USERS->value]();
}



handle_auth();
