<?php
namespace App\Enums;

enum FileServices:string {

    case JSON_TO_ARRAY = 'json_to_array';
    case ARRAY_TO_JSON = 'array_to_json';
}