<?php

/**
 * Helper para auxilo de uso para renderização do menu conforme opção do bootstrap.
 * Para funcionamento registre o partialPath do menu no aplication.ini com a instrução: 
 * {resources.view.scriptPath[] = APPLICATION_PATH "/../library/Zendstrap/Partials"}
 * @example 
 * Exemplo de uso na view ou no Layout
 * $menu = $this->navigation()->menu();
 * $menu->setMenuName('Menu Principal');
 * $menu->setMenuInverseLayout();
 * $menu->setFixedTopLayout();
 * $menu->setCollapsiveLayout();
 * echo $menu;
 * 
 * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
 * @version 1.0 15/12/2015
 * @link Sites de referência
 * @link http://www.virgentech.com/blog/2011/05/extending-navigation-view-helpers-zend-framework.html
 * @link http://stackoverflow.com/questions/1243697/getting-zend-navigation-menu-to-work-with-jquerys-fisheye/1255289#1255289
 * @link http://stackoverflow.com/questions/1971600/custom-rendering-of-zend-navigation
 * @link https://github.com/michaelmoussa/zf1-navigation-view-helper-bootstrap/blob/master/library/ZFBootstrap/View/Helper/Navigation/Menu.php
 * @link http://stackoverflow.com/questions/20150567/zend-navigation-add-a-html-element-in-the-hyperlink
 * @link http://framework.zend.com/manual/1.12/en/zend.navigation.containers.html
 * @link http://framework.zend.com/manual/1.12/en/zend.navigation.pages.html
 * @link http://framework.zend.com/manual/1.12/en/zend.view.helpers.html#zend.view.helpers.initial.navigation.acl
 * @link http://www.diogomatheus.com.br/blog/zend-framework/zend-view-helpers-e-zend-action-helpers/
 */
class Zendstrap_View_Helper_Menu extends Zend_View_Helper_Navigation_Menu {

    const BS_DEFAULT_LAYOUT = 'navbar navbar-default';
    const BS_INVERSE_LAYOUT = 'navbar navbar-inverse';
    const BS_FIXED_TOP_MENU = 'navbar-fixed-top';
    const BS_FIXED_BOT_MENU = 'navbar-fixed-bottom';
    const BS_COLLAPSE_MENU = 'collapse navbar-collapse';
    const BS_HORIZONTAL_DISPLAY_MENU = 'nav navbar-nav';
    const BS_VERTICAL_DISPLAY_MENU = 'nav nav-stacked';

    protected $_menuName = null;
    protected $_menuCollapsiveLayout = null;
    protected $_menuFixedTopBottom = '';
    protected $_menuLayout = self::BS_DEFAULT_LAYOUT;
    protected $_menuDisposition = self::BS_HORIZONTAL_DISPLAY_MENU;
    protected $_menuVerticalWith = 0;
    /**
     * Define a apresentação do menu como vertical e ainda possibilita configurar sua largura. 
     * @param int $widthMenu largura do conteinar que vai conter o menu, minimo 1 máximo 12.
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setVerticalDisplay($widthMenu = 0){
        $this->_menuDisposition = self::BS_VERTICAL_DISPLAY_MENU;
        $this->_menuVerticalWith = $widthMenu;
    }
    /**
     * Retorna a classe CSS do bootstrap que configura itens de menu para apresentação vertical
     * @return string 
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function getMenuDisposition(){
        return $this->_menuDisposition;
    }
    /**
     * Retorna o valor configurado para a largura do menu
     * @return int
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function getMenuVerticalWidth(){
        return $this->_menuVerticalWith;
    }
    
    
    /**
     * Configura a classe do bootstrap que torna o menu responsivo a pequenas telas
     * @return void
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setCollapsiveLayout() {
        $this->_menuCollapsiveLayout = self::BS_COLLAPSE_MENU;
    }

    /**
     * Returna a classe do bootstrap que torna o menu responsivo a pequenas telas
     * @return string
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function getCollapsiveLayout() {
        return $this->_menuCollapsiveLayout;
    }

    /**
     * Returna true se a classe do bootstrap que torna o menu responsivo a pequenas telas estiver configurada
     * @return boolean
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function hasCollapsiveLayout() {
        if (is_null($this->_menuCollapsiveLayout))
            return false;
        return true;
    }

    /**
     * Configura a classe do bootstrap para fixat o menu no topo da tela
     * @return void
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setFixedTopLayout() {

        $this->_menuFixedTopBottom = self::BS_FIXED_TOP_MENU;
    }

    /**
     * Configura a classe do bootstrap para fixat o menu no rodapé da tela
     * @return void
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setFixedBottomLayout() {

        $this->_menuFixedTopBottom = self::BS_FIXED_BOT_MENU;
    }

    /**
     * Configurar a classe css do bootstrap que torna o menu com thema dark
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setMenuInverseLayout() {

        $this->_menuLayout = self::BS_INVERSE_LAYOUT;
    }

    /**
     * Retorn o layout definido para o menu, tanto as cores como a posição do mesmo.
     * @return string
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function getMenuLayout() {

        return $this->_menuLayout . ' ' . $this->_menuFixedTopBottom;
    }

    /**
     * Permite colocar um nome para o menu
     * @param string $name
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function setMenuName($name) {

        $this->_menuName = $name;
    }

    /**
     * Retorna o nome configurado para o menu
     * @return type
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function getMenuName() {
        return $this->_menuName;
    }

    /**
     * Retorna true se existir nome configurado para o menu
     * @return boolean
     * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
     */
    public function hasMenuName() {
        if (is_null($this->_menuName))
            return false;
        return true;
    }

    public function render(Zend_Navigation_Container $container = null, array $options = array()) {
        #define a partial utilizada para renderizar o menu.
       // $this->menu()->setPartial("nav-horizontal-default.phtml");
        return parent::render($container, $options);
    }

}
