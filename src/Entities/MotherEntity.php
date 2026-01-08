<?php

namespace M2i\Blog\Entities;

abstract class MotherEntity
{
    protected string $_prefix;

    protected int $_id;
    
    /** 
    * Fonction d'hydratation 
    * @params $arrData arrayt Tableau des données à hydrater
    */
    public function hydrate(array $arrData):void{
        foreach ($arrData as $key=>$value){
            $strSetter = "set".ucfirst(str_replace($this->_prefix . "_", "", $key));
            if (method_exists($this, $strSetter)){
                $this->$strSetter($value);
            }
        }
    }
    
	public function setId(int $intId){
		$this->_id = $intId;
	}

	public function getId():int{
		return $this->_id;
	}
}