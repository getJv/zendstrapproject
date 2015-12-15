<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Multiselect
 *
 * @author cast
 */
class Zendstrap_Form_Element_Multiselect extends Zendstrap_Form_Element_Select {

    /**
     * 'multiple' attribute
     * @var string
     */
    public $multiple = 'multiple';

    /**
     * Use formSelect view helper by default
     * @var string
     */
    public $helper = 'formSelect';

    /**
     * Multiselect is an array of values by default
     * @var bool
     */
    protected $_isArray = true;

    public function init ()
    {
	$this->addValidator ( "NotEmpty" );
    }

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
