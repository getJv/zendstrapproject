<?php
abstract class Zendstrap_Exception_ZendstrapException extends Exception
{
	
	public function __construct($message=null, $code = 0, Exception $previous = null) {
                # Garante que tudo está corretamente inicializado
		if(is_null($message))	$message = $this->__toString();
		parent::__construct($message, $code, $previous);
	}

	// Configura a apresentação padrão para excessões
	public function __toString() {
		/*TODO arrumar para gerar log completo para ser utilizado no loger*/
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}

	
}