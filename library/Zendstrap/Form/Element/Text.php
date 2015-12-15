<?php

class Zendstrap_Form_Element_Text extends Zend_Form_Element implements Zendstrap_Form_MyBootstrapInterface {

    private $bsUtils;

    public function __construct($spec, $options = null) {
        parent::__construct($spec, $options);

        $this->bsUtils = new Zendstrap_Form_MyBootstrapUtils();
    }

    public function init() {
        $this->addFilters(array('StripTags', 'StringTrim'));
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
                    ->addDecorator('Errors')
                    ->addDecorator('Description', array('tag' => 'p', 'class' => 'description'))
                    ->addDecorator('HelperBlock')
                    ->addDecorator('HtmlTag', array(
                        'tag' => 'div',
                        'id' => array('callback' => array(get_class($this), 'resolveElementId'))
                    ))
                    ->addDecorator('Label');
        }
        return $this;
    }

    /**
     * Render form element
     *
     * @param  Zend_View_Interface $view
     * @return string
     */
    public function render(Zend_View_Interface $view = null) {
        $this->setBootstrapConfiguration();

        return $this->bsUtils->divFormGroup(parent::render($view));
    }

    /* ########################################################################
     * # Declaração dos métodos da interface  Cgmi2_Form_MyBootstrapInterface.#
     * # todos com chamadas diretas aos métodos da classe                     #
     * # Cgmi2_Form_MyBootstrapUtils. Esta estratégia foi adotada devido a    #
     * # ausência de Traits no PHP 5.3, versão a qual trabalhava à época      #
     * # de criação desta solução. Jhonatan Morais                            #  
     * ######################################################################## */

    public function setBootstrapConfiguration($content = null) {

        $this->bsUtils->addCssClass($this, Cgmi2_Form_MyBootstrapUtils::BS_FIELD_CSS_CLASS);

        /**
         * Configuro a renderização para formularios horizontais ou não
         */
        if ($this->hasHorizontalDisplay()) {
            if ($this->hasHorizontalGroupFormDisplay())
                throw new Exception('Não é permitido utilizar os métodos "setHorizontalFieldDisplay" e o "setHorizontalGroupFormDisplay" juntos em um mesmo elemento');
            $this->getDecorator('HtmlTag')->setOption('tag', 'div');
            $this->bsUtils->addCssClass($this, $this->getHorizontalFieldDisplay(), 'HtmlTag');
            $this->bsUtils->addCssClass($this, $this->getHorizontalLabelDisplay(), 'Label');
            if ($this->hasOffsetField()) {

                $this->bsUtils->addCssClass($this, $this->getOffsetField(), 'HtmlTag');
            }
            if ($this->hasOffsetLabel())
                $this->bsUtils->addCssClass($this, $this->getOffsetLabel(), 'Label');
        }else {
            $this->removeDecorator('HtmlTag');
        }
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
