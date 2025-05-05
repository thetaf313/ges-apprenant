<?php
namespace App\Enums;

enum Sessions:string {

    case START_SESSION = 'start_session';
    case UNSET_SESSION = 'unset_session';
    case GET_USER = 'get_user';
    case SET_USER = 'set_user';
    case SET_ERRORS = 'set_errors';
    case GET_ERRORS = 'get_errors';
    case SET_OLD_INPUT = 'set_old_input';
    case GET_OLD_INPUT = 'get_old_input';
    case SET_ERROR_MESSAGE = 'set_error_message';
    case GET_ERROR_MESSAGE = 'get_error_message';
    case SET_FLASH_SUCCESS = 'set_flash_success';
    case GET_FLASH_SUCCESS = 'get_flash_success';
    case DESTROY_SESSION = 'destroy_session';
    case SET_EMAIL_PASSWORD_TO_UPDATE = 'set_email_password_to_update';
    case GET_EMAIL_PASSWORD_TO_UPDATE = 'get_email_password_to_update';
}