<?php

Promotions::FIND_ALL_PROMOTIONS_FILTER->value => function ($filter = null, $search = '', $page = 1, $limit = 3) use (&$promotion_services) {
    $promotions = $promotion_services[Promotions::FIND_ALL_PROMOTIONS->value]();

    // Trouver la promotion active
    $active_promotion = $promotion_services[Promotions::FIND_ACTIVE_PROMOTION->value]();

    // Si une promotion active existe, la mettre en premier
    if ($active_promotion) {
        array_unshift($promotions, $active_promotion);
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

    // Supprimer les doublons si la promotion active est déjà dans la liste
    $promotions = array_unique($promotions, SORT_REGULAR);

    // Trier les promotions par date de début (ou date de création) en ordre décroissant
    usort($promotions, function ($a, $b) {
        $dateA = DateTime::createFromFormat('d/m/Y', $a['date_debut']);
        $dateB = DateTime::createFromFormat('d/m/Y', $b['date_debut']);
        return $dateB <=> $dateA; // Tri décroissant
    });

    // Pagination
    $total = count($promotions);
    $offset = ($page - 1) * $limit;
    $promotions = array_slice($promotions, $offset, $limit);

    return [
        'promotions' => $promotions,
        'total' => $total,
        'pages' => ceil($total / $limit)
    ];
},
