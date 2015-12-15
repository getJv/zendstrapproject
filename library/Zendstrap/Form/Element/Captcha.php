<?php

class Zendstrap_Form_Element_Captcha extends Zend_Form_Element_Captcha {

    public function __construct ( $spec, $options = null )
    {
	$view = Zend_Layout::getMvcInstance ()->getView ();
	$options = array( 'captcha' => array(
		'captcha' => 'Image',
		'wordLen' => 5,
		'timeout' => 300,
		'fontsize' => 25,
		'font' => APPLICATION_PATH . '/../public/fonts/Verdana.ttf',
		'imgDir' => APPLICATION_PATH . '/../public/img/captcha/',
		'imgUrl' => $view->baseUrl () . '/img/captcha/',
		'ImgAlt' => 'Captcha',
		'ImgAlign' => 'left',
		'width' => '200',
		'height' => '69',
		'dotNoiseLevel' => 50,
		'lineNoiseLevel' => 5
	) );
        
	parent::__construct ( $spec, $options );
    }

    public function loadDefaultDecorators ()
    {
	if ( !$this->loadDefaultDecoratorsIsDisabled () )
	{
	    $decorators = $this->getDecorators ();
	    if ( empty ( $decorators ) )
	    {
		$this->addDecorator ( 'Captcha' );
	    }
	}
	return $this;
    }

}
