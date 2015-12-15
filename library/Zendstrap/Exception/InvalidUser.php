<?php

class Zendstrap_Exception_InvalidUser extends Zendstrap_Exception_ZendstrapException {

    protected $_message = "O usuário informado é inválido.";

    public function __construct($message, $code = 0, Exception $previous = null) {

        if (is_null($message))
            $message = $this->_message;
        parent::__construct($message, $code, $previous);
    }

}
