<?php
namespace App\Controllers;

use App\Enums\Routes;
use App\Enums\Sessions;

use function App\Services\session_service_exec;

function handle_home() {
    
    // role_middleware();
    $user = session_service_exec(Sessions::GET_USER);

    if ($user) {
        $role = $user['role'];
        match ($role) {
            'Admin' => redirect_to_route(Routes::PROMOTION->resolve()),
            'Apprenant' => redirect_to_route(Routes::USER_APPRENANT->resolve()),
            'Vigile' => redirect_to_route(Routes::USER_VIGILE->resolve()),
            default => redirect_to_route(Routes::ERROR->resolve())
        };
        return;
    }
    redirect_to_route(Routes::AUTH->resolve());
}