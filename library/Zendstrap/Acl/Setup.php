<?php

/* COLOCAR ESTA CHAMADA DENTRO DO CONTROLE DE AUTENTICAÇÂO  */

/**
 * Description of Setup
 *
 * @author jhonatan.morais
 */
class Zendstrap_Acl_Setup
{
    /**
     * @var Zend_Acl
     */
    protected $_acl;

    public function  __construct()
    {
        $this->_acl = new Zend_Acl();
        $this->_initialize();
    }

    protected function _initialize()
    {
        
        $this->_setupRoles();
       
        $this->_setupResources();
        
        $this->_setupPrivileges();
         
        $this->_saveAcl();
        
    }

    protected function _setupRoles()
    {
        $this->_acl->addRole( new Zend_Acl_Role('guest') );
        $this->_acl->addRole( new Zend_Acl_Role('visualizador'), 'guest' );
        $this->_acl->addRole( new Zend_Acl_Role('admin') );
    }
    /**
     * Registro os controllers
     */
    protected function _setupResources()
    {
        
        $this->_acl->addResource( new Zend_Acl_Resource('user') );
        $this->_acl->addResource( new Zend_Acl_Resource('auth') );
        $this->_acl->addResource( new Zend_Acl_Resource('error') );
        $this->_acl->addResource( new Zend_Acl_Resource('system') );
        
    }

    protected function _setupPrivileges()
    {
        $this->_acl->allow( 'guest', 'auth', array('index', 'login') )
                   ->allow( 'guest', 'error', array('error', 'forbidden') );
                   
        $this->_acl->allow( 'visualizador', 'user', 'view' )
                   ->allow( 'visualizador', 'auth', 'logout' );
        
        $this->_acl->allow( 'admin', 'user', array('index', 'adicionar','view','edit','active','unactive') )
                   ->allow( 'admin', 'auth', 'logout' )
                   ->allow( 'admin', 'system', array('index','add','edit','view','changestatus') )
                    ;
    }

    protected function _saveAcl()
    {
        $registry = Zend_Registry::getInstance();
        $registry->set('acl', $this->_acl);
    }
}