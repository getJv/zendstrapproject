<?php
interface Zendstrap_Validate_Javascript_Interface{
	
	/**
	 * Diz a variavel do validador JS qual valor deve ter
	 * 
	 * @param String $objValidate
	 */
	public function setRules($objValidate);
	public function getRules($key);
	
	/**
	 * Diz a Message do Validador deve emitir
	 * 
	 * @param String $objValidate
	 */
	public function setMessage($objValidate);
	public function getMessage($key);

	public function getKeys();
	
	/**
	 * retorna qual o verdadeiro caminho do Script JS
	 * 
	 */
	public function getJavascriptFile();
	
	
}