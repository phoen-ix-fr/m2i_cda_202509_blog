<?php

namespace M2i\Blog\Models;

use PDO;

/**
 * Modèle des utilisateurs
 */
	class UserModel extends MotherModel
	{

        /**
         * Recherche de tous les utilisateurs
         * @return array Tableau des utilisateurs
         */
		public function findAllUser(){
			// Récupérer les Utilisateurs
			$strQuery	= "SELECT user_id, user_name, user_firstname
							FROM users
							ORDER BY user_name, user_firstname";
			$arrUsers	= $this->_db->query($strQuery)->fetchAll();
			return $arrUsers;
		}

        /**
         * Recherche d'un utilisateur par son mail et son mot de passe
         * @param string $strMail Mail de l'utilisateur
         * @param string $strPwd Mot de passe en clair
         * @return mixed Tableau de l'utilisateur ou false si non trouvé
         */
		function getUserByMailAndPwd(string $strMail, string $strPwd) : array|bool{
			// Récupérer l'utilisateur
			$strQuery	= "SELECT user_id, user_name, user_firstname, user_pwd
							FROM users
							WHERE user_mail = :mail
							";
							
			$rqPrepare	= $this->_db->prepare($strQuery);
			$rqPrepare->bindValue(":mail", $strMail, PDO::PARAM_STR);
			
			$rqPrepare->execute();
			$arrUser = $rqPrepare->fetch();

			if(!$arrUser) { return false; }

			// Vérification du mot de passe
			if(password_verify($strPwd, $arrUser['user_pwd']))
			{
				// On retire du tableau association des données de l'utilisateur
				// Le Hash du mot de passe (pour des raisons de sécurité)
				unset($arrUser['user_pwd']);

				return $arrUser;
			}
			else
			{
				return false;
			}
		}

        /**
         * Recherche d'un utilisateur par son id
         * @param int $intId Identifiant de l'utilisateur
         * @return mixed Tableau de l'utilisateur ou false si non trouvé
         */
		function getUserById(int $intId):array|bool{
			// Récupérer l'utilisateur
			$strQuery	= "SELECT user_id, user_name, user_firstname, user_mail, user_token
							FROM users
							WHERE user_id = :id
							";
							
			$rqPrepare	= $this->_db->prepare($strQuery);
			$rqPrepare->bindValue(":id", $intId, PDO::PARAM_INT);
			
			$rqPrepare->execute();
			return $rqPrepare->fetch();		
		}

        /**
         * Insertion d'un utilisateur en bdd
         * @param $objUser objet de l'utilisateur
         * @return bool statut de l'insertion
         */
		function addUser(object $objUser):bool{
			// Ajouter un utilisateur en BDD
			$strQuery	= "INSERT INTO users (user_name, user_firstname, 
							user_mail, user_pwd)
							VALUES (:name, :firstname, :mail, :pwd)";
			
			$rqPrepare	= $this->_db->prepare($strQuery);
			$rqPrepare->bindValue(":name", $objUser->getName(), PDO::PARAM_STR);
			$rqPrepare->bindValue(":firstname", $objUser->getFirstname(), PDO::PARAM_STR);
			$rqPrepare->bindValue(":mail", $objUser->getMail(), PDO::PARAM_STR);
			$rqPrepare->bindValue(":pwd", $objUser->getPwd(), PDO::PARAM_STR);
			
			return $rqPrepare->execute();
		}

        /**
         * Modification d'un utilisateur
         * @param object $objUser objet utilisateur
         * @return bool statut de la modification
         */
		function editUser(object $objUser):bool{
			// Modifier un utilisateur en BDD
			$strQuery	= "UPDATE users 
							SET user_name = :name
								, user_firstname = :firstname
								, user_mail = :mail";
			if ($objUser->getPwd() != ""){
				$strQuery	.= " , user_pwd = :pwd";
			}			
								
			$strQuery	.= " WHERE user_id = :id	";
			
			$rqPrepare	= $this->_db->prepare($strQuery);
			$rqPrepare->bindValue(":name", $objUser->getName(), PDO::PARAM_STR);
			$rqPrepare->bindValue(":firstname", $objUser->getFirstname(), PDO::PARAM_STR);
			$rqPrepare->bindValue(":mail", $objUser->getMail(), PDO::PARAM_STR);
			
			if(isset($_SESSION['user'])) {
				$rqPrepare->bindValue(":id", $_SESSION['user']['user_id'], PDO::PARAM_INT);
			}
			else
			{
				$rqPrepare->bindValue(":id", $objUser->getId(), PDO::PARAM_INT);
			}
			
			if ($objUser->getPwd() != ""){
				$rqPrepare->bindValue(":pwd", $objUser->getPwd(), PDO::PARAM_STR);
			}
			
			return $rqPrepare->execute();
		}	

		function setToken(int $userId, string $jwtToken)
		{
			$strQuery	= "UPDATE users SET user_token = :token
							WHERE user_id = :id";
			
			$rqPrepare	= $this->_db->prepare($strQuery);
			$rqPrepare->bindValue(":token", $jwtToken, PDO::PARAM_STR);
			$rqPrepare->bindValue(":id", $userId, PDO::PARAM_INT);

			return $rqPrepare->execute();
		}

		public function getUnhashedPassword(): bool|array
		{
			$strQuery	= "SELECT user_id, user_name, user_firstname, user_mail, user_pwd FROM users WHERE user_pwd NOT LIKE '$2y%'";	

			$rqPrepare	= $this->_db->prepare($strQuery);
			
			$rqPrepare->execute();
			return $rqPrepare->fetchAll();	
		}
	}
