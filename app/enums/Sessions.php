<?php
namespace App\Enums;

enum Sessions:string {

    case START_SESSION = 'start_session';
    case GET_USER = 'get_user';
    case SET_USER = 'set_user';
    case DESTROY_SESSION = 'destroy_session';
}