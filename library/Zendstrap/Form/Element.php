<?php

class Zendstrap_Form_Element extends Zend_Form_Element 
{
    
    const BS_FORM_FIELD_GROUP_CSS_CLASS      = 'form-group';
    const BS_FIELD_CSS_CLASS                 = 'form-control';
    const BS_LABEL_CSS_CLASS                 = 'control-label';
    /**
     * @todo Verificar as siglas e tamanhos corretos para os tipos de tamanho e acrescenta las no array de disposição dos campos do form 
     */
    protected $_sizeClassValues = array('sm','lg'); 
    protected $_horizonralColSizeValues = array(1,2,3,4,5,6,7,8,9,10,11,12);
    
    /*
     * Variáveis utilizadas para uso em formulários horizontais
     */
    protected $_horizontalFieldConfiguration = null;
    protected $_horizontalLabelConfiguration = null;
    protected $_horizontalLabelOffset = null;
    protected $_horizontalFieldOffset = null;
    protected $_horizontalGroupFormElement = null;
    protected $_helperBlock = null;
    
   
    
    /**
     * Load default decorators
     *
     * @return Zend_Form_Element
     */
    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return $this;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('ViewHelper')
                 ->addDecorator('Errors')
                 ->addDecorator('Description', array('tag' => 'p', 'class' => 'description'))
                 ->addDecorator('HelperBlock')
                 ->addDecorator('HtmlTag', array(
                     'tag' => 'div',
                     'id'  => array('callback' => array(get_class($this), 'resolveElementId'))
                 ))
                 ->addDecorator('Label');
        }
        return $this;
    }
    
    /**
     * Adiciona o elemento e sua label em um container Div, conforme indicado pelo bootstrap CSS
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    protected function _addFormFieldGroup($elements){
         
        $formFieldCssClass = self::BS_FORM_FIELD_GROUP_CSS_CLASS;
        if($this->hasHorizontalGroupFormConfiguration()) 
         {
             $formFieldCssClass .= " ".$this->_horizontalGroupFormElement;
             
         }
        return "<div class='".$formFieldCssClass."'>". $elements ."</div>"; 
         
     }

    /**
     * Define a configuração da classe CSS da label e seu input para correta renderização em um formulario horizontal 
     * @param char(2) $sizeClass
     * @param int $colLabelSize
     * @param int $colElementSize
     * @throws Exception
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setHorizontalFieldDisplay($sizeClass,$colLabelSize,$colElementSize){
        /*
         * Valido os parametros
         */
        if( !(
                in_array($sizeClass, $this->_sizeClassValues) 
                && in_array($colLabelSize, $this->_horizonralColSizeValues)
                && in_array($colElementSize, $this->_horizonralColSizeValues)
           )){ throw new Exception('Os parametros informados em ('. __METHOD__ .') não são válidos');  }
         
         if( ($colLabelSize + $colElementSize) > 12 ) {throw new Exception('A soma dos valores de $colLabelSize e $colElementSize não pode ser superior a 12');}
           
         /*
          * Trato os valores para compor a classe CSS para fomularios horizontais 
          */  
           $sizeClass   = "-{$sizeClass}";
           $colLabelSize    = "-{$colLabelSize}";
           $colElementSize    = "-{$colElementSize}";
            
            $this->_horizontalLabelConfiguration = "col". $sizeClass . $colLabelSize;
            $this->_horizontalFieldConfiguration = "col". $sizeClass . $colElementSize;
        
        
    }
    /**
     * Verifica se a classe CSS para configuração do elemento dentro de um formulário horizontal foi definida
     * @return boolean
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function hasHorizontalConfiguration(){
        
        if(is_null($this->_horizontalLabelConfiguration) || is_null($this->_horizontalFieldConfiguration) )
            return false;
        return true;
        
        
    } 
    /**
     * Verifica se a classe CSS para configuração do offset do elemento dentro foi definida
     * @return boolean
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function hasFieldOffsetConfiguration(){
        
        if(is_null($this->_horizontalFieldOffset) )
            return false;
        return true;
        
        
    } 
    
    /**
     * Verifica se a classe CSS para configuração do offset da label do elemento dentro foi definida
     * @return boolean
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function hasLabelOffsetConfiguration(){
        
        if(is_null($this->_horizontalLabelOffset) )
            return false;
        return true;
        
        
    } 
     /**
     * Configura o offset da label do elemento baseado em sua configuração horizontal já existente
     * @param integer $offset
     * @throws Exception
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setLabelOffsetConfiguration($offsetValue){
        /*
         * Validações necessárias
         */
        if (!$this->hasHorizontalConfiguration())  throw new Exception('Antes de configurar o offset da label você deve definir a configuração horizontal do campo, utilize o método setHorizontalFieldDisplay para isto.');
        if (!is_numeric($offsetValue))  throw new Exception('O paramêtro $offsetValue de'. __METHOD__ .' deve ser do tipo integer.' );    
        /*
         * Tratamento para construção da classe Offset
         */
        $offset = explode('-' , $this->_horizontalLabelConfiguration);
        $offset[2] = 'offset';
        $offset[3] = $offsetValue;
        $this->_horizontalLabelOffset = implode('-', $offset);
        
    }
    
    /**
     * Configura o offset no elemento baseado em sua configuração horizontal já existente
     * @param integer $offset
     * @throws Exception
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setFieldOffsetConfiguration($offsetValue){
        /*
         * Validações necessárias
         */
        if (!$this->hasHorizontalConfiguration())  throw new Exception('Antes de configurar o offset do field você deve definir a configuração horizontal do campo, utilize o método setHorizontalFieldDisplay para isto.');
        if (!is_numeric($offsetValue))  throw new Exception('O paramêtro $offsetValue de'. __METHOD__ .' deve ser do tipo integer.' );    
        /*
         * Tratamento para construção da classe Offset
         */
        $offset = explode('-' , $this->_horizontalFieldConfiguration);
        $offset[2] = 'offset';
        $offset[3] = $offsetValue;
        $this->_horizontalFieldOffset = implode('-', $offset);
        
    }
    
    
            
   /**
     * Adiciona e organiza as classes de Css do formulário 
     * @param string $classNames
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    protected function _addClassNames($classNames) {
        $classes = $this->_getClassNames();

        foreach ((array) $classNames as $className) {
            $classes[] = $className;
        }

        $this->setAttrib('class', trim(implode(' ', array_unique($classes))));
       
    }
    
    /**
     * Retorna as classes CSS de um Zend_Form_Element quando fornecido 
     * OU do proprio elemento por padrão
     *
     * @param Zend_Form_Element $element
     * @return array
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    protected function _getClassNames(Zend_Form_Element $element = null) {
        if (null !== $element) {
            return explode(' ', $element->getAttrib('class'));
        }

        return explode(' ', $this->getAttrib('class'));
    }
   
    /**
     * Removes a class name definida para o elemento
     * @param string $classNames
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    protected function _removeClassNames($classNames) {
        $this->setAttrib('class', trim(implode(' ', array_diff($this->_getClassNames(), (array) $classNames))));
    }
    
        
     /**
     * Adiciona e organiza as classes de Css no  decorator do elemento 
     * @param string $decoratorName Nome de um decoretor utilizado no elemento
     * @param string $classNames nome da classe CSS que você deseja adicionr ao decorator do elemento
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    protected function _addClassNamesToDecorator($decoratorName,$classNames) {
        $classes = $this->_getClassNamesFromDecorator($decoratorName);

        foreach ((array) $classNames as $className) {
            $classes[] = $className;
        }
        
        $this->getDecorator($decoratorName)->setOption('class', trim(implode(' ', array_unique($classes))));
       
    }
    
    /**
     * Retorna as classes CSS de Decorator de um Zend_Form_Element quando fornecido 
     * OU do proprio elemento por padrão
     *
     * @param Zend_Form_Element $element
     * @return array
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    protected function _getClassNamesFromDecorator($decoratorName,Zend_Form_Element $element = null) {
       
        if (null !== $element) {
            return explode(' ', $element->getDecorator($decoratorName)->getOption('class'));
        }
//Jdebug($decoratorName);
        return explode(' ', $this->getDecorator($decoratorName)->getOption('class'));
    }
   
    /**
     * Removes a class CSS de um decoretor utilizado no elemento
     * @param string $classNames
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    protected function _removeClassNamesFromDecorator($decoratorName,$classNames) {
        $this->getDecorator($decoratorName)->setOption('class', trim(implode(' ', array_diff($this->_getClassNamesHtmlTagDecorator(), (array) $classNames))));
    }
    
    
    /**
     * Verifica se foi configurado um helperBlock para o Elemento
     * @return boolean
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function hasHelperBlock(){
        
        if(is_null($this->_helperBlock) )
            return false;
        return true;
        
        
    }
    /**
     * Permite definir uma mensagem para ser utilizada dentro do helperBlock elementeo de ajuda do bootStrap
     * @param string $message Mensagem que vai aparecer no helperblock do elemento
     * @link http://getbootstrap.com/css/#forms
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setHelperBlock($message){
        
        $this->_helperBlock =  $message;
        
    }
    
    /*
     * Recupera a mensagem de helperblock defiida para o elemento
     * @link http://getbootstrap.com/css/#forms
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function getHelperBlock(){
        
        return $this->_helperBlock;
        
    }
    
    
    /**
     * Define o elemento como obrigatório e acrescenta as classes de CSS required 
     * @param bool $flag
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
     public function setRequired($flag = true) {
         parent::setRequired($flag);
         
         if((bool)$flag){
            $this->addValidator("NotEmpty");
            
          }else{
             $this->removeValidator("NotEmpty");
         
          }
          
          return $this;
     }
    
    
    /**
     * Verifica se um elemento deve ter uma apresentaçao horizontal dentro de um form com apresentação padrão
     * @return boolean
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function hasHorizontalGroupFormConfiguration(){
        
        if(is_null($this->_horizontalGroupFormElement)  )
            return false;
        return true;
        
        
    } 
    
    /**
     * Define a configuração CSS horizontal  para um grupo de elementos em um formulario não horizontal 
     * @param char(2) $sizeClass
     * @param int $colLabelSize
     * @param int $colElementSize
     * @throws Exception
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setHorizontalGroupFormDisplay($sizeClass,$colElementSize){
        /*
         * Valido os parametros
         */
        if( !(
                in_array($sizeClass, $this->_sizeClassValues) 
                && in_array($colElementSize, $this->_horizonralColSizeValues)
           )){ throw new Exception('Os parametros informados em ('. __METHOD__ .') não são válidos');  }
            
           
         /*
          * Trato os valores para compor a classe CSS para fomularios horizontais 
          */  
           $sizeClass   = "-{$sizeClass}";
           $colElementSize    = "-{$colElementSize}";
            
           $this->_horizontalGroupFormElement = "col". $sizeClass . $colElementSize;
           
        
    }
    
    
   
}
