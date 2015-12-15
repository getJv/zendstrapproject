<?php
/**
 * Valida pelo ZendX o Alnum
 * @author pedro151
 *
 */
class Cgmi_Validate_Javascript_Alnum extends Cgmi_Validate_Javascript_Abstract {

	protected  $_key='Alnum';
	private $_javascriptFile = 'validate/jquery.alnum.js';

	public function setRules($objValidate){
		$this->_rules[$this->_key]=true;
	}

	public function setMessage($objValidate)
	{
		# captura todas as Messagens
		$menssagens = $objValidate->getMessageTemplates();
		foreach ($menssagens as $key => $message)
		{
			# verifica se a traducao
			$translator = $objValidate->getTranslator();
			if (null !== $translator)
			{
				# traduz a menssagem
				$menssagens[$this->_key] =  $translator->translate($menssagens['notAlnum']);
				$this->_message[$this->_key] = $menssagens[$this->_key];
			}
		}
	}

	public function getJavascriptFile()
	{
		return JQUERY_DIR ? JQUERY_DIR.$this->_javascriptFile : $this->_javascriptFile;
	}


}