<?php

class Zendstrap_Form_Element_Datepicker extends Zendstrap_Form_Element_Text {

    

    

   public function setAsDatePicker(){
       
       $this->setAttrib('type', 'date');
   }
   
    public function render(Zend_View_Interface $view = null) {
        
        $this->setAsDatePicker();
        parent::render($view);
       
        
        
    }

}
