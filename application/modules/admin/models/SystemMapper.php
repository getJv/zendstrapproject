<?php

class Admin_Model_SystemMapper extends Zendstrap_Model_AbstractModelMapper {

    public function __construct() {
        $this->setDbTable('Admin_Model_DbTable_System');
        $this->setBeanName('Admin_Model_System');
    }

   

}
