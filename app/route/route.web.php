<?php
namespace App\Route;

require_once __DIR__ . './../enums/Paths.php';
require_once __DIR__ . './../enums/Routes.php';
require_once __DIR__ . './../enums/Urls.php';
require_once __DIR__ . './../enums/Sessions.php';
require_once __DIR__ . './../enums/Users.php';
require_once __DIR__ . './../enums/Validators.php';
require_once __DIR__ . './../translate/fr/error.fr.php';
require_once __DIR__ . './../translate/fr/message.fr.php';

use App\Enums\Paths;
use App\Enums\Routes;
use App\Enums\Sessions;

session_start();

require_once Paths::MODELS->resolve('model.php');
require_once Paths::SERVICES->resolve('session.service.php');
require_once Paths::SERVICES->resolve('validator.service.php');
require_once Paths::CONTROLLERS->resolve('controller.php');

use function App\Controllers\redirect_to_route;
use function App\Controllers\handle_auth;
use function App\Controllers\handle_home;
use function App\Controllers\handle_promotion;
use function App\Controllers\handle_referentiel;


/**
 * Tableau des routes et de leurs handlers
 * 
 * @var array<string, callable> $routes
 */
$routes = [
    Routes::HOME->value => function() {
        require_once Paths::CONTROLLERS->resolve('home.controller.php');
        handle_home();
    },

    Routes::AUTH->value => function() {
        require_once Paths::CONTROLLERS->resolve('auth.controller.php');
        handle_auth();
    },
    
    
    Routes::PROMOTION->value => function() {
        require_once Paths::CONTROLLERS->resolve('promotion.controller.php');
        handle_promotion();
    },
    
    Routes::REFERENTIEL->value => function() {
        require_once Paths::CONTROLLERS->resolve('referentiel.controller.php');
        handle_referentiel();
    },

    Routes::ERROR->value => function() {
        require_once Paths::CONTROLLERS->resolve('error.controller.php');
        handle_error();
    }
];

/**
 * Gère la route actuelle
 */
function handle_route(): void {
    global $routes;
    
    // Récupère à la fois le path et les query params
    $request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    // $path = strtok($request_uri, '?'); // Extrait le path avant le ?
    
    // Trouver la route qui correspond
    foreach ($routes as $route_path => $handler) {
        if ($route_path === $request_path) {
            $handler();
            return;
        }
    }
    
    // Route non trouvée
    http_response_code(404);
    redirect_to_route('/error?code=404');
    exit;
}


// Exécute le routeur
handle_route();