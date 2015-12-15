<?php

class Zendstrap_Form_Element_Hidden extends Zendstrap_Form_Element {

    /**
     * Use formHidden view helper by default
     * @var string
     */
    public $helper = 'formHidden';

    public function loadDefaultDecorators ()
    {
	if ( !$this->loadDefaultDecoratorsIsDisabled () )
	{
	    $decorators = $this->getDecorators ();
	    if ( empty ( $decorators ) )
	    {
		$this->addDecorator ( 'Hidden' );
	    }
	}
	return $this;
    }

}
