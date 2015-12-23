<?php

class Admin_Model_System extends Zendstrap_Model_AbstractModel {

    protected $id;
    protected $name;
    protected $is_public = 0;
    protected $created_on;
    protected $updated_on;
    protected $identifier;
    protected $status;

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

    public function setIs_public($value) {

         
        $this->is_public = (bool) (false == $value )? 0:1;
    }

    public function getIs_public() {

        return (bool) $this->is_public;
    }

    public function setCreated_on($value) {

        $this->created_on = $value;
    }

    public function getCreated_on() {
        if(null === $this->created_on) {return date('Y-m-d H:i:s');}
        return $this->created_on;
    }

    public function setUpdated_on($value) {
        
        $this->updated_on = $value;
    }

    public function getUpdated_on() {

        return date('Y-m-d H:i:s');
    }

    public function setIdentifier($value) {

        $this->identifier = $value;
    }

    public function getIdentifier() {

        return $this->identifier;
    }

    public function setStatus($value) {

        $this->status = $value;
    }

    public function getStatus() {

        return $this->status;
    }

}
