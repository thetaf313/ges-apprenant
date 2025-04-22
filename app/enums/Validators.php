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
    case REGEX = 'regex';
    case IN = 'in';
    case SAME = 'same';

    case VALIDATE = 'validate';
    case VALIDATE_FIELD = 'validate_field';
    case GET_VALIDATION_MESSAGE = 'get_validation_message';
    case ADD_VALIDATOR = 'add_validator';


}

enum SuccessMessage:string {

    case LOGIN_SUCCES = 'Connexion Réussie !';
    case UPDATE_PASSWORD_SUCCESS = 'Mot de passe modifié avec succès.';
}


