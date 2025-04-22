<?php
namespace App\Services;

use App\Enums\Sessions;

$session_services = [
    Sessions::START_SESSION->value => function () : void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    },

    Sessions::UNSET_SESSION->value => function(string $key) use (&$session_services) : void {
        $session_services[Sessions::START_SESSION->value]();
        unset($_SESSION[$key]);
    },

    Sessions::GET_USER->value => function() use (&$session_services) : ?array {
        $session_services[Sessions::START_SESSION->value]();
        return $_SESSION['user'] ?? null;
    },

    Sessions::SET_USER->value => function(array $user) use (&$session_services) : void {
        $session_services[Sessions::START_SESSION->value]();
        $_SESSION['user'] = $user;
    },

    Sessions::SET_ERRORS->value => function(array $errors) use (&$session_services) : void {
        $session_services[Sessions::START_SESSION->value]();
        $_SESSION['errors'] = $errors;
    },

    Sessions::GET_ERRORS->value => function() use (&$session_services) : ?array {
        $session_services[Sessions::START_SESSION->value]();
        return $_SESSION['errors'] ?? null;
    },

    Sessions::SET_OLD_INPUT->value => function(array $inputs) use (&$session_services) : void {
        $session_services[Sessions::START_SESSION->value]();
        $_SESSION['old_input'] = $inputs;
    },

    Sessions::GET_OLD_INPUT->value => function() use (&$session_services) : ?array {
        $session_services[Sessions::START_SESSION->value]();
        return $_SESSION['old_input'] ?? null;
        
    },

    Sessions::SET_ERROR_MESSAGE->value => function(string $error_message) use (&$session_services) : void {
        $session_services[Sessions::START_SESSION->value]();
        $_SESSION['error_message'] = $error_message;
    },

    Sessions::GET_ERROR_MESSAGE->value => function() use (&$session_services) : ? string {
        $session_services[Sessions::START_SESSION->value]();
        return $_SESSION['error_message'] ?? '';
    },

    Sessions::SET_FLASH_SUCCESS->value => function(string $flash_success) use (&$session_services) : void {
        $session_services[Sessions::START_SESSION->value]();
        $_SESSION['flash_success'] = $flash_success;
    },

    Sessions::GET_FLASH_SUCCESS->value => function() use (&$session_services) : ?string {
        $session_services[Sessions::START_SESSION->value]();
        return $_SESSION['flash_success'] ?? '';
    },

    Sessions::SET_EMAIL_PASSWORD_TO_UPDATE->value => function(string $email) use (&$session_services) : void {
        $session_services[Sessions::START_SESSION->value]();
        $_SESSION['email_password_to_update'] = $email;
    },

    Sessions::GET_EMAIL_PASSWORD_TO_UPDATE->value => function() use (&$session_services) : string {
        $session_services[Sessions::START_SESSION->value]();
        return $_SESSION['email_password_to_update'] ?? '';
    },

    Sessions::DESTROY_SESSION->value => function () use (&$session_services) : void {
        $session_services[Sessions::START_SESSION->value]();
        session_destroy();
    }
];




// function start_session(): void {
//     if (session_status() === PHP_SESSION_NONE) {
//         session_start();
//     }
// }

// function set_user(array $user): void {
//     start_session();
//     $_SESSION['user'] = $user;
// }

// function get_user(): ?array {
//     start_session();
//     return $_SESSION['user'] ?? null;
// }

// function logout(): void {
//     start_session();
//     session_destroy();
// }
