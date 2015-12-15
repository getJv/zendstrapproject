<?php

abstract class Zendstrap_Validate_Javascript_Abstract implements Zendstrap_Validate_Javascript_Interface{
	
	protected $_rules = array();
	protected $_message = array();
	protected $_key;

	
	public function __construct($objValidate){
		$this->setRules($objValidate);
		$this->setMessage($objValidate);
	}
	
	public function setRules($objValidate){}
	public function setMessage($objValidate){}
	
	public function getRules($key){
		return $this->_rules[$key];
	}

	public function getMessage($key){
		return $this->_message[$key];
	}
	
	public function getKeys(){
		return $this->_key;
	}

	public function getJavascriptFile(){
	}
}