<?php

namespace Blog\Entities;

	class User {
		// Déclaration des attributs d'un utilisateur
		private int $_id;
		private string $_name='';
		private string $_firstname='';
		private string $_mail='';
		private string $_pwd;
		
		/** 
		* Fonction d'hydratation 
		* @params $arrData arrayt Tableau des données à hydrater
		*/
		public function hydrate(array $arrData):void{
			foreach ($arrData as $key=>$value){
				$strSetter = "set".ucfirst(str_replace("user_", "", $key));
				if (method_exists($this, $strSetter)){
					$this->$strSetter($value);
				}
			}
		}

		/* Setters et Getters */
		public function setId(int $intId){
			$this->_id = $intId;
		}
		public function getId():int{
			return $this->_id;
		}
		
		public function setName(string $strName){
			$this->_name = trim($strName);
		}
		public function getName():string{
			return $this->_name;
		}
		
		public function setFirstname(string $strFirstname){
			$this->_firstname = trim($strFirstname);
		}
		public function getFirstname():string{
			return $this->_firstname;
		}
		
		public function setMail(string $strMail){
			$this->_mail = trim($strMail);
		}
		public function getMail():string{
			return $this->_mail;
		}

		public function setPwd(string $strPwd){
			$this->_pwd = $strPwd;
		}
		public function getPwd():string{
			return $this->_pwd;
		}
		
	}