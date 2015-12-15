<?php

class Cgmi2_Form_Decorator_HelperBlock extends Zend_Form_Decorator_Description 
{
    
    const BS_HELPER_BLOCK_CLASS = 'help-block';
    
    
    /**
     * Get class with which to define description
     *
     * Defaults to 'hint'
     *
     * @return string
     */
    public function getClass()
    {
        $class = $this->getOption('class');
        if (null === $class) {
            $class = self::BS_HELPER_BLOCK_CLASS;
            $this->setOption('class', $class);
        }

        return $class;
    }
    
    
    
    /**
     * Get HTML tag, if any, with which to surround description
     *
     * @return string
     */
    public function getTag()
    {
        if (null === $this->_tag) {
            $tag = $this->getOption('tag');
            if (null !== $tag) {
                $this->removeOption('tag');
            } else {
                $tag = 'p';
            }

            $this->setTag($tag);
            return $tag;
        }

        return $this->_tag;
    }
    
    
    
    
    /**
     * Render a description
     *
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

        
       // Jdebug($element,'c');
        
        $description = $element->getHelperBlock();
        $description = trim($description);

        if (!empty($description) && (null !== ($translator = $element->getTranslator()))) {
            $description = $translator->translate($description);
        }

        if (empty($description)) {
            return $content;
        }

        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        $tag       = $this->getTag();
        $class     = $this->getClass();
        $escape    = $this->getEscape();

        $options   = $this->getOptions();

        if ($escape) {
            $description = $view->escape($description);
        }

        if (!empty($tag)) {
            require_once 'Zend/Form/Decorator/HtmlTag.php';
            $options['tag'] = $tag;
            $decorator = new Zend_Form_Decorator_HtmlTag($options);
            $description = $decorator->render($description);
        }

        switch ($placement) {
            case self::PREPEND:
                return $description . $separator . $content;
            case self::APPEND:
            default:
                return $content . $separator . $description;
        }
    }
    
}
