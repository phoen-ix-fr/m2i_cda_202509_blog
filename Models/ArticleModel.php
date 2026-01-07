<?php

namespace Blog\Models;

use PDO;

/**
 * Modèle des articles
 */
class ArticleModel extends MotherModel
{
    public array $_arrSearch = [];

    /**
     * Recherche des articles
     * @param int $intLimit Nombre d'articles à afficher
     * @return array
     */
    public function findAll(int $intLimit = 0)
    {
        // Récupérer les Articles
        $strQuery = "SELECT articles.*, CONCAT(users.user_name, ' ', users.user_firstname) AS article_creator_name	 
							FROM articles 
								INNER JOIN users ON article_creator = user_id";

        $strWhereAnd = " WHERE ";
        // Traitement des mots clés
        $strKeywords	= $this->_arrSearch['strKeywords']??'';
        if ($strKeywords != "") {
            $strQuery .= $strWhereAnd . " (article_title LIKE '%" . $strKeywords . "%' 
								OR article_content LIKE '%" . $strKeywords . "%') ";
            $strWhereAnd = " AND ";
        }
        // Traitement du créateur
        $intAuthor	= $this->_arrSearch['intAuthor']??0;
        if ($intAuthor > 0) {
            $strQuery .= $strWhereAnd . " user_id = " . $intAuthor;
            $strWhereAnd = " AND ";
        }
        // Traitement de date exacte
        $intPeriod	= $this->_arrSearch['intPeriod']??0;
        $strDate	= $this->_arrSearch['strDate']??"";
        if ($intPeriod == 0 && $strDate != "") {
            $strQuery .= $strWhereAnd . " article_createdate = '" . $strDate . "'";
            $strWhereAnd = " AND ";
        }

        // Traitement de période de date
        $strStartDate	= $this->_arrSearch['strStartDate']??"";
        $strEndDate	    = $this->_arrSearch['strEndDate']??"";
        if ($intPeriod == 1 && $strStartDate != "" && $strEndDate != "") {
            $strQuery .= $strWhereAnd . " article_createdate 
											BETWEEN '" . $strStartDate . "'
											AND '" . $strEndDate . "' ";
            $strWhereAnd = " AND ";
        }

        $strQuery .= " ORDER BY article_createdate DESC";
        if ($intLimit > 0) {
            $strQuery .= " LIMIT " . $intLimit;
        }
        //var_dump($strQuery);
        $arrArticles = $this->_db->query($strQuery)->fetchAll();
        return $arrArticles;
    }

    /**
     * Recherche un article par son ID
     * @param int $id Identifiant unique de l'article
     * @return array|bool Tableau des valeurs de l'article ou false
     */
    public function findById(int $id): array|bool
    {
        $strQuery = "SELECT articles.*, 
            CONCAT(users.user_name, ' ', users.user_firstname) AS article_creator_name
            FROM articles 
            INNER JOIN users ON article_creator = user_id
            WHERE article_id = :id";

        $rqPrepare	= $this->_db->prepare($strQuery);
        $rqPrepare->bindValue(":id", $id, PDO::PARAM_INT);
        
        $rqPrepare->execute();
        return $rqPrepare->fetch();
    }
}
