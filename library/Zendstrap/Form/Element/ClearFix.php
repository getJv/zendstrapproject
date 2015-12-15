<?php
/**
* Classe do Elemento vazio que tem a classe ClearFix do Css, Util para resetar as definições Css dos elementos anteriores de um form
* 
* @author Jhonatan Morais <jhonatanvinicius@gmail.com>
*/
class Zendstrap_Form_Element_ClearFix extends Zend_Form_Element
{
   
    /**
    * Elemento utilizado apenas para limpar as definições css existentas antes de sua inclusão dentro de um form
    * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
    */
     public function __construct()
    {
         
         parent::__construct($spec ='clear');
         
         
    }
   
            
     /**
     * Render form element
     *
     * @param  Zend_View_Interface $view
     * @return string
     */
    public function render(Zend_View_Interface $view = null)
    {
                
        return  '<div class="clearfix"></div>';
     }
    
     
     
}
