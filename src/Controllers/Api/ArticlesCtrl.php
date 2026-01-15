<?php

namespace M2i\Blog\Controllers\Api;

use M2i\Blog\Entities\Article;
use M2i\Blog\Models\ArticleModel;

class ArticlesCtrl extends MotherCtrl
{
    /**
     * GET api/articles
     * Liste tous les articles du blog
     */
    protected function getAll()
    {
        $objArticleModel    = new ArticleModel();
        $arrArticles        = $objArticleModel->findAll();

        echo $this->jsonSuccessResponse($arrArticles);        
    }

    /**
     * GET api/articles?id=1
     * Récupérer un article en particulier par son ID
     */
    protected function getOne()
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
    protected function create()
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
    protected function update()
    {
        $input = file_get_contents('php://input');
        var_dump($input);

        echo "Update (Methode PUT)";
    }

    /**
     * DELETE api/articles
     * Supprime un article en base de données
     */
    protected function delete()
    {
        $intArticleId = $_GET['id'];
        
        $objArticleModel = new ArticleModel();

        if ($objArticleModel->remove($intArticleId)) {

            echo $this->jsonSuccessResponse([], "L'article a été supprimé", 204);
        }
        else {
            echo $this->jsonErrorResponse("500", "Une erreur est survenue");  
        }
    }
}