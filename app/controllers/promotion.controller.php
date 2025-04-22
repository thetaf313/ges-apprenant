<?php
namespace App\Controllers;

// require_once __DIR__ . './../enums/Paths.php';

use App\Enums\Paths;
use App\Enums\Sessions;

function handle_promotion(): void {
    global $session_services;

    $user = $session_services[Sessions::GET_USER->value]();

    var_dump($_SESSION);
    exit;
    if ($user) {
        $action = $_REQUEST['action'] ?? 'list';
        $recherche = $_REQUEST['recherche'] ?? '';

        match($action) {
            'list' => get_all_promotions(),
            'add' => add_promotion(),
            default => get_all_promotions()
        };
    } 
    else {
        redirect_to_route('/?page=auth&action=login');
        exit;
    }

}

function get_all_promotions() : void {
    //
    render_view('promotion/list_promotion_grid.html.php', 'grid.layout.php', []);
    exit;
}

function add_promotion() {

}

handle_promotion();

die('Contrôleur promotion bien appelé');
