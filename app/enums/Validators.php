<?php
namespace App\Enums;

enum Validators:string {

    case REQUIRED = 'required';
    case EMAIL = 'email';
    case MIN = 'min';
    case MAX = 'max';
    case NUMERIC = 'numeric';
    case INTEGER = 'integer';
    case DATE = 'date';
    case DATE_FORMAT = 'date_format';
    case REGEX = 'regex';
    case IN = 'in';
    case SAME = 'same';
    case AFTER = 'after';
    case FILE_MIME = 'file_mime';
    case FILE_SIZE = 'file_size';
    case UNIQUE_PROMOTION = 'unique_promotion';
    case VALID_REFERENTIELS = 'valid_referentiels';

    case VALIDATE = 'validate';
    case VALIDATE_PROMOTION = 'validate_promotion';
    case VALIDATE_FIELD = 'validate_field';
    case GET_VALIDATION_MESSAGE = 'get_validation_message';
    case ADD_VALIDATOR = 'add_validator';


}

enum SuccessMessage:string {

    case LOGIN_SUCCES = 'Connexion Réussie !';
    case UPDATE_PASSWORD_SUCCESS = 'Mot de passe modifié avec succès.';
}


