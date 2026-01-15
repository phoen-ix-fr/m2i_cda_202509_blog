<?php

namespace M2i\Blog\Controllers\Api;

use M2i\Blog\Models\UserModel;
use M2i\Blog\Traits\CanResponse;
use M2i\Blog\Traits\Requestable;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

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
        $arrData = $this->getInput();

        $objUserModel = new UserModel();
        $arrUser = $objUserModel->getUserByMailAndPwd($arrData['email'], $arrData['password']);

        if ($arrUser === false) 
        {
            // Identifiant ou mot de passe incorrect(s)
            echo $this->jsonErrorResponse('403', "Identifiant ou mot de passe incorrect");
        }
        else
        {
            // Utilisateur trouvé

            // Information du token qui sera stockée en base de données pour vérification
            $strUserToken = uniqid(); 
            $objUserModel->setToken($arrUser['user_id'], $strUserToken);

            $payload = [
                'user_id'       => $arrUser['user_id'],
                'user_email'    => $arrData['email'],
                'expires_at'    => time() + $_ENV['JWT_LIFETIME'],         //< Expire au bout de 5 minutes (5*60 secondes)
                'user_token'    => $strUserToken
            ];

            /**
             * IMPORTANT:
             * You must specify supported algorithms for your application. See
             * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
             * for a list of spec-compliant algorithms.
             */
            $jwt = JWT::encode($payload, $_ENV['JWT_KEY'], $_ENV['JWT_ALGORITHM']);

            echo $this->jsonSuccessResponse([
                'token' => $jwt
            ], "Connexion effectuée", 200);
        }
    }

    /**
     * POST /auth/logout
     * 
     * Déconnecte l'utilisateur
     * Invalide le(s) jeton(s) d'authentification de l'utilisateur
     */
    public function logout()
    {
        // Uniquement si on stocke en base de données un hash du jeton
    }
}