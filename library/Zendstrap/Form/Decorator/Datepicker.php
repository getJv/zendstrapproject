<?php

class Cgmi_Form_Decorator_Datepicker extends Zend_Form_Decorator_Abstract implements ZendX_JQuery_Form_Decorator_UiWidgetElementMarker
{
    public function buildLabel()
    {
        $element = $this->getElement();
        $label = $element->getLabel();
        if ($translator = $element->getTranslator()) {
                $label = $translator->translate($label);
        }
        
        if ($element->isRequired()){
        	 $label =  $label.'*';
        }
        return $element->getView()
        ->formLabel($element->getName(), $label);
    }
    
    
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
        $arrAttrbs = array_merge($arrgetAttrbs,array('class' => 'typeahead form-control'));
 
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
            $return .= '<label class="col-sm-4 control-label" for="input'.$element->getName().'">'.$element->getLabel().'</label>';
        }
        
        
        
      $return = '<div class="form-group'.$hasError.'" id="group-'.$element->getName().'">';
        if($element->getLabel()){
        $label = $element->getLabel();
         if ($element->isRequired()){
        	 $label =  $label.'<red>*</red>';
        }
            $return .= '<label class="col-sm-4 control-label" for="input'.$element->getName().'">'.$label.'</label>';
        }
        
        
        $return .= 
                '<div class="'.$element->getAttrib('class').'" align="left">' . 
                    '<div class="input-group date">'.
                        $this->buildInput() .
                        '<span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>' .
                    '</div>' .
                '</div>';

        $return .= '</div>';
        
        $return .= '<div id="custom-content-'.$element->getName().'"></div>';
        
        $element->getView()->jQuery()->addOnLoad("
                $('.input-group.date').datepicker({
                    language: 'pt-BR',
                    format: 'dd/mm/yyyy',
                    todayHighlight: true,
                    autoclose: true
                });"
        );
        
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
        $element->getView()->jQuery()->addOnLoad("$('#description-".$element->getName()."').tooltip();");
        $element->options["_classDivInput"][] = "input-append";
        $element->options["_alingAddIco"]["_append"] =  '<span id="description-'.$element->getName().'" data-toggle="tooltip" title="" data-placement="right" data-original-title="'.$desc.'"><span class="add-on"><i class="icon-question-sign"></i></span></span>';
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
