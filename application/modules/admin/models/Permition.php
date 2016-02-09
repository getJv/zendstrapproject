<?php

class Admin_Model_Permition extends Zendstrap_Model_AbstractModel {

    protected $id;
    protected $name;
    protected $action_name;
    protected $system_id;
    
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
    public function setAction_name($value) {

        $this->action_name = $value;
    }

    public function getAction_name() {

        return $this->action_name;
    }
    public function setSystem_id($value) {

        $this->system_id = $value;
    }

    public function getSystem_id() {

        return $this->system_id;
    }

}
