<?php
class Cgmi_Validate_Javascript_EmailAddress extends Cgmi_Validate_Javascript_Abstract{

	protected $_key='email';

	public function setRules($objValidate){
		$this->_rules[$this->_key]=true;
	}

	public function setMessage($objValidate){
		foreach ($objValidate->getMessageTemplates() as $key => $message) {
			$translator = $objValidate->getTranslator();
			if (null !== $translator) {
				switch ($key) {
					case 'emailAddressInvalidFormat':
						$messages =  $translator->translate($message);
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