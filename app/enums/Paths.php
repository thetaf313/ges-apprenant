<?php
namespace App\Enums;

enum Paths: string {
    case ROUTE = __DIR__ . '/../route/route.web.php';
    case DATA = __DIR__ . '/../../data/data.json';
    case STAND_BY_APPRENANTS_FILE = __DIR__ . '/../../data/stand_by_apprenants.json';
    case AUDIT_LOG_FILE = __DIR__ . '/../../data/audit.log';

    case VIEWS = __DIR__ . '/../views/';
    case LAYOUTS = __DIR__ . '/../views/layout/';
    case CONTROLLERS = __DIR__ . '/../controllers/';
    case SERVICES = __DIR__ . '/../services/';
    case MODELS = __DIR__ . '/../models/';
    case Fr_Messages = __DIR__ . '/../translate/fr/';
    case Us_Messages = __DIR__ . '/../translate/us/';
    
    public function resolve(string $path = ''): string {
        return $this->value . $path;
    }
}