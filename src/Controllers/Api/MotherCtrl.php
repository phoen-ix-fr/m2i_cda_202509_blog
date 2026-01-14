<?php

namespace M2i\Blog\Controllers\Api;

abstract class MotherCtrl
{
    protected function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    protected function getInput()
    {
        // Lorsqu'une requête est envoyée avec un corps au format JSON, les données sont
        // récupérables dans le fichier php://input de la manière ci-dessous :
        $input = file_get_contents('php://input');

        if($input) 
        { 
            return json_decode($input, true); 
        }
        elseif(count($_POST) > 0) 
        { 
            return $_POST; 
        }
        else 
        {
            return false;
        }
    }

    protected function jsonErrorResponse(int $httpCode, string $message)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($httpCode);

        $errorJson = json_encode([
            'success'   => false,
            'error'     => [
                'message'   => $message
            ]
        ]);

        return $errorJson;
    }

    protected function jsonSuccessResponse(array $data, string $message = "")
    {
        header('Content-Type: application/json; charset=utf-8');

        $json = json_encode([
            'success'   => true,
            'data'      => $data,
            'message'   => $message
        ]);

        if(json_last_error() !== JSON_ERROR_NONE) {

            $errorJson = json_encode([
                'success'   => false,
                'error'     => [
                    'message'   => json_last_error_msg()
                ]
            ]);

            return $errorJson;
        }
        else {
            return $json;
        }
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