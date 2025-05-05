<?php
namespace App\Models;

use App\Enums\FileServices;
use App\Enums\Promotions;
use App\Enums\Referentiels;

global $promotion_services, $file_services;

$referentiel_services = [

    Referentiels::FIND_ALL_REFERENTIELS->value => function () use (&$file_services): array {
        $data = $file_services[FileServices::JSON_TO_ARRAY->value]();
        return $data['referentiels'] ?? [];
    },

    Referentiels::FIND_ALL_REFERENTIELS_FILTER->value => function ($filter = '', $page = 1, $limit = 4) use (&$referentiel_services, &$promotion_services): array {
        // $active_promotion = $promotion_services[Promotions::FIND_ACTIVE_PROMOTION->value]();
        $all_referentiels = $referentiel_services[Referentiels::FIND_ALL_REFERENTIELS->value]();
    
        // if ($active_promotion) {
        //     $active_promotion_refs = $active_promotion['referentiels'];
        //     $referentiels = array_filter($all_referentiels, fn($ref) => in_array($ref['nom_referentiel'], $active_promotion_refs));
        // } else {
        //     $referentiels = [];
        // }
    
        if (!empty($search)) {
            $all_referentiels = array_filter($all_referentiels, fn($ref) => stripos($ref['nom_referentiel'], $search) !== false);
        }
    
        $total = count($all_referentiels);
        $offset = ($page - 1) * $limit;
        $referentiels = array_slice($all_referentiels, $offset, $limit);
        $stats = $promotion_services[Promotions::GET_GLOBAL_STATS->value]();
    
        return [
            'stats' => $stats,
            'referentiels' => $referentiels,
            'total' => $total,
            'pages' => ceil($total / $limit)
        ];
    },

    Referentiels::FIND_ALL_REFERENTIELS_BY_PROMOTION->value => function($search = '', $page = 1, $limit = 4) use (&$promotion_services, &$referentiel_services) {

        $active_promotion = $promotion_services[Promotions::FIND_ACTIVE_PROMOTION->value]();
        $all_referentiels = $referentiel_services[Referentiels::FIND_ALL_REFERENTIELS->value]();
    
        if ($active_promotion) {
            $active_promotion_refs = $active_promotion['referentiels'];
            $referentiels = array_filter($all_referentiels, fn($ref) => in_array($ref['nom_referentiel'], $active_promotion_refs));
        } else {
            $referentiels = [];
        }
    
        if (!empty($search)) {
            $referentiels = array_filter($referentiels, fn($ref) => stripos($ref['nom_referentiel'], $search) !== false);
        }
    
        $total = count($referentiels);
        $offset = ($page - 1) * $limit;
        $referentiels = array_slice($referentiels, $offset, $limit);
        $stats = $promotion_services[Promotions::GET_GLOBAL_STATS->value]();
    
        return [
            'stats' => $stats,
            'referentiels' => $referentiels,
            'total' => $total,
            'pages' => ceil($total / $limit)
        ];
    },

    Referentiels::SAVE_REFERENTIEL->value => function(array $referentiel) use (&$file_services) {
        $data = $file_services[FileServices::JSON_TO_ARRAY->value]();
        
        $data['referentiels'][] = $referentiel;
        
        $file_services[FileServices::ARRAY_TO_JSON->value]($data);
    },
    
];




function referentiel_service_exec(Referentiels $referentiel, ...$args) {
    global $referentiel_services;
    
    if (!isset($referentiel_services[$referentiel->value])) {
        throw new \RuntimeException("Service de promotion non trouvé : " . $referentiel->value);
    }
    
    return $referentiel_services[$referentiel->value](...$args);
}
