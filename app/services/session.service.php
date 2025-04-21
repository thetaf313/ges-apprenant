<?php
namespace App\Services;

use App\Enums\Sessions;

return [
    Sessions::START_SESSION->value => function () : void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    },

    Sessions::GET_USER->value => function() : ?array {
        session_start();
        return $_SESSION['user'] ?? null;
    },

    Sessions::SET_USER->value => function(array $user) : void {
        session_start();
        $_SESSION['user'] = $user;
    },

    Sessions::DESTROY_SESSION->value => function () : void {
        session_start();
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
