<?php

/**
 * Classe abstrata para modelosMapper, contém metódos uteis comuns ao uso de model e model Mapers
 * 
 * @author jhonatan.morais
 */
abstract class Zendstrap_Model_AbstractModelMapper {

    protected $_dbTable;
    protected $_beanName;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable ();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {

        if (null === $this->_dbTable) {
            throw new Exception('No table data gateway provided configured');
        }
        return $this->_dbTable;
    }

    /**
     * Registra o nome da classe beans que do Model que reflete a entidade do banco de dados
     * @param string $beanName Nome da classe Model. Ex.: Admin_Model_User
     * @throws Exception Caso a classe informada não seja instancia de Zendstrap_Model_AbstractModel
     */
    public function setBeanName($beanName) {

        if (!(new $beanName() instanceof Zendstrap_Model_AbstractModel)) {

            throw new Exception("A classe {$beanName} não é instancia de Zendstrap_Model_AbstractModel");
        }
        $this->_beanName = $beanName;
    }

    /**
     * Retorna o nome da classe beans que do Model que refleta a entidade do banco de dados
     * @throws Exception caso não o nome não esteja configurado
     */
    public function getBeanName() {

        if (null === $this->_beanName) {
            throw new Exception('O nome da Model Class não foi configurado. Consulta o método setBeanName().');
        }
        return $this->_beanName;
    }

    private function getModelClass(array $options = null) {
        $className = $this->getBeanName();
        return new $className($options);
    }

    /**
     * Retorna um array com todos os registros da base
     * @param string $modelClassName Nome da class model que deseja consultar. exemplo: Admin_Model_User
     * @return array de objetos
     */
    public function fetchAll() {

        $arr = array();

        $rs = $this->getDbTable()->fetchAll();
        foreach ($rs as $entry) {
            $arr[] = $this->getModelClass($entry->toArray());
        }

        return $arr;
    }
    /**
     * Retorna um registro conforme o id informado
     * @param string $id valor de chave primaria a ser consultado na entidade da base de dados
     * @return object Retorna um objeto em caso de sucesso e null em caso de falha
     */
    public function find($id) {
        
        $result = $this->getDbTable()->find($id);
         
        if (0 == count($result)) {
            return null;
        }
       
        return $this->getModelClass($result->current()->toArray());
    }
    /**
     * Realiza o INSERT ou UPDATE do objeto recebido.</br>
     * IMPORTANTE: O primeiro atributo do beanModel deve ser o campo id(PK) da entidade.</br>
     * Caso não seja possivel atender esta condição  sobreescreva o metodo save no Mapper correspondente.
     * @param Zendstrap_Model_AbstractModel $obj
     * @throws Exception
     */
    public  function save($obj){ 
        
        if (!( $obj instanceof Zendstrap_Model_AbstractModel)) {

            throw new Exception("A classe ".  get_class($obj)." não é instancia de Zendstrap_Model_AbstractModel");
        }
        $arrData = $obj->toArray();
        if (null === ($id = $obj->getId())) {
            
            array_shift($arrData); #retiro o primeiro registro(PK) para não dar ero de insert
            $this->getDbTable()->insert($arrData);
        } else {
            
            $keys = array_keys($arrData);
            $this->getDbTable()->update($arrData, array($keys[0].'= ?' => $id));
        
            
        }
        
        
    }

       
}
