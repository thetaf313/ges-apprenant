<?php
namespace App\Enums;

enum FileServices:string {

    case JSON_TO_ARRAY = 'json_to_array';
    case ARRAY_TO_JSON = 'array_to_json';
    case GET_STAND_BY_APPRENANTS_FILE = 'get_stand_by_apprenants';
    case SET_STAND_BY_APPRENANTS_FILE = 'set_stand_by_apprenants';
}