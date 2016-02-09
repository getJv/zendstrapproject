<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        echo "<pre> MODULO: ", $this->getRequest()->getModuleName(), "SESSION LIMPA NESTE CONTROLLER-LOGOFF</pre>";

        $tt = Zend_Auth::getInstance();
        $tt->clearIdentity();
        $data = "<?xml version='1.0' encoding='UTF-8'?><config><nav></nav></config>";
        $tt = simplexml_load_string($data);

        $systemMapper = new Admin_Model_SystemMapper();
        $systems = $systemMapper->findUserSystems(1);

        $permissionsMapper = new Admin_Model_PermitionMapper();
        $menus = $permissionsMapper->getUserModules(1, 1, 1);
        //Jdebug($menu);
        foreach ($systems as $sys) {
            if (count($menus)) {
                $tt->nav->addChild('page' . $sys['id']);
                $tt->nav->{'page' . $sys['id']}->label = $sys['name'];
                $tt->nav->{'page' . $sys['id']}->uri = '/ZendstrapProject/' . $sys['identifier'];
                $tt->nav->{'page' . $sys['id']}->addChild('pages');
                foreach ($menus as $menu) {
                    $tt->nav->{'page' . $sys['id']}->pages->addChild('page' . $sys['id'] . '_'.$menu['module_id']);
                    $tt->nav->{'page' . $sys['id']}->pages->{'page' . $sys['id'] . '_'.$menu['module_id']}->label = $menu['module_name'];
                    $tt->nav->{'page' . $sys['id']}->pages->{'page' . $sys['id'] . '_'.$menu['module_id']}->uri = '/ZendstrapProject/' .$sys['identifier'] .'/'  .  $menu['controller_name'];
                }
            }else{
                $tt->nav->addChild('page_' . $sys['id']);
                $tt->nav->{'page' . $sys['id']}->label = $sys['name'];
                $tt->nav->{'page' . $sys['id']}->uri = '/ZendstrapProject/' . $sys['identifier'];
                
            }
        }
        
        
//       $config = new Zend_Config_Xml($tt->asXML(), 'nav');
//Jdebug($tt->asXML(),'s');
//        $navigation = new Zend_Navigation($config);
//
//        $this->view->navigation($navigation)->menu();


        Jdebug($this->view->getHelper('menu'),'om');


        //Jdebug($tt->nav,'sc');
    }

}
