<?php
namespace App\Models;

require_once __DIR__ . '/../enums/FileServices.php';
require_once __DIR__ . '/../enums/Paths.php';
require_once __DIR__ . '/../enums/Users.php';
require_once __DIR__ . '/../enums/Promotions.php';


use App\Enums\FileServices;
use App\Enums\Paths;
use App\Enums\Users;

use function PHPSTORM_META\map;

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
        },

        // Duplication  à corriger
        FileServices::GET_STAND_BY_APPRENANTS_FILE->value => function (): array {
            $path = Paths::STAND_BY_APPRENANTS_FILE->value;
        
            if (!file_exists($path)) {
                return [];
            }
        
            $content = file_get_contents($path);
            return json_decode($content, true) ?? [];
        },

        FileServices::SET_STAND_BY_APPRENANTS_FILE->value => function (array $data): void {
            $path = Paths::STAND_BY_APPRENANTS_FILE->value;
            file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
        },
];
