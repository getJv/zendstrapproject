<?php

class Admin_Model_RoleMapper extends Zendstrap_Model_AbstractModelMapper {

    public function __construct() {
        $this->setDbTable('Admin_Model_DbTable_Role');
        $this->setBeanName('Admin_Model_Role');
        
        
        
        
    }
    
    public function fetchAll($object_format = false) {
        $ArrObj = parent::fetchAll($object_format);
        foreach($ArrObj as $obj){
            
            $obj->setPermissions($this->getPermmisions($obj));    
        }
        
        return $ArrObj;
        
    }
    public function getPermmisions(Admin_Model_Role $obj){
        
        $select = $this->getDbTable()->getAdapter()->select();
        $select->from('vw_roles_permissions',array('permissions'));
        $select->where('role_id = ?',$obj->id);
         $value = $select->query()->fetchAll();
        $value = str_replace(array('{', '}'), array('', ''), $value[0]['permissions']);
        $value = explode(',', $value);
        return $value;
        
    }

    
   

}
