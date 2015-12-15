<?php

class Cgmi_Validate_Javascript_Date extends Cgmi_Validate_Javascript_Abstract{

	protected  $_key='Date';
	private $_javascriptFile = 'validate/jquery.date.js';


	public function __construct($objValidate){
		$this->setRules($objValidate);
		$this->setMessage($objValidate);
	}

	public function setRules($objValidate){
		$this->_rules[$this->_key] = true;
	}

	public function setMessage($objValidate){
		foreach ($objValidate->getMessageTemplates() as $key => $message) {
			$translator = $objValidate->getTranslator();
			if (null !== $translator) {
				$messages =  $translator->translate($message);
				switch ($key) {
					case 'dateInvalidDate':
						$this->_message[$this->_key] = $messages;
					default:
						//	$this->_message[$key] = $translator->translate($message);

						break;
				}
			}
		}
	}

	public function getJavascriptFile()
	{
		return JQUERY_DIR ? JQUERY_DIR.$this->_javascriptFile : $this->_javascriptFile;
	}

}