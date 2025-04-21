<?php
require_once __DIR__ . './../app/route/route.web.php';

use function App\Route\handle_route;

// Initialisation de la session
session_start();

handle_route();
