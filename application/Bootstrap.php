<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initDoctype() {

        $this->bootstrap('view');

        $view = $this->getResource('view');

        $view->doctype('HTML5');
    }

    /**
     * Inicializa os plugins utilizados na aplicação
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     * @date 25/06/2015 
     */
    protected function _initPlugins() {

        $front = Zend_Controller_Front::getInstance();

        # Carrega o plugin que faz a leitura do layout de cada modulo
        $front->registerPlugin(new Zendstrap_Plugins_LayoutSelector());
    }

    /**
     * Configura o menu do sistema a partir do arquivo navigation.ini
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     * @date 25/06/2015 
     */
    protected function _initNavigation() {
      
        $this->bootstrap('layout');

        $layout = $this->getResource('layout');

        $view = $layout->getView();

        $config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml','nav');
        
        $navigation = new Zend_Navigation($config);
          
        $menu = $view->navigation($navigation)->menu();
        
        $view->tt = $menu;
      
    }

    /**
     * Adiciona Classe do pacote Zendstrap_ ao loader de classes
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     * @date 25/06/2015 
     */
    public function _initLoader() {
        $loader = Zend_Loader_Autoloader::getInstance();
        $loader->setFallbackAutoloader(true);
//        $loader->registerNamespace('Zendstrap_');

//        $nameSpaceToPath = array(
//            'admin_' => APPLICATION_PATH . '/modules/admin'
//                //, 'Auth_' => APPLICATION_PATH . '/modules/Auth'
//        );
//
//        foreach ($nameSpaceToPath as $ns => $path) {
//            $resourceLoader = new Zend_Loader_Autoloader_Resource(
//                    array(
//                'basePath' => $path,
//                'namespace' => $ns
//                    )
//            );
//            $resourceLoader->addResourceType('model', 'models', 'Model_');
//        }
    }

    /**
     * Configura o local da Pasta de Helpers da bliblioteca Zendstrap
     */
    public function _initViewHelperPath() {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        //$view->addHelperPath ( "Zendstrap/View/Helper","Zendstrap_View_Helper_FlashMessages" );
        //$view->addHelperPath ( "Zendstrap/View/Helper","Zendstrap_View_Helper_Menu" );
    }

}
