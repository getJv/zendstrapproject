<?php

class Admin_Model_SystemMapper extends Zendstrap_Model_AbstractModelMapper {

    public function __construct() {
        $this->setDbTable('Admin_Model_DbTable_System');
        $this->setBeanName('Admin_Model_System');
        
        
    }
    
    public function findByModule($identifier){
        
        return $this->getDbTable()->select()->where('identifier = ?',$identifier)->query()->fetchAll();
        
    }
    
    public function findUserSystems($userId){
        
        $select = $this->getDbTable()->getAdapter()->select();
        $select->from('systems');
        $select->joinInner('members','systems.id = members.user_id');
        $select->where('members.user_id = ?',$userId);
        return $select->query()->fetchAll();
    }

    
   

}
