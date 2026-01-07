<?php

// Espace de nom suivant le répertoire
namespace Blog\Controllers;

// Changement des requires en "use" :
// require("models/article_model.php");
use Blog\Models\ArticleModel;

use Blog\Models\UserModel;

// require("entities/article_entity.php");
use Blog\Entities\Article;

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

            $this->_display("home");

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

            $this->_display("blog");

        }

        public function show() 
        {
            $intArticleId = 2;

            // Création des variables d'affichage
            $this->_arrData['strMetaDesc'] 	= "Découvrez qui nous sommes : notre équipe passionnée de développement web, notre mission et nos valeurs. Formations et expertise en programmation.";
            
            // Variable technique
            $this->_arrData['strPage']		= "show_article";

            // Rechercher toutes les informations de l'article dont l'ID = $intArticleId
            $objArticleModel    = new ArticleModel();
            $arrArticle = $objArticleModel->findById($intArticleId);

            $objArticle = new Article();
            $objArticle->hydrate($arrArticle);

            $this->_arrData['strTitle'] 	= "Blog - " . $objArticle->getTitle();
            $this->_arrData['strH1'] 		= $objArticle->getTitle();
            $this->_arrData['strDesc']		= "Ecrit par : " . $objArticle->getCreator_name();

            $this->_arrData['objArticle']   = $objArticle;

            $this->_display("show_article");
        }
    }
