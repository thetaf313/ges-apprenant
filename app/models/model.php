<?php
namespace App\Models;

require_once __DIR__ . '/../enums/FileServices.php';
require_once __DIR__ . '/../enums/Paths.php';
require_once __DIR__ . '/../enums/Users.php';
require_once __DIR__ . '/../enums/Promotions.php';


use App\Enums\FileServices;
use App\Enums\Paths;
use App\Enums\Users;

require_once Paths::MODELS->resolve('user.model.php');
require_once Paths::MODELS->resolve('promotion.model.php');
require_once Paths::MODELS->resolve('referentiel.model.php');
require_once Paths::MODELS->resolve('apprenant.model.php');
require_once Paths::MODELS->resolve('auth.model.php');

$file_services = [
        FileServices::JSON_TO_ARRAY->value => function (): array {
            $path = Paths::DATA->value;
        
            if (!file_exists($path)) {
                return [];
            }
        
            $content = file_get_contents($path);
            return json_decode($content, true) ?? [];
        },
    
        FileServices::ARRAY_TO_JSON->value => function (array $data): void {
            $path = Paths::DATA->value;
            file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
        }
];
