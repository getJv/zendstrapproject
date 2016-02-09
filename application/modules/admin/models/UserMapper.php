<?php

class Admin_Model_UserMapper extends Zendstrap_Model_AbstractModelMapper {

    public function __construct() {
        $this->setDbTable('Admin_Model_DbTable_User');
        $this->setBeanName('Admin_Model_User');
    }

}
