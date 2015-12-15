<?php

class Zendstrap_Form_Element_Submit extends Zend_Form_Element_Submit {

    /**
     * Default decorators
     *
     * Uses only 'Submit' and 'li' decorators by default.
     * 
     * @return void
     */
    public function init ()
    {
	$this->setAttrib ( 'class', 'btn btn-success' );
	$this->setIgnore ( true );
    }

    public function loadDefaultDecorators ()
    {
	if ( !$this->loadDefaultDecoratorsIsDisabled () )
	{
	    $decorators = $this->getDecorators ();
	    if ( empty ( $decorators ) )
	    {
		$this->addDecorator ( 'Tooltip' )
			->addDecorator ( 'ViewHelper' );
	    }
	}
    }

}
