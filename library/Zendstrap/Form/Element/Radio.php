<?php

class Zendstrap_Form_Element_Radio extends Zend_Form_Element_Multi {

    public $helper = 'formRadio';

    public function loadDefaultDecorators ()
    {
	if ( !$this->loadDefaultDecoratorsIsDisabled () )
	{
	    $decorators = $this->getDecorators ();
	    if ( empty ( $decorators ) )
	    {
		$this->addDecorator ( 'InputBootstrap' );
	    }
	}
	return $this;
    }

}
