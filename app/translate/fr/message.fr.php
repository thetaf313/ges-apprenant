<?php

namespace App\translate\fr;

enum FrSuccessMessage:string {

    case LOGIN_SUCCESS = 'Connexion réussie !';
    case UPDATE_PASSWORD_SUCCESS = 'Votre mot de passe a été mis à jour !';


    case ERROR_MAX_FILE_SIZE = 'Le fichier dépasse la taille maximale autorisée par le serveur';
}