<?php

/**
 * Classe abstrata para modelos, contém metódos uteis comuns ao uso de model e model Mapers
 * IMPORTANTE: é altamente recomentavel criar os models mantendo o nome de cada atributo 
 * exatamente igual as colunas da entidade na base de dados. Apesar de a nomenclatura ficar ruim esta ação ,
 * vai te ajudar muito na hora de trabalhar com o ZendForm e com os métodos de consulta do Mapper que usam 
 * array tendo como chave o nome dos campos da entidade.
 * @author jhonatan.morais
 */
abstract class Zendstrap_Model_AbstractModel {

    
    /**
     * Retorna os atributos do objeto dentro de um array simples
     * @return type
     */
    public function getArrayCopy() {
        $arr = get_object_vars($this);


        return $arr;
    }
    /**
     * Retira a definição(destroy) de um atributo
     * @param type $propName
     */
    public function unsetProp($propName){
        unset($this->$propName);
    }
    
    
    /**
     * Cria um objeto a partir de um array  que contenha seus atributos
     * @param array $options Array com os atributos do objeto desejado
     */
    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid class property');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid class property');
        }
        return $this->$method();
    }
    /**
     * Auxilia o método contrutor a criar um objeto populado a partir de um  array
     * @param array $options
     * @return \Zendstrap_Model_AbstractModel
     */
    public function setOptions(array $options) {
       
        
        
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

}
