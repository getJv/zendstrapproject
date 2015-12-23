<?php

class Admin_SystemController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {

        $mapper = new Admin_Model_SystemMapper();
        $this->view->entries = $mapper->fetchAll();
    }

    public function addAction() {
        $form = new Admin_Form_System();

        $this->view->form = $form;

        if (!$this->getRequest()->isPost()) {
            return;
        }

        $data = $this->getRequest()->getPost();

        try {
            if (!$form->isValid($data)) {
                throw new Exception("Houve um erro com sua requisição. Tente novamente.");
            }

            $mapper = new Admin_Model_SystemMapper();
            $mapper->save(new Admin_Model_System($data));
            //$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
            return $this->_helper->redirector->goToRoute(array('controller' => 'system', 'module' => 'admin'), null, true);
        } catch (Exception $exc) {
            //$this->_helper->FlashMessenger($e->getMessage());  /* Criar uma exception propri para dados inváçidos, para aproveitar corretamete o form populate */
            $form->populate($data);
        }
    }

    public function editAction() {

        $form = new Admin_Form_System();
        $mapper = new Admin_Model_SystemMapper();
        $this->view->form = $form;

        if (!$this->getRequest()->isPost()) {

            $id = $this->getRequest()->getParam('id');
            $obj = $mapper->find($id);
           
            $form->populate($obj->toArray());
            //return $this->_helper->redirector->goToRoute(array('controller' => 'system', 'module' => 'admin'), null, true);
        } else {
            $data = $this->getRequest()->getPost();
            try {
                if (!$form->isValid($data)) {
                    throw new Exception("Houve um erro com sua requisição. Tente novamente.");
                }

                $mapper = new Admin_Model_SystemMapper();
                $mapper->save(new Admin_Model_System($data));
                //$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
                return $this->_helper->redirector->goToRoute(array('controller' => 'system', 'module' => 'admin'), null, true);
            } catch (Exception $exc) {
                //$this->_helper->FlashMessenger($e->getMessage());  /* Criar uma exception propri para dados inváçidos, para aproveitar corretamete o form populate */
                $form->populate($mapper->find($data['id']));
            }
        }
    }

    public function activeAction() {
        // action body
    }

    public function unactiveAction() {
        // action body
    }

    public function viewAction() {
        // action body
    }

}
