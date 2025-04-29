<?php
// app/Enums/Routes.php
namespace App\Enums;

enum Routes: string {
    case HOME = '/';
    case AUTH = '/auth';
    // case LOGOUT = '/logout';
    case PROMOTION = '/promotion';
    case REFERENTIEL = '/referentiel';
    case APPRENANT = '/apprenant';
    case ERROR = '/error';
    
    public function resolve(string $path = ''): string {
        return $this->value . $path;
    }
}