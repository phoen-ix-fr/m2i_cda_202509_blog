<?php

namespace M2i\Blog\Controllers\Api;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use M2i\Blog\Models\UserModel;
use M2i\Blog\Traits\CanResponse;
use M2i\Blog\Traits\Requestable;
use stdClass;

abstract class MotherCtrl
{
    use Requestable, CanResponse;

    /**
     * Récupère les entêtes liées à l'authentification suivant le type de serveur
     * 
     * @see https://stackoverflow.com/questions/40582161/how-to-properly-use-bearer-tokens
     */
    protected function getAuthorizationHeader()
    {
        if (isset($_SERVER['Authorization'])) {

            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);

        } elseif (function_exists('apache_request_headers')) {
            
            $requestHeaders = apache_request_headers();

            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    protected function verifyJwtToken(string $jwtToken)
    {
        $decoded = JWT::decode($jwtToken, new Key($_ENV['JWT_KEY'], $_ENV['JWT_ALGORITHM']));

        // Vérifier si le jeton a expiré ou non
        if(time() > $decoded->expires_at) { return null; }

        // Vérifier si l'utilisateur (id) existe ou non
        $userModel = new UserModel();
        $checkUser = $userModel->getUserById($decoded->user_id);

        // Si la requête SQL ne revneoi rien, on retourne null
        if(!$checkUser) { return null; }

        return $checkUser;
    }

    /**
     * Récupère le token JWT dans l'entête de la requête
     */
    protected function getBearerToken()
    {
        $headers = $this->getAuthorizationHeader();
        $jwtToken = str_replace('Bearer ', '', $headers);

        return $this->verifyJwtToken($jwtToken);
    }

    public function home()
    {
        switch($this->getRequestMethod())
        {
            case 'GET':

                // Vérifie si un id est présent dans l'URL
                if($_GET['id']??false) {
                    $this->getOne();
                }
                else {
                    $this->getAll();
                }

                break;

            case 'POST':
                $this->create();
                break;

            case 'PUT':
                $this->update();
                break;

            case 'DELETE':
                $this->delete();
                break;
        }
    }

    protected abstract function getOne();

    protected abstract function getAll();

    protected abstract function create();

    protected abstract function update();

    protected abstract function delete();
}