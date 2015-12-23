<?php

class Admin_Form_System extends Zend_Form
{

    public function init()
    {
        $this->setName('system');

        $id = new Zend_Form_Element_Hidden('id');
        
        $nome = new Zend_Form_Element_Text('name');
        $nome->setLabel('Nome do sistema:')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
        
        $sigla = new Zend_Form_Element_Text('identifier');
        $sigla->setLabel('Sigla:')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');

        $isPublic = new Zend_Form_Element_Checkbox('is_public');
        $isPublic->setLabel('Sistema publico?:')
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
        
        $status = new Zend_Form_Element_Checkbox('status');
        $status->setLabel('Situação Ativo:')
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Cadastrar')
               ->setAttrib('id', 'submitbutton');

        $this->addElements(array($id,$nome, $sigla,$isPublic,$status, $submit));
    }


}

