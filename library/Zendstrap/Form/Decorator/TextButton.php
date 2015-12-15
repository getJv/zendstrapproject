<?php

class Cgmi_Form_Decorator_TextButton extends Zend_Form_Decorator_Abstract implements ZendX_JQuery_Form_Decorator_UiWidgetElementMarker
{
    
    public function getName()
    {
        if (null === ($element = $this->getElement())) {
            return '';
        }

        $name = $element->getName();

        if (!$element instanceof Zend_Form_Element) {
            return $name;
        }

        if (null !== ($belongsTo = $element->getBelongsTo())) {
            $name = $belongsTo . '['
            . $name
            . ']';
        }

        if ($element->isArray()) {
            $name .= '[]';
        }

        return $name;
    }
        
    public function buildInput()
    {
        $element = $this->getElement();
        $helper  = $element->helper;
        
        $arrgetAttrbs = $element->getAttribs();
        $arrAttrbs = array_merge($arrgetAttrbs,array('class' => 'form-control'));
        
        return $element->getView()->$helper(
                $this->getName(),
                $element->getValue(),
                $arrAttrbs,
                $element->options
        );
    }
    
    public function buildErrors()
    {
        $element  = $this->getElement();
        $messages = $element->getMessages();
        $hasError = '';
        
        if (!empty($messages)) {
            $hasError = ' has-error';
        }

        $return = '<div class="form-group'.$hasError.'" id="group-'.$element->getName().'">';
        if($element->getLabel()){
        $label = $element->getLabel();
         if ($element->isRequired()){
        	 $label =  $label.'<red>*</red>';
        }
            $return .= '<label class="col-sm-4 control-label" for="input'.$element->getName().'">'.$label.'</label>';
        }
        
        $buttonDisabled = '';
        if (in_array('disabled', $element->getAttribs())){
            $buttonDisabled = ' disabled';
        }
        $return .= 
            '<div class="'.$element->getAttrib('class').'" align="left">' . 
                '<div class="input-group">' .
                    $this->buildInput() .
                    '<div class="input-group-btn">' . 
                        '<button id="'.$element->getButtonId().'" type="button" class="btn btn-default'.$buttonDisabled.'" tabindex="-1">'.$element->getButtonLabel().'</button>' .
                    '</div>' . 
                '</div>' . 
            '</div>';
        
        $return .= '</div>';
        $return .= '<div id="tableList-'.$element->getButtonId().'"></div>';
        
        return $return;
    }
    
    public function formErrors($errors)
    {
        foreach ($errors as $key => $error) {
            $errors[$key] = $error;
        }
        $html  = implode("<br>", (array) $errors);
        return $html;
    }
    
    public function buildDescription()
    {
        $element = $this->getElement();
        $desc    = $element->getDescription();
        if (empty($desc)) {
            return '';
        }
    }
    
    public function render($content)
    {
        $element = $this->getElement();
        
        if (!$element instanceof Zend_Form_Element) {
            return $content;
        }
        if (null === $element->getView()) {
            return $content;
        }

        // Valor padrão da classe
        $classAtri = $element->getAttrib('class');
        if (empty($classAtri)){
            $element->setAttrib('class', 'col-sm-6');
        }
        
        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        $desc      = $this->buildDescription();
        $errors    = $this->buildErrors();

        $output = $errors . $desc;   
        
        switch ($placement) {
            case (self::PREPEND):
                return $output . $separator . $content;
            case (self::APPEND):
            default:
                return $content . $separator . $output;
        }
    }
}
