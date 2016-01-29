<?php

class Admin_Model_DbTable_System extends Zend_Db_Table_Abstract
{

    protected $_name = 'systems';
    static $columnCustomNames = array();
    
    
    public function __construct($config = array()) {
        parent::__construct($config);
        
        $this->setColumnCustomNames('id', 'Código');
        $this->setColumnCustomNames('name', 'Nome');
        $this->setColumnCustomNames('description', 'Descrição');
        $this->setColumnCustomNames('is_public', 'Público');
        $this->setColumnCustomNames('created_on', 'Criado em');
        $this->setColumnCustomNames('updated_on', 'Última Atualização');
        $this->setColumnCustomNames('identifier', 'Identificador');
        $this->setColumnCustomNames('status', 'Situação');
    }
    
     /**
     * Permite registrar os nomes customizados para cada atributo do model 
     * @param string $columnTableName
     * @param string $customName
     * @return void 
     */
    public function setColumnCustomNames($columnTableName,$customName){
        
        self::$columnCustomNames[$columnTableName] = $customName;
    }
     


}

