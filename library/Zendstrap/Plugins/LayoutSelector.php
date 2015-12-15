<?php

/**
 * Plugin para carregamento automatico de layouts por cada modulo da aplicação.
 * Para funcionar este pliguin deve ser inicializado no bootstrap principal. ()
 * @link http://stackoverflow.com/questions/14384100/multiple-layouts-for-different-modules-zend-framework Material complementar
 * @link https://vandenbos.org/zend-framework-module-specific-layout/ Material complementar
 * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
 * @version 1.0 - 09/12/2015
 */
class Zendstrap_Plugins_LayoutSelector extends Zend_Controller_Plugin_Abstract {

    /**
     * Verifica se existe configuração de layout se não existir então defini-se
     * @param Zend_Controller_Request_Abstract $request
     * @author tasmaniski, vandenbos, Jhonatan Morais
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
      
        $module = $request->getModuleName();
        $layout = Zend_Layout::getMvcInstance();
        $moduleDir = Zend_Controller_Front::getInstance()->getModuleDirectory();
        $layoutPath = 'layouts/scripts/';
        
        # se diferente do modulo default e tiver layout dentro do modulo, usamos ele.
        if ('default' !== $module && file_exists($moduleDir . DIRECTORY_SEPARATOR . $layoutPath . 'layout.phtml') ) {
            
            /* TODO Validar se o arquivo existe no diretorio */
            Zend_Layout::getMvcInstance()->setLayoutPath(
                    $moduleDir . DIRECTORY_SEPARATOR . $layoutPath
            );
            
            
        }
        
        
        $layout->setLayout('layout');
    }

}
