<?php

use App\Enums\Paths;

use function App\Controllers\render_view;

function handle_error() {

    $code = $_REQUEST['code'] ?? '';

    if ($code && $code==404) {
        render_view('error/404.php', 'base.layout.php');
        exit;
    }
}

function error_notFound(array $params = []) {
    header("HTTP/1.0 404 Not Found");
    echo "Page non trouvée - Contrôleur spécifique";
}

function error_forbidden(array $params = []) {
    header("HTTP/1.0 403 Forbidden");
    echo "Accès refusé";
}