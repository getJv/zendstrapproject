<?php

class Zendstrap_Form_MyBootstrapUtils implements Zendstrap_Form_MyBootstrapInterface {

    const BS_FORM_FIELD_GROUP_CSS_CLASS = 'form-group';
    const BS_FORM_CHECKBOX_GROUP_CSS_CLASS = 'checkbox';
    const BS_FIELD_CSS_CLASS = 'form-control';
    const BS_LABEL_CSS_CLASS = 'control-label';
    const BS_HIDDEN_CSS_CLASS = 'sr-only';

    /**
     * @todo Verificar as siglas e tamanhos corretos para os tipos de tamanho e acrescenta las no array de disposição dos campos do form 
     */
    protected $_sizeClassValues = array('sm', 'lg', 'xl');
    protected $_colorClassValues = array('default', 'primary', 'success', 'info', 'warning', 'danger', 'link');
    protected $_horizonralColSizeValues = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);

    /*
     * Variáveis utilizadas para uso em formulários horizontais
     */
    protected $_horizontalFieldDisplay = null;
    protected $_horizontalLabelDisplay = null;
    protected $_horizontalOffsetLabel = null;
    protected $_horizontalOffsetField = null;
    protected $_horizontalGroupFormDisplay = null;
    protected $_helperBlock = null;

    /**
     * Retorna o array com o nome das classes de cor utilizadas no bootstrap
     * @param bool $asString Quando TRUE retornas os valores como uma string 
     * @return array de cores 
     */
    public function getColorClassValues($asString = false) {
        if ($asString) {
            return implode(',', $this->_colorClassValues);
        }
        return $this->_colorClassValues;
    }

    /**
     * Retorna o array com os tipos de tamamnho para apresentação de elementos utilizadas no bootstrap
     * @param bool $asString Quando TRUE retornas os valores como uma string
     * exemplo: sm, lg... etc...
     * @return array de tipos de tamanho 
     */
    public function getSizeClassValues($asString = false) {
        if ($asString) {
            return implode(',', $this->_sizeClassValues);
        }
        return $this->_sizeClassValues;
    }

    /**
     * Classe Utilitária para adicionar o HTML dos elementos renderizados dentro de 
     * uma Div de form-group, e a configuração de disposição horizontal quando necessário
     * @param string $elements
     * @return type
     */
    public function divFormGroup($elements) {
        $cssClss = self::BS_FORM_FIELD_GROUP_CSS_CLASS;

        if ($this->hasHorizontalGroupFormDisplay()) {
            $cssClss .= " " . $this->_horizontalGroupFormDisplay;
        }
        return "<div class='" . $cssClss . "'>" . $elements . "</div>";
    }

    /**
     * Classe Utilitária para adicionar o HTML do elemento CHECKBOX já renderizado dentro de 
     * uma Div de classe checkbox. e a configuração de disposição horizontal quando necessário
     * @param string $elements
     * @return type
     */
    public function divCheckBox($elements) {
        $cssClss = self::BS_FORM_CHECKBOX_GROUP_CSS_CLASS;
        return "<div class='" . $cssClss . "'>" . $elements . "</div>";
    }

    /**
     * Refebe a referencia de um Zend_Form_Element e Adiciona e organiza as classes de Css informadas
     * @param Zend_Form_Element $element elemento que vai receber a nova classe
     * @param string $newCssclass Informe o nome da nova classe ou um array simples com os nomes desejados
     * @return string Retorna uma string já contendo a nova classe desejada  
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function addCssClass(Zend_Form_Element &$element, $newCssclasses, $fromDecorator = null) {
        $classes = $this->getCssClass($element, $fromDecorator);

        foreach ((array) $newCssclasses as $className) {
            $classes[] = $className;
        }

        $classes = trim(implode(' ', array_unique($classes)));

        if (is_null($fromDecorator))
            $element->setAttrib('class', $classes);
        else
            $element->getDecorator($fromDecorator)->setOption('class', $classes);
    }

    /**
     * Retorna um array com as classes CSS utilizadas em um Zend_Form_Element
     * @param Zend_Form_Element $element elemento a ser consultado
     * @return array Retorna um array com cada classe encontrada
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function getCssClass(Zend_Form_Element $element, $fromDecorator = null) {
        if (is_null($fromDecorator))
            return explode(' ', $element->getAttrib('class'));
        return explode(' ', $element->getDecorator($fromDecorator)->getOption('class'));
    }

    /**
     * remove e organiza as classes de Css elemento 
     * @param string $elementClasses capture as classes do elemento com seu método: $element->getAttrib('class')
     * @param string $ClassestoRemove Informe o nome da classe a remover ou um array simples com os nomes desejados
     * @return string Retorna uma string já contendo a nova classe desejada  
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function removeCssClass(Zend_Form_Element &$element, $removeCssclasses, $fromDecorator = null) {

        $classes = $this->getCssClass($element, $fromDecorator);
        $classes = trim(implode(' ', array_diff($classes, (array) $removeCssclasses)));

        if (is_null($fromDecorator))
            $element->setAttrib('class', $classes);
        else
            $element->getDecorator($fromDecorator)->setOption('class', $classes);
    }

    /* ########################################################################
     * # Declaração dos métodos da interface  Zendstrap_Form_MyBootstrapInterface.#
     * # Esta estratégia foi adotada devido a                                 #
     * # ausência de Traits no PHP 5.3, versão a qual trabalhava à época      #
     * # de criação desta solução. Jhonatan Morais                            #  
     * ######################################################################## */

    /**
     * {@inheritDoc}
     */
    public function getHorizontalFieldDisplay() {
        return $this->_horizontalFieldDisplay;
    }

    public function getHorizontalLabelDisplay() {
        return $this->_horizontalLabelDisplay . ' ' . self::BS_LABEL_CSS_CLASS;
    }

    public function setHorizontalDisplay($sizeClass, $colSizeLabel, $colSizeField) {
        /*
         * Valido os parametros
         */
        if (!(
                in_array($sizeClass, $this->_sizeClassValues) && in_array($colSizeLabel, $this->_horizonralColSizeValues) && in_array($colSizeField, $this->_horizonralColSizeValues)
                )) {
            throw new Exception('Os parametros informados em (' . __METHOD__ . ') não são válidos');
        }

        if (($colSizeLabel + $colSizeField) > 12) {
            throw new Exception('A soma dos valores de $colLabelSize e $colElementSize não pode ser superior a 12');
        }

        /*
         * Trato os valores para compor a classe CSS para fomularios horizontais 
         */
        $sizeClass = "-{$sizeClass}";
        $colSizeLabel = "-{$colSizeLabel}";
        $colSizeField = "-{$colSizeField}";

        $this->_horizontalLabelDisplay = "col" . $sizeClass . $colSizeLabel;
        $this->_horizontalFieldDisplay = "col" . $sizeClass . $colSizeField;
    }

    public function hasHorizontalDisplay() {

        if (is_null($this->_horizontalLabelDisplay) || is_null($this->_horizontalFieldDisplay))
            return false;
        return true;
    }

    public function hasOffsetField() {

        if (is_null($this->_horizontalOffsetField))
            return false;
        return true;
    }

    public function hasOffsetLabel() {

        if (is_null($this->_horizontalOffsetLabel))
            return false;
        return true;
    }

    public function setOffsetLabel($offsetValue) {
        /*
         * Validações necessárias
         */
        if (!$this->hasHorizontalDisplay())
            throw new Exception('Antes de configurar o offset da label você deve definir a configuração horizontal do campo, utilize o método setHorizontalFieldDisplay para isto.');
        if (!is_numeric($offsetValue))
            throw new Exception('O paramêtro $offsetValue de' . __METHOD__ . ' deve ser do tipo integer.');
        /*
         * Tratamento para construção da classe Offset
         */
        $offset = explode('-', $this->_horizontalLabelDisplay);
        $offset[2] = 'offset';
        $offset[3] = $offsetValue;
        $this->_horizontalOffsetLabel = implode('-', $offset);
    }

    public function setOffsetField($offsetValue) {
        /*
         * Validações necessárias
         */
        if (!$this->hasHorizontalDisplay())
            throw new Exception('Antes de configurar o offset do field você deve definir a configuração horizontal do campo, utilize o método setHorizontalFieldDisplay para isto.');
        if (!is_numeric($offsetValue))
            throw new Exception('O paramêtro $offsetValue de' . __METHOD__ . ' deve ser do tipo integer.');
        /*
         * Tratamento para construção da classe Offset
         */
        $offset = explode('-', $this->_horizontalFieldDisplay);
        $offset[2] = 'offset';
        $offset[3] = $offsetValue;
        $this->_horizontalOffsetField = implode('-', $offset);
    }

    /**
     * Verifica se foi configurado um helperBlock para o Elemento
     * @return boolean
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function hasHelperBlock() {

        if (is_null($this->_helperBlock))
            return false;
        return true;
    }

    /**
     * Permite definir uma mensagem para ser utilizada dentro do helperBlock elementeo de ajuda do bootStrap
     * @param string $message Mensagem que vai aparecer no helperblock do elemento
     * @link http://getbootstrap.com/css/#forms
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setHelperBlock($message) {

        $this->_helperBlock = $message;
    }

    /*
     * Recupera a mensagem de helperblock defiida para o elemento
     * @link http://getbootstrap.com/css/#forms
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */

    public function getHelperBlock() {

        return $this->_helperBlock;
    }

    /**
     * Verifica se um elemento deve ter uma apresentaçao horizontal dentro de um form com apresentação padrão
     * @return boolean
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function hasHorizontalGroupFormDisplay() {

        if (is_null($this->_horizontalGroupFormDisplay))
            return false;
        return true;
    }

    public function setHorizontalGroupFormDisplay($sizeClass, $colSizeField) {
        /*
         * Valido os parametros
         */
        if (!(
                in_array($sizeClass, $this->_sizeClassValues) && in_array($colSizeField, $this->_horizonralColSizeValues)
                )) {
            throw new Exception('Os parametros informados em (' . __METHOD__ . ') não são válidos');
        }


        /*
         * Trato os valores para compor a classe CSS para fomularios horizontais 
         */
        $sizeClass = "-{$sizeClass}";
        $colSizeField = "-{$colSizeField}";

        $this->_horizontalGroupFormDisplay = "col" . $sizeClass . $colSizeField;
    }

    public function getHorizontalGroupFormDisplay() {

        return $this->_horizontalGroupFormDisplay;
    }

    public function setBootstrapConfiguration($content = null) {
        
    }

    public function getOffsetField() {
        return $this->_horizontalOffsetField . ' ' . $this->_horizontalFieldDisplay;
    }

    public function getOffsetLabel() {
        return $this->_horizontalOffsetLabel;
    }

}
