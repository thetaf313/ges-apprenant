<?php
namespace App\Models;

use App\Enums\Paths;

require_once Paths::MODELS->resolve('model.php');

use App\Enums\FileServices;
use App\Enums\Users;

$file_services = require Paths::MODELS->resolve('user.model.php');

$user_services = [

    Users::GET_USERS->value => function() use (&$file_services) : array {
        $data = $file_services[FileServices::JSON_TO_ARRAY->value]();
        return $data['users'] ?? [];
    },

    Users::FIND_USER->value => function(array $users, array $user_to_find) {
        $filtered = array_filter($users, fn($user) =>
            $user['login'] === $user_to_find[0] && $user['password'] === $user_to_find[1]
        );
        return !empty($filtered) ? array_values($filtered)[0] : null;
    }
];
