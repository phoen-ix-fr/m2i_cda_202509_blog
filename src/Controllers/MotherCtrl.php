<?php

namespace M2i\Blog\Controllers;

/**
 * Classe mère des controllers
 */
    abstract class MotherCtrl {

        protected array $_arrData = [];

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
