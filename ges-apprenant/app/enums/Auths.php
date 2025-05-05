<?php

namespace App\Enums;

enum Auths: string {

    case REGISTER_USER = 'register_user';
    case LOGIN_USER = 'login_user';
    case VALIDATE_FIELD = 'validate_field';
    case VALIDATE_USER = 'validate_user';
    case GENERATE_MATRICULE = 'generate_matricule';
    case GENERATE_PASSWORD = 'generate_password';
    case HASH_PASSWORD = 'hash_password';
    case SEND_WELCOME_EMAIL = 'send_welcome_email';
    case LOG_AUDIT = 'log_audit';
}