<?php

class Zendstrap_Form_Element_Button extends Zend_Form_Element_Button {

    private $bsUtils;

    public function __construct($spec, $options = null) {
        parent::__construct($spec, $options);

        $this->bsUtils = new Zendstrap_Form_MyBootstrapUtils();
        #Garanto a apresentação padrão de layout
        if (is_null($this->getAttrib('class')))
            $this->setColorLayout();
    }

    /**
     * Default decorators
     * @return Zend_Form_Element_Submit
     */
    public function loadDefaultDecorators() {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return $this;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('Tooltip')
                    ->addDecorator('ViewHelper');
        }
        return $this;
    }

    /**
     * Define a classe css que controla a cor de apresentação do elemento
     * Opções: default, primary, success, info, warning, danger, link
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setColorLayout($color = 'default') {
        if (!in_array($color, $this->bsUtils->getColorClassValues()))
            throw new Exception('O Valor ' . $color . ' não é utilizado dentro do bootstrap. Veja os valores válidos: ' . $this->bsUtils->getColorClassValues(true));
        $this->bsUtils->addCssClass($this, 'btn btn-' . $color);
    }

    /**
     * Define a classe css que controla o tamanho de apresentação do elemento
     * Opções: sm, xs, lg
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setSizeLayout($size = 'sm') {
        if (!in_array($size, $this->bsUtils->getSizeClassValues()))
            throw new Exception('O Valor ' . $size . ' não é utilizado dentro do bootstrap. Veja os valores válidos: ' . $this->bsUtils->getSizeClassValues(true));
        $this->bsUtils->addCssClass($this, 'btn-' . $size);
    }

    /**
     * Define a classe css 'btn-block' para o button fazendo com que ele ocupe todo o tamanho horizontal da tela.
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setBlockLayout() {

        $this->bsUtils->addCssClass($this, 'btn-block');
    }
    
    /**
     * Adicona a classe 'active' ao elemento dando uma aparencia de ligado/selecionado
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setActiveLayout(){
        $this->bsUtils->addCssClass($this, 'active');
    }
    
    /**
     * Adicona o atributo 'disabled="disabled"' ao HTMl do elemento
     * dando o uma aparência de desligado/desativado
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setDisableLayout(){
        $this->setAttrib('disabled', 'disabled');
    }
    /**
     * Altera o typo do button para type='submit'
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function useAsSubmit(){
        $this->setAttrib('type', 'submit');
    }
    
    /**
     * Altera o button para ser um botão voltar simples (history back) ou para uma url desejada
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function useAsBackButton($url = null){
        
        if($this->getAttrib('type') == 'submit'){
             throw new Exception('Não use os métodos useAsSubmit e useAsBackButton juntos em um mesmo botão. Não é possivel submeter o formulário e voltar uma página ao mesmo tempo.');
        }
        
        if(is_null($url)){
            $this->setAttrib('onClick', 'history.go(-1);return true;');
        }else{
            $this->setAttrib('onClick', "location.href=('{$url}')");
        }
       
    }

}
