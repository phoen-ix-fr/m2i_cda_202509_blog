<?php

namespace M2i\Blog\Controllers\Api;

use M2i\Blog\Traits\CanResponse;
use M2i\Blog\Traits\Requestable;

/**
 * Contrôleur API de gestion de la connexion utilisateur
 * (N'hérite pas du MotherCtrl car routes/fontions/actions spécifiques)
 * 
 * @see https://github.com/firebase/php-jwt
 */
class AuthCtrl
{
    use Requestable, CanResponse;

    /**
     * POST /auth/register
     * 
     * Permet l'inscription de l'utilisateur sur le blog en mode API
     * Envoi les information d'inscription dans le corps de la requête en format JSON
     * { firstname: XX, lastname: XX, email: XX, password: XX }
     */
    public function register()
    {

    }

    /**
     * POST /auth/login
     * 
     * Permet à l'utilisateur de se connecter
     * Envoi les informations de connexion dans le corps de la requête en format JSON
     * { email: XX, password: XX }
     */
    public function login()
    {
        
    }

    /**
     * POST /auth/logout
     * 
     * Déconnecte l'utilisateur
     * Invalide le(s) jeton(s) d'authentification de l'utilisateur
     */
    public function logout()
    {
        
    }
}