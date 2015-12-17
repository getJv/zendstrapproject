<?php

class Admin_Form_Login extends Zend_Form
{

    public function init()
    {
        $this->setName('login');

        $login = new Zend_Form_Element_Text('login');
        $login->setLabel('Login:')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->setValue('jhonatan.morais')  
              ->addValidator('NotEmpty');

        $senha = new Zend_Form_Element_Text('senha');
        $senha->setLabel('Senha:')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
                ->setValue('123')  
              ->addValidator('NotEmpty');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Logar')
               ->setAttrib('id', 'submitbutton');

        $this->addElements(array($login, $senha, $submit));
    }


}

