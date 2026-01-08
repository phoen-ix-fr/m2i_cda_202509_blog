<?php

// Espace de nom suivant le répertoire
namespace M2i\Blog\Controllers;

use DateTime;

// Changement des requires en "use" :
// require("models/article_model.php");
use M2i\Blog\Entities\Article;

// require("entities/article_entity.php");
use M2i\Blog\Models\UserModel;
use M2i\Blog\Models\ArticleModel;

/**
 * Controller des articles
 */
class ArticlesCtrl extends MotherCtrl {

    /**
     * Page d'accueil
     * @return void
     */
    public function home(){
        // Création des variables d'affichage
        $this->_arrData['strTitle']		= "Accueil";
        $this->_arrData['strH1']		= "Accueil";
        $this->_arrData['strMetaDesc'] 	= "Découvrez les derniers articles sur le développement web : JavaScript, HTML, CSS, PHP et bases de données. Tutoriels et conseils pour développeurs.";
        $this->_arrData['strDesc']		= "Découvrez nos derniers articles sur le développement web";

        // Variable technique
        $this->_arrData['strPage']		= "index";

        $objArticleModel                = new ArticleModel();

        $arrArticles                    = $objArticleModel->findAll(4);

        // On parcourt le tableau pour créer des objets
        $arrArticlesToDisplay           = array();
        foreach($arrArticles as $arrDetArticle){
            $objArticle = new Article();
            $objArticle->hydrate($arrDetArticle);
            $arrArticlesToDisplay[] = $objArticle;
        }

        $this->_arrData['arrArticles'] = $arrArticlesToDisplay;

        $this->_display("articles/home");

    }

    /**
     * Page blog
     * @return void
     */
    public function blog(){
        // Création des variables d'affichage
        $this->_arrData['strTitle'] 	= "Blog - Tous les articles";
        $this->_arrData['strH1'] 		= "Mon blog";
        $this->_arrData['strMetaDesc'] 	= "Découvrez qui nous sommes : notre équipe passionnée de développement web, notre mission et nos valeurs. Formations et expertise en programmation.";
        $this->_arrData['strDesc']		= "Découvrez notre histoire, notre équipe et notre passion pour le développement web";

        // Variable technique
        $this->_arrData['strPage']		= "blog";

        $objArticleModel    = new ArticleModel();

        $objArticleModel->_arrSearch = array(
            'strKeywords'	=> $_POST['keywords']??'',
            'intAuthor'		=> $_POST['author']??0,
            'intPeriod'		=> $_POST['period']??0,
            'strDate'		=> $_POST['date']??"",
            'strStartDate'	=> $_POST['startdate']??"",
            'strEndDate'	=> $_POST['enddate']??"");

        // Récupération des articles
        $arrArticles                    = $objArticleModel->findAll();

        // On parcourt le tableau pour créer des objets
        $arrArticlesToDisplay           = array();
        foreach($arrArticles as $arrDetArticle){
            $objArticle = new Article();
            $objArticle->hydrate($arrDetArticle);
            $arrArticlesToDisplay[] = $objArticle;
        }

        $this->_arrData['arrArticles']  = $arrArticlesToDisplay;

        $this->_arrData['arrSearch']	= $objArticleModel->_arrSearch;

        // Récupération des utilisateurs
        // Pas de use en milieu de code, toujours au début, 
        // juste en dessous de la définition du namespace
        // require("models/user_model.php");
        $objUserModel = new UserModel();
        $this->_arrData['arrUsers'] 		= $objUserModel->findAllUser();

        $this->_display("articles/blog");

    }

    public function show() 
    {
        $intArticleId = $_GET['id']??0;

        // cf. https://www.php.net/manual/fr/function.is-int.php#82857
        if(!ctype_digit($intArticleId) || $intArticleId === 0) {
            $this->_notFound();
        }

        // Création des variables d'affichage
        $this->_arrData['strMetaDesc'] 	= "Découvrez qui nous sommes : notre équipe passionnée de développement web, notre mission et nos valeurs. Formations et expertise en programmation.";
        
        // Variable technique
        $this->_arrData['strPage']		= "show_article";

        // Rechercher toutes les informations de l'article dont l'ID = $intArticleId
        $objArticleModel    = new ArticleModel();
        $arrArticle = $objArticleModel->findById($intArticleId);

        if (!$arrArticle) {
            $this->_notFound();
        }

        $objArticle = new Article();
        $objArticle->hydrate($arrArticle);

        $this->_arrData['strTitle'] 	= "Blog - " . $objArticle->getTitle();
        $this->_arrData['strH1'] 		= $objArticle->getTitle();
        $this->_arrData['strDesc']		= "Ecrit par : " . $objArticle->getCreator_name();

        $this->_arrData['objArticle']   = $objArticle;

        $this->_display("articles/show_article");
    }

    public function create() 
    {        
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            $this->_forbidden();
        }        

        $this->_arrData['strTitle']     = "Créer un article";
        $this->_arrData['strH1']        = "Créer un article";
        $this->_arrData['strMetaDesc']  = "Créer un article";
        $this->_arrData['strDesc']      = "Page de création de article";

        $this->_arrData['strPage']		= "create_article";

        // TODO Traitement ici du formulaire
        $arrError = array();
        
        if (count($_POST) > 0) {
            
            // Récupérer les données du formulaire
            $strTitle       = $_POST['title'] ?? "";
            $strContent     = $_POST['content'] ?? "";

            if($strTitle == "") {
                $arrError['title'] = "Le titre est obligatoire";
            }
            
            if($strContent == "") {
                $arrError['content'] = "Un contenu est obligatoire";
            }

            $intCreatorId = $_SESSION['user']['user_id'];
            $strCreateDate = date('Y-m-d H:i:s');

            if (count($arrError) == 0) {

                $strImage = "";

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

                if($intInsert) {

                    $this->_redirect('articles', 'show', ['id' => $intInsert]);
                }
                else {
                    $arrError[] = "Un erreur s'est produite, contactez l'administrateur";
                }
            }
        }
        
        $this->_arrData['arrError']     = $arrError;
        $this->_display("articles/create");
    }
}
