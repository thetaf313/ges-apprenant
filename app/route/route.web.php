<?php
namespace App\Route;

require_once __DIR__ . './../enums/Paths.php';
require_once __DIR__ . './../enums/Urls.php';
require_once __DIR__ . './../enums/Sessions.php';

use App\Enums\Paths;
use App\Enums\Urls;
use App\Enums\Sessions;
use App\Enums\FileServices;

require_once Paths::MODELS->resolve('model.php');
require_once Paths::SERVICES->resolve('session.service.php');
require_once Paths::SERVICES->resolve('validator.service.php');
require_once Paths::CONTROLLERS->resolve('controller.php');


function handle_route(): void {
    // Liste des routes autorisées
    $routes = [
        '' => 'auth.controller.php',
        'auth' => 'auth.controller.php',
        'promotion' => 'promotion.controller.php',
        'referentiel' => 'referentiel.controller.php'
    ];

    // Récupération de la page demandée
    $page = $_REQUEST['page'] ?? '';
    
    if (array_key_exists($page, $routes)) {
        $controllerFile = Paths::CONTROLLERS->resolve($routes[$page]);
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            return;
        }
    }

    // Route non trouvée
    require_once Paths::CONTROLLERS->resolve('error.controller.php');
    http_response_code(404);
}