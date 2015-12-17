<?php

class Admin_AuthController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        
        return $this->_helper->redirector('login');
    }

    public function loginAction() {


        //$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        // 
        //  $this->view->messages = $this->_flashMessenger->getMessages();
        $form = new Admin_Form_Login();
        $form->setAction ( $this->view->url ( array (
    				'controller' => 'auth',
    				'action' => 'login',
                                'module'=>  'admin'
    		) ) );
        $this->view->form = $form;
        
 
        //Verifica se existem dados de POST
        if ($this->getRequest()->isPost()) {
           
            $data = $this->getRequest()->getPost();
            //Formulário corretamente preenchido?
            
            if ($form->isValid($data)) {
               
                $login = $form->getValue('login');
                $senha = $form->getValue('senha');

                try {
                     
                    Admin_Model_Auth::login($login, $senha);
                    
                    //Redireciona para o Controller protegido
                    return $this->_helper->redirector->goToRoute( array('controller' => 'index'), null, true);
                } catch (Exception $e) {
                    //Dados inválidos
                    $this->_helper->FlashMessenger($e->getMessage());
                    $this->_redirect('admin/auth/login');
                }
                
            } else {
                //Formulário preenchido de forma incorreta
                $form->populate($data);
            }
        }
    }

    public function logoutAction() {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        return $this->_helper->redirector('index');
    }

}
