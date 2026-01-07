<?php

namespace Blog\Controllers;

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

        protected function _notFound(){
            header("Location:index.php?ctrl=errors&action=error_404");
            exit();
        }
    }
