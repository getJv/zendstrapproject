<?php

class Admin_Model_PermitionMapper extends Zendstrap_Model_AbstractModelMapper {

    public function __construct() {
        $this->setDbTable('Admin_Model_DbTable_Role');
        $this->setBeanName('Admin_Model_Role');
    }
    
    public function getUserModules($userId,$roleId,$systemId){
        
        $select = $this->getDbTable()->getAdapter()->select();
        $select->from('vw_user_module_permission',array('vw_user_module_permission.module_id','vw_user_module_permission.module_name','vw_user_module_permission.controller_name'));
        $select->where('user_id = ?',$userId);
        $select->where('role_id = ?',$roleId);
        $select->where('system_id = ?',$systemId);
        $select->group(array('vw_user_module_permission.module_id','vw_user_module_permission.module_name','vw_user_module_permission.controller_name'));
        $value = $select->query()->fetchAll();
        return $value;
        
        
    }
    public function getSystems($userId){
        
        $select = $this->getDbTable()->getAdapter()->select();
        $select->from('vw_user_module_permission');
        $select->where('user_id = ?',$userId);
        $value = $select->query()->fetchAll();
        return $value;
        
        
    }
}
