<?php

class Zendstrap_Form_Element_Textautocomplete extends Zendstrap_Form_Element
{
    public $helper = 'formText';
    
    public $_urlAjax;
    public $_urlCadastro;
    public $_inittypeahead = true;
    
    public function init()
    {
        $view = Zend_Layout::getMvcInstance()->getView();
        $this->getView()->headScript()->appendFile($view->baseUrl() . '/js/handlebars.js');
        $this->getView()->headScript()->appendFile($view->baseUrl() . '/js/typeahead.bundle.js');
        $this->getView()->headLink()->appendStylesheet($view->baseUrl() . '/css/field-aucomplete.css');
        
        $this->addValidator("NotEmpty");
        //$this->addFilters(array('StripTags','StringTrim'));
    }
    
    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return $this;
        }
        
        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('AutoComplete');
        }
        return $this;
    }
    
    public function setUrlAjax($urlAjax)
    {
        $this->_urlAjax = is_array($urlAjax)?$this->getView()->url($urlAjax):$urlAjax;;
        return $this;
    }
    
    
    public function getUrlAjax()
    {
        return $this->_urlAjax;
    }
    
    public function setUrlCadastro($urlCadastro)
    {
        $this->_urlCadastro = is_array($urlCadastro)?$this->getView()->url($urlCadastro):$urlCadastro;
        return $this;
    }
    
    public function getUrlCadastro()
    {
        return $this->_urlCadastro;
    }
    
    public function setInitTypeahead($boolean=true)
    {
        $this->_inittypeahead = $boolean;
        return $this;
    }
    
    public function getInitTypeahead()
    {
        return $this->_inittypeahead;
    }
}
