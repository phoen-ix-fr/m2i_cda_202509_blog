<?php

namespace Blog\Controllers;

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // require("models/user_model.php");
    use Blog\Models\UserModel;

    // require("entities/user_entity.php");
    use Blog\Entities\User;

    /**
     * Controller des utilisateurs
     */
    class UsersCtrl extends MotherCtrl {

        /**
         * Page de connexion
         * @return void
         */
        public function login(){
            if (isset($_SESSION['user'])) { // utilisateur connecté
                $_SESSION['message'] = "Vous êtes déjà connecté";
                header("Location:edit_account.php");
                exit;
            }
            // Récupérer les données du formulaire
            $strMail = $_POST['mail'] ?? "";
            $strPwd = $_POST['pwd'] ?? "";

            $arrError = array();
            if (count($_POST) > 0) { // Le formulaire est envoyé
                if ($strMail == "") {
                    $arrError['mail'] = "Le mail est obligatoire";
                } else if (!filter_var($strMail, FILTER_VALIDATE_EMAIL)) {
                    $arrError['mail'] = "Le mail est invalide";
                }
                if ($strPwd == "") {
                    $arrError['pwd'] = "Le mot de passe est obligatoire";
                }

                // Si pas d'erreur => vérification de l'utilisateur en BDD
                if (count($arrError) == 0) {
                    $objUserModel = new UserModel();
                    $arrUser = $objUserModel->getUserByMailAndPwd($strMail, $strPwd);
                    if ($arrUser === false) { // utilisateur non trouvé !$arrUser
                        $arrError[] = "Erreur de connexion";
                    } else { // utilisateur trouvé
                        $_SESSION['user'] = $arrUser;
                        header("Location:index.php");
                        exit;
                    }
                }
            }
            // Création des variables d'affichage
            $this->_arrData['strTitle']     = "Se connecter";
            $this->_arrData['strH1']        = "Se connecter";
            $this->_arrData['strMetaDesc']  = "Se connecter";
            $this->_arrData['strDesc']      = "Page de se connecter";
            $this->_arrData['strMail']      = $strMail;
            $this->_arrData['arrError']     = $arrError;

            // Variable technique
            $this->_arrData['strPage'] = "login";
            $this->_display("login");
        }

        /**
         * Déconnexion
         */
        public function logout(){
            unset($_SESSION['user']);

            $_SESSION['message'] = "Vous êtes déconnecté";
            header("Location:index.php");
            exit;
        }

        /**
         * Page de création d'un compte
         * @return void
         * @throws Exception
         */
        public function create_account(){
            if (isset($_SESSION['user'])) { // utilisateur connecté
                $_SESSION['message'] = "Vous êtes déjà connecté";
                header("Location:edit_account.php");
                exit;
            }

            include "config/config.php";

            $objUser = new User;

            // Récupérer les données du formulaire
            $objUser->hydrate($_POST);

            $arrError = array();
            if (count($_POST) > 0) { // Le formulaire est envoyé
                // Filtrer les données
                $strName = htmlspecialchars(trim($objUser->getName()), ENT_QUOTES);

                // Tester les données reçues
                if ($strName == "") {
                    $arrError['name'] = "Le nom est obligatoire";
                }
                if ($objUser->getFirstname() == "") {
                    $arrError['firstname'] = "Le prénom est obligatoire";
                }
                if ($objUser->getMail() == "") {
                    $arrError['mail'] = "Le mail est obligatoire";
                } else if (!filter_var($objUser->getMail(), FILTER_VALIDATE_EMAIL)) {
                    $arrError['mail'] = "Le mail est invalide";
                }
                if ($objUser->getPwd() == "") {
                    $arrError['pwd'] = "Le mot de passe est obligatoire";
                } else if ($objUser->getPwd() != $_POST['confirm_pwd']) {
                    $arrError['pwd'] = "Le mot de passe doit être identique à sa confirmation";
                }

                // Si pas d'erreur => insertion en bdd
                if (count($arrError) == 0) {
                    $objUserModel = new UserModel();
                    $boolInsert = $objUserModel->addUser($objUser);
                    if ($boolInsert) {
                        // Si insertion ok
                        // => Envoyer le mail de demande de confirmation du compte
                        // A déporter dans un autre fichier pour réutiliser
                        require 'libs/PHPMailer/Exception.php';
                        require 'libs/PHPMailer/PHPMailer.php';
                        require 'libs/PHPMailer/SMTP.php';
                        $objMail = new PHPMailer();
                        $objMail->IsSMTP();
                        $objMail->CharSet = PHPMailer::CHARSET_UTF8;
                        $objMail->Mailer = "smtp";
                        $objMail->SMTPDebug = 0;
                        $objMail->SMTPAuth = TRUE;
                        $objMail->SMTPSecure = "tls";
                        $objMail->Port = 587;
                        $objMail->Host = MAIL_HOST;
                        $objMail->Username = MAIL_USER;
                        $objMail->Password = MAIL_PWD;
                        $objMail->IsHTML(true);
                        // Expéditeur
                        $objMail->setFrom('contact@ce-formation.com', 'christel');
                        // Destinataire
                        $objMail->addAddress($objUser->getMail(), $strName);
                        // Sujet
                        $objMail->Subject = "Création du compte - confirmation";
                        // Contenu du mail
                        $objMail->Body = "Merci de confirmer la création de votre compte à l'aide du lien suivant
										...								
									";
                        // Envoi du mail avec vérification
                        if (!$objMail->send()) {
                            $arrErrors[] = 'Erreur de Mailer : ' . $objMail->ErrorInfo;
                        } else {
                            $_SESSION['message'] = "Votre compte a bien été créé";
                            // => redirection login.php
                            header("Location:index.php?ctrl=users&action=login");
                            exit; // par sécurité arrêter l'exécution
                        }
                    } else {
                        $arrError[] = "Un erreur s'est produite, contactez l'administrateur";
                    }
                }
            }

            // Création des variables d'affichage
            $this->_arrData['strTitle']     = "Créer un compte";
            $this->_arrData['strH1']        = "Créer un compte";
            $this->_arrData['strMetaDesc']  = "Créer un compte";
            $this->_arrData['strDesc']      = "Page de création de compte";

            $this->_arrData['arrError']     = $arrError;
            $this->_arrData['objUser']      = $objUser;

            // Variable technique
            $this->_arrData['strPage']      = "create_account";

            $this->_display("create_account");
        }

        /**
         * Page de modification d'un compte
         * @return void
         */
        public function edit_account(){
            if(!isset($_SESSION['user'])){ // utilisateur non connecté
                header("Location:error_403.php");
                exit;
            }

            // Récupérer les données de l'utilisateur
            $objUserModel	= new UserModel();
            $arrUser		= $objUserModel->getUserById($_SESSION['user']['user_id']);

            $objUser		= new User();
            $objUser->hydrate($arrUser);

            $strPseudo		= $_POST['pseudo']??$_COOKIE["pseudo"]??"";

            $arrError 		= array();
            if (count($_POST) > 0){ // Le formulaire est envoyé
                $objUser->hydrate($_POST);

                // Tester les données reçues
                if ($objUser->getName() == ""){
                    $arrError['name'] = "Le nom est obligatoire";
                }
                if ($objUser->getFirstname() == ""){
                    $arrError['firstname'] = "Le prénom est obligatoire";
                }
                if ($objUser->getMail() == ""){
                    $arrError['mail'] = "Le mail est obligatoire";
                }else if (!filter_var($objUser->getMail(), FILTER_VALIDATE_EMAIL)){
                    $arrError['mail'] = "Le mail est invalide";
                }

                if ($objUser->getPwd() != ""){
                    if ($objUser->getPwd() != $_POST['confirm_pwd']){
                        $arrError['pwd'] = "Le mot de passe doit être identique à sa confirmation";
                    }
                }

                // Si pas d'erreur => modification en bdd
                if (count($arrError) == 0){
                    //require_once("user_model.php"); // par sécurité si pas déjà inclus
                    $boolUpdate = $objUserModel->editUser($objUser);
                    if ($boolUpdate){
                        // Si modification ok => on informe
                        $_SESSION['message'] = "Les modifications ont bien été effectuées";
                        // Mettre à jour la session
                        $_SESSION['user']['user_name']		= $objUser->getName();
                        $_SESSION['user']['user_firstname']	= $objUser->getFirstname();
                        // Mettre à jour le pseudo si renseigné
                        if ($strPseudo != ""){
                            setcookie("pseudo", $strPseudo, time()+365*24*3600);
                        }else if (isset($_COOKIE['pseudo'])){
                            setcookie("pseudo", "", -1);
                        }
                        // Actualise l'entête
                        header("Refresh:5");
                    }else{
                        $arrError[] = "Un erreur s'est produite, contactez l'administrateur";
                    }
                }
            }

            // Création des variables d'affichage
            $this->_arrData['strTitle']     = "Modifier son compte";
            $this->_arrData['strH1'] 		= "Modifier son compte";
            $this->_arrData['strMetaDesc'] 	= "Modifier son compte";
            $this->_arrData['strDesc']		= "Page de modification de son compte";

            $this->_arrData['objUser']      = $objUser;
            $this->_arrData['arrError']     = $arrError;
            $this->_arrData['strPseudo']    = $strPseudo;

            // Variable technique
            $this->_arrData['strPage']		= "edit_account";

            $this->_display("edit_account");
        }

    }
