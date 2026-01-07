<?php

namespace Blog\Entities;

use IntlDateFormatter;

class Article extends MotherEntity {
	// Déclaration des attributs d'un article
	
	private string $_title='';
	private string $_img='';
	private string $_content='';
	private string $_createdate='';
	private int $_creator;
	private string $_creator_name;

	public function __construct()
	{
		$this->_prefix = 'article';
	}

	/* Setters et Getters */
	
	public function setTitle(string $strTitle){
		$this->_title = trim($strTitle);
	}
	public function getTitle():string{
		return $this->_title;
	}
	
	public function setImg(string $strImg){
		$this->_img = trim($strImg);
	}
	public function getImg():string{
		return $this->_img;
	}
	
	public function setContent(string $strContent){
		$this->_content = trim($strContent);
	}
	public function getContent():string{
		return $this->_content;
	}

	public function setCreatedate(string $strCreatedate){
		$this->_createdate = $strCreatedate;
	}
	public function getCreatedate():string{
		return $this->_createdate;
	}

	public function setCreator(int $intCreator){
		$this->_creator = $intCreator;
	}
	public function getCreator():int{
		return $this->_creator;
	}

	public function getCreatedateFormat(string $strLocale = 'fr_FR'){
		// Traitement de date

		// Pour les classes natives de PHP, deux solutions :
		// - Soit \ (back-slash) avant le nom pour lui dire d'aller la récupérer en dehors des espaces de noms
		// - Soit un use au début du fichier
		$objDate			= new \DateTime($this->getCreatedate());
		$objDateFormatter	= new IntlDateFormatter(
			$strLocale, // langue
			IntlDateFormatter::LONG,  // format de date
			IntlDateFormatter::NONE, // format heure
		);
		return $objDateFormatter->format($objDate);
	}

	public function setCreator_name(string $strCreatorName){
		$this->_creator_name = $strCreatorName;
	}
	public function getCreator_name(){
		return $this->_creator_name;
	}

	public function getSummary(int $intLength = 45){
		// Traitement du résumé
		return substr($this->getContent(), 0, $intLength) . ((strlen($this->getContent()) > $intLength) ? "..." : "");
	}
}
