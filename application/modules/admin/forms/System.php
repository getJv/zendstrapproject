<?php

class Admin_Form_System extends Zendstrap_Form
{

    public function init()
    {
        $this->setName('system');
               
        $id = new Zend_Form_Element_Hidden('id');
        
        $nome = new Zendstrap_Form_Element_Text('name');
        $nome->setLabel('Nome do sistema:')
              ->setRequired(true)
               ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
        
        
        $sigla = new Zendstrap_Form_Element_Text('identifier');
        $sigla->setLabel('Sigla:')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');

        $isPublic = new Zendstrap_Form_Element_Checkbox('is_public');
        $isPublic->setLabel('Sistema publico')
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
        
        $status = new Zendstrap_Form_Element_Checkbox('status');
        $status->setLabel('Situação Ativo')
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');

        $submit = new Zendstrap_Form_Element_Submit('submit');
        $submit->setLabel('Cadastrar')
               ->setAttrib('id', 'submitbutton');

        
        
        
//        $this->setInlineDisposition();
//       
        
        $nome->setHorizontalGroupFormDisplay('sm', 6);
        $sigla->setHorizontalGroupFormDisplay('sm', 6);
        $isPublic->setHorizontalGroupFormDisplay('sm', 3);
        $status->setHorizontalGroupFormDisplay('sm', 9);
        
        
         //  $this->setHorizontalDisposition();
        
        $this->setBoxContainer();
        
        $this->addElements(array($id,$nome, $sigla,$isPublic,$status, $submit));
    }


}

