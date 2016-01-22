<?php

/**
 * Classe que presta suporte as operações comuns aos controllers  
 * @version 1.0
 * @author Jhonatan Morais <jhonatanvinicius@gmail.com>
 *
 */
class Zendstrap_Controller_Action extends Zend_Controller_Action {

    protected $_flashMessenger = null;
    /*TODO voltar a fazer a captura do usuario logado foi comentada momentaneamente */
    // protected $_user = null;
    protected $_redirector = null;

    public function init() {
        parent::init();
        #Captura as informações do usuário autenticado.
        //$this->_user = Zend_Auth::getInstance()->getIdentity();
        $this->_redirector = $this->_helper->getHelper('Redirector');
        #Coloca as informações do usuário na view
        //$this->view->usuario = $this->_user;
        #Inicia o helper de mensagens
        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
    }

    /**
     * Alimenta a flashMessager da View com uma mensagem de aviso de cor azul.
     * Esta mensagem é recomendada para avisos de notificação/alerta  pre-erro,que pode ser evitado pelo usuário
     * @link http://getbootstrap.com/components/#alerts
     * @param string $messageText
     */
    protected function addInfoMessage($messageText) {

        $this->_flashMessenger->addMessage(array('info' => $messageText));
    }

    /**
     * Alimenta a flashMessager da View com uma mensagem de aviso de cor verde.
     * Esta mensagem é recomendada para avisos de notificação/alerta  sucesso
     * @link http://getbootstrap.com/components/#alerts
     * @param string $messageText
     */
    protected function addSuccessMessage($messageText) {

        $this->_flashMessenger->addMessage(array('success' => $messageText));
    }

    /**
     * Alimenta a flashMessager da View com uma mensagem de aviso de cor amarelo.
     * Esta mensagem é recomendada para avisos de notificação/alerta  pós-erro, que pode ser corrigido pelo usuário
     * @link http://getbootstrap.com/components/#alerts
     * @param string $messageText
     */
    protected function addWarnMessage($messageText) {

        $this->_flashMessenger->addMessage(array('warn' => $messageText));
    }

    /**
     * Alimenta a flashMessager da View com uma mensagem de aviso de cor rosa.
     * Esta mensagem é recomendada para avisos de notificação/alerta  pós-erro, que não pode ser corrigida pelo usuário.
     * @link http://getbootstrap.com/components/#alerts
     * @param string $messageText
     */
    protected function addErrorMessage($messageText) {
        
        $this->_flashMessenger->addMessage(array('error' => $messageText));
    }

    /**
     * Função para envio de notificações via e-mail
     * @param string $title
     * @param array $destination
     * @param string $bodyMessage
     */
    protected function sendMail($title, $destination, $bodyMessage) {

        try {
            $mail = new Zend_Mail('UTF-8');
            $mail->setSubject($title);
            $mail->addBcc($destination);
            $mail->setBodyHtml($bodyMessage);
            $mail->send();
        } catch (Exception $e) {
            /* TODO Colocar Loogues aqui */
        }
    }

    /**
     * Configura o uso do ZendPaginator e retorna um registro de paginator atual
     * @param type $entryArray Array com os elementos que serão paginados
     * @param int $currentPage Indica a página que será apresentada na apresentação
     * @param int $itensPerPage Configura quantos itens serão apresentados na mesma página
     * @link http://framework.zend.com/manual/1.12/en/learning.paginator.control.html
     * @link http://getbootstrap.com/components/#pagination
     * @link http://zendgeek.blogspot.com.br/2009/07/zend-pagination-example.html
     * @return Zend_Paginator Object
     * @throws Execption
     */
   protected function getPaginator($entryArray, $currentPage = 1, $itensPerPage = 10) {

        # Validações Simples 
        if (!is_array($entryArray)) {
            throw new Exception("EntryArray deve ser um arrayList.");
        }
        # CurrentPage deve ser um inteiro maior que 1.
        if (!is_numeric($currentPage)) {
            $currentPage = 1;
        }
        # ItensPerPage deve ser um inteiro maior que 1.
        if (!is_numeric($itensPerPage)) {
            $itensPerPage = 10;
        }

        try {

            #Defini-se o template de Paginação. Este arquivo deve existir no endereço: application/views/scripts/<nomedoTemplate.phtml>
            Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginatorTemplate.phtml');
            #Ativa a função para os numeros de paginação atualiarem, existem outras mas essa nos atente :D
            Zend_Paginator::setDefaultScrollingStyle('Sliding');
            #Configuro o Paginator
            $paginator = Zend_Paginator::factory($entryArray);
            #Controla a pagina que será exibida
            if ($currentPage > 1) {
                $paginator->setCurrentPageNumber($currentPage);
            }
            #Controla quantos itens por paginas serão exibidos
            if ($itensPerPage != 10)
                $paginator->setItemCountPerPage($itensPerPage);

            return $paginator;
        } catch (Exception $e) {
            #lanço um erro desconhecido. Sorry! :(
            throw new Exception();
        }
    }

}
