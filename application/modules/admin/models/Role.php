<?php

class Admin_Model_Role extends Zendstrap_Model_AbstractModel {

    protected $id;
    protected $name;
    protected $system_id;
    protected $permissions;


    public function setId($value) {

        $this->id = $value;
    }

    public function getId() {

        return $this->id;
    }
    public function setName($value) {

        $this->name = $value;
    }

    public function getName() {

        return $this->name;
    }
    public function setSystem_id($value) {

        $this->system_id = $value;
    }

    public function getSystem_id() {

        return $this->system_id;
    }

    public function setPermissions($value) {
        
        $this->permissions = $value;
         
    }

    public function getPermissions() {

        return $this->permissions;
    }

    
    
    
    }
