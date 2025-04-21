<?php
enum ErrorMessages:string {

    case REQUIRED = 'Le champ %s est obligatoire';
    case EMAIL = 'Le champ %s doit être un email valide';
    case MIN = 'Le champ %s doit avoir au moins %s caractères';
    case MAX = 'Le champ %s ne doit pas dépasser %s caractères';
    case NUMERIC = 'Le champ %s doit être un nombre';
    case INTEGER = 'Le champ %s doit être un entier';
    case DATE = 'Le champ %s doit être une date valide';
    case REGEX = 'Le format du champ %s est invalide';
    case IN = 'Le champ %s doit être parmi: %s';
    case SAME = 'Le champ %s doit correspondre au champ %s';

    case LOGIN_ERROR = 'Login et/ou mot de passe incorrect !';
    case VERIFY_EMAIL_ERROR = 'Cette adresse email n\'existe pas.';

}