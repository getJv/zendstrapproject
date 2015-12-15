<?php

class Zendstrap_Validate_Javascript_NotEmpty extends Zendstrap_Validate_Javascript_Abstract{

	protected $_key='required';


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
			$messages =  $translator->translate($message);
			if (null !== $translator) {
				switch ($key) {
					case 'isEmpty':
						$this->_message[$this->_key] = $messages;
						break;
					default:
						//	$this->_message[$key] = $translator->translate($message);

						break;
				}

			}
		}

	}


}
