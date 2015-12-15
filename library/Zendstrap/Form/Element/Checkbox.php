<?php

class Zendstrap_Form_Element_Checkbox extends Zend_Form_Element_Checkbox implements Zendstrap_Form_MyBootstrapInterface {

    private $bsUtils;

    public function __construct($spec, $options = null) {
        parent::__construct($spec, $options);

        $this->bsUtils = new Zendstrap_Form_MyBootstrapUtils();
    }

    /**
     * Load default decorators
     *
     * @return Zend_Form_Element
     */
    public function loadDefaultDecorators() {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return $this;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('ViewHelper')
                    ->addDecorator('CheckBoxLabel')
                    ->addDecorator('Errors')
                    ->addDecorator('Description', array('tag' => 'p', 'class' => 'description'))
                    ->addDecorator('HelperBlock')
                    ->addDecorator('HtmlTag', array(
                        'tag' => 'label',
                        'id' => array('callback' => array(get_class($this), 'resolveElementId'))
            ));
            // ->addDecorator('Label');
        }
        return $this;
    }

    public function render(Zend_View_Interface $view = null) {
        $checkbox = parent::render($view);
        return $this->setBootstrapConfiguration($checkbox);
    }

    /* ############################################################################
     * # Declaração dos métodos da interface  Zendstrap_Form_MyBootstrapInterface.#
     * # todos com chamadas diretas aos métodos da classe                         #
     * # Zendstrap_Form_MyBootstrapUtils. Esta estratégia foi adotada devido a    #
     * # ausência de Traits no PHP 5.3, versão a qual trabalhava à época          #
     * # de criação desta solução. Jhonatan Morais                                #  
     * ######################################################################### */

    public function setBootstrapConfiguration($content = null) {

        #Adiciono o o ckeck dentro de uma divi com a classe checkbox
        $content = $this->bsUtils->divCheckBox($content);
        
        #Configuro a renderização para formularios horizontais
        if ($this->hasHorizontalDisplay()) {
            if($this->hasHorizontalGroupFormDisplay()) throw new Exception('Não é permitido utilizar os métodos "setHorizontalFieldDisplay" e o "setHorizontalGroupFormDisplay" juntos em um mesmo elemento');
            $horizontalClass = $this->getHorizontalFieldDisplay();
            if ($this->hasOffsetField())
                $horizontalClass .=' ' . $this->getOffsetField();
            return $this->bsUtils->divFormGroup($content,$horizontalClass);
        }

        
        #Configuro a renderização para formularios normais com customização de disposição
        if ($this->hasHorizontalGroupFormDisplay()) {
            if($this->hasHorizontalDisplay()) throw new Exception('Não é permitido utilizar os métodos "setHorizontalFieldDisplay" e o "setHorizontalGroupFormDisplay" juntos em um mesmo elemento');
            $horizontalClass = $this->getHorizontalGroupFormDisplay();
            if ($this->hasOffsetField())
                $horizontalClass .=' ' . $this->getOffsetField();
            return $this->bsUtils->divFormGroup($content,$horizontalClass);
        } 
        
        #Caso não exista nenhuma necessidade especial retorno o conteudo, pois já esta pronto para renderização.
        return $content; 

    }

    public function setHorizontalDisplay($sizeClass, $colLabelSize, $colElementSize) {
        $this->bsUtils->setHorizontalDisplay($sizeClass, $colLabelSize, $colElementSize);
    }

    public function getHorizontalFieldDisplay() {
        return $this->bsUtils->getHorizontalFieldDisplay();
    }

    public function getHorizontalLabelDisplay() {
        return $this->bsUtils->getHorizontalLabelDisplay();
    }

    public function setOffsetLabel($offsetValue) {
        $this->bsUtils->setOffsetLabel($offsetValue);
    }

    public function setOffsetField($offsetValue) {
        $this->bsUtils->setOffsetField($offsetValue);
    }

    public function setHorizontalGroupFormDisplay($sizeClass, $colSizeField) {
        $this->bsUtils->setHorizontalGroupFormDisplay($sizeClass, $colSizeField);
    }

    public function getHorizontalGroupFormDisplay() {
        return $this->bsUtils->getHorizontalGroupFormDisplay();
    }

    public function setHelperBlock($message) {
        $this->bsUtils->setHelperBlock($message);
    }

    public function getHelperBlock() {
        return $this->bsUtils->getHelperBlock();
    }

    public function hasHorizontalDisplay() {
        return $this->bsUtils->hasHorizontalDisplay();
    }

    public function hasOffsetField() {

        return $this->bsUtils->hasOffsetField();
    }

    public function hasOffsetLabel() {
        return $this->bsUtils->hasOffsetLabel();
    }

    public function hasHelperBlock() {
        return $this->bsUtils->hasHelperBlock();
    }

    public function hasHorizontalGroupFormDisplay() {
        return $this->bsUtils->hasHorizontalGroupFormDisplay();
    }

    public function getOffsetField() {

        return $this->bsUtils->getOffsetField();
    }

    public function getOffsetLabel() {
        return $this->bsUtils->getOffsetLabel();
    }

}


