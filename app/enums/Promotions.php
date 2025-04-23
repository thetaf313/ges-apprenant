<?php
namespace App\Enums;

enum Promotions:string {

    case FIND_ALL_PROMOTIONS = 'find_all_promotions';
    case FIND_PROMOTION_BY_NAME = 'find_promotion_by_name';
    case CHANGE_PROMOTION_STATUS = 'change_promotion_status';
    case SAVE_PROMOTION = 'save_promotion';
    case ADD_REFERENTIEL_TO_PROMOTION = 'add_referentiel_to_promotion';
    case FIND_ALL_REFERENTIELS_BY_PROMOTION = 'find_all_referentiels_by_promotion';
    case NB_OF_LEARNERS_BY_PROMOTION = 'nb_of_learners_by_promotion';
    case NB_OF_REFERENTIELS_BY_PROMOTION = 'nb_of_referentiel_by_promotion';
    case NB_OF_ACTIVE_PROMOTION = 'nb_of_active_promotion';
    case NB_OF_TOTAL_PROMOTIONS = 'nb_of_total_promotions';
    case GET_GLOBAL_STATS = 'get_global_stats';
}