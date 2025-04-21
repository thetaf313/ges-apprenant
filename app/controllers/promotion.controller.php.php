<?php


function handle_promotion(): void {
    $action = $_REQUEST['action'] ?? 'list';
    $recherche = $_REQUEST['recherche'] ?? '';

    match($action) {
        'list' => get_all_promotion(),
        'process_login' => process_login(),
        'logout' => logout(),
        default => show_login_form()
    };
}

function get_all_promotions() : void {
    
}