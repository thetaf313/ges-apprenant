<?php
namespace App\Enums;

enum Apprenants: string {

    case FIND_ALL_APPRENANTS = 'find_all_apprenants';
    case FIND_ALL_APPRENANTS_FILTER = 'find_all_apprenants_filter';
    case GET_STAND_BY_APPRENANTS = 'get_stand_by_apprenants';
    case SET_STAND_BY_APPRENANTS = 'set_stand_by_apprenants';
    case FIND_ALL_STAND_BY_APPRENANTS_FILTER = 'find_all_stand_by_apprenants_filter';
    case FIND_ALL_STAND_BY_APPRENANTS = 'find_all_stand_by_apprenants';
}