<?php

namespace M2i\Blog\Entities;

class User extends MotherEntity {

	// Déclaration des attributs d'un utilisateur
	
	private string $_name='';
	private string $_firstname='';
	private string $_mail='';
	private string $_pwd;

	private ?string $_strClearPwd = null;

	public function __construct()
	{
		$this->_prefix = 'user';
	}

	/* Setters et Getters */
	
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

		// Si un mot de passe en clair est présent, je le chiffre et le renvoi
		if($this->_strClearPwd) {
			$this->_pwd = password_hash($this->_strClearPwd, PASSWORD_DEFAULT);
		}

		// Sinon, comportement par défaut, on renvoi le mot de passe présent (qui doit être chiffré)
		return $this->_pwd;
	}

	public function setClearPwd(string $password)
	{
		$this->_strClearPwd = $password;
	}	

	public function getClearPwd(): string
	{
		return $this->_strClearPwd;
	}
}