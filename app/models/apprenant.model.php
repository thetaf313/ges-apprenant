<?php

namespace App\Models;

use App\Enums\Apprenants;
use App\Enums\FileServices;
use App\Enums\Promotions;

// global $promotion_services, $file_services;

$apprenant_services = [

    Apprenants::FIND_ALL_APPRENANTS->value => function () use (&$file_services, &$promotion_services) : array {
        $active_promotion = $promotion_services[Promotions::FIND_ACTIVE_PROMOTION->value]();
        
        if (empty($active_promotion)) {
            return [];
        }
        
        $all_apprenants = $file_services[FileServices::JSON_TO_ARRAY->value]()['apprenants'] ?? [];
        
        $filtered = array_filter($all_apprenants, 
            fn($apprenant) => isset($apprenant['promotion']) && $apprenant['promotion'] === $active_promotion['nom_promotion']);
        
        return !empty($filtered) ? array_values($filtered) : [];
    },

    Apprenants::FIND_ALL_APPRENANTS_FILTER->value => function ($filter_ref='', $filter_status='', $search='', $page=1, $limit=4) use (&$apprenant_services, &$promotion_services) {

        $active_promotion = $promotion_services[Promotions::FIND_ACTIVE_PROMOTION->value]();

        $apprenants = $apprenant_services[Apprenants::FIND_ALL_APPRENANTS->value]();
    
    
        // Filtrage
        if (in_array($filter_ref, $active_promotion['referentiels'])) {
            $apprenants = array_filter($apprenants, fn($apprenant) => $apprenant['referentiel'] === $filter_ref);
        }
        
        if ($filter_status === 'actif') {
            $apprenants = array_filter($apprenants, fn($apprenant) => $apprenant['status'] === 'actif');
        } elseif ($filter_status === 'remplace') {
            $apprenants = array_filter($apprenants, fn($apprenant) => $apprenant['status'] === 'remplace');
        }
    
        // Recherche
        if (!empty($search)) {
            $apprenants = array_filter($apprenants, fn($apprenant) => stripos($apprenant['matricule'], $search) !== false);
        }

        // Pagination
        $total = count($apprenants);
        $offset = ($page - 1) * $limit;
        $apprenants = array_slice($apprenants, $offset, $limit);
        // $stats = $promotion_services[Promotions::GET_GLOBAL_STATS->value]();
    
        return [
            // 'stats' => $stats,
            'apprenants' => $apprenants,
            'total' => $total,
            'pages' => ceil($total / $limit)
        ];
    },

];