<?php

class Admin_Model_User implements Zend_Acl_Role_Interface
{
    private $_userName;
    private $_roleId = 'guest';
    private $_fullName;
    private $_systems;
    

    public function getUserName()
    {
        return $this->_userName;
    }

    public function setUserName($userName)
    {
        $this->_userName = (string) $userName;
    }

    public function getFullName()
    {
        return $this->_fullName;
    }

    public function setFullName($fullName)
    {
        $this->_fullName = (string) $fullName;
    }
    /**
     *
     */
    public function getRoleId()
    {
        return $this->_roleId;
    }

    public function setRoleId($roleId)
    {
        $this->_roleId = (string) $roleId;
    }
     public function getUserSystems()
    {
        return $this->_systems;
    }

    public function setUserSystems($userSystems)
    {
        $userSystems =   str_replace(array('{','}'), array('',''), $userSystems) ;
        $this->_systems = explode(',', $userSystems);
    }
}

