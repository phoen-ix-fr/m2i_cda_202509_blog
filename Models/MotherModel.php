<?php

namespace Blog\Models;

use PDO;
use PDOException;

    /**
     * Classe mère des modèles
     * Basé sur un Singleton puisqu'on teste l'instance
     */
	abstract class MotherModel {
        
		protected object $_db;
        private static ?PDO $_dbInstance = null;

        public function __construct(){
            // Récupère ou crée la connexion singleton
            if (self::$_dbInstance === null) {
                try{
                    self::$_dbInstance = new PDO(
                        "mysql:host=localhost;dbname=blog_php",
                        "root",
                        "root",
                        array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC)
                    );
                    self::$_dbInstance->exec("SET CHARACTER SET utf8");
                    self::$_dbInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch(PDOException $e) {
                    echo "Échec : " . $e->getMessage();
                }
            }
            // Assigne la connexion singleton
            $this->_db = self::$_dbInstance;
        }
    }
