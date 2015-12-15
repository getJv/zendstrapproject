<?php

/**
 * Definição padrão de Form
 * @category Forms
 * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
 */
class Zendstrap_Form extends Zend_Form {

    const DISPOSITION_HORIZONTAL = 'form-horizontal';
    const DISPOSITION_INLINE = 'form-inline';
    const DISPOSITION_DEFAULT = '';

    protected $_prefixesInitialized = false;

    /**
     * Inicializa os prefixos de diretórios e define decorator iniciais
     *
     * @param null $options
     */
    public function __construct($options = null) {

        $this->_initializePrefixes();
        parent::__construct($options);
    }

    /**
     * Retorna verdadeiro se o formulario estiver configurado com apresentação horizontal de campos
     * @return boolean
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function isHorizontalForm() {

        if (in_array(self::DISPOSITION_HORIZONTAL, $this->_getClassNames()))
            return TRUE;
        return FALSE;
    }

    /**
     * Carrega o Load default decorators normal e realiza as adaptações para o padrão do bootStrap
     * @link http://getbootstrap.com/css/#forms sugestão de uso do bootstrap
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     * @return Zend_Form_Element
     */
    public function loadDefaultDecorators() {

        parent::loadDefaultDecorators();

        $decorators = $this->getDecorators();

        if (!empty($decorators)) {
            $this->removeDecorator('HtmlTag');
        }
        return $this;
    }

    /**
     * Inicializa os prefixos de diretórios com decorator customizados
     * 
     */
    protected function _initializePrefixes() {
        if (!$this->_prefixesInitialized) {
            if (null !== $this->getView()) {
                $this->getView()->addHelperPath(
                        'Zendstrap/View/Helper', 'Zendstrap_View_Helper'
                );
            }

            $this->addPrefixPath(
                    'Zendstrap_Form_Element', 'Zendstrap/Form/Element', 'element'
            );

            $this->addElementPrefixPath(
                    'Zendstrap_Form_Decorator', 'Zendstrap/Form/Decorator', 'decorator'
            );

            $this->addDisplayGroupPrefixPath(
                    'Zendstrap_Form_Decorator', 'Zendstrap/Form/Decorator'
            );

            $this->setDefaultDisplayGroupClass('Zendstrap_Form_DisplayGroup');

            $this->_prefixesInitialized = true;
        }
    }

    /**
     * Configura a disposição de apresentaçao horizontal para campos do formulário 
     * 
     * @link http://getbootstrap.com/css/#forms Consulte para mais informações .
     * @param const $disposition usa constantes definidas em Zendstrap_Form
     * @throws Exception
     * 
     */
    public function setHorizontalDisposition() {

        if (in_array(self::DISPOSITION_INLINE, $this->_getClassNames())) {
            $this->_removeClassNames(self::DISPOSITION_INLINE);
        }
        $this->_addClassNames(self::DISPOSITION_HORIZONTAL);
    }

    /**
     * Configura a disposição de apresentaçao inline para campos do formulário 
     * 
     * @link http://getbootstrap.com/css/#forms Consulte para mais informações .
     * @param const $disposition usa constantes definidas em Zendstrap_Form
     * @throws Exception
     * 
     */
    public function setInlineDisposition() {

        if (in_array(self::DISPOSITION_HORIZONTAL, $this->_getClassNames()))
            $this->_removeClassNames(self::DISPOSITION_HORIZONTAL);
        $this->_addClassNames(self::DISPOSITION_INLINE);
    }

    /**
     * Configura a disposição de apresentaçao padrão para campos do formulário 
     * 
     * @link http://getbootstrap.com/css/#forms Consulte para mais informações .
     * @param const $disposition usa constantes definidas em Zendstrap_Form
     * @throws Exception
     * 
     */
    public function setDefaultDisposition() {


        $this->_removeClassNames(self::DISPOSITION_HORIZONTAL);
        $this->_removeClassNames(self::DISPOSITION_INLINE);
    }

    /**
     * Adiciona e organiza as classes de Css do formulário 
     *
     * @param string $classNames
     */
    protected function _addClassNames($classNames) {
        $classes = $this->_getClassNames();

        foreach ((array) $classNames as $className) {
            $classes[] = $className;
        }

        $this->setAttrib('class', trim(implode(' ', array_unique($classes))));
    }

    /**
     * Removes a class name
     *
     * @param string $classNames
     */
    protected function _removeClassNames($classNames) {
        $this->setAttrib('class', trim(implode(' ', array_diff($this->_getClassNames(), (array) $classNames))));
    }

    /**
     * Retorna as classes CSS de um Zend_Form_Element quando fornecido 
     * OU do proprio formulario por padrão
     *
     * @param Zend_Form_Element $element
     * @return array
     */
    protected function _getClassNames(Zend_Form_Element $element = null) {
        if (null !== $element) {
            return explode(' ', $element->getAttrib('class'));
        }

        return explode(' ', $this->getAttrib('class'));
    }

    /**
     * Render Customizado
     *
     * @param  Zend_View_Interface $view
     * @return string
     */
    public function render(Zend_View_Interface $view = null) {

        /**
         * Recupera os elementos do FORM
         */
        $elements = $this->getElements();

        foreach ($elements as $eachElement) {
            /*
             * Realizo validações para garantir a coreta renderização do form e seus elementos
             */
            if ((($eachElement instanceof Zendstrap_Form_MyBootstrapInterface))) {
                if ($this->isHorizontalForm() && !$eachElement->hasHorizontalDisplay())
                    throw new Exception("O campo '{$eachElement->getLabel()}' não esta configurado para uso em um formulário horizontal, configure-o utilizando o método setHorizontalFieldDisplay.");
                if (!$this->isHorizontalForm() && $eachElement->hasHorizontalDisplay())
                    throw new Exception("Utilizar o método setHorizontalFieldDisplay no campo '{$eachElement->getLabel()}', sem configurar a apresentação horizontal do formulário resulta em erro de renderização. OU não use este método OU configure apresentação do form a  com o método: setHorizontalDisposition().");
            }

            /**
             * adiciona a classe CSS required para campos que são obrigatorios
             */
            if ($eachElement->isRequired()) {
                $eachElement->setAttrib('required', '');
            }

            /**
             * Removing label from buttons before render.
             */
            if ($eachElement instanceof Zend_Form_Element_Submit) {
                $eachElement->removeDecorator('Label');
            }

            /**
             * retira todos os decotators dos campos hidden
             */
            if ($eachElement instanceof Zend_Form_Element_Hidden) {
                $eachElement->clearDecorators()->addDecorator('ViewHelper');
            }

            /**
             * retira todos os decotators dos campos de hash
             */
            if ($eachElement instanceof Zend_Form_Element_Hash) {
                $eachElement->clearDecorators()->addDecorator('ViewHelper');
            }
        }

        /**
         * Rendetiza o form.
         */
        return parent::render($view);
    }

}
