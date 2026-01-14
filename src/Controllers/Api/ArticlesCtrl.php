<?php

namespace M2i\Blog\Controllers\Api;

use M2i\Blog\Models\ArticleModel;

class ArticlesCtrl
{
    private function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    private function jsonErrorResponse(int $httpCode, string $message)
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

    private function jsonSuccessResponse(array $data, string $message = "")
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

    /**
     * GET api/articles
     * Liste tous les articles du blog
     */
    function getAll()
    {
        $objArticleModel    = new ArticleModel();
        $arrArticles        = $objArticleModel->findAll();

        echo $this->jsonSuccessResponse($arrArticles);        
    }

    /**
     * GET api/articles?id=1
     * Récupérer un article en particulier par son ID
     */
    function getOne()
    {
        $intArticleId = $_GET['id'];
        
        $objArticleModel    = new ArticleModel();
        $arrArticle = $objArticleModel->findById($intArticleId);

        if (!$arrArticle) {
            echo $this->jsonErrorResponse(404, "L'article demandé n'existe pas");
        }
        else {
            echo $this->jsonSuccessResponse($arrArticle);  
        }
    }

    /**
     * POST api/articles
     * Créer un nouvel article en base de données
     */
    function create()
    {
        $input = file_get_contents('php://input');
        var_dump($input);

        echo "Create (Methode POST)";
    }

    /**
     * PUT api/articles
     * Modifie un article en base de données
     */
    function update()
    {
        $input = file_get_contents('php://input');
        var_dump($input);

        echo "Update (Methode PUT)";
    }

    /**
     * DELETE api/articles
     * Supprime un article en base de données
     */
    function delete()
    {
        $input = file_get_contents('php://input');
        var_dump($input);

        echo "Delete (Methode DELETE)";
    }
}