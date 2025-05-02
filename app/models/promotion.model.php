<?php
namespace App\Models;

use App\Enums\FileServices;
use App\Enums\Promotions;
use App\Enums\Referentiels;
use App\Enums\Sessions;
use DateTime;

global $file_services, $referentiel_services;

$promotion_services = [

    
    Promotions::FIND_ACTIVE_PROMOTION->value => function () use (&$promotion_services): ?array {
        $promotions = $promotion_services[Promotions::FIND_ALL_PROMOTIONS->value]();
        $active = array_filter($promotions, fn($promo) => strtolower($promo['status']) === 'active');
    
        $active = array_values($active);
    
        return !empty($active) ? $active[0] : null;
    },

    Promotions::FIND_CURRENT_PROMOTION->value => function () use (&$promotion_services) : ?array {
        $promotions = $promotion_services[Promotions::FIND_ALL_PROMOTIONS->value]();
        $current = array_filter($promotions, fn($promo) => strtolower($promo['etat']) === 'en cours');
        $current = array_values($current);
        return !empty($current) ? $current[0] : null;
    },
    

    Promotions::GET_GLOBAL_STATS->value => function () use (&$file_services, &$promotion_services) {

        $data = $file_services[FileServices::JSON_TO_ARRAY->value]();

        $active_promotion = $promotion_services[Promotions::FIND_ACTIVE_PROMOTION->value]();
        // $_SESSION['active_promotion'] = $active_promotion;
        
        if ($active_promotion) {
            $referentiels = $active_promotion['referentiels'];
            $num_referentiels = count($referentiels);
            $num_apprenants = 0;

            foreach ($data['apprenants'] as $apprenant) {
                if (in_array($apprenant['referentiel'], $referentiels)) {
                    $num_apprenants++;
                }
            }

            return [
                'active_promotion' => $active_promotion,
                'num_referentiels' => $num_referentiels,
                'num_apprenants' => $num_apprenants,
                'total_promotions' => count($data['promotions']),
                'active_promotions' => count(array_filter($data['promotions'], fn($promo) => $promo['status'] === 'active'))
            ];
        }
        return null;
    },


    Promotions::FIND_ALL_PROMOTIONS->value => function () use (&$file_services): array {
        $data = $file_services[FileServices::JSON_TO_ARRAY->value]();
        return $data['promotions'] ?? [];
    },

    Promotions::FIND_ALL_PROMOTIONS_FILTER->value => function ($filter = null, $search = '', $page = 1, $limit = 3) use (&$promotion_services) {
        $promotions = $promotion_services[Promotions::FIND_ALL_PROMOTIONS->value]();
        
        $activePromotion = $promotion_services[Promotions::FIND_ACTIVE_PROMOTION->value]();
    
        // Exclure la promotion active pour ne pas avoir de doublons
        if ($activePromotion) {
            $promotions = array_filter($promotions, function($promo) use ($activePromotion) {
                return strcasecmp($promo['nom_promotion'], $activePromotion['nom_promotion']) !== 0;
            });
        }
    
        // Filtrage
        if ($filter === 'active') {
            $promotions = array_filter($promotions, fn($promo) => $promo['status'] === 'active');
        } elseif ($filter === 'inactive') {
            $promotions = array_filter($promotions, fn($promo) => $promo['status'] === 'inactive');
        }
    
        // Recherche
        if (!empty($search)) {
            $promotions = array_filter($promotions, fn($promo) => stripos($promo['nom_promotion'], $search) !== false);
        }
    
        // Tri par date de début décroissant
        usort($promotions, function($a, $b) {
            $dateA = DateTime::createFromFormat('d/m/Y', $a['date_debut']);
            $dateB = DateTime::createFromFormat('d/m/Y', $b['date_debut']);
            return $dateB <=> $dateA;
        });
    
        // PAGINATION
        $adjustedLimit = $limit - 1; // On garde 1 place pour la promotion active
        $offset = ($page - 1) * $adjustedLimit;
    
        $paginatedPromotions = array_slice($promotions, $offset, $adjustedLimit);
    
        // On ajoute systématiquement la promotion active en premier
        if ($activePromotion) {
            array_unshift($paginatedPromotions, $activePromotion);
        }
    
        $total = count($promotions);
        $totalWithActive = $total + ($activePromotion ? 1 : 0);
    
        $stats = $promotion_services[Promotions::GET_GLOBAL_STATS->value]();
    
        return [
            'stats' => $stats,
            'promotions' => $paginatedPromotions,
            'total' => $totalWithActive, // pour afficher les bonnes infos
            'pages' => ceil($total / $adjustedLimit) // ATTENTION ici : total sans compter l'active à chaque fois
        ];
    },
    
    
    Promotions::FIND_PROMOTION_BY_NAME->value => function (string $name) use (&$promotion_services): ?array {
        $promotions = $promotion_services[Promotions::FIND_ALL_PROMOTIONS->value]();
        $result = array_filter($promotions, fn($promo) => strcasecmp($promo['nom_promotion'], $name) === 0);
        return !empty($result) ? $result[0] : null;
    },

    Promotions::FIND_PROMOTIONS_BY_STATUS->value => function (string $status) use (&$promotion_services) : ?array {
        $promotions = $promotion_services[Promotions::FIND_ALL_PROMOTIONS->value]();
        $filtered = array_filter($promotions, fn($promo) => $promo['status'] === $status);
        return !empty($filtered) ? $filtered[0] : null;
    },

    // Promotions::CHANGE_PROMOTION_STATUS->value => function (string $name) use (&$file_services): bool {
    //     $data = $file_services[FileServices::JSON_TO_ARRAY->value]();
    
    //     $data['promotions'] = array_map(function ($promo) use ($name) {
    //         if (strcasecmp($promo['nom_promotion'], $name) === 0) {
    //             $promo['status'] = 'active';
    //         } else {
    //             // On désactive les autres si on active celle-ci
    //             if (strtolower($promo['status']) === 'active') {
    //                 $promo['status'] = 'inactive';
    //             }
    //         }
    //         return $promo;
    //     }, $data['promotions'] ?? []);
    
    //     $file_services[FileServices::ARRAY_TO_JSON->value]($data);
    //     return true;
    // }, 
    Promotions::CHANGE_PROMOTION_STATUS->value => function (string $name) use (&$file_services): bool {
        $data = $file_services[FileServices::JSON_TO_ARRAY->value]();
    
        if (!isset($data['promotions']) || empty($data['promotions'])) {
            return false;
        }
    
        $data['promotions'] = array_map(function ($promo) use ($name) {
            if (strcasecmp($promo['nom_promotion'], $name) === 0) {
                $promo['status'] = 'active';
            } else {
                $promo['status'] = 'inactive';
            }
            return $promo;
        }, $data['promotions']);
    
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

    Promotions::GET_REFERENTIELS_SELECTION->value => function() use (&$promotion_services, &$referentiel_services, &$file_services) {
        $data = $file_services[FileServices::JSON_TO_ARRAY->value]();
        
        $activePromo = $promotion_services[Promotions::FIND_ACTIVE_PROMOTION->value]();
        if (!$activePromo) {
            return null;
        }
    
        $allReferentiels = $referentiel_services[Referentiels::FIND_ALL_REFERENTIELS->value]();
        $promoReferentiels = $activePromo['referentiels'] ?? [];
    
        $added = array_filter($allReferentiels, fn($ref) => in_array($ref['nom_referentiel'], $promoReferentiels));
        $available = array_filter($allReferentiels, fn($ref) => !in_array($ref['nom_referentiel'], $promoReferentiels));
    
        return [
            'promotion' => $activePromo,
            'available' => $available,
            'added' => $added,
        ];
    },    
   

    Promotions::NB_OF_LEARNERS_BY_PROMOTION->value => function () use (&$promotion_services): int {
        // $db = $file_services[FileServices::JSON_TO_ARRAY->value]();
        $active_promotion = $promotion_services[Promotions::FIND_ACTIVE_PROMOTION->value]();

        $ref_names = $active_promotion['referentiels'] ?? [];

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
        return count(array_filter($promotions, fn($p) => strtolower($p['status']) === 'active'));
    },

    Promotions::NB_OF_TOTAL_PROMOTIONS->value => function () use (&$promotion_services): int {
        return count($promotion_services[Promotions::FIND_ALL_PROMOTIONS->value]());
    },

    // Dans promotion.model.php
//     Promotions::GET_GLOBAL_STATS->value => function() use (&$file_services): array {
//     $data = $file_services[FileServices::JSON_TO_ARRAY->value]();
    
//     $promotions = $data['promotions'] ?? [];
//     $referentiels = $data['referentiels'] ?? [];
    
//     $totalLearners = array_reduce($referentiels, 
//         fn($carry, $ref) => $carry + ($ref['nb_apprenants'] ?? 0), 0);
    
//     return [
//         'total_promotions' => count($promotions),
//         'active_promotions' => count(array_filter($promotions, 
//             fn($p) => strtolower($p['etat']) === 'active')),
//         'total_referentiels' => array_reduce($promotions,
//             fn($carry, $p) => $carry + count($p['referentiels'] ?? []), 0),
//         'total_learners' => $totalLearners
//     ];
// }
];


function promotion_service_exec(Promotions $promotion, ...$args) {
    global $promotion_services;
    
    if (!isset($promotion_services[$promotion->value])) {
        throw new \RuntimeException("Service de promotion non trouvé : " . $promotion->value);
    }
    
    return $promotion_services[$promotion->value](...$args);
}
