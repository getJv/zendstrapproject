<?php

class Zendstrap_Exception_InvalidParams extends Zendstrap_Exception_ZendstrapException {

    protected $message = "Os parametros informados são inválidos.";

    public function __construct($message = null, $code = 0, Exception $previous = null) {

        if (empty($message))
            $message = $this->message;
        parent::__construct($message, $code, $previous);
    }

}
