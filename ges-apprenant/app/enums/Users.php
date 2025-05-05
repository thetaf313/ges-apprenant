<?php
namespace App\Enums;

enum Users:string {

    case DEFAULT_PASSWORD_LENGTH = '12';
    case MATRICULE_PREFIX = 'USR';
    case MATRICULE_LENGTH = '8';

    case GET_USERS = 'get_users';
    case FIND_USER = 'find_user';
    case SAVE_USER = 'save_user';
    case REGISTER_USER = 'register_user';
}