<?php
namespace App\Models;

use App\Enums\Paths;

require_once Paths::MODELS->resolve('model.php');

use App\Enums\FileServices;
use App\Enums\Users;

$user_services = [];

$user_services = [

    Users::GET_USERS->value => function() use (&$file_services) : array {
        $data = $file_services[FileServices::JSON_TO_ARRAY->value]();
        return $data['users'] ?? [];
    },

    Users::FIND_USER->value => function(array $users, array $user_to_find) {
        $filtered = array_filter($users, fn($user) =>
            ($user['email'] === $user_to_find['login'] || $user['matricule'] === $user_to_find['login']) && $user['password'] === $user_to_find['password']
        );
        // return !empty($filtered) ? $filtered[0] : null;
        return !empty($filtered) ? array_values($filtered)[0] : null;
    },

    Users::SAVE_USER->value => function(array $users) use (&$file_services) : void {
        $data = $file_services[FileServices::JSON_TO_ARRAY->value]();
        $data['users'] = $users;
        $file_services[FileServices::ARRAY_TO_JSON->value]($data);
    },

];


function user_service_exec(Users $action, ...$args) {
    global $user_services;
    return $user_services[$action->value](...$args);
}