<?php

class Cgmi_Form_Decorator_Captcha extends Zend_Form_Decorator_Captcha
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
        
        $view = $element->getView();

        $name = $element->getFullyQualifiedName();
        $hiddenName = $name . '[id]';
        $textName = $name . '[input]';
        
        $arrgetAttrbs = $element->getAttribs();
        $arrAttrbs = array_merge($arrgetAttrbs,array('class' => 'form-control'));
        $text = $view->formText($textName, '', $arrAttrbs);
        $hidden = $view->formHidden($hiddenName, $element->getValue(), $element->getAttribs());
        
        return $text . $hidden;
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
        
        $view = $element->getView();
        $captcha = $element->getCaptcha();
        $markup = $captcha->render($view, $element);
        
        
        
        $return .= '<div class="'.$element->getAttrib('class').'" align="left">';
        $return .= '<div class="imagem-captcha">' . $markup . '</div>';
        $return .= $this->buildInput();
        $return .= '</div>';

        $return .= '</div>';
        
        $return .= '<div id="custom-content-'.$element->getName().'"></div>';
        
        return $return;
    }
    
    public function render($content)
    {
        $element = $this->getElement();
        if (!method_exists($element, 'getCaptcha')) {
            return $content;
        }

        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }

        // Valor padrão da classe
        $classAtri = $element->getAttrib('class');
        if (empty($classAtri)){
            $element->setAttrib('class', 'col-sm-6');
        }
        
        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        $errors    = $this->buildErrors();

        $output = $errors;   
        
        switch ($placement) {
            case (self::PREPEND):
                return $output . $separator . $content;
            case (self::APPEND):
            default:
                //return $content . $separator . $output;
                return $separator . $output;
        }
    }
}
