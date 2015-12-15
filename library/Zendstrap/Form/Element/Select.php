<?php

class Zendstrap_Form_Element_Select extends Zend_Form_Element_Multi {

    /**
     * 'multiple' attribute
     * @var string
     */
    public $multiple = false;

    /**
     * Use formSelect view helper by default
     * @var string
     */
    public $helper = 'formSelect';

    public function init() {
        $this->addValidator("NotEmpty");
    }

    public function loadDefaultDecorators() {
        if (!$this->loadDefaultDecoratorsIsDisabled()) {
            $decorators = $this->getDecorators();
            if (empty($decorators)) {
                $this->addDecorator('InputBootstrap');
            }
        }
        return $this;
    }

}
