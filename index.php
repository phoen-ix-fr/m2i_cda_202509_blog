<?php

// Toutes les pages utilisent les sessions
session_start();

// Déclaration de l'autoloader (manuel)
spl_autoload_register(function($class) {

    // Pour chaque use, cette fonction sera appelée
    // ex. : use Blog\Controllers\ArticlesCtrl;
    // $class = "Blog\Controllers\ArticlesCtrl"

    // Objectif, transformer $class => chemin réel du fichier .php
    // ex. "./Controllers/ArticlesCtrl.php"

    $strWithoutBlog = str_replace('Blog\\', '', $class); //< "Controllers\ArticlesCtrl"
    $strInversedSlash = str_replace('\\', '/', $strWithoutBlog); //< "Controllers/ArticlesCtrl"

    $strFilename = './' . $strInversedSlash . '.php'; //< "./Controllers/ArticlesCtrl.php"
    
    // On vérifie si le fichier existe avant de faire le require_once
    if(file_exists($strFilename)) {
        require_once $strFilename;
    }
});

// Récupération des informations dans l'URL
$ctrl   = $_GET['ctrl']??'articles';
$action = $_GET['action']??'home';

// Flag sur la présence de la page
$bool404 = false;

// Création du nom de la classe
// On spécifie le nom complet de la classe avec le namespace
$strCtrlName    = 'Blog\\Controllers\\' . ucfirst($ctrl).'Ctrl';

// Test sur l'existence de la classe
if (class_exists($strCtrlName)) {

    // Instanciation de l'objet de la classe
    // Remplacer le nom par Blog\Controllers\Articles
    $objCtrl = new $strCtrlName();

    // Test sur la présence de la méthode dans l'objet instancié
    if (method_exists($objCtrl, $action)) {

        // Appel à la méthode
        $objCtrl->$action();

    }else{
        $bool404 = true;
    }
}
else{
    $bool404 = true;
}

// si un des éléments non trouvé => redirection vers page 404
if ($bool404) {
    header("Location:index.php?ctrl=errors&action=error_404");
    exit();
}

/*
// Inlcusion des mother
// require("models/mother_model.php");
// require("controllers/mother_controller.php");

// Création du nom du fichier controller
$strCtrlFile = 'controllers/'.$ctrl.'_controller.php';

// Test sur l'existence du fichier
if (file_exists($strCtrlFile)) {

    // inclusion du fichier
    require_once($strCtrlFile);

    // Création du nom de la classe
    $strCtrlName    = ucfirst($ctrl).'Ctrl';

    // Test sur l'existence de la classe
    if (class_exists($strCtrlName)) {

        // Instanciation de l'objet de la classe
        $objCtrl = new $strCtrlName();

        // Test sur la présence de la méthode dans l'objet instancié
        if (method_exists($objCtrl, $action)) {

            // Appel à la méthode
            $objCtrl->$action();
        }else{

            $bool404 = true;
        }

    }else{

        $bool404 = true;
    }
}else{

    $bool404 = true;
}


*/