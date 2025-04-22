<?php
namespace App\Route;

require_once __DIR__ . './../enums/Paths.php';
require_once __DIR__ . './../enums/Urls.php';
require_once __DIR__ . './../enums/Sessions.php';
require_once __DIR__ . './../enums/Users.php';
require_once __DIR__ . './../enums/Validators.php';
require_once __DIR__ . './../translate/fr/error.fr.php';
require_once __DIR__ . './../translate/fr/message.fr.php';

use App\Enums\Paths;
// use App\Enums\Urls;
// use App\Enums\Sessions;
// use App\Enums\FileServices;
// use App\Enums\Users;
// use App\Enums\Validators;

use function App\Controllers\redirect_to_route;

require_once Paths::MODELS->resolve('model.php');
require_once Paths::SERVICES->resolve('session.service.php');
require_once Paths::SERVICES->resolve('validator.service.php');
require_once Paths::CONTROLLERS->resolve('controller.php');

// Initialisation de la session
session_start();


function handle_route(): void {
    // Liste des routes autorisées
    $routes = [
        '' => 'auth.controller.php',
        'auth' => 'auth.controller.php',
        'promotion' => 'promotion.controller.php',
        'referentiel' => 'referentiel.controller.php',
        'error' => 'error.controller.php'
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
    redirect_to_route('/?page=error&code=404');
    //require_once Paths::CONTROLLERS->resolve('error.controller.php');
    //http_response_code(404);
}