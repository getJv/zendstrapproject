<?php

/**
 * Valida pelo ZendX o Alnum
 * @author pedro151
 *
 */
class Zendstrap_Validate_Javascript_Identical extends Zendstrap_Validate_Javascript_Abstract {

    protected $_key = 'equalTo';

    public function setRules($objValidate) {
        $this->_rules[$this->_key] = '\'#' . $objValidate->getToken() . '\'';
    }

    public function setMessage($objValidate) {
        # captura todas as Messagens
        $menssagens = $objValidate->getMessageTemplates();
        foreach ($menssagens as $key => $message) {
            # verifica se a traducao
            $translator = $objValidate->getTranslator();
            if (null !== $translator) {
                # traduz a menssagem
                $menssagens[$this->_key] = $translator->translate($menssagens['notSame']);
                $this->_message[$this->_key] = $menssagens[$this->_key];
            }
        }
    }

}
