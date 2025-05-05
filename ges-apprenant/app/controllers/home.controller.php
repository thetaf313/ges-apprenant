<?php
namespace App\Controllers;

use App\Enums\Routes;

function handle_home() {
    
    // role_middleware();
    redirect_to_route(Routes::PROMOTION->resolve());
}