<?php

class Cgmi_Validate_Javascript_Login extends Cgmi_Validate_Javascript_Abstract{

	protected  $_key='login';
	private $_javascriptFile = 'validate/jquery.login.js';


	public function __construct($objValidate){
		$this->setRules($objValidate);
		$this->setMessage($objValidate);
	}

	public function setRules($objValidate){
		$this->_rules[$this->_key] = 'true';
	}

	public function setMessage($objValidate){
		foreach ($objValidate->getMessageTemplates() as $key => $message) {
			$this->_message[$this->_key] = $message;
		}
	}

	public function getJavascriptFile(){
		return JQUERY_DIR ? JQUERY_DIR.$this->_javascriptFile : $this->_javascriptFile;
	}

}