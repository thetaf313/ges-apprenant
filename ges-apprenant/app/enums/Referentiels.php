<?php
namespace App\Enums;

enum Referentiels:string {

    case FIND_ALL_REFERENTIELS = 'find_all_referentiels';
    case FIND_ALL_REFERENTIELS_FILTER = 'find_all_referentiels_filter';
    case FIND_ALL_REFERENTIELS_BY_PROMOTION = 'find_all_referentiels_by_promotion';
    case SAVE_REFERENTIEL = 'save_referentiel';
}