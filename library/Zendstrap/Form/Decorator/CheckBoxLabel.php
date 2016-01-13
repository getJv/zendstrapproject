<?php

class Zendstrap_Form_Decorator_CheckBoxLabel extends Zend_Form_Decorator_Abstract 
{
    
   
    
    /**
     * Alteração do Render para possibilitar a impressão da label do checkbox conforme o exemplo exstente no site do bootStrap
     * @link http://getbootstrap.com/css/#forms-example Exemplo do html de checkbox utilizado pelo bootstrap
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     * @param  string $content
     * @return string
     */
    public function render($content)
    {
        $element = $this->getElement();
        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }

        $description = $element->getLabel();
        $description = trim($description);

        if (!empty($description) && (null !== ($translator = $element->getTranslator()))) {
            $description = $translator->translate($description);
        }

        if (empty($description)) {
            return $content;
        }

        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
     
        switch ($placement) {
            case self::PREPEND:
                return $description . $separator . $content;
            case self::APPEND:
            default:
                return $content . $separator . $description;
        }
    }
    
}

