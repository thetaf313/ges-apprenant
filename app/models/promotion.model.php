<?php
namespace App\Models;

use App\Enums\FileServices;
use App\Enums\Promotions;
use App\Enums\Sessions;

global $file_services;

$promotion_services = [

    Promotions::FIND_ALL_PROMOTIONS->value => function () use (&$file_services): array {
        $data = $file_services[FileServices::JSON_TO_ARRAY->value]();
        return $data['promotions'] ?? [];
    },

    Promotions::FIND_PROMOTION_BY_NAME->value => function (string $name) use (&$promotion_services): ?array {
        $promotions = $promotion_services[Promotions::FIND_ALL_PROMOTIONS->value]();
        $result = array_filter($promotions, fn($promo) => strcasecmp($promo['nom_promotion'], $name) === 0);
        return !empty($result) ? array_values($result)[0] : null;
    },

    Promotions::CHANGE_PROMOTION_STATUS->value => function (string $name, string $status) use (&$file_services): bool {
        $data = $file_services[FileServices::JSON_TO_ARRAY->value]();
    
        $data['promotions'] = array_map(function ($promo) use ($name, $status) {
            if (strcasecmp($promo['nom_promotion'], $name) === 0) {
                $promo['etat'] = $status;
            } else {
                // On désactive les autres si on active celle-ci
                if (strtolower($status) === 'active') {
                    $promo['etat'] = 'inactive';
                }
            }
            return $promo;
        }, $data['promotions'] ?? []);
    
        $file_services[FileServices::ARRAY_TO_JSON->value]($data);
        return true;
    },    

    Promotions::SAVE_PROMOTION->value => function (array $data) use (&$file_services, &$promotion_services): void {
        $db = $file_services[FileServices::JSON_TO_ARRAY->value]();
        $db['promotions'][] = $data;
        $file_services[FileServices::ARRAY_TO_JSON->value]($db);
    },

    Promotions::ADD_REFERENTIEL_TO_PROMOTION->value => function (string $promotion_name, string $referentiel_name) use (&$file_services): bool {
        $data = $file_services[FileServices::JSON_TO_ARRAY->value]();

        $data['promotions'] = array_map(function ($promo) use ($promotion_name, $referentiel_name) {
            if (strcasecmp($promo['nom_promotion'], $promotion_name) === 0) {
                if (!in_array($referentiel_name, $promo['referentiels'])) {
                    $promo['referentiels'][] = $referentiel_name;
                }
            }
            return $promo;
        }, $data['promotions'] ?? []);

        $file_services[FileServices::ARRAY_TO_JSON->value]($data);
        return true;
    },

    Promotions::FIND_ALL_REFERENTIELS_BY_PROMOTION->value => function(string $promotion_name) {
        $promos = promotion_service_exec(Promotions::FIND_ALL_PROMOTIONS);
        $filtered = array_filter($promos, function($promo) {
            return $promo['status'] === 'active';
        });
        return !empty($filtered) ? $filtered[0]['referentiels'] : null;

    },

    Promotions::NB_OF_LEARNERS_BY_PROMOTION->value => function (string $promotion_name) use (&$file_services): int {
        $db = $file_services[FileServices::JSON_TO_ARRAY->value]();

        $promotion = array_values(array_filter($db['promotions'] ?? [], fn($p) => strcasecmp($p['nom_promotion'], $promotion_name) === 0));
        if (empty($promotion)) return 0;

        $ref_names = $promotion[0]['referentiels'] ?? [];

        $referentiels = array_filter($db['referentiels'] ?? [], fn($r) => in_array($r['nom_referentiel'], $ref_names));
        $total = array_reduce($referentiels, fn($carry, $ref) => $carry + ($ref['nb_apprenants'] ?? 0), 0);

        return $total;
    },

    Promotions::NB_OF_REFERENTIELS_BY_PROMOTION->value => function (string $promotion_name) use (&$file_services): int {
        $promotions = $file_services[FileServices::JSON_TO_ARRAY->value]()['promotions'] ?? [];
        $promotion = array_values(array_filter($promotions, fn($p) => strcasecmp($p['nom_promotion'], $promotion_name) === 0));
        return isset($promotion[0]['referentiels']) ? count($promotion[0]['referentiels']) : 0;
    },

    Promotions::NB_OF_ACTIVE_PROMOTION->value => function () use (&$promotion_services): int {
        $promotions = $promotion_services[Promotions::FIND_ALL_PROMOTIONS->value]();
        return count(array_filter($promotions, fn($p) => strtolower($p['etat']) === 'active'));
    },

    Promotions::NB_OF_TOTAL_PROMOTIONS->value => function () use (&$promotion_services): int {
        return count($promotion_services[Promotions::FIND_ALL_PROMOTIONS->value]());
    },

    // Dans promotion.model.php
    Promotions::GET_GLOBAL_STATS->value => function() use (&$file_services): array {
    $data = $file_services[FileServices::JSON_TO_ARRAY->value]();
    
    $promotions = $data['promotions'] ?? [];
    $referentiels = $data['referentiels'] ?? [];
    
    $totalLearners = array_reduce($referentiels, 
        fn($carry, $ref) => $carry + ($ref['nb_apprenants'] ?? 0), 0);
    
    return [
        'total_promotions' => count($promotions),
        'active_promotions' => count(array_filter($promotions, 
            fn($p) => strtolower($p['etat']) === 'active')),
        'total_referentiels' => array_reduce($promotions,
            fn($carry, $p) => $carry + count($p['referentiels'] ?? []), 0),
        'total_learners' => $totalLearners
    ];
}
];


function promotion_service_exec(Promotions $promotion, ...$args) {
    global $promotion_services;
    
    if (!isset($promotion_services[$promotion->value])) {
        throw new \RuntimeException("Service de promotion non trouvé : " . $promotion->value);
    }
    
    return $promotion_services[$promotion->value](...$args);
}
