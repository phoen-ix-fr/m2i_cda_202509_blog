<?php

namespace M2i\Blog\Controllers\Api;

use M2i\Blog\Entities\Article;
use M2i\Blog\Models\ArticleModel;

class ArticlesCtrl
{
    private function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    private function getInput()
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
        // @TODO La création se fait toujours sur l'utilisateur ID = 1 (pour les tests)
        $intCreatorId   = 1;
        $strCreateDate  = date('Y-m-d H:i:s');
        $strImage       = "";

        $arrInputData   = $this->getInput();

        if($arrInputData) 
        {
            $strTitle       = $arrInputData['title'] ?? "";
            $strContent     = $arrInputData['content'] ?? "";

            // Récupération de l'image postée
            if (count($_FILES) > 0 && isset($_FILES['image'])) {

                $strImageName       = $_FILES['image']['name'] ?? "";
                $intImageSize       = $_FILES['image']['size'] ?? 0;
                $strImageTmpName    = $_FILES['image']['tmp_name'] ?? "";
                $strImageExtension  = strtolower(pathinfo($strImageName, PATHINFO_EXTENSION));

                // On construit le nom de l'image final sur le disque
                // uniqid => permet de générer une chaine alphanumérique unique (aléatoire)
                // On acolle ensuite l'extension du fichier source
                $strImage = uniqid() . '.' . $strImageExtension;
                $strImageDstName    = "assets/images/" . $strImage;

                if($strImageName != "" 
                    && $intImageSize > 0 
                    && $strImageTmpName != "") {
                    
                    // Récupérer l'image et l'enregistrer dans /assets/images
                    move_uploaded_file($strImageTmpName, $strImageDstName);
                }
            }

            $objArticle = new Article();
            $objArticle->hydrate([
                'article_title'         => $strTitle,
                'article_content'       => $strContent,
                'article_img'           => $strImage,
                'article_creator'       => $intCreatorId,
                'article_createdate'    => $strCreateDate
            ]);

            $objArticleModel = new ArticleModel();

            $intInsert = $objArticleModel->add($objArticle);

            $objNewArticle = $objArticleModel->findById($intInsert);

            echo $this->jsonSuccessResponse($objNewArticle, "Article créé avec succès");
        }
        else
        {
            // Pas de données envoyées, renvoyer un message d'erreur 400
            echo $this->jsonErrorResponse(400, "Aucune donnée n'a été envoyée");
        }
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