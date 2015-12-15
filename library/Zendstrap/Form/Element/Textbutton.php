<?php

class Zendstrap_Form_Element_Textbutton extends Zendstrap_Form_Element {

    public $helper = 'formText';
    protected $_buttonId;
    protected $_buttonLabel;

    public function init ()
    {
	//$this->addValidator("NotEmpty");
	//$this->addFilters(array('StripTags','StringTrim'));
    }

    public function loadDefaultDecorators ()
    {
	if ( !$this->loadDefaultDecoratorsIsDisabled () )
	{
	    $decorators = $this->getDecorators ();
	    if ( empty ( $decorators ) )
	    {
		$this->addDecorator ( 'TextButton' );
	    }
	}
	return $this;
    }

    public function setButtonId ( $buttonId )
    {
	$this->_buttonId = $buttonId;
	return $this;
    }

    public function setButtonLabel ( $buttonLabel )
    {
	$this->_buttonLabel = $buttonLabel;
	return $this;
    }

    public function getButtonId ()
    {
	return $this->_buttonId;
    }

    public function getButtonLabel ()
    {
	return $this->_buttonLabel;
    }

}
