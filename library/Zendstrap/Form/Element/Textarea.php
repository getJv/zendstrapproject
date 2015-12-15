<?php

class Zendstrap_Form_Element_Textarea extends Zendstrap_Form_Element
{
    public $helper = 'formTextarea';
    
    public function init() {
        $this->addValidator("NotEmpty");
        $this->addFilters(array('StripTags','StringTrim'));
    }
}

