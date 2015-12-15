<?php

class Zendstrap_Validate_Javascript_CNPJ extends Zendstrap_Validate_Javascript_Abstract{

	protected  $_key='cnpj';
	private $_javascriptFile = 'validate/jquery.cnpj.js';

	public function setRules($objValidate)
	{
		$this->_rules[$this->_key] = true;
	}

	public function setMessage($objValidate)
	{
		foreach ($objValidate->getMessageTemplates() as $key => $message) 
		{
			$this->_message[$this->_key] = $message;
		}
	}

	public function getJavascriptFile()
	{
		return JQUERY_DIR ? JQUERY_DIR.$this->_javascriptFile : $this->_javascriptFile;
	}

}