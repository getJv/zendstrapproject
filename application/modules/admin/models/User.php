<?php



class Admin_Model_User extends Zendstrap_Model_AbstractModel implements Zend_Acl_Role_Interface {

    protected $id;
    protected $login;
    protected $hashed_password;
    protected $firstname;
    protected $lastname;
    protected $mail;
    protected $mail_notification;
    protected $admin;
    protected $status;
    protected $last_login_on;
    protected $language;
    protected $created_on;
    protected $updated_on;
    protected $_roleId = 'guest';
    protected $_systems;

    public function getId() {
        return $this->id;
    }

    public function setId($value) {
        $this->id =  $value;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($userName) {
        $this->login = (string) $userName;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function setFirstname($value) {
        $this->firstname =  $value;
    }
    
    public function getLastname() {
        return $this->lastname;
    }

    public function setLastname($value) {
        $this->lastname =  $value;
    }
    
    public function getMail() {
        return $this->mail;
    }

    public function setMail($value) {
        $this->mail =  $value;
    }
    
    
    public function getFullName() {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getRoleId() {
        return $this->_roleId;
    }

    public function setRoleId($roleId) {
        $this->_roleId = (string) $roleId;
    }

    public function getUserSystems() {
        return $this->_systems;
    }

    public function setUserSystems($userSystems) {
        $userSystems = str_replace(array('{', '}'), array('', ''), $userSystems);
        $this->_systems = explode(',', $userSystems);
    }

}
