<?php
namespace App\Services;

use function App\Controllers\render_view;


function add_route(array &$routes, string $path, callable $handler) {
    $routes[$path] = $handler;
}

function dispatch_request(array $routes) {
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    
    if (array_key_exists($requestUri, $routes)) {
        $routes[$requestUri]();
    } else {
        header("HTTP/1.0 404 Not Found");
        render_view('error/404.php', 'base.layout.php');
    }
}

function redirect(string $path) {
    header("Location: $path");
    exit;
}