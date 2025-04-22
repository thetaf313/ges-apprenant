<?php
namespace App\Enums;

enum Users:string {

    case GET_USERS = 'get_users';
    case FIND_USER = 'find_user';
    case SAVE_USER = 'save_user';
}