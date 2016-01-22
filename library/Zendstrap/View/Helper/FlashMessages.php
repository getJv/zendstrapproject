<?php

/**
 * Solução para impressão de flashMessages customizados
 * @link http://aaronsaray.com/blog/2011/06/14/easy-flash-messenger-messages-in-zend-framework/
 * @author jhonatan.morais
 * @version 1.0
 *
 */
class Zendstrap_View_Helper_FlashMessages extends Zend_View_Helper_Abstract {

    public function flashMessages($currentMessages = true) {
        
        #Imprime mensagens para a pagina seguinte redirecionada... sobreescreve a $messages
        $messages = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger')->getMessages();
        #Imprime mensagens para a pagina atual. sem redirecionamento
        if ($currentMessages)
            $messages = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger')->getCurrentMessages();

        $output = '';

        if (!empty($messages)) {
            $infoMessages = "";
            $warnMessages = "";
            $successMessages = "";
            $errorMessages = "";
            foreach ($messages as $message) {
                switch ((string) key($message)) {
                    case 'info':
                        $infoMessages .= "<li >{$message[key($message)]}</li>";

                        break;
                    case 'warn':
                        $warnMessages .= "<li >{$message[key($message)]}</li>";
                        break;
                    case 'success':
                        $successMessages .= "<li >{$message[key($message)]}</li>";
                        break;
                    case 'error':
                        $errorMessages .= "<li >{$message[key($message)]}</li>";
                        break;
                }
            }
            if (!empty($infoMessages))
                $output .= "<ul class='alert alert-info list-unstyled' style='text-align:center' >$infoMessages</ul>";
            if (!empty($warnMessages))
                $output .= "<ul class='alert alert-warning list-unstyled' style='text-align:center'>$warnMessages</ul>";
            if (!empty($successMessages))
                $output .= "<ul class='alert alert-success list-unstyled' style='text-align:center'>$successMessages</ul>";
            if (!empty($errorMessages))
                $output .= "<ul class='alert alert-danger list-unstyled' style='text-align:center'>$errorMessages</ul>";
        }

        return $output;
    }

}
