<?php
namespace App\Controllers;

use App\Enums\Routes;

function handle_user_apprenant() {

    $action = $_REQUEST['action'] ?? 'dashboard';

    match ($action) {
        'dashboard' => show_dashboard_apprenant(),
        'modules' => get_all_modules(),
        default => redirect_to_route(Routes::ERROR->resolve())
    };
    return;
}

function show_dashboard_apprenant() {

    render_view('apprenant/dashboard.html.php', 'grid.layout.php', []);
    exit;
}

function get_all_modules() {
    // to be continued
}