<?php

namespace M2i\Blog\Controllers;

use Smarty\Smarty;

/**
 * Classe mère des controllers
 */
abstract class MotherCtrl {

    protected array $_arrData = [];

    private static ?Smarty $_smartyInstance = null;

    /**
     * Création du Singleton pour Smarty
     * 
     * @return Smarty Objet Smarty pour la génération des vues
     */
    protected function getSmarty() : Smarty
    {
        if(self::$_smartyInstance == null) {

            // Création de l'instance de Smarty
            self::$_smartyInstance = new Smarty();

            // Définition du chemin des templates (gabarits) qui seront utilisés
            self::$_smartyInstance->setTemplateDir('templates/');

            // Configuration des chemins des templates compilés et du cache
            self::$_smartyInstance->setCompileDir('templates_c/');
            self::$_smartyInstance->setCacheDir('cache/');
        }

        return self::$_smartyInstance;
    }

    protected function _displaySmarty(string $strTemplate)
    {
        // Transmission des variables contenues dans 
        // _arrData à la vue via assign() de Smarty
        foreach ($this->_arrData as $key => $value) {

            $this->getSmarty()->assign($key, $value);
        }        

        // $smarty->display('index.tpl');
        $this->getSmarty()->display($strTemplate);
    }

    /**
     * Fonction d'affichage
     * @param string $strTemplate nom de la vue à afficher
     * @return void Affichage de la vue
     */
    protected function _display(string $strTemplate){
        foreach ($this->_arrData as $key => $value){
            $$key = $value;
        }
        require("views/_partial/header.php");
        include('views/'.$strTemplate.'.php');
        require("views/_partial/footer.php");
    }

    protected function _notFound()
    {
        header("Location:index.php?ctrl=errors&action=error_404");
        exit();
    }

    protected function _forbidden()
    {
        header("Location:index.php?ctrl=errors&action=error_403");
        exit();
    }

    /**
     * Redirection vers une URL donnée
     * 
     * @param string $controller
     * @param string $action
     * @param array $params (facultatif)
     */
    protected function _redirect(string $controller, string $action, array $params = [])
    {
        $header = "Location:index.php?ctrl=$controller&action=$action";

        // Dans le param, les données sont sous la forme clé=>valeur
        // ex. ['id' => 3, 'page' => 6]
        // final attendu à la fin du header : ...&id=3&page=6

        foreach($params as $key => $value) {
            $header .= '&' . $key . '=' . $value;
        }

        header($header);
        exit();
    }
}
