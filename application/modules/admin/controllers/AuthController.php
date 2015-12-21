<?php

class Admin_AuthController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {

        return $this->_helper->redirector('login');
    }

    public function loginAction() {

        try {
            //$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
            // 
            //  $this->view->messages = $this->_flashMessenger->getMessages();
            $form = new Admin_Form_Login();
            $form->setAction($this->view->url(array(
                        'controller' => 'auth',
                        'action' => 'login',
                        'module' => 'admin'
            )));
            $this->view->form = $form;
            #Carrega formulário para primeiro acesso.
            if (!$this->getRequest()->isPost()) {
                return;
            }

            $data = $this->getRequest()->getPost();
            //Formulário corretamente preenchido?
            if (!$form->isValid($data)) {
                throw new Exception("Houve um erro com sua requisição. Tente novamente.");
            }

            $login = $form->getValue('login');
            $senha = $form->getValue('senha');
            Admin_Model_Auth::login($login, $senha);
            return $this->_helper->redirector->goToRoute(array('controller' => 'index','module'=>'default'), null, true);
        } catch (Exception $exc) {
            //$this->_helper->FlashMessenger($e->getMessage());
            /* Criar uma exception propri para dados inváçidos, para aproveitar corretamete o form populate */
            $form->populate($data);
            
        }
    }

    public function logoutAction() {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        //Jdebug(11);
        return $this->_helper->redirector->goToRoute(array('controller' => 'index','module'=>'default'), null, true);
    }

}
