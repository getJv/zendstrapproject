<?php

class Zendstrap_Form_Element_Reset extends Zendstrap_Form_Element_Submit
{
    public $helper = 'formReset';
    
    
    public function loadDefaultDecorators ()
    {
	if ( !$this->loadDefaultDecoratorsIsDisabled () )
	{
	    $decorators = $this->getDecorators ();
	    if ( empty ( $decorators ) )
	    {
		$this->addDecorator ( 'Reset' );
	    }
	}
	return $this;
    }
}

