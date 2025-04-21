<?php
namespace App\Controllers;

use App\Enums\Paths;
use App\Enums\Sessions;
use App\Enums\Validators;
use App\Services\SessionService;
use App\Services\Vali


function handle_auth(): void {
    $action = $_REQUEST['action'] ?? 'login';

    match($action) {
        'login' => $_SERVER['REQUEST_METHOD'] === 'POST' ? process_login() : show_login_form(),
        'process_login' => process_login(),
        'forget-password' => show_forget_password_form(),
        'send-reset-link' => send_reset_link(),
        'reset-password' => show_reset_password_form(),
        'update-password' => update_password(),
        'logout' => logout(),
        default => show_login_form()
    };
}

function show_login_form(array $errors = []): void {
    $data = [
        'title' => 'Connexion',
        'errors' => $errors,
        'old_input' => $_POST ?? []
    ];
    render_view('auth/login.html.php', 'base.layout.php', $data);
}

function process_login(): void {

    $user = [
        'login' => $_POST['login'] ?? '',
        'password' => $_POST['password'] ?? ''
    ];
    // Validation des données
    $rules = [
        'login' => ['required', str_contains($user['login'], '@') ? 'email' : 'min:7'],
        'password' => ['required', 'min:8']
    ];
    
    
    
    if (!$validation['is_valid']) {
        show_login_form($validation['errors']);
        return;
    }

    // Authentification (exemple simplifié)
    $user = authenticate_user($_POST['login'], $_POST['password']);
    
    if ($user) {
        SessionService::set(Sessions::USER->value, $user);
        SessionService::setFlash('success', 'Connexion réussie !');
        header('Location: ?page=dashboard');
        exit;
    }
    
    show_login_form(['general' => 'Identifiants incorrects']);
}

function show_forget_password_form(array $errors = []): void {
    $data = [
        'title' => 'Mot de passe oublié',
        'errors' => $errors
    ];
    render_view('auth/forget-password.html.php', 'base.layout.php', $data);
}

function send_reset_link(): void {
    $validator = new ValidatorService();
    $validation = $validator->validate($_POST, ['email' => ['required', 'email']]);
    
    if (!$validation['is_valid']) {
        show_forget_password_form($validation['errors']);
        return;
    }
    
    // Envoi du lien de réinitialisation (simulé)
    $token = bin2hex(random_bytes(32));
    SessionService::setFlash('reset_token', $token);
    SessionService::setFlash('success', 'loginUn lien de réinitialisation a été envoyé à votre email');
    
    header('Location: ?page=auth&action=reset-password&token='.$token);
    exit;
}

function show_reset_password_form(): void {
    $token = $_GET['token'] ?? '';
    
    if (!SessionService::verifyFlash('reset_token', $token)) {
        SessionService::setFlash('error', 'Lien invalide ou expiré');
        header('Location: ?page=auth&action=forget-password');
        exit;
    }
    
    $data = [
        'title' => 'Réinitialisation du mot de passe',
        'token' => $token
    ];
    render_view('auth/reset-password.html.php', 'base.layout.php', $data);
}

function update_password(): void {
    $validator = new ValidatorService();
    $rules = [
        'password' => ['required', 'min:8', 'confirmed'],
        'token' => ['required']
    ];
    
    $validation = $validator->validate($_POST, $rules);
    
    if (!$validation['is_valid']) {
        show_reset_password_form($validation['errors']);
        return;
    }
    
    if (!SessionService::verifyFlash('reset_token', $_POST['token'])) {
        SessionService::setFlash('error', 'Lien invalide ou expiré');
        header('Location: ?page=auth&action=forget-password');
        exit;
    }
    
    // Mise à jour du mot de passe (simulé)
    $user = SessionService::get(Sessions::USER->value);
    if ($user) {
        // Ici vous mettriez à jour le mot de passe en base de données
        // update_user_password($user['id'], $_POST['password']);
    }
    
    SessionService::setFlash('success', 'Votre mot de passe a été mis à jour');
    header('Location: ?page=auth&action=login');
    exit;
}

function logout(): void {
    SessionService::destroy();
    header('Location: ?page=auth&action=login');
    exit;
}

// Fonction utilitaire fictive - à remplacer par votre vraie logique
function authenticate_user(string $login, string $password): ?array {
    // Exemple simplifié - en pratique vous vérifieriez en base de données
    $validUsers = [
        'admin' => password_hash('admin123', PASSWORD_BCRYPT),
        'user' => password_hash('user123', PASSWORD_BCRYPT)
    ];
    
    if (isset($validUsers[$login]) && password_verify($password, $validUsers[$login])) {
        return [
            'id' => 1,
            'login' => $login,
            'role' => ($login === 'admin') ? 'admin' : 'user'
        ];
    }
    
    return null;
}

function validate_user(array $user, array $rules) : array {
    // Validation des données
    $rules = [
        'login' => ['required', str_contains($user['login'], '@') ? 'email' : 'min:7'],
        'password' => ['required', 'min:8']
    ];
}

handle_auth();