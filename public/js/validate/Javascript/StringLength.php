<?php

class Cgmi_Validate_Javascript_StringLength extends Cgmi_Validate_Javascript_Abstract {

	protected $_key = array('minlength','maxlength');
	
	public function setRules($objValidate){
		$this->_rules[$this->_key[0]] = ($objValidate->getMin())?$objValidate->getMin():0;
		$this->_rules[$this->_key[1]] = ($objValidate->getMax())? $objValidate->getMax():0;
	}

	public function setMessage($objValidate){

		foreach ($objValidate->getMessageTemplates() as $key => $message) {
			$translator = $objValidate->getTranslator();
			if (null !== $translator) {
				switch ($key) {
					case 'stringLengthTooShort':
						$messages =  $translator->translate($message);
						$messages = str_replace("de '%value%'", "", $messages);
						$this->_message[$this->_key[0]] = str_replace('%min%', $this->_rules[$this->_key[0]], $messages);
						break;
					case 'stringLengthTooLong':
						$messages = $translator->translate($message);
						$messages = str_replace("de '%value%'", "", $messages);
						$this->_message[$this->_key[1]] = str_replace('%min%', $this->_rules[$this->_key[1]], $messages);
						break;
							
					default:
					//	$this->_message[$key] = $translator->translate($message);

						break;
				}
			}
		}

	}

}