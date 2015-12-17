<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
        $this->_acl->addRole( new Zend_Acl_Role('admin'), 'visualizador' );
    }
    /**
     * Registro os controllers
     */
    protected function _setupResources()
    {
        
        $this->_acl->addResource( new Zend_Acl_Resource('user') );
        $this->_acl->addResource( new Zend_Acl_Resource('auth') );
        $this->_acl->addResource( new Zend_Acl_Resource('error') );
        $this->_acl->addResource( new Zend_Acl_Resource('index') );
//        $this->_acl->addResource( new Zend_Acl_Resource('noticias') );
//        $this->_acl->addResource( new Zend_Acl_Resource('usuarios') );
    }

    protected function _setupPrivileges()
    {
        $this->_acl->allow( 'guest', 'index', array('index'))
                   ->allow( 'guest', 'auth', array('index', 'login') )
                   ->allow( 'guest', 'error', array('error', 'forbidden') );
                   
        $this->_acl->allow( 'visualizador', 'user', array('view') )
                   ->allow( 'visualizador', 'auth', 'logout' );
        
        $this->_acl->allow( 'admin', 'user', array('index', 'adicionar','view','edit','active','unactive') );
    }

    protected function _saveAcl()
    {
        $registry = Zend_Registry::getInstance();
        $registry->set('acl', $this->_acl);
    }
}