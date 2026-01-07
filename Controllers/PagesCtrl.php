<?php

namespace Blog\Controllers;

/**
 * Controller des pages de contenu
 */
    class PagesCtrl extends MotherCtrl {

        /**
         * A propos
         * @return void
         */
        public function about(){	// Création des variables d'affichage
            $this->_arrData['strTitle'] 		= "À propos";
            $this->_arrData['strH1'] 			= "À propos";
            $this->_arrData['strMetaDesc'] 	    = "Découvrez qui nous sommes : notre équipe passionnée de développement web, notre mission et nos valeurs. Formations et expertise en programmation.";
            $this->_arrData['strDesc']		    = "Découvrez notre histoire, notre équipe et notre passion pour le développement web";

            // Variable technique
            $this->_arrData['strPage']		    = "about";

            $this->_display("pages/about");
        }

        /**
         * Contact
         * @return void
         */
        public function contact(){
            // Création des variables d'affichage
            $this->_arrData['strTitle'] 	= "Contact";
            $this->_arrData['strH1']	    = "Contact";
            $this->_arrData['strMetaDesc'] 	= "Découvrez qui nous sommes : notre équipe passionnée de développement web, notre mission et nos valeurs. Formations et expertise en programmation.";
            $this->_arrData['strDesc']		= "Contactez-nous pour toute question";

            // Variable technique
            $this->_arrData['strPage']		= "contact";

            $this->_display("pages/contact");
        }

        /**
         * Mentions légales
         * @return void
         */
        public function mentions(){
            // Création des variables d'affichage
            $this->_arrData['strTitle'] 	= "Mentions légales";
            $this->_arrData['strH1'] 		= "Mentions légales";
            $this->_arrData['strMetaDesc'] 	= "Découvrez qui nous sommes : notre équipe passionnée de développement web, notre mission et nos valeurs. Formations et expertise en programmation.";
            $this->_arrData['strDesc']		= "Informations légales et politique de confidentialité";

            // Variable technique
            $this->_arrData['strPage']		= "mentions";

            $this->_display("pages/contact");
        }

    }
